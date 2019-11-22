<?php
    //pulling in header
    get_header();
    $userID = get_current_user_id();

    /**
     * TODO:
     *  -sanitize all echoed data
     *  -
     */
?>
<main>
<?php

/**
 * check if there is already created partner profile for user
 * if not check if there is a live version
 * if so duplicate live post and make copy into pending
 * if no live (new user) create a profile post
 */
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
$thePartnerPost;
if(!$PartnerQuery->have_posts()){
    wp_reset_postdata();
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
        $thePartnerPost = get_post($draftPost);
    } else {
        $draftPost = create_custom_post('partners', get_current_user_id(), array(
            'accomodations',
            'camping',
            'attractions'
        ));
        $thePartnerPost = get_post($draftPost);
    }
} else if($PartnerQuery->have_posts()){
    $PartnerQuery->the_post(); 
    $thePartnerPost = get_post($post->ID);
}
wp_reset_postdata();
?>

    <h2 class="profile-header">Your Profile</h2>
    <h3 id="profile-status" class="profile-header"><!--use JS to Dynamically change this --> </h3>
    <?php if(is_user_logged_in()){ 
        $user_info = get_userdata($userID);     
    ?>
    <div class="twoColumns" id="profile-container" data-id="<?php echo $userID; ?>">
        <!--left side-->


        <div class="packages">

        <h3 class="form-section">Partnership Information</h3>
        <label class="partnershipStatus">Status of Partnership</label>
        <button class="upgrade-btn">Upgrade</button>

        <div class="addons">
            <div class="addon-elements">
                <label class="addon-title">Advertising packages</label>
                <label class="addon-label">
                    <input type="checkbox" class="addon" name="Advertising packages" value="Platinum">
                    Platinum</label>
                <label class="addon-label">
                    <input type="checkbox" class="addon">
                    Gold</label>
                <label class="addon-label">
                    <input type="checkbox" class="addon">
                    Silver</label>
                <label class="addon-label">
                    <input type="checkbox" class="addon">
                    Bronze</label>
            </div>
            
            <div class="addon-elements">
                <label class="addon-title">Online Packages</label>
                <label class="addon-label">
                    <input type="checkbox" class="addon">
                    E-newletter</label>
                <label class="addon-label">
                    <input type="checkbox" class="addon">
                    Facebook: $250</label>
                <label class="addon-label">
                    <input type="checkbox" class="addon">
                    Social Media</label>
                <label class="addon-label">
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
                if($packageQuery->found_posts() < 4){
                    $publicPackageQuery = new WP_Query(array(
                        'post_type' => 'packages',
                        'posts_per_page' => -1,
                        'author' => $userID,
                        'post_status' => 'public'
                    ));
                    for( $count = 1; $count <= 4; $count++){
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
                for($i = 1; $i <= 4; $i++){ ?>
            
                <!-- when clicked this link will bring you to a page for package editing -->
                <a href="<?php echo (home_url() . "/packages-editing?id=" . $thePackage[$i]->ID); ?>" class="package-thumnail">
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


            <?php } 
            // MARK : Pulling checkbox information
            ?>
            </ul>
            <!-- pull in information about addons -->
            <form id='more-info' class="share-more-information-form">
                <h3 class="form-more-info-header">Accomodations</h3>
                <div class="row">
                    <div class="two-column"><?php 
                        $count = 0;
                        $accomodations = get_field_object('accomodations', $thePartnerPost->ID);
                        $choices = $accomodations['choices'];
                        $checked = get_field('accomodations', $thePartnerPost->ID);
                        if($accomodations){
                            foreach ($choices as $value => $label){
                                $count++;
                                if($count == (int)(count($choices)/2)+1){
                                ?>
                                    </div>
                                    <div class="two-column col-2">
                                <?php
                                }
                                ?>
                        <label class="form-checkbox"><input type="checkbox" name="accomodations" value="<?php echo $label; ?>" <?php echo (in_array($value, $checked) ? 'checked' : '');?>> <?php echo $label; ?> </label>
                   
                    <?php  }} ?>
                    </div>
                </div>
                <h3 class="form-more-info-header">Camping & Rv Parks</h3>
                <div class="row">
                    <div class="two-column">
                    <?php 
                        $count = 0;
                        $camping = get_field_object('camping', $thePartnerPost->ID);
                        $choices = $camping['choices'];
                        $checked = get_field('camping', $thePartnerPost->ID);
                        if($camping){
                            foreach ($choices as $value => $label){
                                //truncate count($choices)/2 it is giving a decimal which causes an error!
                                
                                //echo $count;
                                //echo ((Int)count($choices)/2);
                                //echo (($count == count($choices)/2) ? "true" : "false");
                                $count++;
                                if($count == (int)(count($choices)/2)+1){
                                ?>
                                    </div>
                                    <div class="two-column col-2">
                                <?php
                                }
                                ?>
                        <label class="form-checkbox"><input type="checkbox" name="camping" value="<?php echo $label; ?>" <?php echo (in_array($value, $checked) ? 'checked' : '');?>> <?php echo $label; ?> </label>
                   
                    <?php  }} ?>
                    </div>
                </div>
                <h3 class="form-more-info-header">Attractions, Activities & Services</h3>
                <div class="row">
                    <div class="two-column">
                    <?php 
                        $count = 0;
                        $attractions = get_field_object('attractions', $thePartnerPost->ID);
                        $choices = $attractions['choices'];
                        $checked = get_field('attractions', $thePartnerPost->ID);
                        if($attractions){
                            foreach ($choices as $value => $label){
                                $count++;
                                if($count == (int)(count($choices)/2)+1){
                                ?>
                                    </div>
                                    <div class="two-column col-2">
                                <?php
                                }
                                ?>
                        <label class="form-checkbox"><input type="checkbox" name="attractions" value="<?php echo $label; ?>" <?php echo (in_array($value, $checked) ? 'checked' : '');?>> <?php echo $label; ?> </label>
                   
                    <?php  }} ?>
                    </div>
                </div>
            </form>
        </div>
        <!-- right Side-->

        <section id="profile-edit-form" class="profile-edit-form" data-postID="<?php echo $thePartnerPost->ID; ?>">
            <!-- <div class="container"> -->
            <h3 class="form-section">Location Information</h3>
            
            <label class="form-header">Business Name:</label>
            <input id='comp-name' class="form-element" type="textbox" placeholder="Company Name" value="<?php echo apply_filters('the_title', $thePartnerPost->post_title); ?>" data-char-cap="40">
            
            <label class="form-header">Business Description:</label>
            <textarea id='desc' class="form-element desc" resize="false" placeholder="Description of your company" data-char-cap="400"><?php echo apply_filters('the_content', $thePartnerPost->post_content); ?></textarea>
            
            <label class="form-header">
                Website:
                <input type="text" class="form-element website" id="website" placeholder="Website" value='<?php echo get_field('website_url', $thePartnerPost->ID); ?>'>
            </label>
            
            <label class="form-header">
                Business Email:
                <input type="text" class="form-element b-email" id="business-email" placeholder="Business Email" placeholder="Website" value='<?php echo get_field('business_email', $thePartnerPost->ID); ?>'>
            </label>

            <!-- <h4 class="form-header">Business Address</h4> -->
            <label class="form-header">
                Business Street Address:
                <input type="text" class="form-element b-addr" id="business-addr" placeholder="Business Address" placeholder="Street Address" value='<?php echo get_field('business_street_address', $thePartnerPost->ID); ?>'>
            </label>
            <div class="form-split">
                <div class="half-split">
                    <label class="form-header">Business City</label>
                    <input type="text" class="form-element" id="b-city" placeholder="Business City" placeholder="Website" value='<?php echo get_field('business_city', $thePartnerPost->ID); ?>'>
                </div>
                <div class="center-split"></div>
                <div class="half-split">
                    <label class="form-header">Business Postal Code</label>
                    <input type="text" class="form-element" id="b-postal-code" placeholder="Postal Code" placeholder="Website" value='<?php echo get_field('business_postal_code', $thePartnerPost->ID); ?>'>
                </div>
            </div>

            <button id="locate">user current position</button>

            <div class="form-split">
                <div class="half-split">
                    <label class="form-header">Latitude</label>
                    <input type="text" class="form-element" id="lat" placeholder="Latitude" placeholder="Website" value='<?php echo get_field('latitude', $thePartnerPost->ID); ?>'>
                </div>
                <div class="center-split"></div>
                <div class="half-split">
                    <label class="form-header">Longitude</label>
                    <input type="text" class="form-element" id="lng" placeholder="Longitude" placeholder="Website" value='<?php echo get_field('longitude', $thePartnerPost->ID); ?>'>
                </div>
            </div>
            <label class="form-header">Business Phone number</label>
            <input class="phonenumber form-element" id="b-phonenumber" placeholder="Phone Number" placeholder="Website" value='<?php echo get_field('business_phone_number', $thePartnerPost->ID); ?>'>
            
            <label class="form-header">Toll-Free Number</label>
            <input class="form-element tollfree" id="toll-free" placeholder="Toll-Free Phone Number" placeholder="Website" value='<?php echo get_field('toll_free_nunber', $thePartnerPost->ID); ?>'>

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
                    <input id="last-name" class="form-element" type="textbox" placeholder="Last Name" value="<?php echo $user_info->user_lastname; ?>">
                </div>
            </div>
            <label class="form-header">Email</label>
            <input id="email" class="form-element" type="textbox" placeholder="Email" value="<?php echo $user_info->user_email;?>">

            <label class="form-header">Secondary Contact</label>
            <div class="form-split">
                <div class="half-split">
                    <label class="form-header">First Name</label>
                    <input id="s-first-name" class="form-element" type="textbox" placeholder="First Name" placeholder="Website" value='<?php echo get_field('secondary_contact_firstname', $thePartnerPost->ID); ?>'>
                </div>
                <div class="center-split"></div>
                <div class="half-split">   
                    <label class="form-header">Last Name</label>
                    <input id="s-last-name" class="form-element last-name" type="textbox" placeholder="Last Name" placeholder="Website" value='<?php echo get_field('secondary_contact_lastname', $thePartnerPost->ID); ?>'>
                </div>
            </div>
            <label class="form-header">Email:</label>
            <input id="s-email" class="form-element email" type="textbox" placeholder="Email" placeholder="Website" value='<?php echo get_field('secondary_contact_email', $thePartnerPost->ID); ?>'>
            
            <h3 class="form-section">Head Office Information</h3>

            <!-- make sure you dynamically change the checked onption depending on the option the user chose
            this information must be stored in WP -->
            <label class="form-header"><input id='same-as-location' type="checkbox" checked> same as location information</label>

            <div id="same-as-location-content">
            <label class="form-header">
                Head Office Street Address
                <input id='head-addr' type="text" class="form-element" placeholder='Street Address' placeholder="Website" value='<?php echo get_field('head_office_street_address', $thePartnerPost->ID); ?>'>
            </label>
            <label class="form-header">
                City
                <input id='head-city' type="text" class="form-element" placeholder='City' placeholder="Website" value='<?php echo get_field('head_office_city', $thePartnerPost->ID); ?>'>
            </label>
            <label class="form-header">
                Province/State
                <input id='head-province' type="text" class="form-element" placeholder='Province/State' placeholder="Website" value='<?php echo get_field('head_office_provicestate', $thePartnerPost->ID); ?>'>
            </label>
            <div class="form-split">
                <div class="half-split">
                    <label class="form-header">
                        Postal/Zip Code
                        <input id='head-postal' type="text" class="form-element" placeholder='Postal/Zip Code' placeholder="Website" value='<?php echo get_field('head_office_postal_code', $thePartnerPost->ID); ?>'>
                    </label>
                </div>
                <div class="center-split"></div>
                <div class="half-split">
                    <label class="form-header">
                        phone number
                        <input id='head-phone' class="form-element" placeholder='Phone Number' placeholder="Website" value='<?php echo get_field('head_office_phone_number', $thePartnerPost->ID); ?>'>
                    </label>
                </div>
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