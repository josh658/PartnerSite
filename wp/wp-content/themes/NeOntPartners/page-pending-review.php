<?php
    //pulling in header
    get_header();
?>
<main>
    <h2>Pending Review</h2>
<?php

// custom query.  get all pending files

    $pendingQue = new WP_Query(array(
        'post_type' => array('packages', 'partners'),
        'post_status' => 'pending',
        'posts_per_page' => -1
    ));
        
    while($pendingQue->have_posts()){
        $pendingQue->the_post();
?>
    <div id='<?php echo $post->ID ?>' class='pending-card--small'>
        <h1><?php the_title() ?> </h1>
        <?php 
            // if it is a package write this template
        ?>
        <div>

        </div>
        <?php
            //if it is a partner write this template
        ?>

    </div>
<?php
    }
?>
</main>

<?php        

    get_footer();
?>