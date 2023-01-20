<?php
namespace HiBricks\Register;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Ajaxes {
	/**
	 * Contructor
	 */
	public function __construct() {
		// add_action( 'wp_ajax_example', array( $this, 'example' ) );
		// add_action( 'wp_ajax_nopriv_example', array( $this, 'example' ) );
	}

	public function example() {
		check_ajax_referer( 'hibricks_nonce', 'security' );

		$results = '';

		$data = $_POST['data'];

		ob_start();
		?>
		<?php
		$results = ob_get_clean();

		wp_send_json( $results );
		die();
	}
}
