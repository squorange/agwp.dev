<?php

/*
 * Plugin Name: Easy Social Share Buttons for WordPress 
 * Description: Easy Social Share Buttons automatically adds share bar to your post or pages with support of Facebook, Twitter, Google+, LinkedIn, Pinterest, Digg, StumbleUpon, VKontakte, Tumblr, Reddit, Print, E-mail. Easy Social Share Buttons for WordPress is compatible with WooCommerce, bbPress and BuddyPress 
 * Plugin URI: http://codecanyon.net/item/easy-social-share-buttons-for-wordpress/6394476?ref=appscreo
 * Version: 2.0.2
 * Author: CreoApps 
 * Author URI: http://codecanyon.net/user/appscreo/portfolio?ref=appscreo
 */

if (! defined ( 'WPINC' ))
	die ();
	
	// error_reporting( E_ALL | E_STRICT );

define ( 'ESSB_SELF_ENABLED', false );

define ( 'ESSB_VERSION', '2.0.2' );
define ( 'ESSB_PLUGIN_ROOT', dirname ( __FILE__ ) . '/' );
define ( 'ESSB_PLUGIN_URL', plugins_url () . '/' . basename ( dirname ( __FILE__ ) ) );
define ( 'ESSB_PLUGIN_BASE_NAME', plugin_basename ( __FILE__ ) );
define ( 'ESSB_DEMO_MODE', true);

global $essb_plugin_base_name;
$essb_plugin_base_name = basename ( dirname ( __FILE__ ) );

define ( 'ESSB_TEXT_DOMAIN', 'essb' );

include_once (ESSB_PLUGIN_ROOT . 'lib/helpers/essb-cache.php');
include_once (ESSB_PLUGIN_ROOT . 'lib/essb.php');
include_once (ESSB_PLUGIN_ROOT . 'lib/essb-options.php');
//
include_once (ESSB_PLUGIN_ROOT . 'lib/helpers/essb-optionshelper.php');
include_once (ESSB_PLUGIN_ROOT . 'lib/essb-stats.php');
include_once (ESSB_PLUGIN_ROOT . 'lib/essb-loveyou.php');
include_once (ESSB_PLUGIN_ROOT . 'lib/extensions/essb-social-privacy.php');
include_once (ESSB_PLUGIN_ROOT . 'lib/extensions/essb-social-share-optimization.php');
include_once (ESSB_PLUGIN_ROOT . 'lib/extensions/essb-js-builder.php');
include_once (ESSB_PLUGIN_ROOT . 'lib/extensions/essb-advanced-display-settings.php');
include_once (ESSB_PLUGIN_ROOT . 'lib/extensions/essb-shorturl.php');
include_once (ESSB_PLUGIN_ROOT . 'lib/extensions/essb-shortcode-helper.php');
require_once (ESSB_PLUGIN_ROOT . 'lib/external/TwitterAPIExchange.php');
require_once (ESSB_PLUGIN_ROOT . 'lib/external/mobile-detect/mobile-detect.php');
include_once (ESSB_PLUGIN_ROOT . 'lib/modules/essb-social-fanscounter.php');
include_once (ESSB_PLUGIN_ROOT . 'lib/helpers/essb-social-image-share-options.php');
include (ESSB_PLUGIN_ROOT . 'lib/extensions/essb-share-widget.php');
include (ESSB_PLUGIN_ROOT . 'lib/modules/easy-top-social-posts-widget/easy-top-social-posts-widget.php');

include (ESSB_PLUGIN_ROOT . 'lib/extensions/essb-flattr.php');
include (ESSB_PLUGIN_ROOT . 'lib/extensions/essb-skinned-native-button.php');
include (ESSB_PLUGIN_ROOT . 'lib/extensions/essb-css-builder.php');

include_once (ESSB_PLUGIN_ROOT . 'lib/modules/essb-after-share-close.php');

register_activation_hook ( __FILE__, array ('EasySocialShareButtons', 'activate' ) );
register_deactivation_hook ( __FILE__, array ('EasySocialShareButtons', 'deactivate' ) );

add_action ( 'init', 'essb_load_translations' );
function essb_load_translations() {
	load_plugin_textdomain ( ESSB_TEXT_DOMAIN, false, ESSB_PLUGIN_ROOT . '/languages' );
}

$essb_options = EasySocialShareButtons_Options::get_instance();
$option = $essb_options->options;


$module_off_sfc = isset ( $option ['module_off_sfc'] ) ? $option ['module_off_sfc'] : 'false';
$module_off_lv = isset ( $option ['module_off_lv'] ) ? $option ['module_off_lv'] : 'false';
$essb_cache = isset($option['essb_cache']) ? $option['essb_cache'] : 'false';
$essb_cache_mode = isset($option['essb_cache_mode']) ? $option['essb_cache_mode'] : '';

if ($essb_cache == 'true') { ESSBCache::activate($essb_cache_mode); }

global $essb_fans;
if ($module_off_sfc != 'true') {
	$essb_fans = EasySocialFansCounter::get_instance ();
	$essb_fans->version = ESSB_VERSION;
	$remove_ver_resource = isset($option['remove_ver_resource']) ? $option['remove_ver_resource'] : 'false';
	if ($remove_ver_resource == 'true') {
		$essb_fans->version = '';
	}
	
}

// static resources cache
$essb_cache_static = isset($option['essb_cache_static']) ? $option['essb_cache_static'] : 'false';
$essb_cache_static_js = isset($option['essb_cache_static_js']) ? $option['essb_cache_static_js'] : 'false';
if ($essb_cache_static == 'true' || $essb_cache_static_js == 'true') {
	include_once (ESSB_PLUGIN_ROOT . 'lib/helpers/essb-cache-static-css.php');
}

global $essb_stats;
$essb_stats = new EasySocialShareButtons_Stats();

global $essb;
$essb = EasySocialShareButtons::get_instance ();


$disable_admin_menu = isset ( $option ['disable_adminbar_menu'] ) ? $option ['disable_adminbar_menu'] : 'false';

// @since 1.3.1
if ($disable_admin_menu != 'true') {
	add_action ( "init", "ESSBAdminMenuInit" );
}

function ESSBAdminMenuInit() {
	global $essb_adminmenu;
	$essb_adminmenu = new EasySocialShareButtons_AdminMenu ();
}

// add update periods for social metrics
$esml_active = isset ( $option ['esml_active'] ) ? $option ['esml_active'] : 'false';
define ( 'ESSB_ESML_ACTIVE', $esml_active );
if ($esml_active == 'true') {
	add_action( 'plugins_loaded', 'esml_register_custom_cron_jobs' );
	
	function esml_register_custom_cron_jobs() {
		add_filter( 'cron_schedules', 'ESMLregsiterUpdateCronPeriods');		
	}	
}
include (ESSB_PLUGIN_ROOT . 'lib/modules/easy-social-metrics-lite/easy-social-metrics-lite.php');

// since 2.0 Easy Social Image Share Module
$essb_image_options = ESSBSocialImageShareOptions::get_instance();
if ($essb_image_options->is_active_module()) {
	include_once (ESSB_PLUGIN_ROOT . 'lib/modules/easy-image-share/easy-image-share.php');
}

//if (is_admin () && (! defined ( 'DOING_AJAX' ) || ! DOING_AJAX)) {
if (is_admin ()) {
	include (ESSB_PLUGIN_ROOT . 'lib/external/autoupdate/plugin-update-checker.php');
	include (ESSB_PLUGIN_ROOT . 'lib/admin/essb-metabox.php');
	include (ESSB_PLUGIN_ROOT . 'lib/extensions/essb-settings-helper.php');
	include_once (ESSB_PLUGIN_ROOT . 'lib/helpers/essb-shortcode-generator.php');
	
	global $stats;
	$stats = EasySocialShareButtons_Stats_Admin::get_instance ();
	
	
	// @since 1.3.9.5 - Hanlde activation of Easy Social Metrics Lite
	if (ESSB_ESML_ACTIVE == 'false') {
		EasySocialMetricsUpdater::removeAllQueuedUpdates ();
		delete_option ( "esml_version" );
	}
	// /end load of Easy Social Metrics Lite
	
	
	include_once (ESSB_PLUGIN_ROOT . 'lib/essb-admin.php');
	add_action( 'plugins_loaded', array( 'EasySocialShareButtons_Admin', 'get_instance' ) );
	
	$puchase_code = isset ( $option ['purchase_code'] ) ? $option ['purchase_code'] : 'none';
	
	// @since 1.3.3
	// autoupdate
	// activating autoupdate option
	$essb_autoupdate = PucFactory::buildUpdateChecker ( 'http://update.creoworx.com/essb/', __FILE__, 'easy-social-share-buttons' );
	
	// @since 1.3.7.2 - update to avoid issues with other plugins that uses same
	// method
	function addSecretKeyESSB($query) {
		global $puchase_code;
		$query ['license'] = $puchase_code;
		return $query;
	}
	$essb_autoupdate->addQueryArgFilter ( 'addSecretKeyESSB' );
	
	
}
if (! function_exists ( 'easy_share_deactivate' )) {
	function easy_share_deactivate() {
		global $essb;
		
		$essb->temporary_deactivate_content_filter ();
	}
}

if (! function_exists ( 'easy_share_reactivate' )) {
	function easy_share_reactivate() {
		global $essb;
		
		$essb->reactivate_content_filter ();
	}
}

if (! function_exists ( 'easy_share_buttons' )) {
	function easy_share_buttons($counters = false) {
		global $essb;
		
		$cnt_flag = ($counters) ? 1 : 0;
		$buttons_html = $essb->generate_share_snippet ( array (), $cnt_flag );
		echo $buttons_html;
	}
}

function ESMLregsiterUpdateCronPeriods($schedules) {

	$schedules['esml_1'] = array(
			'interval' => 3600,
			'display' => __( 'Every 1 hour' )
	);
	$schedules['esml_2'] = array(
			'interval' => 7200,
			'display' => __( 'Every 2 hours' )
	);
	$schedules['esml_4'] = array(
			'interval' => 14400,
			'display' => __( 'Every 4 hours' )
	);
	$schedules['esml_8'] = array(
			'interval' => 28800,
			'display' => __( 'Every 8 hours' )
	);
	$schedules['esml_12'] = array(
			'interval' => 43200,
			'display' => __( 'Every 12 hours' )
	);
	$schedules['esml_24'] = array(
			'interval' => 86400,
			'display' => __( 'Every 24 hours' )
	);
	$schedules['esml_36'] = array(
			'interval' => 129600,
			'display' => __( 'Every 36 hours' )
	);
	$schedules['esml_48'] = array(
			'interval' => 172800,
			'display' => __( 'Every 48 hours' )
	);
	$schedules['esml_72'] = array(
			'interval' => 259200,
			'display' => __( 'Every 3 days' )
	);
	$schedules['esml_96'] = array(
			'interval' => 345600,
			'display' => __( 'Every 4 days' )
	);
	$schedules['esml_120'] = array(
			'interval' => 432000,
			'display' => __( 'Every 5 days' )
	);
	$schedules['esml_168'] = array(
			'interval' => 604800,
			'display' => __( 'Every 7 days' )
	);

	return $schedules;
}
?>