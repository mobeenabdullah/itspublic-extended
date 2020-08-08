<?php

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

// Register Taxonomy Onderwerp
function create_onderwerp_tax() {

	$labels = array(
		'name'              => _x( 'Onderwerpen', 'taxonomy general name', 'itspublic' ),
		'singular_name'     => _x( 'Onderwerp', 'taxonomy singular name', 'itspublic' ),
		'search_items'      => __( 'Search Onderwerpen', 'itspublic' ),
		'all_items'         => __( 'All Onderwerpen', 'itspublic' ),
		'parent_item'       => __( 'Parent Onderwerp', 'itspublic' ),
		'parent_item_colon' => __( 'Parent Onderwerp:', 'itspublic' ),
		'edit_item'         => __( 'Edit Onderwerp', 'itspublic' ),
		'update_item'       => __( 'Update Onderwerp', 'itspublic' ),
		'add_new_item'      => __( 'Add New Onderwerp', 'itspublic' ),
		'new_item_name'     => __( 'New Onderwerp Name', 'itspublic' ),
		'menu_name'         => __( 'Onderwerp', 'itspublic' ),
	);
	$args = array(
		'labels' => $labels,
		'description' => __( 'Custom onderwerp taxonomy for Materiaal CPT', 'itspublic' ),
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
	register_taxonomy( 'onderwerp', array('materiaal'), $args );

}
add_action( 'init', 'create_onderwerp_tax' );

// Register Taxonomy Categorie
function create_categorie_tax() {

	$labels = array(
		'name'              => _x( ' Categorieen', 'taxonomy general name', 'itspublic' ),
		'singular_name'     => _x( 'Categorie', 'taxonomy singular name', 'itspublic' ),
		'search_items'      => __( 'Search  Categorieen', 'itspublic' ),
		'all_items'         => __( 'All  Categorieen', 'itspublic' ),
		'parent_item'       => __( 'Parent Categorie', 'itspublic' ),
		'parent_item_colon' => __( 'Parent Categorie:', 'itspublic' ),
		'edit_item'         => __( 'Edit Categorie', 'itspublic' ),
		'update_item'       => __( 'Update Categorie', 'itspublic' ),
		'add_new_item'      => __( 'Add New Categorie', 'itspublic' ),
		'new_item_name'     => __( 'New Categorie Name', 'itspublic' ),
		'menu_name'         => __( 'Categorie', 'itspublic' ),
	);
	$args = array(
		'labels' => $labels,
		'description' => __( 'Custom categorie taxonomy for Materiaal CPT', 'itspublic' ),
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
	register_taxonomy( 'categorie', array('materiaal'), $args );

}
add_action( 'init', 'create_categorie_tax' );

// Register Taxonomy Filetype
function create_filetype_tax() {

	$labels = array(
		'name'              => _x( 'Filetypes', 'taxonomy general name', 'itspublic' ),
		'singular_name'     => _x( 'Filetype', 'taxonomy singular name', 'itspublic' ),
		'search_items'      => __( 'Search Filetypes', 'itspublic' ),
		'all_items'         => __( 'All Filetypes', 'itspublic' ),
		'parent_item'       => __( 'Parent Filetype', 'itspublic' ),
		'parent_item_colon' => __( 'Parent Filetype:', 'itspublic' ),
		'edit_item'         => __( 'Edit Filetype', 'itspublic' ),
		'update_item'       => __( 'Update Filetype', 'itspublic' ),
		'add_new_item'      => __( 'Add New Filetype', 'itspublic' ),
		'new_item_name'     => __( 'New Filetype Name', 'itspublic' ),
		'menu_name'         => __( 'Filetype', 'itspublic' ),
	);
	$args = array(
		'labels' => $labels,
		'description' => __( 'Custom filetype taxonomy for Materiaal CPT', 'itspublic' ),
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
	register_taxonomy( 'filetype', array('materiaal'), $args );

}
add_action( 'init', 'create_filetype_tax' );