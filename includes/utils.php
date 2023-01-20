<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'hibricks_option' ) ) {
	/**
	 * Get ACF options
	 */
	function hibricks_option( $selector, $post_id = false, $format_value = true ) {
		if ( ! class_exists( 'ACF' ) ) {
			return;
		}

		return apply_filters( 'hibricks_option', get_field( $selector, $post_id, $format_value ) );
	}
}
