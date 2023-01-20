<?php
namespace HiBricks\Integrations\ACF;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'ACF' ) ) {
	return;
}

class ACF {

	public function __construct() {
		// Paths to save acf data.
		add_filter( 'acf/settings/capability', array( $this, 'capability' ) );
		add_filter( 'acf/settings/show_admin', array( $this, 'show_admin' ), 30 );

		// Add admin option pages.
		add_action( 'after_setup_theme', array( $this, 'add_theme_options_page' ) );
	}

	public function capability( $value ) {
		return 'administrator';
	}

	public function show_admin( $show ) {
		$roles = wp_get_current_user()->roles;

		if ( count( $roles ) ) {
			$role = $roles[0];
		}

		if ( 'administrator' == $role ) {
			return true;
		} else {
			return false;
		}
	}

	public function add_theme_options_page() {
		if ( class_exists( 'acf_pro' ) ) {
			$args = array(
				'page_title'      => __( 'Theme General Options', 'hibricks' ),
				'menu_title'      => __( 'Theme Options', 'hibricks' ),
				'menu_slug'       => 'theme-options',
				'capability'      => 'manage_options',
				'update_button'   => __( 'Update', 'hibricks' ),
				'updated_message' => __( 'Options Updated', 'hibricks' ),
				'post_id'         => 'options',
				'redirect'        => false,
			);

			acf_add_options_page( $args );
		}
	}
}
