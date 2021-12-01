<?php

class SS_Testimoni_Shortcode {

	/**
	 * Instance
	 *
	 * @var $instance
	 */
	public static $instance;

	/**
	 * Class constructor.
	 */
	public function __construct() {
		add_shortcode( 'ss_testimoni', array( $this, 'ss_testimoni_shortcode' ) );
	}

	/**
	 * Set instance and fire class
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
	 * Callback for shortcode
	 *
	 * @global $post
	 *
	 * @param array $atts shortcode attributes.
	 *
	 * @return string
	 */
	public function ss_testimoni_shortcode( $atts, $content = '' ) {
		$nonce = wp_create_nonce( 'ss_testimoni_nonce' );
		
		ob_start();

		self::save_testimomi();

		$default_template = SS_TESTIMONI_PATH . 'templates/default.php';		
		include $default_template;	

		$content .= ob_get_contents();
		ob_end_clean();

		return $content;
	}

	public function save_testimomi() {
		if ( isset( $_POST['ss-submitted'] ) ) {
			$feedback = '';
		
			$data = array(
				'name' 		=> esc_attr( $_POST['ss-name'] ),
				'email' 		=> esc_attr( $_POST['ss-email'] ),
				'phone_number' => esc_attr( $_POST['ss-phone-number'] ),
				'testimonial' 		=> esc_attr( $_POST['ss-testimoni'] )
			);
			$feedback = SS_Testimoni_Helper::insertSSTestimoni( $data );
		
			echo $feedback;
		}	
	}
}
