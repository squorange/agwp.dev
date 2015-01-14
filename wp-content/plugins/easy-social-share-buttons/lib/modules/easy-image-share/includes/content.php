<?php

function essbis_content_filter( $content ) {

	if ( is_feed() || false == essbis_plugin_active_for_current_request() )
		return $content;

	$active_modules = ESSBImageShare()->get_module_manager()->get_active_modules();
	foreach($active_modules as $module_name => $module) {
		$content = $module->content_filter( $content );
	}

	return $content;
}

function essbis_the_content_filter( $content ){
	return essbis_content_filter( $content );
}

function essbis_the_excerpt_filter( $content ){
	return essbis_content_filter( $content );
}

add_filter('the_content', 'essbis_the_content_filter');
add_filter('the_excerpt', 'essbis_the_excerpt_filter');