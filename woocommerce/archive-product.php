<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action( 'woocommerce_before_main_content' );

if(is_shop()){
    //shop_page_filter_function();
    ?>
    <section class="product-grid">
        <div class="container">
            <form class="row" action="" method="post" id="product_filter_form">
                <div class="col-lg-3 col-md-4 col-sm-12 product-sidebar">
                    <?php
                    $args = array(
                        'orderby'           => 'id',
                        'order'             => 'ASC',
                        'parent'            => 0
                    );
                    $terms = get_terms('product_cat', $args);
                    if(!empty($terms)):
                        ?>
                        <div class="sidebar_title">
                            <h3>Categories</h3>
                        </div>
                        <div id="accordion" class="content-box product_widget_area">
                        <?php
                    $i =1;
                        foreach ($terms as $term):
                        $pr_term_id = $term->term_id;
                        $show = '';

                            $show = '';
                            $aria_expanded = '';
                            if ($i == 1) {
                                $show = "show";
                                $aria_expanded = "true";

                            } else {
                                $show = '';
                                $aria_expanded = "false";
                            }


                        ?>

                    <div class="card">


                              <div class="card-header widget_title" id="heading-<?php echo $pr_term_id;?>">
                            <h4 class="mb-0">
                                <a role="button" data-toggle="collapse" href="#collapse-<?php echo $pr_term_id;?>" aria-expanded="<?php echo $aria_expanded; ?>" aria-controls="collapse-<?php echo $pr_term_id;?>">
                                    <label class="custom_checkbox">
                                        <input type="checkbox" class="custom-control-input" value="<?php echo $pr_term_id;?>" name="parent-cat[]" checked >
                                        <i class="fa fa-square fa-4" aria-hidden="true"></i>
                                        <?php echo $term->name;?> <span class="check_num">(<?php echo $term->count;?>)</span>
                                </a>

                            </h4>
                        </div>


                            <?php
                            $args = array(
                                'orderby'           => 'id',
                                'order'             => 'ASC',
                                'parent'            => $pr_term_id
                            );
                            $sub_categories = get_terms('product_cat', $args);
                            if(!empty($sub_categories)):
                                ?>
                                <div id="collapse-<?php echo $pr_term_id;?>" class="collapse <?php echo $show; ?>"
                                     data-parent="#accordion" aria-labelledby="heading-<?php echo $pr_term_id;?>">
                                    <div class="card-body widget_body">
                                        <ul class="widget-list category-list">
                                            <?php foreach ($sub_categories as $term):?>
                                                <li>
                                                    <label class="custom_checkbox">
                                                        <input type="checkbox" class="custom-control-input" value="<?php echo $term->term_id;?>" name="cat-<?php echo $pr_term_id;?>[]">
                                                        <i class="fa fa-square fa-4" aria-hidden="true"></i>
                                                        <?php echo $term->name;?>
                                                    </label>
                                                </li>
                                            <?php endforeach;?>
                                        </ul>

                                    </div>
                                </div>

                            <?php endif;?>
                      </div>

                    <?php $i++; endforeach;?>
                    <?php endif;?>
                        </div>
                    <div class="sidebar_title">
                        <h3>Price</h3>
                    </div>

                    <div class="product_widget_area">
                        <div class="widget_body">

                            <div class="price-slider-wrap">

                                <?php
                                $first_val = get_option('first_val');
                                $last_val = get_option('last_val');
                                if(empty($first_val)){
	                                $first_val = 10;
	                                $last_val = 35;
                                }
                                ?>
                                <div class="form-inline price_input">
                                    <span class="fi-dlr mb-2">$</span>
                                    <input type="text" class="form-control mb-2 mr-sm-2" id="range_first" placeholder="10" name="pr_first" value="<?php echo $first_val;?>">
                                    <span class="fi-sep mb-2">&mdash;</span>

                                    <input type="text" class="form-control mb-2 mr-sm-2" id="range_last" placeholder="35" name="pr_last" value="<?php echo $last_val;?>">
                                </div>

                                <div class="price_slide">
                                    <input id="price_slide_input" type="text" class="span2" value="" data-slider-min="0" data-slider-max="50" data-slider-step="1" data-slider-value="[<?php echo $first_val . ',' . $last_val;?>]"/>
                                </div>
                                <div class="price_checkbox">
                                    <label class="custom_checkbox">
                                        <input type="checkbox" class="custom-control-input" checked="checked">
                                        <i class="fa fa-square fa-4" aria-hidden="true"></i>
                                    </label>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- /.product_widget_area  -->
                    <?php
                    $field_name = "strength";
                    $field = get_field_object($field_name);

                    if(!empty($field['choices'])):
                    ?>

                    <div class="sidebar_title">
                        <h3>Strength</h3>
                    </div>

                    <div class="product_widget_area">
                        <div class="widget_body">
                            <ul class="widget-list category-list">
                                <?php foreach ($field['choices'] as $key => $value):?>
                                <li>
                                    <label class="custom_checkbox">
                                        <input type="checkbox" class="custom-control-input" value="<?php echo $key;?>" name="pr-srength[]">
                                        <i class="fa fa-square fa-4" aria-hidden="true"></i>
                                        <?php echo $value;?>
                                    </label>
                                </li>
                                <?php endforeach;?>
                            </ul>
                        </div>
                    </div>
                    <?php endif;?>
                    <!-- /.product_widget_area  -->

                </div>
                <!-- /.product-sidebar  -->

                <div class="col-lg-9 col-md-8 col-sm-12 product-content">
                    <div class="row">
                    <?php
                    $args = array(
                        'post_type' => 'product',
                        'meta_key' => 'total_sales',
                        'orderby' => 'meta_value_num',
                        'posts_per_page' => 5,
                    );
                    $loop = new WP_Query( $args );
                    if ( $loop->have_posts() ) :
                    ?>
                        <div class="col-lg-6">
                            <div class="pc-slide-wrap">
                                <div class="pcsw-top">
                                    <span class="best-seller">Best Seller</span>
                                </div>
                                <div class="pcsw-slider">
                                    <?php
                                    $exclude_array = [];
                                    while ( $loop->have_posts() ) : $loop->the_post();
                                    global $product;
                                    $exclude_array[] = $product->get_id();
                                    $catIds = $product->get_category_ids();
                                    $category_name = [];
                                    if(!empty($catIds)){
                                        foreach ($catIds as $cat_id){
                                            $trm = get_term_by( 'id',  $cat_id, 'product_cat' );

                                            if($trm->parent == 0) {
                                                $category_name[] = $trm->name;
                                                break;
                                            }
                                        }
                                    }
                                    $price = get_post_meta($product->get_id(), '_price', true);
                                    $image = wp_get_attachment_image_src( get_post_thumbnail_id( $product->get_id() ), 'full' );

                                    ?>
                                    <div class="pcsw-slider-item">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h3><strong><?php echo implode(', ',$category_name);?></strong>
                                                    <?php
                                                    $product_name = $product->get_name();
                                                    $p_lenght = strlen($product_name);
                                                    if($p_lenght > 20){
                                                        $product_name = substr($product_name,0,20).'...';
                                                    }
                                                    echo $product_name;
                                                    ?>
                                                </h3>
                                                <p>
                                                    <?php
                                                    $short_description = $product->get_short_description();
                                                    $s_lenght = strlen($short_description);
                                                    if($s_lenght > 75){
                                                        $short_description = substr($short_description,0,75).'...';
                                                    }
                                                    echo $short_description;
                                                    ?>
                                                </p>
                                                <?php $best_seller_text = get_field('best_seller_text','option');?>
                                                <p class="small"><?php echo $best_seller_text;?></p>
                                                <div class="amount_buy clearfix">
                                                    <span><em><?php echo get_woocommerce_currency_symbol();?></em> <?php echo $price;?></span>
                                                    <a href="<?php echo $product->add_to_cart_url();?>" data-quantity="1"
                                                       class="btn orange product_type_<?php echo $product->get_type();?> add_to_cart_button ajax_add_to_cart"
                                                       data-product_id="<?php echo $product->get_id();?>" data-product_sku="" aria-label="Add “Product” to your cart"
                                                       rel="nofollow">Buy now
                                                    </a>
                                                    <!--<button type="submit" class="btn orange">Buy now</button>-->
                                                </div>
                                            </div>
                                            <div class="col-md-6 text-right">
                                                <img src="<?php  echo $image[0]; ?>" alt="Product">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.pcsw-slider-item  -->
                                    <?php endwhile; ?>
                                </div>
                            </div>
                        </div>
                        <?php wp_reset_query(); ?>
                        <?php else : ?>
                        <div class="col-lg-12"><p><?php esc_html_e( 'Sorry, no order place yet.' ); ?></p></div>
                        <?php endif; ?>
                        <?php
                        $args = array(
                            'post_type' => 'product',
                            'meta_key' => 'total_sales',
                            'orderby' => 'meta_value_num',
                            'posts_per_page' => 5,
                            'post__not_in' => $exclude_array
                        );
                        $loop = new WP_Query( $args );
                        if ( $loop->have_posts() ) :
                        ?>

                        <div class="col-lg-6">
                            <div class="pc-slide-wrap">
                                <div class="pcsw-top">
                                    <span class="best-seller">Best Seller</span>
                                </div>
                                <div class="pcsw-slider">
                                <?php
                                while ( $loop->have_posts() ) : $loop->the_post();
                                    global $product;
                                    $catIds = $product->get_category_ids();
                                    $category_name = [];
                                    if(!empty($catIds)){
                                        foreach ($catIds as $cat_id){
                                            $trm = get_term_by( 'id',  $cat_id, 'product_cat' );
                                            if($trm->parent == 0) {
                                                $category_name[] = $trm->name;
                                                break;
                                            }
                                        }
                                    }
                                    $price = get_post_meta($product->get_id(), '_price', true);
                                    $image = wp_get_attachment_image_src( get_post_thumbnail_id( $product->get_id() ), 'full' );

                                    ?>
                                    <div class="pcsw-slider-item">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h3><strong><?php echo implode(', ',$category_name);?></strong>
                                                    <?php
                                                        $product_name = $product->get_name();
                                                        $p_lenght = strlen($product_name);
                                                        if($p_lenght > 20){
                                                            $product_name = substr($product_name,0,20).'...';
                                                        }
                                                        echo $product_name;
                                                    ?>
                                                </h3>
                                                <p>
                                                    <?php
                                                    $short_description = $product->get_short_description();
                                                    $s_lenght = strlen($short_description);
                                                    if($s_lenght > 75){
                                                        $short_description = substr($short_description,0,75).'...';
                                                    }
                                                    echo $short_description;
                                                    ?>
                                                </p>
                                                <?php $best_seller_text = get_field('best_seller_text','option');?>
                                                <p class="small"><?php echo $best_seller_text;?></p>
                                                <div class="amount_buy clearfix">
                                                    <span><em><?php echo get_woocommerce_currency_symbol();?></em> <?php echo $price;?></span>
                                                    <a href="<?php echo $product->add_to_cart_url();?>" data-quantity="1"
                                                       class="btn orange product_type_<?php echo $product->get_type();?> add_to_cart_button ajax_add_to_cart"
                                                       data-product_id="<?php echo $product->get_id();?>" data-product_sku="" aria-label="Add “Product” to your cart"
                                                       rel="nofollow">Buy now
                                                    </a>
                                                    <!--<button type="submit" class="btn orange">Buy now</button>-->
                                                </div>
                                            </div>
                                            <div class="col-md-6 text-right">
                                                <img src="<?php  echo $image[0]; ?>" alt="Product">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.pcsw-slider-item  -->
                                    <?php endwhile; ?>
                                </div>
                            </div>
                        </div>
                        <?php wp_reset_query(); ?>
                        <?php else : ?>
                            <div class="col-lg-6"><p><?php esc_html_e( 'Sorry, no other best seller product.' ); ?></p></div>
                        <?php endif; ?>
                    </div>

                    <!--product-category start-->
                    <div class="product-category pc-category-wrap">
                        <div class="container">
                            <div class="cp_container">
                            <?php
                            $terms = get_terms(array(
                                'taxonomy' => 'product_cat',
                                'hide_empty' => true,
                                'number' => 3,
                                'parent' => 0
                            ));
                            if(!empty($terms)):
                                foreach ($terms as $term):
                            ?>
                                    <div class="row">
                                        <div class="col-12">
                                            <header class="woocommerce-products-header clearfix">
                                                <h5 class="woocommerce-products-header__title page-title"><?php echo $term->name;?></h5>
                                                <!--<i class="fa fa-circle sep" aria-hidden="true"></i>
                                                <h6>Indica</h6>-->
                                            </header>
                                            <?php
                                            $args = array(
                                                'post_type'             => 'product',
                                                'post_status'           => 'publish',
                                                'posts_per_page'        => -1,
                                                'tax_query'             => array(
                                                    array(
                                                        'taxonomy'      => 'product_cat',
                                                        'field' => 'term_id',
                                                        'terms'         => $term->term_id,
                                                        'operator'      => 'IN'
                                                    )
                                                )
                                            );
                                            $products = new WP_Query($args);
                                            if ( $products->have_posts() ) :
                                            ?>
                                            <ul class="products columns-4 pr-category-slider text-center">
                                                <?php
                                                while ( $products->have_posts() ) : $products->the_post();
                                                    global $product;
                                                    $catIds = $product->get_category_ids();
                                                    $category_name = [];
                                                    if(!empty($catIds)){
                                                        foreach ($catIds as $cat_id){
                                                            $trm = get_term_by( 'id',  $cat_id, 'product_cat' );
                                                            $category_name[] = $trm->name;
                                                        }
                                                    }
                                                    ?>
                                                    <li class="post-<?php echo $product->get_id();?> product type-product status-publish entry product-type-<?php echo $product->get_type();?>">
                                                        <a href="<?php echo $product->get_permalink();?>"
                                                           class="woocommerce-LoopProduct-link woocommerce-loop-product__link" data-pid="<?php echo $product->get_id();?>">
                                                            <div class="media">
                                                                <?php echo $product->get_image('woocommerce_thumbnail');?>
                                                                <div class="media-body">
                                                                    <h4 class="mt-0"><?php echo $product->get_name();?><?php if($product->get_type() == 'variable'):
                                                                            $attribute_name = get_attribute_name($product);
                                                                            ?>
                                                                            &nbsp; - &nbsp;<?php echo str_replace('-',' ',$attribute_name);?>
                                                                        <?php endif;?></h4>
                                                                    <h5 class="mt-0"><?php echo implode(', ',$category_name);?></h5>
                                                                    <h6 class="mt-0"><?php echo $product->get_price_html();?></h6>
                                                                </div>
                                                            </div>
                                                        </a>
                                                        <a href="<?php echo $product->add_to_cart_url();?>" data-quantity="1"
                                                           class="button product_type_<?php echo $product->get_type();?> add_to_cart_button ajax_add_to_cart"
                                                           data-product_id="<?php echo $product->get_id();?>" data-product_sku="<?php echo $product->get_sku();?>" aria-label="Add “Product” to your cart"
                                                           rel="nofollow"><i class="fa fa-plus" aria-hidden="true"></i>
                                                        </a>
                                                    </li>
                                                <?php endwhile; ?>
                                                <?php wp_reset_query(); ?>
                                            </ul>
                                            <?php else : ?>
                                                <p><?php esc_html_e( 'Sorry, no product found.' ); ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach;?>
                            <?php endif;?>
                            </div>
                            <div class="row loadMore2">
                                <div class="col-12 text-center">
                                    <div class="load-more">
                                        <h6>load more</h6>
                                        <div class="wait" id="wait2"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="full-wait wait-reg"></div>
                    </div>
                    <!--product-category end-->
                </div>
            </form>
        </div>
    </section>

    <?php
}else {


    ?>
    <header class="woocommerce-products-header">
        <?php if (apply_filters('woocommerce_show_page_title', true)) : ?>
            <h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
        <?php endif; ?>

        <?php
        /**
         * Hook: woocommerce_archive_description.
         *
         * @hooked woocommerce_taxonomy_archive_description - 10
         * @hooked woocommerce_product_archive_description - 10
         */
        do_action('woocommerce_archive_description');
        ?>
    </header>
    <?php
    if (woocommerce_product_loop()) {

        /**
         * Hook: woocommerce_before_shop_loop.
         *
         * @hooked woocommerce_output_all_notices - 10
         * @hooked woocommerce_result_count - 20
         * @hooked woocommerce_catalog_ordering - 30
         */
        do_action('woocommerce_before_shop_loop');

        woocommerce_product_loop_start();

        if (wc_get_loop_prop('total')) {
            while (have_posts()) {
                the_post();

                /**
                 * Hook: woocommerce_shop_loop.
                 *
                 * @hooked WC_Structured_Data::generate_product_data() - 10
                 */
                do_action('woocommerce_shop_loop');

                wc_get_template_part('content', 'product');
            }
        }

        woocommerce_product_loop_end();

        /**
         * Hook: woocommerce_after_shop_loop.
         *
         * @hooked woocommerce_pagination - 10
         */
        do_action('woocommerce_after_shop_loop');
    } else {
        /**
         * Hook: woocommerce_no_products_found.
         *
         * @hooked wc_no_products_found - 10
         */
        do_action('woocommerce_no_products_found');
    }

    /**
     * Hook: woocommerce_after_main_content.
     *
     * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
     */
}


do_action( 'woocommerce_after_main_content' );

/**
 * Hook: woocommerce_sidebar.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
//do_action( 'woocommerce_sidebar' );

get_footer( 'shop' );
