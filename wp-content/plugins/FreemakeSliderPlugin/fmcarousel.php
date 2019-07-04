<?php

/*
Plugin Name: Freemake Slider
Plugin URI: http://www.freemake.com/free_wordpress_slider_plugin/
Description: WordPress Image and Video Slider Plugin
Version: 1.0
Author: Freemake
Author URI: http://www.freemake.com/
License: Copyright 2016 Freemake, All Rights Reserved
*/

define('FM_CAROUSEL_VERSION', '1.0');
define('FM_CAROUSEL_URL', plugin_dir_url( __FILE__ ));
define('FM_CAROUSEL_PATH', plugin_dir_path( __FILE__ ));
define('FM_CAROUSEL_PLUGIN', basename(dirname(__FILE__)) . '/' . basename(__FILE__));
define('FM_CAROUSEL_PLUGIN_VERSION', '1.0');

require_once 'app/class-fm-carousel-controller.php';

class FM_Carousel_Plugin {
	
	function __construct() {
	
		$this->init();
	}
	
	public function init() {
		
		// init controller
		$this->fm_carousel_controller = new FM_Carousel_Controller();
		
		add_action( 'admin_menu', array($this, 'register_menu') );
		
		add_shortcode( 'fm_carousel', array($this, 'shortcode_handler') );
		
		add_action( 'init', array($this, 'register_script') );
		add_action( 'wp_enqueue_scripts', array($this, 'enqueue_script') );
		
		if ( is_admin() )
		{
			add_action( 'wp_ajax_fm_carousel_save_config', array($this, 'wp_ajax_save_item') );
			add_action( 'admin_init', array($this, 'admin_init_hook') );
		}
		
		$supportwidget = get_option( 'fm_carousel_supportwidget', 1 );
		if ( $supportwidget == 1 )
		{
			add_filter('widget_text', 'do_shortcode');
		}
	}
	
	function register_menu()
	{
		$settings = $this->get_settings();
		$userrole = $settings['userrole'];
		
		$menu = add_menu_page(
				__('Freemake Slider', 'fm_carousel'),
				__('Freemake Slider', 'fm_carousel'),
				$userrole,
				'fm_carousel_overview',
				array($this, 'show_overview'),
				FM_CAROUSEL_URL . 'images/logo-16.png' );
		add_action( 'admin_print_styles-' . $menu, array($this, 'enqueue_admin_script') );
		
		$menu = add_submenu_page(
				'fm_carousel_overview',
				__('Overview', 'fm_carousel'),
				__('Overview', 'fm_carousel'),
				$userrole,
				'fm_carousel_overview',
				array($this, 'show_overview' ));
		add_action( 'admin_print_styles-' . $menu, array($this, 'enqueue_admin_script') );
		
		$menu = add_submenu_page(
				'fm_carousel_overview',
				__('New Slider', 'fm_carousel'),
				__('New Slider', 'fm_carousel'),
				$userrole,
				'fm_carousel_add_new',
				array($this, 'add_new' ));
		add_action( 'admin_print_styles-' . $menu, array($this, 'enqueue_admin_script') );
		
		$menu = add_submenu_page(
				'fm_carousel_overview',
				__('Manage Sliders', 'fm_carousel'),
				__('Manage Sliders', 'fm_carousel'),
				$userrole,
				'fm_carousel_show_items',
				array($this, 'show_items' ));
		add_action( 'admin_print_styles-' . $menu, array($this, 'enqueue_admin_script') );
		
		$menu = add_submenu_page(
				'fm_carousel_overview',
				__('Settings', 'fm_carousel'),
				__('Settings', 'fm_carousel'),
				'manage_options',
				'fm_carousel_edit_settings',
				array($this, 'edit_settings' ) );
		add_action( 'admin_print_styles-' . $menu, array($this, 'enqueue_admin_script') );
		
		
		$menu = add_submenu_page(
				null,
				__('View Slide', 'fm_carousel'),
				__('View Slide', 'fm_carousel'),	
				$userrole,	
				'fm_carousel_show_item',	
				array($this, 'show_item' ));
		add_action( 'admin_print_styles-' . $menu, array($this, 'enqueue_admin_script') );
		
		$menu = add_submenu_page(
				null,
				__('Edit Slide', 'fm_carousel'),
				__('Edit Slide', 'fm_carousel'),
				$userrole,
				'fm_carousel_edit_item',
				array($this, 'edit_item' ) );
		add_action( 'admin_print_styles-' . $menu, array($this, 'enqueue_admin_script') );
	}
	
	function register_script()
	{		
		wp_register_script('fm-carousel-template-script', FM_CAROUSEL_URL . 'app/fmcarouseltemplate.js', array('jquery'), FM_CAROUSEL_VERSION, false);
		wp_register_script('fm-carousel-skins-script', FM_CAROUSEL_URL . 'engine/fmcarouselskins.js', array('jquery'), FM_CAROUSEL_VERSION, false);
		wp_register_script('fm-carousel-script', FM_CAROUSEL_URL . 'engine/fmcarousel.js', array('jquery'), FM_CAROUSEL_VERSION, false);
		wp_register_script('fm-carousel-creator-script', FM_CAROUSEL_URL . 'app/fm-carousel-creator.js', array('jquery'), FM_CAROUSEL_VERSION, false);
		wp_register_style('fm-carousel-admin-style', FM_CAROUSEL_URL . 'fmcarousel.css');
	}
	
	function enqueue_script()
	{
		$addjstofooter = get_option( 'fm_carousel_addjstofooter', 0 );
		if ($addjstofooter == 1)
		{
			wp_enqueue_script('fm-carousel-skins-script', false, array(), false, true);
			wp_enqueue_script('fm-carousel-script', false, array(), false, true);
		}
		else
		{
			wp_enqueue_script('fm-carousel-skins-script');
			wp_enqueue_script('fm-carousel-script');
		}
	}
	
	function enqueue_admin_script($hook)
	{
		wp_enqueue_script('post');
		if (function_exists("wp_enqueue_media"))
		{
			wp_enqueue_media();
		}
		else
		{
			wp_enqueue_script('thickbox');
			wp_enqueue_style('thickbox');
			wp_enqueue_script('media-upload');
		}
		wp_enqueue_script('fm-carousel-template-script');
		wp_enqueue_script('fm-carousel-skins-script');
		wp_enqueue_script('fm-carousel-script');
		wp_enqueue_script('fm-carousel-creator-script');
		wp_enqueue_style('fm-carousel-admin-style');
	}
	
	function generate_lightbox_options()
	{
		return '<div id="wondercarousellightbox_options" data-skinsfoldername=""  data-jsfolder="' . FM_CAROUSEL_URL . 'engine/" style="display:none;"></div>';
	}
	
	function admin_init_hook()
	{
		$settings = $this->get_settings();
		$userrole = $settings['userrole'];
		if ( !current_user_can($userrole) )
			return;
		
		// change text of history media uploader
		if (!function_exists("wp_enqueue_media"))
		{
			global $pagenow;
			
			if ( 'media-upload.php' == $pagenow || 'async-upload.php' == $pagenow ) {
				add_filter( 'gettext', array($this, 'replace_thickbox_text' ), 1, 3 );
			}
		}
		
		// add meta boxes
		$this->fm_carousel_controller->add_metaboxes();
	}
	
	function replace_thickbox_text($translated_text, $text, $domain) {
		
		if ('Insert into Post' == $text) {
			$referer = strpos( wp_get_referer(), 'fm-carousel' );
			if ( $referer != '' ) {
				return __('Insert into carousel', 'fm_carousel' );
			}
		}
		return $translated_text;
	}
	
	function show_overview() {
		
		$this->fm_carousel_controller->show_overview();
	}
	
	function show_items() {
		
		$this->fm_carousel_controller->show_items();
	}
	
	function add_new() {
		
		$this->fm_carousel_controller->add_new();
	}
	
	function show_item() {
		
		$this->fm_carousel_controller->show_item();
	}
	
	function edit_item() {
	
		$this->fm_carousel_controller->edit_item();
	}
	
	function edit_settings() {
	
		$this->fm_carousel_controller->edit_settings();
	}
	
	function register() {
	
		$this->fm_carousel_controller->register();
	}
	
	function get_settings() {
	
		return $this->fm_carousel_controller->get_settings();
	}
	
	function shortcode_handler($atts) {
		
		if ( !isset($atts['id']) )
			return __('Please specify a carousel id', 'fm_carousel');
		
		return $this->generate_lightbox_options() . "\r\n" . $this->fm_carousel_controller->generate_body_code( $atts['id'], false);
	}
	
	function wp_ajax_save_item() {
		
		check_ajax_referer( 'fm-carousel-ajaxnonce', 'nonce' );
		
		$settings = $this->get_settings();
		$userrole = $settings['userrole'];
		if ( !current_user_can($userrole) )
			return;
		
		$jsonstripcslash = get_option( 'fm_carousel_jsonstripcslash', 1 );
		if ($jsonstripcslash == 1)
			$json_post = trim(stripcslashes($_POST["item"]));
		else
			$json_post = trim($_POST["item"]);
		$json_post = str_replace("\\\\", "\\\\\\\\", $json_post);
		$items = json_decode($json_post, true);
		
		if ( empty($items) )
		{
			$json_error = "json_decode error";
			if ( function_exists('json_last_error_msg') )
				$json_error .= ' - ' . json_last_error_msg();
			else if ( function_exists('json_last_error') )
				$json_error .= 'code - ' . json_last_error();
			
			header('Content-Type: application/json');
			echo json_encode(array(
					"success" => false,
					"id" => -1, 
					"message" => $json_error
				));
			wp_die();
		}
		
		foreach ($items as $key => &$value)
		{
			if ($value === true)
				$value = "true";
			else if ($value === false)
				$value = "false";
			else if ( is_string($value) )
				$value = wp_kses_post($value);
		}
		
		if (isset($items["slides"]) && count($items["slides"]) > 0)
		{
			foreach ($items["slides"] as $key => &$slide)
			{
				foreach ($slide as $key => &$value)
				{
					if ($value === true)
						$value = "true";
					else if ($value === false)
						$value = "false";
					else if ( is_string($value) )
						$value = wp_kses_post($value);
				}
			}
		}
		
		header('Content-Type: application/json');
		echo json_encode($this->fm_carousel_controller->save_item($items));
		wp_die();
		
	}
	
}

/**
 * Init the plugin
 */
$fm_carousel_plugin = new FM_Carousel_Plugin();

/**
 * Uninstallation
 */
function fm_carousel_uninstall() {
	
	if ( ! current_user_can( 'activate_plugins' ) )
		return;
	
	global $wpdb;
	
	$keepdata = get_option( 'fm_carousel_keepdata', 1 );
	if ( $keepdata == 0 )
	{
		$table_name = $wpdb->prefix . "fm_slider";
		$wpdb->query("DROP TABLE IF EXISTS $table_name");
	}
}

if ( function_exists('register_uninstall_hook') )
{
	register_uninstall_hook( __FILE__, 'fm_carousel_uninstall' );
}

define('FM_CAROUSEL_VERSION_TYPE', 'F');
