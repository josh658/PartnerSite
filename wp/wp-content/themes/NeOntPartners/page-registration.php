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
    <label>Password:</label>
    <input id="password" class="form-element" type="password" placeholder="Password">
    <label>Email:</label>
    <input id="email" class="form-element" type="email" placeholder="Email">
    <div class="row">
        <?php 
            $SubscriptionQuery = new WP_Query(array(
                'post_type' => 'subscription',
                'posts_per_page' => 3,
                // 'meta_key' => 'isAddon',
                // 'meta_value' => 'no'
            ));
            while($SubscriptionQuery->have_posts()){
                $SubscriptionQuery->the_post();
        ?>
        <div class="three-column card-subscription">
            <?php if(get_field('order', $post->ID) == 1){?>
                <h2><?php the_title(); ?></h2>
                <p><?php the_content(); ?></p>
                <p><?php echo get_field('price', $post->ID);?> </p>
            <?php } ?>
        </div>
        <div class="three-column card-subscription">
        <?php if(get_field('order', $post->ID) == 2){?>
                <h2><?php the_title(); ?></h2>
                <p><?php the_content(); ?></p>
                <p><?php echo get_field('price', $post->ID);?> </p>
            <?php } ?>    
        </div>
        <div class="three-column card-subscription">
        <?php if(get_field('order', $post->ID) == 3){?>
                <h2><?php the_title(); ?></h2>
                <p><?php the_content(); ?></p>
                <p><?php echo get_field('price', $post->ID);?> </p>
            <?php } ?>    
        </div>

    <?php } 
    wp_rest_query();
    ?>

    </div>
    <input type="submit" value="register" name="register" id="register-btn">
</form>

<!-- add registration react app here -->
</main>

<?php        
    get_footer();
?>