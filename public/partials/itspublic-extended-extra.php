<?php

// Trimming Excerpt Length for Teams and Projects
//function itspublic_custom_excerpt_length( $length ) {
//	return 20;
//}
//add_filter( 'excerpt_length', 'itspublic_custom_excerpt_length', 999 );

function get_excerpt(){
	$excerpt = get_the_content();
	$excerpt = preg_replace(" ([.*?])",'',$excerpt);
	$excerpt = strip_shortcodes($excerpt);
	$excerpt = strip_tags($excerpt);
	$excerpt = substr($excerpt, 0, 130);
	$excerpt = substr($excerpt, 0, strripos($excerpt, " "));
	$excerpt = trim(preg_replace( '/\s+/', ' ', $excerpt));
	$excerpt = $excerpt.'...';
	return $excerpt;
}
