<?php
    //pulling in header
    get_header();
    $userID = get_current_user_id();
?>
<main>
    <h2 class="profile-header">Your Profile</h2>
    <div class="twoColumns" id="profile-container" data-id="<?php echo $userID; ?>">
        <!--left side-->
        
        <div class="packages">
            <h4>Packages</h4>
            <?php //custome query for packages by this user
            ?>
            <ul>
            
            </ul>
            <!-- pull in information about packages -->
        </div>
        <!-- right Side-->
        <?php
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

        if(is_user_logged_in()){
            $thePost;
            if(!$PartnerQuery->have_posts()){
                $publicPartner = new WP_Query(array(
                    'post_type' => 'partners',
                    'posts_per_page' => 1,
                    'author' => $userID,
                    'post_status' => array('public')
                ));
                if($publicPartner->have_posts()){
                    $publicPartner->the_post();
                    $draftPost = duplicate_post($post->ID);
                    $thePost = get_post($draftPost);
                }
            } else if($PartnerQuery->have_posts()){
                $PartnerQuery->the_post(); 
                $thePost = get_post($post->ID);
            }
        ?>
        <section id="profile-edit-form" class="profile-edit-form" data-postID="<?php echo $thePost->ID; ?>">
            <div class="container">
            <h4 class="heading">Information</h4>
            <input id='comp-name' class="input comp-name" type="textbox" placeholder="Company Name" value="<?php echo apply_filters('the_title', $thePost->post_title); ?>">
            <h4 class="headeing">description</h4>
            <textarea id='desc' class="input desc" resize="false" placeholder="Description of your company"><?php echo apply_filters('the_content', $thePost->post_content); ?></textarea>
            <h4 class="heading">contanct info</h4>
            <div class="name">
                <input id="first-name" class="input first-name" type="textbox" placeholder="First Name" value="<?php get_field('contact_firstname', $thePost->ID); ?>">
                <input id="last-name" class="input last-name" type="textbox" placeholder="Last Name" value="<?php get_field('contact_lastname', $thePost->ID); ?>">
            </div>
            <input id="email" class="input email" type="textbox" placeholder="Email" value="<?php get_field('contact_email', $thePost->ID);?>">
            <button id="Submit-Profile">Submit</button>
            <!-- content of the form -->
        </section>
    <?php wp_reset_postdata(); } else{?>
        <h2>Please Signin First</h2>
    <?php } ?>
    </div>
<!-- Place hetml for form here-->
</main>

<?php
    get_footer();
?>