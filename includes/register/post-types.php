<?php
namespace HiBricks\Register;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Post_Types
 *
 * PostType class.
 *
 * @since 2.3.0
 */
class Post_Types {
	/**
	 * Constructor.
	 */
	public function __construct() {
		// add_action( 'init', array( $this, 'product' ) );

		// add_filter( 'gutenberg_can_edit_post_type', array( $this, 'gutenberg_can_edit_post_type' ), 10, 2 );
		// add_filter( 'use_block_editor_for_post_type', array( $this, 'gutenberg_can_edit_post_type' ), 10, 2 );
	}

	/**
	 * Disable Gutenberg for post type.
	 *
	 * @param bool   $can_edit Whether the post type can be edited or not.
	 * @param string $post_type The post type being checked.
	 * @return bool
	 */
	public static function gutenberg_can_edit_post_type( $can_edit, $post_type ) {
		return in_array( $post_type, array( 'product' ) ) ? false : $can_edit;
	}

	/**
	 * Registers a new post type
	 *
	 * @uses $wp_post_types Inserts new post type object into the list
	 *
	 * @param string  Post type key, must not exceed 20 characters
	 * @param array|string  See optional args description above.
	 * @return object|WP_Error the registered post type object, or an error object
	 */
	function product() {

		$labels = array(
			'name'               => __( 'Products', 'hibricks' ),
			'singular_name'      => __( 'Product', 'hibricks' ),
			'add_new'            => _x( 'Add New', 'hibricks', 'hibricks' ),
			'add_new_item'       => __( 'Add New', 'hibricks' ),
			'edit_item'          => __( 'Edit', 'hibricks' ),
			'new_item'           => __( 'New', 'hibricks' ),
			'view_item'          => __( 'View', 'hibricks' ),
			'search_items'       => __( 'Search Products', 'hibricks' ),
			'not_found'          => __( 'No Products found', 'hibricks' ),
			'not_found_in_trash' => __( 'No Products found in Trash', 'hibricks' ),
			'parent_item_colon'  => __( 'Parent Product:', 'hibricks' ),
			'menu_name'          => __( 'Products', 'hibricks' ),
		);

		$args = array(
			'labels'              => $labels,
			'hierarchical'        => false,
			'description'         => '',
			'taxonomies'          => array(),
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => null,
			'menu_icon'           => null,
			'show_in_nav_menus'   => true,
			'publicly_queryable'  => true,
			'exclude_from_search' => false,
			'has_archive'         => true,
			'query_var'           => true,
			'can_export'          => true,
			'rewrite'             => array( 'slug' => 'product' ),
			'capability_type'     => 'post',
			'supports'            => array(
				'title',
				'editor',
				'author',
				'thumbnail',
				'excerpt',
				'custom-fields',
				'trackbacks',
				'comments',
				'revisions',
				'page-attributes',
				'post-formats',
			),
		);

		register_post_type( 'product', $args );
	}

}

new Post_Types();
