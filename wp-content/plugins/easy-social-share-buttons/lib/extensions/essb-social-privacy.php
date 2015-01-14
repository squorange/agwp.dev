<?php

/**
 * ESSB_Social_Privacy
 * 
 * @package Easy Social Share Buttons for WordPress
 * @author appscreo
 * @since 2.0
 *
 */
class ESSB_Social_Privacy {
	
	private static $instance = null;
	
	protected $options;
	
	protected $active = false;
	
	protected $state_facebook = false;
	protected $state_google = false;
	protected $state_twitter = false;
	protected $state_pinterest = false;
	protected $state_linkedin = false;
	protected $state_vk = false;
	
	function __construct() {
		
		// initialize options
		$essb_options = EasySocialShareButtons_Options::get_instance();
		$this->options = $essb_options->options;
		
		$this->active = ESSBOptionsHelper::optionsBoolValue($this->options, 'native_privacy_active');
		
		if (ESSB_DEMO_MODE) {
			$is_active_option = isset($_REQUEST['native-privacy']) ? $_REQUEST['native-privacy'] : '';
			if ($is_active_option == 'true') {
				$this->active = true;
			}
		}
		
		if ($this->active) {
			$this->get_state();
			add_action ( 'wp_enqueue_scripts', array ($this, 'registerCSS' ), 10 );				
		}
	}
		
	public static function get_instance() {
	
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
	
		return self::$instance;
	
	} // end get_instance;
	
	public function get_state() {
		$this->state_facebook = isset($_COOKIE['essb_socialprivacy_facebook']) ? true : false;
		$this->state_google = isset($_COOKIE['essb_socialprivacy_google']) ? true : false;
		$this->state_twitter = isset($_COOKIE['essb_socialprivacy_twitter']) ? true : false;
		$this->state_pinterest = isset($_COOKIE['essb_socialprivacy_pinterest']) ? true : false;
		$this->state_linkedin = isset($_COOKIE['essb_socialprivacy_linkedin']) ? true : false;
		$this->state_vk = isset($_COOKIE['essb_socialprivacy_vk']) ? true : false;
		
	}
	
	public function is_activated($network) {
		// if module is not active return always true
		if (!$this->active) { return true; }
		
		$result = false;
		
		switch ($network) {
			case "facebook":
				$result = $this->state_facebook;
				break;
			case "google":
				$result = $this->state_google;
				break;
			case "twitter":
				$result = $this->state_twitter;
				break;
			case "pinterest":
				$result = $this->state_pinterest;
				break;
			case "linkedin":
				$result = $this->state_linkedin;
				break;
			case "vk":
				$result = $this->state_vk;
				break;			
		}
		
		return $result;
	}
	
	public function get_icon($type) {
		$icon = "";
	
		switch ($type) {
			case "google" :
				$icon = "fa-google-plus";
				break;
					
			case "facebook" :
				$icon = "fa-facebook";
				break;
					
			case "twitter" :
				$icon = "fa-twitter";
				break;
					
			case "pinterest" :
				$icon = "fa-pinterest";
				break;
					
			case "youtube" :
				$icon = "fa-youtube-play";
				break;
			case "vk" :
				$icon = "fa-vk";
				break;
			case "linkedin" :
				$icon = "fa-linkedin";
				break;
		}
	
		return $icon;
	}
	
	public function generate_button($type, $text = '', $width = '', $user_skin = 'metro') {
		$output = "";
		if ($user_skin != '') {
			$user_skin = ' '.$user_skin;
		}
		$check_type = $type;
		if ($type == 'facebook') { $check_type = 'fb'; }
		if ($text == '') {
			$options_text = isset($this->options['skinned_'.$check_type.'_privacy_text']) ? $this->options['skinned_'.$check_type.'_privacy_text'] : '';
			if ($options_text != '') { $text = $options_text;}
		}
		if ($width == '') {
			$options_text = isset($this->options['skinned_'.$check_type.'_privacy_width']) ? $this->options['skinned_'.$check_type.'_privacy_width'] : '';
			if ($options_text != '') {
				$width = $options_text;
			}
		}
		
		$css_width = "";
		if ($width != '') {
			$css_width = ' style="width:'.$width.'px!important;"';
		}
		
		$output = '<div class="essb-privacy-button'.$user_skin.'" data-button-type="'.$type.'">';
		$output .= '<div class="essb-privacy-outsite'.$user_skin.' essb-privacy-' . $type . '"'.$css_width.'>';
		
		$output_text = "";
		
		if ($text != '') {
			$output_text = '<span class="essb-privacy-text-inner">' . $text . '</span>';
		}
		
		$output .= '<div class="essb-privacy-text'.$user_skin.'"><span class="fa ' . $this->get_icon($type) . '"></span>' . $output_text . '</div>';
		
		$output .= '</div>';
		$output .= '</div>';
		
		return $output;
	}
	
	public function registerCSS() {
		wp_enqueue_style ( 'essb-native-privacy', ESSB_PLUGIN_URL . '/assets/css/essb-native-privacy.min.css', array () );
		wp_register_style ( 'essb-fontawsome', ESSB_PLUGIN_URL . '/assets/css/font-awesome.min.css', array () );
		wp_enqueue_style ( 'essb-fontawsome' );
		
		wp_enqueue_script ( 'essb-socialprivacy-script', ESSB_PLUGIN_URL . '/assets/js/essb-social-privacy.min.js', array ( 'jquery' ), "", true );
		
	}
}

?>