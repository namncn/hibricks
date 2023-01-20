<?php
namespace HiBricks;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Hooks {

	/**
	 * Constructor
	 */
	public function __construct() {
		add_filter( 'body_class', array( $this, 'body_classes' ) );
		add_filter( 'upload_mimes', array( $this, 'mime_types' ) );
		add_filter( 'wp_check_filetype_and_ext', array( $this, 'wp_check_filetype_and_ext' ), 10, 4 );
		add_filter( 'big_image_size_threshold', array( $this, 'big_image_size_threshold' ) );
		add_action( 'wp_footer', array( $this, 'back_to_top' ) );
		add_action( 'wp_print_footer_scripts', array( $this, 'skip_link_focus_fix' ) );
		add_filter( 'frontpage_template', array( $this, 'front_page_template' ) );
		add_filter( 'max_srcset_image_width', array( $this, 'max_srcset_image_width' ) );
		add_filter( 'intermediate_image_sizes_advanced', array( $this, 'intermediate_image_sizes_advanced' ) );
		add_filter( 'wp_lazy_loading_enabled', '__return_false', 9999 );
		add_filter( 'wp_sitemaps_enabled', '__return_false' );
		add_filter( 'auto_update_plugin', '__return_false' );
		add_filter( 'auto_update_theme', '__return_false' );
		add_action( 'enqueue_block_editor_assets', array( $this, 'disable_editor_fullscreen_by_default' ) );
		add_action( 'pre_get_posts', array( $this, 'pre_get_posts' ) );
		add_filter( 'get_the_archive_title_prefix', '__return_false' );
		add_filter( 'get_the_archive_title', array( $this, 'filter_archive_title' ) );
		add_filter( 'excerpt_length', array( $this, 'excerpt_length' ) );
		add_filter( 'excerpt_more', array( $this, 'excerpt_more' ) );
		add_action( 'wp_footer', array( $this, 'supports_js' ) );
		remove_action( 'wp_body_open', 'wp_global_styles_render_svg_filters' );
		add_action( 'wp_enqueue_scripts', array( $this, 'wp_enqueue_scripts' ) );
		add_action( 'admin_menu', array( $this, 'pixelplus_admin_menu' ), 9999 );
		add_filter( 'gettext', array( $this, 'gettext' ), 9999, 3 );
		add_filter( 'init', array( $this, 'bricks_custom_elements' ), 11 );
		add_filter( 'display_post_states', array( $this, 'add_post_state' ), 9999, 2 );
	}

	public function add_post_state( $post_states, $post ) {
		if ( array_key_exists( 'bricks', $post_states ) ) {
			$post_states['bricks'] = 'Live Edit';
		}

		return $post_states;
	}

	public function bricks_custom_elements() {
		$element_files = glob( __DIR__ . '/elements/*.php' );

		foreach ( $element_files as $file ) {
			\Bricks\Elements::register_element( $file );
		}
	}

	public function gettext( $translated_text, $text, $domain ) {
		if ( 'bricks' == $domain ) {
			$translated_text = str_ireplace( 'Edit with Bricks', 'Live Edit', $translated_text );
		}

		return $translated_text;
	}

	public function pixelplus_admin_menu() {
		remove_submenu_page( 'bricks', 'bricks' );

		add_submenu_page(
			'bricks',
			esc_html__( 'Getting Started', 'hibricks' ),
			esc_html__( 'Getting Started', 'hibricks' ),
			'edit_posts',
			'hibricks',
			array( $this, 'admin_screen_getting_started' ),
			0
		);
	}

	public function admin_screen_getting_started() {
		require_once 'admin/admin-screen-getting-started.php';
	}

	public function wp_enqueue_scripts() {
		wp_enqueue_style( 'hibricks', get_stylesheet_uri(), array( 'bricks-frontend' ), time() );
		wp_enqueue_script( 'hibricks', get_theme_file_uri( 'assets/js/frontend.js' ), array( 'jquery' ), time(), true );

		wp_script_add_data( 'hibricks', 'async', true );

		wp_localize_script(
			'hibricks',
			'hibricks',
			array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'_nonce'   => wp_create_nonce( 'hibricks_nonce' ),
			)
		);
	}

	/**
	 * Adds custom classes to the array of body classes.
	 *
	 * @param array $classes Classes for the body element.
	 * @return array
	 */
	public function body_classes( $classes ) {
		// Helps detect if JS is enabled or not.
		$classes[] = 'no-js';

		// Adds `singular` to singular pages, and `hfeed` to all other pages.
		$classes[] = is_singular() ? 'singular' : 'hfeed';

		return $classes;
	}

	public function mime_types( $mimes ) {
		$mimes['svg'] = 'image/svg+xml';
		return $mimes;
	}

	public function wp_check_filetype_and_ext( $data, $file, $filename, $mimes ) {
		global $wp_version;

		if ( '4.7.1' !== $wp_version ) {
			return $data;
		}

		$filetype = wp_check_filetype( $filename, $mimes );

		return array(
			'ext'             => $filetype['ext'],
			'type'            => $filetype['type'],
			'proper_filename' => $data['proper_filename'],
		);
	}

	public function big_image_size_threshold( $imagesize ) {
		return 1920;
	}

	/**
	 * Back to top.
	 */
	public function back_to_top() {
		echo '<div class="backtotop" title="' . esc_html__( 'Back To Top', 'pixelplus' ) . '"><svg width="18" height="10" viewBox="0 0 18 10" xmlns="http://www.w3.org/2000/svg" data-svg="totop"><polyline fill="none" stroke="#999" stroke-width="1.2" points="1 9 9 1 17 9 "></polyline></svg></div>';
	}

	/**
	 * Fix skip link focus in IE11.
	 *
	 * This does not enqueue the script because it is tiny and because it is only for IE11,
	 * thus it does not warrant having an entire dedicated blocking script being loaded.
	 *
	 * @link https://git.io/vWdr2
	 */
	public function skip_link_focus_fix() {
		// The following is minified via `terser --compress --mangle -- js/skip-link-focus-fix.js`.
		?>
		<script>
		/(trident|msie)/i.test(navigator.userAgent)&&document.getElementById&&window.addEventListener&&window.addEventListener("hashchange",function(){var t,e=location.hash.substring(1);/^[A-z0-9_-]+$/.test(e)&&(t=document.getElementById(e))&&(/^(?:a|select|input|button|textarea)$/i.test(t.tagName)||(t.tabIndex=-1),t.focus())},!1);
		</script>
		<?php
	}

	/**
	 * Use front-page.php when Front page displays is set to a static page.
	 *
	 * @param string $template front-page.php.
	 *
	 * @return string The template to be used: blank if is_home() is true (defaults to index.php), else $template.
	 */
	public function front_page_template( $template ) {
		return is_home() ? '' : $template;
	}

	public function max_srcset_image_width() {
		return 1;
	}

	public function intermediate_image_sizes_advanced( $sizes ) {
		unset( $sizes['thumbnail'] );
		unset( $sizes['medium'] );
		unset( $sizes['large'] );
		unset( $sizes['medium_large'] );

		return $sizes;
	}

	public function disable_editor_fullscreen_by_default() {
		$script = "window.onload = function() { const isFullscreenMode = wp.data.select( 'core/edit-post' ).isFeatureActive( 'fullscreenMode' ); if ( isFullscreenMode ) { wp.data.dispatch( 'core/edit-post' ).toggleFeature( 'fullscreenMode' ); } }";
		wp_add_inline_script( 'wp-blocks', $script );
	}

	public function pre_get_posts( $query ) {
		if ( ! is_admin() && $query->is_main_query() ) {
			// if ( is_tax( 'event_cat' ) ) {
			// $query->set( 'posts_per_page', 10 );
			// }
		}
	}

	public function filter_archive_title( $title ) {
		$blog = get_option( 'page_for_posts' );

		if ( is_home() ) {
			if ( $blog ) {
				$title = get_the_title( $blog );
			} else {
				$title = esc_html__( 'Blog', 'pixelplus' );
			}
		}

		return $title;
	}

	public function excerpt_length() {
		return 20;
	}

	public function excerpt_more() {
		return '';
	}

	/**
	 * Remove the `no-js` class from body if JS is supported.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function supports_js() {
		echo '<script>document.body.classList.remove("no-js");</script>';
	}
}
