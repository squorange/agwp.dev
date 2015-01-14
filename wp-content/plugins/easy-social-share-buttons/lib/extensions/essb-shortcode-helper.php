<?php

class EasySocialShareButtons_ShortcodeHelper {
	public static function unified_true($value) {
		$out = $value;
		
		if ($value == "yes") {
			$out = "true";
		}
		if ($value == "no") {
			$out = "false";
		}
		
		return $out;
	}
	
	public static function unified_yes($value) {
		$out = $value;
		
		if ($value == "true") {
			$out = "yes";
		}
		if ($value == "false") {
			$out = "no";
		}
		
		return $out;			
	}
}

?>