<?php

// if (isset($_POST)) {
// if (!check_admin_referer('essb')) { die(); }
// }
$essb_cache = isset ( $_REQUEST ['essb_cache'] ) ? $_REQUEST ['essb_cache'] : '';
$current_admin_url = 'http' . (is_ssl () ? 's' : '') . '://' . $_SERVER ['HTTP_HOST'] . $_SERVER ['REQUEST_URI'];
$action = str_replace ( '%7E', '~', $_SERVER ['REQUEST_URI'] );
$welcome_action = isset ( $_REQUEST ['welcome'] ) ? $_REQUEST ['welcome'] : '';
if ($welcome_action == '0') {
	update_option ( 'essb-welcome-deactivated', 'true' );
}

global $apply_setting;
$apply_setting = isset ( $_REQUEST ['apply_setting'] ) ? $_REQUEST ['apply_setting'] : '';
if ($apply_setting != '') {
	include (ESSB_PLUGIN_ROOT . '/lib/admin/pages/essb-admin-quick-apply.php');
}

$current_tab = (empty ( $_GET ['tab'] )) ? 'general' : sanitize_text_field ( urldecode ( $_GET ['tab'] ) );

$tabs = array ('general' => __ ( 'Main Settings', ESSB_TEXT_DOMAIN ), 'display' => __ ( 'Display Settings', ESSB_TEXT_DOMAIN ), 'customizer' => __ ( 'Style Settings', ESSB_TEXT_DOMAIN ), 'shortcode2' => __ ( 'Shortcode Generator', ESSB_TEXT_DOMAIN ), "stats" => "Click Statistics", "backup" => "Import/Export Settings", "update" => "Automatic Updates" );

$first_time_option = get_option ( 'essb-first-time' );
if (isset ( $first_time_option )) {
	if ($first_time_option == 'true') {
		// $current_tab = "wizard";
	}
	
	delete_option ( 'essb-first-time' );
}

$welcome_active = true;
if ($current_tab == "wizard") {
	$welcome_active = false;
}

$welcome_option = get_option ( 'essb-welcome-deactivated' );
if (isset ( $welcome_option )) {
	if ($welcome_option == "true") {
		$welcome_active = false;
	}
}

if ($current_tab == "wizard") {
	include (ESSB_PLUGIN_ROOT . '/lib/admin/pages/essb-settings-wizard2.php');
}
if ($current_tab == "wizard2") {
	include (ESSB_PLUGIN_ROOT . '/lib/admin/pages/essb-settings-wizard.php');
}

// check for cache activated
$current_options = get_option ( EasySocialShareButtons::$plugin_settings_name );
$general_cache_active = ESSBOptionsHelper::optionsBoolValue ( $current_options, 'essb_cache' );
$general_cache_active_static = ESSBOptionsHelper::optionsBoolValue ( $current_options, 'essb_cache_static' );
$general_cache_active_static_js = ESSBOptionsHelper::optionsBoolValue ( $current_options, 'essb_cache_static_js' );
$general_cache_mode = ESSBOptionsHelper::optionsValue ( $current_options, 'essb_cache_mode' );

$display_cache_mode = "";
if ($general_cache_active) {
	if ($general_cache_mode == "full") {
		$display_cache_mode = "Cache button render and dynamic resources";
	} else {
		$display_cache_mode = "Cache only dynamic resources";
	}
}

if ($general_cache_active_static || $general_cache_active_static_js) {
	if ($display_cache_mode != '') {
		$display_cache_mode .= ", ";
	}
	$display_cache_mode .= "Combine into sigle file all plugin static CSS files";
}

if ($essb_cache == 'clear') {
	ESSBCache::flush ();
	if (function_exists ( 'purge_essb_cache_static_cache' )) {
		purge_essb_cache_static_cache ();
	}
	
	echo '<div class="updated" style="padding: 10px;"><strong>Success: Easy Social Share Buttons for WordPress cache purged.</strong></div>';
}

if ($current_tab != 'wizard' && $current_tab != 'wizard2') {
	
	?>

<div class="wrap">
	<div class="essb-title-panel">
	<?php echo '<a href="http://support.creoworx.com" target="_blank" text="' . __ ( 'Need Help? Click here to visit our support center', ESSB_TEXT_DOMAIN ) . '" class="button float_right">' . __ ( 'Support Center', ESSB_TEXT_DOMAIN ) . '</a>'; ?>
	
<h3>Easy Social Share Buttons for WordPress</h3>
		<p>
			Version <strong><?php echo ESSB_VERSION;?></strong>. &nbsp;<strong><a
				href="http://fb.creoworx.com/essb/change-log/" target="_blank">See
					what's new in this version</a></strong>&nbsp;&nbsp;&nbsp;<strong><a
				href="http://codecanyon.net/item/easy-social-share-buttons-for-wordpress/6394476?ref=appscreo"
				target="_blank">Easy Social Share Buttons plugin homepage</a></strong>
		</p>
	</div>

	<div class="essb-tabs">

		<ul>
    <?php
	foreach ( $tabs as $name => $label ) {
		echo '<li><a href="' . admin_url ( 'admin.php?page=essb_settings&tab=' . $name ) . '" class="essb-nav-tab ';
		if ($current_tab == $name)
			echo 'active';
		echo '">' . $label . '</a></li>';
	}
	
	?>
    </ul>

	</div>
	<div class="essb-clear"></div>
	<div class="essb-quick-nav" id="essb-quick-nav">
		<ul>
			<li><a href="admin.php?page=essb_settings&tab=wizard"><i
					class="fa fa-cog fa-lg"></i><span>Configuration Wizard</span></a></li>
			<li><a
				href="#TB_inline?width=600&height=550&inlineId=quick-settings-apply"
				class="thickbox" title="Quick Settings Apply"><i
					class="fa fa-bolt fa-lg"></i><span>Quick Apply</span></a></li>
			<li><a href="#TB_inline?width=600&height=550&inlineId=quick-fix"
				class="thickbox" title="Quick Fix Common Issues"><i
					class="fa fa-check-circle-o fa-lg"></i><span>Quick Fix</span></a></li>
			<li><a href="admin.php?page=essb_settings&tab=general&section=1"><i
					class="fa fa-eyedropper fa-lg"></i><span>Template</span></a></li>
			<li><a href="admin.php?page=essb_settings&tab=general&section=2"><i
					class="fa fa-share-alt fa-lg"></i><span>Share Buttons</span></a></li>
			<li><a href="admin.php?page=essb_settings&tab=general&section=3"><i
					class="fa fa-thumbs-up fa-lg"></i><span>Native Buttons</span></a></li>
			<li><a href="admin.php?page=essb_settings&tab=general&section=7"><i
					class="fa fa-dashboard fa-lg"></i><span>Optimization</span></a></li>
			<li><a href="admin.php?page=essb_settings&tab=display&section=1"><i
					class="fa fa-image fa-lg"></i><span>Display Settings</span></a></li>
			<li><a href="admin.php?page=essb_settings&tab=display&section=2"><i
					class="fa fa-th-large fa-lg"></i><span>Button position</span></a></li>
			<li><a href="admin.php?page=essb_settings&tab=display&section=6"><i
					class="fa fa-spinner fa-lg"></i><span>Counters</span></a></li>
			<li><a href="admin.php?page=essb_settings&tab=display&section=15"><i
					class="fa fa-square fa-lg"></i><span>Button style</span></a></li>
		</ul>
	</div>

	<div class="essb-clear"></div>
	
	<?php if ($general_cache_active || $general_cache_active_static || $general_cache_active_static_js) { ?>
	<div class="essb-clear"></div>
	<div class="essb-quick-nav" style="margin-top: 10px;">
				<?php echo '<a href="'.admin_url ( 'admin.php?page=essb_settings&tab=' . $current_tab.'&essb_cache=clear' ).'" text="' . __ ( 'Purge cache', ESSB_TEXT_DOMAIN ) . '" class="button float_right">' . __ ( 'Purge Cache', ESSB_TEXT_DOMAIN ) . '</a>'; ?>
		<div class="text">
			<i class="fa fa-database fa-lg"></i>Easy Social Share Buttons Cache
			is
			<div class="essb-active">
				<span></span>
			</div>&nbsp;&nbsp;Cache mode: <?php echo $display_cache_mode;?></div>

	</div>
	<?php } ?>
	
	<?php add_thickbox(); ?>
	<div id="quick-settings-apply" style="display: none;">

		<div class="essb-quick-apply">
			<h3>Apply ready made configurations</h3>
			<ul>
				<li><a href="#"
					onclick="quick_admin_redirect('admin.php?page=essb_settings&tab=backup&import-ready=mashable'); return false;">
						<span class="icon"><i class="fa fa-eyedropper fa-lg"></i></span><span
						class="text">Import Mashabale style buttons design</span>
						<div class="clear"></div> <span class="label">This will overwrite
							your current settings to produce Mashable style share buttons</span>
				</a></li>
				<li><a href="#"
					onclick="quick_admin_redirect('admin.php?page=essb_settings&tab=backup&import-ready=upworthy');return false;">
						<span class="icon"><i class="fa fa-eyedropper fa-lg"></i></span><span
						class="text">Import Upworthy style buttons design</span>
						<div class="clear"></div> <span class="label">This will overwrite
							your current settings to produce Upworthy style share buttons</span>
				</a></li>
				<li><a href="#"
					onclick="quick_admin_redirect('admin.php?page=essb_settings&tab=backup&import-ready=demo'); return false;">
						<span class="icon"><i class="fa fa-eyedropper fa-lg"></i></span><span
						class="text">Import Easy Social Share Buttons demo style buttons
							design</span>
						<div class="clear"></div> <span class="label">This will overwrite
							your current settings to produce demo style of share buttons from
							official page</span>
				</a></li>
				<li><a href="#"
					onclick="quick_admin_redirect('admin.php?page=essb_settings&tab=backup&import-ready=addthis');return false;">
						<span class="icon"><i class="fa fa-eyedropper fa-lg"></i></span><span
						class="text">Import Add This Sidebar with Counters style buttons
							design</span>
						<div class="clear"></div> <span class="label">This will overwrite
							your current settings to produce Add This Sidebar with Counters
							style of share buttons</span>
				</a></li>
				<li><a href="#"
					onclick="quick_admin_redirect('admin.php?page=essb_settings&tab=backup&import-ready=copy');return false;">
						<span class="icon"><i class="fa fa-eyedropper fa-lg"></i></span><span
						class="text">Import copyblogger style buttons design</span>
						<div class="clear"></div> <span class="label">This will overwrite
							your current settings to produce copyblogger style of share
							buttons</span>
				</a></li>
			</ul>
			<h3>Quick change button style</h3>
			<ul>
				<li><a href="#"
					onclick="quick_settings_apply('button_button');return false;"> <span
						class="icon"><i class="fa fa-square fa-lg"></i></span><span
						class="text">Activate social share button with icon and text</span>
						<div class="clear"></div> <span class="label">This will change the
							look of button to display icon and network name in share button</span></a>
				</li>
				<li><a href="#"
					onclick="quick_settings_apply('button_icon');return false;"> <span
						class="icon"><i class="fa fa-square fa-lg"></i></span><span
						class="text">Activate social share button with icon only</span>
						<div class="clear"></div> <span class="label">This will change the
							look of button to display icon only in share button</span></a></li>
				<li><a href="#"
					onclick="quick_settings_apply('button_icon_name');return false;"> <span
						class="icon"><i class="fa fa-square fa-lg"></i></span><span
						class="text">Activate social share button with icon and text on
							icon hover</span>
						<div class="clear"></div> <span class="label">This will change the
							look of button to display icon and network name that appear only
							when you hover button</span></a></li>
				<li><a href="#"
					onclick="quick_settings_apply('button_button_name');return false;">
						<span class="icon"><i class="fa fa-square fa-lg"></i></span><span
						class="text">Activate social share button with text only</span>
						<div class="clear"></div> <span class="label">This will change the
							look of button to display network name only in share button</span>
				</a></li>
			</ul>
			<h3>Quick change counter settings</h3>
			<ul>
				<li><a href="#"
					onclick="quick_settings_apply('counter_deactivate');return false;">
						<span class="icon"><i class="fa fa-spinner fa-lg"></i></span><span
						class="text">Deactivate counters</span>
						<div class="clear"></div> <span class="label">This will hide
							counters of sharing and total counter</span>
				</a></li>
				<li><a href="#"
					onclick="quick_settings_apply('counter_both');return false;"> <span
						class="icon"><i class="fa fa-spinner fa-lg"></i></span><span
						class="text">Display total counter and button counter </span>
						<div class="clear"></div> <span class="label">This will display
							both total counter and button share counter</span></a></li>
				<li><a href="#"
					onclick="quick_settings_apply('counter_total');return false;"> <span
						class="icon"><i class="fa fa-spinner fa-lg"></i></span><span
						class="text">Display only total counter</span>
						<div class="clear"></div> <span class="label">This option will
							hide button counters and display only total counter</span></a></li>
				<li><a href="#"
					onclick="quick_settings_apply('counter_button');return false;"> <span
						class="icon"><i class="fa fa-spinner fa-lg"></i></span><span
						class="text">Display only button counter </span>
						<div class="clear"></div> <span class="label">This will hide total
							counter and display only button counter</span></a></li>
			</ul>
			<h3>Performance</h3>
			<ul>
				<li><a href="#"
					onclick="quick_settings_apply('performance_minified');return false;">
						<span class="icon"><i class="fa fa-dashboard fa-lg"></i></span><span
						class="text">Optimize load of plugin resources (javascript and
							CSS)</span>
						<div class="clear"></div> <span class="label">This option will
							activate load of minified version of resources, script sources
							will be loaded in async mode.</span>
				</a></li>
				<li><a href="#"
					onclick="quick_settings_apply('performance_cache');return false;">
						<span class="icon"><i class="fa fa-dashboard fa-lg"></i></span><span
						class="text">Activate build in cache</span>
						<div class="clear"></div> <span class="label">Activating build in
							cache will reduce time for generation as it will serve already
							generated static versions of buttons. If cache is active dynamic
							plugin resources will be served from static external files.</span>
				</a></li>
				<li><a href="#"
					onclick="quick_settings_apply('performance_cache');return false;">
						<span class="icon"><i class="fa fa-dashboard fa-lg"></i></span><span
						class="text">Activate build in cache and static resource join (max
							mode)</span>
						<div class="clear"></div> <span class="label">Activating build in
							cache will reduce time for generation as it will serve already
							generated static versions of buttons. If cache is active dynamic
							plugin resources will be served from static external files. All
							plugin static files will be combined to narrow down included
							resource files.</span>
				</a></li>
			</ul>

		</div>
	</div>

	<div id="quick-fix" style="display: none;">

		<div class="essb-quick-apply">
			<h3>Social Share Problems</h3>
			<ul>
				<li><a href="#"
					onclick="quick_settings_apply('fix_og'); return false;"> <span
						class="icon"><i class="fa fa-check-circle-o fa-lg"></i></span><span
						class="text">Problem with shared information on social networks</span>
						<div class="clear"></div> <span class="label">To personalize
							shared information and avoid strange messages it is strongly
							recommended to use meta tag optimization. If you do not use any
							SEO plugin or your theme does not support them click here to
							activate generation of those meta tags.</span></a></li>
			</ul>
			<h3>Counter problems</h3>
			<ul>
				<li><a href="#"
					onclick="quick_settings_apply('fix_zerocounter'); return false;"> <span
						class="icon"><i class="fa fa-check-circle-o fa-lg"></i></span><span
						class="text">Counters reset and start from zero</span>
						<div class="clear"></div> <span class="label">This usually is
							result of using short url option applied for all social networks.
							Social networks does not follow redirects from short links. Click
							here to deactivate this and apply recommended options.</span></a>
				</li>
				<li><a href="#"
					onclick="quick_settings_apply('fix_missingcounter'); return false;">
						<span class="icon"><i class="fa fa-check-circle-o fa-lg"></i></span><span
						class="text">Counter for Google is missing</span>
						<div class="clear"></div> <span class="label">Not all networks has
							native access to counter API. If you do not see counters for
							example for Google click here to fix this.</span>
				</a></li>
				<li><a href="#"
					onclick="quick_settings_apply('fix_nocounter'); return false;"> <span
						class="icon"><i class="fa fa-check-circle-o fa-lg"></i></span><span
						class="text">Some social networks do not display counters</span>
						<div class="clear"></div> <span class="label">There are social
							networks that does not provide access to counters. For those we
							emulate counter inside WordPress. Click here to activate this
							option (example of such networks: WhatsApp, Tumblr).</span></a></li>
			</ul>
			<h3>Button problems</h3>
			<ul>
				<li><a href="#"
					onclick="quick_settings_apply('fix_yoast'); return false;"> <span
						class="icon"><i class="fa fa-check-circle-o fa-lg"></i></span><span
						class="text">When I click on share button window does not open
							properly</span>
						<div class="clear"></div> <span class="label">This usually is
							result of another plugin that breaks the load of share window.
							Click here to apply fix for this.</span></a></li>
			</ul>
		</div>
	</div>

	<!--  code mirror include -->
	<link rel=stylesheet
		href="<?php echo ESSB_PLUGIN_URL?>/assets/codemirror/codemirror.css">
	<script
		src="<?php echo ESSB_PLUGIN_URL?>/assets/codemirror/codemirror.js"></script>
	<script
		src="<?php echo ESSB_PLUGIN_URL?>/assets/codemirror/mode/xml/xml.js"></script>
	<script
		src="<?php echo ESSB_PLUGIN_URL?>/assets/codemirror/mode/javascript/javascript.js"></script>
	<script
		src="<?php echo ESSB_PLUGIN_URL?>/assets/codemirror/mode/css/css.js"></script>
	<script
		src="<?php echo ESSB_PLUGIN_URL?>/assets/codemirror/mode/htmlmixed/htmlmixed.js"></script>
	<script
		src="<?php echo ESSB_PLUGIN_URL?>/assets/codemirror/addon/edit/matchbrackets.js"></script>
	<script
		src="<?php echo ESSB_PLUGIN_URL?>/assets/codemirror/addon/edit/closebrackets.js"></script>
	<script
		src="<?php echo ESSB_PLUGIN_URL?>/assets/codemirror/addon/edit/matchtags.js"></script>
	<script
		src="<?php echo ESSB_PLUGIN_URL?>/assets/codemirror/addon/edit/closetag.js"></script>
	<script
		src="<?php echo ESSB_PLUGIN_URL?>/assets/codemirror/addon/fold/foldcode.js"></script>
	<script
		src="<?php echo ESSB_PLUGIN_URL?>/assets/codemirror/addon/fold/foldgutter.js"></script>
	<script
		src="<?php echo ESSB_PLUGIN_URL?>/assets/codemirror/addon/fold/indent-fold.js"></script>
	<script
		src="<?php echo ESSB_PLUGIN_URL?>/assets/codemirror/addon/fold/xml-fold.js"></script>
	<script
		src="<?php echo ESSB_PLUGIN_URL?>/assets/codemirror/addon/fold/brace-fold.js"></script>
	<script
		src="<?php echo ESSB_PLUGIN_URL?>/assets/codemirror/addon/fold/comment-fold.js"></script>

	<?php
}
?>
</div>
<div class="clear"></div>
<?php if ($welcome_active) { ?>
<div class="wrap" id="essb-welcome">
	<div class="welcome-panel essb-welcome-panel" id="welcome-panel">
		<a class="welcome-panel-close"
			href="<?php echo $current_admin_url;?>&welcome=0">Close welcome panel</a>

		<div class="welcome-panel-content">
			<div class="welcome-panel-column-container">
				<div class="welcome-panel-column">
					<h4>Get Started</h4>
					<a
						class="button button-primary button-hero load-customize hide-if-no-customize"
						href="<?php echo admin_url ( 'admin.php?page=essb_settings&tab=wizard' ); ?>">Customize
						Display Using Configuration Wizard</a>
					<p class="hide-if-no-customize">
						or, <a
							href="<?php echo admin_url ( 'admin.php?page=essb_settings&tab=backup&section=2' ); ?>">import
							ready made configurations (Upworthy style, Mashable Style,
							Default Plugin Demo, AddThis, CopyBlogger or Your own backup of settings)</a>
					</p>
				</div>
				<div class="welcome-panel-column">
					<h4>More Actions</h4>
					<ul class="essb-welcome-list">
						<li><a
							href="http://codecanyon.net/user/appscreo/portfolio?ref=appscreo"
							target="_blank"><i class="fa fa-check-square-o fa-essb-welcome"></i>Check
								out our product portfolio</a></li>
						<li><a
							href="<?php echo admin_url ( 'admin.php?page=essb_settings&tab=update' ); ?>"><i
								class="fa fa-refresh fa-essb-welcome"></i>Activate automatic
								update</a></li>

						<li><a href="http://codecanyon.net/downloads" target="_blank"><i
								class="fa fa-star fa-essb-welcome"></i>Rate Easy Social Share
								Buttons for WordPress</a></li>
					</ul>
				</div>
				<div class="welcome-panel-column welcome-panel-last">
					<h4>Support</h4>
					<ul class="essb-welcome-list">
						<li><a
							href="http://support.creoworx.com/section/easy-social-share-buttons-for-wordpress/how-to-work-with-easy-social-share-buttons/"
							target="_blank"><i
								class="fa fa-external-link-square fa-essb-welcome"></i>Read
								plugin documentation</a></li>
						<li><a
							href="http://support.creoworx.com/section/easy-social-share-buttons-for-wordpress/shortcodes/"
							target="_blank"><i class="fa fa-code fa-essb-welcome"></i>Read
								shortcodes documentation</a></li>
						<li><a
							href="http://support.creoworx.com/forums/forum/wordpress-plugins/easy-social-share-buttons/"
							target="_blank"><i class="fa fa-question-circle fa-essb-welcome"></i>Need
								Help? Visit our support site</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>

<?php } ?>

<div class="" id="essb-scroll-top"></div>

<?php

switch ($current_tab) :
	case "general" :
		include (ESSB_PLUGIN_ROOT . '/lib/admin/pages/essb-settings-general.php');
		
		break;
	case "display" :
		include (ESSB_PLUGIN_ROOT . '/lib/admin/pages/essb-settings-display.php');
		
		break;
	case "shortcode" :
		include (ESSB_PLUGIN_ROOT . '/lib/admin/pages/essb-settings-shortcode.php');
		
		break;
	case "shortcode2" :
		include (ESSB_PLUGIN_ROOT . '/lib/admin/pages/essb-settings-shortcode2.php');
		
		break;
	case "backup" :
		include (ESSB_PLUGIN_ROOT . '/lib/admin/pages/essb-settings-backup.php');
		
		break;
	case "stats" :
		include (ESSB_PLUGIN_ROOT . '/lib/admin/pages/essb-settings-stats.php');
		
		break;
	case "update" :
		include (ESSB_PLUGIN_ROOT . '/lib/admin/pages/essb-settings-autoupdate.php');
		
		break;
	case "customizer" :
		include (ESSB_PLUGIN_ROOT . '/lib/admin/pages/essb-settings-customize.php');
		
		break;
	case "fans" :
		include (ESSB_PLUGIN_ROOT . '/lib/admin/pages/essb-settings-fans.php');
		break;
	case "wizard" :
		// include (ESSB_PLUGIN_ROOT .
		// '/lib/admin/pages/essb-settings-wizard.php');
		break;
endswitch
;

?>

<script type="text/javascript">

function quick_settings_apply(oKey) {
	window.location='<?php admin_url()?>admin.php?page=essb_settings&tab=<?php echo $current_tab; ?>&apply_setting='+oKey;
}

function quick_admin_redirect(oKey) {
	window.location='<?php admin_url()?>'+oKey;
}

</script>