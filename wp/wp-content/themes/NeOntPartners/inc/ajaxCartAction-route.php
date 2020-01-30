<?php
add_action('rest_api_init', 'ajaxCartAction');

function ajaxCartAction(){
    register_rest_route('neont/v1', '/ajaxCartAction', array(
        'methods'   => 'POST',
        'callback'  => 'cartAction'
    ));
}

function cartAction($data){
    add_filter( 'woocommerce_is_rest_api_request', 'simulate_as_not_rest' );

    $message = 'test';
    $action;
    
    if($data['action'] == 'remove'){
        // TODO check if proper user
        //check current user who the cart belongs to
        $product_cart_id = WC()->cart->generate_cart_id($data['itemID']);
        $cart_item_key = WC()->cart->find_product_in_cart($product_cart_id);
        if ($cart_item_key){
            WC()->cart->remove_cart_item($cart_item_key);
            $message = 'product has been removed from cart';
            $action = 'add';
        } else {
            $message = 'error';
        }
    } else if ($data['action'] == 'add'){
        // TODO:
        // check if user already purchased certain item
        WC()->cart->add_to_cart($data['itemID']);
        $message = WC();
        $in_cart = false;
        $product_cart_id = WC()->cart->generate_cart_id($data['itemID']);
        $in_cart = WC()->cart->find_product_in_cart($product_cart_id);
        if( !$in_cart){
            if( !isOrdered($data['itemID'])){
                WC()->cart->add_to_cart();
                $message = 'product has been added to cart';
                $action = 'remove';
            } else {
                $message = 'item is already ordered';
                $action = 'ordered';
            }
        } else {
            $message = 'item is already in cart';
            $action = 'remove';
        }
    } else {
        return new WP_REST_Response( array( 'message' => 'error: remove/add keyword not specified',
                                            'cart' => count(WC()->cart->get_cart())), 200);
    }
    return new WP_REST_Response( array( 'message' => $message,
                                        'cart' => count(WC()->cart->get_cart()),
                                        'action' => $action), 200);
}
