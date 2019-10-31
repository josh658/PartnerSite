<?php
    //pulling in header
    get_header();
    $userID = get_current_user_id();
?>
<main>
    <h2 class="profile-header">Your Profile</h2>
    <?php if(is_user_logged_in()){ ?>
    <div class="twoColumns" id="profile-container" data-id="<?php echo $userID; ?>">
        <!--left side-->
        
        <div class="packages">
            <h4>Packages</h4>
            <?php //custome query for packages by this user
                $packageQuery = new WP_Query(array(
                    'post_type' => 'packages',
                    'posts_per_page' => -1,
                    'author' => $userID,
                    'post_status' => array(
                        'pending', 
                        'draft',
                        'future'
                    )
                ));
                $thePackage = array();
                while($packageQuery->have_posts()){
                    $packageQuery->the_post();
                    //echo $post->ID;
                    //echo get_field('package_id', $post->ID);
                    //error check to make sure that each package has an package_id between 1-6 if not...
                    //  move to the next item and set the number later
                    //  keep doing this till elements have been checked
                    //  retroactively give all packages unique elements
                    $thePackage[get_field('package_id', $post->ID)] = $post;
                }
                wp_reset_postdata();
                if($packageQuery->found_posts() < 6){
                    $publicPackageQuery = new WP_Query(array(
                        'post_type' => 'packages',
                        'posts_per_page' => -1,
                        'author' => $userID,
                        'post_status' => 'public'
                    ));
                    for( $count = 1; $count <= 6; $count++){
                        $doesExist = false;
                        foreach( $thePackage as $value){
                            if( $count == get_field('package_id', $value->ID)){
                                //echo get_field('package_id', $value->ID);
                                $doesExist = true;
                                break;
                            }
                        }
                        if(!$doesExist){
                            while($publicPackageQuery->have_posts()){
                                $publicPackageQuery->the_post();
                                if($count == get_field('package_id', $post->ID)){
                                    update_field('original_post_id', $post->ID, duplicate_post($post->ID));
                                    //echo "publicTrue";
                                    $doesExist = true;
                                    break;
                                }
                            }
                            if(!$doesExist){
                                //echo "making new";
                                $thePackage[$count] = get_post(create_custom_post('packages', $userID));
                                update_field('package_id', $count, $thePackage[$count]->ID);
                            }
                        }
                    }
                }
                wp_reset_postdata();
            ?> 
            <ul> 
            <?php
                for($i = 1; $i <= 6; $i++){ ?>
            
                <!-- when clicked this link will bring you to a page for package editing -->
                <a href="<?php the_permalink($thePackage[$i]); ?>" class="package-thumnail">
                    <?php //check to see if there is a title
                    if(apply_filters('the_title', $thePackage[$i]->post_title == "")){
                        ?>
                        <h2>Edit Me</h2>
                    <?php } else {?>
                    <h2><?php echo apply_filters('the_title', $thePackage[$i]->post_title);?></h2>
                    <div>
                        <p><?php echo apply_filters('the_content', $thePackage[$i]->post_content); ?></p>
                        <div>
                            <div><?php echo get_field('start_date', $thePackage[$i]->ID); ?></div>
                            <div><?php echo get_field('end_date', $thePackage[$i]->ID); ?></div>
                        </div>
                    </div>
                    <?php } ?>
                </a>


            <?php } ?>
            </ul>
            <!-- pull in information about packages -->
        </div>
        <!-- right Side-->
        <?php

            $PartnerQuery = new WP_Query(array(
                'post_type' => 'partners',
                'posts_per_page' => 1,
                'author' => $userID,
                'post_status' => array(
                    'pending', 
                    'draft',
                    'future'
                )
            ));
            $thePartner;
            if(!$PartnerQuery->have_posts()){
                $publicPartner = new WP_Query(array(
                    'post_type' => 'partners',
                    'posts_per_page' => 1,
                    'author' => $userID,
                    'post_status' => 'public'
                ));
                if($publicPartner->have_posts()){
                    $publicPartner->the_post();
                    //this function is in methods.php
                    $draftPost = duplicate_post($post->ID);
                    $thePartner = get_post($draftPost);
                }
            } else if($PartnerQuery->have_posts()){
                $PartnerQuery->the_post(); 
                $thePartner = get_post($post->ID);
            }
        ?>
        <section id="profile-edit-form" class="profile-edit-form" data-postID="<?php echo $thePartner->ID; ?>">
            <!-- <div class="container"> -->
            <h4 class="form-heading">Information</h4>
            <input id='comp-name' class="form-element comp-name" type="textbox" placeholder="Company Name" value="<?php echo apply_filters('the_title', $thePartner->post_title); ?>">
            <h4 class="form-headeing">description</h4>
            <textarea id='desc' class="form-element  desc" resize="false" placeholder="Description of your company"><?php echo apply_filters('the_content', $thePartner->post_content); ?></textarea>
            <h4 class="form-heading">contanct info</h4>
            <div class="name">
                <input id="first-name" class="form-element first-name" type="textbox" placeholder="First Name" value="<?php echo get_field('contact_firstname', $thePartner->ID); ?>">
                <div class="name-space"></div>
                <input id="last-name" class="form-element last-name" type="textbox" placeholder="Last Name" value="<?php echo get_field('contact_lastname', $thePartner->ID); ?>">
            </div>
            <input id="email" class="form-element email" type="textbox" placeholder="Email" value="<?php echo get_field('contact_email', $thePartner->ID);?>">
            <button id="Submit-Profile" class="form-element submit-btn">Submit</button>
            <!-- content of the form -->
        </section>
    </div>
    <?php wp_reset_postdata(); } else{?>
        <h2>Please Signin First</h2>
    <?php } ?>
<!-- Place hetml for form here-->
</main>

<?php
    get_footer();
?>