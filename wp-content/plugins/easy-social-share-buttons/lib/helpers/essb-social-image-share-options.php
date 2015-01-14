<?php

class ESSBSocialImageShareOptions {
	private $options_slug = "easy-social-image-share";
	public $sis_options;
	
	private static $instance = null;
	
	public static function get_instance() {
		
		if (null == self::$instance) {
			self::$instance = new self ();
		}
		
		return self::$instance;
	
	} // end get_instance;

	function __construct() {
		$this->sis_options = get_option ( $this->options_slug );
		if (!$this->sis_options || empty($this->sis_options)) {
			$this->sis_options = $this->default_options();
		}
	}
	
	public function default_options() {
		$options = array();
		
		$options["main"] = array("moduleHoverActive" => 0, "moduleLightboxActive" => 0, "moduleShortcodeActive" => 0 );
		$options["buttonSettings"] = array();
		$options["buttonSettings"]["pinterestImageDescription"] = array("titleAttribute", "altAttribute", "postTitle", "mediaLibraryDescription");
		$options["buttonSettings"]["generalUseFullImages"] = 0;
		$options["buttonSettings"]['generalDownloadImageDescription'] = 0;
		$options["buttonSettings"]['twitterHandle'] = "";
		
		$options["hover"] = array();
		$options["hover"]["imageSelector"] = ".essbis-hover-container img";
		$options["hover"]["minImageHeight"] = "100";
		$options["hover"]["minImageWidth"] = "100";
		$options["hover"]["hoverPanelPosition"] = "bottom-left";
		$options["hover"]["buttonSet"] = "default";
		$options["hover"]["theme"] = "default48";
		$options["hover"]["showOnHome"] = "1";
		$options["hover"]["showOnSingle"] = "1";
		$options["hover"]["showOnPage"] = "1";
		$options["hover"]["showOnBlog"] = "1";
		$options["hover"]["showOnLightbox"] = "1";
		
		$options["lightbox"] = array();
		$options["lightbox"]["descriptionSource"] = array("titleAttribute", "altAttribute");
		$options["shortcode"] = array("beforeContent" => 0, "beforeContentShortcodeId" => "", "afterContent" => 0, "afterContentShortcodeId" => "" );
		
		$options["advanced"] = array("additionalJS" => "");
		
		return $options;
	}
	
	public function update($options) {
		
		$options= $this->prepareUpdateValue($options, 'moduleHoverActive', '0');
		$options= $this->prepareUpdateValue($options, 'twitterHandle', '');
		$options= $this->prepareUpdateValue($options, 'imageSelector', '');
		$options= $this->prepareUpdateValue($options, 'minImageHeight', '');
		$options= $this->prepareUpdateValue($options, 'minImageWidth', '');
		$options= $this->prepareUpdateValue($options, 'hoverPanelPosition', '');
		$options= $this->prepareUpdateValue($options, 'showOnHome', '0');
		$options= $this->prepareUpdateValue($options, 'showOnSingle', '0');
		$options= $this->prepareUpdateValue($options, 'showOnPage', '0');
		$options= $this->prepareUpdateValue($options, 'showOnBlog', '0');
		//update_option ( $this->options_slug, $this->default_options() );
		
		$this->sis_options['main']['moduleHoverActive'] = $options['moduleHoverActive'];
		$this->sis_options['buttonSettings']['twitterHandle'] = $options['twitterHandle'];
		$this->sis_options['hover']['imageSelector'] = $options['imageSelector'];
		$this->sis_options['hover']['minImageHeight'] = $options['minImageHeight'];
		$this->sis_options['hover']['minImageWidth'] = $options['minImageWidth'];
		$this->sis_options['hover']['hoverPanelPosition'] = $options['hoverPanelPosition'];
		$this->sis_options['hover']['showOnHome'] = $options['showOnHome'];
		$this->sis_options['hover']['showOnSingle'] = $options['showOnSingle'];
		$this->sis_options['hover']['showOnPage'] = $options['showOnPage'];
		$this->sis_options['hover']['showOnBlog'] = $options['showOnBlog'];
		
		update_option ( $this->options_slug, $this->sis_options );
		
	}
	
	public function prepareUpdateValue($options, $key, $default_value = '') {
		if (!isset($options[$key])) {
			$options[$key] = $default_value;
		}
		
		return $options;
	}
	
	public function is_active_module() {
		$value = "0";
		
		$section = "main";
		$field = "moduleHoverActive";
		
		if (isset($this->sis_options[$section])) {
			$value = isset($this->sis_options[$section][$field]) ? $this->sis_options[$section][$field] : 0;
		}
			
		$is_checked = (intval($value) == 1) ? true : false;
		
		return $is_checked;
	}
	
	public function drawCheckboxField($section, $field){
		//$value = isset($options[$field]) ? $options[$field] : "false";
		$value = "0";
		
		if (isset($this->sis_options[$section])) {
			$value = isset($this->sis_options[$section][$field]) ? $this->sis_options[$section][$field] : 0;
		}
			
		$is_checked = (intval($value) == 1) ? ' checked="checked"' : '';
		echo '<p style="margin: .2em 5% .2em 0;"><input id="'.$field.'" type="checkbox" name="image_share['.$field.']" value="1" ' . $is_checked . ' /></p>';
	}
	
	public function drawInputField($section, $field, $fullwidth = false) {
		$value = "";
		if (isset($this->sis_options[$section])) {
			$value = isset($this->sis_options[$section][$field]) ? $this->sis_options[$section][$field] : "";
		}
		if ($fullwidth) {
			echo '<input id="customshare_text" type="text" name="image_share['.$field.']" value="' . $value . '" class="input-element stretched" />';
		}
		else {
			echo '<input id="customshare_text" type="text" name="image_share['.$field.']" value="' . $value . '" class="input-element" />';
		}
	}
	
	public function drawPositionSelectBox($section, $field) {
		$positions = array("top-left" => "Top Left", "top-middle" => "Top", "top-right" => "Top Right", "middle-left" => "Left", "middle-middle" => "Center", "middle-right" => "Right", "bottom-left" => "Bottom Left", "bottom-middle" => "Bottom", "bottom-right" => "Bottom Right");
		$value = "";
		if (isset($this->sis_options[$section])) {
			$value = isset($this->sis_options[$section][$field]) ? $this->sis_options[$section][$field] : "";
		}
		echo '<select name="image_share['.$field.']" class="input-element">';
			
		
			foreach ($positions as $singleValueCode => $singleValue)
			{
				printf('<option value="%s" %s>%s</option>',
						$singleValueCode,
						($singleValueCode == $value ? 'selected' : ''),
						$singleValue
				);
			}
		
			
		echo '</select>';
		
	}
 }

?>