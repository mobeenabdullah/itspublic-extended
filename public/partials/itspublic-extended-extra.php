<?php

// Trimming Excerpt Length for Teams and Projects
function itspublic_custom_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'itspublic_custom_excerpt_length', 999 );
