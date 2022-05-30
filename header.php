<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package norcanna
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class();?> >

<div class="wrapper">
    <!-- /.header start  -->
    <header class="header">
        <!-- /.header-top start -->
        <!-- /.main-menu start -->
        <div class="main-menu">
            <div class="main-menu-wrapper text-center">
                <!-- /.close-btn start -->
                <div class="close-btn">
                    <i class="fa fa-close menu-toggle-btn"></i>
                </div>
                <!-- /.close-btn end -->
                <!-- /.menu-logo start -->
                <?php
                user_logged_in_menu_cart();

                $header_menu_logo = get_field('header_menu_logo', 'option');

                if( !empty($header_menu_logo) ): ?>
                    <div class="menu-logo">
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                            <img src="<?php echo $header_menu_logo; ?>" class="img-fluid" alt="" />
                        </a>
                    </div>
                <?php endif; ?>

                <!-- /.menu-logo end -->
                <!-- /.header-search start -->
                <div class="header-search">
                    <form action="#">
                        <input type="text" value="" name="" class="">
                        <button><i class="fa fa-search"></i></button>
                    </form>
                </div>
                <!-- /.header-search end -->
                <!-- /.nav-wrapper start -->
                <div class="nav-wrapper text-uppercase">

                    <?php

                    wp_nav_menu( array(
                        'theme_location'    => 'menu-1',
                        'depth'             => '',
                        'container'         => 'ul',
                        'menu_class'        => 'list-unstyled',
                        'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
                        'walker'            => new WP_Bootstrap_Navwalker()
                    ) );

                    ?>

                </div>
                <!-- /.nav-wrapper end -->
                <!-- /.account start -->
                <div class="account text-uppercase">
                    <div class="login-register">
                        <?php if( !is_user_logged_in() ) : ?>
                        <a href="#" class="sing-up"><i class="fa fa-lock"></i>SIGN UP</a>
                        <a href="#" class="sing-in"><i class="fa fa-sign-in"></i>SIGN IN</a>
                        <?php else : ?>
                        <a href="<?php echo wp_logout_url( home_url() ); ?>" class="sing-out"><i class="fa fa-sign-out"></i>LOG OUT</a>
                        <?php endif; ?>
                    </div>
                </div>
                <!-- /.account end -->

                <!-- /.social-icons start -->
                <?php

                $header_social_links = get_field('header_social_links', 'option');
                if ( $header_social_links ) : ?>

                    <!-- /.social-icons start -->
                    <ul class="social-icons list-inline">
                        <?php do_action('social_links' ); ?>
                    </ul>
                    <!-- /.social-icons end -->

                <?php
                endif ?>
                <!-- /.social-icons end -->
            </div>
        </div>
        <!-- /.main-menu end -->
        <!-- /.mini-cart start -->
        <div class="mini-cart">
            <div class="mini-cart-wrapper">
                <!-- /.close-btn start -->
                <div class="mini-cart-btn cart-btn-trig">
                    <i class="fa fa-close menu-toggle-btn"></i>
                </div>
                <!-- /.close-btn end -->
                <div class="d-flex align-items-md-center">
                    <?php
                    global $woocommerce;
                    $woocommerce->cart->get_cart_contents_count();
                    ?>
                    <!-- /.cart-icon start -->
                    <div class="cart-icon">
                        <a href="<?php echo $woocommerce->cart->get_cart_url();?>" class="cart-content position-relative text-uppercase">
                            <span class="contcon"><?php if($woocommerce->cart->get_cart_contents_count() > 0){?><span class="badge"></span><?php };?></span>
                            <img src="<?php echo URL;?>/images/menu-cart.png" class="img-fluid" alt=""/>
                            <span class="cart-txt">shopping cart</span>
                            <span class="cart-seperate"></span>
                            <span class="product-items-count"><span class="items-count"><?php if($woocommerce->cart->get_cart_contents_count() > 0){ echo $woocommerce->cart->get_cart_contents_count();}else{ echo '0';}?></span> product</span>
                        </a>
                    </div>
                    <!-- /.cart-icon end -->
                    <?php user_logged_in_menu_cart() ?>
                </div>

                <div class="product-items-wrapper">

                    <?php
                    global $woocommerce;
                    $items = $woocommerce->cart->get_cart();
                    //echo '<pre>';
                    //print_r($items);
                    //echo '</pre>';
                    if(empty($items)){
                    ?>
                        <!-- /.mini-pro-item start -->
                        <div class="mini-pro-item position-relative d-block">
                            Cart is empty!
                        </div>
                        <?php
                    }else{
                    foreach($items as $item => $values) {
                        $product_id = apply_filters( 'woocommerce_cart_item_product_id', $values['product_id'], $values, $item );
                        $_product =  wc_get_product( $values['data']->get_id());
                        $price = get_post_meta($values['product_id'] , '_price', true);
                    ?>

                    <!-- /.mini-pro-item start -->
                    <div class="mini-pro-item position-relative d-block">
                        <a href="<?php echo $_product->get_permalink();?>" class="mini-pro-thumb">
                            <?php
                            $image = wp_get_attachment_image_src( get_post_thumbnail_id( $values['data']->get_id() ), 'full' );
                            ?>
                            <img src="<?php  echo $image[0]; ?>" class="img-fluid" alt="">
                            <p class="mini-title d-inline-block">
                                <?php
                                    $catIds = $_product->get_category_ids();
                                    $category_name = [];
                                    if(!empty($catIds)){
                                        foreach ($catIds as $cat_id){
                                            $trm = get_term_by( 'id',  $cat_id, 'product_cat' );
                                            $category_name[] = $trm->name;
                                        }
                                    }
                                ?>
                                <span><?php echo implode(', ',$category_name);?>. </span>
                                <?php echo $_product->get_title();?>
                            </p>
                        </a>
                        <div  class="mini-qty text-right d-flex align-items-center justify-content-end">
                            <span class="mb-0 mini-price"><?php echo get_woocommerce_currency_symbol().''.$price;?></span>
                            <span class="d-inline-block input-qty-fix">
                                <span class="input-group-btn">
                                    <button type="button" class="quantity-left-minus"  data-type="minus" data-field="">+</button>
                                </span>
                                <input type="text" id="quantity" name="quantity" class="input-number" value="<?php echo $values['quantity'];?>" min="1" max="100">
                                <span class="input-group-btn">
                                    <button type="button" class="quantity-right-plus" data-type="plus" data-field="">-</button>
                                </span>
                            </span>
                        </div>
                        <span class="mini-pro-remove">
                            <?php
                            echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
									'<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s"><i class="fa fa-remove"></i></a>',
									esc_url( wc_get_cart_remove_url( $item ) ),
									__( 'Remove this item', 'norcanna' ),
									esc_attr( $product_id ),
									esc_attr( $_product->get_sku() )
								), $item );?>
                        </span>
                        <div class="clearfix"></div>
                    </div>
                    <!-- /.mini-pro-item end -->
                   <?php };?>
                    <!-- /.oder-delivery start -->
                    <div class="oder-delivery">
                        <p>
                            <span>Order</span>
                            <span class="float-right"><?php wc_cart_totals_subtotal_html(); ?></span>
                        </p>
                        <p>
                            <span>Delivery</span>
                            <span class="float-right">Free</span>
                        </p>
                    </div>
                    <!-- /.oder-delivery end -->
                    <!-- /.total-amount start -->
                    <div class="total-amount">
                        <p>
                            <span>Total Amount</span>
                            <span class="float-right"><?php wc_cart_totals_order_total_html(); ?></span>
                        </p>
                    </div>
                    <!-- /.total-amount end -->
                    <?php
                    if ( is_user_logged_in() ) {
                        $user_id = get_current_user_id();
                        $shipping_address = cus_get_formatted_shipping_address($user_id);
                        $shipping_address = trim($shipping_address);
                        if(!empty($shipping_address)):
                        ?>
                            <div class="delivery-address position-relative">
                                <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>edit-address/shipping/"><i class="fa fa-edit"></i></a>
                                <img src="<?php echo URL;?>/images/delivery-address-icon.png" class="img-fluid rounded" />
                                <div class="del-add-fix">
                                    <h6>Delivery Address</h6>
                                    <p><?php echo $shipping_address;?></p>
                                </div>
                            </div>
                        <?php endif;};?>
                    <?php };?>
                </div>

                <!-- /.cart-footer start -->
                <div class="cart-footer d-flex align-items-center mt-4">
                    <a href="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>" class="text-capitalize mt-2"><i class="fa fa-angle-left mr-2"></i>Continue Shopping</a>
                    <div class="checkoutBtn ml-lg-auto ml-sm-auto ml-auto">
                    <?php if(!empty($items)){?>
                        <a href="<?php echo get_permalink( wc_get_page_id( 'checkout' ) );?>" class="btn orange text-uppercase mt-2">CHECKOUT</a>
                    <?php };?>
                    </div>
                </div>
                <!-- /.cart-footer end -->
            </div>
        </div>
        <!-- /.mini-cart end -->
        <div class="header-top position-relative">
            <div class="container-fluid">
                <div class="row d-flex align-items-center">
                    <!-- /.menu-icon-logo start -->
                    <div class="col-md-6 col-sm-6 col-10 menu-icon-logo">
                        <div class="menu-icon menu-toggle-btn d-inline-block">
                            <span><i class="fa fa-bars"></i></span>
                        </div>

                        <?php

                        $main_logo = get_field('main_logo', 'option');

                        if( !empty($main_logo) ): ?>

                        <div class="logo d-inline-block">
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                                <img src="<?php echo $main_logo; ?>" alt="<?php echo $main_logo; ?>" />
                            </a>
                        </div>

                        <?php endif; ?>
                    </div>
                    <!-- /.menu-icon-logo end -->

                    <!-- /.search-cart-icon start -->
                    <div class="col-md-6 col-sm-6 col-2 search-cart-icon">

                        <?php

                        $header_search = get_field('header_search', 'option');
                        if( $header_search ):

                        ?>
                        <div class="header-search float-left">
                            <form action="#">
                                <input type="text" value="" name="" placeholder="SEARCH" class="">
                                <button><i class="fa fa-search"></i></button>
                            </form>
                        </div>
                        <?php endif;
                        ?>

                        <div class="cart-icon float-right">
                            <a href="#" class="cart-content cart-btn-trig position-relative">
                                <span class="contcon"><?php if($woocommerce->cart->get_cart_contents_count() > 0){?><span class="badge"></span><?php };?></span>
                                <img src="<?php echo URL;?>/images/cart.png" class="img-fluid desktop-cart" alt=""/>
                                <img src="<?php echo URL;?>/images/menu-cart.png" class="img-fluid menu-cart" alt=""/>
                            </a>
                        </div>
                    </div>
                    <!-- /.search-cart-icon end -->
                </div>
                <div class="row pt-260">
                    <!-- /.social-icons-services start -->
                    <div class="col-lg-5 col-md-5 col-sm-12 col-12 social-icons-services">
                        <div class="text-center top-delivey-services">
                            <?php

                            $hero_title = get_field('hero_title', 'option');
                            $hero_sub_title = get_field('hero_sub_title', 'option');
                            $hero_call_to_action = get_field('hero_call_to_action', 'option');
                            $call_to_action_btn_text = get_field('call_to_action_btn_text', 'option');
                            $hero_banner = get_field('hero_banner', 'option');

                            if( $hero_title ):
                                echo "<h2>$hero_title</h2>";
                            endif;

                            if( $hero_sub_title ):
                                echo "<h3>$hero_sub_title</h3>";
                            endif;

                            if( $call_to_action_btn_text ):
                                echo "<a href='$hero_call_to_action' class='btn orange text-uppercase'>$call_to_action_btn_text</a>";
                            endif;

                            if( $hero_banner ):
                                ?>
                            <style>
                                .header .header-top:after{
                                    background-image: url(<?php echo $hero_banner; ?>)
                                }
                            </style>
                            <?php
                            endif;

                            ?>
                        </div>

                        <?php

                        $hero_banner_social_links = get_field('hero_banner_social_links', 'option');
                        if ( $hero_banner_social_links ) : ?>

                            <!-- /.social-icons start -->
                            <ul class="social-icons list-unstyled">
                                <?php do_action('social_links' ); ?>
                            </ul>
                            <!-- /.social-icons end -->

                        <?php
                        endif ?>

                    </div>
                    <!-- /.social-icons-services end -->
                    <?php

                    $scroll_down = get_field('scroll_down', 'option');
                    if( $scroll_down ): ?>

                    <!-- /.scroll-down-arrow start -->
                    <div class="col-lg-7 col-md-7 col-12 scroll-down-arrow d-flex align-items-end justify-content-end">
                        <a href="#" class="text-uppercase scroll-down-action d-flex">
                            <span>Scroll down</span>
                            <i class="fa fa-arrow-down"></i>
                        </a>
                    </div>
                    <!-- /.scroll-down-arrow end -->
                    <?php endif;
                    ?>

                </div>
            </div>
        </div>
        <!-- /.header-top end -->
    </header>
    <!-- /.header -->
