<?php

class ESSBAfterCloseShare {
	static $instance;
	
	private $options;
	
	public $version = "";
	
	protected  $essb_js_builder;
	protected $load_js_async = false;
	
	function __construct() {
		$essb_options = EasySocialShareButtons_Options::get_instance();
		$this->options = $essb_options->options;
		
		$is_active = ESSBOptionsHelper::optionsBoolValue($this->options, 'afterclose_active');
		$is_active_option = "";
		if (ESSB_DEMO_MODE) {
			$is_active_option = isset($_REQUEST['aftershare']) ? $_REQUEST['aftershare'] : '';
			if ($is_active_option != '') {
				$is_active = true;
			}
		}
		
		if ($is_active) {
			$this->load_js_async = ESSBOptionsHelper::optionsBoolValue($this->options, 'load_js_async');
			$this->load($is_active_option);
		}
	}
	
	public static function instance() {
	
		if ( ! self::$instance )
			self::$instance = new ESSBAfterCloseShare();
	
		return self::$instance;	
	}
	
	private function load($demo_mode = '') {
		$this->essb_js_builder = ESSB_JS_Buider::get_instance();
		$acs_type = ESSBOptionsHelper::optionsValue($this->options, 'afterclose_type');
		
		if ($demo_mode != '') {
			$acs_type = $demo_mode;
		}
		
		switch ($acs_type) {
			case "follow":
				add_action ( 'wp_enqueue_scripts', array ($this, 'register_asc_assets' ), 999 );
				add_action ( 'wp_footer', array ($this, 'generateFollowWindow' ), 999 );
				break;				
			case "message":
				add_action ( 'wp_enqueue_scripts', array ($this, 'register_asc_assets' ), 999 );
				add_action ( 'wp_footer', array ($this, 'generateMessageText' ), 999 );
				break;
			case "code":
				$this->generateMessageCode();
				break;			
		}
	}
	
	public function register_asc_assets() {
		$scripts_in_head = isset($this->options['scripts_in_head']) ? $this->options['scripts_in_head'] : 'false';
			
		$load_footer = ($scripts_in_head == 'true') ? false : true;
		wp_enqueue_style ( 'easy-social-share-buttons-popupasc', ESSB_PLUGIN_URL . '/assets/css/essb-after-share-close.css', false, '', 'all' );
		if (!$this->load_js_async) {
			wp_enqueue_script ( 'essb-aftershare-close-script', ESSB_PLUGIN_URL . '/assets/js/essb-after-share-close.js', array ( 'jquery' ), $this->version, $load_footer );
		}
		else {
			$this->essb_js_builder->add_js_lazyload(ESSB_PLUGIN_URL . '/assets/js/essb-after-share-close.js', 'essb-aftershare-close-script');
		}		
	}
	
	public function generateMessageCode() {
		$user_js_code = ESSBOptionsHelper::optionsValue($this->options, 'afterclose_code_text');
		
		if ($user_js_code != '') {
			$this->essb_js_builder->add_js_code('function essb_acs_code(oService, oPostID) { '.$user_js_code.' }', false, 'essb_acs_code');
		}
	} 
	
	public function generateFollowButton($social_code, $network_key, $icon_key) {
		$output = '';
		
		$output .= '<div class="essbasc-fans-single essbasc-fans-'.$network_key.'">
				<div class="essbasc-fans-icon">
					<i class="essbasc-fans-icon-'.$icon_key.'"></i>
				</div>
				<div class="essbasc-fans-text">
		'.$social_code.'
		</div>
		</div>';
		
		return $output;
	}
	
	public function generateFollowWindow() {
		
		$afterclose_like_text = ESSBOptionsHelper::optionsValue($this->options, 'afterclose_like_text');
		$afterclose_like_fb_like_url = ESSBOptionsHelper::optionsValue($this->options, 'afterclose_like_fb_like_url');
		$afterclose_like_fb_follow_url = ESSBOptionsHelper::optionsValue($this->options, 'afterclose_like_fb_follow_url');
		$afterclose_like_google_url = ESSBOptionsHelper::optionsValue($this->options, 'afterclose_like_google_url');
		$afterclose_like_google_follow_url = ESSBOptionsHelper::optionsValue($this->options, 'afterclose_like_google_follow_url');
		$afterclose_like_twitter_profile = ESSBOptionsHelper::optionsValue($this->options, 'afterclose_like_twitter_profile');
		$afterclose_like_pin_follow_url = ESSBOptionsHelper::optionsValue($this->options, 'afterclose_like_pin_follow_url');
		$afterclose_like_youtube_channel = ESSBOptionsHelper::optionsValue($this->options, 'afterclose_like_youtube_channel');
		$afterclose_like_linkedin_company = ESSBOptionsHelper::optionsValue($this->options, 'afterclose_like_linkedin_company');
		
		$afterclose_like_cols = ESSBOptionsHelper::optionsValue($this->options, 'afterclose_like_cols', 'onecol');
				
		// Facebook Follow Button
		
		$widget = "";
		
		if ($afterclose_like_text != '') {
			$widget .= '<div class="essbasc-text-before">'.$afterclose_like_text.'</div>';
		}
		
		$widget .= '<div class="essbasc-fans '.$afterclose_like_cols.'">';
		
		if ($afterclose_like_fb_like_url != '') {
			$this->essb_js_builder->include_fb_script();
			$social_code = '<div class="fb-like" data-href="'.$afterclose_like_fb_like_url.'" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>';
			$widget .= $this->generateFollowButton($social_code, 'facebook', 'facebook');
		}
		if ($afterclose_like_fb_follow_url != '') {
			$this->essb_js_builder->include_fb_script();
			$social_code = '<div class="fb-follow" data-href="'.$afterclose_like_fb_follow_url.'" data-colorscheme="light" data-layout="button_count" data-show-faces="true"></div>';
			$widget .= $this->generateFollowButton($social_code, 'facebook', 'facebook');
		}
		if ($afterclose_like_google_url != '') {
			$this->essb_js_builder->include_gplus_script();
			$social_code = '<div class="g-plusone" data-size="medium" data-href="'.$afterclose_like_google_url.'"></div>';
			$widget .= $this->generateFollowButton($social_code, 'google', 'gplus');
		}
		if ($afterclose_like_google_follow_url != '') {
			$this->essb_js_builder->include_gplus_script();
			$social_code = '<div class="g-follow" data-annotation="bubble" data-height="20" data-href="'.$afterclose_like_google_follow_url.'" data-rel="author"></div>';
			$widget .= $this->generateFollowButton($social_code, 'google', 'gplus');
		}
		if ($afterclose_like_twitter_profile != '') {
			$social_code = '<a href="https://twitter.com/'.$afterclose_like_twitter_profile.'" class="twitter-follow-button" data-show-count="true" data-show-screen-name="false">Follow @'.$afterclose_like_twitter_profile.'</a>';
			$social_code .= "<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>";
			$widget .= $this->generateFollowButton($social_code, 'twitter', 'twitter');
		}	
		if ($afterclose_like_pin_follow_url != '') {
			$this->essb_js_builder->add_js_lazyload('//assets.pinterest.com/js/pinit.js', 'api_pinfollow');
			$social_code = '<a data-pin-do="buttonFollow" href="'.$afterclose_like_pin_follow_url.'">'.'Follow'.'</a>';
			$widget .= $this->generateFollowButton($social_code, 'pinterest', 'pinterest');
		}	
		if ($afterclose_like_youtube_channel != '') {
			$this->essb_js_builder->include_gplus_script();
			$social_code = '<div class="g-ytsubscribe" data-channelid="'.$afterclose_like_youtube_channel.'" data-layout="default" data-count="default"></div>';
			$widget .= $this->generateFollowButton($social_code, 'youtube', 'youtube');				
		}
		if ($afterclose_like_linkedin_company != '') {
			$social_code = '<script src="//platform.linkedin.com/in.js" type="text/javascript">lang: en_US</script><script type="IN/FollowCompany" data-id="'.$afterclose_like_linkedin_company.'" data-counter="right"></script>';
			$widget .= $this->generateFollowButton($social_code, 'linkedin', 'linkedin');				
		}
		
		$widget .= '</div>';
		
		//$widget .= '<div class="essbasc-text-after">&nbsp;</div>';
		
		$this->popupWindowGenerate($widget, '');
	}
	
	public function generateMessageText() {
		$user_html_code = ESSBOptionsHelper::optionsValue($this->options, 'afterclose_message_text');
		$user_html_code = stripslashes($user_html_code);
		
		$user_html_code = do_shortcode($user_html_code);
		
		$this->popupWindowGenerate($user_html_code);
	}
	
	public function popupWindowGenerate($html, $force_width = '') {
		
		$popup_width = ESSBOptionsHelper::optionsValue($this->options, 'afterclose_popup_width', '400');
		
		if (trim($popup_width) == '') { $popup_width = '400'; }
		
		if ($force_width != '') { $popup_width = $force_width; }
		
		echo '<div class="essbasc-popup" data-popup-width="'.$popup_width.'">';
		echo '<div class="essbasc-popup-content">';
		echo $html;
		echo '</div>';
		
		echo '<a href="#" class="essbasc-popup-close" onclick="essbasc_popup_close(); return false;"></a>';
		echo '</div>';
		echo '<div class="essbasc-popup-shadow"></div>';
	}
}

?>