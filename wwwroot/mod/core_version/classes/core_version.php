<?php
class core_version {
	
	/**
	 * Init, system event
	 */
	static function init() {
		elgg_register_action('widgets/get', elgg_get_config('pluginspath').__CLASS__.'/actions/widgets/get.php');

		$widget = 'version';
		elgg_register_widget_type(
			$widget,
			elgg_echo("admin:widget:$widget"),
			elgg_echo("admin:widget:$widget:help"),
			'admin'
		);
		
		elgg_extend_view('js/admin', 'js/ui.widgets.get');
	}
	
	/**
	 * Plugin activation
	 */
	static function activate() {
		//add widget on plugin activation if not added yet
		if (!self::isAdded()) {
			self::init();
			$guid = elgg_create_widget(elgg_get_logged_in_user_guid(), 'version', 'admin');
			if ($guid) {
				$widget = get_entity($guid);
				$widget->move(1, 0);
			}
		}
	}
	
	/**
	 * Checks if version widget was already added
	 * @return boolean
	 */
	static function isAdded() {
		$widgets = elgg_get_widgets(ELGG_ENTITIES_ANY_VALUE, 'admin');
		foreach ($widgets as $column) {
			foreach ($column as $item) {
				if ($item->handler=='version') {
					return true;
				}
			}
		}
		return false;
	}
	
}