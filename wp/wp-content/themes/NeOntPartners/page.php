<?php
    //pulling in header
    get_header();
?>
<main>
<?php
    wp_login_form( array(
        'redirect' => home_url()
    ));

    if(have_posts()){
        while(have_posts()){
            the_post();
            the_content();
        
?>
</main>

<?php        
        }
    }
    get_footer();
?>