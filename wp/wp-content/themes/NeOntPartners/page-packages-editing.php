
<?php
    //pulling in header
    get_header();
    $userID = get_current_user_id();
?>
<main>
    <h2 class="package-header">Your Package</h2>
    <?php if(is_user_logged_in()){ ?>
        <!-- right Side-->
        <?php
        /**
         * edit this code so that it pulls in relevant information about the current post(package)
         * 
         * this can be done with a simple custom query. 
         * 
         * uploading can be done with js like in registrationForm.js
         */
            $packageQuery = new WP_Query(array(
                'post_type' => 'packages',
                'post__in' => array($_GET['id']),
                'posts_per_page' => 1,
                'author' => get_current_user_id(),
                'post_status' => array(
                    'pending',
                    'draft',
                    'future'
                )
            ));
        if($packageQuery->have_posts()){
            while($packageQuery->have_posts()){
                $packageQuery->the_post();
            
        ?>
        <section id="package-edit-form" class="profile-edit-form" data-postID="<?php echo $post->ID; ?>">
            <!-- <div class="container"> -->
            <h4 class="form-heading">Information</h4>
            <input id='package-name' class="form-element comp-name" type="textbox" placeholder="Package Name" value="<?php echo apply_filters('the_title', $post->post_title); ?>">
            <h4 class="form-headeing">description</h4>
            <textarea id='package-desc' class="form-element  desc" resize="false" placeholder="Description of the package"><?php echo apply_filters('the_content', $post->post_content); ?></textarea>
            <h4 class="form-heading">Start/End Date</h4>
            <div class="name form-split">
                <div class='half-split'>
                <?php $imgs = get_posts(array('post_type' => 'attachment', 'numberposts' => -1, 'post_parent' => $post->ID))?>
                <div id="drop-area" data-img='<?php echo count($imgs); ?>'>
                <form class="my-form" enctype='multipart/form-data'>
                    <div id='drop-area-content' <?php echo (count($imgs) <= 0) ? "" : "style='display: none'" ?>>
                        <p>Upload multiple files with the file dialog or by dragging and dropping images onto the dashed region</p>
                        
<!-- need to look at what events happen after a file has been chosen -->
<!-- name='fileElem' multiple accept="image/png, image/jpeg" -->
                        <input type="file" id="fileElem" name='fileElem' multiple accept="image/png, image/jpeg"/>
                        <input type='hidden' id="parent_id" value='<?php echo $post->ID; ?>'/>
                        <?php wp_nonce_field('fileElem', 'fileElem-nonce');?>
                        <label class="button" for="fileElem">Select some files</label>
                    </div>
                    <div id="loading-icon" style='display: none;'>Uploading...</div>
                    <div id="gallery">
                        <?php 
                        echo (count($imgs) <= 0) ? "<img style='display: none'>" : "" ;
                        foreach( $imgs as $img){
                            $thumbnail = wp_get_attachment_image($img->ID, 'thumbnail', true, array('data-id' => $img->ID));
                            echo $thumbnail;
                        }
                        ?>
                    </div>
                    
                    <button id='delete-img-btn' style='display: <?php echo $img > 0 ? "" : "none" ?>;'>Delete</button>
                </form>
            </div>
                </div>
                <div class='half-split'>
                    <input id="start" class="package-datepicker form-element start" type="textbox" placeholder="Start Date" value="<?php echo get_field('start_date', $post->ID); ?>">
                    <div class="name-space"></div>
                    <input id="end" class="package-datepicker form-element end" type="textbox" placeholder="End Date" value="<?php echo get_field('end_date', $post->ID); ?>">
                </div>
            </div>
            <button id="submit-package" class="form-element submit-btn">Submit</button>
            <!-- content of the form -->
        </section>
            <?php } wp_reset_postdata(); }else{
                echo "You do not have access to this page. Please contact NEONT";
            } 
    }else {?>
        <h2>Please Signin First</h2>
    <?php } ?>
<!-- Place hetml for form here-->
</main>

<?php
    get_footer();
?>
