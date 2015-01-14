<?php

class ESSBIS_Hover_Module extends ESSBIS_Activateable_Module {

	public function get_module_tag() {
		return 'hover';
	}

	public function get_module_name() {
		return __('Hover Module', 'essbis');
	}

	public function get_registered_settings_header() {
		return __("Hover", 'essbis' );
	}

	public function content_filter( $content ){
		global $essbis_options;

		$attributes = ' data-essbisPostContainer=""';
		$attributes.= ' data-essbisPostUrl="' . get_the_permalink() . '"';
		$attributes.= ' data-essbisPostTitle="' . wp_strip_all_tags( get_the_title(), true ) . '"';
		$attributes.= ' data-essbisHoverContainer=""';

		$post_container = '<input type="hidden" value=""' . $attributes . '>';

		if ('1' == $essbis_options['buttonSettings']['generalDownloadImageDescription']) {
			$content = ESSBIS_Utils::add_description_attribute_to_images( $content );
		}
		return $post_container . $content;
	}

	public function is_active() {
		global $essbis_options;
		return $essbis_options['main']['moduleHoverActive'] == '1';
	}

	public function use_for_current_request() {
		global $essbis_options;

		$base_value = parent::use_for_current_request();
		if (false == $base_value)
			return false;

		$result = true;

		if ( is_front_page() )
			$result = $essbis_options[ $this->get_module_tag() ]['showOnHome'] == '1';
		else if ( is_single() )
			$result = $essbis_options[ $this->get_module_tag() ]['showOnSingle'] == '1';
		else if ( is_page() )
			$result = $essbis_options[ $this->get_module_tag() ]['showOnPage'] == '1';
		else if ( $this->is_this_blog_page() )
			$result = $essbis_options[ $this->get_module_tag() ]['showOnBlog'] == '1';
		return $result;
	}

	/* function copied from https://gist.github.com/wesbos/1189639 */
	private function is_this_blog_page() {
		global $post;

		$post_type = get_post_type( $post );

		return ( ( is_home() || is_archive() || is_single() ) && ( $post_type == 'post' )	);
	}
}