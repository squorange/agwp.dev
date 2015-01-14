<?php

class ESSBOptionsHelper {
	
	public static function getPostMetaOptions($post_id) {
		
		// getting post meta
		$metaboxContainer = get_post_custom ( $post_id );
		// $essb_position = isset ( $custom ["essb_position"] ) ? $custom
		// ["essb_position"] [0] : "";
		
		$optionsFromPost = array ();
		$optionsFromPost ['essb_off'] = ESSBOptionsHelper::metaboxValue ( $metaboxContainer, 'essb_off', 'false' );
		
			
			$optionsFromPost ['essb_position'] = ESSBOptionsHelper::metaboxValue ( $metaboxContainer, 'essb_position' );
			$optionsFromPost ['essb_names'] = ESSBOptionsHelper::metaboxValue ( $metaboxContainer, 'essb_names' );
			
			$optionsFromPost ['essb_hidefb'] = ESSBOptionsHelper::metaboxValue ( $metaboxContainer, 'essb_hidefb' );
			$optionsFromPost ['essb_hideplusone'] = ESSBOptionsHelper::metaboxValue ( $metaboxContainer, 'essb_hideplusone' );
			$optionsFromPost ['essb_hidevk'] = ESSBOptionsHelper::metaboxValue ( $metaboxContainer, 'essb_hidevk' );
			$optionsFromPost ['essb_hidetwitter'] = ESSBOptionsHelper::metaboxValue ( $metaboxContainer, 'essb_hidetwitter' );
			$optionsFromPost ['essb_hideyoutube'] = ESSBOptionsHelper::metaboxValue ( $metaboxContainer, 'essb_hideyoutube' );
			$optionsFromPost ['essb_hidepinfollow'] = ESSBOptionsHelper::metaboxValue ( $metaboxContainer, 'essb_hidepinfollow' );

			$optionsFromPost ['essb_sidebar_pos'] = ESSBOptionsHelper::metaboxValue ( $metaboxContainer, 'essb_sidebar_pos' );
			$optionsFromPost ['essb_counter_pos'] = ESSBOptionsHelper::metaboxValue ( $metaboxContainer, 'essb_counter_pos' );
			$optionsFromPost ['essb_total_counter_pos'] = ESSBOptionsHelper::metaboxValue ( $metaboxContainer, 'essb_total_counter_pos' );
			$optionsFromPost ['essb_hidepinfollow'] = ESSBOptionsHelper::metaboxValue ( $metaboxContainer, 'essb_hidepinfollow' );

			$optionsFromPost ['essb_post_share_message'] = ESSBOptionsHelper::metaboxValue ( $metaboxContainer, 'essb_post_share_message' );
			$optionsFromPost ['essb_post_share_url'] = ESSBOptionsHelper::metaboxValue ( $metaboxContainer, 'essb_post_share_url' );
			$optionsFromPost ['essb_post_share_image'] = ESSBOptionsHelper::metaboxValue ( $metaboxContainer, 'essb_post_share_image' );
			$optionsFromPost ['essb_post_share_text'] = ESSBOptionsHelper::metaboxValue ( $metaboxContainer, 'essb_post_share_text' );
			$optionsFromPost ['essb_post_fb_url'] = ESSBOptionsHelper::metaboxValue ( $metaboxContainer, 'essb_post_fb_url' );
			$optionsFromPost ['essb_post_plusone_url'] = ESSBOptionsHelper::metaboxValue ( $metaboxContainer, 'essb_post_plusone_url' );
			$optionsFromPost ['essb_post_twitter_username'] = ESSBOptionsHelper::metaboxValue ( $metaboxContainer, 'essb_post_twitter_username' );
			$optionsFromPost ['essb_post_twitter_hashtags'] = ESSBOptionsHelper::metaboxValue ( $metaboxContainer, 'essb_post_twitter_hashtags' );
			$optionsFromPost ['essb_post_twitter_tweet'] = ESSBOptionsHelper::metaboxValue ( $metaboxContainer, 'essb_post_twitter_tweet' );
			$optionsFromPost ['essb_as'] = ESSBOptionsHelper::metaboxValue ( $metaboxContainer, 'essb_as' );
			
			if ($optionsFromPost['essb_as'] != '') {
				$optionsFromPost['essb_as'] = unserialize($optionsFromPost['essb_as']);
			}
				
			$optionsFromPost ['essb_theme'] = ESSBOptionsHelper::metaboxValue ( $metaboxContainer, 'essb_theme' );
			$optionsFromPost ['essb_activate_fullwidth'] = ESSBOptionsHelper::metaboxValue ( $metaboxContainer, 'essb_activate_fullwidth' );
			$optionsFromPost ['essb_counter'] = ESSBOptionsHelper::metaboxValue ( $metaboxContainer, 'essb_counter' );

			$optionsFromPost ['essb_shorturl_bitly'] = ESSBOptionsHelper::metaboxValue ( $metaboxContainer, 'essb_shorturl_bitly' );
			$optionsFromPost ['essb_shorturl_googl'] = ESSBOptionsHelper::metaboxValue ( $metaboxContainer, 'essb_shorturl_googl' );
				
		//print_r($optionsFromPost);
		return $optionsFromPost;
	}
	
	public static function metaboxValue($metaboxContainer, $param, $default = '') {
		return isset ( $metaboxContainer [$param] ) ? $metaboxContainer [$param] [0] : $default;
	}


	public static function optionsValue($optionsContainer, $param, $default = '') {
		return isset ( $optionsContainer [$param] ) ? $optionsContainer [$param]  : $default;
	}
	
	public static function optionsBoolValue($optionsContainer, $param) {
		$value = isset ( $optionsContainer [$param] ) ? $optionsContainer [$param]  : 'false';
		
		if ($value == "true") {
			return true;
		}
		else {
			return false;
		}
		
	}
	
	public static function optionsBoolValueAsText($optionsContainer, $param) {
		$value = isset ( $optionsContainer [$param] ) ? $optionsContainer [$param]  : 'false';
	
		if ($value == "true") {
			return "true";
		}
		else {
			return "false";
		}
	
	}
	
	public static function templateFolder ($template_id) {
		$folder = 'default';
	
		if ($template_id == 1) {
			$folder = "default";
		}
		if ($template_id == 2) {
			$folder = "metro";
		}
		if ($template_id == 3) {
			$folder = "modern";
		}
		if ($template_id == 4) {
			$folder = "round";
		}
		if ($template_id == 5) {
			$folder = "big";
		}
		if ($template_id == 6) {
			$folder = "metro-retina";
		}
		if ($template_id == 7) {
			$folder = "big-retina";
		}
		if ($template_id == 8) {
			$folder = "light-retina";
		}
		if ($template_id == 9) {
			$folder = "flat-retina";
		}
		if ($template_id == 10) {
			$folder = "tiny-retina";
		}
		if ($template_id == 11) {
			$folder = "round-retina";
		}
		if ($template_id == 12) {
			$folder = "modern-retina";
		}
		if ($template_id == 13) {
			$folder = "circles-retina";
		}
		if ($template_id == 14) {
			$folder = "blocks-retina";
		}
		if ($template_id == 15) {
			$folder = "dark-retina";
		}
		if ($template_id == 16) {
			$folder = "grey-circles-retina";
		}
		if ($template_id == 17) {
			$folder = "grey-blocks-retina";
		}
		if ($template_id == 18) {
			$folder = "clear-retina";
		}
		if ($template_id == 19) {
			$folder = "copy-retina";
		}
		
		return $folder;
	}
	
	public static function get_current_url($mode = 'base') {
	
		$url = 'http' . (is_ssl () ? 's' : '') . '://' . $_SERVER ['HTTP_HOST'] . $_SERVER ['REQUEST_URI'];
	
		switch ($mode) {
			case 'raw' :
				return $url;
				break;
			case 'base' :
				return reset ( explode ( '?', $url ) );
				break;
			case 'uri' :
				$exp = explode ( '?', $url );
				return trim ( str_replace ( home_url (), '', reset ( $exp ) ), '/' );
				break;
			default :
				return false;
		}
	}

	public static function curPageURL() {
		$pageURL = 'http';
		if(isset($_SERVER["HTTPS"]))
			if ($_SERVER["HTTPS"] == "on") {
			$pageURL .= "s";
		}
		$pageURL .= "://";
		if ($_SERVER["SERVER_PORT"] != "80") {
			$pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
		} else {
			$pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
		}
		return $pageURL;
	}
	
	public static function exsitQueryString() {
		$exist = false;
	
		if (!empty($_SERVER['QUERY_STRING'])) {
				
			$exist = true;
		}
	
		return $exist;
	}	
	
	public static function generate_mycred_datatoken($group = 'mycred_default', $points = '1') {
		$salt = mt_rand ();
		$result = "";
		
		if (function_exists('mycred_create_token')) {

			if ($points == "") { $points = "1"; }
			if ($group == "") { $group = "mycred_default"; }
			
			$result = mycred_create_token( array( $points, $group, $salt ) );
			
			if ($result != '') {
				$result = ' data-token="' . $result . '"';
			}
		}
		
		return $result;
	}
	
	public static function attachGoogleCampaignTrackingCode($url, $code = '') {
		$posParamSymbol = strpos($url, '?');
		
		if ($posParamSymbol === false) {
			$url .= '?';
		}
		else {
			$url .= "&";
		}
		
		$url .= $code;
		
		return $url;
	}
}

?>