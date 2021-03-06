<?php
	/* Table of Contents:
		1.0:- Includes
		2.0:- Stylesheets and Scripts
		3.0:- Init
			3.1:- Menus
			3.2:- Custom Post Types
				3.2.1:- Staff
				3.2.2:- Carousel Images
				3.2.3:- Enquiries
			3.3:- Custom Header
			3.4:- Custom Background
			3.5:- Post Thumbnails
			3.6:- Post Formats
		4.0:- Sidebars
		5.0:- Ajax
	*/


	// 1.0:- Includes
	require_once get_template_directory().'/includes/class-wp-bootstrap-navwalker.php';

	require get_parent_theme_file_path( './includes/custom_customiser.php' );

	require get_parent_theme_file_path( './includes/custom_fields.php' );


	// 2.0:- Stylesheets and Scripts
	add_action( 'wp_enqueue_scripts', function() {
		$css_directory = get_template_directory_uri().'/assets/css/';
		$js_directory = get_template_directory_uri().'/assets/js/';

		// Stylesheets
		wp_enqueue_style( 'bootstrap', $css_directory.'bootstrap.min.css', array(), '4.1.3', 'all' );
		wp_enqueue_style( 'master', $css_directory.'master.css', array(), '0.0.3', 'all' );

		// Scripts
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'bootstrapjs', $js_directory.'bootstrap.min.js', array(), '4.1.3', true );
		wp_enqueue_script( 'theme-scripts', $js_directory.'theme-scripts.js', array(), '0.0.3', true );

		// Script localization
		global $wp_query;

		$theme_script_localize_data = array(
			'ajax_url'     => site_url().'/wp-admin/admin-ajax.php',
			'query'        => json_encode( $wp_query->query_vars ),
			'current_page' => get_query_var( 'paged' ) ? get_query_var( 'paged' ): 1,
			'max_page'     => $wp_query->max_num_pages,
		);

		wp_localize_script( 'theme-scripts', 'front_page_show_more', $theme_script_localize_data );
	});

	add_action( 'admin_enqueue_scripts', function(){
		$css_directory = get_template_directory_uri().'/assets/css/';
		$js_directory = get_template_directory_uri().'/assets/js/';

		// Stylesheets
		wp_enqueue_style( 'admin-style', $css_directory.'admin.css', array(), '0.0.1', 'all' );

		// Scripts
		wp_enqueue_script( 'admin-scripts', $js_directory.'admin-scripts.js', array(), '0.0.1', true );

		// Script localization
		global $metaboxes;

		$formats = array();

		foreach ( $metaboxes as $id => $metabox ) {
			if ( $metabox['format_condition'] ) {
				$formats[$metabox['format_condition']] = $id;
			}
		}

		$admin_script_localize_data = array(
			'formats' => $formats,
		);

		wp_localize_script( 'admin-scripts', 'metaboxes', $admin_script_localize_data );
	});


	// 3.0:- Init
	function custom_theme_init() {
		// 3.1:- Menus
		register_nav_menu( 'defaultnav', __( 'Default Navigation' ) );

		// 3.2:- Custom Post Types

		// 3.2.1:- Staff
		$staff_labels = array(
			'name'               => _x( 'Staff', 'Post type name', '18wdwu02theme' ),
			'singular_name'      => _x( 'Staff', 'Post type singular name', '18wdwu02theme' ),
			'add_new_item'       => _x( 'Add New Staff Member', 'Adding new staff member', '18wdwu02theme' ),
			'edit_item'          => _x( 'Edit Staff Member', 'Editing staff member', '18wdwu02theme' ),
			'new_item'           => _x( 'New Staff Member', 'New staff member', '18wdwu02theme' ),
			'view_item'          => _x( 'View Staff Member', 'Viewing staff member', '18wdwu02theme' ),
			'view_items'         => _x( 'View Staff Members', 'Viewing staff members', '18wdwu02theme' ),
			'search_items'       => _x( 'Search Staff Members', 'Searching staff members', '18wdwu02theme' ),
			'not_found'          => _x( 'No Staff Members Found', 'No staff members found', '18wdwu02theme' ),
			'not_found_in_trash' => _x( 'No Staff Members found in Trash', 'No Staff Members found in Trash', '18wdwu02theme' ),
			'all_items'          => _x( 'All Staff Members', 'All staff members', '18wdwu02theme' ),
		);

		$staff_supports = array(
			'title',
			'thumbnail',
		);

		$staff_args = array(
			'labels'              => $staff_labels,
			'description'         => 'A post type for the staff members in the company',
			'public'              => true,
			'hierarchical'        => true,
			'exclude_from_search' => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => false,
			'menu_position'       => 25,
			'menu_icon'           => 'dashicons-groups',
			'supports'            => $staff_supports,
			'query_var'           => true,
		);

		register_post_type( 'staff', $staff_args );


		// 3.2.2:- Carousel Images
		$carousel_images_labels = array(
			'name'               => _x( 'Carousel', 'Post type name', '18wdwu02theme' ),
			'singular_name'      => _x( 'Carousel Image', 'Post type singular name', '18wdwu02theme' ),
			'add_new_item'       => _x( 'Add New Image', 'Adding new carousel image', '18wdwu02theme' ),
			'edit_item'          => _x( 'Edit Carousel Image', 'Editing carousel image', '18wdwu02theme' ),
			'new_item'           => _x( 'New Carousel Image', 'New carousel image', '18wdwu02theme' ),
			'view_item'          => _x( 'View Carousel Image', 'Viewing carousel image', '18wdwu02theme' ),
			'view_items'         => _x( 'View Carousel Images', 'Viewing carousel images', '18wdwu02theme' ),
			'search_items'       => _x( 'Search Carousel Images', 'Searching carousel images', '18wdwu02theme' ),
			'not_found'          => _x( 'No Carousel Images found', 'No carousel images found', '18wdwu02theme' ),
			'not_found_in_trash' => _x( 'No Carousel Images found in Trash', 'No Carousel Images found in Trash', '18wdwu02theme' ),
			'all_items'          => _x( 'All Carousel Images', 'All carousel images', '18wdwu02theme' ),
		);

		$carousel_images_supports = array(
			'title',
			'thumbnail',
		);

		$carousel_images_args = array(
			'labels'              => $carousel_images_labels,
			'description'         => 'Carousel images for the front-page carousel',
			'public'              => true,
			'hierarchical'        => true,
			'exclude_from_search' => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => false,
			'menu_position'       => 25,
			'menu_icon'           => 'dashicons-images-alt2',
			'supports'            => $carousel_images_supports,
			'query_var'           => true,
		);

		register_post_type( 'carousel', $carousel_images_args );


		//3.2.3:- Enquiries
		$enquiries_labels = array(
			'name'               => _x( 'Enquiries', 'Post type name', '18wdwu02theme' ),
			'singular_name'      => _x( 'Enquiries', 'Post type singular name', '18wdwu02theme' ),
			'add_new_item'       => _x( 'Add New Enquiry', 'Adding new enquiry', '18wdwu02theme' ),
			'edit_item'          => _x( 'Edit Enquiry', 'Editing enquiry', '18wdwu02theme' ),
			'new_item'           => _x( 'New Enquiry', 'New enquiry', '18wdwu02theme' ),
			'view_item'          => _x( 'View Enquiry', 'Viewing enquiry', '18wdwu02theme' ),
			'view_items'         => _x( 'View Enquiries', 'Viewing enquiries', '18wdwu02theme' ),
			'search_items'       => _x( 'Search Enquiries', 'Searching enquiries', '18wdwu02theme' ),
			'not_found'          => _x( 'No Enquiries found', 'No enquiries found', '18wdwu02theme' ),
			'not_found_in_trash' => _x( 'No Enquiries found in Trash', 'No enquiries found in Trash', '18wdwu02theme' ),
			'all_items'          => _x( 'All Enquiries', 'All enquiries', '18wdwu02theme' ),
		);

		$enquiries_supports = array(
			'title',
			'editor',
		);

		$enquiries_capabilities = array(
			'create_posts'    => 'do_not_allow',
		);

		$enquiries_args = array(
			'labels'              => $enquiries_labels,
			'description'         => 'Enquiries',
			'public'              => false,
			'hierarchical'        => true,
			'exclude_from_search' => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => false,
			'menu_position'       => 25,
			'menu_icon'           => 'dashicons-megaphone',
			'supports'            => $enquiries_supports,
			'query_var'           => true,
			// 'capabilities'        => $enquiries_capabilities,
		);

		register_post_type( 'enquiries', $enquiries_args );


		// 3.3:- Custom Header
		$header_banner = array(
			'url'           => get_template_directory_uri().'/assets/images/defaultheader.png',
			'thumbnail_url' => get_template_directory_uri().'/assets/images/defaultheader.png',
			'description'   => 'Nav image',
		);

		register_default_headers(array(
			'banner' => $header_banner,
		));

		$header_args = array(
			'default-image'          => get_template_directory_uri().'/assets/images/defaultheader.png',
			'width'                  => 1280,
			'height'                 => 720,
			'flex-height'            => false,
			'flex-width'             => false,
			'uploads'                => true,
			'random-default'         => false,
			'header-text'            => false,
			'default-text-color'     => '',
		);

		add_theme_support( 'custom-header', $defaults );


		// 3.4:- Custom Background
		$background_args = array(
			'default-color'          => '000000',
			'default-image'          => '',
			'default-repeat'         => 'repeat',
			'default-position-x'     => 'left',
	        'default-position-y'     => 'top',
	        'default-size'           => 'auto',
			'default-attachment'     => 'fixed',
		);

		add_theme_support( 'custom-background', $background_args );


		// 3.5:- Post Thumbnails
		add_theme_support( 'post-thumbnails' );


		// 3.6:- Post Formats
		$post_formats = array(
			'aside',
			'gallery',
			'image',
			'video',
			'link',
			'audio',
		);

		add_theme_support( 'post-formats', $post_formats );
	}

	add_action( 'init', 'custom_theme_init' );


	// 4.0:- Sidebars
	add_action( 'widgets_init', function() {
		register_sidebar(array(
			'id'            => 'sidebar-main',
			'name'          => __( 'Main Sidebar', 'theme-slug' ),
			'description'   => __( 'Main sidebar appears on all pages', 'theme-slug' ),
			'before_widget' => '<div id="%1$s" class="custom-widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		));
	});


	// 5.0:- Ajax
	function ajax_load_more_posts_on_front_page(){
		$args = json_decode( stripslashes( $_POST['query'] ), true );
		$args['paged'] = $_POST['page'] + 1;
		$args['post_status'] = 'publish';

		query_posts( $args );

		if ( have_posts() ) {
			while ( have_posts() ) {
				the_post();

				get_template_part( 'content', get_post_format() );
			}
		}

		die();
	}

	add_action( 'wp_ajax_loadmore', 'ajax_load_more_posts_on_front_page' );
	add_action( 'wp_ajax_nopriv_loadmore', 'ajax_load_more_posts_on_front_page' );
