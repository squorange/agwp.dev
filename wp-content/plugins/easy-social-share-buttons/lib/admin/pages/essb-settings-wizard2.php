<?php

// update settings command
// parsing update action
$cmd = isset($_REQUEST['cmd']) ? $_REQUEST['cmd'] : '';

if ($cmd == "update") {
	$options = $_POST ['general_options'];
	//$nn = $_POST ["general_options_nn"];

	$current_options = get_option ( EasySocialShareButtons::$plugin_settings_name );

	foreach ( $current_options ['networks'] as $nw => $v ) {
		// print_r($current_options ['networks'] [$nw] );
		$current_options ['networks'] [$nw] [0] = 0;
	}

	$new_networks = array ();

	foreach ( $options ['sort'] as $nw ) {
		$new_networks [$nw] = $current_options ['networks'] [$nw];
	}

	$current_options ['networks'] = $new_networks;
	foreach ( $options ['networks'] as $nw ) {
		$current_options ['networks'] [$nw] [0] = 1;
	}

	//foreach ( $nn as $k => $v ) {
	//	$current_options ['networks'] [$k] [1] = $v;
	//}

	if (! isset ( $options ['display_in_types'] )) {
		$options ['display_in_types'] = array ();
	}
	$current_options ['display_in_types'] = $options ['display_in_types'];

	$current_options['style'] = get_options_field_value($options, 'style', '0');

	$current_optoins['css_animations'] = get_options_field_value($options, 'css_animations', '');
	
	$button_type = get_options_field_value($options, 'button_type', 'button');
	if ($button_type == 'button') {
		$current_options['hide_social_name'] = '0';
		$current_options['force_hide_social_name'] = 'false';
		$current_options['force_hide_icons'] = 'false';
	}
	
	if ($button_type == 'button_name') {
		$current_options['hide_social_name'] = '0';
		$current_options['force_hide_social_name'] = 'false';
		$current_options['force_hide_icons'] = 'true';
	}
	
	if ($button_type == 'icon') {
		$current_options['hide_social_name'] = '1';
		$current_options['force_hide_social_name'] = 'true';
		$current_options['force_hide_icons'] = 'false';
	}
	
	if ($button_type == 'icon_name') {
		$current_options['hide_social_name'] = '1';
		$current_options['force_hide_social_name'] = 'false';
		$current_options['force_hide_icons'] = 'false';
	}

	$current_options['show_counter'] = get_options_field_value($options, 'show_counter', 0);
	
	$show_counter_type = get_options_field_value($options, 'show_counter_type', 'both');
	$current_options['counter_pos'] = get_options_field_value($options, 'counter_pos', '');
	$current_options['total_counter_pos'] = get_options_field_value($options, 'total_counter_pos', '');
	
	if ($show_counter_type == 'both') {
		$current_options['force_hide_total_count'] = 'false';		
	}
	if ($show_counter_type == 'total') {
		$current_options['counter_pos'] = 'hidden';
	}
	if ($show_counter_type == 'button') {
		$current_options['force_hide_total_count'] = 'true';
	}
	$current_options['facebooktotal'] = get_options_field_value($options, 'facebooktotal', 'true');
	$current_options['force_counters_admin'] = get_options_field_value($options, 'force_counters_admin', 'true');
	
	$current_options['buttons_pos'] = get_options_field_value($options, 'buttons_pos', '');
	$current_options['twitter_shareshort'] = get_options_field_value($options, 'twitter_shareshort', 'false');
	$current_options['twitteruser'] = get_options_field_value($options, 'twitteruser', '');
	$current_options['twitterhashtags'] = get_options_field_value($options, 'twitterhashtags', '');
	$current_options['url_short_bitly_user'] = get_options_field_value($options, 'url_short_bitly_user', '');
	$current_options['url_short_bitly_api'] = get_options_field_value($options, 'url_short_bitly_api', '');
	$current_options['more_button_func'] = get_options_field_value($options, 'more_button_func', '');
	$current_options['twitter_shareshort_service'] = get_options_field_value($options, 'twitter_shareshort_service', '');
	
	$current_options['display_where'] = get_options_field_value($options, 'display_where', 'bottom');
	$current_options['display_excerpt_pos'] = get_options_field_value($options, 'display_excerpt_pos', '');
	$current_options['display_excerpt'] = get_options_field_value($options, 'display_excerpt', 'false');
		
	$current_options['display_position_mobile'] = get_options_field_value($options, 'display_position_mobile', '');
	$current_options['force_hide_buttons_on_mobile'] = get_options_field_value($options, 'force_hide_buttons_on_mobile', 'false');
	$current_options['display_position_mobile_sidebar'] = get_options_field_value($options, 'display_position_mobile_sidebar', '');
	$current_options['force_hide_buttons_on_all_mobile'] = get_options_field_value($options, 'force_hide_buttons_on_all_mobile', 'false');
	$current_options['always_hide_names_mobile'] = get_options_field_value($options, 'always_hide_names_mobile', 'false');
	$current_options['using_yoast_ga'] = get_options_field_value($options, 'using_yoast_ga', 'true');

	$use_minified_files = get_options_field_value($options, 'use_minified_files', 'false');
	if ($use_minified_files == 'true') {
		$current_options['use_minified_css'] = 'true';
		$current_options['use_minified_js'] = 'true';
	}
	else {
		$current_options['use_minified_css'] = 'false';
		$current_options['use_minified_js'] = 'false';		
	}
	
	$current_options['load_js_async'] = get_options_field_value($options, 'load_js_async', 'false');
	$current_options['load_js_defer'] = get_options_field_value($options, 'load_js_defer', 'false');
	$current_options['remove_ver_resource'] = get_options_field_value($options, 'remove_ver_resource', 'false');
	$current_options['essb_cache'] = get_options_field_value($options, 'essb_cache', 'false');
	$current_options['essb_cache_mode'] = get_options_field_value($options, 'essb_cache_mode', '');
	$current_options['essb_cache_static'] = get_options_field_value($options, 'essb_cache_static', 'false');

	$current_options['another_display_sidebar'] = get_options_field_value($options, 'another_display_sidebar', 'false');
	$current_options['another_display_popup'] = get_options_field_value($options, 'another_display_popup', 'false');
	$current_options['another_display_flyin'] = get_options_field_value($options, 'another_display_flyin', 'false');
	$current_options['another_display_postfloat'] = get_options_field_value($options, 'another_display_postfloat', 'false');
	
	$current_options['active_internal_counters'] = get_options_field_value($options, 'active_internal_counters', 'false');
	$current_options['admin_ajax_cache_internal'] = get_options_field_value($options, 'admin_ajax_cache_internal', 'false');
	$current_options['opengraph_tags'] = get_options_field_value($options, 'opengraph_tags', 'false');
	
	if ($current_options['admin_ajax_cache_internal'] == 'true') {
		$current_options['admin_ajax_cache'] = '600';
		$current_options['admin_ajax_cache_internal_time'] = '600';
	}
	else {
		$current_options['admin_ajax_cache'] = '';
		$current_options['admin_ajax_cache_internal_time'] = '';
	}
	
	update_option ( EasySocialShareButtons::$plugin_settings_name, $current_options );
	ESSBCache::flush();
	if (function_exists ( 'purge_essb_cache_static_cache' )) {
		purge_essb_cache_static_cache ();
	}
	echo "<script type='text/javascript'>window.location='".admin_url()."admin.php?page=essb_settings&tab=general#wizard';</script>";
}


// wizard display functions
function get_options_field_value($options, $key, $default) {
	$value = '';
	if (! isset ( $options [$key] )) {
		$value = $default;
	} else {
		$value = $options [$key];
	}
	
	return $value;
}

// content generation functions
function essb_template_select_radio() {
	
	$options = get_option ( EasySocialShareButtons::$plugin_settings_name );
	if (is_array ( $options )) {
		$n1 = $n2 = $n3 = $n4 = $n5 = $n6 = $n7 = $n8 = $n9 = $n10 = $n11 = $n12 = $n13 = $n14 = $n15 = $n16 = $n17 = $n18 = $n19 = "";
		${
			'n' . $options ['style']} = " checked='checked'";
		
		echo '
			<tr class="even"><td>
			<input id="essb_style_1" value="1" name="general_options[style]" type="radio" ' . $n1 . ' />&nbsp;&nbsp;' . __ ( 'Default', ESSB_TEXT_DOMAIN ) . '<br /><img src="' . ESSB_PLUGIN_URL . '/assets/images/demo-style-default.png"/>
			</td><td>
			<input id="essb_style_2" value="2" name="general_options[style]" type="radio" ' . $n2 . ' />&nbsp;&nbsp;' . __ ( 'Metro', ESSB_TEXT_DOMAIN ) . '<br /><img src="' . ESSB_PLUGIN_URL . '/assets/images/demo-style-metro.png"/>
			</td></tr><tr class="odd"><td>
			<input id="essb_style_3" value="3" name="general_options[style]" type="radio" ' . $n3 . ' />&nbsp;&nbsp;' . __ ( 'Modern', ESSB_TEXT_DOMAIN ) . '<br /><img src="' . ESSB_PLUGIN_URL . '/assets/images/demo-style-modern.png"/>
			</td><td>
			<input id="essb_style_4" value="4" name="general_options[style]" type="radio" ' . $n4 . ' />&nbsp;&nbsp;' . __ ( 'Round', ESSB_TEXT_DOMAIN ) . '<br /><img src="' . ESSB_PLUGIN_URL . '/assets/images/demo-style-round.png"/>
			</td></tr><tr class="even"><td>
			<input id="essb_style_5" value="5" name="general_options[style]" type="radio" ' . $n5 . ' />&nbsp;&nbsp;' . __ ( 'Big', ESSB_TEXT_DOMAIN ) . '<br /><img src="' . ESSB_PLUGIN_URL . '/assets/images/demo-style-big.png"/>
			</td><td>
			<input id="essb_style_6" value="6" name="general_options[style]" type="radio" ' . $n6 . ' />&nbsp;&nbsp;' . __ ( 'Metro (Retina)', ESSB_TEXT_DOMAIN ) . '<br /><img src="' . ESSB_PLUGIN_URL . '/assets/images/demo-style-metro2.png"/>
			</td></tr><tr class="odd"><td>
			<input id="essb_style_7" value="7" name="general_options[style]" type="radio" ' . $n7 . ' />&nbsp;&nbsp;' . __ ( 'Big (Retina)', ESSB_TEXT_DOMAIN ) . '<br /><img src="' . ESSB_PLUGIN_URL . '/assets/images/demo-style-big-retina.png"/>
			</td><td>
			<input id="essb_style_8" value="8" name="general_options[style]" type="radio" ' . $n8 . ' />&nbsp;&nbsp;' . __ ( 'Light (Retina)', ESSB_TEXT_DOMAIN ) . '<br /><img src="' . ESSB_PLUGIN_URL . '/assets/images/demo-style-light-retina.png"/>
			</td></tr><tr class="even"><td>
			<input id="essb_style_9" value="9" name="general_options[style]" type="radio" ' . $n9 . ' />&nbsp;&nbsp;' . __ ( 'Flat (Retina)', ESSB_TEXT_DOMAIN ) . '<br /><img src="' . ESSB_PLUGIN_URL . '/assets/images/demo-style-flat.png"/>
			</td><td>
			<input id="essb_style_10" value="10" name="general_options[style]" type="radio" ' . $n10 . ' />&nbsp;&nbsp;' . __ ( 'Tiny (Retina)', ESSB_TEXT_DOMAIN ) . '<br /><img src="' . ESSB_PLUGIN_URL . '/assets/images/demo-style-tiny.png"/>
			</td></tr><tr class="odd"><td>
			<input id="essb_style_11" value="11" name="general_options[style]" type="radio" ' . $n11 . ' />&nbsp;&nbsp;' . __ ( 'Round (Retina)', ESSB_TEXT_DOMAIN ) . '<br /><img src="' . ESSB_PLUGIN_URL . '/assets/images/demo-style-round-retina.png"/>
			</td><td>
			<input id="essb_style_12" value="12" name="general_options[style]" type="radio" ' . $n12 . ' />&nbsp;&nbsp;' . __ ( 'Modern (Retina)', ESSB_TEXT_DOMAIN ) . '<br /><img src="' . ESSB_PLUGIN_URL . '/assets/images/demo-style-modern-retina.png"/>
			</td></tr><tr class="even"><td>
			<input id="essb_style_13" value="13" name="general_options[style]" type="radio" ' . $n13 . ' />&nbsp;&nbsp;' . __ ( 'Circles (Retina)', ESSB_TEXT_DOMAIN ) . '<br /><img src="' . ESSB_PLUGIN_URL . '/assets/images/demo-style-circles-retina.png"/>
			</td><td>
			<input id="essb_style_14" value="14" name="general_options[style]" type="radio" ' . $n14 . ' />&nbsp;&nbsp;' . __ ( 'Blocks (Retina)', ESSB_TEXT_DOMAIN ) . '<br /><img src="' . ESSB_PLUGIN_URL . '/assets/images/demo-style-blocks-retina.png"/>
			</td></tr><tr class="odd"><td>
			<input id="essb_style_15" value="15" name="general_options[style]" type="radio" ' . $n15 . ' />&nbsp;&nbsp;' . __ ( 'Dark (Retina)', ESSB_TEXT_DOMAIN ) . '<br /><img src="' . ESSB_PLUGIN_URL . '/assets/images/demo-style-dark-retina.png"/>
			</td><td>
			<input id="essb_style_16" value="16" name="general_options[style]" type="radio" ' . $n16 . ' />&nbsp;&nbsp;' . __ ( 'Grey Circles (Retina)', ESSB_TEXT_DOMAIN ) . '<br /><img src="' . ESSB_PLUGIN_URL . '/assets/images/demo-style-grey-circles-retina.png"/>
			</td></tr><tr class="even"><td>
			<input id="essb_style_17" value="17" name="general_options[style]" type="radio" ' . $n17 . ' />&nbsp;&nbsp;' . __ ( 'Grey Blocks (Retina)', ESSB_TEXT_DOMAIN ) . '<br /><img src="' . ESSB_PLUGIN_URL . '/assets/images/demo-style-grey-blocks-retina.png"/>
			</td><td><input id="essb_style_18" value="18" name="general_options[style]" type="radio" ' . $n18 . ' />&nbsp;&nbsp;' . __ ( 'Clear (Retina)', ESSB_TEXT_DOMAIN ) . '<br /><img src="' . ESSB_PLUGIN_URL . '/assets/images/demo-style-clear-retina.png"/></td></tr>
			<tr class="odd"><td>
			<input id="essb_style_19" value="19" name="general_options[style]" type="radio" ' . $n19 . ' />&nbsp;&nbsp;' . __ ( 'Copy (Retina)', ESSB_TEXT_DOMAIN ) . '<br /><img src="' . ESSB_PLUGIN_URL . '/assets/images/demo-style-copy-retina.png"/>
			</td><td></td></tr>';
	}
}

function essb_setting_checkbox_network_selection() {
	$y = $n = '';
	$options = get_option ( EasySocialShareButtons::$plugin_settings_name );
	
	if (is_array ( $options )) {
		
		if (! is_array ( $options ['networks'] )) {
			$default_networks = EasySocialShareButtons::default_options ();
			$options ['networks'] = $default_networks ['networks'];
		}
		
		foreach ( $options ['networks'] as $k => $v ) {
			
			$more_options = "";
			
			if ($k == "twitter" || $k == "facebook" || $k == "pinterest" || $k == "flatter" || $k == "stumbleuppon" || $k == "print") {
				// $more_options = '<span class="label"
				// style="margin-top:-15px;"><a href="#'.$k.'"> Additional
				// Options</a></span>';
			}
			
			if ($k == "more") {
				$more_options = " onclick=\"essb_option_show_hide('#essb-more-button-options', '#network_selection_more');\"";
			}
			if ($k == "twitter") {
				$more_options = " onclick=\"essb_option_show_hide('#essb-twitter1,#essb-twitter2,#essb-twitter3,#essb-twitter4,#essb-twitter5,#essb-twitter6,#essb-twitter7', '#network_selection_twitter');\"";
			}
			
			$is_checked = ($v [0] == 1) ? ' checked="checked"' : '';
			$network_name = isset ( $v [1] ) ? $v [1] : $k;
			
			echo '<li><p style="margin: .2em 5% .2em 0;">
			<input id="network_selection_' . $k . '" value="' . $k . '" name="general_options[networks][]" type="checkbox"
			' . $is_checked . ' ' . $more_options . ' /><input name="general_options[sort][]" value="' . $k . '" type="checkbox" checked="checked" style="display: none; " />
			<label for="network_selection_' . $k . '"><span class="essb_icon essb_icon_' . $k . '"></span>' . $network_name . '</label> ' . '' . '
			</p></li>';
		}
	
	}
}

function essb_custom_buttons_pos() {
	$options = get_option ( EasySocialShareButtons::$plugin_settings_name );
	if (is_array ( $options )) {
		$exist = isset ( $options ['buttons_pos'] ) ? $options ['buttons_pos'] : '';
		$exist = stripslashes ( $exist );
		
		echo '<p style="margin: .2em 5% .2em 0;"><select id="buttons_pos" type="text" name="general_options[buttons_pos]" class="input-element">
		<option value="" ' . ($exist == '' ? ' selected="selected"' : '') . '>Left</option>
		<option value="right" ' . ($exist == 'right' ? ' selected="selected"' : '') . '>Right</option>
		<option value="center" ' . ($exist == 'center' ? ' selected="selected"' : '') . '>Center</option>
		</select>
		</p>';
	
	}
}

function essb_twitter_share_short() {
	$options = get_option ( EasySocialShareButtons::$plugin_settings_name );
	if (is_array ( $options )) {
		$exist = isset ( $options ['twitter_shareshort'] ) ? $options ['twitter_shareshort'] : 'false';
		
		$is_checked = ($exist == 'true') ? ' checked="checked"' : '';
		echo '<p style="margin: .2em 5% .2em 0;"><input id="twitter_shareshort" type="checkbox" name="general_options[twitter_shareshort]" value="true" ' . $is_checked . ' onclick="essb_option_show_hide(\'#essb-twitter3,#essb-twitter6,#essb-twitter7\', \'#twitter_shareshort\');" /></p>';
	
	}

}

function essb_twitter_username_append() {
	$options = get_option ( EasySocialShareButtons::$plugin_settings_name );
	if (is_array ( $options )) {
		$exist = isset ( $options ['twitteruser'] ) ? $options ['twitteruser'] : '';
		
		echo '<p style="margin: .2em 5% .2em 0;"><input id="twitteruser" type="text" name="general_options[twitteruser]" value="' . $exist . '" class="input-element" /></p>';
	
	}

}

function essb_twitter_hashtags_append() {
	$options = get_option ( EasySocialShareButtons::$plugin_settings_name );
	if (is_array ( $options )) {
		$exist = isset ( $options ['twitterhashtags'] ) ? $options ['twitterhashtags'] : '';
		
		echo '<p style="margin: .2em 5% .2em 0;"><input id="twitterhashtags" type="text" name="general_options[twitterhashtags]" value="' . $exist . '" class="input-element" /></p>';
	
	}
}

function essb_url_short_bitly_user() {
	$options = get_option ( EasySocialShareButtons::$plugin_settings_name );
	if (is_array ( $options )) {
		$exist = isset ( $options ['url_short_bitly_user'] ) ? $options ['url_short_bitly_user'] : '';
		
		echo '<p style="margin: .2em 5% .2em 0;"><input id="url_short_bitly_user" type="text" name="general_options[url_short_bitly_user]" value="' . $exist . '" class="input-element" style="width: 350px;" /></p>';
	
	}
}

function essb_url_short_bitly_api() {
	$options = get_option ( EasySocialShareButtons::$plugin_settings_name );
	if (is_array ( $options )) {
		$exist = isset ( $options ['url_short_bitly_api'] ) ? $options ['url_short_bitly_api'] : '';
		
		echo '<p style="margin: .2em 5% .2em 0;"><input id="url_short_bitly_api" type="text" name="general_options[url_short_bitly_api]" value="' . $exist . '" class="input-element" style="width: 350px;" /></p>';
	
	}
}

function essb_select_content_type() {
	$pts = get_post_types ( array ('public' => true, 'show_ui' => true, '_builtin' => true ) );
	$cpts = get_post_types ( array ('public' => true, 'show_ui' => true, '_builtin' => false ) );
	$options = get_option ( EasySocialShareButtons::$plugin_settings_name );
	
	$woocommerce_selected = isset ( $options ['woocommece_share'] ) ? $options ['woocommece_share'] : 'false';
	$is_woocommerce_selected = ($woocommerce_selected == 'true') ? ' checked="checked"' : '';
	
	$excerpt_selected = isset ( $options ['display_excerpt'] ) ? $options ['display_excerpt'] : 'false';
	$is_excerpt_selected = ($excerpt_selected == 'true') ? ' checked="checked"' : '';
	
	$all_lists_selected = '';
	if (is_array ( $options ['display_in_types'] )) {
		$all_lists_selected = in_array ( 'all_lists', $options ['display_in_types'] ) ? 'checked="checked"' : '';
	}
	
	if (is_array ( $options ) && isset ( $options ['display_in_types'] ) && is_array ( $options ['display_in_types'] )) {
		
		global $wp_post_types;
		// classical post type listing
		foreach ( $pts as $pt ) {
			
			$selected = in_array ( $pt, $options ['display_in_types'] ) ? 'checked="checked"' : '';
			
			$icon = "";
			echo '<input type="checkbox" name="general_options[display_in_types][]" id="' . $pt . '" value="' . $pt . '" ' . $selected . '> <label for="' . $pt . '">' . $icon . ' ' . $wp_post_types [$pt]->label . '</label><br />';
		}
		
		// custom post types listing
		if (is_array ( $cpts ) && ! empty ( $cpts )) {
			foreach ( $cpts as $cpt ) {
				
				$selected = in_array ( $cpt, $options ['display_in_types'] ) ? 'checked="checked"' : '';
				
				$icon = "";
				echo '<input type="checkbox" name="general_options[display_in_types][]" id="' . $cpt . '" value="' . $cpt . '" ' . $selected . '> <label for="' . $cpt . '">' . $icon . ' ' . $wp_post_types [$cpt]->label . '</label><br />';
			}
		}
	}
	echo '<input type="checkbox" name="general_options[display_in_types][]" id="all_lists" value="all_lists" ' . $all_lists_selected . '> <label for="all_lists">' . "" . ' ' . sprintf ( __ ( 'Lists of articles <br />%s<span class="label">(blog, archives, search results, etc.)</span>%s', ESSB_TEXT_DOMAIN ), '<em>', '</em>' ) . '</label><br/><br/>';
	echo '<input type="checkbox" name="general_options[woocommece_share]" id="woocommece_share" value="true" ' . $is_woocommerce_selected . '> <label for="woocommece_share">' . "" . ' ' . sprintf ( __ ( 'WooCommence Products <br />%s<span class="label">(Activate share buttons for WooCommerce Products)</span>%s', ESSB_TEXT_DOMAIN ), '<em>', '</em>' ) . '</label><br/><br/>';
}

function essb_setting_radio_where() {
	
	$options = get_option ( EasySocialShareButtons::$plugin_settings_name );
	
	// print_r($options);
	
	$w_bottom = $w_top = $w_both = $w_nowhere = $w_float = $w_sidebar = $w_popup = $w_likeshare = $w_sharelike = $w_postfloat = $w_inline = $w_flyin = "";
	if (is_array ( $options ) && isset ( $options ['display_where'] ))
		${
		'w_' . $options ['display_where']} = " checked='checked'";
	
	echo '<table border="0" cellpadding="2" cellspacing="0" style="background-color: #f3f3f3;">';
	echo '<col width="33%"/>';
	echo '<col width="33%"/>';
	echo '<col width="33%"/>';
	echo '<tr>';
	echo '<td align="center" valign="top" style="background-color: #fafafa !important;"><img src="' . ESSB_PLUGIN_URL . '/assets/images/button-position-02.png" style="margin-bottom: 5px;" /><br/><input id="" value="bottom" name="general_options[display_where]" type="radio" ' . $w_bottom . ' />
	<br/><label for=""><strong>' . __ ( 'Content bottom', ESSB_TEXT_DOMAIN ) . '</strong><br/><label class="small">This will display buttons after content</label></label></td>';
	echo '<td align="center" valign="top" style="background-color: #ffffff !important;"><img src="' . ESSB_PLUGIN_URL . '/assets/images/button-position-01.png"  style="margin-bottom: 5px;" /><br/><input id="" value="top" name="general_options[display_where]" type="radio" ' . $w_top . ' />
	<br/><label for=""><strong>' . __ ( 'Content top', ESSB_TEXT_DOMAIN ) . '</strong><br/><label class="small">This will display buttons before content</label></label></td>';
	echo '<td align="center"  valign="top" style="background-color: #fafafa !important;"><img src="' . ESSB_PLUGIN_URL . '/assets/images/button-position-03.png"  style="margin-bottom: 5px;" /><br/><input id="" value="both" name="general_options[display_where]" type="radio" ' . $w_both . ' />
	<br/><label for=""><strong>' . __ ( 'Both (content bottom and content top)', ESSB_TEXT_DOMAIN ) . '</strong><br/><label class="small">This will display buttons before and after content</label></label></td>';
	echo '</tr>';
	
	echo '<tr>';
	echo '<td align="center" valign="top" style="background-color: #fafafa !important;border-top: 1px solid #dadada;"><img src="' . ESSB_PLUGIN_URL . '/assets/images/button-position-04.png" style="margin-bottom: 5px;" /><br/><input id="" value="float" name="general_options[display_where]" type="radio" ' . $w_float . ' />
	<br/><label for=""><strong>' . __ ( "Float from content top", ESSB_TEXT_DOMAIN ) . '</strong><br/><label class="small">This will display buttons before content and stick on top while scroll down</label></label></td>';
	echo '<td align="center" valign="top" style="background-color: #ffffff !important; border-top: 1px solid #dadada;"><img src="' . ESSB_PLUGIN_URL . '/assets/images/button-position-06.png"  style="margin-bottom: 5px;" /><br/><input id="" value="sidebar" name="general_options[display_where]" type="radio" ' . $w_sidebar . ' />
	<br/><label for=""><strong>' . __ ( "Sidebar", ESSB_TEXT_DOMAIN ) . '</strong><br/><label class="small">This will display buttons as left, right, top or bottom window sidebar</label></label><br/></td>';
	echo '<td align="center"  valign="top"  style="background-color: #fafafa !important;border-top: 1px solid #dadada;"><img src="' . ESSB_PLUGIN_URL . '/assets/images/button-position-09.png"  style="margin-bottom: 5px;" /><br/><input id="" value="nowhere" name="general_options[display_where]" type="radio" ' . $w_nowhere . ' />
	<br/><label for=""><strong>' . __ ( "Via shortcode only", ESSB_TEXT_DOMAIN ) . '</label><br /><label class="small">This will display buttons only when shortcode call is included: <strong>[easy-share]</strong>, <strong>[easy-social-share]</strong>, <strong>[easy-social-like]</strong></label></td>';
	echo '</tr>';
	
	echo '<tr>';
	echo '<td align="center" valign="top" style="background-color: #fafafa !important;border-top: 1px solid #dadada;"><img src="' . ESSB_PLUGIN_URL . '/assets/images/button-position-07.png" style="margin-bottom: 5px;" /><br/><input id="" value="popup" name="general_options[display_where]" type="radio" ' . $w_popup . ' />
	<br/><label for=""><strong>' . __ ( "Pop up", ESSB_TEXT_DOMAIN ) . '</strong><br/><label class="small">This will display buttons as pop up over content</label></label></td>';
	echo '<td align="center" valign="top" style="background-color: #ffffff !important; border-top: 1px solid #dadada;"><img src="' . ESSB_PLUGIN_URL . '/assets/images/button-position-10.png"  style="margin-bottom: 5px;" /><br/><input id="" value="likeshare" name="general_options[display_where]" type="radio" ' . $w_likeshare . ' />
	<br/><label for=""><strong>' . __ ( 'Native top/Share bottom', ESSB_TEXT_DOMAIN ) . '</strong><br/><label class="small">This will display native buttons before content and share buttons after content</label></label></td>';
	echo '<td align="center"  valign="top"  style="background-color: #fafafa !important;border-top: 1px solid #dadada;"><img src="' . ESSB_PLUGIN_URL . '/assets/images/button-position-11.png"  style="margin-bottom: 5px;" /><br/><input id="" value="sharelike" name="general_options[display_where]" type="radio" ' . $w_sharelike . ' />
	<br/><label for=""><strong>' . __ ( 'Share top/Native bottom', ESSB_TEXT_DOMAIN ) . '</strong><br/><label class="small">This will display share buttons before content and native buttons after content</label></label></td>';
	echo '</tr>';
	
	echo '<tr>';
	echo '<td align="center" valign="top" style="background-color: #fafafa !important;border-top: 1px solid #dadada;"><img src="' . ESSB_PLUGIN_URL . '/assets/images/button-position-05.png" style="margin-bottom: 5px;" /><br/><input id="" value="postfloat" name="general_options[display_where]" type="radio" ' . $w_postfloat . ' />
	<br/><label for=""><strong>' . __ ( "Post Vertical Float Sidebar", ESSB_TEXT_DOMAIN ) . '</strong><br/><label class="small">This will display buttons as vertical float bar on the left side of post and stay on screen while scroll down</label></label></td>';
	echo '<td align="center" valign="top" style="background-color: #ffffff !important;border-top: 1px solid #dadada;"><img src="' . ESSB_PLUGIN_URL . '/assets/images/button-position-08.png" style="margin-bottom: 5px;" /><br/><input id="" value="inline" name="general_options[display_where]" type="radio" ' . $w_inline . ' />
	<br/><label for=""><strong>' . __ ( "Content Inline (&lt;!--easy-share--&gt;)", ESSB_TEXT_DOMAIN ) . '</strong><br/><label class="small">This will display buttons on every position where text &lt;!--easy-share--&gt; is included.</label></label></td>';
	echo '<td align="center" valign="top" style="background-color: #fafafa !important;border-top: 1px solid #dadada;"><img src="' . ESSB_PLUGIN_URL . '/assets/images/button-position-12.png" style="margin-bottom: 5px;border: 1px solid #d3d3d3;" /><br/><input id="" value="flyin" name="general_options[display_where]" type="radio" ' . $w_flyin . ' />
	<br/><label for=""><strong>' . __ ( "Flyin", ESSB_TEXT_DOMAIN ) . '</strong><br/><label class="small">This will display buttons as fly in panel</label></label></td>';
	echo '</tr>';
	
	echo '</table>';
}

function essb_display_for_mobile() {
	$options = get_option ( EasySocialShareButtons::$plugin_settings_name );
	if (is_array ( $options )) {
		$exist = isset ( $options ['display_position_mobile'] ) ? $options ['display_position_mobile'] : '';
		$exist = stripslashes ( $exist );
		
		echo '<p style="margin: .2em 5% .2em 0;"><select id="display_position_mobile" type="text" name="general_options[display_position_mobile]" class="input-element">
		<option value="" ' . ($exist == '' ? ' selected="selected"' : '') . '>No</option>
		<option value="bottom" ' . ($exist == 'bottom' ? ' selected="selected"' : '') . '>Content bottom</option>
		<option value="top" ' . ($exist == 'top' ? ' selected="selected"' : '') . '>Content top</option>
		<option value="both" ' . ($exist == 'both' ? ' selected="selected"' : '') . '>Content top and bottom</option>
		<option value="float" ' . ($exist == 'float' ? ' selected="selected"' : '') . '>Float from content top</option>
		<option value="sidebar" ' . ($exist == 'sidebar' ? ' selected="selected"' : '') . '>Top or bottom Sidebar</option>
		</select>
		</p>';
	}
}

function essb_force_hide_buttons_on_mobile() {
	$options = get_option ( EasySocialShareButtons::$plugin_settings_name );
	if (is_array ( $options )) {
		$exist = isset ( $options ['force_hide_buttons_on_mobile'] ) ? $options ['force_hide_buttons_on_mobile'] : 'false';
		
		$is_checked = ($exist == 'true') ? ' checked="checked"' : '';
		echo '<p style="margin: .2em 5% .2em 0;"><input id="force_hide_buttons_on_mobile" type="checkbox" name="general_options[force_hide_buttons_on_mobile]" value="true" ' . $is_checked . ' /><label for="force_hide_buttons_on_mobile"></label></p>';
	
	}

}

function essb_another_display_sidebar() {
	$options = get_option ( EasySocialShareButtons::$plugin_settings_name );
	if (is_array ( $options )) {
		$exist = isset ( $options ['another_display_sidebar'] ) ? $options ['another_display_sidebar'] : 'false';
		
		$is_checked = ($exist == 'true') ? ' checked="checked"' : '';
		echo '<p style="margin: .2em 5% .2em 0;"><input id="another_display_sidebar" type="checkbox" name="general_options[another_display_sidebar]" value="true" ' . $is_checked . ' /><label for="another_display_sideba"></label></p>';
	
	}

}

function essb_another_display_popup() {
	$options = get_option ( EasySocialShareButtons::$plugin_settings_name );
	if (is_array ( $options )) {
		$exist = isset ( $options ['another_display_popup'] ) ? $options ['another_display_popup'] : 'false';
		
		$is_checked = ($exist == 'true') ? ' checked="checked"' : '';
		echo '<p style="margin: .2em 5% .2em 0;"><input id="another_display_popup" type="checkbox" name="general_options[another_display_popup]" value="true" ' . $is_checked . ' /><label for="another_display_popup"></label></p>';
	
	}

}

?>


<div class="wrap">
	<form name="general_form" method="post"
		action="admin.php?page=essb_settings&tab=wizard"
		enctype="multipart/form-data" id="wizard-form">
		<input type="hidden" id="cmd" name="cmd" value="update" />

		<div id="poststuff">
			<div class="postbox">
				<h3 class="hndle">
					<span>Easy Social Share Buttons for WordPress Configuration Wizard</span>
				</h3>
				<div class="inside">

					<div id="essb-easy-wizard">
						<!--  wizard start -->

						<h3>Template</h3>
						<section>
							<table border="0" cellpadding="5" cellspacing="0" width="100%">
								<col width="30%" />
								<col width="70%" />
								<tr>
									<td colspan="2" class="sub"><?php _e('Template', ESSB_TEXT_DOMAIN); ?></td>
								</tr>
								<tr>
									<td colspan="2" class="info-box-parent">
										<div class="info-box">Choose default template you wish to use
											for button render. After finishing the wizard you can change
											template in Main Settings -> Template or provide in advanced
											display options different templates for each button location
											or post type.</div>
									</td>
								</tr>
							</table>
							<table border="0" cellpadding="5" cellspacing="0" width="100%"
								class="wizard-templates">
								<col width="30%" />
								<col width="70%" />
						<?php essb_template_select_radio();?>
						</table>

						</section>
						<h3>Button style</h3>
						<section>
							<table border="0" cellpadding="5" cellspacing="0" width="100%">
								<col width="30%" />
								<col width="70%" />
								<tr>
									<td colspan="2" class="sub"><?php _e('Provide default button style', ESSB_TEXT_DOMAIN); ?></td>
								</tr>
								<tr>
									<td colspan="2" class="info-box-parent">
										<div class="info-box">Button style can be changed after
											closing wizard using Display Settings -> Counters and Display
											Settings -> Names</div>
									</td>
								</tr>
							</table>
							<table border="0" cellpadding="5" cellspacing="0" width="100%">
								<col width="30%" />
								<col width="70%" />
								<tr class="even table-border-bottom">
									<td class="bold">Social Share Buttons Type:<br /> <span
										class="label">Provide the default button look. You can
											personalize this using advanced options in Display Settings
											after finishing wizard</span></td>
									<td class="essb_options_general bold"><select
										class="input-element stretched"
										name="general_options[button_type]">
											<option value="button">Social Share Buttons with network name
												and icon</option>
											<option value="button_name">Social Share Buttons with network
												name and without icon</option>
											<option value="icon">Social Share Button with icon only and
												not network name</option>
											<option value="icon_name">Social Share Button with icon and
												network name visible on button hover</option>
									</select></td>
								</tr>

								<tr class="odd table-border-bottom">
									<td valign="top" class="bold"><?php _e('Activate animations:', ESSB_TEXT_DOMAIN); ?><div
											class="essb-new">
											<span></span>
										</div> <br /> <span class="label" style="font-weight: 400;">Animations
											are provided with CSS transitions and work on best with
											retina templates.</span></td>
									<td class="essb_options_general bold">
							<?php
							
							$css_animations = array ("no" => "", "smooth" => "Smooth colors", "pop" => "Pop up", "zoom" => "Zoom out", "flip" => "Flip" );
							ESSB_Settings_Helper::drawSelectField ( 'css_animations', $css_animations );
							
							?>
							
							</td>
								</tr>
								<tr class="table-border-bottom">
									<td colspan="2" class="sub3">Display Counters</td>
								</tr>
								<tr class="even table-border-bottom">
									<td class="bold">Display counters of sharing:<br /> <span
										class="label">Activate display of social share counters</span></td>
									<td class="bold">
									<?php
									
									$counter_object = array ("0" => "No", "1" => "Yes" );
									ESSB_Settings_Helper::drawSelectField ( 'show_counter', $counter_object );
									
									?>
									
									</td>
								</tr>
								<tr class="odd table-border-bottom" id="essb-counters1">
									<td class="bold">Counters display type:<br /> <span
										class="label">Choose counters you wish to display</span></td>
									<td class="bold">
									<?php
									
									$counter_object = array ("both" => "Total counter and button counter", "total" => "Total counter only", "button" => "Button counter only" );
									ESSB_Settings_Helper::drawSelectField ( 'show_counter_type', $counter_object );
									
									?>
									
									
									</td>
								</tr>
								<tr class="even table-border-bottom" id="essb-counters2">
									<td class="bold">Total counter display position:<br /> <span
										class="label">Provide position of total counter. If <b>Button
												counter only</b> is provided in Counters display type this
											field will not be taken as total coutner will not be
											displayed.
									</span></td>
									<td class="bold">
									<?php
									$counter_object = array ("" => "Right", "left" => "Left", "rightbig" => "Right big numbers", "leftbig" => "Left big numbers" );
									ESSB_Settings_Helper::drawSelectField ( 'total_counter_pos', $counter_object );
									?>
									
									</td>
								</tr>
								<tr class="odd table-border-bottom" id="essb-counters3">
									<td class="bold">Button counter display position:<br /> <span
										class="label">Provide position of button counter. If <b>Total
												counter only</b> is provided in Counters display type this
											field will not be taken as total coutner will not be
											displayed.
									</span></td>
									<td class="bold">
									<?php
									$counter_object = array ("" => "Left", "right" => "Right", "inside" => "Inside Button", "insidename" => "Inside button and network name", "leftm" => "Left Modern", "rightm" => "Right Modern", "top" => "Top Modern", "topm" => "Top Mini", "bottom" => "Bottom" );
									ESSB_Settings_Helper::drawSelectField ( 'counter_pos', $counter_object );
									?>
									
									</td>
								</tr>
								<tr class="even table-border-bottom" id="essb-counters4">
									<td class="bold">Activate counters for social networks that does not support them:<br /> <span
										class="label">Not all social networks give access to the share counter. Activate this option to have internal counter for all networks that does not support them.
									</span></td>
									<td class="bold">
									<?php
									ESSB_Settings_Helper::drawCheckboxField('active_internal_counters');
									?>
									
									</td>
								</tr>
								<tr class="odd table-border-bottom" id="essb-counters5">
									<td class="bold">Cache all counters that cannot be accessed directly:<br /><div class="essb-recommended">
											<i class="fa fa-check"></i><span></span>
										</div> <span
										class="label">Cache of all counters that has no direct access will make plugin to refresh them on given period and will reduce load and execution calls. We recommend activating this option.
									</span></td>
									<td class="bold">
									<?php
									ESSB_Settings_Helper::drawCheckboxField('admin_ajax_cache_internal');
									?>
									
									</td>
								</tr>
							</table>
						</section>

						<h3>Social Share Buttons</h3>
						<section>
							<table border="0" cellpadding="5" cellspacing="0" width="100%">
								<col width="50%" />
								<col width="50%" />
								<tr>
									<td colspan="2" class="sub"><?php _e('Choose Active Social Share Buttons', ESSB_TEXT_DOMAIN); ?></td>
								</tr>
								<tr>
									<td colspan="2" class="info-box-parent">
										<div class="info-box">Choose default active social share
											buttons. Using drag and drop you can move them and arrange
											the way you wish to appear in the list. You can change this
											anytime after wizard finish using the Main Settings -> Social
											Share Buttons screen.</div>
									</td>
								</tr>

								<tr class="even table-border-bottom">

									<td colspan="2"><ul id="networks-sortable"><?php essb_setting_checkbox_network_selection(); ?></ul></td>
								</tr>

							</table>
						</section>
						<h3>Additional Social Share Buttons Settings</h3>
						<section>
							<table border="0" cellpadding="5" cellspacing="0" width="100%">
								<col width="30%" />
								<col width="70%" />
								<tr>
									<td colspan="2" class="sub"><?php _e('Additional Social Share Buttons Settings', ESSB_TEXT_DOMAIN); ?></td>
								</tr>
								<tr class="odd table-border-bottom">
									<td valign="top" class="bold"><?php _e('Buttons Align:', ESSB_TEXT_DOMAIN); ?><br />
										<span class="label" style="font-weight: 400;">Choose how
											buttons to be aligned. Default position is left but you can
											also select Right or Center</span></td>
									<td><?php essb_custom_buttons_pos(); ?></td>
								</tr>
								<tr class="even table-border-bottom"
									id="essb-more-button-options" style="display: none;">
									<td valign="top" class="bold">More button function:<br /> <span
										class="label" style="font-weight: 400;">Choose how more button
											will function.</span></td>
									<td class="essb_options_general">
						 	<?php
								
								$more_options = array ("1" => "Display all active networks after more button", "2" => "Display all social networks as popup", "3" => "Display only active social networks as popup" );
								ESSB_Settings_Helper::drawSelectField ( 'more_button_func', $more_options );
								
								?>
						 
						 </td>
								</tr>
								<tr class="table-border-bottom" id="essb-twitter1">
									<td colspan="2" class="sub3">Twitter Additional Options</td>
								</tr>
								<tr class="even table-border-bottom" id="essb-twitter4">
									<td class="bold" valign="top">Twitter username to be mentioned:<br />
										<span for="twitteruser" class="label">If you wish a twitter
											username to be mentioned in tweet write it here. Enter your
											username without @ - example <span class="bold">twittername</span>.
											This text will be appended to tweet message at the end.
											Please note that if you activate custom share address option
											this will be added to custom share message.
									</span></td>
									<td class="essb_general_options"><?php essb_twitter_username_append(); ?></td>
								</tr>
								<tr class="odd table-border-bottom" id="essb-twitter5">
									<td class="bold" valign="top">Twitter hashtags to be added:<br />
										<span for="twitterhashtags" class="label">If you wish hashtags
											to be added to message write theme here. You can set one or
											more (if more then one separate them with comma (,)) Example:
											demotag1,demotag2.</span></td>
									<td class="essb_general_options"><?php essb_twitter_hashtags_append(); ?></td>
								</tr>
								<tr class="even table-border-bottom" id="essb-twitter2">
									<td class="bold" valign="top">Twitter share short url:<br />
										<div class="essb-recommended">
											<i class="fa fa-check"></i><span></span>
										</div> <span for="twitter_shareshort" class="label">Activate
											this option to share short url with Twitter.</span></td>
									<td class="essb_general_options"><?php essb_twitter_share_short(); ?></td>
								</tr>
								<tr class="odd table-border-bottom" id="essb-twitter3">
									<td class="bold" valign="top">Short URL service:<br /> <span
										class="label">Provide short URL service you wish to use to
											generate short URL's used with Twitter. wp_get_shortlink is
											build in WordPress option that will provide shorturl like
											this http://www.site.com/?p=123. Goo.gl is short url serives
											provided from Google which does not require registration or
											setup. Returned address will look like this:
											http://goo.gl/abcdsd. Bit.ly is advanced short URL services
											that requires to work valid username and API key. Return
											address will be in format http://bit.ly/abvcsd or using your
											short domain that you setup in bit.ly.</span></td>
									<td class="essb_general_options">
							<?php
							$list_of_url = array ('wp_get_shortlink', 'goo.gl', 'bit.ly' );
							ESSB_Settings_Helper::drawSelectField ( 'twitter_shareshort_service', $list_of_url, true );
							?>
							</td>
								</tr>
								<tr class="even table-border-bottom" id="essb-twitter6">
									<td valign="top" class="bold">bit.ly user:<br /> <span
										class="label">Provide valid bit.ly username if you select
											short url services options to be active and choose bit.ly</span>
									</td>
									<td class="essb_general_options"><?php essb_url_short_bitly_user(); ?></td>
								</tr>
								<tr class="odd table-border-bottom" id="essb-twitter7">
									<td valign="top" class="bold">bit.ly api key:<br /> <span
										class="label">Provide valid bit.ly api key if you select short
											url services options to be active and choose bit.ly</span>
									</td>
									<td class="essb_general_options"><?php essb_url_short_bitly_api(); ?></td>
								</tr>

							</table>
						</section>
						<h3>Display buttons on</h3>
						<section>
							<table border="0" cellpadding="5" cellspacing="0" width="100%">
								<col width="25%" />
								<col width="75%" />
								<tr>
									<td colspan="2" class="sub"><?php _e('Display buttons on', ESSB_TEXT_DOMAIN); ?></td>
								</tr>

								<tr class="even">
									<td valign="top" class="bold"><?php _e('Where to display buttons:', ESSB_TEXT_DOMAIN); ?><br />
										<span class="label" style="font-weight: 400;">Choose post
											types where you wish buttons to appear. If you are running <span
											class="bold">WooCommerce</span> store you can choose between
											post type <span class="bold">Products</span> which will
											display share buttons into product description or option to
											display buttons below price.
									</span></td>
									<td class="essb_general_options"><?php essb_select_content_type(); ?></td>
								</tr>
								<tr class="odd table-border-bottom">
									<td class="bold" valign="top">Display in post excerpt:<br /> <span
										class="label">(Activate this option if your theme is using
											excerpts and you wish to display share buttons in excerpts)</span></td>
									<td class="essb_general_options"
										style="vertical-align: middle;"><?php
										$excerpt_pos = array ("top", "bottom" );
										$html = ESSB_Settings_Helper::generateCustomSelectField ( 'display_excerpt_pos', $excerpt_pos, true );
										echo "<br/>";
										ESSB_Settings_Helper::drawExtendedCheckboxField ( 'display_excerpt', $html . '' );
										?></td>
								</tr>
							</table>
						</section>
						<h3>Position of buttons</h3>
						<section>
							<table border="0" cellpadding="5" cellspacing="0" width="100%">
								<col width="25%" />
								<col width="75%" />
								<tr>
									<td colspan="2" class="sub"><?php _e('Position of buttons', ESSB_TEXT_DOMAIN); ?></td>
								</tr>

								<tr class="even table-border-bottom">
									<td valign="top" class="bold"><?php _e('Primary position of buttons:', ESSB_TEXT_DOMAIN); ?><br />
										<span class="label" style="font-weight: 400;">Choose default
											method that will be used to render buttons. You are able to
											provide custom options for each post/page.</span></td>
									<td class="essb_general_options"><?php essb_setting_radio_where(); ?></td>
								</tr>
								<tr class="table-border-bottom">
									<td colspan="2" class="sub3">Additional display positions</td>
								</tr>
								<tr class="even table-border-bottom">
									<td class="bold" valign="top">Window sidebar:</td>
									<td class="essb_general_options"><?php ESSB_Settings_Helper::drawCheckboxField('another_display_sidebar');?></td>
								</tr>
								<tr class="odd table-border-bottom">
									<td class="bold" valign="top">Post vertical float sidebar:</td>
									<td class="essb_general_options"><?php ESSB_Settings_Helper::drawCheckboxField('another_display_postfloat');?></td>
								</tr>
								<tr class="even table-border-bottom">
									<td class="bold" valign="top">Display as popup window:</td>
									<td class="essb_general_options"><?php ESSB_Settings_Helper::drawCheckboxField('another_display_popup');?></td>
								</tr>
								<tr class="odd table-border-bottom">
									<td class="bold" valign="top">Display as flyin panel:</td>
									<td class="essb_general_options"><?php ESSB_Settings_Helper::drawCheckboxField('another_display_flyin');?></td>
								</tr>								
								<tr class="table-border-bottom">
									<td colspan="2" class="sub3">Mobile device options</td>
								</tr>
								<tr class="even table-border-bottom">
									<td valign="top" class="bold"><?php _e("Change display method for mobile:", ESSB_TEXT_DOMAIN);?>
							<br /> <span class="label" style="font-weight: 400;">This option
											allow you to set another display method of buttons which will
											be applied when page/post is viewed from mobile device.</span></td>
									<td class="essb_general_options"><?php essb_display_for_mobile(); ?></td>
								</tr>
								<tr class="odd table-border-bottom">
									<td valign="top" class="bold"><?php _e("Mobile sidebar position:", ESSB_TEXT_DOMAIN);?>
							<br /> <span class="label" style="font-weight: 400;">Choose
											sidebar position when activate another display method for
											mobile is set to sidebar.</span></td>
									<td class="essb_general_options"><?php $mobile_pos = array("bottom", "top"); ESSB_Settings_Helper::drawSelectField('display_position_mobile_sidebar', $mobile_pos, true) ?></td>
								</tr>
								<tr class="even table-border-bottom">
									<td valign="top" class="bold">Hide buttons for low resolution
										mobile devices:<br /> <span class="label"
										style="font-weight: 400;">This option will hide buttons when
											viewed from low resolution mobile device.</span>
									</td>
									</td>
									<td class="essb_general_options"><?php essb_force_hide_buttons_on_mobile();?></td>
								</tr>
								<tr class="odd table-border-bottom">
									<td valign="top" class="bold">Hide buttons for all mobile
										devices:<br /> <span class="label" style="font-weight: 400;">This
											option will always hide buttons when viewed from any mobile
											device.</span>
									</td>
									</td>
									<td class="essb_general_options"><?php ESSB_Settings_Helper::drawCheckboxField('force_hide_buttons_on_all_mobile');?></td>
								</tr>
							</table>
						</section>
						<h3>Optimization</h3>
						<section>
							<table border="0" cellpadding="5" cellspacing="0" width="100%">
								<col width="25%" />
								<col width="75%" />
								<tr>
									<td colspan="2" class="sub"><?php _e('Optimzation of plugin work', ESSB_TEXT_DOMAIN); ?></td>
								</tr>

								<tr class="table-border-bottom">
									<td colspan="2" class="sub3">Social Share Optimization</td>
								</tr>
								<tr class="even table-border-bottom">
									<td class="bold" valign="top">Activate include of social share optimization meta tags:<br/>
									<span class="label">If you do not use SEO plugin or other plugin that insert social share optimization meta tags it is highly recommended to activate this option. It will generated required for better sharing meta tags and also will allow you to change the values that social network read from your site.</span></td>
									<td><?php ESSB_Settings_Helper::drawCheckboxField('opengraph_tags');?>
								</tr>
								<tr class="table-border-bottom">
									<td colspan="2" class="sub3">Static Resource Optimization</td>
								</tr>
								
								<tr class="even table-border-bottom">
									<td valign="top" class="bold"><?php _e('Use minified plugin resources:', ESSB_TEXT_DOMAIN); ?><br />
										<span class="label" style="font-weight: 400;">Minified
											resources will improve page load</span></td>
									<td class="essb_general_options"><?php ESSB_Settings_Helper::drawCheckboxField('use_minified_files'); ?></td>
								</tr>
								<tr class="odd table-border-bottom">
									<td class="bold" valign="top">Load plugin javascript files
										asynchronous:<br /> <span class="label"
										style="font-weight: normal;">If you found any problems using
											it please report at our <a href="http://support.creoworx.com"
											target="_blank">support portal</a>.
									</span>
									</td>
									<td><?php ESSB_Settings_Helper::drawCheckboxField('load_js_async'); ?></td>
								</tr>
								<tr class="even table-border-bottom">
									<td class="bold" valign="top">Load plugin javascript files
										deferred:
										<div class="essb-new">
											<span></span>
										</div> <br /> <span class="label" style="font-weight: normal;">If
											you found any problems using it please report at our <a
											href="http://support.creoworx.com" target="_blank">support
												portal</a>.
									</span>
									</td>
									<td><?php ESSB_Settings_Helper::drawCheckboxField('load_js_defer'); ?></td>
								</tr>
								<tr class="odd table-border-bottom">
									<td class="bold" valign="top">Remove version number from script
										and css files:<br /> <span class="label"
										style="font-weight: 400;">Activating this option will remove
											added to resources version number ?ver= which will allow this
											files to be cached.</span>
									</td>
									<td><?php  ESSB_Settings_Helper::drawCheckboxField('remove_ver_resource'); ?></td>
								</tr>
								<tr class="table-border-bottom">
									<td class="sub3" colspan="2">Build-in Cache (Dynamic Resource Optimization)</td>
								</tr>
								<tr class="even table-border-bottom">
									<td class="bold" valign="top">Activate cache:
										<div class="essb-new">
											<span></span>
										</div>
										<div class="essb-beta">
											<span></span>
										</div> <br /> <span class="label" style="font-weight: normal;">This
											is option is in beta and if you found any problems using it
											please report at our <a href="http://support.creoworx.com"
											target="_blank">support portal</a>.<br />To clear cache you
											can simply press Update Settings button in Main Settings
											(cache expiration time is 1 hour)
									</span>
									</td>
									<td><?php ESSB_Settings_Helper::drawCheckboxField('essb_cache'); ?></td>
								</tr>
								<tr class="odd table-border-bottom">
									<td class="bold" valign="top">Cache mode:
										<div class="essb-new">
											<span></span>
										</div>
										<div class="essb-beta">
											<span></span>
										</div> <br /> <span class="label" style="font-weight: normal;">Choose
											between caching full render of share buttons and resources or
											cache only dynamic resources (CSS and Javascript).</span>
									</td>
									<td><?php
									$cache_mode = array ("full" => "Cache button render and dynamic resources", "resource" => "Cache only dynamic resources" );
									
									ESSB_Settings_Helper::drawSelectField ( 'essb_cache_mode', $cache_mode );
									?></td>
								</tr>
							<tr class="even table-border-bottom">
							<td class="bold" valign="top">Combine into single file all plugin
								static CSS files:
								<div class="essb-new">
									<span></span>
								</div>
								<div class="essb-beta">
									<span></span>
								</div>
								<br /> <span class="label" style="font-weight: 400;">This option
									will combine all plugin static CSS files into single file.</span>
							</td>
							<td><?php  ESSB_Settings_Helper::drawCheckboxField('essb_cache_static'); ?></td>
						</tr>
							</table>
						</section>
						<!--  wizard end -->
					</div>
				</div>
			</div>
		</div>
	</form>
</div>

<script type="text/javascript">
jQuery("#essb-easy-wizard").steps({
    headerTag: "h3",
    bodyTag: "section",
    transitionEffect: "slide",
    stepsOrientation: "vertical",
    cssClass: 'essb-wizard',
    enableCancelButton: true,
    onCanceled: function(event) { window.location='<?php admin_url()?>admin.php?page=essb_settings&tab=general#wizard'; },    
    onFinished: function (event, currentIndex) { jQuery("#wizard-form").submit(); },
	onStepChanged: function (event, currentIndex, priorIndex) {
		if (currentIndex == 3) {
			essb_option_show_hide('#essb-more-button-options', '#network_selection_more');
			essb_option_show_hide('#essb-twitter1,#essb-twitter2,#essb-twitter3,#essb-twitter4,#essb-twitter5,#essb-twitter6,#essb-twitter7', '#network_selection_twitter');
			essb_option_show_hide('#essb-twitter3,#essb-twitter6,#essb-twitter7', '#twitter_shareshort');
		}
	
		if (currentIndex == 6) {
		}

		jQuery("html, body").animate({ scrollTop: 0 }, "slow");
	}
});

jQuery(document).ready(function(){
    jQuery('#networks-sortable').sortable();
	essb_option_show_hide_based_on_value('#essb-counters1,#essb-counters2,#essb-counters3,#essb-counters4,#essb-counters5', '#show_counter', '1');
    jQuery("#show_counter").change(function() {
    	essb_option_show_hide_based_on_value('#essb-counters1,#essb-counters2,#essb-counters3,#essb-counters4,#essb-counters5', '#show_counter', '1');
    });
    jQuery("#twitter_shareshort_service").change(function() {
    	essb_option_show_hide_based_on_value('#essb-twitter6,#essb-twitter7', '#twitter_shareshort_service', 'bit.ly');
    });
    
});

function essb_option_show_hide_based_on_value(oSelector, oSender, oValue) {
	if (oSelector.indexOf(",") > -1) {
		var obj = oSelector.split(",");

		for (var i=0;i<obj.length;i++) {
			var sender = jQuery(oSender).val();
			if (sender == oValue) {
				jQuery(obj[i]).show();
			}
			else {
				jQuery(obj[i]).hide();
			}
		}
	}
	else {
		var sender = jQuery(oSender).val();
		if (sender == oValue) {
			jQuery(oSelector).show();
		}
		else {
			jQuery(oSelector).hide();
		}
	}
}


function essb_option_show_hide(oSelector, oSender) {
	if (oSelector.indexOf(",") > -1) {
		var obj = oSelector.split(",");

		for (var i=0;i<obj.length;i++) {
			var sender = jQuery(oSender);
			if (sender.is(':checked')) {
				jQuery(obj[i]).show();
			}
			else {
				jQuery(obj[i]).hide();
			}
		}
	}
	else {
		var sender = jQuery(oSender);
		if (sender.is(':checked')) {
			jQuery(oSelector).show();
		}
		else {
			jQuery(oSelector).hide();
		}
	}
}
</script>

<style type="text/css">
#wpfooter {
	display: none;
}
</style>