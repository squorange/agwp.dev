<?php

class ESSBCache {
	
	public static $cacheFolder = "";
	public static $cacheURL = "";
	public static $cacheTime = 3600;
	public static $isActive = false;
	
	public static function activate($cache_mode) {
		
		$upload_dir = wp_upload_dir ();
		
		$base_path = $upload_dir ['basedir'] . '/essb_cache/';
		$base_url = $upload_dir['baseurl'] . '/essb_cache/';
		
		if ( is_ssl()) {
			$base_url = str_replace( 'http://', 'https://', $base_url );
		}
		
		if (! is_dir ( $base_path )) {
			if (! mkdir ( $base_path, 0777 )) {
				
				return false;
			}
		
		}
		self::$cacheFolder = $base_path;
		self::$cacheURL = $base_url;
		if ($cache_mode != 'resource') {
			define('ESSB_CACHE_ACTIVE', true);
			define('ESSB_CACHE_ACTIVE_RESOURCE', true);
		}
		else {
			define('ESSB_CACHE_ACTIVE_RESOURCE', true);
		}
		self::$isActive = true;
		return true;
	}
	
	public static function put($id = '', $data = '') {
		if (!self::$isActive) { return; }
		$id = self::key_parser ( $id );
		
		$filename = self::$cacheFolder . $id . '_cache.txt';
		
		if (! file_put_contents ( $filename, $data )) {
			return false;
		}
		
		return true;
	}
	
	public static function put_resource($id = '', $data = '', $type = 'css') {
		if (!self::$isActive) {
			return;
		}
		$id = self::key_parser ( $id );
	
		$filename = self::$cacheFolder . $id . '.'.$type;
	
		if (! file_put_contents ( $filename, $data )) {
			return false;
		}
	
		return true;
	}
	
	public static function key_parser($id) {
		$id = strtolower ( $id );
		$id = str_replace ( ' ', '_', $id );
		$id = md5($id);
		return $id;
	}
	
	public static function get($id = '', $data = '') {
		if (!self::$isActive) {
			return "";
		}
		$id = self::key_parser ( $id );
		
		$filename = self::$cacheFolder . $id . '_cache.txt';
		if (file_exists ( $filename )) {
			$expires = self::$cacheTime;
			$age = (time() - filemtime ($filename));
			if ($age < $expires) {
				$data = file_get_contents ($filename);
				return $data;
			}
			else {
				return "";
			}
		} 
		else {
			return "";
		}
	}
	
	public static function get_resource($id = '', $type = 'css') {
		if (!self::$isActive) {
			return "";
		}
		$id = self::key_parser ( $id );
	
		$filename = self::$cacheFolder . $id . '.'.$type;
		if (file_exists ( $filename )) {
			$expires = self::$cacheTime;
			$age = (time() - filemtime ($filename));
			if ($age < $expires) {
				$data = self::$cacheURL. $id . '.'.$type;
				return $data;
			}
			else {
				return "";
			}
		}
		else {
			return "";
		}
	}
	
	public static function flush() {
		if (!self::$isActive) {
			return;
		}
		$base_path = self::$cacheFolder;
		
		if (is_dir ( $base_path )) {
			self::recursiveRemoveDirectory ( $base_path );			
			//self::activate ();
		
		}
		return false;
	}
	
	public static function flush_single($id) {
		if (!self::$isActive) {
			return "";
		}
		$id = self::key_parser ( $id );
		
		$filename = self::$cacheFolder . $id . '_cache.txt';
		if (file_exists ( $filename )) {
			unlink ( $filename );
		}			
	}
	
	public static function recursiveRemoveDirectory($directory) {
		foreach ( glob ( "{$directory}/*" ) as $file ) {
			if (is_dir ( $file )) {
				self::recursiveRemoveDirectory ( $file );
			} else {
				unlink ( $file );
			}
		}
		//rmdir ( $directory );
	}
}

?>