<?php

//add_filter( 'woocommerce_is_rest_api_request', 'simulate_as_not_rest' );


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

    // set the WC() function to access the cart
    //import_WC();
    add_filter( 'woocommerce_is_rest_api_request', 'simulate_as_not_rest' );

    $product = wc_get_product($data['productID']);

    $isOrdered = isOrdered($data['productID']);

    $product_cart_id = WC()->cart->generate_cart_id( $data['productID']);
    $in_cart = WC()->cart->find_product_in_cart($product_cart_id) ? 'remove' : 'add';

    return new WP_REST_Response (array('message' => $in_cart,
                                       'productID' => $product->get_id(),
                                       'description' => $product->get_description(),
                                       'price' => $product->get_price(),
                                       'title' => $product->get_name(),
                                       'isOrdered' => $isOrdered,
                                       'action' => $isOrdered ? 'ordered' : $in_cart,
                                       'buttonTitle' => $isOrdered ? 'remove from cart' : 'add to cart'
                                ), 200);
}
