<?php
/**
 * Admin notice if PHP version is older than 5.4
 *
 * Required due to: array shorthand, array dereferencing etc.
 *
 * @since 1.0
 */

if ( version_compare( PHP_VERSION, '5.4', '>=' ) ) {
	require_once 'includes/init.php';
} else {
	add_action(
		'admin_notices',
		function() {
			$message = sprintf( esc_html__( 'HiBricks requires PHP version %s+.', 'hibricks' ), '5.4' );
			$html    = sprintf( '<div class="error">%s</div>', wpautop( $message ) );
			echo wp_kses_post( $html );
		}
	);
}

add_action(
	'after_setup_theme',
	function() {
		load_theme_textdomain( 'hibricks', get_theme_file_path() . '/languages' );
	}
);
