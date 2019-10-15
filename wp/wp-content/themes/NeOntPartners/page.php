<?php
    //pulling in header
    get_header();
?>
<main>
<?php

    if(have_posts()){
        while(have_posts()){
            the_post();
            the_content();
        
?>

<!-- Place packages here -->
</main>

<?php        
        }
    }
    get_footer();
?>