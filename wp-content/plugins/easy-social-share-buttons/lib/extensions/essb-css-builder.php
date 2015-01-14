<?php

class ESSB_CSS_Builder {
	private $css;
	private $version = ESSB_VERSION;
	
	private $custom_css_builder_executed = false;
	private $default_deactivated = false;
	
	function __construct() {
		
		// reset CSS generated output
		$this->css = array();		
		add_action('wp_head', array($this, 'generate_custom_css'));
	}
	
	public function deactivate_css_builder() {
		remove_action('wp_head', array($this, 'generate_custom_css'));
		$this->default_deactivated = true;
	}
	
	public function register_custom_css_footer() {
		if ($this->default_deactivated) {
			add_action('wp_footer', array($this, 'generate_custom_css'));
		}
	}
	
	public function add_rule($singleRule, $key = '') {
		if ($key != '') {
			$this->css[$key] = $singleRule;
		}
		else {
			$this->css[] = $singleRule;
		}
	}
	
	public function fix_css_hide_icons() {
		$this->add_rule('.essb_links .essb_icon { display: none !important; }', 'essb_hidden_icons');
	}
	
	public function fix_css_mobile_hidden_network_names() {
		$this->add_rule('.essb_hide_name a:hover .essb_network_name, .essb_hide_name a:focus .essb_network_name { display: none !important; }', 'essb_hide_mobile1');
		$this->add_rule('.essb_hide_name a:hover .essb_icon, .essb_hide_name a:focus .essb_icon { margin-right: 0px !important; margin-left: 0px !important; }', 'essb_hide_mobile2');
		$this->add_rule('@media only screen and (max-width: 767px) { .essb_fixed { left: 5px !important; } }', 'essb_hide_mobile3');
		$this->add_rule('@media only screen and (max-width: 479px) { .essb_fixed { left: 5px !important; } }', 'essb_hide_mobile4');
	}
	
	public function fix_css_mobile_hidden_buttons() {
		$this->add_rule('@media only screen and (max-width: 767px) { .essb_links { display: none !important; } }', 'essb_hide_mobile5');
		$this->add_rule('@media only screen and (max-width: 479px) { .essb_links { display: none !important; } }', 'essb_hide_mobile6');
		
	}
	
	public function fix_css_float_from_top() {
		$options = get_option(  EasySocialShareButtons::$plugin_settings_name );
		
		$top_pos = isset($options['float_top']) ? $options['float_top'] : '';
		$bg_color = isset($options['float_bg']) ? $options['float_bg'] : '';
		$float_full = isset($options['float_full']) ? $options['float_full'] : '';
		$button_pos = isset($options['buttons_pos']) ? $options['buttons_pos'] : '';
		
		$float_top_loggedin = isset($options['float_top_loggedin']) ? $options['float_top_loggedin'] : '';
		
		// fix margin from top option
		$this->add_rule('.essb_fixed { margin: 0; }');
		//print "is_user_logged_in = " . is_user_logged_in().', $float_top_loggedin = '.$float_top_loggedin;
		if (is_user_logged_in() && $float_top_loggedin != '') { $top_pos = $float_top_loggedin; }
		
		$custom_float_js = isset($options['float_js']) ? $options['float_js'] : 'false';
		
		if ($top_pos != '' || $bg_color != '' || $float_full != '' || $button_pos != '' || $custom_float_js == 'true') {
				
			if ($top_pos != '') {
				$this->add_rule('.essb_fixed { top: '.$top_pos.'px !important; }');
			}
			if ($bg_color != '') {
				$this->add_rule('.essb_fixed { background: '.$bg_color.' !important; }');
			}
				
			if ($float_full == 'true') {
				$this->add_rule('.essb_fixed { left: 0; width: 100%; min-width: 100%; padding-left: 10px; }');
			}
				
			if ($button_pos != '') {
				if ($button_pos == "right") {
					$this->add_rule('.essb_links { text-align: right;}');
				}
				if ($button_pos == "center") {
					$this->add_rule('.essb_links { text-align: center;}');
				}
			}
				
			if ($custom_float_js == 'true') {
				$this->add_rule('.essb_float_absolute { position: absolute !important; z-index: 999 !important; }');
			}
		}
	}
	
	public function handle_postfloat_custom_css() {
		$options = get_option(  EasySocialShareButtons::$plugin_settings_name );
		
		$postfloat_marginleft = isset($options['postfloat_marginleft']) ? $options['postfloat_marginleft'] : '';
		$postfloat_margintop = isset($options['postfloat_margintop']) ? $options['postfloat_margintop'] : '';
		$postfloat_fixedtop = isset($options['postfloat_fixedtop']) ? $options['postfloat_fixedtop'] : '';
		
		if ($postfloat_fixedtop != '') {
			if (false === strpos($postfloat_fixedtop, 'px') && false === strpos($postfloat_fixedtop, '%')) {
				$postfloat_fixedtop .= 'px';
			}
		}
		
		if ($postfloat_marginleft != '') {
			$this->add_rule('.essb_displayed_postfloat { margin-left: '.$postfloat_marginleft.'px !important;}', 'essb_postfloat1');
		}

		if ($postfloat_margintop != '') {
			$this->add_rule('.essb_displayed_postfloat { margin-top: '.$postfloat_margintop.'px !important;}', 'essb_postfloat2');
		}
		
		if ($postfloat_fixedtop != ''){
			$this->add_rule('.essb_displayed_postfloat { top: '.$postfloat_fixedtop.' !important;}', 'essb_postfloat3');
		}

		$sidebar_fixedtop = isset($options['sidebar_fixedtop']) ? $options['sidebar_fixedtop'] : '';
		$sidebar_bottom_bgcolor = isset($options['sidebar_bottom_bgcolor']) ? $options['sidebar_bottom_bgcolor'] : '';
		
		$sidebar_bottom_percent = isset($options['sidebar_bottom_percent']) ? $options['sidebar_bottom_percent'] : '';
		$sidebar_top_percent = isset($options['sidebar_top_percent']) ? $options['sidebar_top_percent'] : '';
		$postfloat_percent = isset($options['postfloat_percent']) ? $options['postfloat_percent'] : '';
		
		if ($sidebar_fixedtop != '') {
			if (false === strpos($sidebar_fixedtop, 'px') && false === strpos($sidebar_fixedtop, '%')) {
				$sidebar_fixedtop .= 'px';
			}
			//essb_displayed_sidebar_right
			$this->add_rule('.essb_displayed_sidebar_right, .essb_displayed_sidebar { top: '.$sidebar_fixedtop.' !important;}', 'essb_postfloat4');
		}
		if ($sidebar_bottom_bgcolor != '' ) {
			$this->add_rule('.essb_displayed_sidebar_bottom, .essb_displayed_sidebar_top { background-color:'.$sidebar_bottom_bgcolor. '!important;}', 'essb_postfloat5');
		}
		if ($sidebar_bottom_percent != '') {
			$this->add_rule('.essb_displayed_sidebar_bottom { display: none; -webkit-transition: all 1s; -moz-transition: all 1s;-ms-transition: all 1s;-o-transition: all 1s;transition: all 1s;}', 'essb_postfloat6');
		}
		if ($sidebar_top_percent != '') {
			$this->add_rule('.essb_displayed_sidebar_top { display: none; -webkit-transition: all 1s; -moz-transition: all 1s;-ms-transition: all 1s;-o-transition: all 1s;transition: all 1s;}', 'essb_postfloat7');
		}
		if ($postfloat_percent != '') {
			$this->add_rule('.essb_displayed_postfloat { display: none; -webkit-transition: all 1s; -moz-transition: all 1s;-ms-transition: all 1s;-o-transition: all 1s;transition: all 1s;}', 'essb_postfloat8');
			
		}
	}
	
	public function insert_total_shares_text() {
		$options = get_option(  EasySocialShareButtons::$plugin_settings_name );
		$activate_total_counter_text = isset($options['activate_total_counter_text']) ? $options['activate_total_counter_text'] : '';
		$activate_total_counter_text_value = isset($options['activate_total_counter_text_value']) ? $options['activate_total_counter_text_value'] : '';
		
		if ($activate_total_counter_text_value != '' && $activate_total_counter_text == "true") {
			$this->add_rule('.essb_links_list li.essb_totalcount_item .essb_t_l_big .essb_t_nb:after, .essb_links_list li.essb_totalcount_item .essb_t_r_big .essb_t_nb:after { '.
				'color: #999999;'.
				'content: "'.$activate_total_counter_text_value.'";'.
				'display: block;'.
				'font-size: 11px;'.
				'font-weight: normal;'.
				'text-align: center;'.
				'text-transform: uppercase;'.
				'margin-top: -5px; } ', 'essb_total_counter');
		}
	}
	
	public function generate_custom_css() {
		global $post;
		
		// caching will work only if post is provided
		if (isset($post)) {
			if (defined('ESSB_CACHE_ACTIVE_RESOURCE')) {
				$cache_key = "essb_inline_styles_".$post->ID;
				
				$cached_data = ESSBCache::get_resource($cache_key, 'css');
				
				if ($cached_data != '') {
					echo "<link rel='stylesheet' id='essb-cache-css'  href='".$cached_data."' type='text/css' media='all' />";
					return;
				}
			}
		}
		
		$this->fix_css_float_from_top();
		$this->generate_essb_more_popup_css();
				
			// $custom_css_builder_executed
		$options = get_option ( EasySocialShareButtons::$plugin_settings_name );
		$is_active = isset ( $options ['customizer_is_active'] ) ? $options ['customizer_is_active'] : 'false';
		if (isset ( $post )) {
			$post_activate_customizer = get_post_meta ( $post->ID, 'essb_activate_customizer', true );
			
			if ($post_activate_customizer != '') {
				if ($post_activate_customizer == "yes") {
					$is_active = "true";
				} else {
					$is_active = "false";
				}
			}
		}
		if ($is_active == "true" && !$this->custom_css_builder_executed) {
			$this->customizer_compile_css_second();
		}
		
		if (count($this->css) > 0) {
			//echo '<!-- ESSB v. '.$this->version.' CSS Builder -->';
			$output_css = "";
							
			foreach ($this->css as $cssRule) {
				//$cssRule = str_replace(array("\n","\r\n"), '', $cssRule);
				$cssRule = trim(preg_replace('/\s+/', ' ', $cssRule));
				$output_css .= $cssRule;
			}
			
			if (isset($post)) {
				if (defined('ESSB_CACHE_ACTIVE_RESOURCE')) {
					$cache_key = "essb_inline_styles_".$post->ID;
			
					ESSBCache::put_resource($cache_key, $output_css, 'css');		

					$cached_data = ESSBCache::get_resource($cache_key, 'css');
					
					if ($cached_data != '') {
						echo "<link rel='stylesheet' id='essb-cache-css'  href='".$cached_data."' type='text/css' media='all' />";
						return;
					}
				}
			}
			echo '<style type="text/css">';
			echo $output_css;
			echo '</style>';
		}
	}
	
	function generate_essb_more_popup_css() {
		$this->add_rule('.essb_more_popup {
	
	z-index: 999;
	
}', 'essb_morepop1');
		$this->add_rule('.essb_more_popup_content {
	padding-top: 10px; padding-bottom: 10px; padding-left: 5px; padding-right: 5px;
	margin: 0;
	text-align: center;
}', 'essb_morepop2');
		$this->add_rule('.essb_more_popup_shadow {
	position:fixed;
	_position:absolute; /* hack for IE 6*/
	height:100%;
	width:100%;
	top:0;
	left:0;
	background: rgba(99, 99, 99, 0.3);
	z-index:998;
	display: none;
}', 'essb_morepop3');
		$this->add_rule('.essb_more_popup_button_close { position: absolute; top:5px; right: 0;}', 'essb_morepop4');
		$this->add_rule('.essb_more_popup_button_close a, .essb_more_popup_button_close a:hover { background: none; background-color: none; border: none; font-weight: bold; text-decoration: none; color: #333; padding-right: 5px; margin-top: 5px;}','essb_morepop5');
	}
	
	function customizer_compile_css($skinedSocial = false) {
		global $post;
		$options = get_option ( EasySocialShareButtons::$plugin_settings_name );
		
		$is_active = isset ( $options ['customizer_is_active'] ) ? $options ['customizer_is_active'] : 'false';
				
		if (isset ( $post )) {
			$post_activate_customizer = get_post_meta ( $post->ID, 'essb_activate_customizer', true );
			
			if ($post_activate_customizer != '') {
				if ($post_activate_customizer == "yes") {
					$is_active = "true";
				} else {
					$is_active = "false";
				}
			}
		}
		
		if ($is_active == "true") {
			$this->custom_css_builder_executed = true;
			$global_bgcolor = isset ( $options ['customizer_bgcolor'] ) ? $options ['customizer_bgcolor'] : '';
			$global_textcolor = isset ( $options ['customizer_textcolor'] ) ? $options ['customizer_textcolor'] : '';
			$global_hovercolor = isset ( $options ['customizer_hovercolor'] ) ? $options ['customizer_hovercolor'] : '';
			$global_hovertextcolor = isset ( $options ['customizer_hovertextcolor'] ) ? $options ['customizer_hovertextcolor'] : '';
			
			$global_remove_bg_effects = isset ( $options ['customizer_remove_bg_hover_effects'] ) ? $options ['customizer_remove_bg_hover_effects'] : '';
			$css = "";
			
			// @since 2.0
			$customizer_totalbgcolor = ESSBOptionsHelper::optionsValue($options, 'customizer_totalbgcolor');
			$customizer_totalcolor = ESSBOptionsHelper::optionsValue($options, 'customizer_totalcolor');
			$customizer_totalnobgcolor = ESSBOptionsHelper::optionsValue($options, 'customizer_totalnobgcolor');
			$customizer_totalfontsize = ESSBOptionsHelper::optionsValue($options, 'customizer_totalfontsize');
			$customizer_totalfontsize_after = ESSBOptionsHelper::optionsValue($options, 'customizer_totalfontsize_after');
			
			if ($customizer_totalbgcolor != '') {
				$this->add_rule('.essb_totalcount { background: '.$customizer_totalbgcolor.' !important;} ');
			}
			if ($customizer_totalnobgcolor == "true") {
				$this->add_rule('.essb_totalcount { background: none !important;} ');
			}
			if ($customizer_totalcolor != '') {
				$this->add_rule('.essb_totalcount, .essb_totalcount .essb_t_nb:after { color: '.$customizer_totalcolor.' !important;} ');
			}
			if ($customizer_totalfontsize != '') {
				$this->add_rule('.essb_totalcount .essb_t_nb { font-size: '.$customizer_totalfontsize.'!important; line-height:'.$customizer_totalfontsize.'!important;}');
			}
			if ($customizer_totalfontsize_after != '') {
				$this->add_rule('.essb_totalcount .essb_t_nb:after { font-size: '.$customizer_totalfontsize_after.'!important; }');
			}
				
				
			if ($global_remove_bg_effects == "true") {
				$this->add_rule('.essb_links a:hover, .essb_links a:focus { background: none !important; }');
			}
			
			$essb_networks = $options ['networks'];
			
			if ($global_bgcolor != '' || $global_textcolor != '' || $global_hovercolor != '' || $global_hovertextcolor != '') {
				foreach ( $essb_networks as $k => $v ) {
					if ($v [0] == 1 || $v[0] == 0) {
						$singleCss = "";
						if ($global_bgcolor != '' || $global_textcolor != '') {
							$singleCss .= '.essb_links .essb_link_' . $k . ' a { ';
							if ($global_bgcolor != '') {
								$singleCss .= 'background-color:' . $global_bgcolor . '!important;';
							}
							if ($global_textcolor != '') {
								$singleCss .= 'color:' . $global_bgcolor . '!important;';
							}
							$singleCss .= '}';
						}
						if ($global_hovercolor != '' || $global_hovertextcolor != '') {
							$singleCss .= '.essb_links .essb_link_' . $k . ' a:hover, .essb_links .essb_link_' . $k . ' a:focus { ';
							if ($global_hovercolor != '') {
								$singleCss .= 'background-color:' . $global_hovercolor . '!important;';
							}
							if ($global_hovertextcolor != '') {
								$singleCss .= 'color:' . $global_hovertextcolor . '!important;';
							}
							$singleCss .= '}';
						}
						
						$this->add_rule($singleCss);
					}
				
				}
			}
			
			// single network color customization
			foreach ( $essb_networks as $k => $v ) {
				if ($v [0] == 1) {
					$network_bgcolor = isset ( $options ['customizer_' . $k . '_bgcolor'] ) ? $options ['customizer_' . $k . '_bgcolor'] : '';
					$network_textcolor = isset ( $options ['customizer_' . $k . '_textcolor'] ) ? $options ['customizer_' . $k . '_textcolor'] : '';
					$network_hovercolor = isset ( $options ['customizer_' . $k . '_hovercolor'] ) ? $options ['customizer_' . $k . '_hovercolor'] : '';
					$network_hovertextcolor = isset ( $options ['customizer_' . $k . '_hovertextcolor'] ) ? $options ['customizer_' . $k . '_hovertextcolor'] : '';
					
					$network_icon = isset ( $options ['customizer_' . $k . '_icon'] ) ? $options ['customizer_' . $k . '_icon'] : '';
					$network_hovericon = isset ( $options ['customizer_' . $k . '_hovericon'] ) ? $options ['customizer_' . $k . '_hovericon'] : '';
					$network_iconbgsize = isset ( $options ['customizer_' . $k . '_iconbgsize'] ) ? $options ['customizer_' . $k . '_iconbgsize'] : '';
					$network_hovericonbgsize = isset ( $options ['customizer_' . $k . '_hovericonbgsize'] ) ? $options ['customizer_' . $k . '_hovericonbgsize'] : '';
					
					$sigleCss = "";
					
					if ($network_bgcolor != '' || $network_textcolor != '') {
						$sigleCss .= '.essb_links .essb_link_' . $k . ' a { ';
						if ($network_bgcolor != '') {
							$sigleCss .= 'background-color:' . $network_bgcolor . '!important;';
						}
						if ($network_textcolor != '') {
							$sigleCss .= 'color:' . $network_textcolor . '!important;';
						}
						$sigleCss .= '}';
					}
					if ($network_hovercolor != '' || $network_hovertextcolor != '') {
						$sigleCss .= '.essb_links .essb_link_' . $k . ' a:hover, .essb_links .essb_link_' . $k . ' a:focus { ';
						if ($network_hovercolor != '') {
							$sigleCss .= 'background-color:' . $network_hovercolor . '!important;';
						}
						if ($network_hovertextcolor != '') {
							$sigleCss .= 'color:' . $network_hovertextcolor . '!important;';
						}
						$sigleCss .= '}';
					}
					
					if ($network_icon != '') {
						$sigleCss .= '.essb_links .essb_link_' . $k . ' .essb_icon { background: url("' . $network_icon . '") !important; }';
						
						if ($network_iconbgsize != '') {
							$sigleCss .= '.essb_links .essb_link_' . $k . ' .essb_icon { background-size: ' . $network_iconbgsize . '!important; }';
						}
					}
					if ($network_hovericon != '') {
						$sigleCss .= '.essb_links .essb_link_' . $k . ' a:hover .essb_icon { background: url("' . $network_hovericon . '") !important; }';
						
						if ($network_hovericonbgsize != '') {
							$sigleCss .= '.essb_links .essb_link_' . $k . ' a:hover .essb_icon { background-size: ' . $network_hovericonbgsize . '!important; }';
						}
					}
					
					$this->add_rule($sigleCss);
				}
			
			}			
		}
		
		$global_user_defined_css = isset ( $options ['customizer_css'] ) ? $options ['customizer_css'] : '';
		$global_user_defined_css = stripslashes ( $global_user_defined_css );
		
		if ($global_user_defined_css != '') {
			//$css .= $global_user_defined_css;
			$this->add_rule($global_user_defined_css);
		}
		
		if ($skinedSocial) {
			//$css .= ESSB_Skinned_Native_Button::generateStyleCustomizerCSS ( $options );
			$this->add_rule(ESSB_Skinned_Native_Button::generateStyleCustomizerCSS ( $options ), 'essb_native_skin');
		}
		
	}
	
	function customizer_compile_css_second() {
		$options = get_option ( EasySocialShareButtons::$plugin_settings_name );
		
		$this->custom_css_builder_executed = true;
		$global_bgcolor = isset ( $options ['customizer_bgcolor'] ) ? $options ['customizer_bgcolor'] : '';
		$global_textcolor = isset ( $options ['customizer_textcolor'] ) ? $options ['customizer_textcolor'] : '';
		$global_hovercolor = isset ( $options ['customizer_hovercolor'] ) ? $options ['customizer_hovercolor'] : '';
		$global_hovertextcolor = isset ( $options ['customizer_hovertextcolor'] ) ? $options ['customizer_hovertextcolor'] : '';
		
		$global_remove_bg_effects = isset ( $options ['customizer_remove_bg_hover_effects'] ) ? $options ['customizer_remove_bg_hover_effects'] : '';
		$css = "";
		
		if ($global_remove_bg_effects == "true") {
			$this->add_rule ( '.essb_links a:hover, .essb_links a:focus { background: none !important; }' );
		}
		
		$essb_networks = $options ['networks'];
		
		if ($global_bgcolor != '' || $global_textcolor != '' || $global_hovercolor != '' || $global_hovertextcolor != '') {
			foreach ( $essb_networks as $k => $v ) {
				if ($v [0] == 1) {
					$singleCss = "";
					if ($global_bgcolor != '' || $global_textcolor != '') {
						$singleCss .= '.essb_links .essb_link_' . $k . ' a { ';
						if ($global_bgcolor != '') {
							$singleCss .= 'background-color:' . $global_bgcolor . '!important;';
						}
						if ($global_textcolor != '') {
							$singleCss .= 'color:' . $global_bgcolor . '!important;';
						}
						$singleCss .= '}';
					}
					if ($global_hovercolor != '' || $global_hovertextcolor != '') {
						$singleCss .= '.essb_links .essb_link_' . $k . ' a:hover, .essb_links .essb_link_' . $k . ' a:focus { ';
						if ($global_hovercolor != '') {
							$singleCss .= 'background-color:' . $global_hovercolor . '!important;';
						}
						if ($global_hovertextcolor != '') {
							$singleCss .= 'color:' . $global_hovertextcolor . '!important;';
						}
						$singleCss .= '}';
					}
					
					$this->add_rule ( $singleCss );
				}
			
			}
		}
		
		// single network color customization
		foreach ( $essb_networks as $k => $v ) {
			if ($v [0] == 1) {
				$network_bgcolor = isset ( $options ['customizer_' . $k . '_bgcolor'] ) ? $options ['customizer_' . $k . '_bgcolor'] : '';
				$network_textcolor = isset ( $options ['customizer_' . $k . '_textcolor'] ) ? $options ['customizer_' . $k . '_textcolor'] : '';
				$network_hovercolor = isset ( $options ['customizer_' . $k . '_hovercolor'] ) ? $options ['customizer_' . $k . '_hovercolor'] : '';
				$network_hovertextcolor = isset ( $options ['customizer_' . $k . '_hovertextcolor'] ) ? $options ['customizer_' . $k . '_hovertextcolor'] : '';
				
				$network_icon = isset ( $options ['customizer_' . $k . '_icon'] ) ? $options ['customizer_' . $k . '_icon'] : '';
				$network_hovericon = isset ( $options ['customizer_' . $k . '_hovericon'] ) ? $options ['customizer_' . $k . '_hovericon'] : '';
				$network_iconbgsize = isset ( $options ['customizer_' . $k . '_iconbgsize'] ) ? $options ['customizer_' . $k . '_iconbgsize'] : '';
				$network_hovericonbgsize = isset ( $options ['customizer_' . $k . '_hovericonbgsize'] ) ? $options ['customizer_' . $k . '_hovericonbgsize'] : '';
				
				$sigleCss = "";
				
				if ($network_bgcolor != '' || $network_textcolor != '') {
					$sigleCss .= '.essb_links .essb_link_' . $k . ' a { ';
					if ($network_bgcolor != '') {
						$sigleCss .= 'background-color:' . $network_bgcolor . '!important;';
					}
					if ($network_textcolor != '') {
						$sigleCss .= 'color:' . $network_textcolor . '!important;';
					}
					$sigleCss .= '}';
				}
				if ($network_hovercolor != '' || $network_hovertextcolor != '') {
					$sigleCss .= '.essb_links .essb_link_' . $k . ' a:hover, .essb_links .essb_link_' . $k . ' a:focus { ';
					if ($network_hovercolor != '') {
						$sigleCss .= 'background-color:' . $network_hovercolor . '!important;';
					}
					if ($network_hovertextcolor != '') {
						$sigleCss .= 'color:' . $network_hovertextcolor . '!important;';
					}
					$sigleCss .= '}';
				}
				
				if ($network_icon != '') {
					$sigleCss .= '.essb_links .essb_link_' . $k . ' .essb_icon { background: url("' . $network_icon . '") !important; }';
					
					if ($network_iconbgsize != '') {
						$sigleCss .= '.essb_links .essb_link_' . $k . ' .essb_icon { background-size: ' . $network_iconbgsize . '!important; }';
					}
				}
				if ($network_hovericon != '') {
					$sigleCss .= '.essb_links .essb_link_' . $k . ' a:hover .essb_icon { background: url("' . $network_hovericon . '") !important; }';
					
					if ($network_hovericonbgsize != '') {
						$sigleCss .= '.essb_links .essb_link_' . $k . ' a:hover .essb_icon { background-size: ' . $network_hovericonbgsize . '!important; }';
					}
				}
				
				$this->add_rule ( $sigleCss );
			}
		
		}
		
	
	}
	
	public function build_animation_css ($animation) {
		$singleTransition = '.essb_links a { -webkit-transition: all 0.2s linear;-moz-transition: all 0.2s linear;-ms-transition: all 0.2s linear;-o-transition: all 0.2s linear;transition: all 0.2s linear;}';
		$this->add_rule($singleTransition);
		
		switch ($animation) {
			case "pop":
				$this->add_rule('.essb_links a:hover {transform: translateY(-5px);-webkit-transform:translateY(-5px);-moz-transform:translateY(-5px);-o-transform:translateY(-5px); }');
				break;
			case "zoom":
				$this->add_rule('.essb_links a:hover {transform: scale(1.2);-webkit-transform:scale(1.2);-moz-transform:scale(1.2);-o-transform:scale(1.2); }');
				break;
			case "flip":
				$this->add_rule('.essb_links a:hover {transform: rotateZ(360deg);-webkit-transform:rotateZ(360deg);-moz-transform:rotateZ(360deg);-o-transform:rotateZ(360deg); }');
				break;
				
		}
	}
	
}

?>