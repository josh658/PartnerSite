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
    //check to see if email is already in use 
    // if($data['email'] == "" || $data['FirstName'] == "" || $data['LastName'] == "" || $data['Password'] == ""){
    //     return new WP_REST_Response(array('message' => 'missing arg'), 200);
    // }

    echo get_post($data['postID'])->post_author;

    if(get_post($data['postID'])->post_author == get_current_user_id()){
        foreach  ($data["accomodations"] as $value){
            
        }
        return new WP_REST_Response( array('message' => 'OK'), 200);
    } else {
        return new WP_REST_Response( array('message' => 'Email already exists.',
                                           'email_exists' => email_exists($data['email'])), 200);
    }
    
    
    //create two partners pages for them (one draft one published) (will be passed in through $data)

    //reload page to help redirect
}