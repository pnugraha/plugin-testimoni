<?php

if( ! defined( 'ABSPATH' ) ){
    exit; // Exit if accessed directly
}

if( ! class_exists('WP_List_Table') ){
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

/**
 *  class hipwee user management autopost
 */
class SS_Testimoni_Table extends WP_List_Table {
    private $table_testimoni;
    private $per_page;

     /**
     * [REQUIRED] You must declare constructor and give some basic params
     */
    function __construct(){
        global $wpdb;

        $this->table_testimoni = $wpdb->prefix . SS_TESTIMONI_TABLE;
        $this->per_page = 10;

        parent::__construct( array( 
            'singular' => 'testimonial', 
            'plural' => 'testimonials' 
        ) );
    }

    /**
     * [REQUIRED] this is a default column renderer
     *
     * @param $item - row (key, value array)
     * @param $column_name - string (key)
     * @return HTML
     */
    function column_default( $item, $column_name ){
        return $item->{$column_name};
    }

    function column_name( $item ){
       // create a nonce
        $delete_nonce = wp_create_nonce( 'ss_delete_testimoni' );

        $title = '<strong>' . $item->name . '</strong>';

        $actions = [
        'delete' => sprintf( '<a href="?page=%s&action=%s&testimoni=%s&_wpnonce=%s">Delete</a>', esc_attr( $_REQUEST['page'] ), 'delete', absint( $item->id ), $delete_nonce )
        ];

        return $title . $this->row_actions( $actions );
    }

    function column_email( $item ){
        return $item->email;
    }

    function column_phone_number( $item ){
        return $item->phone_number;
    }

    function column_testimonial( $item ){
        return $item->testimonial;
    }

    /**
     * [REQUIRED] This method return columns to display in table
     * you can skip columns that you do not want to show
     * like content, or description
     *
     * @return array
     */
    function get_columns(){
        $columns = array(
            'name' => __( 'Name', 'ss_testimoni' ),
            'email' => __( 'Email', 'ss_testimoni' ),
            'phone_number'  => __( 'Phone Number', 'ss_testimoni' ),
            'testimonial' => __( 'Testimonial', 'ss_testimoni' ),
        );
        return $columns;
    }

    /**
    * [OPTIONAL] This method return columns that may be used to sort table
    * all strings in array - is column names
    * notice that true on name column means that its default sort
    *
    * @return array
    */
    function get_sortable_columns(){
        $sortable_columns = array(
            'name' => array( 'name', true ),
            'email' => array( 'email', true ),
            'phone_number' => array( 'phone_number', true ),
            'testimonial' => array( 'testimonial', true ),
        );
        return $sortable_columns;
    }


    /**
     * [REQUIRED] This is the most important method
     *
     * It will get rows from database and prepare them to be showed in table
     */
    function prepare_items( $search = NULL ){

        global $wpdb;

        $this->process_bulk_action();

        // prepare query params, as usual current page, order by and order direction
        $paged = isset($_REQUEST['paged']) ? max(0, intval($_REQUEST['paged']) - 1) : 0;

        //order by
        $orderby = (isset($_REQUEST['orderby']) && in_array($_REQUEST['orderby'], array_keys($this->get_sortable_columns()))) ? $_REQUEST['orderby'] : 'name';
        // order
        $order = (isset($_REQUEST['order']) && in_array($_REQUEST['order'], array('asc', 'desc'))) ? $_REQUEST['order'] : 'ASC';

        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();

        // here we configure table headers, defined in our methods
        $this->_column_headers = array($columns, $hidden, $sortable);

        $query = "SELECT * FROM {$this->table_testimoni} ORDER BY {$orderby} {$order} " ;
        $query .= " LIMIT $this->per_page";
        $query .= ' OFFSET ' . ( $paged ) * $this->per_page;
      
        // will be used in pagination settings
        $total_items = $wpdb->get_var( "SELECT COUNT(*) FROM ({$this->table_testimoni})" );

        // [REQUIRED] define $items array
        // notice that last argument is ARRAY_A, so we will retrieve array
        $this->items = $wpdb->get_results( $query );

        // [REQUIRED] configure pagination
        $this->set_pagination_args( array( 
            'total_items'   => $total_items, // total items defined above
            'per_page'      => $this->per_page, // per page constant defined at top of method
            'total_pages'   => ceil($total_items / $this->per_page) // calculate pages count
        ) );
        $this->print_scripts();
    }

    public function process_bulk_action() {
        //Detect when a bulk action is being triggered...
        if ( 'delete' === $this->current_action() ) {

            // In our file that handles the request, verify the nonce.
            $nonce = esc_attr( $_REQUEST['_wpnonce'] );

            if ( ! wp_verify_nonce( $nonce, 'ss_delete_testimoni' ) ) {
                die( 'Go get a life script kiddies' );
            } else {
                SS_Testimoni_Helper::deleteSSTestimoni( absint( $_GET['testimoni'] ) );
                echo("<script>location.href = '". esc_url( 'admin.php?page=ss-testimoni' ) ."'</script>");
                exit;
            }
        }
    }

    function print_scripts(){}
}