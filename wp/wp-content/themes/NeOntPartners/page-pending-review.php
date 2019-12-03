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
        $i = 0;
    while($pendingQue->have_posts()){
        $pendingQue->the_post();
?>
    <div id='<?php echo $post->ID ?>' class='pending-card--small'>
        <h1><?php the_title() ?> </h1>
        <?php 
            // if it is a package write this template
            if ($post->post_type == 'partners'){ 
        ?>

            <!-- html template for any partners -->
            <div class="twoColumns isHidden" id="profile-container" data-post-type='partners'>
                <button id='edit-top' class='edit-btn'>Edit</button>
                <button id='publish-top' class='publish-btn'>Publish</button>
                <div id='more-info' class="share-more-indivation-form">
                    <h3 class="form-more-info-header">Accomodations</h3>
                    <div class="row">
                        <div class="two-column"><?php 
                            $count = 0;
                            $accomodations = get_field_object('accomodations', $post->ID);
                            $choices = $accomodations['choices'];
                            $checked = get_field('accomodations', $post->ID);
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
                            $camping = get_field_object('camping', $post->ID);
                            $choices = $camping['choices'];
                            $checked = get_field('camping', $post->ID);
                            if($camping){
                                foreach ($choices as $value => $label){

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
                            $attractions = get_field_object('attractions', $post->ID);
                            $choices = $attractions['choices'];
                            $checked = get_field('attractions', $post->ID);
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
                </div>
                <!-- right Side-->

                <div id="profile-edit-form" class="profile-edit-form" data-postID="<?php echo $post->ID; ?>">
                    <!-- <div class="container"> -->
                    <h3 class="form-section">Location Information</h3>
                    
                    <label class="form-header">Business Name:</label>
                    <input id='comp-name' class="form-element" type="textbox" placeholder="Company Name" value="<?php echo apply_filters('the_title', $post->post_title); ?>" data-char-cap="40">
                    
                    <label class="form-header">Business Description:</label>
                    <textarea id='desc' class="form-element desc" resize="false" placeholder="Description of your company" data-char-cap="400"><?php echo apply_filters('the_content', $post->post_content); ?></textarea>
                    
                    <label class="form-header">
                        Website:
                        <input type="text" class="form-element website" id="website" placeholder="Website" value='<?php echo get_field('website_url', $post->ID); ?>'>
                    </label>
                    
                    <label class="form-header">
                        Business Email:
                        <input type="text" class="form-element b-email" id="business-email" placeholder="Business Email" placeholder="Website" value='<?php echo get_field('business_email', $post->ID); ?>'>
                    </label>

                    <!-- <h4 class="form-header">Business Address</h4> -->
                    <label class="form-header">
                        Business Street Address:
                        <input type="text" class="form-element b-addr" id="business-addr" placeholder="Business Address" placeholder="Street Address" value='<?php echo get_field('business_street_address', $post->ID); ?>'>
                    </label>
                    <div class="form-split">
                        <div class="half-split">
                            <label class="form-header">Business City</label>
                            <input type="text" class="form-element" id="b-city" placeholder="Business City" placeholder="Website" value='<?php echo get_field('business_city', $post->ID); ?>'>
                        </div>
                        <div class="center-split"></div>
                        <div class="half-split">
                            <label class="form-header">Business Postal Code</label>
                            <input type="text" class="form-element" id="b-postal-code" placeholder="Postal Code" placeholder="Website" value='<?php echo get_field('business_postal_code', $post->ID); ?>'>
                        </div>
                    </div>

                    <button id="locate">user current position</button>

                    <div class="form-split">
                        <div class="half-split">
                            <label class="form-header">Latitude</label>
                            <input type="text" class="form-element" id="lat" placeholder="Latitude" placeholder="Website" value='<?php echo get_field('latitude', $post->ID); ?>'>
                        </div>
                        <div class="center-split"></div>
                        <div class="half-split">
                            <label class="form-header">Longitude</label>
                            <input type="text" class="form-element" id="lng" placeholder="Longitude" placeholder="Website" value='<?php echo get_field('longitude', $post->ID); ?>'>
                        </div>
                    </div>
                    <label class="form-header">Business Phone number</label>
                    <input class="phonenumber form-element" id="b-phonenumber" placeholder="Phone Number" placeholder="Website" value='<?php echo get_field('business_phone_number', $post->ID); ?>'>
                    
                    <label class="form-header">Toll-Free Number</label>
                    <input class="form-element tollfree" id="toll-free" placeholder="Toll-Free Phone Number" placeholder="Website" value='<?php echo get_field('toll_free_nunber', $post->ID); ?>'>

                    <!-- Billing information -->
                    <h3 class="form-section">Billing Information</h3>
                    <div class="form-split">
                        <?php  $user_info = get_userdata($post->post_author);?>
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
                            <input id="s-first-name" class="form-element" type="textbox" placeholder="First Name" placeholder="Website" value='<?php echo get_field('secondary_contact_firstname', $post->ID); ?>'>
                        </div>
                        <div class="center-split"></div>
                        <div class="half-split">   
                            <label class="form-header">Last Name</label>
                            <input id="s-last-name" class="form-element last-name" type="textbox" placeholder="Last Name" placeholder="Website" value='<?php echo get_field('secondary_contact_lastname', $post->ID); ?>'>
                        </div>
                    </div>
                    <label class="form-header">Email:</label>
                    <input id="s-email" class="form-element email" type="textbox" placeholder="Email" placeholder="Website" value='<?php echo get_field('secondary_contact_email', $post->ID); ?>'>
                    
                    <h3 class="form-section">Head Office Information</h3>

                    <!-- make sure you dynamically change the checked onption depending on the option the user chose
                    this information must be stored in WP -->
                    <label class="form-header"><input id='same-as-location' type="checkbox" checked> same as location information</label>

                    <div id="same-as-location-content">
                        <label class="form-header">
                            Head Office Street Address
                            <input id='head-addr' type="text" class="form-element" placeholder='Street Address' placeholder="Website" value='<?php echo get_field('head_office_street_address', $post->ID); ?>'>
                        </label>
                        <label class="form-header">
                            City
                            <input id='head-city' type="text" class="form-element" placeholder='City' placeholder="Website" value='<?php echo get_field('head_office_city', $post->ID); ?>'>
                        </label>
                        <label class="form-header">
                            Province/State
                            <input id='head-province' type="text" class="form-element" placeholder='Province/State' placeholder="Website" value='<?php echo get_field('head_office_provicestate', $post->ID); ?>'>
                        </label>
                        <div class="form-split">
                            <div class="half-split">
                                <label class="form-header">
                                    Postal/Zip Code
                                    <input id='head-postal' type="text" class="form-element" placeholder='Postal/Zip Code' placeholder="Website" value='<?php echo get_field('head_office_postal_code', $post->ID); ?>'>
                                </label>
                            </div>
                            <div class="center-split"></div>
                            <div class="half-split">
                                <label class="form-header">
                                    phone number
                                    <input id='head-phone' class="form-element" placeholder='Phone Number' placeholder="Website" value='<?php echo get_field('head_office_phone_number', $post->ID); ?>'>
                                </label>
                            </div>
                        </div>
                    </div>
                    <!-- content of the form -->
                </div>
                <button id='edit-bottom' class='edit-btn'>Edit</button>
                <button id='publish-bottom' class='publish-btn'>Publish</button>
            </div>
        <?php
            } else if ($post->post_type == "packages"){
        ?>
        <!-- html for packages -->
            <div id="package-edit-form" class="profile-edit-form isHidden" data-post-type='packages'>
                <!-- <div class="container"> -->
                <button id='edit-top' class='edit-btn'>Edit</button>
                <button id='publish-top' class='publish-btn'>Publish</button>
                <h4 class="form-heading">Information</h4>
                <input id='package-name' class="form-element comp-name" type="textbox" placeholder="Package Name" value="<?php echo apply_filters('the_title', $post->post_title); ?>">
                <h4 class="form-headeing">description</h4>
                <textarea id='package-desc' class="form-element  desc" resize="false" placeholder="Description of the package"><?php echo apply_filters('the_content', $post->post_content); ?></textarea>
                <h4 class="form-heading">Start/End Date</h4>
                <div class="name">
                    <input id="start" class="package-datepicker form-element start" type="textbox" placeholder="Start Date" value="<?php echo get_field('start_date', $post->ID); ?>">
                    <div class="name-space"></div>
                    <input id="end" class="package-datepicker form-element end" type="textbox" placeholder="End Date" value="<?php echo get_field('end_date', $post->ID); ?>">
                </div>
                <button id='edit-bottom' class='edit-btn'>Edit</button>
                <button id='publish-bottom' class='publish-btn'>Publish</button>
            </div>
        <?php } ?>
    </div>
<?php
    }
?>
</main>

<?php        
    get_footer();
?>