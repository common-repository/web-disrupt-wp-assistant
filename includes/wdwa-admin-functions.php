<?php

class Web_Disrupt_WordPress_Assistant_Admin_Functions {

       /**
        * Assign all admin AJAX action to the proper hooks
        *
        * @since 1.0.0
        */
    	public function __construct(){

		if( is_admin()){
			// UI actions
			$UI_Actions = array(
				'wp_ajax_wdwa_generate_theme' => 'wdwa_generate_theme'
				);
			foreach ($UI_Actions as $hook => $function) { 
				add_action($hook , array( $this, $function ));
			}
		}

	}

	/**
	 * Generate Disrupt One Theme and return Activation link
	 *
	 * @since 1.0.0
	 */
	public function wdwa_generate_theme(){

		Web_Disrupt_WordPress_Assistant::$helpers->copy_recursive(Web_Disrupt_WordPress_Assistant::$plugin_data["theme-src"], Web_Disrupt_WordPress_Assistant::$plugin_data["theme-dest"]);
		echo site_url("/wp-admin/themes.php?action=activate&stylesheet=".Web_Disrupt_WordPress_Assistant::$plugin_data["theme"]."&_wpnonce=".wp_create_nonce("switch-theme_".Web_Disrupt_WordPress_Assistant::$plugin_data["theme"]));
		wp_die();

	}



}