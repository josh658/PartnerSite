<!-- For HomePage
    Login
    description
    partnership plans (cards)
-->

<?php
    //pulling in header
    get_header();
?>
<main>
<?php
    if(is_user_logged_in()){
        ?>
            <h2>Welcome back <?php echo esc_html(wp_get_current_user()->user_login);?> </h2>
        <?php
    }else{
        wp_login_form( array(
            'redirect' => home_url()
        ));
    }

    if(have_posts()){
        while(have_posts()){
            the_post();
            the_content();
        
?>

<!-- Place package cards here -->
</main>

<?php        
        }
    }
    get_footer();
?>