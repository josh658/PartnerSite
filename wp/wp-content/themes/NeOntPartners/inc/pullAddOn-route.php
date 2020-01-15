<?php

/**
 * create a custom route for pulling in the information fo add ons
 * this will reduce the amount of content being pulled in at once potentially speeding up page loading.
 * Might need to convert
 * package post for this user.
 */

add_action('rest_api_init', 'pullAddOn');

function PullAddOn(){
    register_rest_route('neont/v1', '/addOnInfo', array(
        'methods'   => 'POST',
        'callback'  => 'addOnInfo'
    ));
}

function addOnInfo($data){


    $product = wc_get_product($data['productID']);


    // html output 
    $addToCartURL = $product->add_to_cart_url();

    return new WP_REST_Response (array('message' => "OK",
                                       //'productID' => $product->get_id(),
                                       'description' => $product->get_description(),
                                       'price' => $product->get_price(),
                                       'title' => $product->get_name(),
                                       'addToCartURL' => $addToCartURL 
                                ), 200);
}
