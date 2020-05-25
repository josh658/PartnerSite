<!-- For HomePage
    Login
    description
    partnership plans (cards)
-->

<?php
    //pulling in header
    get_header();
?>
<main>
<?php
    if(is_user_logged_in()){
        ?>
            <h2>Welcome back <?php echo esc_html(wp_get_current_user()->user_login);?> </h2>
        <?php
    }else{
        //insert form
        ?>
        <form id='login-form' class='sign-in-form-card' method='post' action=<?php echo esc_url(site_url('wp-login.php', 'login_post'));?>>
            <div id='login-error'></div>
            <p>Sign In to Northeastern Ontario Tourism Partners</p>
            <input id='login-email' name='log' placeholder='Email Address'>
            <input id='login-password' type='password' name="pwd" placeholder='password'>
            <button id='login-btn'>Log In</button>
            <p>not a partner? <a>sign in</a></p>
        </form>
<<<<<<< HEAD
    </section>
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
                    <h2><?php echo esc_html($product->get_title());?></h2>
                    <p><?php echo esc_html($product->get_description());?></p>
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
                    
                    ?> </h5>
                    <button class="card-sub-select">Select</button>
                </div>
                    <?php
                
            }
            ?>
        </div>
    </section>
=======
        <?php
    }
    ?>
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
>>>>>>> parent of 97487a0c... setting up initial page

                    echo '<div>$' . esc_html($yearRate) . '<span>/year</span></div>';
                    echo '<div>$' . esc_html($monthRate) . '/month</div>';

<<<<<<< HEAD
    <section class='card-row'>
            <?php
            $products = wc_get_products(array(
                'category' => 'municipal',
                'status' => 'public'
            ));
            foreach($products as $product){
                ?>
                <div
                    data-subID="<?php //echo get_field('price', $product-get_id())?>"
                    class="card-subscription"
                            style="order: <?php echo get_field('order', $product->get_id());?>;">
                    <h2><?php echo esc_html($product->get_title());?></h2>
                    <p><?php echo esc_html($product->get_description());?></p>
                    <?php
                    if ($product->is_type('variable')){
                        $variations = $product->get_available_variations();
                        $min = $variations[0]['display_price'];
                        foreach($variations as $variation){
                            if($variation['display_price'] < $min){
                                $min = $variation["display_price"];
                            }
                        }
                        
                        echo '<div>Starts at $' . esc_html($min) . '<span>/year</span></div>';
                        
                    }
                    ?>
                    <button>select</button>
                </div>
        <?php
            }
            $products = wc_get_products(array(
                'category' => array('event-sport'),
                'status' => 'public'
            ));
            foreach($products as $product){
                ?>
                <div
                    data-subID="<?php //echo get_field('price', $product-get_id())?>"
                    class="card-subscription
                            <?php echo (get_field('order', $product->get_id()));?>"
                            style="order: <?php echo get_field('order', $product->get_id());?>;">
                    <h2><?php echo esc_html($product->get_title());?></h2>
                    <p><?php echo esc_html($product->get_description());?></p>
                    <?php
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
                        
                    }
                    ?>
                    <button>select</button>
                </div>
            <?php
            }
            ?>
    </section>
=======
                } else {
                    echo "free";
                }
                                
                ?> </h5>
                <button class="card-sub-select">Select</button>
            </div>
                <?php
            
        }
    ?>
    </div>
    <div>
        <?php
        $products = wc_get_products(array(
            'category' => 'municipal',
            'status' => 'public'
        ));
        foreach($products as $product){
        ?>
            <div
                data-subID="<?php //echo get_field('price', $product-get_id())?>"
                class="card-subscription
                        <?php echo (get_field('order', $product->get_id()));?>"
                        style="order: <?php echo get_field('order', $product->get_id());?>;">
                <h2><?php echo esc_html($product->get_title());?></h2>
                <p><?php echo esc_html($product->get_description());?></p>
            </div>
    </div>
    <div>
    <?php
        }
        
        print_r(get_categories());
        $products = wc_get_products(array(
            'category' => array('plan_event-sport'),
            'status' => 'public'
        ));
        foreach($products as $product){
        ?>
            <div
                data-subID="<?php //echo get_field('price', $product-get_id())?>"
                class="card-subscription
                        <?php echo (get_field('order', $product->get_id()));?>"
                        style="order: <?php echo get_field('order', $product->get_id());?>;">
                <h2><?php echo esc_html($product->get_title());?></h2>
                <p><?php echo esc_html($product->get_description());?></p>
            </div>
    </div>
>>>>>>> parent of 97487a0c... setting up initial page

    
<?php   
    }
        ?>

</main>

<?php        
    get_footer();
?>