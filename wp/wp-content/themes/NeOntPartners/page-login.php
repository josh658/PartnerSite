<?php
    //pulling in header
    get_header();
?>
<main>
<?php
    //content for login
    //need some styling
    if(is_user_logged_in()){
        ?>
            <h2>Welcome back<?php echo wp_get_current_user()->user_login;?> </h2>
        <?php
    }else{
        wp_login_form( array(
            'redirect' => home_url()
        ));
    }

    //content from the page **editable from the wordpress admin side**
    if(have_posts()){
        while(have_posts()){
            the_post();
            the_content();
?>
    <!-- add a react app here for people who wnat to sign up -->
</main>

<?php        
        }
    }
    get_footer();
?>