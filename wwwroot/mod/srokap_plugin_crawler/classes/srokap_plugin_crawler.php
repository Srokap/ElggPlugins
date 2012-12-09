<?php
class srokap_plugin_crawler {
	static function init() {
		elgg_register_event_handler('pagesetup', 'system', array(__CLASS__, 'pagesetup'));
	}
	
	static function pagesetup() {
		elgg_register_admin_menu_item('srokap', 'srokap_plugins_crawler', null, 50);
		elgg_register_admin_menu_item('srokap', 'commands', 'srokap_plugins_crawler', 10);
	}
	
	/**
	 * @var array
	 */
	private static $subtypes = array();
	
	/**
	 * @param int $subtype_id
	 * @param string $subtype
	 */
	static function registerSubtype($subtype_id, $subtype) {
		self::$subtypes[$subtype_id] = $subtype;
	}
	
	/**
	 * @param int $subtype_id
	 * @return stirng|false
	 */
	static function getSubtypeName($subtype_id) {
		if (isset(self::$subtypes[$subtype_id])) {
			return self::$subtypes[$subtype_id];
		}
		return false;
	}
	
	static function getRemoteName() {
		return 'origin';
	}
	
	/**
	 * @param array $options
	 * @return array|false
	 */
	static function get_plugin_projects($options = array()) {
// 		var_dump('CALL', $options);
		
		$mt = microtime(true);
		$url = 'http://community.elgg.org/plugins/search';
		$url = elgg_http_add_url_query_elements($url, array(
			'sort' => 'created',
			'view' => 'json',
			'limit' => elgg_extract('limit', $options, 10),
			'offset' => elgg_extract('offset', $options, 0),
		));
		
		list($content, $meta) = srokap_framework::http_get($url);
		$data = json_decode($content);
		var_dump(microtime(true) - $mt);
		
// 		var_dump($url, $data);
		
		if (isset($data->object) && isset($data->object->plugin_project)) {
			$result = $data->object->plugin_project;
			if (isset($result[0])) {
				self::registerSubtype($result[0]->subtype, 'plugin_project');
			}
			foreach ($result as $key => $val) {
				$result[$key] = self::plugin_projects_postprocess($val);
			}
			return $result;
		}
		return false;
	}
	
	/**
	 * @param stdClass $result
	 * @param array $externalAttributes
	 * @return stdClass
	 */
	private static function postprocess_attributes_rewrite($result, $externalAttributes) {
		$result->subtype = self::getSubtypeName($result->subtype);
		foreach ($result as $key => $val) {
			if (in_array($key, $externalAttributes)) {
				unset($result->$key);
				$result->{self::getRemoteName().'/'.$key} = $val;
			}
		}
		return $result;
	}
	
	static function plugin_projects_postprocess($result) {
		var_dump('clbck', $result->guid);
// 		var_dump($result, $getter, $options);die();
		$externalAttributes = array(
			'guid',
			'owner_guid',
			'container_guid',
			'time_updated',
			'site_guid',
		);
		$result = self::postprocess_attributes_rewrite($result, $externalAttributes);
		
// 		var_dump($result);
		return $result;
	}
	
	/**
	 * @return ElggBatch
	 */
	static function getPluginProjectsBatch($options = array()) {
		static $batch;
		if (!$batch) {
			$chunk_size = 50;
			$defaults = array(
				'limit' => 0,
			);
			$options = array_merge((array)$defaults, (array)$options);
			$batch = new ElggBatch(array(__CLASS__, 'get_plugin_projects'), $options, null, $chunk_size);
		}
		return $batch;
	}
}