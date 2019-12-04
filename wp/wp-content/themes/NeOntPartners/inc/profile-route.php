<?php

/**
 * create a custom route for our registration form
 * this will allow us to create a new user and make new partner posts and 
 * package post for this user.
 */

add_action('rest_api_init', 'editProfile');

function editProfile(){
    register_rest_route('neont/v1', '/profile', array(
        'methods'   => 'POST',
        'callback'  => 'profileForm'
    ));
}

function profileForm($data){

    if((get_post($data['postID'])->post_author == get_current_user_id()) || in_array('administrator', wp_get_current_user()->roles) ){
        if($data['status'] == 'publish'){
            $originalPostID = get_field('original_post_id', $data['postID']);
            if( !is_null($originalPostID)){
                update_profile_post($originalPostID, $data, 'publish');
            } else {
                $newPostID = create_custom_post('partners', get_post($data['postID'])->post_author);
                //return new WP_REST_Response( array( 'message' => $newPostID));
                update_profile_post($newPostID, $data, 'publish');
                update_field('original_post_id', $newPostID, $data['postID']);
            }
            update_profile_post($data['postID'], $data, 'draft');
        } else {
            update_profile_post($data['postID'], $data, 'pending');
        }
        


        return new WP_REST_Response( array('message' => 'OK',), 200);
    } else {
        return new WP_REST_Response( array('message' => 'Error'), 200);
    }
    
    
    //create two partners pages for them (one draft one published) (will be passed in through $data)

    //reload page to help redirect
}