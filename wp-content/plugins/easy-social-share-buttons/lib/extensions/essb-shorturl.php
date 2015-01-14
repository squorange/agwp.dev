<?php

class EasySocialShareButtons_ShortUrl {
	public static function google_shorten($url, $post_id = '') {
		$result = wp_remote_post ( 'https://www.googleapis.com/urlshortener/v1/url', array ('body' => json_encode ( array ('longUrl' => esc_url_raw ( $url ) ) ), 'headers' => array ('Content-Type' => 'application/json' ) ) );
	
		// Return the URL if the request got an error.
		if (is_wp_error ( $result ))
			return $url;
	
		$result = json_decode ( $result ['body'] );
		$shortlink = $result->id;
		if ($shortlink) {
			if ($post_id != '') {
				update_post_meta ( $post_id, 'essb_shorturl_googl', $shortlink );
				
			}
			
			return $shortlink;
		}
	
		return $url;
	}
	
	public static function bitly_shorten($url, $user, $api, $jmp = 'false', $post_id = '') {
		$params = http_build_query(
				array(
						'login' => $user,
						'apiKey' => $api,
						'longUrl' => $url,
						'format' => 'json',
				)
		);
		
		if ($jmp == 'true') {
			$params['domain'] = "j.mp";
		}
			
		$result = $url;
	
		$rest_url = 'https://api-ssl.bitly.com/v3/shorten?' . $params;
	
		$response = wp_remote_get( $rest_url );
		//print_r($response);
		// if we get a valid response, save the url as meta data for this post
		if( !is_wp_error( $response ) ) {
	
			$json = json_decode( wp_remote_retrieve_body( $response ) );
	
			if( isset( $json->data->url ) ) {
	
				$result = $json->data->url;
				update_post_meta ( $post_id, 'essb_shorturl_bitly', $result );
			}
		}
	
		return $result;
	}
	
}

?>