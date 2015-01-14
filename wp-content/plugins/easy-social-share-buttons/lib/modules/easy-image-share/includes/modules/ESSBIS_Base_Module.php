<?php

interface iESSBIS_Base_Module {
	public function get_module_tag();
	public function get_module_name();
	public function get_boolean_settings_ids();
	public function get_registered_settings_header();
	public function content_filter( $content );
	public function get_type_for_setting( $setting_name );
	public function is_active();
	public function copy_settings_to_js();
}

interface iESSBIS_Activateable_Module {
	public function use_for_current_request();
}

abstract class ESSBIS_Base_Module implements iESSBIS_Base_Module {

	public function get_module_settings(){
		global $essbis_options;
		return $essbis_options[$this->get_module_tag()];
	}

	public function get_boolean_settings_ids() {
		$settings_with_types = $this->get_settings_with_types();
		return array_keys($settings_with_types, 'checkbox');
	}

	public function is_active(){
		return true;
	}

	public function content_filter( $content ) {
		return $content;
	}

	public function get_type_for_setting( $setting_name ){
		$settings_with_types = $this->get_settings_with_types();
		if (isset( $settings_with_types[ $setting_name]))
			return $settings_with_types[ $setting_name];
		return false;
	}

	public function copy_settings_to_js() {
		return true;
	}

	private function get_settings_with_types(){

		$settings = array();

		foreach ( $this->get_registered_settings() as $key => $value ) {

			switch( $value['type']){
				case 'header':
					break;
				case 'multiple_checkboxes':
					foreach(array_keys( $value['options']) as $checkbox_key)
						$settings[$checkbox_key] = 'checkbox';
					break;
				default:
					$settings[ $key ] = $value['type'];
			}
		}

		return $settings;
	}
}

abstract class ESSBIS_Activateable_Module extends ESSBIS_Base_Module implements iESSBIS_Activateable_Module {

	public function use_for_current_request(){
		global $post;

		if (false == parent::is_active())
			return false;

		return true;
	}
}

