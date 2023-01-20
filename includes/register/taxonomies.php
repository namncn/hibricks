<?php
namespace HiBricks\Register;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Taxonomies class.
 *
 * @since 2.3.0
 */
class Taxonomies {
	/**
	 * Constructor.
	 */
	public function __construct() {
		// add_action( 'init', array( $this, 'product_cat' ) );
	}

	/**
	 * Create a taxonomy
	 *
	 * @uses  Inserts new taxonomy object into the list
	 * @uses  Adds query vars
	 *
	 * @param string  Name of taxonomy object
	 * @param array|string  Name of the object type for the taxonomy object.
	 * @param array|string  Taxonomy arguments
	 * @return null|WP_Error WP_Error if errors, otherwise null.
	 */
	function product_cat() {

		$labels = array(
			'name'              => _x( 'Product categories', 'Taxonomy Product categories', 'hibricks' ),
			'singular_name'     => _x( 'Category', 'Taxonomy product category', 'hibricks' ),
			'search_items'      => __( 'Search Product categories', 'hibricks' ),
			'popular_items'     => __( 'Popular Product categories', 'hibricks' ),
			'all_items'         => __( 'All Product categories', 'hibricks' ),
			'parent_item'       => __( 'Parent category', 'hibricks' ),
			'parent_item_colon' => __( 'Parent category', 'hibricks' ),
			'edit_item'         => __( 'Edit category', 'hibricks' ),
			'update_item'       => __( 'Update category', 'hibricks' ),
			'add_new_item'      => __( 'Add New category', 'hibricks' ),
			'new_item_name'     => __( 'New category name', 'hibricks' ),
			'menu_name'         => __( 'Category', 'hibricks' ),
		);

		$args = array(
			'labels'            => $labels,
			'public'            => true,
			'show_in_nav_menus' => true,
			'show_admin_column' => false,
			'hierarchical'      => false,
			'show_tagcloud'     => true,
			'show_ui'           => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'product-category' ),
			'query_var'         => true,
			'capabilities'      => array(),
		);

		register_taxonomy( 'product_cat', array( 'product' ), $args );
	}
}

new Taxonomies();
