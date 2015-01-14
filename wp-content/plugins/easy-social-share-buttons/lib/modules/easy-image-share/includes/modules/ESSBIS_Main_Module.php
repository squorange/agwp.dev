<?php

class ESSBIS_Main_Module extends ESSBIS_Base_Module {

	public function get_module_tag(){
		return 'main';
	}

	public function get_module_name(){
		return __('Main', 'essbis');
	}

	public function get_default_settings() {
		$settings = array(
			'moduleHoverActive' => '1',
			'moduleLightboxActive' => '0',
			'moduleShortcodeActive' => '1'
		);
		return $settings;
	}

	public function get_registered_settings_header() {
		return __("General", 'essbis');
	}

	public function content_filter( $content ){
		return $content;
	}

	private function get_active_modules_options(){
		$result = array();
		$activateable_modules_list = ESSBIS()->get_module_manager()->get_activateable_modules_list();
		foreach($activateable_modules_list as $module_tag => $module_name){
			$result['module' . ucfirst($module_tag) . 'Active'] = $module_name;
		}
		return $result;
	}
}