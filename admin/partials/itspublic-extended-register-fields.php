<?php

// Register Custom Fields for Members
function itspublic_members_fields( $meta_boxes ) {
    $prefix = 'itspublic-';

    $meta_boxes[] = array(
        'id' => 'member_fields',
        'title' => esc_html__( 'Member Fields', 'itspublic' ),
        'post_types' => array('member' ),
        'context' => 'advanced',
        'priority' => 'default',
        'autosave' => 'true',
        'fields' => array(
            array(
                'id' => $prefix . 'member_designation',
                'type' => 'text',
                'name' => esc_html__( 'Designation', 'itspublic' ),
            ),
            array(
                'id' => $prefix . 'member_email',
                'name' => esc_html__( 'Email', 'itspublic' ),
                'type' => 'email',
            ),
            array(
                'id' => $prefix . 'member_linkedin',
                'type' => 'text',
                'name' => esc_html__( 'LinkedIn', 'itspublic' ),
            ),
        ),
    );

    return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'itspublic_members_fields' );