<?php
function post_types(){
    register_post_type( 'partners', array(
        'capability_type' => 'partner',
        'map_meta_cap' => true,
        'register_meta' => true,
        'public' => false,
        'show_ui' => true,
        'show_in_rest' => true,
        'supports' => array('title', 'editor', 'author', 'custom-fields'),
        'labels' => array(
            'name' => 'Partners',
            'add_new_item' => 'Add New Partner',
            'edit_item' => 'Edit Partner',
            'all_items' => 'All Partners',
            'singular_name' => 'Partner'
        ),
        'menu_icon' => 'dashicons-groups'
    ));
}

add_action('init', 'post_types');

