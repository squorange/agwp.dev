<?php

/* FRONT END  */

function essbis_load_scripts_styles() {
	global $essbis_options;

	if (false == essbis_plugin_active_for_current_request())
		return;

	wp_enqueue_style( 'essbis-styles', ESSBIS_Constants::get_plugin_url() . 'assets/css/styles.css', array(), ESSBIS_Constants::get_version() );
	wp_enqueue_script( 'essbis-main', ESSBIS_Constants::get_plugin_url() . 'assets/js/essbis.js', array( 'jquery' ), ESSBIS_Constants::get_version(), false );

	$options_copy = $essbis_options;
	//update module info for current request
	$active_modules = array();
	foreach(ESSBImageShare()->get_module_manager()->get_modules() as $module_name => $module){
		$use_module = $module->is_active();
		if ($use_module && $module instanceof iESSBIS_Activateable_Module){
			$use_module = $module->use_for_current_request();
		}
		if ($use_module)
			$active_modules[] = $module_name;
	}

	$options_copy['main']['activeModules'] = $active_modules;
	//hide settings for modules that don't need to copy them
	foreach(ESSBImageShare()->get_module_manager()->get_modules() as $module_name => $module){
		if ($module->copy_settings_to_js() == false)
			$options_copy[$module_name] = null;
	}

	//print_r($options_copy);
	
	$js_settings = array(
		'modules' => $options_copy,
		'buttonSets' => essbis_button_set_get_for_js(),
		'themes' => essbis_theme_get_for_js()
	);
	wp_localize_script( 'essbis-main', 'ESSBISSettings', $js_settings);

}
add_action( 'wp_enqueue_scripts', 'essbis_load_scripts_styles' );