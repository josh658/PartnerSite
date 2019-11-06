<?php

/**
 * create a custom route for our registration form
 * this will allow us to create a new user and make new partner posts and 
 * package post for this user.
 */

add_action('rest_api_init', 'registerNewUser');

function registerNewUser(){
    register_rest_route('neont/v1', '/register', array(
        'methods'   => 'POST',
        'callback'  => 'evaluateForm',
        'args'      => array(
            'email'     => array('required' => true),
            'FirstName' => array('required' => true),
            'LastName'  => array('required' => true),
            'Password'  => array('required' => true)
        )
    ));
}

function evaluateForm($data){
    
    if($data['email'] == "" || $data['FirstName'] == "" || $data['LastName'] == "" || $data['Password'] == ""){
        return new WP_REST_Response(array('message' => 'missing arg'), 200);
    }


    //check to see if email is already in use
    if(!email_exists($data['email'])){
        //create new user and store new user ID
        $newID = wp_insert_user( array(
            'user_login' => $data['FirstName'], 
            'user_pass' => $data['Password'], 
            'user_email' => $data['email'],
            'first_name' => $data['FirstName'],
            'last_name' => $data['LastName'],
            'nickname' => $data['FirstName'] . " " . $data['LastName'],
            'display_name' => $data['FirstName'] . " " . $data['LastName'],
            'role' => 'partnermember',
            'show_admin_bar_front' => 'false'
        ));

        //ERROR CHECK newID
        //sign new user in
        $new_user = wp_signon(array(
            'user_login' => $data['FirstName'],
            'user_password' => $data['Password'],
            'remember' => false
        ));
        return new WP_REST_Response( array('message' => 'OK'), 200);
    } else {
        return new WP_REST_Response( array('message' => 'Email already exists.',
                                            'email_exists' => email_exists($data['email'])), 200);
    }
    
    
    //create two partners pages for them (one draft one published) (will be passed in through $data)

    //reload page to help redirect
}