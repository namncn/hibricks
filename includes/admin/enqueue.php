<?php
namespace HiBricks\Admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Enqueue.
 */
class Enqueue {

	public $version;

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->version = time();

		add_action( 'wp_enqueue_scripts', array( $this, 'frontend_scripts' ) );
	}

	/**
	 * [frontend_scripts description]
	 *
	 * @return [type] [description]
	 */
	public function frontend_scripts() {
		wp_dequeue_style( 'global-styles' );

		wp_enqueue_style( 'pixelplus-style', get_stylesheet_uri(), array(), $this->version );

		wp_enqueue_script( 'hibricks-frontend', get_theme_file_uri( '/assets/js/frontend.js' ), array( 'jquery' ), $this->version, true );

		wp_script_add_data( 'hibricks-frontend', 'async', true );

		wp_localize_script(
			'hibricks-frontend',
			'hibricks',
			array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'nonce'   => wp_create_nonce( 'hibricks_nonce' ),
			)
		);
	}
}