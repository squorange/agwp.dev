<?php

class ESSBShortcodeGenerator {
	
	public $shortcodeOptions;
	public $shortcode = "";
	public $shortcodeTitle = "";
	
	public $optionsGroup = "shortcode";
	private $counterPositions;
	private $templates;
	private $totalCounterPosition;
	
	function __construct() {
		$this->shortcodeOptions = array();
		
		$this->templates = array();
		$this->templates[''] = "Default template from settings";
		$this->templates['default'] = "Default";
		$this->templates['metro'] = "Metro";
		$this->templates['modern'] = "Modern";
		$this->templates['roud'] = "Round";
		$this->templates['big'] = "Big";
		$this->templates['metro-retina'] = "Metro (Retina)";
		$this->templates['big-retina'] = "Big (Retina)";
		$this->templates['light-retina'] = "Light (Retina)";
		$this->templates['flat-retina'] = "Flat (Retina)";
		$this->templates['tiny-retina'] = "Tiny (Retina)";
		$this->templates['round-retina'] = "Round (Retina)";
		$this->templates['modern-retina'] = "Modern (Retina)";
		$this->templates['circles-retina'] = "Circles (Retina)";
		$this->templates['blocks-retina'] = "Blocks (Retina)";
		$this->templates['dark-retina'] = "Dark (Retina)";
		$this->templates['grey-circles-retina'] = "Grey Circles (Retina)";
		$this->templates['grey-blocks-retina'] = "Grey Blocks (Retina)";
		$this->templates['clear-retina'] = "Clear (Retina)";
		
		$this->counterPositions = array();
		$this->counterPositions[''] = "Default counter position";
		$this->counterPositions['left'] = "Left";
		$this->counterPositions['right'] = "Right";
		$this->counterPositions['inside'] = "Inside button";
		$this->counterPositions['insidename'] = "Inside button with Network Names";
		$this->counterPositions['hidden'] = "Hidden";
		$this->counterPositions['leftm'] = "Left Modern";
		$this->counterPositions['rightm'] = "Right Modern";
		$this->counterPositions['top'] = "Top Modern";
		$this->counterPositions['topm'] = "Top Mini";
		$this->counterPositions['bottom'] = "Bottom";
		
		$this->totalCounterPosition = array();
		$this->totalCounterPosition[''] = "Default counter position";
		$this->totalCounterPosition['left'] = "Left";
		$this->totalCounterPosition['right'] = "Right";
		$this->totalCounterPosition['leftbig'] = "Left Big Number";
		$this->totalCounterPosition['rightbig'] = "Right Big Number";
		$this->totalCounterPosition['none'] = "Hidden";
	}
	
	/*
	 * @$param : the shortcode param
	 * @$options : shortcode param options to be provided in following structure
	 *    array("type" => "",
	 *          "text" => "",
	 *          "comment" => "",
	 *          "value" => "",
	 *          "sourceOptions" => "",
	 *          "fullwidth" => ""
	 */
	function register($param, $options) {
		$this->shortcodeOptions[$param] = $options;
	}
	
	function renderNavigation() {
		echo '<li id="essb-menu-1" class="essb-menu-item"><a href="#"
						onclick="return false;">'.$this->shortcodeTitle.'</a></li>';
		
		$sectionCount = 1;
		
		foreach ($this->shortcodeOptions as $param => $settings) {
			$type = isset($settings['type']) ? $settings['type'] : 'textbox';
			
			if ($type == "section") {
				$text = isset($settings['text']) ? $settings['text'] : '';
				echo '<li id="essb-menu-1-'.$sectionCount.'" class="essb-submenu-item"><a href="#"
						onclick="essb_submenu_execute(\''.$sectionCount.'\'); return false;">'.$text.'</a></li>';
				$sectionCount++;
			}
		}
	}
	
	function render() {
		
		$required_js = "";
		
		echo '<table border="0" cellpadding="5" cellspacing="0" width="100%">
						<col width="25%" />
						<col width="75%" />';
		
		echo '<tr class="table-border-bottom">';
		echo '<td colspan="2" class="sub">'.$this->shortcodeTitle.'</td>';
		echo '</tr>';
		
		$cnt = 0;
		$sectionCount = 1;
		
		foreach ($this->shortcodeOptions as $param => $settings) {
			$type = isset($settings['type']) ? $settings['type'] : 'textbox';
			switch ($type) {
				case "section":
					$this->renderSection($param, $settings, $sectionCount);
					$sectionCount++;
					break;
				case "textbox" :
					$this->renderTextbox($param, $settings, $cnt);
					break;
				case "checkbox":
					$this->renderCheckbox($param, $settings, $cnt);
					break; 
				case "dropdown":
					$this->renderDropDown($param, $settings, $cnt);
					break;
				case "networks":
					$this->renderNetworkSelection($param, $settings, $cnt);
					break;
				case "network_names":
					$this->renderNetworkNames($param, $settings, $cnt);
					break;
			}
			
			$cnt++;
		}
		
		echo '</table>';
		
	}

	function renderSection($param, $settings, $cnt) {
		$text = isset($settings['text']) ? $settings['text'] : '';
		
		echo '<tr class="table-border-bottom">';
		
		echo '<td class="sub3" colspan="2" id="essb-submenu-'.$cnt.'">'.$text.'</td>';
		
		echo '</tr>';
	}
	
	function renderTextbox($param, $settings, $cnt) {
		$text = isset($settings['text']) ? $settings['text'] : '';
		$comment = isset($settings['comment']) ? $settings['comment'] : '';
		$default_value = isset($settings['value']) ? $settings['value'] : '';
		$fullwidth = isset($settings["fullwidth"]) ? $settings["fullwidth"] : "";
		
		$cssClass = ($cnt % 2 == 0) ? "even" : "odd";
		
		echo '<tr class="'.$cssClass.' table-border-bottom">';
		echo '<td class="bold" valign="top">'.$text.'<br/><span class="label">'.$comment.'</span></td>';
		echo '<td class="essb_general_options">';
		echo '<input id="'.$param.'" type="text" name="'.$this->optionsGroup.'['.$param.']" value="' . $default_value . '" class="input-element '.($fullwidth == "true" ? "stretched" : "").'" />';
		echo '</td>';
		echo '</tr>';		
	}
	
	function renderCheckbox($param, $settings, $cnt) {
		$text = isset($settings['text']) ? $settings['text'] : '';
		$comment = isset($settings['comment']) ? $settings['comment'] : '';
		$default_value = isset($settings['value']) ? $settings['value'] : '';
		
		$cssClass = ($cnt % 2 == 0) ? "even" : "odd";
		
		echo '<tr class="'.$cssClass.' table-border-bottom">';
		echo '<td class="bold" valign="top">'.$text.'<br/><span class="label">'.$comment.'</span></td>';
		echo '<td class="essb_general_options">';
		echo '<input id="'.$param.'" type="checkbox" name="'.$this->optionsGroup.'['.$param.']" value="' . $default_value . '" />';
		echo '</td>';
		echo '</tr>';
	}
	
	function renderDropDown($param, $settings, $cnt) {
		$text = isset($settings['text']) ? $settings['text'] : '';
		$comment = isset($settings['comment']) ? $settings['comment'] : '';
		$default_value = isset($settings['value']) ? $settings['value'] : '';
		$fullwidth = isset($settings["fullwidth"]) ? $settings["fullwidth"] : "";
		$values = isset($settings['sourceOptions']) ? $settings['sourceOptions'] : array();
		
		$cssClass = ($cnt % 2 == 0) ? "even" : "odd";
		
		echo '<tr class="'.$cssClass.' table-border-bottom">';
		echo '<td class="bold" valign="top">'.$text.'<br/><span class="label">'.$comment.'</span></td>';
		echo '<td class="essb_general_options">';
		echo '<select id="'.$param.'" name="'.$this->optionsGroup.'['.$param.']" class="input-element '.($fullwidth == "true" ? "stretched" : "").'">';
		
		foreach ($values as $key => $single) {
				printf('<option value="%s" %s>%s</option>',
							$key,
							($key == $value ? 'selected' : ''),
							$single
					);
		}
		
		echo '</select>';
		echo '</td>';
		echo '</tr>';
	}
	
	function renderNetworkNames($param, $settings, $cnt) {
	$text = isset($settings['text']) ? $settings['text'] : '';
		$comment = isset($settings['comment']) ? $settings['comment'] : '';
		$default_value = isset($settings['value']) ? $settings['value'] : '';
		$fullwidth = isset($settings["fullwidth"]) ? $settings["fullwidth"] : "";
		$values = isset($settings['sourceOptions']) ? $settings['sourceOptions'] : array();
		
		$cssClass = ($cnt % 2 == 0) ? "even" : "odd";
		
		echo '<tr class="'.$cssClass.' table-border-bottom">';
		echo '<td class="bold" valign="top">'.$text.'<br/><span class="label">'.$comment.'</span></td>';
		echo '<td class="essb_general_options">';
		echo '<ul id="'.$param.'">';
		$y = $n = '';
		$options = get_option ( EasySocialShareButtons::$plugin_settings_name );
		$network_list = "";
		if (is_array ( $options )) {
			foreach ( $options ['networks'] as $k => $v ) {
				
				if ($network_list !='') {
					$network_list .= ',';
				}
				$network_list .= $k;
				
				$is_checked = "";
				$network_name = isset ( $v [1] ) ? $v [1] : $k;
					
				echo '<li><p style="margin: .2em 5% .2em 0;">
						<input id="network__name_' . $k . '" name="'.$this->optionsGroup.'[' . $k . '_text]" type="text"
								class="input-element" />
						<label for="network_name_' . $k . '"><span class="essb_icon essb_icon_' . $k . '"></span>' . $network_name . '</label>
						</p></li>';
			}
		
		}
		echo '</ul>';
		echo '<input type="hidden" name="'.$this->optionsGroup.'['.$param.']" value="'.$network_list.'"/>';
	}
	
	function renderNetworkSelection($param, $settings, $cnt) {
		$text = isset($settings['text']) ? $settings['text'] : '';
		$comment = isset($settings['comment']) ? $settings['comment'] : '';
		$default_value = isset($settings['value']) ? $settings['value'] : '';
		$fullwidth = isset($settings["fullwidth"]) ? $settings["fullwidth"] : "";
		$values = isset($settings['sourceOptions']) ? $settings['sourceOptions'] : array();
		
		$cssClass = ($cnt % 2 == 0) ? "even" : "odd";
		
		echo '<tr class="'.$cssClass.' table-border-bottom">';
		echo '<td class="bold" valign="top">'.$text.'<br/><span class="label">'.$comment.'</span></td>';
		echo '<td class="essb_general_options">';
		echo '<ul id="'.$param.'">';
		$y = $n = '';
		$options = get_option ( EasySocialShareButtons::$plugin_settings_name );
		
		
		
		if (is_array ( $options )) {
			foreach ( $options ['networks'] as $k => $v ) {
					
				$is_checked = "";
				$network_name = isset ( $v [1] ) ? $v [1] : $k;
				
				
				echo '<li><p style="margin: .2em 5% .2em 0;">
				<input id="network_selection_' . $k . '" value="' . $k . '" name="'.$this->optionsGroup.'['.$param.'][]" type="checkbox"
				' . $is_checked . ' /><input name="'.$this->optionsGroup.'[sort][]" value="' . $k . '" type="checkbox" checked="checked" style="display: none; " />
				<label for="network_selection_' . $k . '"><span class="essb_icon essb_icon_' . $k . '"></span>' . $network_name . '</label>
				</p></li>';
			}
		
		}
		echo '</ul>';
		
		
		
		echo '<script type="text/javascript">
jQuery(document).ready(function(){
    jQuery(\'#'.$param.'\').sortable();
});
</script>';
		
		echo '</td>';
		echo '</tr>';
	}
	
	public function generate($options) {
		$output = "";
		//print_r($options);
		$output .= '['.$this->shortcode;
		
		foreach ($this->shortcodeOptions as $param => $settings) {
			$value = isset($options[$param]) ? $options[$param] : '';
			$type = isset($settings['type']) ? $settings['type'] : 'textbox';
			if ($type == "section") { continue; }
			
			if ($type == "networks") {
				
				if (count($value) > 0 && $value != '') {
				$network_list = "";
				foreach ( $value as $nw ) {
					if ($network_list != '') {
						$network_list .= ",";
					}
					$network_list .= $nw;
				}
				
				if ($network_list == "") {
					$network_list = "no";
				}
				
				$value = $network_list;
				}
			}
			
			if ($type == "network_names") {
				$networks = preg_split('#[\s+,\s+]#', $value);
				$network_list = "";
				
				foreach ($networks as $k) {
					$text_for_network = isset($options[$k.'_text'])	? $options[$k.'_text'] : '';
					
					if ($text_for_network != '') {
						if ($network_list != '' ) { $network_list .= ' '; }
						$network_list .= $k.'_text="'.$text_for_network.'"';
					}
				}
				
				$value = $network_list;
			}
			
			if ($param == "counters" && $value == '') { $value = '0'; }
			
			if ($value != '') {
				
				if ($param == "counters") {
					$output .= ' '.$param.'='.$value.'';
				}
				else if ($param == "network_names") {
					$output .= ' '.$value;
				}
				else {
					$output .= ' '.$param.'="'.$value.'"';
				}
			}
		}
		
		$output .= ']';
		
		echo '<div class="essb-shortcode-title">Your generated shortcode is</div>';
		echo '<div class="essb-shortcode">';
		echo $output;
		echo '</div>';
		
		echo '<div class="essb-shortcode-title">Include your shortcode into template files using this sample code</div>';
		echo '<div class="essb-shortcode-code"><code>';
		echo '&lt;?php&nbsp;';
		echo 'echo do_shortcode(\''.$output.'\');&nbsp;';
		echo '?&gt;&nbsp;</code>';
		
		echo '<br/><br/>To get the current post/page title and permalink you can use the following code: <br/><code>$url = get_permalink($post->ID);<br/> 
&nbsp;$title = get_the_title($post-ID);</code>';
	}
	
	// initialize shortcodes
	public function activate($shortcode = 'easy-social-share') {
		if ($shortcode == 'easy-social-share') {
			$this->includeOptionsForEasyShare();
		}
		
		if ($shortcode == 'easy-social-like') {
			$this->includeOptionsForEasyLike();
		}
		
		if ($shortcode == 'easy-total-shares') {
			$this->includeOptionsForTotalShares();
		}
	}
	
	private function includeOptionsForTotalShares() {
		$this->shortcode = 'easy-total-share';
		$this->shortcodeTitle = '[easy-total-share] Shortcode';
		
		$this->register("message", array("type" => "textbox", "text" => "Message before the total counter:", "comment" => "Custom message before the share counter", "value" => "", "fullwidth" => "true"));
		$this->register("url", array("type" => "textbox", "text" => "Custom URL to extract total counter for:", "comment" => "Provide only if you wish get counter for different page then the shortcode is used", "value" => "", "fullwidth" => "true"));
		$this->register("align", array("type" => "dropdown", "text" => "Align:", "comment" => "", "sourceOptions" => array("left" => "Left", "center" => "Center", "right" => "Right")));
		$this->register("share_text", array("type" => "textbox", "text" => "Text for shares after the number:", "comment" => "Provide custom text if you wish to display after share number value", "value" => "", "fullwidth" => "true"));
		$this->register("fullnumber", array("type" => "checkbox", "text" => "Display full number (not short syntax):", "comment" => "This will display 100 000 instead of 100k", "value" => "yes"));
		$this->register('networks', array("type" => "networks", "text" => "Select Social Networks:", "comment" => "Provide list of networks that will be included. Select none for all."));
		
	}
	
	private function includeOptionsForEasyShare() {
		$this->shortcode = 'easy-social-share';
		$this->shortcodeTitle = '[easy-social-share] Shortcode';

		$this->register('section5', array("type" => "section", "text" => "Social Share Buttons"));
		$this->register('buttons', array("type" => "networks", "text" => "Social Networks:", "comment" => "Select and reorder networks that you want to add shortcode. If you wish to include only native social buttons don't select options here."));

		$this->register("morebutton", array("type" => "dropdown", "text"=> "More button function:", "comment" => "Choose the more button function", "sourceOptions" => array (""=>"", "1" => "Display all active networks after more button", "2" => "Display all social networks as popup", "3" => "Display only active social networks as popup" )));
		
		$this->register('section1', array("type" => "section", "text" => "Counters"));
		
		$this->register("counters", array("type" => "checkbox", "text" => "Include Counters:", "comment" => "Activate display of share counters", "value" => "1"));
		$this->register("counter_pos", array("type" => "dropdown", "text"=> "Counter position", "comment" => "Choose poistion of counters", "sourceOptions" => $this->counterPositions));
		$this->register("total_counter_pos", array("type" => "dropdown", "text"=> "Total counter position", "comment" => "Choose poistion of total counters", "sourceOptions" => $this->totalCounterPosition));
		
		$this->register('section2', array("type" => "section", "text" => "Button Style"));
		$this->register("hide_names", array("type" => "dropdown", "text"=> "Hide network names", "comment" => "", "sourceOptions" => array(""=>"", "no" => "Do not hide network names", "yes" => "Hide network names and display them on hover", "force" => "Always hide network names")));
		
		$this->register("fullwidth", array("type" => "checkbox", "text" => "Full width share buttons:", "comment" => "Activate display of full width share buttons", "value" => "yes"));
		$this->register("fullwidth_fix", array("type" => "textbox", "text" => "Full width share buttons single element width correction:", "comment" => "Correct width of single share button (between 0 and 100)", "value" => ""));
		
		$this->register("fixedwidth", array("type" => "checkbox", "text" => "Fixed width share buttons:", "comment" => "Activate display of fixed width share buttons", "value" => "yes"));
		$this->register("fixedwidth_px", array("type" => "textbox", "text" => "Fixed width button width:", "comment" => "Provide width of element in px without the px mark (example 120)", "value" => ""));
		$this->register("fixedwidth_align", array("type" => "dropdown", "text" => "Choose alignment of network name when fixed width is used:", "comment" => "Provide different alignment of network name (counter when position inside or inside name) when fixed button width is activated. Default value is center.", "sourceOptions" => array (""=>"Center", "left" => "Left", "right" => "Right" )));
		
		$this->register("message", array("type" => "checkbox", "text" => "Display message above buttons:", "comment" => "This will display the message that you provide in options", "value" => "yes"));
		$this->register("template", array("type" => "dropdown", "text"=> "Template", "comment" => "Choose different template for buttons in shortcode", "sourceOptions" => $this->templates));

		$this->register('section3', array("type" => "section", "text" => "Customize shared message"));
		$this->register("url", array("type" => "textbox", "text" => "Share URL:", "comment" => "Provide custom share url. If nothid is filled the page/post address where buttons are displayed will be used", "value" => "", "fullwidth" => "true"));
		$this->register("text", array("type" => "textbox", "text" => "Share Message:", "comment" => "Provide custom share message. If nothid is filled the page/post title where buttons are displayed will be used", "value" => "", "fullwidth" => "true"));

		$this->register('section4', array("type" => "section", "text" => "Additional display options"));
		$this->register("sidebar", array("type" => "checkbox", "text" => "Display social buttons as sidebar:", "comment" => "", "value" => "yes"));
		$this->register("sidebar_pos", array("type" => "dropdown", "text"=> "Choose sidebar poistion", "comment" => "", "sourceOptions" => array(""=>"", "left" => "Left", "right" => "Right", "top" => "Top", "bottm" => "Bottom")));
		$this->register("popup", array("type" => "checkbox", "text" => "Display social buttons as popup:", "comment" => "", "value" => "yes"));
		$this->register("popafter", array("type" => "textbox", "text" => "Display popup window after about of seconds:", "comment" => "If you wish popup to be displayed after amount of time fill the value here", "value" => ""));
		$this->register("float", array("type" => "checkbox", "text" => "Display social buttons as float from top:", "comment" => "", "value" => "yes"));
		$this->register("post_float", array("type" => "checkbox", "text" => "Display social buttons as post vetical float:", "comment" => "", "value" => "yes"));
		$this->register("hide_mobile", array("type" => "checkbox", "text" => "Hide this shortcode display on mobile devices:", "comment" => "", "value" => "yes"));
		
		$this->register('section6', array("type" => "section", "text" => "Social Share Button Texts"));
		$this->register('network_names', array("type" => "network_names", "text" => "Social Network Names:", "comment" => "Provide custom network names instead of default. For example instead of Facebook you can use Share on Facebook"));
		
	}
	
	private function includeOptionsForEasyLike() {
		$this->shortcode = 'easy-social-like';
		$this->shortcodeTitle = '[easy-social-like] Shortcode';
		
		$this->register('section1', array("type" => "section", "text" => "Facebook Like Button"));
		$this->register("facebook", array("type" => "checkbox", "text" => "Include Facebook Like Button:", "comment" => "", "value" => "true"));
		$this->register("facebook_url", array("type" => "textbox", "text" => "Facebook Like Button URL:", "comment" => "", "value" => "", "fullwidth" => "true"));
		$this->register("facebook_width", array("type" => "textbox", "text" => "Width of button:", "comment" => "Provide custom width of button only if it is not fully rendered", "value" => ""));
		$this->register("facebook_skinned_text", array("type" => "textbox", "text" => "Skinned button text overlay:", "comment" => "", "value" => "", "fullwidth" => "true"));
		$this->register("facebook_skinned_width", array("type" => "textbox", "text" => "Skinned button width:", "comment" => "", "value" => ""));
		
		$this->register('section2', array("type" => "section", "text" => "Facebook Follow Button"));
		$this->register("facebook_follow", array("type" => "checkbox", "text" => "Include Facebook Follow Button:", "comment" => "", "value" => "true"));
		$this->register("facebook_follow_url", array("type" => "textbox", "text" => "Facebook Profile URL:", "comment" => "", "value" => "", "fullwidth" => "true"));
		$this->register("facebook_follow_width", array("type" => "textbox", "text" => "Width of button:", "comment" => "Provide custom width of button only if it is not fully rendered", "value" => ""));
		$this->register("facebook_follow_skinned_text", array("type" => "textbox", "text" => "Skinned button text overlay:", "comment" => "", "value" => "", "fullwidth" => "true"));
		$this->register("facebook_follow_skinned_width", array("type" => "textbox", "text" => "Skinned button width:", "comment" => "", "value" => ""));

		$this->register('section3', array("type" => "section", "text" => "Twitter Follow Button"));
		$this->register("twitter_follow", array("type" => "checkbox", "text" => "Include Twitter Follow Button:", "comment" => "", "value" => "true"));
		$this->register("twitter_follow_user", array("type" => "textbox", "text" => "Twitter username:", "comment" => "Without the @", "value" => "", "fullwidth" => "true"));
		$this->register("twitter_follow_skinned_text", array("type" => "textbox", "text" => "Skinned button text overlay:", "comment" => "", "value" => "", "fullwidth" => "true"));
		$this->register("twitter_follow_skinned_width", array("type" => "textbox", "text" => "Skinned button width:", "comment" => "", "value" => ""));
		
		$this->register('section4', array("type" => "section", "text" => "Twitter Tweet Button"));
		$this->register("twitter_tweet", array("type" => "checkbox", "text" => "Include Twitter Tweet Button:", "comment" => "", "value" => "true"));
		$this->register("twitter_tweet_message", array("type" => "textbox", "text" => "Tweet Message:", "comment" => "", "value" => "", "fullwidth" => "true"));
		$this->register("twitter_tweet_skinned_text", array("type" => "textbox", "text" => "Skinned button text overlay:", "comment" => "", "value" => "", "fullwidth" => "true"));
		$this->register("twitter_tweet_skinned_width", array("type" => "textbox", "text" => "Skinned button width:", "comment" => "", "value" => ""));

		$this->register('section5', array("type" => "section", "text" => "Google +1 Button"));
		$this->register("google", array("type" => "checkbox", "text" => "Include Google +1 Button:", "comment" => "", "value" => "true"));
		$this->register("google_url", array("type" => "textbox", "text" => "URL users to give +1:", "comment" => "", "value" => "", "fullwidth" => "true"));
		$this->register("google_skinned_text", array("type" => "textbox", "text" => "Skinned button text overlay:", "comment" => "", "value" => "", "fullwidth" => "true"));
		$this->register("google_skinned_width", array("type" => "textbox", "text" => "Skinned button width:", "comment" => "", "value" => ""));
		
		$this->register('section6', array("type" => "section", "text" => "Google +1 Button"));
		$this->register("google_follow", array("type" => "checkbox", "text" => "Include Google Follow Button:", "comment" => "", "value" => "true"));
		$this->register("google_follow_url", array("type" => "textbox", "text" => "URL to Google+ Profile:", "comment" => "", "value" => "", "fullwidth" => "true"));
		$this->register("google_follow_skinned_text", array("type" => "textbox", "text" => "Skinned button text overlay:", "comment" => "", "value" => "", "fullwidth" => "true"));
		$this->register("google_follow_skinned_width", array("type" => "textbox", "text" => "Skinned button width:", "comment" => "", "value" => ""));

		$this->register('section7', array("type" => "section", "text" => "Youtube Channel Subsribe"));
		$this->register("youtube", array("type" => "checkbox", "text" => "Include Youtube Chanell Subscribe Button:", "comment" => "", "value" => "true"));
		$this->register("youtube_chanel", array("type" => "textbox", "text" => "Youtube Channel ID:", "comment" => "", "value" => "", "fullwidth" => "true"));
		$this->register("youtube_skinned_text", array("type" => "textbox", "text" => "Skinned button text overlay:", "comment" => "", "value" => "", "fullwidth" => "true"));
		$this->register("youtube_skinned_width", array("type" => "textbox", "text" => "Skinned button width:", "comment" => "", "value" => ""));

		$this->register('section8', array("type" => "section", "text" => "Pinterest Pin Button"));
		$this->register("pinterest_pin", array("type" => "checkbox", "text" => "Include Pinterest Pin Button:", "comment" => "", "value" => "true"));
		$this->register("pinterest_pin_skinned_text", array("type" => "textbox", "text" => "Skinned button text overlay:", "comment" => "", "value" => "", "fullwidth" => "true"));
		$this->register("pinterest_pin_skinned_width", array("type" => "textbox", "text" => "Skinned button width:", "comment" => "", "value" => ""));

		$this->register('section9', array("type" => "section", "text" => "Pinterest Follow Button"));
		$this->register("pinterest_follow", array("type" => "checkbox", "text" => "Include Pinterest Follow Button:", "comment" => "", "value" => "true"));
		$this->register("pinterest_follow_display", array("type" => "textbox", "text" => "Text to display in button:", "comment" => "", "value" => "", "fullwidth" => "true"));
		$this->register("pinterest_follow_url", array("type" => "textbox", "text" => "URL to Pinterest Profile:", "comment" => "", "value" => "", "fullwidth" => "true"));
		$this->register("pinterest_follow_skinned_text", array("type" => "textbox", "text" => "Skinned button text overlay:", "comment" => "", "value" => "", "fullwidth" => "true"));
		$this->register("pinterest_follow_skinned_width", array("type" => "textbox", "text" => "Skinned button width:", "comment" => "", "value" => ""));
		
		$this->register('section10', array("type" => "section", "text" => "LinkedIn Company Follow"));
		$this->register("linkedin", array("type" => "checkbox", "text" => "Include LinkedIn Company Follow Button:", "comment" => "", "value" => "true"));
		$this->register("linkedin_company", array("type" => "textbox", "text" => "LinkedIn Company ID:", "comment" => "", "value" => "", "fullwidth" => "true"));
		$this->register("linkedin_skinned_text", array("type" => "textbox", "text" => "Skinned button text overlay:", "comment" => "", "value" => "", "fullwidth" => "true"));
		$this->register("linkedin_skinned_width", array("type" => "textbox", "text" => "Skinned button width:", "comment" => "", "value" => ""));
		
		$this->register('section11', array("type" => "section", "text" => "Visual Options"));
		$this->register("skinned", array("type" => "checkbox", "text" => "Skinned Native Buttons:", "comment" => "", "value" => "true"));
		$this->register("skin", array("type" => "dropdown", "text" => "Skin:", "comment" => "", "sourceOptions" => array("metro" => "Metro", "flat" => "Flat")));
		$this->register("counters", array("type" => "checkbox", "text" => "Counters for Native Buttons:", "comment" => "", "value" => "true"));
		$this->register("align", array("type" => "dropdown", "text" => "Align:", "comment" => "", "sourceOptions" => array("left" => "Left", "center" => "Center", "right" => "Right")));
	}
}

?>