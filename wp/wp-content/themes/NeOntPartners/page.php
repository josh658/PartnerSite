<?php
    get_header();
    if(have_posts()){
        while(have_posts()){
            the_title();
            the_post();
            the_content();
        
?>


<?php        
        }
    }
    get_footer();
?>