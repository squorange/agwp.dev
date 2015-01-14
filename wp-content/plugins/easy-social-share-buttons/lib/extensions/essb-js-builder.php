<?php

class ESSB_JS_Buider {
	private static $instance = null;
	
	private $js_builder;
	private $js_lazyload;
	private $js_socialscripts;	
	
	private $included_window_script = false;
	private $included_ga_script = false;
	private $included_mail_script = false;
	
	public $load_async = false;
	public $load_defer = false;
	
	public $deactivate_auto = false;
	
	private $options;
	
	public static function get_instance() {
	
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	
	} // end get_instance;
	
	function __construct() {
		$this->js_builder = array();
		$this->js_lazyload = array();
		$this->js_socialscripts = array();
		
		$essb_options = EasySocialShareButtons_Options::get_instance();
		$this->options = $essb_options->options;
		
		
		add_action('wp_footer', array($this, 'generate_custom_js'), 12);
	}
	
	public function remove_hook() {
		remove_action('wp_footer', array($this, 'generate_custom_js'), 12);
		$this->deactivate_auto = true;
	}
	
	public function register_footer_load() {
		if ($this->deactivate_auto) {
			add_action('wp_footer', array($this, 'generate_custom_js'), 12);
		}
	}
	
	/**
	 * Custom Javascript injection function into page footer
	 * @since 1.3.9.8
	 * @update 2.0 added support for cache include
	 */
	public function generate_custom_js() {
		global $post;
		if (count($this->js_lazyload) > 0) {
		
			//echo '<!-- easy-async-scripts-ver-'.ESSB_VERSION. '-->';
			echo '<script type="text/javascript">';
		
			$list = array_unique($this->js_lazyload);
		
			foreach ($list as $script) {
				if ($this->load_defer) {
					echo '
					(function() {
					var po = document.createElement(\'script\'); po.type = \'text/javascript\'; po.defer = true;
					po.src = \''.$script.'\';
					var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(po, s);
					})();';
						
				}
				else {
				echo '
				(function() {
				var po = document.createElement(\'script\'); po.type = \'text/javascript\'; po.async = true;
				po.src = \''.$script.'\';
				var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(po, s);
				})();';
				}
			}
		
			echo '</script>';
		}
				
		// social scripts are loaded at the end
		if (count($this->js_socialscripts) > 0) {
			//echo '<!-- easy-social-scripts-ver-'.ESSB_VERSION. '-->';
				
			foreach ($this->js_socialscripts as $key => $code) {
				echo $code;
			}
		}
		
		if (count($this->js_builder) > 0) {
			//echo '<!-- easy-inline-scripts-ver-'.ESSB_VERSION. '-->';
			

			if (isset($post)) {
				if (defined('ESSB_CACHE_ACTIVE_RESOURCE')) {
					$cache_key = "essb_inline_scripts_".$post->ID;				
				
					$cached_data = ESSBCache::get_resource($cache_key, 'js');
				
					if ($cached_data != '') {
						echo "<script type='text/javascript' src='".$cached_data."' defer></script>"; 
						return;
					}
				}
			}
			
			
			$inline_scritps = "";
			foreach ($this->js_builder as $singleCode) {
				//$singleCode = trim(preg_replace('/\s+/', ' ', $singleCode));
				$inline_scritps .= $singleCode;
			}
			
			if (isset($post)) {
				if (defined('ESSB_CACHE_ACTIVE_RESOURCE')) {
					$cache_key = "essb_inline_scripts_".$post->ID;
						
					ESSBCache::put_resource($cache_key, $inline_scritps, 'js');

					$cached_data = ESSBCache::get_resource($cache_key, 'js');
				
					if ($cached_data != '') {
						echo "<script type='text/javascript' src='".$cached_data."' defer></script>"; 
						return;
					}
				}
			}
			echo '<script type="text/javascript">';
			echo $inline_scritps;
			echo '</script>';
			
		}
			
	}
	
	// @since 1.3.9.9 add key to load
	public function add_js_lazyload ($file, $key = '') {
		if ($key != '') {
			$this->js_lazyload[$key] = $file;
		}
		else {
			$this->js_lazyload[] = $file;
		}
	}
	
	public function add_js_code($js, $clean_new_lines = false, $key = '') {
		if ($clean_new_lines) {
			$js = trim(preg_replace('/\s+/', ' ', $js));
		}
		if ($key != '') {
			$this->js_builder[$key] = $js;
		}
		else {
			$this->js_builder[] = $js;
		}
		
	}
	
	public function include_ga_tracking_code($ga_type) {
		
		//if($this->included_ga_script) { return; }
		
		$js_code = '
			function essb_ga_tracking(oService, oPosition, oURL) {
				var essb_ga_type = "'.$ga_type.'";
				
				if ( \'ga\' in window && window.ga !== undefined && typeof window.ga === \'function\' ) {
					if (essb_ga_type == "extended") {
						ga(\'send\', \'event\', \'social\', oService + \' \' + oPosition, oURL);
					}
					else {
						ga(\'send\', \'event\', \'social\', oService, oURL);
					}
				}
			}
		';

		$this->add_js_code($js_code, false, 'essb_ga_code');
		$this->included_ga_script = true;
	}
	
	public function include_share_window_script() {
		
		//if ($this->included_window_script) { return; }
		
		$this->add_js_code('var wnd;', false, 'essb_wnd1');
		$this->add_js_code('function essb_window_stat(oUrl, oService, oCountID) { var wnd; var w = 800 ; var h = 500;  if (oService == "twitter") { w = 500; h= 300; } var left = (screen.width/2)-(w/2); var top = (screen.height/2)-(h/2); if (oService == "twitter") { wnd = window.open( oUrl, "essb_share_window", "height=300,width=500,resizable=1,scrollbars=yes,top="+top+",left="+left ); }  else { wnd = window.open( oUrl, "essb_share_window", "height=500,width=800,resizable=1,scrollbars=yes,top="+top+",left="+left ); } essb_handle_stats(oService, oCountID); essb_self_postcount(oService, oCountID); var pollTimer = window.setInterval(function() {if (wnd.closed !== false) { window.clearInterval(pollTimer); essb_smart_onclose_events(oService, oCountID);}}, 200);  }; ', false, 'essb_Wnd2');
		$this->add_js_code("function essb_pinterenst_stat(oCountID) { essb_handle_stats('pinterest', oCountID); var e=document.createElement('script');e.setAttribute('type','text/javascript');e.setAttribute('charset','UTF-8');e.setAttribute('src','//assets.pinterest.com/js/pinmarklet.js?r='+Math.random()*99999999);document.body.appendChild(e)};", false, 'essb_wnd3');
		$this->add_js_code('function essb_window(oUrl, oService, oCountID) { var wnd; var w = 800 ; var h = 500;  if (oService == "twitter") { w = 500; h= 300; } var left = (screen.width/2)-(w/2); var top = (screen.height/2)-(h/2);  if (oService == "twitter") { wnd = window.open( oUrl, "essb_share_window", "height=300,width=500,resizable=1,scrollbars=yes,top="+top+",left="+left ); }  else { wnd = window.open( oUrl, "essb_share_window", "height=500,width=800,resizable=1,scrollbars=yes,top="+top+",left="+left ); } essb_self_postcount(oService, oCountID); var pollTimer = window.setInterval(function() {if (wnd.closed !== false) { window.clearInterval(pollTimer); essb_smart_onclose_events(oService, oCountID);}}, 200); };', false, 'essb_wnd4');
		$this->add_js_code("function essb_pinterenst() {var e=document.createElement('script');e.setAttribute('type','text/javascript');e.setAttribute('charset','UTF-8');e.setAttribute('src','//assets.pinterest.com/js/pinmarklet.js?r='+Math.random()*99999999);document.body.appendChild(e)};", false, 'essb_wnd5');
		$this->add_js_code("var essb_count_data = {
				'ajax_url': '" . admin_url ('admin-ajax.php') . "'
		};", false, 'essb_wnd6');
		
		$this->add_js_code('function essb_smart_onclose_events(oService, oPostID) { if (typeof essbasc_popup_show == \'function\') {   essbasc_popup_show(); } if (typeof essb_acs_code == \'function\') {   essb_acs_code(oService, oPostID); } }', false, 'essb_wnd7');
		
		//$this->included_window_script = true;
	}
	
	/* social media scripts */
	
	public function include_fb_script() {
		
		$option = get_option ( EasySocialShareButtons::$plugin_settings_name );
		$lang = isset($option['native_social_language']) ? $option['native_social_language'] : "en";
		
		$fb_appid = isset($option['facebookadvancedappid']) ? $option['facebookadvancedappid'] : "";
		
		$async_load = isset($option['facebook_like_button_api_async']) ? $option['facebook_like_button_api_async'] : 'false';
		
		if ($lang == "") {
			$lang = "en";
		}
		
		$code = $lang ."_" . strtoupper($lang);
		if ($lang == "en") {
			$code = "en_US";
		}
		
		$this->js_socialscripts['fb'] = $this->generate_fb_script($code, $fb_appid, $async_load);
	}
	
	public function generate_fb_script_inline() {
		$option = get_option ( EasySocialShareButtons::$plugin_settings_name );
		$lang = isset($option['native_social_language']) ? $option['native_social_language'] : "en";
		
		$fb_appid = isset($option['facebookadvancedappid']) ? $option['facebookadvancedappid'] : "";
		$async_load = isset($option['facebook_like_button_api_async']) ? $option['facebook_like_button_api_async'] : 'false';
		
		if ($lang == "") {
			$lang = "en";
		}
		
		$code = $lang ."_" . strtoupper($lang);
		if ($lang == "en") {
			$code = "en_US";
		}
		
		return $this->generate_fb_script($code, $fb_appid, $async_load);
	}
	
	public function generate_fb_script($lang = 'en_US', $app_id = '', $async_load = 'false') {
		if ($app_id != '') {
			$app_id = "&appId=".$app_id;
		}
		
		$js_async = "";
		if ($async_load == 'true') {
			$js_async = " js.async = true;";
		}
		
		$result = '<div id="fb-root"></div>
		<script>(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id; '.$js_async.'
		js.src = "//connect.facebook.net/'.$lang.'/sdk.js#version=v2.0&xfbml=1'.$app_id.'"
		fjs.parentNode.insertBefore(js, fjs);
		}(document, \'script\', \'facebook-jssdk\'));</script>';
		
		return $result;
	}
	
	public function generate_gplus_script() {
	
		$script = '	
		<script type="text/javascript">
		(function() {
		var po = document.createElement(\'script\'); po.type = \'text/javascript\'; po.async = true;
		po.src = \'https://apis.google.com/js/platform.js\';
		var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(po, s);
	})();
	</script>';
	
		return $script;
	}
	
	public function include_gplus_script() {
		$this->js_socialscripts['gplus'] = $this->generate_gplus_script();	
	}
	
	public function include_vk_script () {
		$option = get_option ( EasySocialShareButtons::$plugin_settings_name );
		
		$vkapp_id = isset($option['vklikeappid']) ? $option['vklikeappid'] : '';
		$this->js_socialscripts['vk'] = $this->generate_vk_script($vkapp_id);
	}
	
	public function generate_vk_script($appid = '') {
		$script = '<script type="text/javascript" src="//vk.com/js/api/openapi.js?115"></script>
<script type="text/javascript">
  VK.init({apiId: '.$appid.', onlyWidgets: true});
</script>';

		return $script;
	
	}
	
	public function generate_popup_mailform() {
	
		//if ($this->included_mail_script) { return; }
		
		$salt = mt_rand ();
		$mailform_id = 'essb_mail_from_'.$salt;
	
		$options = $this->options;
		$translate_mail_title = isset($options['translate_mail_title']) ? $options['translate_mail_title'] : '';
		$translate_mail_email = isset($options['translate_mail_email']) ? $options['translate_mail_email'] : '';
		$translate_mail_recipient = isset($options['translate_mail_recipient']) ? $options['translate_mail_recipient'] : '';
		$translate_mail_subject = isset($options['translate_mail_subject']) ? $options['translate_mail_subject'] : '';
		$translate_mail_message = isset($options['translate_mail_message']) ? $options['translate_mail_message'] : '';
		$translate_mail_cancel = isset($options['translate_mail_cancel']) ? $options['translate_mail_cancel'] : '';
		$translate_mail_send = isset($options['translate_mail_send']) ? $options['translate_mail_send'] : '';
		
		$mail_disable_editmessage = isset($options['mail_disable_editmessage']) ? $options['mail_disable_editmessage'] : 'false';
		
		$mail_edit_readonly = "";
		if ($mail_disable_editmessage == "true") {
			$mail_edit_readonly = ' readonly="readonly"';
		}
	
		$mail_captcha = isset($options['mail_captcha']) ? $options['mail_captcha'] : '';
		$mail_captcha_answer = isset($options['mail_captcha_answer']) ? $options['mail_captcha_answer'] : '';
	
		$captcha_html = '';
		if ($mail_captcha != '' && $mail_captcha_answer != '') {
			$captcha_html = '\'<div class="vex-custom-field-wrapper"><strong>'.$mail_captcha.'</strong></div><input name="captchacode" type="text" placeholder="Captcha Code" />\'+';
		}
	
	
		$siteurl = ESSB_PLUGIN_URL. '/';
		//$open = 'javascript:PopupContact_OpenForm("PopupContact_BoxContainer","PopupContact_BoxContainerBody","PopupContact_BoxContainerFooter");';
	
		$html = 'function essb_mailer(oTitle, oMessage, oSiteTitle, oUrl, oImage, oPermalink) {
		vex.defaultOptions.className = \'vex-theme-os\';
		vex.dialog.open({
		message: \''.($translate_mail_title != '' ? $translate_mail_title : 'Share this with a friend').'\',
		input: \'\' +
		\'<div class="vex-custom-field-wrapper"><strong>'. ($translate_mail_email != '' ? $translate_mail_email : 'Your Email').'</strong></div>\'+
		\'<input name="emailfrom" type="text" placeholder="'. ($translate_mail_email != '' ? $translate_mail_email : 'Your Email').'" required />\' +
		\'<div class="vex-custom-field-wrapper"><strong>'.($translate_mail_recipient != '' ? $translate_mail_recipient : 'Recipient Email'). '</strong></div>\'+
		\'<input name="emailto" type="text" placeholder="'.($translate_mail_recipient != '' ? $translate_mail_recipient : 'Recipient Email'). '" required />\' +
		\'<div class="vex-custom-field-wrapper" style="border-bottom: 1px solid #aaa !important; margin-top: 10px;"><h3></h3></div>\'+
		\'<div class="vex-custom-field-wrapper" style="margin-top: 10px;"><strong>'.($translate_mail_subject != '' ? $translate_mail_subject : 'Subject').'</strong></div>\'+
		\'<input name="emailsubject" type="text" placeholder="Subject" required value="\'+oTitle+\'" />\' +
		\'<div class="vex-custom-field-wrapper" style="margin-top: 10px;"><strong>'.($translate_mail_message != '' ? $translate_mail_message : 'Message').'</strong></div>\'+
		\'<textarea name="emailmessage" placeholder="Message" required" rows="6" '.$mail_edit_readonly.'>\'+oMessage+\'</textarea>\' +
		'.$captcha_html. '
		\'\',
		buttons: [
		jQuery.extend({}, vex.dialog.buttons.YES, { text: \''.($translate_mail_send != '' ? $translate_mail_send : 'Send').'\' }),
		jQuery.extend({}, vex.dialog.buttons.NO, { text: \''.($translate_mail_cancel != '' ? $translate_mail_cancel : 'Cancel').'\' })
		],
		callback: function (data) {
		if (data.emailfrom && typeof(data.emailfrom) != "undefined") {
		var c = typeof(data.captchacode) != "undefined" ? data.captchacode : "";
		essb_sendmail_ajax'.$salt.'(data.emailfrom, data.emailto, data.emailsubject, data.emailmessage, c, oSiteTitle, oUrl, oImage, oPermalink);
	}
	}
	
	});
	};
	function essb_sendmail_ajax'.$salt.'(emailfrom, emailto, emailsub, emailmessage, c, oSiteTitle, oUrl, oImage, oPermalink) {
	
	var get_address = "' . ESSB_PLUGIN_URL . '/public/essb-mail.php?from="+emailfrom+"&to="+emailto+"&sub="+emailsub+"&message="+emailmessage+"&t="+oSiteTitle+"&u="+oUrl+"&img="+oImage+"&p="+oPermalink+"&c="+c;
	jQuery.getJSON(get_address)
	.done(function(data){
	alert(data.message);
	});
	};
	';
	
		$this->included_mail_script = true;
		$this->add_js_code($html, true, 'essb_mail');
	}
	
	public function include_postfloat_scroll_script($value) {
		$value = str_replace('%', '' , $value);
		
		$js_code = "jQuery(document).ready(function($){
		
		$(window).scroll(essb_sidebar_onscroll);
		
		function essb_sidebar_onscroll() {
			var current_pos = $(window).scrollTop();
			var height = $(document).height()-$(window).height();
			var percentage = current_pos/height*100;
		
			var value_bottom = '".$value."';		
		
			var display_state = (percentage > parseInt('".$value."')) ? true : false;
		
			if ($('.essb_displayed_postfloat').length && value_bottom != '') {
				if (display_state) {
					$('.essb_displayed_postfloat').show('fast');
				}
				else {
					$('.essb_displayed_postfloat').hide('fast');
				}
			}
		}
		});
		";
		
		// clean new lines
		$js_code = trim(preg_replace('/\s+/', ' ', $js_code));
		
		$this->add_js_code($js_code, false, 'essb_postfloat_onscroll');
	}
}

?>