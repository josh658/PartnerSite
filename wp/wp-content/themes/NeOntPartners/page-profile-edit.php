<?php
    //pulling in header
    get_header();
    $userID = get_current_user_id();
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
$thePartner;
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
        $thePartner = get_post($draftPost);
    } else {
        $thePartner = create_custom_post('partners', get_current_user_id());
    }
} else if($PartnerQuery->have_posts()){
    $PartnerQuery->the_post(); 
    $thePartner = get_post($post->ID);
}
wp_reset_postdata()
?>

    <h2 class="profile-header">Your Profile</h2>
    <h3 id="profile-status" class="profile-header"><!--use JS to Dynamically change this --> </h3>
    <?php if(is_user_logged_in()){ 
        $user_info = get_userdata($userID); ?>
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
                <a href="<?php echo (home_url() . "/packages-editing?id=" . $thePackage[$i]->ID); /*the_permalink($thePackage[$i]);*/ ?>" class="package-thumnail">
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
            <form class="share-more-information-form">
                <h3 class="form-more-info-header">Accomodations</h3>
                <div class="row">
                    <?php 
                    //not pulling in all checkboxs
                        $accom = get_field('accomodations', $thePartner->ID);
                        if($accom){
                            foreach ($accom as $a){
                                if(true){
                    ?>
                    <div class="two-column">

                                <label class="form-checkbox"><input type="checkbox" name="accomodations" value="<?php echo $a; ?>"> <?php echo $a; ?> </label>

                        <!-- <label class="form-checkbox"><input type="checkbox" name="accomodations" value="B&B"> B&B </label>
                        <label class="form-checkbox"><input type="checkbox" name="accomodations" value="Cabins"> Cabins </label>
                        <label class="form-checkbox"><input type="checkbox" name="accomodations" value="Lodges"> Lodges </label>
                        <label class="form-checkbox"><input type="checkbox" name="accomodations" value="Hotel & Motel"> Hotel & Motel </label>
                        <label class="form-checkbox"><input type="checkbox" name="accomodations" value="Hostel"> Hostel </label>
                        <label class="form-checkbox"><input type="checkbox" name="accomodations" value="Open All Year"> Open All Year </label>
                        <label class="form-checkbox"><input type="checkbox" name="accomodations" value="Seasonal"> Seasonal </label>
                        <label class="form-checkbox"><input type="checkbox" name="accomodations" value="Free Parking"> Free Parking </label>
                        <label class="form-checkbox"><input type="checkbox" name="accomodations" value="Internet Access"> Internet Access </label>
                        <label class="form-checkbox"><input type="checkbox" name="accomodations" value="Restaurant"> Restaurant </label>
                        <label class="form-checkbox"><input type="checkbox" name="accomodations" value="Kitchen"> Kitchen </label>
                        <label class="form-checkbox"><input type="checkbox" name="accomodations" value="American Plan"> American Plan </label> -->
                    </div> 
                        <?php } else { ?>
                    <div class="two-column col-2">
                                <label class="form-checkbox"><input type="checkbox" name="accomodations" value="<?php echo $a; ?>"> <?php echo $a; ?> </label>
                        <!-- <label class="form-checkbox"><input type="checkbox" name="accomodations" value="Private Bath"> Private Bath </label>
                        <label class="form-checkbox"><input type="checkbox" name="accomodations" value="Laundry"> Laundry </label>
                        <label class="form-checkbox"><input type="checkbox" name="accomodations" value="Waterfront"> Waterfront </label>
                        <label class="form-checkbox"><input type="checkbox" name="accomodations" value="Spa/Pool"> Spa/Pool </label>
                        <label class="form-checkbox"><input type="checkbox" name="accomodations" value="Wheelchair Access"> Wheelchair Access </label>
                        <label class="form-checkbox"><input type="checkbox" name="accomodations" value="Shuttle Service"> Shuttle Service </label>
                        <label class="form-checkbox"><input type="checkbox" name="accomodations" value="Motorcyce Friendly"> Motorcyce Friendly </label>
                        <label class="form-checkbox"><input type="checkbox" name="accomodations" value="Snowmonile Fiendly"> Snowmonile Fiendly </label>
                        <label class="form-checkbox"><input type="checkbox" name="accomodations" value="Guided Tours"> Guided Tours </label>
                        <label class="form-checkbox"><input type="checkbox" name="accomodations" value="Fuel"> Fuel </label>
                        <label class="form-checkbox"><input type="checkbox" name="accomodations" value="Pets Welcome"> Pets Welcome </label> -->
                    </div>
                    <?php   }}} ?>
                </div>
                <h3 class="form-more-info-header">Camping & Rv Parks</h3>
                <div class="row">
                    <div class="two-column">
                        <label class="form-checkbox"><input type="checkbox" name="Parks" value="30 amp"> 30 amp</label>
                        <label class="form-checkbox"><input type="checkbox" name="Parks" value="50 amp"> 50 amp</label>
                        <label class="form-checkbox"><input type="checkbox" name="Parks" value="Full hook-up"> Full hook-up</label>
                        <label class="form-checkbox"><input type="checkbox" name="Parks" value="Boat Launch"> Boat Launch</label>
                        <label class="form-checkbox"><input type="checkbox" name="Parks" value="Boat Rentals"> Boat Rentals</label>
                        <label class="form-checkbox"><input type="checkbox" name="Parks" value="Pull-through sites"> Pull-through sites</label>
                    </div>    
                    <div class="two-column col-2">
                        <label class="form-checkbox"><input type="checkbox" name="Parks" value="Internet Access"> Internet Access</label>
                        <label class="form-checkbox"><input type="checkbox" name="Parks" value="Open year-round"> Open year-round</label>
                        <label class="form-checkbox"><input type="checkbox" name="Parks" value="Pets welcome"> Pets welcome</label>
                        <label class="form-checkbox"><input type="checkbox" name="Parks" value="Store"> Store</label>
                        <label class="form-checkbox"><input type="checkbox" name="Parks" value="Restaurant"> Restaurant</label>
                    </div>
                </div>
                <h3 class="form-more-info-header">Attractions, Activities & Services</h3>
                <div class="row">
                    <div class="two-column">
                        <label class="form-checkbox"><input type="checkbox" name="Attractions" value="Air Service"> Air Service</label>
                        <label class="form-checkbox"><input type="checkbox" name="Attractions" value="Art gallery"> Art gallery</label>
                        <label class="form-checkbox"><input type="checkbox" name="Attractions" value="Attraction"> Attraction</label>
                        <label class="form-checkbox"><input type="checkbox" name="Attractions" value="Aurora/Dark sky viewing"> Aurora/Dark sky viewing</label>
                        <label class="form-checkbox"><input type="checkbox" name="Attractions" value="Boat rental"> Boat rental</label>
                        <label class="form-checkbox"><input type="checkbox" name="Attractions" value="Bus/Motorcoach"> Bus/Motorcoach</label>
                        <label class="form-checkbox"><input type="checkbox" name="Attractions" value="Cruise & Ferries"> Cruise & Ferries</label>
                        <label class="form-checkbox"><input type="checkbox" name="Attractions" value="Cultural/Interpretive center"> Cultural/Interpretive center</label>
                        <label class="form-checkbox"><input type="checkbox" name="Attractions" value="Day trip"> Day trip</label>
                        <label class="form-checkbox"><input type="checkbox" name="Attractions" value="Dogsledding"> Dogsledding</label>
                        <label class="form-checkbox"><input type="checkbox" name="Attractions" value="Event"> Event</label>
                        <label class="form-checkbox"><input type="checkbox" name="Attractions" value="Festival"> Festival</label>
                        <label class="form-checkbox"><input type="checkbox" name="Attractions" value="Fishing"> Fishing</label>
                        <label class="form-checkbox"><input type="checkbox" name="Attractions" value="Ice-fishing"> Ice-fishing</label>
                        <label class="form-checkbox"><input type="checkbox" name="Attractions" value="Flightseeing"> Flightseeing</label>
                        <label class="form-checkbox"><input type="checkbox" name="Attractions" value="General Store"> General Store</label>
                        <label class="form-checkbox"><input type="checkbox" name="Attractions" value="Grocery store"> Grocery store</label>
                        <label class="form-checkbox"><input type="checkbox" name="Attractions" value="Golf"> Golf</label>
                        <label class="form-checkbox"><input type="checkbox" name="Attractions" value="Hiking"> Hiking</label>
                        <label class="form-checkbox"><input type="checkbox" name="Attractions" value="Guided Hiking"> Guided Hiking</label>
                    </div>    
                    <div class="two-column col-2">
                        <label class="form-checkbox"><input type="checkbox" name="Attractions" value="Hunting"> Hunting</label>
                        <label class="form-checkbox"><input type="checkbox" name="Attractions" value="Guided Hunting"> Guided Hunting</label>
                        <label class="form-checkbox"><input type="checkbox" name="Attractions" value="Paddling"> Paddling</label>
                        <label class="form-checkbox"><input type="checkbox" name="Attractions" value="Guided Paddling"> Guided Paddling</label>
                        <label class="form-checkbox"><input type="checkbox" name="Attractions" value="Rafting"> Rafting</label>
                        <label class="form-checkbox"><input type="checkbox" name="Attractions" value="Guided Rafting"> Guided Rafting</label>
                        <label class="form-checkbox"><input type="checkbox" name="Attractions" value="Mountain Biking"> Mountain Biking</label>
                        <label class="form-checkbox"><input type="checkbox" name="Attractions" value="Museum"> Museum</label>
                        <label class="form-checkbox"><input type="checkbox" name="Attractions" value="Rail"> Rail</label>
                        <label class="form-checkbox"><input type="checkbox" name="Attractions" value="Shopping"> Shopping</label>
                        <label class="form-checkbox"><input type="checkbox" name="Attractions" value="Skiing"> Skiing</label>
                        <label class="form-checkbox"><input type="checkbox" name="Attractions" value="Snowmobiling"> Snowmobiling</label>
                        <label class="form-checkbox"><input type="checkbox" name="Attractions" value="Vehicle rental"> Vehicle rental</label>
                        <label class="form-checkbox"><input type="checkbox" name="Attractions" value="Snowshoeing"> Snowshoeing</label>
                        <label class="form-checkbox"><input type="checkbox" name="Attractions" value="Wildlife viewing"> Wildlife viewing</label>
                        <label class="form-checkbox"><input type="checkbox" name="Attractions" value="Hunting"> Hunting</label>
                        <label class="form-checkbox"><input type="checkbox" name="Attractions" value="Bear"> Bear</label>
                        <label class="form-checkbox"><input type="checkbox" name="Attractions" value="Deer"> Deer</label>
                        <label class="form-checkbox"><input type="checkbox" name="Attractions" value="Moose"> Moose</label>
                        <label class="form-checkbox"><input type="checkbox" name="Attractions" value="Small Game"> Small Game</label>
                        <label class="form-checkbox"><input type="checkbox" name="Attractions" value="Waterfowl"> Waterfowl</label>
                    </div>
                </div>
            </form>
        </div>
        <!-- right Side-->

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