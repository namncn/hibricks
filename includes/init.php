<?php
namespace HiBricks;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Theme {

	/**
	 * The one and only Theme instance
	 *
	 * @var Theme
	 */
	public static $instance = null;

	/**
	 * Autoload and init components
	 */
	public function __construct() {
		$this->autoloader();
		$this->init();
	}

	/**
	 * Autoload files
	 */
	private function autoloader() {
		require_once 'autoloader.php';

		Autoloader::register();
	}

	/**
	 * Init components
	 */
	public function init() {
		require_once 'utils.php';

		new Hooks();
		new Register\Post_Types();
		new Register\Taxonomies();
		new Register\Ajaxes();
		new Integrations\ACF\ACF();
	}

	/**
	 * Main Theme instance
	 *
	 * Ensure only one instance of Theme exists at any given time.
	 *
	 * @return object Theme The one and only Theme instance
	 */
	public static function instance() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Theme ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
}

// Get the theme up and running
Theme::instance();
