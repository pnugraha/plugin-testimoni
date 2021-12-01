<?php
/**
 * Helper for getting stored values in database,
 *
 * @package Helpful
 */
class SS_Testimoni_Helper {

	/**
	 * Insert helpful contra on single post
	 *
	 * @global $wpdb
	 *
	 */
	public static function selectSSTestimoni( $per_page = 10, $page_number = 1 ) {
		global $wpdb;

		$table_name = $wpdb->prefix . SS_TESTIMONI_TABLE;
		$sql = "SELECT * FROM {$wpdb->prefix}.$table_name";

		if ( ! empty( $_REQUEST['orderby'] ) ) {
		$sql .= ' ORDER BY ' . esc_sql( $_REQUEST['orderby'] );
		$sql .= ! empty( $_REQUEST['order'] ) ? ' ' . esc_sql( $_REQUEST['order'] ) : ' ASC';
		}

		$sql .= " LIMIT $per_page";

		$sql .= ' OFFSET ' . ( $page_number - 1 ) * $per_page;

		$result = $wpdb->get_results( $sql, 'ARRAY_A' );

		return $result;
	}


	/**
	 * Insert helpful contra on single post
	 *
	 * @global $wpdb
	 *
	 */
	public static function insertSSTestimoni( $data ) {
		global $wpdb;

		$table_name = $wpdb->prefix . SS_TESTIMONI_TABLE;
		$wpdb->query( $wpdb->prepare( 
		"
			INSERT INTO $table_name
			( `name`, `email`, `phone_number`, `testimonial` )
			VALUES ( %s, %s, %s, %s )
		", 
        $data['name'], $data['email'], $data['phone_number'], $data['testimonial'] 
		) );
		
		return $wpdb->insert_id;
	}

}
