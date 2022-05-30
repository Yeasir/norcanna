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
                <div class="menu-logo">
                    <div class=""></div>
                    <a href="#">
                        <img src="images/menu-logo.png" class="img-fluid" alt=""/>
                    </a>
                </div>
                <!-- /.menu-logo end -->

                <?php
                //user_logged_in_menu_cart();

                $header_menu_logo = get_field('header_menu_logo', 'option');

                if( !empty($header_menu_logo) ): ?>
                    <div class="menu-logo">
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                            <img src="<?php echo $header_menu_logo; ?>" class="img-fluid" alt="" />
                        </a>
                    </div>
                <?php endif; ?>


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
                            <a href="#" class="sing-up"><i class="fa fa-lock"></i>sing up</a>
                            <a href="#" class="sing-in"><i class="fa fa-sign-in"></i>sing in</a>
                        <?php else : ?>
                            <a href="<?php echo wp_logout_url( '/' ); ?>" class="sing-out"><i class="fa fa-sign-out"></i>sing out</a>
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

        <div class="inner-header">
            <div class="container-fluid">
                <div class="row d-flex align-items-center">
                    <!-- /.menu-icon-logo start -->
                    <div class="col-md-6 col-sm-6 col-12 menu-icon-logo">
                        <div class="menu-icon menu-toggle-btn d-inline-block">
                            <span><i class="fa fa-bars"></i></span>
                        </div>

                    </div>
                    <!-- /.menu-icon-logo end -->

                </div>
                <div class="row pt-5">
                    <div class="col-12 text-center">
                        <?php
                        $header_menu_logo = get_field('page_logo', 'option');

                        if( !empty($header_menu_logo) ): ?>
                            <div class="logo mb-5">
                                <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                                    <img src="<?php echo $header_menu_logo; ?>" class="img-fluid" alt="logo" />
                                </a>
                            </div>
                        <?php endif; ?>

                        <div class="sub_heading">
                            <?php
                            global $post;
                            $id = $post->ID;
                            if  ( is_shop() ) {
                                $id = wc_get_page_id( 'shop' );
                            }
                            ?>
                            <h4><?php echo get_field( "sub_heading", $id );?></h4>
                        </div>
                    </div>

                </div>

            </div>
        </div>
        <!-- /.header-top end -->
    </header>
    <!-- /.header -->
    <?php //global $template; echo $template;?>