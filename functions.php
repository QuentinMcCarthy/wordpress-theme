<?php
	// Table of Contents:
	// 1.0 Plugins
	// 2.0 Functions for Actions
	// 2.1 Stylesheets and Scripts
	// 2.2 Menus
	// 2.3 Custom Post Types
	// 3.0 Actions
	// 4.0 Theme Support
	// 5.0 Other


	// 1.0 Plugins
	require_once get_template_directory().'/class-wp-bootstrap-navwalker.php';


	// 2.0 Functions for Actions

	// 2.1 Stylesheets and Scripts
	function add_custom_files() {
		$css_directory = get_template_directory_uri().'/assets/css/';
		$js_directory = get_template_directory_uri().'/assets/js/';

		// Stylesheets
		wp_enqueue_style( 'bootstrap', $css_directory.'bootstrap.min.css', array(), '4.1.3', 'all' );
		wp_enqueue_style( 'master', $css_directory.'master.css', array(), '0.0.1', 'all' );

		// Scripts
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'bootstrapjs', $js_directory.'bootstrap.min.js', array(), '4.1.3', true );
		wp_enqueue_script( 'master', $js_directory.'script.js', array( 'jquery' ), '0.0.1', true );
	}

	// 2.2 Menus
	function add_custom_menus() {
		// Default navigation menu
		register_nav_menu( 'defaultnav', __( 'Default Navigation' ) );
	}

	// 2.3 Custom Post Types
	function add_staff_post_type(){
		$labels = array(
			'name'               => _x( 'Staff', 'Post type name', '18wdwu02theme' ),
			'singular_name'      => _x( 'Staff', 'Post type singular name', '18wdwu02theme' ),
			'add_new_item'       => _x( 'Add New Staff Member', 'Adding new staff member', '18wdwu02theme' ),
			'edit_item'          => _x( 'Edit Staff Member', 'Editing staff member', '18wdwu02theme' ),
			'new_item'           => _x( 'New Staff Member', 'New staff member', '18wdwu02theme' ),
			'view_item'          => _x( 'View Staff Member', 'View staff member', '18wdwu02theme' ),
			'view_items'         => _x( 'View Staff Members', 'View staff members', '18wdwu02theme' ),
			'search_items'       => _x( 'Search Staff Members', 'Search staff members', '18wdwu02theme' ),
			'not_found'          => _x( 'No Staff Members Found', 'No staff members found', '18wdwu02theme' ),
			'not_found_in_trash' => _x( 'No Staff Members found in Trash', 'No Staff Members found in Trash', '18wdwu02theme' ),
			'all_items'          => _x( 'All Staff Members', 'All staff members', '18wdwu02theme' ),
		);

		$supports = array(
			'title',
			'thumbnail',
		);

		$args = array(
			'labels'              => $labels,
			'description'         => 'A post type for the staff members in the company',
			'public'              => true,
			'hierarchical'        => true,
			'exclude_from_search' => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => false,
			'menu_position'       => 20,
			'menu_icon'           => 'dashicons-groups',
			'supports'            => $supports,
			'query_var'           => true,
		);

		register_post_type( 'staff', $args);
	}


	// 3.0 Actions
	add_action( 'wp_enqueue_scripts', 'add_custom_files' );
	add_action( 'init', 'add_custom_menus' );
	add_action( 'init', 'add_staff_post_type' );


	// 4.0 Theme Support
	add_theme_support( 'post-thumbnails' );

	$post_formats = array(
		'aside',
		'gallery',
		'image',
		'video',
	);

	add_theme_support( 'post-formats', $post_formats );


	// 5.0 Other
	add_image_size( 'icon', 50, 50, true );
