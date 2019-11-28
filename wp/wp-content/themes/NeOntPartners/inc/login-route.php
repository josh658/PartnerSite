<?php


add_action('rest_api_init', 'login');

function login(){
    register_rest_route('neont/v1', '/login', array(
        'methods' => "POST",
        "callback" => 'loginAuthentication'
    ));
}

function loginAuthentication($data){
    $user = new WP_User();
    $user = wp_authenticate_email_password(null, $data['email'], $data['password']);
    // $user = new WP_Error();
    $message = "";
    if(filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
        if(is_wp_error($user)){
            $message = $user->get_error_messages();
        }else if($user == null){
            $message = "error: returns null";
        } else {
            //Do not need two lines below keeping them just in case
            // do_action('wp_login', $user->user_login, $user);
            // wp_set_current_user($user->ID);
            $message = "OK";
        }
    } else {
        $message = "OK";
    }
    return new WP_REST_Response( array('message' => $message,
                                        "user" => $user->user_login), 200);
}