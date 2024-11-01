<?php
/**
 * WD Assistant UI which extends the shared UI class in the core
 *
 * @package Web Disrupt WordPress Assistant
 */
class Web_Disrupt_WordPress_Assistant_UI {

	/**
	 * Post Types available
	 *
	 * @var  An array of all the get_post_types()
	 * @since 1.0.0
	 */
	private $post_types = NUll;
	private $meta_data = array("lm_input_type" => "");

	public function __construct(){
		if( is_admin()){
			// UI actions
			$UI_Actions = array(
				'admin_menu' => "init_admin_menu_item",
				'admin_enqueue_scripts' => "LM_admin_enqueue"
				);
			foreach ($UI_Actions as $hook => $function) { 
				add_action($hook , array( $this, $function ));
			}
		}
	}

	/**
	 * Admin Enqueue -  Which encompasss all scripts and styles for the wp-admin areas
	 *
	 * @since 1.0.0
	 */
	public function LM_admin_enqueue($hook) {

		 // If its not the main post page then exit now
		if ( 'toplevel_page_wdwa' != $hook && 'wpe-dashboard_page_wdwa' != $hook ) {
			return;
		}
		// Load only in admin area 
		wp_enqueue_style(  'wdwa-admin-styles', Web_Disrupt_WordPress_Assistant::$plugin_data["this-root"].'style.css', '', false );
		wp_enqueue_style(  'font-awesome', Web_Disrupt_WordPress_Assistant::$plugin_data["this-root"].'3pl/font-awesome/css/font-awesome.min.css', '', false );
		
	}


	/* Attach LM dashboard to the admin menu or inside the dashboard if it exists
	 *
	 * @since 1.0.0
	 */
	public function init_admin_menu_item() {

		$icon_url = plugins_url('../images/icon.png', __FILE__);
		add_menu_page('WD Assistant', 'WD Assistant', 'administrator', 'wdwa', array($this, 'init_admin_page'), $icon_url);
	
	}
	


	/**
	 * Render the layout and setup data for settings page
	 *
	 * @since 1.0.0
	 */  		
	public function init_admin_page() {

		$data = array(
			"name" => Web_Disrupt_WordPress_Assistant::$plugin_data["name"],
			"version" => Web_Disrupt_WordPress_Assistant::$plugin_data["version"],
			"desc" => Web_Disrupt_WordPress_Assistant::$plugin_data["description"],
			"author" => Web_Disrupt_WordPress_Assistant::$plugin_data["author"],
			"logo" => Web_Disrupt_WordPress_Assistant::$plugin_data["logo"],
			"typography" => Web_Disrupt_WordPress_Assistant::$plugin_data["typography"],
			"images_path" => Web_Disrupt_WordPress_Assistant::$plugin_data["img-lib"],
			"plugins_path" => Web_Disrupt_WordPress_Assistant::$plugin_data['plugins-dir'],
			"wdwa_theme" => array(
				
			),
			"wdwa_plugins" => array(
				array(
					"title"      =>  "Elementor",
					"desc"       =>  "Elementor is one of the fastest and easiest page builders. Elementor allows you to build and reuse content very easily. Great for newbies and developers alike.",
					"wp-name"    =>  "elementor",
					"plugin"     =>  "elementor/elementor.php",
					"folder"     =>   Web_Disrupt_WordPress_Assistant::$plugin_data['plugins-dir'] . "elementor"
				), 
				array(
					"title"      =>  "Funnelmentals",
					"desc"       =>  "Adds a couple key powerful features to elementor.",
					"wp-name"    =>  "web-disrupt-funnelmentals",
					"plugin"     =>  "web-disrupt-funnelmentals/web-disrupt-funnelmentals.php",
					"folder"     =>  Web_Disrupt_WordPress_Assistant::$plugin_data['plugins-dir'] . "web-disrupt-funnelmentals"
				),
				array(
					"title"      =>  "Elementor Library Unlimited",
					"desc"       =>  "A constantly updating template library.",
					"wp-name"    =>  "web-disrupt-elementor-extended-template-library",
					"plugin"     =>  "web-disrupt-elementor-extended-template-library/web-disrupt-elementor-library-unlimited.php",
					"folder"     =>  Web_Disrupt_WordPress_Assistant::$plugin_data['plugins-dir'] . "web-disrupt-elementor-extended-template-library"
				),
	   		),
			"wdwa_optional_plugins" => array(
				array(
					"title"      =>  "Yoast SEO",
					"desc"       =>  "Optimize for search engine results.",
					"wp-name"    =>  "wordpress-seo",
					"plugin"     =>  "wordpress-seo/wp-seo.php",
					"folder"     =>  Web_Disrupt_WordPress_Assistant::$plugin_data['plugins-dir'] . "wordpress-seo"
				),
				array(
					"title"      =>  "WooCommerce",
					"desc"       =>  "For selling ecommerce products",
					"wp-name"    =>  "woocommerce",
					"plugin"     =>  "woocommerce/woocommerce.php",
					"folder"     =>  Web_Disrupt_WordPress_Assistant::$plugin_data['plugins-dir'] . "woocommerce"
				),
				array(
					"title"      =>  "WC Stripe Checkout",
					"desc"       =>  "Best non-disruptive checkout process.",
					"wp-name"    =>  "woocommerce-gateway-stripe",
					"plugin"     =>  "woocommerce-gateway-stripe/woocommerce-gateway-stripe.php",
					"folder"     =>  Web_Disrupt_WordPress_Assistant::$plugin_data['plugins-dir'] . "woocommerce-gateway-stripe"
				)
			),
			"premium_sidebar" => array(
				array(
					"check"     =>  "",
					"image"     =>  "web-disrupt-icon.png",
					"link"      =>  "https://webdisrupt.com/",
					"title"     =>  "Free Training",
				),
				array(
					"check"     =>  "sg-cachepress/sg-cachepress.php",
					"image"     =>  "siteground-logo.png",
					"link"      =>  "https://www.siteground.com/go/webdisrupt",
					"title"     =>  "Upgrade Hosting",
				),
				array(
					"check"     =>  "elementor-pro/elementor-pro.php",
					"image"     =>  "elementor-pro-icon.png",
					"link"      =>  "https://elementor.com/pro/?ref=1544&campaign=webdisrupt",
					"title"     =>  "Get Elemnetor Pro",
				),
				array(
					"check"     =>  "web-disrupt-funnelmentals/web-disrupt-funnelmentals.php",
					"image"     =>  "funnelmentals-pro-icon.png",
					"link"      =>  "https://webdisrupt.com/funnelmentals/",
					"title"     =>  "Get Funnelmentals Pro",
				)
			)
		);
		

		$this->load_template( Web_Disrupt_WordPress_Assistant::$plugin_data["this-dir"].'templates/settings', $data );
	}


	/**
	* Loads a PHP Rendered Template
	*
	* The filename is the full path Directory path without the ".php"
	* Use the $data parameter to pass data into each template as needed
	*
	* @since  1.0.0
	* @param  string $name is the template name.
	* @param  array  $data extracted into variables & passed into the template. Must be key value pairs!
	*/
	public function load_template($filename, $data = array()){
		if(isset($filename)){
			extract($data);
			require $filename.".php";
		}
	}


}