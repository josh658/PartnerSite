<?php
function post_types(){
    register_post_type( 'partners', array(
        'public' => true,
        'labels' => array(
            'name' => 'Partners',
            'add_new_item' => 'Add New Partner',
            'edit_item' => 'Edit Partner',
            'all_items' => 'All Events',
            'singular_name' => 'Partner'
        ),
        'menu_icon' => 'dashicons-groups'
    ));
}

add_action('init', 'post_types');

