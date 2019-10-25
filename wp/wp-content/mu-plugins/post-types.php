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

    register_post_type( 'packages', array(
        'capability_type' => 'package',
        'map_meta_cap' => true,
        'register_meta' => true,
        'public' => true,
        'show_ui' => true,
        'show_in_rest' => true,
        'show_in_menu' => true,
        'supports' => array('title', 'editor', 'author', 'custom-fields'),
        'rewrite' => array( 'slug' => 'packages' ),
        'labels' => array(
            'name' => 'Packages',
            'add_new_item' => 'Add New Package',
            'edit_item' => 'Edit Package',
            'all_items' => 'All Packages',
            'singular_name' => 'Package'
        ),
        'menu_icon' => 'dashicons-feedback'
    ));
}

add_action('init', 'post_types');

