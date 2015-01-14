<?php

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) exit;

class ESSBIS_Constants {

	public static function get_version(){
		$versionConstant = '';
		return $versionConstant;
	}

	private static $root_file = null;
	public static function get_root_file() {
		if ( ESSBIS_Constants::$root_file == null )
			ESSBIS_Constants::$root_file = __FILE__;
		return ESSBIS_Constants::$root_file;
	}

	private static $plugin_url = null;
	public static function get_plugin_url() {
		if ( ESSBIS_Constants::$plugin_url == null )
			ESSBIS_Constants::$plugin_url = plugin_dir_url( ESSBIS_Constants::get_root_file() );
		return ESSBIS_Constants::$plugin_url;
	}

	private static $plugin_dir = null;
	public static function get_plugin_dir() {
		if ( ESSBIS_Constants::$plugin_dir == null )
			ESSBIS_Constants::$plugin_dir = plugin_dir_path( ESSBIS_Constants::get_root_file() );
		return ESSBIS_Constants::$plugin_dir;
	}

	private static $admin_screen_id = null;
	public static function get_admin_screen_id() {
		return ESSBIS_Constants::$admin_screen_id;
	}

	public static function set_admin_screen_id( $screen_id ) {
		ESSBIS_Constants::$admin_screen_id = $screen_id;
	}
}

if ( ! class_exists( 'ESSBImageShare' ) ) :

	final class ESSBImageShare {
		/** Singleton *************************************************************/

		private static $instance;

		private $module_manager;

		public static function instance() {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof ESSBImageShare ) ) {
				self::$instance = new ESSBImageShare();
				self::$instance->includes();
			}
			return self::$instance;
		}

		private function includes() {
			global $essbis_options;

			//load utils
			require_once( ESSBIS_Constants::get_plugin_dir() . 'includes/ESSBIS_Utils.php');

			//load modules
			require_once( ESSBIS_Constants::get_plugin_dir() . 'includes/modules/ESSBIS_Base_Module.php');
			require_once( ESSBIS_Constants::get_plugin_dir() . 'includes/modules/ESSBIS_Main_Module.php');
			require_once( ESSBIS_Constants::get_plugin_dir() . 'includes/modules/ESSBIS_Hover_Module.php');
			require_once( ESSBIS_Constants::get_plugin_dir() . 'includes/modules/ESSBIS_Button_Settings_Module.php');
			require_once( ESSBIS_Constants::get_plugin_dir() . 'includes/modules/ESSBIS_Module_Manager.php');

			$modules = array(
				new ESSBIS_Main_Module(),
				new ESSBIS_Button_Settings_Module(),
				new ESSBIS_Hover_Module()
			);
			$this->module_manager = new ESSBIS_Module_Manager();
			foreach($modules as $module) {
				$this->module_manager->add_module( $module);
			}

			$essb_image_options = ESSBSocialImageShareOptions::get_instance();
			$essbis_options = $essb_image_options->sis_options;

			
			//load custom post types
			//load widgets
			//load everything else
			require_once( ESSBIS_Constants::get_plugin_dir() . 'includes/misc_functions.php' );
			require_once( ESSBIS_Constants::get_plugin_dir() . 'includes/scripts.php' );
			require_once( ESSBIS_Constants::get_plugin_dir() . 'includes/content.php' );

		
		}


		public function get_module_manager() {
			return $this->module_manager;
		}
	}

endif; // End if class_exists check


function ESSBImageShare() {
	return ESSBImageShare::instance();
}

// Get ESSBImageShare Running
ESSBImageShare();

add_filter( 'body_class', 'essbis_class_names' );
function essbis_class_names( $classes ) {
	// add 'class-name' to the $classes array
	$classes[] = 'essbis_site';
	// return the $classes array
	return $classes;
}