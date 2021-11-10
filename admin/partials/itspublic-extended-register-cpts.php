<?php

// Register Custom Post Type Member
function itspublic_member_cpt() {

    $labels = array(
        'name' => _x( 'Members', 'Post Type General Name', 'itspublic' ),
        'singular_name' => _x( 'Member', 'Post Type Singular Name', 'itspublic' ),
        'menu_name' => _x( 'Team', 'Admin Menu text', 'itspublic' ),
        'name_admin_bar' => _x( 'Member', 'Add New on Toolbar', 'itspublic' ),
        'archives' => __( 'Member Archives', 'itspublic' ),
        'attributes' => __( 'Member Attributes', 'itspublic' ),
        'parent_item_colon' => __( 'Parent Member:', 'itspublic' ),
        'all_items' => __( 'All Members', 'itspublic' ),
        'add_new_item' => __( 'Add New Member', 'itspublic' ),
        'add_new' => __( 'Add New', 'itspublic' ),
        'new_item' => __( 'New Member', 'itspublic' ),
        'edit_item' => __( 'Edit Member', 'itspublic' ),
        'update_item' => __( 'Update Member', 'itspublic' ),
        'view_item' => __( 'View Member', 'itspublic' ),
        'view_items' => __( 'View Members', 'itspublic' ),
        'search_items' => __( 'Search Member', 'itspublic' ),
        'not_found' => __( 'Not found', 'itspublic' ),
        'not_found_in_trash' => __( 'Not found in Trash', 'itspublic' ),
        'featured_image' => __( 'Featured Image', 'itspublic' ),
        'set_featured_image' => __( 'Set featured image', 'itspublic' ),
        'remove_featured_image' => __( 'Remove featured image', 'itspublic' ),
        'use_featured_image' => __( 'Use as featured image', 'itspublic' ),
        'insert_into_item' => __( 'Insert into Member', 'itspublic' ),
        'uploaded_to_this_item' => __( 'Uploaded to this Member', 'itspublic' ),
        'items_list' => __( 'Members list', 'itspublic' ),
        'items_list_navigation' => __( 'Members list navigation', 'itspublic' ),
        'filter_items_list' => __( 'Filter Members list', 'itspublic' ),
    );
    $args = array(
        'label' => __( 'Member', 'itspublic' ),
        'description' => __( 'Custom post type for Members', 'itspublic' ),
        'labels' => $labels,
        'menu_icon' => 'dashicons-buddicons-buddypress-logo',
        'supports' => array('title', 'editor', 'thumbnail'),
        'taxonomies' => array(),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 25,
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => true,
        'hierarchical' => false,
        'exclude_from_search' => false,
        'show_in_rest' => true,
        'publicly_queryable' => true,
        'capability_type' => 'post',
    );
    register_post_type( 'member', $args );

}
add_action( 'init', 'itspublic_member_cpt', 0 );

// Register Custom Post Type Project
function create_project_cpt() {

	$labels = array(
		'name' => _x( 'Projects', 'Post Type General Name', 'itspublic' ),
		'singular_name' => _x( 'Project', 'Post Type Singular Name', 'itspublic' ),
		'menu_name' => _x( 'Projects', 'Admin Menu text', 'itspublic' ),
		'name_admin_bar' => _x( 'Project', 'Add New on Toolbar', 'itspublic' ),
		'archives' => __( 'Project Archives', 'itspublic' ),
		'attributes' => __( 'Project Attributes', 'itspublic' ),
		'parent_item_colon' => __( 'Parent Project:', 'itspublic' ),
		'all_items' => __( 'All Projects', 'itspublic' ),
		'add_new_item' => __( 'Add New Project', 'itspublic' ),
		'add_new' => __( 'Add New', 'itspublic' ),
		'new_item' => __( 'New Project', 'itspublic' ),
		'edit_item' => __( 'Edit Project', 'itspublic' ),
		'update_item' => __( 'Update Project', 'itspublic' ),
		'view_item' => __( 'View Project', 'itspublic' ),
		'view_items' => __( 'View Projects', 'itspublic' ),
		'search_items' => __( 'Search Project', 'itspublic' ),
		'not_found' => __( 'Not found', 'itspublic' ),
		'not_found_in_trash' => __( 'Not found in Trash', 'itspublic' ),
		'featured_image' => __( 'Featured Image', 'itspublic' ),
		'set_featured_image' => __( 'Set featured image', 'itspublic' ),
		'remove_featured_image' => __( 'Remove featured image', 'itspublic' ),
		'use_featured_image' => __( 'Use as featured image', 'itspublic' ),
		'insert_into_item' => __( 'Insert into Project', 'itspublic' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Project', 'itspublic' ),
		'items_list' => __( 'Projects list', 'itspublic' ),
		'items_list_navigation' => __( 'Projects list navigation', 'itspublic' ),
		'filter_items_list' => __( 'Filter Projects list', 'itspublic' ),
	);
	$args = array(
		'label' => __( 'Project', 'itspublic' ),
		'description' => __( 'Custom post type for Projects', 'itspublic' ),
		'labels' => $labels,
		'menu_icon' => 'dashicons-index-card',
		'supports' => array('title', 'editor', 'thumbnail'),
		'taxonomies' => array(),
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'menu_position' => 25,
		'show_in_admin_bar' => true,
		'show_in_nav_menus' => true,
		'can_export' => true,
		'has_archive' => true,
		'hierarchical' => false,
		'exclude_from_search' => false,
		'show_in_rest' => true,
		'publicly_queryable' => true,
		'capability_type' => 'post',
	);
	register_post_type( 'project', $args );

}
add_action( 'init', 'create_project_cpt', 0 );

// Register Custom Post Type Photo
function create_photo_cpt() {

	$labels = array(
		'name' => _x( 'Photos', 'Post Type General Name', 'itspublic' ),
		'singular_name' => _x( 'Photo', 'Post Type Singular Name', 'itspublic' ),
		'menu_name' => _x( 'Photos', 'Admin Menu text', 'itspublic' ),
		'name_admin_bar' => _x( 'Photo', 'Add New on Toolbar', 'itspublic' ),
		'archives' => __( 'Photo Archives', 'itspublic' ),
		'attributes' => __( 'Photo Attributes', 'itspublic' ),
		'parent_item_colon' => __( 'Parent Photo:', 'itspublic' ),
		'all_items' => __( 'All Photos', 'itspublic' ),
		'add_new_item' => __( 'Add New Photo', 'itspublic' ),
		'add_new' => __( 'Add New', 'itspublic' ),
		'new_item' => __( 'New Photo', 'itspublic' ),
		'edit_item' => __( 'Edit Photo', 'itspublic' ),
		'update_item' => __( 'Update Photo', 'itspublic' ),
		'view_item' => __( 'View Photo', 'itspublic' ),
		'view_items' => __( 'View Photos', 'itspublic' ),
		'search_items' => __( 'Search Photo', 'itspublic' ),
		'not_found' => __( 'Not found', 'itspublic' ),
		'not_found_in_trash' => __( 'Not found in Trash', 'itspublic' ),
		'featured_image' => __( 'Featured Image', 'itspublic' ),
		'set_featured_image' => __( 'Set featured image', 'itspublic' ),
		'remove_featured_image' => __( 'Remove featured image', 'itspublic' ),
		'use_featured_image' => __( 'Use as featured image', 'itspublic' ),
		'insert_into_item' => __( 'Insert into Photo', 'itspublic' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Photo', 'itspublic' ),
		'items_list' => __( 'Photos list', 'itspublic' ),
		'items_list_navigation' => __( 'Photos list navigation', 'itspublic' ),
		'filter_items_list' => __( 'Filter Photos list', 'itspublic' ),
	);
	$args = array(
		'label' => __( 'Photo', 'itspublic' ),
		'description' => __( 'Custom post type for Photos', 'itspublic' ),
		'labels' => $labels,
		'menu_icon' => 'dashicons-format-gallery',
		'supports' => array('title', 'thumbnail'),
		'taxonomies' => array(),
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'menu_position' => 25,
		'show_in_admin_bar' => true,
		'show_in_nav_menus' => true,
		'can_export' => true,
		'has_archive' => true,
		'hierarchical' => false,
		'exclude_from_search' => false,
		'show_in_rest' => true,
		'publicly_queryable' => true,
		'capability_type' => 'post',
	);
	register_post_type( 'photo', $args );

}
add_action( 'init', 'create_photo_cpt', 0 );

// Register Custom Post Type Materiaal
function create_materiaal_cpt() {

	$labels = array(
		'name' => _x( 'Materialen', 'Post Type General Name', 'itspublic' ),
		'singular_name' => _x( 'Materiaal', 'Post Type Singular Name', 'itspublic' ),
		'menu_name' => _x( 'Materialen', 'Admin Menu text', 'itspublic' ),
		'name_admin_bar' => _x( 'Materiaal', 'Add New on Toolbar', 'itspublic' ),
		'archives' => __( 'Materiaal Archives', 'itspublic' ),
		'attributes' => __( 'Materiaal Attributes', 'itspublic' ),
		'parent_item_colon' => __( 'Parent Materiaal:', 'itspublic' ),
		'all_items' => __( 'All Materialen', 'itspublic' ),
		'add_new_item' => __( 'Add New Materiaal', 'itspublic' ),
		'add_new' => __( 'Add New', 'itspublic' ),
		'new_item' => __( 'New Materiaal', 'itspublic' ),
		'edit_item' => __( 'Edit Materiaal', 'itspublic' ),
		'update_item' => __( 'Update Materiaal', 'itspublic' ),
		'view_item' => __( 'View Materiaal', 'itspublic' ),
		'view_items' => __( 'View Materialen', 'itspublic' ),
		'search_items' => __( 'Search Materiaal', 'itspublic' ),
		'not_found' => __( 'Not found', 'itspublic' ),
		'not_found_in_trash' => __( 'Not found in Trash', 'itspublic' ),
		'featured_image' => __( 'Featured Image', 'itspublic' ),
		'set_featured_image' => __( 'Set featured image', 'itspublic' ),
		'remove_featured_image' => __( 'Remove featured image', 'itspublic' ),
		'use_featured_image' => __( 'Use as featured image', 'itspublic' ),
		'insert_into_item' => __( 'Insert into Materiaal', 'itspublic' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Materiaal', 'itspublic' ),
		'items_list' => __( 'Materialen list', 'itspublic' ),
		'items_list_navigation' => __( 'Materialen list navigation', 'itspublic' ),
		'filter_items_list' => __( 'Filter Materialen list', 'itspublic' ),
	);
	$args = array(
		'label' => __( 'Materiaal', 'itspublic' ),
		'description' => __( 'Custom post type for Materials', 'itspublic' ),
		'labels' => $labels,
		'menu_icon' => 'dashicons-media-default',
		'supports' => array('title', 'editor'),
		'taxonomies' => array(),
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'menu_position' => 25,
		'show_in_admin_bar' => true,
		'show_in_nav_menus' => true,
		'can_export' => true,
		'has_archive' => true,
		'hierarchical' => false,
		'exclude_from_search' => false,
		'show_in_rest' => true,
		'publicly_queryable' => true,
		'capability_type' => 'post',
	);
	register_post_type( 'materiaal', $args );

}
add_action( 'init', 'create_materiaal_cpt', 0 );


// Register Custom Post Type Slide
function create_slide_cpt() {

	$labels = array(
		'name' => _x( 'Slides', 'Post Type General Name', 'itspublic-extended' ),
		'singular_name' => _x( 'Slide', 'Post Type Singular Name', 'itspublic-extended' ),
		'menu_name' => _x( 'Slides', 'Admin Menu text', 'itspublic-extended' ),
		'name_admin_bar' => _x( 'Slide', 'Add New on Toolbar', 'itspublic-extended' ),
		'archives' => __( 'Slide Archives', 'itspublic-extended' ),
		'attributes' => __( 'Slide Attributes', 'itspublic-extended' ),
		'parent_item_colon' => __( 'Parent Slide:', 'itspublic-extended' ),
		'all_items' => __( 'All Slides', 'itspublic-extended' ),
		'add_new_item' => __( 'Add New Slide', 'itspublic-extended' ),
		'add_new' => __( 'Add New', 'itspublic-extended' ),
		'new_item' => __( 'New Slide', 'itspublic-extended' ),
		'edit_item' => __( 'Edit Slide', 'itspublic-extended' ),
		'update_item' => __( 'Update Slide', 'itspublic-extended' ),
		'view_item' => __( 'View Slide', 'itspublic-extended' ),
		'view_items' => __( 'View Slides', 'itspublic-extended' ),
		'search_items' => __( 'Search Slide', 'itspublic-extended' ),
		'not_found' => __( 'Not found', 'itspublic-extended' ),
		'not_found_in_trash' => __( 'Not found in Trash', 'itspublic-extended' ),
		'featured_image' => __( 'Featured Image', 'itspublic-extended' ),
		'set_featured_image' => __( 'Set featured image', 'itspublic-extended' ),
		'remove_featured_image' => __( 'Remove featured image', 'itspublic-extended' ),
		'use_featured_image' => __( 'Use as featured image', 'itspublic-extended' ),
		'insert_into_item' => __( 'Insert into Slide', 'itspublic-extended' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Slide', 'itspublic-extended' ),
		'items_list' => __( 'Slides list', 'itspublic-extended' ),
		'items_list_navigation' => __( 'Slides list navigation', 'itspublic-extended' ),
		'filter_items_list' => __( 'Filter Slides list', 'itspublic-extended' ),
	);
	$args = array(
		'label' => __( 'Slide', 'itspublic-extended' ),
		'description' => __( 'CPT for Slides', 'itspublic-extended' ),
		'labels' => $labels,
		'menu_icon' => 'dashicons-format-image',
		'supports' => array('title'),
		'taxonomies' => array(),
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'menu_position' => 5,
		'show_in_admin_bar' => true,
		'show_in_nav_menus' => true,
		'can_export' => true,
		'has_archive' => true,
		'hierarchical' => false,
		'exclude_from_search' => true,
		'show_in_rest' => true,
		'publicly_queryable' => true,
		'capability_type' => 'post',
	);
	register_post_type( 'slide', $args );

}
add_action( 'init', 'create_slide_cpt', 0 );