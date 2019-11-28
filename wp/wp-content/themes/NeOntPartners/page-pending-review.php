<?php
    //pulling in header
    get_header();
?>
<main>
    <h2>Test Email</h2>
<?php

    $mailResult = false;
    $mailResult = wp_mail('josh@northeasternontario.com', 'test if mail workds', 'hurray');
    if( $mailResult){
        echo "good";
    } else {
        echo "Bad";
    }
        
?>

<!-- Place package cards here -->
</main>

<?php        

    get_footer();
?>