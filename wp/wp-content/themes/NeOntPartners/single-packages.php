
<?php
    //pulling in header
    get_header();
    $userID = get_current_user_id();
?>
<main>
    <h2 class="profile-header">Your Package</h2>
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

            while(have_posts()){
                the_post();
            
        ?>
        <section id="profile-edit-form" class="profile-edit-form" data-postID="<?php echo $post->ID; ?>">
            <!-- <div class="container"> -->
            <h4 class="form-heading">Information</h4>
            <input id='comp-name' class="form-element comp-name" type="textbox" placeholder="Company Name" value="<?php echo apply_filters('the_title', $post->post_title); ?>">
            <h4 class="form-headeing">description</h4>
            <textarea id='desc' class="form-element  desc" resize="false" placeholder="Description of your company"><?php echo apply_filters('the_content', $post->post_content); ?></textarea>
            <h4 class="form-heading">Start/End Date</h4>
            <div class="name">
                <input id="package-datepicker" class="form-element start" type="textbox" placeholder="Start Date" value="<?php echo get_field('start_date', $post->ID); ?>">
                <div class="name-space"></div>
                <input id="package-datepicker" class="form-element end" type="textbox" placeholder="End Date" value="<?php echo get_field('end_date', $post->ID); ?>">
            </div>
            <button id="Submit-Profile" class="form-element submit-btn">Submit</button>
            <!-- content of the form -->
        </section>
            <?php } wp_reset_postdata(); } else {?>
        <h2>Please Signin First</h2>
    <?php } ?>
<!-- Place hetml for form here-->
</main>

<?php
    get_footer();
?>
