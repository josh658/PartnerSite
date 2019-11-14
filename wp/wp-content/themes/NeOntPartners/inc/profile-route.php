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

    if(get_post($data['postID'])->post_author == get_current_user_id()){
        foreach ($data['acf'] as $key => $val){
            update_field($key, $val, $data['postID']);
        }
        
        // update_field('camping', $data['parks'], $data['postID']);
        // update_field('attractions', $data['attractions'], $data['postID']);
        
        //TODO: escape all this
        wp_update_post(array(
            'ID'    => $data['postID'],
            'post_title' => $data['title'],
            'post_content' => $data['content'],
            'post_status' => $data['status']
        ));

        wp_update_user(array(
            'ID' => get_current_user_id(),
            'first_name' => $data['contactFirstName'],
            'last_name' => $data['contactLastName'],
            'user_email' => $data['contactEmail']
        ));

        return new WP_REST_Response( array('message' => 'OK'), 200);
    } else {
        return new WP_REST_Response( array('message' => 'Email already exists.',
                                           'email_exists' => email_exists($data['email'])), 200);
    }
    
    
    //create two partners pages for them (one draft one published) (will be passed in through $data)

    //reload page to help redirect
}