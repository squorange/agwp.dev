<?php

class ESSBIS_Button_Settings_Module extends ESSBIS_Base_Module {

	public function get_module_tag(){
		return 'buttonSettings';
	}

	public function get_module_name(){
		return __('Button Settings', 'essbis');
	}

	public function get_registered_settings_header() {
		return __("Button settings", 'essbis');
	}
}

 