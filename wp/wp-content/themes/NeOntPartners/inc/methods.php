<?php

function duplicate_post($postID){
    //copy post from ID
    $title   = get_the_title($postID);
    $oldpost = get_post($postID);
    $post    = array(
      'post_title' => $title,
      'post_status' => 'draft',
      'post_type' => $oldpost->post_type,
      'post_author' => $oldpost->post_author
    );
    $new_postID = wp_insert_post($post);
    // Copy post metadata
    $data = get_post_custom($postID);
    foreach ( $data as $key => $values) {
      foreach ($values as $value) {
        add_post_meta( $new_postID, $key, $value );
      }
    }
    return $new_postID;
}

//strip the tags off the UNUSED
// function strip_the_content($content){
//     return strip_tags($content);
// }
