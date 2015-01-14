<?php
class ESSBIS_Utils {

	public static function array_merge_map_recursive($r1, $r2) {
		$merged = array();
		foreach ($r1 as $k => $v) {
			if (!isset($r2[$k])) {
				$merged[$k] = $v;
			}
			elseif (!is_array($v)) {
				$merged[$k] = $r2[$k];
			}
			else {
				$merged[$k] = ESSBIS_Utils::array_merge_map_recursive($v,$r2[$k]);
			}
		}
		return $merged;
	}

	public static function get_attribute_from_html_tag($html_tag, $attribute_name){
		$result = '';
		if ( preg_match('/' . $attribute_name . '="(.*?)"/i', $html_tag, $matches)) {
		 $result = $matches[1];
		}
		return $result;
	}

	public static function get_image_attributes_from_post( $content ){
		global $essbis_options;

		$img_title = $img_alt = $img_src = $img_description = '';
		$imgPattern = "/<img([^\>]*?)>/i";
		if (preg_match($imgPattern, $content, $img_tag)) {
			$img_src = ESSBIS_Utils::get_attribute_from_html_tag($img_tag[0], 'src');
			$img_alt = ESSBIS_Utils::get_attribute_from_html_tag($img_tag[0], 'alt');
			$img_title = ESSBIS_Utils::get_attribute_from_html_tag($img_tag[0], 'title');

			if ('1' == $essbis_options['buttonSettings']['generalDownloadImageDescription']) {
				$classAttr = ESSBIS_Utils::get_attribute_from_html_tag($img_tag[0], 'class');
				$id = self::get_post_id_from_image_classes( $classAttr );
				$img_description = self::get_image_description( $id, $img_src );
			}
		}
		return array(
			'title' => wp_strip_all_tags( $img_title, true ),
			'alt' => wp_strip_all_tags( $img_alt, true ),
			'src' => $img_src,
			'description' => $img_description
		);
	}

	/*
	 * Function copied from http://stephenharris.info/how-to-get-the-current-url-in-wordpress/
	 */
	public static function get_current_URL() {
		global $wp;
		return home_url(add_query_arg(array(),$wp->request));
	}

	public static function add_description_attribute_to_images( $content ) {

		$imgPattern = '/<img[^>]*>/i';
		$attrPattern = '/ ([\w]+)[ ]*=[ ]*([\"\'])(.*?)\2/i';

		preg_match_all($imgPattern, $content, $images, PREG_SET_ORDER);

		foreach ($images as $img) {

			preg_match_all($attrPattern, $img[0], $attributes, PREG_SET_ORDER);

			$newImg = '<img';
			$src = '';
			$id = '';

			foreach ($attributes as $att) {
				$full = $att[0];
				$name = $att[1];
				$value = $att[3];

				$newImg .= $full;

				if ('class' == $name ) {
					$id = self::get_post_id_from_image_classes( $value );
				}	else if ( 'src' == $name ) {
					$src = $value;
				}
			}

			$description = self::get_image_description( $id, $src );
			$newImg .= ' data-essbisImageDescription="' . esc_attr( $description ) . '" />';
			$content = str_replace($img[0], $newImg, $content);
		}

		return $content;
	}

	//function gets the id of the image by searching for class with wp-image- prefix, otherwise returns empty string
	private static function get_post_id_from_image_classes( $class_attribute ) {
		$classes = preg_split( '/\s+/', $class_attribute, -1, PREG_SPLIT_NO_EMPTY );
		$prefix = 'wp-image-';

		for ($i = 0; $i < count( $classes ); $i++) {

			if ( $prefix === substr( $classes[ $i ], 0, strlen( $prefix ) ))
				return str_replace( $prefix, '',  $classes[ $i ] );
		}

		return '';
	}

	/* Get description for a given image */
	private static function get_image_description( $id, $src ) {

		$result = is_numeric( $id ) ? self::get_image_description_by_id( $id ) : '';

		//if description based on id wasn't found
		if ( '' === $result  ) {
			$id = self::fjarrett_get_attachment_id_by_url( $src );
			$result = is_numeric ( $id ) ? self::get_image_description_by_id( $id ) : '';
		}

		return $result;
	}

	/* Function searches for image based on $id and returns its description */
	static function get_image_description_by_id( $id ){

		$attachment = get_post( $id );
		return null == $attachment ? '' : $attachment->post_content;
	}

	/**
	 * Function copied from http://frankiejarrett.com/get-an-attachment-id-by-url-in-wordpress/
	 * Return an ID of an attachment by searching the database with the file URL.
	 *
	 * First checks to see if the $url is pointing to a file that exists in
	 * the wp-content directory. If so, then we search the database for a
	 * partial match consisting of the remaining path AFTER the wp-content
	 * directory. Finally, if a match is found the attachment ID will be
	 * returned.
	 *
	 * @return {int} $attachment
	 */
	private static function fjarrett_get_attachment_id_by_url( $url ) {

		// Split the $url into two parts with the wp-content directory as the separator.
		$parse_url  = explode( parse_url( WP_CONTENT_URL, PHP_URL_PATH ), $url );

		// Get the host of the current site and the host of the $url, ignoring www.
		$this_host = str_ireplace( 'www.', '', parse_url( home_url(), PHP_URL_HOST ) );
		$file_host = str_ireplace( 'www.', '', parse_url( $url, PHP_URL_HOST ) );

		// Return nothing if there aren't any $url parts or if the current host and $url host do not match.
		if ( ! isset( $parse_url[1] ) || empty( $parse_url[1] ) || ( $this_host != $file_host ) )
			return;

		// Now we're going to quickly search the DB for any attachment GUID with a partial path match.
		// Example: /uploads/2013/05/test-image.jpg
		global $wpdb;

		$prefix     = $wpdb->prefix;
		$attachment = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM " . $prefix . "posts WHERE guid RLIKE %s;", $parse_url[1] ) );

		// Returns null if no attachment is found.
		return  $attachment ? $attachment[0] : null;
	}
}