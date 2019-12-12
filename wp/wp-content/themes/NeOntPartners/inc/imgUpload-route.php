<?php


add_action('rest_api_init', 'imgUpload');

function imgUpload(){
    register_rest_route('neont/v1', '/imgUpload', array(
        'methods' => "POST",
        "callback" => 'imageUpload'
    ));
}

function imageUpload($data){

    if(wp_verify_nonce($data['fileElem_nonce'], 'fileElem')
            && current_user_can('edit_post', $data['parent_id']))
    {
    //return new WP_REST_Response(array( current_user_can('edit_post', $data['parent_id']) ), 200);

        require_once( ABSPATH . 'wp-admin/includes/image.php');
        require_once( ABSPATH . 'wp-admin/includes/file.php');
        require_once( ABSPATH . 'wp-admin/includes/media.php');
        //require_once( ABSPATH . 'wp-admin/includes/class-admin.php');
        $attachement_id = media_handle_upload('file', 1);
        return new WP_REST_Response(array('message' => $attachement_id), 200);
        if(is_wp_error($attachement_id)){
            return new WP_REST_Response(array('message' => 'OK'), 200);
        } else {
            return new WP_REST_Response(array('message' => 'error'), 200);
        }
    }
}
