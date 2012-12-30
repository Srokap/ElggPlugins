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
			$batch = new ElggBatch(array('srokap_plugin', 'getPluginProjects'), $options, null, $chunk_size);
		}
		return $batch;
	}
}