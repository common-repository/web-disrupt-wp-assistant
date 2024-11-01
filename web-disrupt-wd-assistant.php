<?php
/**
 * Plugin Name: Web Disrupt WP Assistant
 * Plugin URI: https://webdisrupt.com/
 * Description: Web Disrupt WordPress Assistant is a very simple, yet powerful way to maximize the power of WordPress.
 * Author: Web Disrupt
 * Version: 2.0.3
 * 
 * Copyright 2018 Web Disrupt - Contact us at https://webdisrupt.com/
 *
 * @package WebDisrupt WordPress Assistant
 * 
 */


/**  Main Lead Master Class that encompasses all it's functionality */
class Web_Disrupt_WordPress_Assistant {

	/**
	 * All the plugin specific Data
	 *
	 * @var Static data - Define all important magic strings
	 * @since 1.0.0
	 */
	static $plugin_data = null;	

	/**
	 * Initiates all global init functionality
	 *
	 * @var  Web_Disrupt_WordPress_Assistant_Init()
	 * @since 1.0.0
	 */
	 static $init = null;

	/**
	 * Backend admin functions
	 *
	 * @var  Web_Disrupt_WordPress_Assistant_Admin_Functions()
	 * @since 1.0.0
	 */
	 static $admin_functions = null;

    /**
	 * DB data functions
	 *
	 * @var  Web_Disrupt_WordPress_Assistant_DB()
	 * @since 1.0.0
	 */
	 static $db = null;

	/**
	 * helper functions to handle complicated reusable code
	 *
	 * @var  Web_Disrupt_WordPress_Assistant_helpers()
	 * @since 1.0.0
	 */
	 static $helpers = null;

	/**
	 * User interface
	 *
	 * @var  Web_Disrupt_WordPress_Assistant_UI()
	 * @since 1.0.0
	 */
	 static $ui = null;

	/**
	 * Creates and returns the main object for this plugin
	 *
	 *
	 * @since  1.0.0
	 * @return Web_Disrupt_WordPress_Assistant
	 */
	static public function init() {

		static $instance = null;
		if ( null === $instance ) {
			$instance = new Web_Disrupt_WordPress_Assistant();
		}

		return $instance;
	}

	/**
	 * Main Constructor that sets up all static data associated with this plugin.
	 *
	 *
	 * @since  1.0.0
	 *
	 */
	private function __construct() {

		// Setup static plugin_data
		self::$plugin_data = array(
		"name"            => "Web Disrupt WP Assistant",
		"slug"            => "wdwa-menu",
		"version"         => "2.0.2",
		"author"          => "Web Disrupt",
		"description"     => "Web Disrupt WordPress Assistant will change the way you WordPress forever.",
		"logo"            => plugins_url( 'images/logo.png', __FILE__ ),
		"typography"      => plugins_url( 'images/typography.png', __FILE__ ),
		"img-lib"         => plugins_url( 'images/interface/', __FILE__ ),
		"theme"           => 'disrupt-one',
		"theme-src"       => plugin_dir_path( __FILE__ ).'templates/disrupt-one',
		"theme-dest"      => get_theme_root().'/disrupt-one',
		"url-author"      => "https://webdisrupt.com/",
		"this-root"       => plugins_url( '', __FILE__ )."/",
		"this-dir"        => plugin_dir_path( __FILE__ ),
		"plugins-dir"     => plugin_dir_path(dirname (__FILE__))
		);



		// LM Core Classes & Class Extensions
		require_once 'includes/wdwa-admin-functions.php';
		require_once 'includes/wdwa-helpers.php';
		require_once 'includes/wdwa-ui.php';
		

		// Initiate Classes
		self::$admin_functions = new Web_Disrupt_WordPress_Assistant_Admin_Functions();
		self::$helpers = new Web_Disrupt_WordPress_Assistant_Helpers();
		self::$ui = new Web_Disrupt_WordPress_Assistant_UI();


	}


}


// Initialize the Web Disrupt Assistant
Web_Disrupt_WordPress_Assistant::init();

?>