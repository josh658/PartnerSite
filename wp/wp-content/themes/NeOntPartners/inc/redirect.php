<?php

// Redirect non admin users to front page.
//used in redirect_login_page() functions
function redirect_admin(){
    $user = wp_get_current_user();
    $userNotAdmin = true;

    foreach ($user->roles as $role){
        if($role == 'administrator'){
            $userNotAdmin = false;
        }
    }

    if($userNotAdmin){
        wp_redirect( home_url('/') );
        exit;
    }
}

/* Main refirection of the default login page */
function redirect_login_page(){
    $login_page = home_url('/');
    $page_viewed = basename($_SERVER['REQUEST_URI']);

    if($page_viewed == "wp-login.php" && $_SERVER['REQUEST_METHOD'] == 'GET'){
        wp_redirect($login_page);
        exit;
    }

    if($page_viewed == "wp-admin"){
        redirect_admin();
    }
}
add_action('init', 'redirect_login_page');

/** where to go if a login fialed */
function custom_login_failed(){
    $login_page = home_url('/');
    wp_redirect( $login_page . '?login=failed' );
    exit;
}
add_action('wp_login_failed', 'custom_login_failed');

/** Where to go if any fields were empty */
function verify_user_pass($user, $username, $password){
    $login_page = home_url('/');
    if($username == "" || $password == ""){
        wp_redirect( $login_page . "?login=empty" );
        exit;
    }
}
add_filter('authenticate', 'verify_user_pass', 1, 3);

/** what to do on logout */
function logout_redirect(){
    $login_page = home_url('/');
    wp_redirect( $login_page . "?login=false");
    exit;
}
add_action('wp_logout', 'logout_redirect');

//redirect already registered used to home page
function register_redirect(){
    $home_page = home_url('/');
    $page_viewed = basename($_SERVER['REQUEST_URI']);

    if($page_viewed == "registration" && get_current_user_id()){
        wp_redirect($home_page);
        exit;
    }
}
add_action('init', 'register_redirect');