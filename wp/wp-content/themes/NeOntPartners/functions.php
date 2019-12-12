<?php

//seperate files to keep things organized
require get_theme_file_path('/inc/register-route.php');
require get_theme_file_path('/inc/methods.php');
require get_theme_file_path('/inc/redirect.php');
require get_theme_file_path('/inc/profile-route.php');
require get_theme_file_path('/inc/login-route.php');
require get_theme_file_path('/inc/package-route.php');
require get_theme_file_path('/inc/imgUpload-route.php');

//for removing p tags when calling the_content
remove_filter ('the_content', 'wpautop'); 

//loading style and script files
function files(){
    wp_enqueue_style('main_styles', get_stylesheet_uri());
    wp_enqueue_script( 'main-js', get_theme_file_uri('/js/scripts-bundled.js'), NULL, '1.0', true );
    wp_localize_script('main-js', 'data', array(
        'nonce' => wp_create_nonce('wp_rest'),
        'root_url' => get_site_url()
    ));
}
add_action('wp_enqueue_scripts', 'files');


?>