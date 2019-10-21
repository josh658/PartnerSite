<?php

add_action('rest_api_init', 'registerNewUser');

function registerNewUser(){
    register_rest_route('neont/v1', 'register', array(
        'methods' => 'POST',
        'callback' => 'evaluateForm'
    ));
}

function evaluateForm($data){
    
    $newID = wp_insert_user( array(
        'user_login' => $data['FirstName'], 
        'user_pass' => $data['Password'], 
        'user_email' => $data['email'],
        'first_name' => $data['FirstName'],
        'last_name' => $data['LastName'],
        'nickname' => $data['FirstName'] . $data['LastName'],
        'display_name' => $data['FirstName'] . " " . $data['LastName'],
        'role' => 'partnermember'

    ));
}