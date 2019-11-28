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

    if(is_wp_error($user)){
        $message = $user->get_error_messages();
    }else if($user == null){
        $user = new WP_Error('invalid_email', "<strong>ERROR</strong>: That is not a valid email");
        $message = $user->get_error_messages();
    } else {
    //Do not need two lines below keeping them just in case
        // do_action('wp_login', $user->user_login, $user);
        // wp_set_current_user($user->ID);
        $message = "OK";
    }

    return new WP_REST_Response( array('message' => $message,
                                        "user" => $user->user_login), 200);
}