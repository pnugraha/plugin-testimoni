<?php
/**
 * Plugin Name: Softwareseni Testimoni
 * Description: Plugin for testimoni user
 * Version:     1.0.0
 * Author:      Priya
 * Author URI:  softwareseni.co.id
 * Text Domain: ss_testimoni
 * License:     GPL-2.0+
 *
 * @package Softwareseni Testimoni
 */

// If this file is accessed directory, then abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'SS_TESTIMONI_URL' ) ) {
	define( 'SS_TESTIMONI_URL', plugin_dir_url( __FILE__ ) );
}

if ( ! defined( 'SS_TESTIMONI_PATH' ) ) {
	define( 'SS_TESTIMONI_PATH', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'SS_TESTIMONI_TABLE' ) ) {
	define( 'SS_TESTIMONI_TABLE', 'ss_testimoni' );
}

include SS_TESTIMONI_PATH . '/inc/class-ss-testimoni-shortcode.php';
include SS_TESTIMONI_PATH . '/inc/class-ss-testimoni-helper.php';

class SS_Testimoni_Setup {

	/**
	 * Instance
	 *
	 * @var $instance
	 */
	public static $instance;

	/**
	 * Set url & path, include files
	 */
	public function __construct() {
		register_activation_hook(__FILE__, array($this, 'SS_Testimoni_activated'));
		add_action( 'admin_menu', array( $this, 'SS_Testimoni_menu'  ) );
		add_action( 'admin_init', array( $this, 'SS_Testimoni_init_settings'  ) );		
		SS_Testimoni_Shortcode::get_instance();
	}

	/**
	 * Set instance and fire class.
	 *
	 * @return instance
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * register menu
	 */
	public function SS_Testimoni_menu() {
		add_menu_page('SS Testimoni','SS Testimoni','manage_options','ss-testimoni', array( $this, 'SS_Testimoni_admin_page' ) );
	}


	/**
	 * page option to show form
	 */
	public function SS_Testimoni_admin_page() {
		// Check required user capability
	    if ( !current_user_can( 'manage_options' ) )  {
	      wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'ss_testimoni' ) );
	    }

	    // Admin Page Layout

	    $datas = SS_Testimoni_Helper::selectSSTestimoni();

	    $default_template = SS_TESTIMONI_PATH . 'templates/admin-default.php';		
		include $default_template;	
	}


	/**
	 * init setting for display in admin/backend
	 */
	public function SS_Testimoni_init_settings() {
		register_setting(
	    	'settings_group',
	    	'ss_testimoni' // nama option
	    );

	    add_settings_section(
	    	'site_settings_section',
	      	__( 'SS Testimoni', 'ss_testimoni' ),
	      	false,
	      	'site-settings'
	    );
	}


	public function SS_Testimoni_activated(){ 
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		// create db table.
		$table_name = $wpdb->prefix . SS_TESTIMONI_TABLE;		
		if ( $wpdb->get_var( "SHOW TABLES LIKE '$table_name'" ) != $table_name ) {			
			$sql = "CREATE TABLE " . $table_name . " (
				`id` bigint(20) NOT NULL AUTO_INCREMENT,
				`name` varchar(100) NOT NULL,				
				`email` varchar(100) NOT NULL DEFAULT '0',
				`phone_number` varchar(15) NOT NULL DEFAULT '0',
				`testimonial` text DEFAULT NULL,
				PRIMARY KEY  (`id`)
				)$charset_collate;";
			dbDelta( $sql );
		}
	}
}

new SS_Testimoni_Setup();