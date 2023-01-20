<?php
namespace HiBricks\Element;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Team extends \Bricks\Element {

	/**
	 * How to create your own elements
	 *
	 * https://docs.bricksbuilder.io/article/38-create-your-own-elements
	 */

	public $category     = 'hibricks';
	public $name         = 'hibricks-team';
	public $icon         = 'fas fa-users'; // FontAwesome 5 icon in builder (https://fontawesome.com/icons)
	public $css_selector = '.hibricks-team-wrapper'; // Default CSS selector for all controls with 'css' properties
	// public $scripts      = []; // Enqueue registered scripts

	public function get_label() {
		return esc_html__( 'Team', 'hibricks' );
	}

		// Set builder controls
	public function set_controls() {
	}

	/**
	 * Render element HTML on frontend
	 *
	 * If no 'render_builder' function is defined then this code is used to render element HTML in builder, too.
	 */
	public function render() {
		$settings = $this->settings;
		?>
		<?php
	}
}
