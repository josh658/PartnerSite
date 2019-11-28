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
        //insert form
        ?>
        <form id='login-form' class='sign-in-form-card' method='post' action=<?php echo esc_url(site_url('wp-login.php', 'login_post'));?>>
            <p>Sign In to Northeastern Ontario Tourism Partners</p>
            <input id='login-email' name='log' placeholder='Email Address'>
            <input id='login-password' type='password' name="pwd" placeholder='password'>
            <button id='login-btn'>Log In</button>
            <p>not a partner? <a>sign in</a></p>
        </form>
        <?php
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