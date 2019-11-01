<?php

//seperate files to keep things organized
require get_theme_file_path('/inc/register-route.php');
require get_theme_file_path('/inc/methods.php');
require get_theme_file_path('/inc/redirect.php');


//for removing p tags when calling the_content
remove_filter ('the_content', 'wpautop'); 

//loading style and script files
function files(){
    wp_enqueue_style('main_styles', get_stylesheet_uri());
    wp_enqueue_script( 'main-js', get_theme_file_uri('/js/scripts-bundled.js'), NULL, '1.0', true );
    wp_localize_script('main-js', 'data', array(
        'nonce' => wp_create_nonce('wp_rest'),
        'root_url' => get_site_url(),
        "userId" => get_current_user_id()
    ));
}
add_action('wp_enqueue_scripts', 'files');

//customizing the rest api
function custom_rest(){
    //Post type profile
    register_rest_field('partners', 'authorName', array(
        'get_callback' => function() {return get_the_author();}
    ));
    register_rest_field( 'partners', 'contactFirstName', array(
        'get_callback' => function() {
            return get_field('contact_firstname');
        },
        'update_callback' => function($value, $obj) {
            //echo &obj->ID ***debugging to consol***
            update_field('contact_firstname', $value, $obj->ID);
            return true;
        }
    ));
    register_rest_field( 'partners', 'contactLastName', array(
        'get_callback' => function() {return get_field('contact_lastname');},
        'update_callback' => function($value, $obj) {
            update_field('contact_lastname', $value, $obj->ID);
            return true;
        }
    ));
    register_rest_field( 'partners', 'contactEmail', array(
        'get_callback' => function() {return get_field('contact_email');},
        'update_callback' => function($value, $obj) {
            update_field('contact_email', $value, $obj->ID);
            return true;
        }
    ));

    //post type package
    register_rest_field('packages', 'authorName', array(
        'get_callback' => function() {return get_the_author();}
    ));
    register_rest_field('packages', 'startDate', array(
        'get_callback' => function() {return get_field('start_date');},
        'update_callback' => function($value, $obj){
            update_field('start_date', $value, $obj->ID);
            return true;
        }
    ));
    register_rest_field('packages', 'endDate', array(
        'get_callback' => function() {return get_field('end_date');},
        'update_callback' => function($value, $obj){
            update_field('end_date', $value, $obj->ID);
            return true;
        }
    ));
}
add_action('rest_api_init', 'custom_rest');

?>