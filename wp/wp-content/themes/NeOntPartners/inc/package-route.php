<?php

add_action('rest_api_init', 'editPackage');

function editPackage(){
    register_rest_route('neont/v1', '/packages', array(
        'methods' => array('POST', 'GET'),
        'callback' => 'packages'
    ));
}

function packages($data){

    if(get_post($data['postID'])->post_author == get_current_user_id() || in_array('administrator', wp_get_current_user()->roles)){ 
        
        if($data['status'] == 'publish'){
            $originalPostID = get_field('original_post_id', $data['postID']);
            if(!is_null($originalPostID)){
                update_package_post($originalPostID, $data, 'publish');
            } else {
                $newPostID = create_custom_post('packages', get_post($data['postID'])->post_author);
                update_package_post($newPostID, $data, 'publish');
                update_field('original_post_id', $newPostID, $data['postID']);
            }
            update_package_post($data['postID'], $data, 'draft');
        } else {
            update_package_post($data['postID'], $data, $data['status']);
        }
        return new WP_REST_Response( array('message' => 'OK'));
    } else {
        return new WP_REST_Response( array('message' => 'Error'));
    }
}