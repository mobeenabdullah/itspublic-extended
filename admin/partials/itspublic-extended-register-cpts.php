<?php

// Register Custom Post Type Member
function itspublic_member_cpt() {

    $labels = array(
        'name' => _x( 'Members', 'Post Type General Name', 'itspublic' ),
        'singular_name' => _x( 'Member', 'Post Type Singular Name', 'itspublic' ),
        'menu_name' => _x( 'Members', 'Admin Menu text', 'itspublic' ),
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
        'show_in_nav_menus' => false,
        'can_export' => true,
        'has_archive' => false,
        'hierarchical' => false,
        'exclude_from_search' => true,
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
		'show_in_nav_menus' => false,
		'can_export' => true,
		'has_archive' => true,
		'hierarchical' => false,
		'exclude_from_search' => true,
		'show_in_rest' => true,
		'publicly_queryable' => true,
		'capability_type' => 'post',
	);
	register_post_type( 'project', $args );

}
add_action( 'init', 'create_project_cpt', 0 );