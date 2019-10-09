<?php

function files(){
    wp_enqueue_style('main_styles', get_stylesheet_uri());
    wp_enqueue_script( 'main-js', get_theme_file_uri('/js/scripts-bundled.js'), NULL, '1.0', true );
}

add_action('wp_enqueue_scripts', 'files');


?>