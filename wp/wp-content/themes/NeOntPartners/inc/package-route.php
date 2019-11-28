<?php

add_action('rest_api_init', 'editPackage');

function editPackage(){
    register_rest_route('neont/v1', '/packages', array(
        'methods' => array('POST', 'GET'),
        'callback' => 'packages'
    ));
}

function packages($data){

    update_field('start_date', $data['startDate'], $data['postID']);
    update_field('end_date', $data['endDate'], $data['postID']);

    wp_update_post( array(
        'ID'    => $data['postID'],
        'post_title' => $data['title'],
        'post_content' => $data['content'],
        'post_status' => $data['status']
    ));

    return new WP_REST_Response( array('message' => 'OK'));
}