<?php

// Register Taxonomy Project Type
// Register Taxonomy Project Type
function create_projecttype_tax() {

	$labels = array(
		'name'              => _x( 'Project Types', 'taxonomy general name', 'itspublic' ),
		'singular_name'     => _x( 'Project Type', 'taxonomy singular name', 'itspublic' ),
		'search_items'      => __( 'Search Project Types', 'itspublic' ),
		'all_items'         => __( 'All Project Types', 'itspublic' ),
		'parent_item'       => __( 'Parent Project Type', 'itspublic' ),
		'parent_item_colon' => __( 'Parent Project Type:', 'itspublic' ),
		'edit_item'         => __( 'Edit Project Type', 'itspublic' ),
		'update_item'       => __( 'Update Project Type', 'itspublic' ),
		'add_new_item'      => __( 'Add New Project Type', 'itspublic' ),
		'new_item_name'     => __( 'New Project Type Name', 'itspublic' ),
		'menu_name'         => __( 'Project Type', 'itspublic' ),
	);
	$args = array(
		'labels' => $labels,
		'description' => __( 'Custom taxonomy for Project CPT', 'itspublic' ),
		'hierarchical' => true,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_nav_menus' => false,
		'show_tagcloud' => false,
		'show_in_quick_edit' => true,
		'show_admin_column' => false,
		'show_in_rest' => true,
	);
	register_taxonomy( 'project_type', array('project'), $args );

}
add_action( 'init', 'create_projecttype_tax' );