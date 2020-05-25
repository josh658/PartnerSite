<?php
    //pulling in header
    get_header();
?>
<main>
<?php
    
?>
<h2 id="error-message"></h2>

<section class="progress-bar">

</section>

<!-- page 1 which plan you want to choose
Note make variations late for standard partnerships vs muni/sport partnerships -->
<section>
    <div class="card-row">
        <?php 
            $products = wc_get_products(array(
                'category' => array('partner'),
                'status' => 'publish'
            ));
            $yearRate;
            $monthRate;

            foreach($products as $product){
                    ?>
                <div
                    data-subID="<?php //echo get_field('price', $product-get_id())?>"
                    class="card-subscription
                            <?php echo (get_field('order', $product->get_id()));?>"
                            style="order: <?php echo get_field('order', $product->get_id());?>;">
                    <h2><?php echo $product->get_title();?></h2>
                    <p><?php echo $product->get_description();?></p>
                    <h5><?php
                    if ($product->is_type('variable')){
                        foreach($product->get_available_variations() as $variation){
                            //print_r($variation['attributes']['attribute_pay-period']);
                            if($variation['attributes']['attribute_pay-period'] == 'month'){
                                $monthRate = $variation["display_price"];
                            } else {
                                $yearRate = $variation['display_price'];
                            }
                        }

                        echo '<div>$' . esc_html($yearRate) . '<span>/year</span></div>';
                        echo '<div>$' . esc_html($monthRate) . '/month</div>';

                    } else {
                        echo "free";
                    }
                    //echo $product->get_id();
                    
                    
                    ?> </h5>
                    <button class="card-sub-select">Select</button>
                </div>
                    <?php
                // foreach($product->get_available_variations() as $variation){
                // }
            }
        ?>
    </div>

    <!-- view compare packages section 
            talk to rox about creating this
    -->

</section>

<!-- contact information section
this will be used to create the user and their company profile -->
<section>
    <!-- check if comp name already exists -->
    <label>Company Name:</label>
    <input type="text" id='company-name' class='form-element' placeholder='Company Name'>
    <label>First Name:</label>
    <input id="first-name" class="form-element" placeholder="First Name" >
    <label>Last Name:</label>
    <input id="last-name" class="form-element" placeholder="Last Name">
    <div class='password-error-message'></div>
    <label>Password:</label>
    <input id="password" class="form-element" type="password" placeholder="Password">
    <div class='password-match-error-message'></div>
    <!-- Password check. make sure both passwords match 
        <label>Retype Password:</label>
    <input id="password-check" class="form-element" type="password" placeholder="Password">
    <div class="email-error-message"></div> -->
    <label>Email:</label>
    <input id="email" class="form-element" type="email" placeholder="Email">
    <div class="card-row">
</section>

<!-- addons: this sections will pull all available addons that the user can choose at that moment -->
<section>

</section>

<!-- 
    when the page is being redirected the account should be created
        and all items desired should be added to the cart.
    finaly there will be a link to a checkout page, the user will be created, 
if chekout is not completed within 24 hrs the user will be deleted -->

</main>

<?php        
    get_footer();
?>