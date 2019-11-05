<?php
    //pulling in header
    get_header();
    $userID = get_current_user_id();
?>
<main>
    <h2 class="profile-header">Your Profile</h2>
    <?php if(is_user_logged_in()){ 
        $user_info = get_userdata($userID); ?>
    <div class="twoColumns" id="profile-container" data-id="<?php echo $userID; ?>">
        <!--left side-->


        <div class="packages">

        <h3 class="form-section">Partnership Information</h3>
        <label class="partnershipStatus">Status of Partnership</label>
        <button>Upgrade</button>

        <div class="addons">
            <div class="addon-elements">
                <label class="addon-title">Advertising packages</label>
                <label for="" class="addon-label">
                    <input type="checkbox" class="addon">
                    Platinum</label>
                <label for="" class="addon-label">
                    <input type="checkbox" class="addon">
                    Gold</label>
                <label for="" class="addon-label">
                    <input type="checkbox" class="addon">
                    Silver</label>
                <label for="" class="addon-label">
                    <input type="checkbox" class="addon">
                    Bronze</label>
            </div>
            
            <div class="addon-elements">
                <label for="" class="addon-title">Online Packages</label>
                <label for="" class="addon-label">
                    <input type="checkbox" class="addon">
                    E-newletter</label>
                <label for="" class="addon-label">
                    <input type="checkbox" class="addon">
                    Facebook: $250</label>
                <label for="" class="addon-label">
                    <input type="checkbox" class="addon">
                    Social Media</label>
                <label for="" class="addon-label">
                    <input type="checkbox" class="addon">
                    Website</label>
            </div>
        </div>
        <button>Purchase Addon</button>



            <h3>Packages</h3>
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
            <h3 class="form-section">Location Information</h3>
            
            <label class="form-header">Business Name:</label>
            <input id='comp-name' class="form-element" type="textbox" placeholder="Company Name" value="<?php echo apply_filters('the_title', $thePartner->post_title); ?>" data-char-cap="40">
            
            <label class="form-header">Business Description:</label>
            <textarea id='desc' class="form-element desc" resize="false" placeholder="Description of your company" data-char-cap="400"><?php echo apply_filters('the_content', $thePartner->post_content); ?></textarea>
            
            <label class="form-header">
                Website:
                <input type="text" class="form-element website" id="website" placeholder="Website">
            </label>
            
            <label class="form-header">
                Business Email:
                <input type="text" class="form-element b-email" id="business-email" placeholder="Business Email">
            </label>

            <!-- <h4 class="form-header">Business Address</h4> -->
            <label class="form-header">
                Business Street Address:
                <input type="text" class="form-element b-addr" id="business-addr" placeholder="Business Address">
            </label>
            <div class="form-split">
                <div class="half-split">
                    <label class="form-header">Business City</label>
                    <input type="text" class="form-element" id="b-city" placeholder="Business City">
                </div>
                <div class="center-split"></div>
                <div class="half-split">
                    <label class="form-header">Business Postal Code</label>
                    <input type="text" class="form-element" id="postal-code" placeholder="Postal Code">
                </div>
            </div>

            <div class="form-split">
                <div class="half-split">
                    <label class="form-header">Latitude</label>
                    <input type="text" class="form-element" id="lat" placeholder="Latitude">
                </div>
                <div class="center-split"></div>
                <div class="half-split">
                    <label class="form-header">Longitude</label>
                    <input type="text" class="form-element" id="lng" placeholder="Longitude">
                </div>
            </div>
            <label class="form-header">Business Phone number</label>
            <input class="phonenumber form-element" id="b-phonenumber" placeholder="Phone Number">
            
            <label class="form-header">Toll-Free Number</label>
            <input class="form-element tollfree" id="toll-free" placeholder="Toll-Free Phone Number">

            <!-- Billing information -->
            <h3 class="form-section">Billing Information</h3>
            <div class="form-split">
                <div class="half-split">
                    <label class="form-header">First Name</label>
                    <input id="first-name" class="form-element" type="textbox" placeholder="First Name" value="<?php echo $user_info->user_firstname; ?>">
                </div>
                <div class="center-split"></div>
                <div class="half-split">   
                    <label class="form-header">Last Name</label>
                    <input id="last-name" class="form-element last-name" type="textbox" placeholder="Last Name" value="<?php echo $user_info->user_lastname; ?>">
                </div>
            </div>
            <label class="form-header">Email</label>
            <input id="email" class="form-element email" type="textbox" placeholder="Email" value="<?php echo $user_info->user_email;?>">

            <label class="form-header">Secondary Contact</label>
            <div class="form-split">
                <div class="half-split">
                    <label class="form-header">First Name</label>
                    <input id="first-name" class="form-element" type="textbox" placeholder="First Name" value="">
                </div>
                <div class="center-split"></div>
                <div class="half-split">   
                    <label class="form-header">Last Name</label>
                    <input id="last-name" class="form-element last-name" type="textbox" placeholder="Last Name" value="">
                </div>
            </div>
            <label class="form-header">Email:</label>
            <input id="email--secondary" class="form-element email" type="textbox" placeholder="Email" value="">
            
            <h3 class="form-section">Head Office Information</h3>

            <label class="form-header"><input type="checkbox" > same as location information</label>


            <label class="form-header">
                Head Office Street Address
                <input type="text" class="form-element" placeholder='Street Address'>
            </label>
            <label class="form-header">
                City
                <input type="text" class="form-element" placeholder='City'>
            </label>
            <label class="form-header">
                Province/State
                <input type="text" class="form-element" placeholder='Province/State'>
            </label>
            <div class="form-split">
                <div class="half-split">
                    <label class="form-header">
                        Postal/Zip Code
                        <input type="text" class="form-element" placeholder='Postal/Zip Code'>
                    </label>
                </div>
                <div class="center-split"></div>
                <div class="half-split">
                    <label class="form-header">
                        phone number
                        <input class="form-element" placeholder='Phone Number'>
                    </label>
                </div>
            </div>

            <button id="Submit-Profile" class="form-element submit-btn">Submit</button>
            <!-- content of the form -->
        </section>
    </div>
    <?php wp_reset_postdata(); } else{?>
        <h2>Please Sign in First</h2>
    <?php } ?>
<!-- Place hetml for form here-->
</main>

<?php
    get_footer();
?>