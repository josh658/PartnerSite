<?php
    //pulling in header
    get_header();
    $userID = get_current_user_id();
?>
<main>
    <h2 class="profile-header">Your Profile</h2>
    <?php if(is_user_logged_in()){ ?>
        </div>
        <!-- right Side-->
        <?php
        /**
         * edit this code so that it pulls in relevant information about the current post(package)
         * 
         * this can be done with a simple custom query. 
         * 
         * uploading can be done with js like in registrationForm.js
         */

            $PartnerQuery = new WP_Query(array(
                'post_type' => 'partners',
                'posts_per_page' => 1,
                'author' => $userID,
                'post_status' => array(
                    'pending', 
                    'draft',
                    'future'
                )
            ));
            $thePartner;
            if(!$PartnerQuery->have_posts()){
                $publicPartner = new WP_Query(array(
                    'post_type' => 'partners',
                    'posts_per_page' => 1,
                    'author' => $userID,
                    'post_status' => 'public'
                ));
                if($publicPartner->have_posts()){
                    $publicPartner->the_post();
                    //this function is in methods.php
                    $draftPost = duplicate_post($post->ID);
                    $thePartner = get_post($draftPost);
                }
            } else if($PartnerQuery->have_posts()){
                $PartnerQuery->the_post(); 
                $thePartner = get_post($post->ID);
            }
        ?>
        <section id="profile-edit-form" class="profile-edit-form" data-postID="<?php echo $thePartner->ID; ?>">
            <!-- <div class="container"> -->
            <h4 class="form-heading">Information</h4>
            <input id='comp-name' class="form-element comp-name" type="textbox" placeholder="Company Name" value="<?php echo apply_filters('the_title', $thePartner->post_title); ?>">
            <h4 class="form-headeing">description</h4>
            <textarea id='desc' class="form-element  desc" resize="false" placeholder="Description of your company"><?php echo apply_filters('the_content', $thePartner->post_content); ?></textarea>
            <h4 class="form-heading">contanct info</h4>
            <div class="name">
                <input id="first-name" class="form-element first-name" type="textbox" placeholder="First Name" value="<?php echo get_field('contact_firstname', $thePartner->ID); ?>">
                <div class="name-space"></div>
                <input id="last-name" class="form-element last-name" type="textbox" placeholder="Last Name" value="<?php echo get_field('contact_lastname', $thePartner->ID); ?>">
            </div>
            <input id="email" class="form-element email" type="textbox" placeholder="Email" value="<?php echo get_field('contact_email', $thePartner->ID);?>">
            <button id="Submit-Profile" class="form-element submit-btn">Submit</button>
            <!-- content of the form -->
        </section>
    <?php wp_reset_postdata(); } else{?>
        <h2>Please Signin First</h2>
    <?php } ?>
<!-- Place hetml for form here-->
</main>

<?php
    get_footer();
?>