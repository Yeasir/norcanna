<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package norcanna
 */

?>
<?php
//$social_options = get_field('social_options', 'option');
///*echo '<pre>';
//print_r($social_options);
//echo '</pre>';*/
//wp_nav_menu( array(
//    'theme_location' => 'footer-menu',
//    'menu_id'        => '',
//) );
?>
<footer class="footer text-uppercase">
    <!-- /.footer-top start -->
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <?php
                    $footer_logo = get_field('footer_logo','option');
                    if ($footer_logo){?>
                    <!-- /.footer-logo start -->
                    <div class="footer-logo text-center">
                        <a href="#">
                            <img src="<?php echo $footer_logo; ?>" alt="">
                        </a>
                    </div>
                    <?php }
                    ?>
                    <!-- /.footer-logo end -->
                    <!-- /.footer-menu start -->
                    <div class="footer-menu overflow-hidden">

                        <?php
                        wp_nav_menu( array(
                            'theme_location' => 'footer-menu',
                            'menu_id'        => false,
                            'menu_class'        => "list-unstyled overflow-hidden m-0",
                            'container' => "ul",
                        ) );
                        ?>


                    </div>
                    <!-- /.footer-menu end -->

                </div>
            </div>
        </div>
    </div>
    <!-- /.footer-top end -->
    <!-- /.footer-bottom start -->
    <div class="footer-bottom text-center">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <?php
                    $footer_social_links = get_field('footer_social_links','option');
                    $copyright = get_field('copyright','option');;
                    if ($footer_social_links) { ?>

                        <?php if( have_rows('social_links','option') ): ?>

                            <ul class="social-icons list-inline mb-5">

                                <?php while( have_rows('social_links' , 'option') ): the_row();
                                    $icon= get_sub_field('social_icon','option');
                                    $link = get_sub_field('social_link','option');
                                    ?>

                                    <li class="list-inline-item">
                                        <a href="<?php echo $link; ?>" class=""><i class="fa <?php echo $icon; ?>"></i></a>
                                    </li>

                                <?php endwhile; ?>

                            </ul>

                        <?php endif; ?>


                    <?php } ?>

                    <?php if ($copyright){ ?>
                    <p><?php echo $copyright; ?></p>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <!-- /.footer-bottom end -->
</footer>
</div><!-- /.wrapper -->

<?php
get_template_part( 'template-parts/modal' );
 wp_footer(); ?>

</body>
</html>
