<?php
global $apply_setting;

if ($apply_setting != '') {
	$current_options = get_option ( EasySocialShareButtons::$plugin_settings_name );
	
	if ($apply_setting == 'button_button') {
		$current_options['hide_social_name'] = '0';
		$current_options['force_hide_social_name'] = 'false';
		$current_options['force_hide_icons'] = 'false';
		
	}
	if ($apply_setting == 'button_icon') {
		$current_options['hide_social_name'] = '1';
		$current_options['force_hide_social_name'] = 'true';
		$current_options['force_hide_icons'] = 'false';
	}
	if ($apply_setting == 'button_icon_name') {
		$current_options['hide_social_name'] = '1';
		$current_options['force_hide_social_name'] = 'false';
		$current_options['force_hide_icons'] = 'false';
	}
	if ($apply_setting == 'button_button_name') {
		$current_options['hide_social_name'] = '0';
		$current_options['force_hide_social_name'] = 'false';
		$current_options['force_hide_icons'] = 'true';
	}
	
	if ($apply_setting == 'counter_deactivate') {
		$current_options['show_counter'] = '0';
		
	}
	if ($apply_setting == 'counter_both') {
		$current_options['show_counter'] = '1';
		$current_options['force_hide_total_count'] = 'false';
		$current_options['counter_pos'] = 'left';
		$current_options['total_counter_pos'] = 'leftbig';		
	}
	if ($apply_setting == 'counter_total') {
		$current_options['show_counter'] = '1';
		$current_options['force_hide_total_count'] = 'false';
		$current_options['counter_pos'] = 'hidden';
		$current_options['total_counter_pos'] = 'leftbig';		
	}
	if ($apply_setting == 'counter_button') {
		$current_options['show_counter'] = '1';
		$current_options['force_hide_total_count'] = 'true';
		$current_options['counter_pos'] = 'left';
		$current_options['total_counter_pos'] = 'leftbig';		
	}
	
	if ($apply_setting == 'performance_minified') {
		$current_options['use_minified_css'] = 'true';
		$current_options['use_minified_js'] = 'true';
		$current_options['load_js_async'] = 'true';
	}
	
	if ($apply_setting == 'performance_cache') {
		$current_options['essb_cache'] = 'true';
		$current_options['essb_cache_mode'] = 'full';
	}

	if ($apply_setting == 'full_performance_cache') {
		$current_options['essb_cache'] = 'true';
		$current_options['essb_cache_mode'] = 'full';
		$current_options['essb_cache_static'] = 'true';
		$current_options['essb_cache_static_js'] = 'true';
	}
	
	if ($apply_setting == 'fix_zerocounter') {
		$current_options['url_short_native'] = 'false';
		$current_options['url_short_google'] = 'false';
		$current_options['url_short_bitly'] = 'false';		
	}

	if ($apply_setting == 'fix_missingcounter') {
		$current_options['force_counters_admin'] = 'true';
	}

	if ($apply_setting == 'fix_nocounter') {
		$current_options['active_internal_counters'] = 'true';
	}

	if ($apply_setting == 'fix_yoast') {
		$current_options['using_yoast_ga'] = 'true';
	}

	if ($apply_setting == 'fix_og') {
		$current_options['opengraph_tags'] = 'true';
	}
	
	update_option ( EasySocialShareButtons::$plugin_settings_name, $current_options );
	ESSBCache::flush();
	
	echo '<div class="updated" style="padding: 10px;">Easy Social Share Buttons: Quick change in settings is applied.</div>';
}

?>