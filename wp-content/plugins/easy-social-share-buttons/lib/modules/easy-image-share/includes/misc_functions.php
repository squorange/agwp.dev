<?php

/* Returns available buttons as an array */
function essbis_get_available_buttons() {
	$buttons = array(
		'pinterest' => __('Pinterest', 'essbis'),
		'facebook' => __('Facebook', 'essbis'),
		'twitter' => __('Twitter', 'essbis')
	);

	return $buttons;
}

/* True if plugin should be added to the current post/page */
function essbis_plugin_active_for_current_request() {

	$result = false;

	//loop through active modules
	$activateable_modules = ESSBImageShare()->get_module_manager()->get_activateable_modules();

	foreach($activateable_modules as $module_name => $module){
			$result = $result || $module->use_for_current_request();
	}

	return apply_filters( 'essbis_plugin_active_for_current_request', $result );
}
 

function essbis_button_set_get_for_js() {

	$button_sets_details = array();

	return $button_sets_details;
}

function essbis_theme_get_for_js(){

	$themes_for_js = array();

	return $themes_for_js;
}


function essbis_theme_get_query(){
	$themes = array();
	return $themes;
}

