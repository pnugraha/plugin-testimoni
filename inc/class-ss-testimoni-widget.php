<?php
/**
 * SS Testimoni Widget
 *
 * @package SS
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * SS Testimoni widget class
 */
class SS_Testimoni_Widget extends WP_Widget {

	/**
	 * Set base ID, name & options
	 */
	public function __construct() {
		parent::__construct(
			'ss_testimoni',
			esc_html__( 'SS Testimoni', 'ss_testimoni' ),
			array(
				'description' => esc_html__( 'SS Testimoni', 'ss_testimoni' ),
			)
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {

		if ( isset( $instance['limit'] ) ){
			$limit = $instance['limit'];
		} else {
			$limit = 5;
		}	

		$datas = SS_Testimoni_Helper::displaySSTestimoni( $limit );
		echo $args['before_widget'];
		if( $datas ){
			echo "<h2>Testimonial Terbaru</h2>";
			echo "<ul>";
			foreach ($datas as $data) {
				echo "<li>$data->testimonial</li>";
			}
			echo "</ul>";			
		}
		echo $args['after_widget'];
	}

	public function form( $instance ) {
		if ( isset( $instance['limit'] ) ){
			$limit = $instance['limit'];
		} else {
			$limit = 5;
		}		
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'limit' ); ?>"><?php _e( 'Limit:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'limit' ); ?>" name="<?php echo $this->get_field_name( 'limit' ); ?>" type="text" value="<?php echo esc_attr( $limit ); ?>" />
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['limit'] = ( ! empty( $new_instance['limit'] ) ) ? strip_tags( $new_instance['limit'] ) : '';
		return $instance;
	}
}
