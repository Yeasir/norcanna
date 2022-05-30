<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package norcanna
 */

get_header();
?>

	<!-- /.main start  -->
    <main class="main">
        <!-- /.categories start  -->
        <section class="categories"
                 <?php
                    $background = get_field('category_background_image','option');
                    if($background){?>
                        style="background-image: url('<?php echo $background?>')"
                  <?php  } ?> >
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="header-top text-center">
                            <h2 class="white-color"><?php echo the_field('category_title','option');?></h2>
                        </div>
                    </div>
                </div>
                <div class="categories-item">
                    <div class="row mb-2">

                        <?php
                        $termObject = get_term_by('name', 'Uncategorized', 'product_cat');
                        $exclude_id = '';
                        if(!empty($termObject)){
                            $exclude_id = $termObject->term_id;
                        }


                        $taxonomy     = 'product_cat';
                        $orderby      = 'name';
                        $show_count   = 0;
                        $pad_counts   = 0;
                        $hierarchical = 1;
                        $title        = '';
                        $empty        = 0;

                        $args = array(
                            'taxonomy'     => $taxonomy,
                            'orderby'      => $orderby,
                            'show_count'   => $show_count,
                            'pad_counts'   => $pad_counts,
                            'hierarchical' => $hierarchical,
                            'title_li'     => $title,
                            'hide_empty'   => $empty,
                            'exclude'    => array( $exclude_id )
                        );
                        $all_categories = get_categories( $args );

                        $i=1;
                        foreach ($all_categories as $cat) {
                            if($cat->category_parent == 0) {
                                $category_id = $cat->term_id;
                                $thumbnail_id = get_term_meta( $cat->term_id, 'thumbnail_id', true );
                                $image = wp_get_attachment_url( $thumbnail_id );
                                $cols = "col-lg-6 col-md-6 co-sm-12 cat mb-4";

                                if($i > 4){
                                    $cols = "col-lg-6 col-md-6 co-sm-12 cat mb-4 d-none";
                                }

                                if ($cat->term_id){
                                ?>
                                <div class="<?php echo $cols;?>">
                                    <a href="<?php echo get_term_link($cat->slug, 'product_cat'); ?>" class="item dark-color">
                                        <?php
                                        if ($image){ ?>
                                            <img class="mr-3 rounded-circle" src="<?php echo $image; ?>" alt="categories-icon">
                                      <?php  }
                                        ?>
                                        <span><?php echo $cat->name;?></span>
                                    </a>

                                </div>

                          <?php  }  }
                          $i++;
                        }
                        ?>

                    </div>

                    <div class="row">
                        <div class="col col-12 text-center">
                            <div class="more-btn">
                                <a id="more_cat" href="#" class="btn orange text-uppercase"><?php echo the_field('more_button_text','option');?></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="subscribe">
                    <div class="row">
                        <div class="col-12">
                            <form action="" method="post">
                                <div class="form-group">

                                    <div class="input-group mb-1">

                                        <input type="email" name="mailchimp_email" class="form-control" id="email" placeholder="Email Address">
                                        <div class="input-group-addon"><button class="mailChimpBtn" type="submit"><i class="fa fa-paper-plane white-color"
                                                                                                                                   aria-hidden="true"></i></button></div>
                                    </div>
                                    <label for="email">Receive Special Offers, News & Updates</label>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.categories end  -->

        <?php

        $call_to_action_heading = get_field('call_to_action_heading', 'option');
        $shop_now_url = get_field('shop_now_url', 'option');
        $shop_now_url_text = get_field('shop_now_url_text', 'option');

        if( $call_to_action_heading || $shop_now_url_text ) : ?>

        <!--.support start-->
        <section class="support">
            <div class="support-box">
                <div class="row d-flex align-items-center">
                    <?php

                    if ( $call_to_action_heading ) : ?>

                    <div class="col-lg-7 col-md-6 col-sm-12 mb-2">
                        <h4 class="white-color text-center"><?php echo $call_to_action_heading; ?></h4>
                    </div>

                    <?php endif;

                    if ( $shop_now_url_text ) :
                    ?>

                    <div class="col-lg-5 col-md-6 col-sm-12 text-center">
                        <!--<a href="<?php echo $shop_now_url; ?>" class="btn custom-btn text-uppercase"><?php echo $shop_now_url_text; ?></a>-->
                        <a href="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>" class="btn custom-btn text-uppercase"><?php echo $shop_now_url_text; ?></a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
        <!--.support end-->

        <?php endif; ?>


        <!--product-category start-->
        <div class="product-category">
            <div class="container">
                <div class="offer">
                    <div class="row d-flex align-items-center">
                        <div class="col-lg-6 col-md-6 col-sm-12 text-lg-left text-md-left text-sm-center">
                            <?php
                            $offering_title = get_field('offering_title', 'option');
                            $offering_title = $offering_title ? $offering_title : 'Offerings';
                            $terms = get_terms( array(
                                'taxonomy' => 'product_cat',
                                'hide_empty' => true,
                                'parent' => 0
                            ) );

                            ?>
                            <h2 class="gray-light-color"><?php echo $offering_title;?></h2>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 text-lg-right text-md-right text-sm-center">
                            <?php if(!empty($terms)){?>
                                <form method="get">
                                    <select name="orderby" class="category_by">
                                        <option value="" selected="selected">All</option>
                                        <?php foreach ($terms as $trm):?>
                                        <option value="<?php echo $trm->term_id;?>"><?php echo $trm->name;?></option>
                                        <?php endforeach;?>
                                    </select>
                                </form>
                            <?php };?>
                        </div>
                    </div>
                </div>
                <div class="cp_container">
                <?php
                $select_offering_category = get_field('select_offering_category', 'option');
                if(empty($select_offering_category)) :
                    $terms = get_terms(array(
                        'taxonomy' => 'product_cat',
                        'hide_empty' => true,
                        'number' => 3,
                        'parent' => 0
                    ));
                    $select_offering_category = wp_list_pluck($terms, 'term_id');
                endif;
                if(!empty($select_offering_category)) :
                    foreach ($select_offering_category as $s_offering_cat):
                        $termObject = get_term_by('id', $s_offering_cat, 'product_cat');

                        $args = array(
                            'post_type'             => 'product',
                            'post_status'           => 'publish',
                            'posts_per_page'        => -1,
                            'tax_query'             => array(
                                array(
                                    'taxonomy'      => 'product_cat',
                                    'field' => 'term_id',
                                    'terms'         => $s_offering_cat,
                                    'operator'      => 'IN'
                                )
                            )
                        );
                        $products = new WP_Query($args);

                ?><div class="row" data-catId="<?php echo $s_offering_cat;?>">
                    <div class="col-12">
                        <header class="woocommerce-products-header">
                            <h5 class="woocommerce-products-header__title page-title"><?php echo $termObject->name;?></h5>
                        </header>
                        <?php if($products->post_count > 0):?>
                        <ul class="products columns-4 category-slider text-center">
                            <?php
                            while ( $products->have_posts() ) : $products->the_post();
                                global $product;
                                ?>
                            <li class="post-<?php echo $product->get_id();?> product type-product status-publish entry instock instock shipping-taxable purchasable product-type-<?php echo $product->get_type();?>">
                                <a href="<?php echo $product->get_permalink();?>"
                                   class="woocommerce-LoopProduct-link woocommerce-loop-product__link">
                                        <?php echo $product->get_image('woocommerce_thumbnail');?>
                                    <h2 class="woocommerce-loop-product__title"><?php echo $product->get_name();?><?php if($product->get_type() == 'variable'):
                                            $attribute_name = get_attribute_name($product);
                                            ?>
                                           &nbsp; - &nbsp;<?php echo str_replace('-',' ',$attribute_name);?>
                                        <?php endif;?></h2>

                                    <span class="price"><?php echo $product->get_price_html();?></span>
                                </a>
                                <a href="<?php echo $product->add_to_cart_url();?>" data-quantity="1"
                                       class="button product_type_<?php echo $product->get_type();?> add_to_cart_button ajax_add_to_cart"
                                       data-product_id="<?php echo $product->get_id();?>" data-product_sku="" aria-label="Add “Product” to your cart"
                                       rel="nofollow"> <img class="shop-icon" src="<?php echo URL; ?>/images/cart-icon.png" alt=""> Add to cart</a>
                            </li>
                            <?php endwhile;?>
                        </ul>
                        <?php endif;?>
                    </div>
                </div>
                <?php endforeach;?>
                </div>
                <div class="row loadMore">
                    <div class="col-12 text-center">
                        <div class="load-more">
                            <h6>load more</h6>

                            <div class="wait" id="wait2">

                            </div>
                        </div>
                    </div>
                </div>
                <?php endif;?>
            </div>
        </div>
        <!--product-category end-->


    </main>
    <!-- /.main start  -->

<?php
get_footer();
