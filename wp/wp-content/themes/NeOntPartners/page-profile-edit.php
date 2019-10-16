<?php
    //pulling in header
    get_header();
?>
<main>
    <h2 class="profile-header">Your Profile</h2>
    <div class="twoColumns">
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
                'author' => get_current_user_id()
            ));
        
            while($PartnerQuery->have_posts()){
                $PartnerQuery->the_post(); 
        ?>
        <section class="profile-edit-form">
            <div class="container">
            <h4 class="heading">Information</h4>
            <input class="input comp-name" type="textbox" placeholder="Company Name" value="<?php esc_html(the_title()); ?>">
            <h4 class="headeing">description</h4>
            <textarea class="input desc" resize="false" placeholder="Description of your company"><?php echo strip_the_content(); ?></textarea>
            <h4 class="heading">contanct info</h4>
            <div class="name">
                <input class="input first-name" type="textbox" placeholder="First Name" value="<?php the_field('contact_firstname'); ?>">
                <input class="input last-name" type="textbox" placeholder="Last Name" value="<?php the_field('contact_lastname'); ?>">
            </div>
            <input class="input email" type="textbox" placeholder="Email" value="<?php the_field('contact_email');?>">
            <button>Submit</button>
            <!-- content of the form -->
            </section>
    <?php } wp_reset_postdata(); ?>
    </div>
<!-- Place hetml for form here-->
</main>

<?php      
    get_footer();
?>