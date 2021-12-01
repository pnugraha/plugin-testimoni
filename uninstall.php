<?php
/* 
 * exit uninstall if not called by WP
 */
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit();
}

global $wpdb;
		
$table_name = $wpdb->prefix . 'ss_testimoni';		
if ( $wpdb->get_var( "SHOW TABLES LIKE '$table_name'" ) == $table_name ) {
	$wpdb->query("DROP TABLE IF EXISTS {$table_name}");
}