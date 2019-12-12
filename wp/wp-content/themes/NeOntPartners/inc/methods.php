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
 * @param Array $data the data you want to updated
 * @param String $status to be able to change the status of the post
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
 * class to update package posts. 
 * 
 * @param Int $postID the ID of the post you want to update
 * @param Array $data the data you want to updated
 * @param String $status to be able to change the status of the post
 * 
 */

 function update_package_post($postID, $data, $status = 'pending'){
  update_field('start_date', $data['startDate'], $data['postID']);
  update_field('end_date', $data['endDate'], $data['postID']);

  wp_update_post( array(
      'ID'    => $data['postID'],
      'post_title' => $data['title'],
      'post_content' => $data['content'],
      'post_status' => $data['status']
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

  //check if array is associative of sequencial
  if(array_keys($acfArr) !== range(0, count($acfArr) -1)){
    foreach ($acfArr as $key => $value){
      update_field($key, $value, $newPostID);
    }
  } else {
    foreach ($acfArr as $value){
      update_field($value, array(), $newPostID);
    }
  }


  return $newPostID;
}


/**
 * might be deprecated soon
 */
function upload_media($filePath, $filename){

  $upload_dir = wp_upload_dir( null, true, true );
  $file_type = mime_content_type( $filename['tmp_name']);


  if( $filename['error']){
    return new WP_Error(array('message' => $filename['error']));
  }

  if( $filename['size'] > wp_max_upload_size()){
    return new WP_Error(array('message' => "file size to large"));
  }

  if( !in_array($fine_mime, get_allowed_mime_types() )){
    return new WP_Error(array('message' => "this file type is not allowed"));
  }



  if(!$upload_file['error']){
    $wp_filetype = wp_check_filetype($filename, null);
    $attachment = array(
      'post_mime_type' => $wp_filetype['type'],
      'post_title' => preg_replace('/\.[^.]+$/', '', $filename),
      'post_content' => '',
      'post_status' => 'inherit'
    );
    $attachement_id = wp_insert_attachment($attachment, $upload_file['file']);
    if(!is_wp_error($attachment_id)){
      //require_once(ABSPATH . 'wp_admin' . '/includes/image.php');
      $attachment_data = wp_generate_attachemnt_metadata($attachment_id, $upload_file['file']);
      wp_update_attachment_metadata( $attachment_id, $attachment_data );
    }
  } else {
    // return an error
  }
  
}