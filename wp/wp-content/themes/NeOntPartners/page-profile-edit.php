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

//echo 'Current PHP version: ' . phpversion();

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
        'post_status' => 'publish'
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

    <h2 class="profile-header">My Account</h2>
    <h2 class='pending-message' style='<?php echo ($thePartnerPost->post_status == 'pending') ? "" : 'display: none;'?>' data-status='<?php echo $thePartnerPost->post_status ?>'>
            Thank you for your submission we are currently reviweing your profile. 
            <button id='switch'>switch to draft</button>
    </h2> 
    <div id='autosave-loader' class="loader autosave-loader"></div>
    <label>Auto Save</label>
    <label class='auto-save-btn'>
        <input type="checkbox" id='auto-save-btn' class='checkbox-slider-btn' checked>
        <span class='slider-btn round-btn'></span>
    </label>
    <?php if(is_user_logged_in()){ 
        $user_info = get_userdata($userID);     
    ?>
    <div class="twoColumns" id="profile-container" data-id="<?php echo $userID; ?>">
        <!--left side-->


        <div class="update">

            <div class='update-card'>
                <h2>Current Package</h2>
                <label>Status:</label>
                <label>Advertising Plan:</label>
                <label>Plan Expires:</label>
                <label>Autorenewl:</label>
                <!-- line seperator -->
                <h2>Current Add-ons</h2>
                <!-- list of items -->
            </div>
        </div>
        <!-- right Side-->
        <div class='account'>

            <nav class="sub-nav">
                <ul class="sub-nav--list">
                    <li class="sub-nav--item subnav-selected" data-id='profile'>Profile</li>
                    <li>|</li>
                    <li class="sub-nav--item " data-id='gallery'>Gallery</li>
                    <li>|</li>
                    <li class="sub-nav--item " data-id='plans'>Plans</li>
                    <li>|</li>
                    <li class="sub-nav--item " data-id='advertising'>Advertising</li>
                    <li>|</li>
                    <li class="sub-nav--item " data-id='account-billing'>Account Billing</li>
                    <li>|</li>
                    <li class="sub-nav--item " data-id='additional-info'>Additional Info</li>
                </ul>
            </nav>
            
            <!-- PROFILE -->
            <section id='profile' class="account-card profile-edit-form" data-postID="<?php echo $thePartnerPost->ID; ?>">
                
                <label class="form-header">Business Name:</label>
                <!-- REQUIRED -->
                <input id='comp-name' class="required form-element" type="textbox" placeholder="Company Name" value="<?php echo apply_filters('the_title', $thePartnerPost->post_title); ?>" data-char-cap="40">
                
                <label class="form-header">
                    Business Email:
                    <input type="text" class="form-element b-email" id="business-email" placeholder="Business Email" placeholder="Website" value='<?php echo get_field('business_email', $thePartnerPost->ID); ?>'>
                </label>

                <!-- REQUIRED  -->
                <label class="form-header">Business Description:</label>
                <textarea id='desc' class="required form-element desc" resize="false" placeholder="Description of your company" data-char-cap="400" ><?php echo apply_filters('the_content', $thePartnerPost->post_content); ?></textarea>
                
                <label class="form-header">
                    Website:
                    <input type="text" class="form-element website" id="website" placeholder="Website" value='<?php echo get_field('website_url', $thePartnerPost->ID); ?>'>
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
                <!-- REQUIRED -->
                <label class="form-header">Business Phone number</label>
                <input class="phonenumber form-element" id="b-phonenumber" placeholder="Phone Number" placeholder="Website" value='<?php echo get_field('business_phone_number', $thePartnerPost->ID); ?>'>
                
                <label class="form-header">Toll-Free Number</label>
                <input class="form-element tollfree" id="toll-free" placeholder="Toll-Free Phone Number" placeholder="Website" value='<?php echo get_field('toll_free_nunber', $thePartnerPost->ID); ?>'>
                
                
                <!-- REQUIRED -->
                
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
                
                <div class="form-split">
                    <button id='save-profile-btn' class='form-element submit-btn'>Save</button>
                    <button id="submit-profile-btn" class="form-element submit-btn ">Submit</button>
                </div>
            </section>
                
                <!-- GALLERY -->
            <section id='gallery' class='account-card'>
                    <h3>Cover Image</h3>
                    <?php $imgs = get_posts(array('post_type' => 'attachment', 'numberposts' => -1, 'post_parent' => $thePartnerPost->ID))?>
                    <div id="drop-area" data-img='<?php echo count($imgs); ?>'>
                        <form class="my-form" enctype='multipart/form-data'>
                            <div id='drop-area-content' <?php echo (count($imgs) <= 0) ? "" : "style='display: none'" ?>>
                                <p>Upload multiple files with the file dialog or by dragging and dropping images onto the dashed region</p>
                                
        <!-- need to look at what events happen after a file has been chosen -->
        <!-- name='fileElem' multiple accept="image/png, image/jpeg" -->
                                <input type="file" id="fileElem" name='fileElem' multiple accept="image/png, image/jpeg"/>
                                <input type='hidden' id="parent_id" value='<?php echo $thePartnerPost->ID; ?>'/>
                                <?php wp_nonce_field('fileElem', 'fileElem-nonce');?>
                                <label class="button" for="fileElem">Select some files</label>
                            </div>
                            <div id="loading-icon" style='display: none;'>Uploading...</div>
                            <div id="gallery">
                                <?php 
                                echo (count($imgs) <= 0) ? "<img style='display: none'>" : "" ;
                                foreach( $imgs as $img){
                                    $thumbnail = wp_get_attachment_image($img->ID, 'thumbnail', true, array('data-id' => $img->ID));
                                    echo $thumbnail;
                                }
                                ?>
                            </div>
                            
                            <button id='delete-img-btn' style='display: <?php echo $img > 0 ? "" : "none" ?>;'>Delete</button>
                        </form>
                    </div>
                </section>
                
                <!-- PLANS -->
                <section id='plans' class='account-card'>
                    
                </section>
                    
                <!-- ADVERTISING -->
                <section id='advertising' class='account-card'>
                    <ul class="ad-nav--list">
                        <li class="ad-nav--item subnav-selected" data-id='package'>Packages</li>
                        <li class="ad-nav--item" data-id='digital'>Digital</li>
                        <li class="ad-nav--item" data-id='print'>Print</li>
                        <button class='cart-button'>Cart</button>
                    </ul>
                    <section id='package' class="ad-card">
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
                                $thePackage[get_field('package_order', $post->ID)] = $post;
                            }
                            if($packageQuery->found_posts() < 4){
                                wp_reset_postdata();
                                $publicPackageQuery = new WP_Query(array(
                                    'post_type' => 'packages',
                                    'posts_per_page' => -1,
                                    'author' => $userID,
                                    'post_status' => 'publish'
                                ));
                                for( $count = 1; $count <= 4; $count++){
                                    $doesExist = false;
                                    foreach( $thePackage as $value){
                                        if( $count == get_field('package_order', $value->ID)){
                                            //echo get_field('package_order', $value->ID);
                                            $doesExist = true;
                                            break;
                                        }
                                    }
                                    if(!$doesExist){
                                        while($publicPackageQuery->have_posts()){
                                            $publicPackageQuery->the_post();
                                            //duplicate_post returns the new post id 
                                            if($count == get_field('package_order', $post->ID)){
                                                $newPost = duplicate_post($post->ID);
                                                update_field('original_post_id', $post->ID, $newPost);
                                                $thePackage[$count] = get_post($newPost);
                                                //echo "publicTrue";
                                                $doesExist = true;
                                                break;
                                            }
                                        }
                                        if(!$doesExist){
                                            //echo "making new";
                                            $thePackage[$count] = get_post(create_custom_post('packages', $userID));
                                            update_field('package_order', $count, $thePackage[$count]->ID);
                                        }
                                    }
                                }
                            }
                            wp_reset_postdata();
                        ?> 
                        <ul> 
                        <?php
                            for($i = 1; $i <= 4; $i++){ 
                        ?>
                            <!-- when clicked this link will bring you to a page for package editing -->
                            <a href="<?php echo (home_url() . "/packages-editing?id=" . $thePackage[$i]->ID); ?>" class="package-thumnail">
                                <?php //check to see if there is a title
                                if(apply_filters('the_title', $thePackage[$i]->post_title) == ""){
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
                    </section>
                    <section id='digital' class="ad-card">
                        <ul class='addon-list'>
                        <?php 
                            //make custom query to loop through all items
                            $products = wc_get_products(array(
                               'category' => array('digital'),
                            ));
                            foreach($products as $product){
                                ?>
                                    <li class='add-on' data-productid='<?php echo esc_attr($product->get_id());?>'>
                                        <?php echo esc_attr($product->get_title());
                                        ?>
                                    </li>
                                <?php
                            }
                            

                            //do I want to load all information at once? or ajax style
                            //get cart content == WC()->cart->get_cart()
                        ?>
                        </ul>
                        <div id="digital-add-on-details">
                            <h3 id='digital-add-on-title'></h3>
                            <p id='digital-add-on-description'></p>
                            <button id='digital-add-to-cart' class='add-to-cart' data-id=''>add to cart</button>
                        </div>
                    </section>
                    <section id='print' class="ad-card">print advertising card</section>
                </section>
                        
                <!-- ACCOUNT BILLING -->
                <section id='account-billing' class='account-card'>
                    <!-- Billing information -->
                    <h3 class="form-section">Billing Information</h3>
                    <div class="form-split">
                        <div class="half-split">
                            <!-- REQUIRED -->
                            <label class="form-header">First Name</label>
                            <input id="first-name" class="form-element" type="textbox" placeholder="First Name" value="<?php echo $user_info->user_firstname; ?>">
                        </div>
                        <div class="center-split"></div>
                        <div class="half-split">   
                            <!-- REQUIRED  -->
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
                <label class="form-header">Business Email:</label>
                <input id="s-email" class="form-element email" type="textbox" placeholder="Email" placeholder="Website" value='<?php echo get_field('secondary_contact_email', $thePartnerPost->ID); ?>'>
                     
                </section>
                            
                <!-- ADDITION -->
                <section id='additional-info' class='account-card'>
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
                </section>
            <h2 class='pending-message' style='<?php echo ($thePartnerPost->post_status == 'pending') ? "" : 'display: none;'?>'>Thank you for your sumission we are currently reviweing your profile.</h2> 
        </div>
        <?php wp_reset_postdata(); } else{?>
            <h2>Please Sign in First</h2>
        <?php } ?>
    </div>
<!-- Place hetml for form here-->
</main>

<?php
    get_footer();
?>