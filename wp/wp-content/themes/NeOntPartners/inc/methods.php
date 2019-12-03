<?php

/**
 * Duplicate a post will keep all data from origial other than the status
 * it will be switched to draft
 * 
 * @param Int   $postID the id of the post to duplicate
 * @return Int  return the id of the newly duplicated
 */
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
    //make sure thatt original post id custom field has the correct value
    update_field('original_post_id', $postID, $new_postID);
    
    return $new_postID;
}

/**
 * used to update a profile post. makes sure that all the information we want updated is, in fact updated
 * 
 * @param Int $postID the ID of the post you want to update
 * @param Int $data the data you want to replace
 * 
 */
function update_profile_post($postID, $data, $status = 'pending'){
  foreach ($data['acfCheckbox'] as $key => $val){
      update_field($key, $val, $postID);
  }

  foreach ($data['acfString'] as $key => $val){
      update_field($key, $val, $postID);
  }

  //TODO: escape all this
  wp_update_post(array(
      'ID'    => $postID,
      'post_title' => $data['title'],
      'post_content' => $data['content'],
      'post_status' => $status
  ));

  wp_update_user(array(
      'ID' => $postID->post_author,
      'first_name' => $data['contactFirstName'],
      'last_name' => $data['contactLastName'],
      'user_email' => $data['contactEmail']
  ));
}

/**
 * creating a post post with status draft and current user as author
 * 
 * @param String  $type of custom post
 * @param Int     $userID
 * @param Array   $acfArr array of acf field that need to be initialized on load
 * @return Int    new ID of post
 */

//TODO: add post_parent to array 
function create_custom_post($type, $userID, $acfArr = array()){
  $newPostID = wp_insert_post(array(
    'post_title' => " ",
    'post_status' => 'draft',
    'post_author' => $userID,
    'post_type'   => $type
  ));

  foreach ($acfArr as $key => $value){
    update_field($key, $value, $newPostID);
  }


  return $newPostID;
}

