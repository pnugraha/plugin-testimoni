<?php
/**
 * Helper for getting stored values in database,
 *
 * @package Helpful
 */
class SS_Testimoni_Helper {

    /**
	 * Insert helpful contra on testimoni
	 *
	 * @global $wpdb
	 *
	 */
	public static function insertSSTestimoni( $data ) {
		global $wpdb;

		$table_testimoni = $wpdb->prefix . SS_TESTIMONI_TABLE ;

		$wpdb->query( $wpdb->prepare( 
		"
			INSERT INTO {$table_testimoni} 
			( `name`, `email`, `phone_number`, `testimonial` )
			VALUES ( %s, %s, %s, %s )
		", 
        $data['name'], $data['email'], $data['phone_number'], $data['testimonial'] 
		) );
		
		return $wpdb->insert_id;
	}

	/**
	 * Delete helpful contra on testimoni
	 *
	 * @global $wpdb
	 *
	 */
	public static function deleteSSTestimoni( $id ) {
		global $wpdb;

		$table_testimoni = $wpdb->prefix . SS_TESTIMONI_TABLE ;

		$wpdb->delete( "$table_testimoni",
        	[ 'id' => $id ],
        	[ '%d' ]
        );
	}

	/**
	 * Get testimoni for frotent widgets
	 *
	 * @global $wpdb
	 *
	 */
	public static function displaySSTestimoni( $limit = 5 ) {
		global $wpdb;

		$table_testimoni = $wpdb->prefix . SS_TESTIMONI_TABLE ;

		$query = "SELECT * FROM {$table_testimoni} ORDER BY id DESC LIMIT {$limit} ";

        return $wpdb->get_results( $query );
	}

}
