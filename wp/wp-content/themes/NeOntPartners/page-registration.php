<?php
    //pulling in header
    get_header();
?>
<main>
<?php
    
?>
<h2 id="error-message"></h2>
<form id="register-form" class="register-form">
    <label>First Name:</label>
    <input id="first-name" class="form-element" placeholder="First Name" >
    <label>Last Name:</label>
    <input id="last-name" class="form-element" placeholder="Last Name">
    <div class='password-error-message'></div>
    <label>Password:</label>
    <input id="password" class="form-element" type="password" placeholder="Password">
    <div class="email-error-message"></div>
    <label>Email:</label>
    <input id="email" class="form-element" type="email" placeholder="Email">
    <div class="card-row">
        <?php 
            $SubscriptionQuery = new WP_Query(array(
                'post_type' => 'subscriptions',
                'posts_per_page' => -1,
                'post_status' => 'private',
                //querying is_addon custom field to only accept
                'meta_key' => 'is_addon',
                'meta_value' => 'no'
            ));
            while($SubscriptionQuery->have_posts()){
                $SubscriptionQuery->the_post();
                if (get_field('static_name', $post->ID) == 'Free' ||
                    get_field('static_name', $post->ID) == 'Standard' ||
                    get_field('static_name', $post->ID) == 'Premium'){
        ?>
        <div    data-subID="<?php echo get_field('price', $post->ID)?>"
                class="card-subscription
                    <?php echo (get_field('order', $post->ID) == 1 ? "card-selected" : ""); ?>"
                style="order: <?php echo get_field('order', $post->ID); ?>;">
                <h2><?php the_title(); ?></h2>
                <p><?php the_content(); ?></p>
                <h5><?php echo get_field('display_price', $post->ID); ?> </h5>
                <button class="card-sub-select">Select</button>
        </div>
            <?php } }
            wp_reset_query();
            ?>

    </div>
    <button id="register-btn" class="btn">Register</button>
</form>
</main>

<?php        
    get_footer();
?>