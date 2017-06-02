<?php
namespace Connect_Core_WP\inc\classes;

defined( 'ABSPATH' ) || die( 'File cannot be accessed directly' );


class Post_Types {

	public function init() {

	}

	public function register_panel() {
		$labels = Post_Types::get_label_defaults();
		$labels['name']                  = _x( 'Home Panels', 'Post Type General Name', 'cmpbl-command-central' );
		$labels['singular_name']         = _x( 'Home Panel', 'Post Type Singular Name', 'cmpbl-command-central' );
		$labels['all_items']             = __( 'All Home Panels', 'cmpbl-command-central' );
		$labels['menu_name']             = __( 'Home Panels', 'cmpbl-command-central' );
		$labels['name_admin_bar']        = __( 'Home Panels', 'cmpbl-command-central' );
		$labels['add_new_item']        = __( 'Add New Home Panel', 'cmpbl-command-central' );

		$args = Post_Types::get_args_defaults();
		$args['label']               = __( 'Home Panels', 'cmpbl-command-central' );
		$args['description']         = __( 'Home Panels', 'cmpbl-command-central' );
		$args['labels']              = $labels;
		$args['menu_icon']           = 'dashicons-id';
		$args['rewrite']             = array(
			'with_front' => false,
			'slug' => 'panel',
		);
		$args['rest_base']           = __( 'panel', 'cmpbl-command-central' );

		register_post_type( 'new_relic_panel', $args );
	}

	private function get_label_defaults() {
		return array(
			'name'                  => _x( 'Pages', 'Post Type General Name', 'cmpbl-command-central' ),
			'singular_name'         => _x( 'Page', 'Post Type Singular Name', 'cmpbl-command-central' ),
			'menu_name'             => __( 'Pages', 'cmpbl-command-central' ),
			'name_admin_bar'        => __( 'Page', 'cmpbl-command-central' ),
			'archives'              => __( 'Page Archives', 'cmpbl-command-central' ),
			'parent_item_colon'     => __( 'Parent Page:', 'cmpbl-command-central' ),
			'all_items'             => __( 'All Pages', 'cmpbl-command-central' ),
			'add_new_item'          => __( 'Add New Page', 'cmpbl-command-central' ),
			'add_new'               => __( 'Add New', 'cmpbl-command-central' ),
			'new_item'              => __( 'New Page', 'cmpbl-command-central' ),
			'edit_item'             => __( 'Edit Page', 'cmpbl-command-central' ),
			'update_item'           => __( 'Update Page', 'cmpbl-command-central' ),
			'view_item'             => __( 'View Page', 'cmpbl-command-central' ),
			'search_items'          => __( 'Search Page', 'cmpbl-command-central' ),
			'not_found'             => __( 'Not found', 'cmpbl-command-central' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'cmpbl-command-central' ),
			'featured_image'        => __( 'Featured Image', 'cmpbl-command-central' ),
			'set_featured_image'    => __( 'Set featured image', 'cmpbl-command-central' ),
			'remove_featured_image' => __( 'Remove featured image', 'cmpbl-command-central' ),
			'use_featured_image'    => __( 'Use as featured image', 'cmpbl-command-central' ),
			'insert_into_item'      => __( 'Insert into page', 'cmpbl-command-central' ),
			'uploaded_to_this_item' => __( 'Uploaded to this page', 'cmpbl-command-central' ),
			'items_list'            => __( 'Pages list', 'cmpbl-command-central' ),
			'items_list_navigation' => __( 'Pages list navigation', 'cmpbl-command-central' ),
			'filter_items_list'     => __( 'Filter pages list', 'cmpbl-command-central' ),
		);
	}

	private function get_args_defaults() {
		return array(
			'label'                 => __( 'Page', 'cmpbl-command-central' ),
			'description'           => __( 'Page Description', 'cmpbl-command-central' ),
			'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'page-attributes' ),
			'taxonomies'            => array( 'category', 'placement' ),
			'hierarchical'          => true,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 25,
			'menu_icon'             => 'dashicons-admin-page',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			// 'has_archive'           => true,
			'has_archive'           => false,
			'rewrite'               => array(
				'with_front' => false,
				'slug' => 'page',
			),
			'exclude_from_search'   => false,
			'query_var'             => true,
			'publicly_queryable'    => true,
			'capability_type'       => 'page',
			'show_in_rest'          => true,
			'rest_base'             => 'pages',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
		);
	}
}
