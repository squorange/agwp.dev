<?php


class ESSBIS_Module_Manager {
	private $modules;

	public function add_module( ESSBIS_Base_Module $module ) {
		$this->modules[ $module->get_module_tag() ] = $module;
	}

	public function get_module( $name ) {
		if (array_key_exists( $name, $this->modules) ){
			return $this->modules[ $name ];
		} else {
			return NULL;
		}
	}

	public function get_modules() {
		return $this->modules;
	}

	public function get_active_modules() {
		$active_modules = array();

		foreach($this->modules as $module_name => $module ){
			if ( $module->is_active() )
				$active_modules[ $module_name ] = $module;
		}

		return $active_modules;
	}

	public function get_activateable_modules() {
		$activateable_modules = array();

		foreach($this->modules as $module_name => $module ){
			if ( $module instanceof iESSBIS_Activateable_Module )
				$activateable_modules[ $module_name ] = $module;
		}

		return $activateable_modules;
	}

	public function get_activateable_modules_list(){
		$list = array();
		$activateable_modules = $this->get_activateable_modules();
		foreach($activateable_modules as $module){
			$list[$module->get_module_tag()] = $module->get_module_name();
		}
		return $list;
	}

	public function get_default_settings() {
		$default_settings = array();

		foreach($this->modules as $name => $module){
			$default_settings[ $name ] = $module->get_default_settings();
		}

		return $default_settings;
	}

	public function get_registered_settings() {
		$registered_settings = array();

		foreach($this->modules as $name => $module) {
			$registered_settings[ $name ] = $module->get_registered_settings();
		}

		return $registered_settings;
	}

	public function get_registered_settings_headers() {
		$settings_headers = array();

		foreach($this->modules as $name => $module) {
			$settings_headers[ $name ] = $module->get_registered_settings_header();
		}

		return $settings_headers;
	}
} 