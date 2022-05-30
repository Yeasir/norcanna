<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package norcanna
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function norcanna_body_classes( $classes ) {
    // Adds a class of hfeed to non-singular pages.
    if ( ! is_singular() ) {
        $classes[] = 'hfeed';
    }

    // Adds a class of no-sidebar when there is no sidebar present.
    if ( ! is_active_sidebar( 'sidebar-1' ) ) {
        $classes[] = 'no-sidebar';
    }

    return $classes;
}
add_filter( 'body_class', 'norcanna_body_classes' );
/**
 * Social Links
 */
add_action( 'social_links', 'social_links_action' );
function social_links_action(){

    if( have_rows('social_links','option') ):

        while( have_rows('social_links' , 'option') ): the_row();
            $icon= get_sub_field('social_icon','option');
            $link = get_sub_field('social_link','option');
            ?>

            <li class="list-inline-item">
                <a href="<?php echo $link; ?>" class=""><i class="fa <?php echo $icon; ?>"></i></a>
            </li>

        <?php
        endwhile;

    endif;

}
/**
 * User logged in info for ( Menu & cart )
 */
function user_logged_in_menu_cart(){

    if ( is_user_logged_in() ) :

        global  $current_user;
        ?>

        <!-- /.user-logged-in start -->
        <div class="user-logged-in ml-auto">
            <div class="customer-icons">
                <a>
                    <img src="<?php echo esc_url( get_avatar_url( $current_user->ID ) ); ?>" width="35" height="35" class="img-fluid rounded-circle" alt="">
                    <span class="text-capitalize ml-2">Hi, <?php echo $current_user->user_login; ?></span>
                </a>
            </div>
        </div>
        <!-- /.user-logged-in end -->

    <?php endif;
}
/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function norcanna_pingback_header() {
    if ( is_singular() && pings_open() ) {
        printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
    }
}
add_action( 'wp_head', 'norcanna_pingback_header' );


if(isset($_POST['mailchimp_email']) && !empty($_POST['mailchimp_email'])){

    $api_key = get_field('api_key', 'option');
    $list_id = get_field('list_id', 'option');

    $email = isset($_POST['mailchimp_email']) ? $_POST['mailchimp_email'] : '';

    $status = 'subscribed';
    if($email) {
        $data = array(
            'apikey'        => $api_key,
            'email_address' => $email,
            'status'     => $status
        );

        // URL to request
        $API_URL =   'https://' . substr($api_key,strpos($api_key,'-') + 1 ) . '.api.mailchimp.com/3.0/lists/' . $list_id . '/members/' . md5(strtolower($data['email_address']));

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $API_URL);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: Basic '.base64_encode( 'user:'.$api_key )));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data) );
        $result = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($result);

        if( $response->status == 400 ){
            foreach( $response->errors as $error ) {
                $msg = 'Error: ' . $error->message . '<br>';
            }
        } elseif( $response->status == 'subscribed' ){
            $msg = 'Thank you. You have already subscribed.';
        }elseif( $response->status == 'pending' ){
            $msg = 'You subscription is Pending. Please check your email.';
        }
    }
}

add_filter( 'woocommerce_add_to_cart_fragments', 'norcanna_cart_count_fragments', 10, 1 );
function norcanna_cart_count_fragments( $fragments ) {
    if(WC()->cart->get_cart_contents_count() > 0) {
        $fragments['span.contcon'] = '<span class="contcon"><span class="badge"></span></span>';
        $fragments['span.items-count'] = '<span class="items-count">'.WC()->cart->get_cart_contents_count().'</span>';

        $output = '';

        $output .= '<div class="product-items-wrapper">';
        global $woocommerce;
        $items = $woocommerce->cart->get_cart();
        $total_amount = $woocommerce->cart->cart_contents_total+$woocommerce->cart->tax_total;
        foreach($items as $item => $values) {
            $product_id = apply_filters( 'woocommerce_cart_item_product_id', $values['product_id'], $values, $item );
            $_product =  wc_get_product( $values['data']->get_id());
            $price = get_post_meta($values['product_id'] , '_price', true);

            $output .= '<div class="mini-pro-item position-relative d-block">
                <a href="'.$_product->get_permalink().'" class="mini-pro-thumb">';

            $image = wp_get_attachment_image_src( get_post_thumbnail_id( $values['data']->get_id() ), 'full' );

            $output .= '<img src="'.$image[0].'" class="img-fluid" alt="">
                    <p class="mini-title d-inline-block">';
            $catIds = $_product->get_category_ids();
            $category_name = [];
            if(!empty($catIds)){
                foreach ($catIds as $cat_id){
                    $trm = get_term_by( 'id',  $cat_id, 'product_cat' );
                    $category_name[] = $trm->name;
                }
            }
            $output .= '<span>'.implode(',',$category_name).'</span>
                        '.$_product->get_title().'
                    </p>
                </a>
                <div  class="mini-qty text-right d-flex align-items-center justify-content-end">
                    <span class="mb-0 mini-price">'.get_woocommerce_currency_symbol().''.$price.'</span>
                    <span class="d-inline-block input-qty-fix">
                        <span class="input-group-btn">
                            <button type="button" class="quantity-left-minus"  data-type="minus" data-field="">+</button>
                        </span>
                        <input type="text" id="quantity" name="quantity" class="input-number" value="'.$values['quantity'].'" min="1" max="100">
                        <span class="input-group-btn">
                            <button type="button" class="quantity-right-plus" data-type="plus" data-field="">-</button>
                        </span>
                    </span>
                </div>
                <span class="mini-pro-remove">';

            $output .= apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
                '<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s"><i class="fa fa-remove"></i></a>',
                esc_url( wc_get_cart_remove_url( $item ) ),
                __( 'Remove this item', 'norcanna' ),
                esc_attr( $product_id ),
                esc_attr( $_product->get_sku() )
            ), $item );
            $output .= '</span>
                <div class="clearfix"></div>
            </div>';

        }
        $output .= '<div class="oder-delivery">
                <p>
                    <span>Order</span>
                    <span class="float-right">'.$woocommerce->cart->get_cart_subtotal().'</span>
                </p>
                <p>
                    <span>Delivery</span>
                    <span class="float-right">Free</span>
                </p>
            </div>
            
            <div class="total-amount">
                <p>
                    <span>Total Amount</span>
                    <span class="float-right">'.get_woocommerce_currency_symbol().''.number_format($total_amount, 2, '.', '').'</span>
                </p>
            </div>';

        if ( is_user_logged_in() ) {
            $user_id = get_current_user_id();
            $shipping_address = cus_get_formatted_shipping_address($user_id);
            $shipping_address = trim($shipping_address);
            if(!empty($shipping_address)):

                $output .= '<div class="delivery-address position-relative">
                        <a href="'.get_permalink( get_option('woocommerce_myaccount_page_id') ).'edit-address/shipping/"><i class="fa fa-edit"></i></a>
                        <img src="'.URL.'/images/delivery-address-icon.png" class="img-fluid rounded" />
                        <div class="del-add-fix">
                            <h6>Delivery Address</h6>
                            <p>'.$shipping_address.'</p>
                        </div>
                    </div>';
            endif;
        };
        $output .= '</div>';

        $fragments['div.product-items-wrapper'] = $output;

        $fragments['div.checkoutBtn'] = '<div class="checkoutBtn ml-lg-auto ml-sm-auto ml-auto"><a href="'.get_permalink( wc_get_page_id( 'checkout' ) ).'" class="btn orange text-uppercase mt-2">CHECKOUT</a></div>';

    }else{
        $fragments['span.contcon'] = '<span class="contcon"></span>';
        $fragments['span.items-count'] = '<span class="items-count">0</span>';
    }
    return $fragments;
}

function norcanna_add_woocommerce_support() {
    add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'norcanna_add_woocommerce_support' );

function woocommerce_template_product_reviews() {
    wc_get_template( 'single-product-reviews.php' );
}
add_action( 'woocommerce_after_single_product_summary', 'woocommerce_template_product_reviews', 50 );

add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );
function woo_remove_product_tabs( $tabs ) {
    //echo '<pre>';
    //print_r($tabs);
    // echo '</pre>';
    unset( $tabs['reviews'] );  // Removes the reviews tab
    unset( $tabs['description'] );  // Removes the description tab
    unset( $tabs['additional_information'] );  // Removes the additional information tab
    return $tabs;
}

function add_review_name_field_on_comment_form() {
    echo '<p class="reviewer-name"><label for="name">' . __( 'Name', 'norcanna' ) . '</label><input class="input" type="text" name="reviewer_name" id="reviewer_name"/></p>';
}
add_action( 'comment_form_logged_in_after', 'add_review_name_field_on_comment_form' );
add_action( 'comment_form_after_fields', 'add_review_name_field_on_comment_form' );

add_filter('woocommerce_variable_price_html', 'custom_variation_price', 10, 2);
function custom_variation_price( $price, $product ) {
    $available_variations = $product->get_available_variations();
    $selectedPrice = '';

    //$count = count($available_variations);

    //foreach ( $available_variations as $variation )
    //{
    $variation = $available_variations[0];
    $price = $variation['display_price'];
    //break;

    //}
    $selectedPrice = wc_price($price);

    return $selectedPrice;
}

function get_attribute_name($product){
    $available_variations = $product->get_available_variations();

    //$count = count($available_variations);
    $attribute_name = '';
    //foreach ( $available_variations as $variation )
    //{
    $variation = $available_variations[0];
    foreach (wc_get_product($variation['variation_id'])->get_variation_attributes() as $attr) {
        $attribute_name = wc_attribute_label( $attr );
    }
    //break;
    //}
    return $attribute_name;
}
function load_category_products_ajax() {

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

    $paged = $_POST['page'];

    $load_terms = get_terms(array(
        'taxonomy' => 'product_cat',
        'hide_empty' => true,
        'exclude' => $select_offering_category,
        'number' => 3,
        'parent' => 0,
        'offset' => $paged * 3
    ));

    if(!empty($load_terms)) :
        $output = '';
        foreach ($load_terms as $load_term):
            $termObject = get_term_by('id', $load_term->term_id, 'product_cat');

            $args = array(
                'post_type'             => 'product',
                'post_status'           => 'publish',
                'posts_per_page'        => -1,
                'tax_query'             => array(
                    array(
                        'taxonomy'      => 'product_cat',
                        'field' => 'term_id',
                        'terms'         => $load_term->term_id,
                        'operator'      => 'IN'
                    )
                )
            );
            $products = new WP_Query($args);

            $output .= '<div class="row" data-catId="'.$load_term->term_id.'">
            <div class="col-12">
                <header class="woocommerce-products-header">
                    <h5 class="woocommerce-products-header__title page-title">'.$termObject->name.'</h5>
                </header>';
            if($products->post_count > 0):
                $className = 'category-slider-ajax-'.$paged;

                $output .= '<ul class="products columns-4 category-slider category-slider-ajax-'.$paged.' text-center">';
                while ( $products->have_posts() ) : $products->the_post();
                    global $product;
                    $output .= '<li class="post-'.$product->get_id().' product type-product status-publish entry instock instock shipping-taxable purchasable product-type-'.$product->get_type().'">
                                <a href="'.$product->get_permalink().'"
                                   class="woocommerce-LoopProduct-link woocommerce-loop-product__link" data-pid="'.$product->get_id().'">
                                    '.$product->get_image('woocommerce_thumbnail').'
                                    <h2 class="woocommerce-loop-product__title">'.$product->get_name().'';
                    if($product->get_type() == 'variable'):
                        $attribute_name = get_attribute_name($product);

                        $output .= '&nbsp; - &nbsp;'.str_replace('-',' ',$attribute_name).'';
                    endif;
                    $output .= '</h2>
        
                                    <span class="price">'.$product->get_price_html().'</span>
                                </a>
                                <a href="'.$product->add_to_cart_url().'" data-quantity="1"
                                   class="button product_type_'.$product->get_type().' add_to_cart_button ajax_add_to_cart"
                                   data-product_id="'.$product->get_id().'" data-product_sku="" aria-label="Add “Product” to your cart"
                                   rel="nofollow"> <img class="shop-icon" src="'.URL.'/images/cart-icon.png" alt=""> Add to cart</a>
                            </li>';
                endwhile;
                $output .= '</ul>';
            endif;
            $output .= '</div>
        </div>';
        endforeach;
    endif;
    echo json_encode(array('output' => $output, 'className' => $className));
    exit();
}


add_action('wp_ajax_load_category_products_ajax', 'load_category_products_ajax');
add_action('wp_ajax_nopriv_load_category_products_ajax', 'load_category_products_ajax');


function load_shop_page_category_products_ajax() {

    $terms = get_terms(array(
        'taxonomy' => 'product_cat',
        'hide_empty' => true,
        'number' => 3,
        'parent' => 0
    ));
    $exclude_categories = wp_list_pluck($terms, 'term_id');


    $paged = $_POST['page'];

    $load_terms = get_terms(array(
        'taxonomy' => 'product_cat',
        'hide_empty' => true,
        'exclude' => $exclude_categories,
        'number' => 3,
        'parent' => 0,
        'offset' => $paged * 3
    ));

    if(!empty($load_terms)) :
        $output = '';
        foreach ($load_terms as $load_term):
            $termObject = get_term_by('id', $load_term->term_id, 'product_cat');

            $args = array(
                'post_type'             => 'product',
                'post_status'           => 'publish',
                'posts_per_page'        => -1,
                'tax_query'             => array(
                    array(
                        'taxonomy'      => 'product_cat',
                        'field' => 'term_id',
                        'terms'         => $load_term->term_id,
                        'operator'      => 'IN'
                    )
                )
            );
            $products = new WP_Query($args);

            $output .= '<div class="row" data-catId="'.$load_term->term_id.'">
            <div class="col-12">
                <header class="woocommerce-products-header clearfix">
                    <h5 class="woocommerce-products-header__title page-title">'.$termObject->name.'</h5>
                </header>';
            if($products->post_count > 0):
                $className = 'category-slider-ajax-'.$paged;

                $output .= '<ul class="products columns-4 pr-category-slider category-slider-ajax-'.$paged.' text-center">';
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

                    $output .= '<li class="post-'.$product->get_id().' product type-product status-publish product-type-'.$product->get_type().'" data-catids="'.implode(',',$catIds).'">
                        <a href="'.$product->get_permalink().'"
                           class="woocommerce-LoopProduct-link woocommerce-loop-product__link" data-pid="'.$product->get_id().'">
                            <div class="media">
                                '.$product->get_image('woocommerce_thumbnail').'
                                <div class="media-body">
                                    <h4 class="mt-0">'.$product->get_name().'';if($product->get_type() == 'variable'):
                        $attribute_name = get_attribute_name($product);
                        $output .= '&nbsp; - &nbsp;'.str_replace('-',' ',$attribute_name).'';
                    endif;
                    $output .= '</h4>
                                    <h5 class="mt-0">'.implode(', ',$category_name).'</h5>
                                    <h6 class="mt-0">'.$product->get_price_html().'</h6>
                                </div>
                            </div>

                        </a>
                        <a href="'.$product->add_to_cart_url().'" data-quantity="1"
                           class="button product_type_'.$product->get_type().' add_to_cart_button ajax_add_to_cart"
                           data-product_id="'.$product->get_id().'" data-product_sku="'.$product->get_id().'" aria-label="Add “Product” to your cart"
                           rel="nofollow"><i class="fa fa-plus" aria-hidden="true"></i>
                        </a>
                    </li>';
                endwhile;
                $output .= '</ul>';
            endif;
            $output .= '</div>
        </div>';
        endforeach;
    endif;
    echo json_encode(array('output' => $output, 'className' => $className));
    exit();
}


add_action('wp_ajax_load_shop_page_category_products_ajax', 'load_shop_page_category_products_ajax');
add_action('wp_ajax_nopriv_load_shop_page_category_products_ajax', 'load_shop_page_category_products_ajax');


function load_category_by_id() {

    $catId = $_POST['catId'];
    if(empty($catId)){
        $select_offering_category = get_field('select_offering_category', 'option');
        if(empty($select_offering_category)) :
            $terms = get_terms(array(
                'taxonomy' => 'product_cat',
                'hide_empty' => true,
                'number' => 3
            ));
            $select_offering_category = wp_list_pluck($terms, 'term_id');
        endif;
    }else{
        $select_offering_category = array($catId);
    }

    if(!empty($select_offering_category)) :
        $output = '';
        foreach ($select_offering_category as $term_id):
            $termObject = get_term_by('id', $term_id, 'product_cat');

            $args = array(
                'post_type'             => 'product',
                'post_status'           => 'publish',
                'posts_per_page'        => -1,
                'tax_query'             => array(
                    array(
                        'taxonomy'      => 'product_cat',
                        'field' => 'term_id',
                        'terms'         => $term_id,
                        'operator'      => 'IN'
                    )
                )
            );
            $products = new WP_Query($args);

            $output .= '<div class="row" data-catId="'.$term_id.'">
            <div class="col-12">
                <header class="woocommerce-products-header">
                    <h5 class="woocommerce-products-header__title page-title">'.$termObject->name.'</h5>
                </header>';
            if($products->post_count > 0):
                $output .= '<ul class="products columns-4 category-slider category-slider-ajax text-center">';
                while ( $products->have_posts() ) : $products->the_post();
                    global $product;
                    $output .= '<li class="post-'.$product->get_id().' product type-product status-publish entry instock instock shipping-taxable purchasable product-type-'.$product->get_type().'">
                                <a href="'.$product->get_permalink().'"
                                   class="woocommerce-LoopProduct-link woocommerce-loop-product__link" data-pid="'.$product->get_id().'">
                                    '.$product->get_image('woocommerce_thumbnail').'
                                    <h2 class="woocommerce-loop-product__title">'.$product->get_name().'';
                    if($product->get_type() == 'variable'):
                        $attribute_name = get_attribute_name($product);

                        $output .= '&nbsp; - &nbsp;'.str_replace('-',' ',$attribute_name).'';
                    endif;
                    $output .= '</h2>
        
                                    <span class="price">'.$product->get_price_html().'</span>
                                </a>
                                <a href="'.$product->add_to_cart_url().'" data-quantity="1"
                                   class="button product_type_'.$product->get_type().' add_to_cart_button ajax_add_to_cart"
                                   data-product_id="'.$product->get_id().'" data-product_sku="" aria-label="Add “Product” to your cart"
                                   rel="nofollow"> <img class="shop-icon" src="'.URL.'/images/cart-icon.png" alt=""> Add to cart</a>
                            </li>';
                endwhile;
                $output .= '</ul>';
            endif;
            $output .= '</div>
        </div>';
        endforeach;
    endif;
    echo json_encode(array('output' => $output));
    exit();
}


add_action('wp_ajax_load_category_by_id', 'load_category_by_id');
add_action('wp_ajax_nopriv_load_category_by_id', 'load_category_by_id');

function enqueue_admin_script($hook) {
    wp_register_style( 'fancybox_css', 'https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.6/jquery.fancybox.min.css', false );
    wp_enqueue_style( 'fancybox_css' );

    wp_enqueue_script( 'admin_custom_script', get_template_directory_uri() . '/js/admin-script.js' );
    wp_enqueue_script( 'fancybox_js', 'https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.6/jquery.fancybox.min.js' );
}

add_action( 'admin_enqueue_scripts', 'enqueue_admin_script' );

function modify_user_table_column( $column ) {
    $column['status'] = 'Status';
    return $column;
}
add_filter( 'manage_users_columns', 'modify_user_table_column' );

function modify_user_table_row( $val, $column_name, $user_id ) {
    switch ($column_name) {
        case 'status' :
            $user_meta=get_userdata($user_id);
            $user_roles=$user_meta->roles;

            if($user_roles[0] != 'administrator'):
                $status = get_user_meta($user_id, 'status', true);
                if($status === 'unapproved') {
                    $output = '<span style="color:red">Unapproved</span>';
                }
                if($status === 'active') {
                    $output = '<span style="color:green">Active</span>';
                }
                if($status === 'inactive') {
                    $output = '<span style="color:purple">Inactive</span>';
                }

                /*$output = '<select name="user_status" id="user_status" data-uid="'.$user_id.'">
                    <option value="unapproved"';
                if($status === 'unapproved'){
                    $output .= ' selected';
                }
                $output .= '>Unapproved</option>
                    <option value="active"';
                if($status === 'active'){
                    $output .= ' selected';
                }
                $output .= '>Active</option>
                    <option value="inactive"';
                if($status === 'inactive'){
                    $output .= ' selected';
                }
                $output .= '>Inactive</option>
                </select>';*/
                return $output;
            endif;
            break;
        default:
    }
    return $val;
}
add_filter( 'manage_users_custom_column', 'modify_user_table_row', 10, 3 );

function change_user_status(){
    $status = $_POST['status'];
    $uid = $_POST['uid'];
    $userdata = get_userdata( $uid );
    $user_email = $userdata->user_email;
    //$user_email = 'developer2@puredevs.com';

    $full_name = get_user_meta($uid, 'full_name', true);

    update_user_meta( $uid, 'status', $status );

    if($status == 'active') {
        $approve_notification_email_send = get_field('approve_notification_email_send', 'option');
        if ($approve_notification_email_send) {
            $subject = 'Account approved.';
            $message = get_email_template('template-parts/email/user-approve-email');
            $u_args = array(
                'full_name' => $full_name
            );
            send_email_notification($user_email, $subject, $message, $u_args);
        }

        //Send SMS

        $allow_text_message = get_user_meta($uid, 'allow_text_message', true);
        $user_phone = get_user_meta($uid, 'user_phone', true);

        $send_sms = get_field('send_sms','option');
        if($send_sms == 'All Users' && $allow_text_message == 1) {
            $user_message = get_field('sms_text_for_approve_account','option');
            send_msg_notification($user_phone, $user_message);
        }
    }

    //Send SMS

    if($status == 'inactive') {
        $allow_text_message = get_user_meta($uid, 'allow_text_message', true);
        $user_phone = get_user_meta($uid, 'user_phone', true);

        $send_sms = get_field('send_sms','option');
        if($send_sms == 'All Users' && $allow_text_message == 1) {
            $user_message = get_field('sms_text_when_inactive_user','option');
            send_msg_notification($user_phone, $user_message);
        }
    }

    echo json_encode(array('status' => 1));
    exit();
}

add_action('wp_ajax_change_user_status', 'change_user_status');
add_action('wp_ajax_nopriv_change_user_status', 'change_user_status');

function register_user_notice() {
    global $pagenow;
    $inactiveusers = new WP_User_Query( array( 'meta_key' => 'status', 'meta_value' => 'inactive', 'meta_compare' => '=' ) );
    $upapprovedusers = new WP_User_Query( array( 'meta_key' => 'status', 'meta_value' => 'unapproved', 'meta_compare' => '=' ) );

    if($inactiveusers->get_total() > 0) {
        ?>
        <div class="notice-info notice">
            <p><?php _e('Please check inactive users <a href="' . admin_url('users.php?role=subscriber&status=inactive') . '">here!</a>', 'norcanna'); ?></p>
        </div>
        <?php
    }

    if($upapprovedusers->get_total() > 0) {
        ?>
        <div class="notice-error notice">
            <p><?php _e('You have new register users on your site! Please approve from <a href="' . admin_url('users.php?role=subscriber&status=unapproved') . '">here!</a>', 'norcanna'); ?></p>
        </div>
        <?php
    }
}
add_action( 'admin_notices', 'register_user_notice' );

function filter_users_by_status($query)
{
    global $pagenow;
    if (is_admin() && 'users.php' == $pagenow) {
        if(isset($_GET['status'])){
            $meta_query = array(
                array(
                    'key' => 'status',
                    'value' => $_GET['status']
                )
            );
            $query->set( 'meta_key', 'status' );
            $query->set( 'meta_query', $meta_query );

            $query->query_vars['orderby'] = 'user_registered';
            $query->query_vars['order']   = 'DESC';

        }

        if(isset($_GET['approve_user']) && wp_verify_nonce( $_GET['_wpnonce'], 'approve-user' )) {
            update_user_meta( $_GET['approve_user'], 'status', 'active' );
            $userdata = get_userdata( $_GET['approve_user'] );
            $user_email = $userdata->user_email;
            //$user_email = 'developer2@puredevs.com';
            $sub = get_field('approve_notification_email_subject','option');
            $subject = $sub ? $sub : 'Account approved.';
            $message = get_email_template('template-parts/email/user-approve-email');
            $full_name = get_user_meta($_GET['approve_user'], 'full_name', true);
            $u_args = array(
                'full_name' => $full_name
            );

            send_email_notification($user_email, $subject, $message, $u_args);

            //Send SMS

            $allow_text_message = get_user_meta($_GET['approve_user'], 'allow_text_message', true);
            $user_phone = get_user_meta($_GET['approve_user'], 'user_phone', true);

            $send_sms = get_field('send_sms','option');
            if($send_sms == 'All Users' && $allow_text_message == 1) {
                $user_message = get_field('sms_text_for_approve_account','option');
                send_msg_notification($user_phone, $user_message);
            }
        }
    }
}
add_filter('pre_get_users', 'filter_users_by_status');

/*function authentication_check($username, $password ) {
    if (!empty($username) && !empty($password)) {
        echo $username;
        echo $password;
        $user = get_user_by( 'email', $username );
        echo '<pre>';
        print_r($user);
        echo '</pre>';
        echo $status = get_user_meta($user->ID, 'status', true);
        die();
    }
}
add_action('wp_authenticate', 'authentication_check', 30, 2);*/

function custom_auth_signon( $user, $username, $password ) {

    if ($user instanceof WP_User) {
        $status = get_user_meta($user->ID, 'status', true);
        $user_data = get_userdata( $user->ID );
        $user_roles = $user_data->roles;
        if($user_roles[0] != 'administrator'):
            if ($status != 'active') {
                return new WP_Error('on_hold_error', 'Your account is not approve yet!');
            }
        endif;
    }
    return $user;
}
add_filter( 'authenticate', 'custom_auth_signon', 30, 3 );

function save_registration_data(){
    global $wpdb;
    $table_registration = $wpdb->prefix . 'registration_step_data';

    $full_name = sanitize_text_field($_POST['fname']);
    $birth_date = sanitize_text_field($_POST['birthdate']);
    $user_email = sanitize_text_field($_POST['email']);
    $user_phone = sanitize_text_field($_POST['phone']);
    $zip_code = sanitize_text_field($_POST['zipcode']);
    $user_password = sanitize_text_field($_POST['userpassword']);
    $address = sanitize_text_field($_POST['address']);
    $front_side = $_POST['front_side'];
    $back_side = $_POST['back_side'];
    $medical_id = $_POST['medical_id'];
    $photo_id = $_POST['photo_id'];
    $allow_text_message = $_POST['allow_text_message'];
    $expired_date = $_POST['expired_date'];

    if (!empty($full_name))
        $user_name = preg_replace('/\s+/', '', $user_email);

    $user_id = username_exists($user_name);
    if (!$user_id && email_exists($user_email) == false) {
        $userdata = array(
            'user_pass' => $user_password,
            'user_login' => $user_name,
            'user_email' => $user_email,
            'display_name' => $full_name,
            'role' => 'subscriber'
        );
        $user_id = wp_insert_user($userdata);
        if ($user_id) {
            update_user_meta($user_id, 'full_name', $full_name);
            update_user_meta($user_id, 'birth_date', $birth_date);
            update_user_meta($user_id, 'user_phone', $user_phone);
            update_user_meta($user_id, 'zip_code', $zip_code);
            update_user_meta($user_id, 'address', $address);
            update_user_meta($user_id, 'front_side', $front_side);
            update_user_meta($user_id, 'back_side', $back_side);
            update_user_meta($user_id, 'medical_id', $medical_id);
            update_user_meta($user_id, 'photo_id', $photo_id);
            update_user_meta($user_id, 'allow_text_message', $allow_text_message);
            update_user_meta($user_id, 'expired_date', $expired_date);
            update_user_meta($user_id, 'status', 'unapproved');
            update_user_meta($user_id, 'registered_on', date('Y-m-d H:i:s'));

            $registration_notification_email_send = get_field('registration_notification_email_send','option');
            if($registration_notification_email_send) {
                $send_to_admin = get_field('admin_email','option');
                if(empty($send_to_admin))
                    $send_to_admin = get_option('admin_email');
                $send_to_user = $user_email;
                $nonce = wp_create_nonce( 'approve-user' );
                //$send_to_admin = 'developer2@puredevs.com';
                //$send_to_user = 'assad@puredevs.com';
                $admn_subject = get_field('registration_email_subject_to_admin','option');
                $admin_subject = $admn_subject ? $admn_subject : 'New user registration';
                $usr_subject = get_field('registration_email_subject_to_user','option');
                $user_subject = $usr_subject ? $usr_subject : 'Registration complete';

                $admin_message = get_email_template('template-parts/email/admin-register-email');
                $user_message = get_email_template('template-parts/email/user-register-email');

                $user_list_page = admin_url('users.php');
                $a_args = array(
                    'user_id' => $user_id,
                    'nonce' => $nonce,
                    'user_list_page' => $user_list_page
                );

                $u_args = array(
                    'full_name' => $full_name
                );

                send_email_notification($send_to_admin, $admin_subject, $admin_message, $a_args);
                send_email_notification($send_to_user, $user_subject, $user_message, $u_args);

            }
            //Send SMS
            $send_sms = get_field('send_sms','option');
            if($send_sms == 'All Users' && $allow_text_message == 1) {
                $user_message = get_field('sms_text_for_registration','option');
                send_msg_notification($user_phone, $user_message);
            }

            $wpdb->delete(
                $table_registration,
                array(
                    'user_email' => $user_email
                ),
                array(
                    '%s'
                )
            );

            echo json_encode(array('status' => 1));
        } else {
            echo json_encode(array('status' => 2));
        }
    } else {
        echo json_encode(array('status' => 3));
    }
    exit();
}

add_action('wp_ajax_nopriv_save_registration_data', 'save_registration_data');

function norcanna_validate_email_function(){
    $email = sanitize_text_field($_POST['email']);
    $response = array(
        'status'=>'success'
    );
    if(email_exists($email) || username_exists($email)){
        $response['status'] = 'error';
    }
    wp_send_json($response);
}

add_action('wp_ajax_nopriv_norcanna_validate_email', 'norcanna_validate_email_function');
add_action('wp_ajax_norcanna_validate_email', 'norcanna_validate_email_function');

function get_email_template($template){
    ob_start();
    get_template_part( $template );
    return ob_get_clean();
}

function check_authentication(){
    $logname = sanitize_text_field($_POST['logname']);
    $pwd = sanitize_text_field($_POST['pwd']);

    //$user = get_user_by( 'email', $logname );
    $user = get_user_by( 'login', $logname );

    $status = get_user_meta($user->ID, 'status', true);

    if ((isset($status) && $status == 'active') || $user->roles[0] == 'administrator') {
        $user_id = username_exists($logname);
        if($user_id && wp_check_password( $pwd, $user->data->user_pass, $user->ID)){
            echo json_encode(array('status' => 1));
        } else {
            echo json_encode(array('status' => 3));
        }
    } else {
        if(isset($status))
            echo json_encode(array('status' => 3));
        else
            echo json_encode(array('status' => 2));
    }
    exit();
}

add_action('wp_ajax_nopriv_check_authentication', 'check_authentication');

function cus_get_formatted_shipping_address($user_id) {

    $address = '';
    $address .= get_user_meta( $user_id, 'shipping_address_1', true );
    $address .= " ";
    $address .= get_user_meta( $user_id, 'shipping_address_2', true );
    $address .= " ";
    $address .= get_user_meta( $user_id, 'shipping_city', true );
    $address .= " ";
    $address .= get_user_meta( $user_id, 'shipping_state', true );
    $address .= " ";
    $address .= get_user_meta( $user_id, 'shipping_postcode', true );
    $address .= " ";
    $address .= get_user_meta( $user_id, 'shipping_country', true );

    return $address;
}

function save_registration_first_step_data(){
    global $wpdb;
    $table_registration = $wpdb->prefix . 'registration_step_data';
    $values = array();
    parse_str($_POST['formdata'], $values);
    $formdata = serialize($values);
    $email = $_POST['email'];
    $email_exist = $wpdb->get_var("SELECT id FROM $table_registration WHERE user_email='$email'");
    if($email_exist != NULL){
        $wpdb->update(
            $table_registration,
            array(
                'form_data' => $formdata,
                'status' => 0
            ),
            array( 'user_email' => $email ),
            array(
                '%s',
                '%d'
            ),
            array( '%s' )
        );
    }else{
        $res = $wpdb->insert(
            $table_registration,
            array(
                'user_email' => $email,
                'form_data' => $formdata,
                'status' => 0
            ),
            array(
                '%s',
                '%s',
                '%d'
            )
        );
    }
    echo json_encode(array('status' => 1));
    exit();
}

add_action('wp_ajax_nopriv_save_registration_first_step_data', 'save_registration_first_step_data');

function add_my_custom_schedule( $schedules ) {
    $schedules['every_five_minutes'] = array(
        'interval' => 300,
        'display' => __('Once every five minutes')
    );
    return $schedules;
}
add_filter( 'cron_schedules', 'add_my_custom_schedule' );

add_action('init','check_cron_schedule', 99);
function check_cron_schedule(){
    //echo wp_next_scheduled( 'send_pending_notification_email' );
    //echo wp_clear_scheduled_hook('send_pending_notification_email');die();
    if ( !wp_next_scheduled( 'send_pending_notification_email' ) ) {
        wp_schedule_event(time(), 'twicedaily', 'send_pending_notification_email');
    }
}

add_action('send_pending_notification_email','send_user_notification_email');

function send_user_notification_email(){
    global $wpdb;
    $table_registration = $wpdb->prefix . 'registration_step_data';
    $sql = "SELECT * FROM $table_registration WHERE status = 0";
    $results = $wpdb->get_results( $sql );

    if(!empty($results)){
        $sub = get_field('user_reminder_email_subject','option');
        $subject = $sub ? $sub : 'Reminder!';
        $message = get_email_template('template-parts/email/user-reminder-email');
        $home_url = get_bloginfo('url');
        $nonce = wp_create_nonce( 'back-user' );
        foreach ($results as $res){
            $id = $res->id;
            $user_email = $res->user_email;
            $form_data = unserialize($res->form_data);
            $status = $res->status;
            $a_args = array(
                'home_url' => $home_url,
                'full_name' => $form_data['full-name'],
                'res_id' => $id,
                'nonce' => $nonce,
            );
            send_email_notification($user_email, $subject, $message, $a_args);

            //Send SMS

            $allow_text_message = $form_data['allow_text_message'];
            $user_phone = $form_data['phone'];

            $send_sms = get_field('send_sms','option');
            if($send_sms == 'All Users' && $allow_text_message == 1) {
                $user_message = get_field('reminder_text_for_registration','option');
                send_msg_notification($user_phone, $user_message);
            }

            $wpdb->update(
                $table_registration,
                array(
                    'status' => 1
                ),
                array( 'id' => $id ),
                array(
                    '%d'
                ),
                array( '%d' )
            );
        }
    }
}

function change_view_link( $actions, $user_object ) {
    if ( current_user_can( 'administrator', $user_object->ID ) ) {
        $actions['view'] = '<a href="'.get_edit_user_link($user_object->ID).'">View</a>';
    }
    return $actions;
}

add_filter( 'user_row_actions', 'change_view_link', 10, 2 );

// Apply filter
add_filter('body_class', 'add_custom_body_classes');

function add_custom_body_classes($classes) {
    if(is_shop()){
        $classes[] = 'shop-page';
    }
    return $classes;
}

add_action('wp_ajax_nopriv_product_filter_action', 'shop_page_filter_function');
add_action('wp_ajax_product_filter_action', 'shop_page_filter_function');

function shop_page_filter_function() {
    $data = array();
	parse_str($_POST['data'], $data);
	$response = array();
	$response['status'] = 'success';
    $args = array(
        'post_type'             => 'product',
        'post_status'           => 'publish',
        'posts_per_page'        => -1
    );
	if(empty($data['parent-cat'])){
		$response['status'] = 'error';
		$response['html'] = '<p>No data matched your criteria.</p>';
		wp_send_json($response);
    }
	$parent_cats = $data['parent-cat'];

	//$category_shown = $data['cat_shown'];
	$category_shown = $_POST['cat_shown'];
    $added_cat = 1;
    $output = '';
	foreach ($parent_cats as $index => $parent_cat){
        $termObject = get_term_by('id', $parent_cat, 'product_cat');
        $meta_query = array(
            'relation' => 'AND',
        );
        $tax_query = [];

        if($index < $category_shown && $category_shown != 0)
            continue;

        if($added_cat > 3){
            break;
        }

        $added_cat++;


	    /*if($index < $category_shown)
	        continue;
	    if($added_cat > 3){
	        break;
        }
	    $child_cats = $data['cat-' . $parent_cat];

		$added_cat++;*/

        $child_cats = $data['cat-' . $parent_cat];

	    if(isset($data['cat-' . $parent_cat])){

            $tax_query[] = array(
                'taxonomy' => 'product_cat',
                'field' => 'term_id',
                'terms' => $child_cats,
                'operator' => 'AND'
            );
        }else{
            $tax_query[] = array(
                'taxonomy' => 'product_cat',
                'field' => 'term_id',
                'terms' => $parent_cat,
                'operator' => 'IN'
            );
        }

        $meta_args_2 = array(
            'key' => '_price',
            'value' => array($data['pr_first'],$data['pr_last']),
            'compare' => 'BETWEEN',
            'type' => 'NUMERIC'
        );
        $meta_query[] = $meta_args_2;

        if(isset($data['pr-srength']) && !empty($data['pr-srength'])) {
            $meta_args_1 = array(
                'relation' => 'OR',
            );
            foreach ($data['pr-srength'] as $strength){
                $meta_args_1[] = array(
                    'key' => 'strength',
                    'value' => ''.$strength.'',
                    'compare' => '=',
                );
            }
            $meta_query[] = $meta_args_1;
        }
        $args['meta_query'] =  $meta_query;
        $args['tax_query'] =  $tax_query;

        //echo '<pre>';
        //print_r($args);
        //echo '</pre>';

        $products = new WP_Query($args);
        if ($products->post_count > 0):
            $output .= '<div class="row">
                <div class="col-12">
                    <header class="woocommerce-products-header clearfix">
                        <h5 class="woocommerce-products-header__title page-title">' . $termObject->name . '</h5>
                    </header>';
                    if ($products->post_count > 0):
                        $className = 'category-slider-ajax-' . $category_shown;

                        $output .= '<ul class="products columns-4 pr-category-slider category-slider-ajax-' . $category_shown . ' text-center">';
                        while ($products->have_posts()) : $products->the_post();
                            global $product;
                            $catIds = $product->get_category_ids();
                            $category_name = [];
                            if (!empty($catIds)) {
                                foreach ($catIds as $cat_id) {
                                    $trm = get_term_by('id', $cat_id, 'product_cat');
                                    $category_name[] = $trm->name;
                                }
                            }

                            $output .= '<li class="post-' . $product->get_id() . ' product type-product status-publish product-type-' . $product->get_type() . '">
                            <a href="' . $product->get_permalink() . '"
                               class="woocommerce-LoopProduct-link woocommerce-loop-product__link" data-pid="'.$product->get_id().'">
                                <div class="media">
                                    ' . $product->get_image('woocommerce_thumbnail') . '
                                    <div class="media-body">
                                        <h4 class="mt-0">' . $product->get_name() . '';
                            if ($product->get_type() == 'variable'):
                                $attribute_name = get_attribute_name($product);
                                $output .= '&nbsp; - &nbsp;' . str_replace('-', ' ', $attribute_name) . '';
                            endif;
                            $output .= '</h4>
                                        <h5 class="mt-0">' . implode(', ', $category_name) . '</h5>
                                        <h6 class="mt-0">' . $product->get_price_html() . '</h6>
                                    </div>
                                </div>
        
                            </a>
                            <a href="' . $product->add_to_cart_url() . '" data-quantity="1"
                               class="button product_type_' . $product->get_type() . ' add_to_cart_button ajax_add_to_cart"
                               data-product_id="' . $product->get_id() . '" data-product_sku="' . $product->get_id() . '" aria-label="Add “Product” to your cart"
                               rel="nofollow"><i class="fa fa-plus" aria-hidden="true"></i>
                            </a>
                        </li>';
                        endwhile;
                        $output .= '</ul>';
                    endif;
                    $output .= '</div>
            </div>';
        endif;
    }
    $response['status'] = 'success';
    $response['className'] = $className;
    $response['html'] = $output;

	wp_send_json($response);
}

add_action('save_post_product', 'sync_on_product_save', 10, 3);
function sync_on_product_save( $post_id, $post, $update ) {
    $product = wc_get_product( $post_id );

    $price = get_post_meta($product->get_id(), '_price', true);
    if($price){
    }else{
        $price = $_POST['_regular_price'];
    }

    $first_val = get_option('first_val');
    $last_val = get_option('last_val');
    if(empty($first_val)){
        update_option( 'first_val', $price );
        update_option( 'last_val', $price );
    }
    if($price < $first_val){
        update_option( 'first_val', $price );
    }

    if($price > $last_val){
        update_option( 'last_val', $price );
    }
}

function load_single_product(){
    $pid = $_POST['pid'];
    $response = array(
        'status'=>'success'
    );
    $product = wc_get_product( $pid );

    $output = '<div id="product-'.$product->get_id().'" class="post-'.$product->get_id().' product type-product product-type-'.$product->get_type().'">
                    <div class="single-product-wrap">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="woocommerce-product-gallery woocommerce-product-gallery--with-images woocommerce-product-gallery--columns-4 images"
                                     data-columns="4" style="opacity: 1; transition: opacity 0.25s ease-in-out 0s;">';
                                    $columns           = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
                                    $post_thumbnail_id = $product->get_image_id();
                                    $wrapper_classes   = apply_filters( 'woocommerce_single_product_image_gallery_classes', array(
                                        'woocommerce-product-gallery',
                                        'woocommerce-product-gallery--' . ( $product->get_image_id() ? 'with-images' : 'without-images' ),
                                        'woocommerce-product-gallery--columns-' . absint( $columns ),
                                        'images',
                                    ) );

    $output .= '<div class="'.esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ).'" data-columns="'.esc_attr( $columns ).'" style="opacity: 1; transition: opacity .25s ease-in-out;">
                                        <figure class="woocommerce-product-gallery__wrapper">';

                                            if ( $product->get_image_id() ) {
                                                $html = wc_get_gallery_image_html( $post_thumbnail_id, true );
                                            } else {
                                                $html  = '<div class="woocommerce-product-gallery__image--placeholder">';
                                                $html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting product image', 'woocommerce' ) );
                                                $html .= '</div>';
                                            }

    $output .=  apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id );

                                        //$output .= do_action( 'woocommerce_product_thumbnails' );

    $output .= '</figure>
                                    </div>';

                                    $attachment_ids = $product->get_gallery_image_ids();

                                    //echo '<pre>';
                                    //print_r($attachment_ids);
                                    //echo '</pre>';

                                    if ( $attachment_ids && $product->get_image_id() ) {
                                        foreach ( $attachment_ids as $attachment_id ) {
                                            //echo wc_get_gallery_image_html( $attachment_id );die();
                                            $output .= apply_filters( 'woocommerce_single_product_image_thumbnail_html', wc_get_gallery_image_html( $attachment_id ), $attachment_id );
                                        }
                                    }

    $output .= '</div>

                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">


                                <div class="row align-items-center mb-2">
                                    <div class="col-lg-6 col-md-6 col-sm-12 text-left">
                                        <h1 class="product_title entry-title">'.$product->get_name().'</h1>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 text-right">
                                        <p class="price">'.$product->get_price_html().'</p>
                                    </div>
                                </div>


                                <form class="variations_form cart"
                                      action="http://localhost/norcanna/product/product/"
                                      method="post" enctype="multipart/form-data" data-product_id="23"
                                      data-product_variations="[{&quot;attributes&quot;:{&quot;attribute_pa_color&quot;:&quot;blue&quot;},&quot;availability_html&quot;:&quot;&quot;,&quot;backorders_allowed&quot;:false,&quot;dimensions&quot;:{&quot;length&quot;:&quot;&quot;,&quot;width&quot;:&quot;&quot;,&quot;height&quot;:&quot;&quot;},&quot;dimensions_html&quot;:&quot;N\/A&quot;,&quot;display_price&quot;:250,&quot;display_regular_price&quot;:250,&quot;image&quot;:{&quot;title&quot;:&quot;hoodie-green-1.jpg&quot;,&quot;caption&quot;:&quot;&quot;,&quot;url&quot;:&quot;http:\/\/localhost\/norcanna\/wp-content\/uploads\/2019\/01\/hoodie-green-1.jpg&quot;,&quot;alt&quot;:&quot;&quot;,&quot;src&quot;:&quot;http:\/\/localhost\/norcanna\/wp-content\/uploads\/2019\/01\/hoodie-green-1-450x450.jpg&quot;,&quot;srcset&quot;:&quot;http:\/\/localhost\/norcanna\/wp-content\/uploads\/2019\/01\/hoodie-green-1-450x450.jpg 450w, http:\/\/localhost\/norcanna\/wp-content\/uploads\/2019\/01\/hoodie-green-1-150x150.jpg 150w, http:\/\/localhost\/norcanna\/wp-content\/uploads\/2019\/01\/hoodie-green-1-300x300.jpg 300w, http:\/\/localhost\/norcanna\/wp-content\/uploads\/2019\/01\/hoodie-green-1-768x768.jpg 768w, http:\/\/localhost\/norcanna\/wp-content\/uploads\/2019\/01\/hoodie-green-1-100x100.jpg 100w, http:\/\/localhost\/norcanna\/wp-content\/uploads\/2019\/01\/hoodie-green-1.jpg 800w&quot;,&quot;sizes&quot;:&quot;(max-width: 450px) 100vw, 450px&quot;,&quot;full_src&quot;:&quot;http:\/\/localhost\/norcanna\/wp-content\/uploads\/2019\/01\/hoodie-green-1.jpg&quot;,&quot;full_src_w&quot;:800,&quot;full_src_h&quot;:800,&quot;gallery_thumbnail_src&quot;:&quot;http:\/\/localhost\/norcanna\/wp-content\/uploads\/2019\/01\/hoodie-green-1-100x100.jpg&quot;,&quot;gallery_thumbnail_src_w&quot;:100,&quot;gallery_thumbnail_src_h&quot;:100,&quot;thumb_src&quot;:&quot;http:\/\/localhost\/norcanna\/wp-content\/uploads\/2019\/01\/hoodie-green-1-300x300.jpg&quot;,&quot;thumb_src_w&quot;:300,&quot;thumb_src_h&quot;:300,&quot;src_w&quot;:450,&quot;src_h&quot;:450},&quot;image_id&quot;:&quot;59&quot;,&quot;is_downloadable&quot;:false,&quot;is_in_stock&quot;:true,&quot;is_purchasable&quot;:true,&quot;is_sold_individually&quot;:&quot;no&quot;,&quot;is_virtual&quot;:false,&quot;max_qty&quot;:&quot;&quot;,&quot;min_qty&quot;:1,&quot;price_html&quot;:&quot;<span class=\&quot;price\&quot;><span class=\&quot;woocommerce-Price-amount amount\&quot;><span class=\&quot;woocommerce-Price-currencySymbol\&quot;>&amp;#2547;&amp;nbsp;<\/span>250.00<\/span><\/span>&quot;,&quot;sku&quot;:&quot;&quot;,&quot;variation_description&quot;:&quot;&quot;,&quot;variation_id&quot;:63,&quot;variation_is_active&quot;:true,&quot;variation_is_visible&quot;:true,&quot;weight&quot;:&quot;&quot;,&quot;weight_html&quot;:&quot;N\/A&quot;},{&quot;attributes&quot;:{&quot;attribute_pa_color&quot;:&quot;green&quot;},&quot;availability_html&quot;:&quot;&quot;,&quot;backorders_allowed&quot;:false,&quot;dimensions&quot;:{&quot;length&quot;:&quot;&quot;,&quot;width&quot;:&quot;&quot;,&quot;height&quot;:&quot;&quot;},&quot;dimensions_html&quot;:&quot;N\/A&quot;,&quot;display_price&quot;:300,&quot;display_regular_price&quot;:300,&quot;image&quot;:{&quot;title&quot;:&quot;vnech-tee-green-1.jpg&quot;,&quot;caption&quot;:&quot;&quot;,&quot;url&quot;:&quot;http:\/\/localhost\/norcanna\/wp-content\/uploads\/2019\/01\/vnech-tee-green-1.jpg&quot;,&quot;alt&quot;:&quot;&quot;,&quot;src&quot;:&quot;http:\/\/localhost\/norcanna\/wp-content\/uploads\/2019\/01\/vnech-tee-green-1-450x450.jpg&quot;,&quot;srcset&quot;:&quot;http:\/\/localhost\/norcanna\/wp-content\/uploads\/2019\/01\/vnech-tee-green-1-450x450.jpg 450w, http:\/\/localhost\/norcanna\/wp-content\/uploads\/2019\/01\/vnech-tee-green-1-150x150.jpg 150w, http:\/\/localhost\/norcanna\/wp-content\/uploads\/2019\/01\/vnech-tee-green-1-300x300.jpg 300w, http:\/\/localhost\/norcanna\/wp-content\/uploads\/2019\/01\/vnech-tee-green-1-768x768.jpg 768w, http:\/\/localhost\/norcanna\/wp-content\/uploads\/2019\/01\/vnech-tee-green-1-100x100.jpg 100w, http:\/\/localhost\/norcanna\/wp-content\/uploads\/2019\/01\/vnech-tee-green-1.jpg 800w&quot;,&quot;sizes&quot;:&quot;(max-width: 450px) 100vw, 450px&quot;,&quot;full_src&quot;:&quot;http:\/\/localhost\/norcanna\/wp-content\/uploads\/2019\/01\/vnech-tee-green-1.jpg&quot;,&quot;full_src_w&quot;:800,&quot;full_src_h&quot;:800,&quot;gallery_thumbnail_src&quot;:&quot;http:\/\/localhost\/norcanna\/wp-content\/uploads\/2019\/01\/vnech-tee-green-1-100x100.jpg&quot;,&quot;gallery_thumbnail_src_w&quot;:100,&quot;gallery_thumbnail_src_h&quot;:100,&quot;thumb_src&quot;:&quot;http:\/\/localhost\/norcanna\/wp-content\/uploads\/2019\/01\/vnech-tee-green-1-300x300.jpg&quot;,&quot;thumb_src_w&quot;:300,&quot;thumb_src_h&quot;:300,&quot;src_w&quot;:450,&quot;src_h&quot;:450},&quot;image_id&quot;:&quot;55&quot;,&quot;is_downloadable&quot;:false,&quot;is_in_stock&quot;:true,&quot;is_purchasable&quot;:true,&quot;is_sold_individually&quot;:&quot;no&quot;,&quot;is_virtual&quot;:false,&quot;max_qty&quot;:&quot;&quot;,&quot;min_qty&quot;:1,&quot;price_html&quot;:&quot;<span class=\&quot;price\&quot;><span class=\&quot;woocommerce-Price-amount amount\&quot;><span class=\&quot;woocommerce-Price-currencySymbol\&quot;>&amp;#2547;&amp;nbsp;<\/span>300.00<\/span><\/span>&quot;,&quot;sku&quot;:&quot;&quot;,&quot;variation_description&quot;:&quot;&quot;,&quot;variation_id&quot;:64,&quot;variation_is_active&quot;:true,&quot;variation_is_visible&quot;:true,&quot;weight&quot;:&quot;&quot;,&quot;weight_html&quot;:&quot;N\/A&quot;},{&quot;attributes&quot;:{&quot;attribute_pa_color&quot;:&quot;red&quot;},&quot;availability_html&quot;:&quot;&quot;,&quot;backorders_allowed&quot;:false,&quot;dimensions&quot;:{&quot;length&quot;:&quot;&quot;,&quot;width&quot;:&quot;&quot;,&quot;height&quot;:&quot;&quot;},&quot;dimensions_html&quot;:&quot;N\/A&quot;,&quot;display_price&quot;:400,&quot;display_regular_price&quot;:400,&quot;image&quot;:{&quot;title&quot;:&quot;vnech-tee-blue-1.jpg&quot;,&quot;caption&quot;:&quot;&quot;,&quot;url&quot;:&quot;http:\/\/localhost\/norcanna\/wp-content\/uploads\/2019\/01\/vnech-tee-blue-1.jpg&quot;,&quot;alt&quot;:&quot;&quot;,&quot;src&quot;:&quot;http:\/\/localhost\/norcanna\/wp-content\/uploads\/2019\/01\/vnech-tee-blue-1-450x450.jpg&quot;,&quot;srcset&quot;:&quot;http:\/\/localhost\/norcanna\/wp-content\/uploads\/2019\/01\/vnech-tee-blue-1-450x450.jpg 450w, http:\/\/localhost\/norcanna\/wp-content\/uploads\/2019\/01\/vnech-tee-blue-1-150x150.jpg 150w, http:\/\/localhost\/norcanna\/wp-content\/uploads\/2019\/01\/vnech-tee-blue-1-300x300.jpg 300w, http:\/\/localhost\/norcanna\/wp-content\/uploads\/2019\/01\/vnech-tee-blue-1-768x768.jpg 768w, http:\/\/localhost\/norcanna\/wp-content\/uploads\/2019\/01\/vnech-tee-blue-1-100x100.jpg 100w, http:\/\/localhost\/norcanna\/wp-content\/uploads\/2019\/01\/vnech-tee-blue-1.jpg 800w&quot;,&quot;sizes&quot;:&quot;(max-width: 450px) 100vw, 450px&quot;,&quot;full_src&quot;:&quot;http:\/\/localhost\/norcanna\/wp-content\/uploads\/2019\/01\/vnech-tee-blue-1.jpg&quot;,&quot;full_src_w&quot;:800,&quot;full_src_h&quot;:800,&quot;gallery_thumbnail_src&quot;:&quot;http:\/\/localhost\/norcanna\/wp-content\/uploads\/2019\/01\/vnech-tee-blue-1-100x100.jpg&quot;,&quot;gallery_thumbnail_src_w&quot;:100,&quot;gallery_thumbnail_src_h&quot;:100,&quot;thumb_src&quot;:&quot;http:\/\/localhost\/norcanna\/wp-content\/uploads\/2019\/01\/vnech-tee-blue-1-300x300.jpg&quot;,&quot;thumb_src_w&quot;:300,&quot;thumb_src_h&quot;:300,&quot;src_w&quot;:450,&quot;src_h&quot;:450},&quot;image_id&quot;:&quot;56&quot;,&quot;is_downloadable&quot;:false,&quot;is_in_stock&quot;:true,&quot;is_purchasable&quot;:true,&quot;is_sold_individually&quot;:&quot;no&quot;,&quot;is_virtual&quot;:false,&quot;max_qty&quot;:&quot;&quot;,&quot;min_qty&quot;:1,&quot;price_html&quot;:&quot;<span class=\&quot;price\&quot;><span class=\&quot;woocommerce-Price-amount amount\&quot;><span class=\&quot;woocommerce-Price-currencySymbol\&quot;>&amp;#2547;&amp;nbsp;<\/span>400.00<\/span><\/span>&quot;,&quot;sku&quot;:&quot;&quot;,&quot;variation_description&quot;:&quot;&quot;,&quot;variation_id&quot;:65,&quot;variation_is_active&quot;:true,&quot;variation_is_visible&quot;:true,&quot;weight&quot;:&quot;&quot;,&quot;weight_html&quot;:&quot;N\/A&quot;}]"
                                      current-image="">

                                    <table class="variations mb-4" cellspacing="0">
                                        <tbody>
                                        <tr>
                                            <td class="label pull-left"><label for="pa_color">Sativa</label></td>
                                            <td class="value pull-right">
                                                <select id="pa_color" class="varient-product"
                                                        name="attribute_pa_color"
                                                        data-attribute_name="attribute_pa_color"
                                                        data-show_option_none="yes">
                                                    <option value="">Choose an option</option>
                                                    <option value="blue" class="attached enabled">1 Gram</option>
                                                    <option value="green" class="attached enabled">Green</option>
                                                    <option value="red" class="attached enabled">Red</option>
                                                </select>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>

                                    <div class="row">
                                        <div class="col-12">
                                            <ul class="list-inline single-product-icon-list">
                                                <li class="list-inline-item">
                                                    <span class="circle">THC</span> 14%
                                                </li>
                                                <li class="list-inline-item">
                                                <span class="circle"><img src="images/flower_icon.png"
                                                                          alt="flower-icon"></span> Whole Flower
                                                </li>
                                                <li class="list-inline-item">
                                                        <span class="circle"><img src="images/shop_icon.png"
                                                                                  alt="flower-icon"></span>
                                                    1/8th oz.
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="row align-items-center">
                                        <div class="col-12">
                                            <p>Reach for this when you want to feel upbeat, clear-headed,
                                                and stoked. Old Pal sativa strains are great for daytime routine and
                                                activity.
                                                Naturally grown under the California sun, this flower is a bright
                                                addition
                                                to your day. </p>
                                            <h6>License No. C11-18-0000024-TEMP</h6>
                                        </div>
                                    </div>

                                    <div class="single_variation_wrap">
                                        <div class="woocommerce-variation single_variation"
                                             style="display: none;"></div>
                                        <div class="woocommerce-variation-add-to-cart variations_button woocommerce-variation-add-to-cart-disabled">

                                            <div class="quantity d-none">
                                                <label class="screen-reader-text"
                                                       for="quantity_5c46a260703e6">Quantity</label>
                                                <input type="number" id="quantity_5c46a260703e6"
                                                       class="input-text qty text"
                                                       step="1" min="1" max="" name="quantity" value="1" title="Qty"
                                                       size="4" pattern="[0-9]*" inputmode="numeric"
                                                       aria-labelledby="Product quantity">
                                            </div>

                                            <div class="row align-items-center">
                                                <div class="col-lg-6 col-md-6 col-sm-12 text-left">
                                                    <a class="share-btn btn mb-3">
                                                        <img class="mr-2" src="images/share_icon.png" alt="">
                                                        Share
                                                    </a>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-12 text-right">
                                                    <button type="submit"
                                                            class="single_add_to_cart_button button alt custom-btn wc-variation-selection-needed mb-3">
                                                        <img class="mr-2" src="images/shop_cart.png" alt="">Add to
                                                        cart
                                                    </button>
                                                    <input type="hidden" name="add-to-cart" value="23">
                                                    <input type="hidden" name="product_id" value="23">
                                                    <input type="hidden" name="variation_id" class="variation_id"
                                                           value="0">
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </form>

                                <div class="product_meta d-none">

                                    <span class="sku_wrapper">SKU: <span class="sku">N/A</span></span>

                                    <span class="posted_in">Category: <a
                                                href="http://localhost/norcanna/product-category/uncategorized/"
                                                rel="tag">Uncategorized</a></span>

                                </div>

                            </div>
                        </div>


                    </div>

                    <div class="clearfix"></div>

                    <div class="product-progress">
                        <div class="container">
                            <div class="row align-items-center">
                                <div class="col-lg-6 col-md-6 col-sm-12">

                                    <p>uplifted</p>
                                    <div class="progress">
                                        <div class="progress-bar bg-warning" style="width:40%"></div>
                                    </div>
                                    <br>

                                    <p>euphoric</p>
                                    <div class="progress">
                                        <div class="progress-bar bg-warning" style="width:60%"></div>
                                    </div>
                                    <br>


                                    <p>energetic</p>
                                    <div class="progress">
                                        <div class="progress-bar bg-warning" style="width:60%"></div>
                                    </div>
                                    <br>

                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">


                                    <p>creative</p>
                                    <div class="progress">
                                        <div class="progress-bar bg-warning" style="width:60%"></div>
                                    </div>
                                    <br>


                                    <p>focused</p>
                                    <div class="progress">
                                        <div class="progress-bar bg-warning" style="width:60%"></div>
                                    </div>
                                    <br>

                                </div>
                            </div>
                        </div>
                    </div>

                    <section class="related products">


                        <h2>Related products</h2>
                        <div class="container">
                            <ul class="products columns-4 category-slider">


                                <li class="post-26 product type-product status-publish product_cat-uncategorized entry instock shipping-taxable purchasable product-type-simple">


                                    <div class="row justify-content">
                                        <div class="col-6">
                                            <a href="http://localhost/norcanna/product/product-4/"
                                               class="woocommerce-LoopProduct-link woocommerce-loop-product__link"><img
                                                        src="images/product1.png"
                                                        alt="Placeholder" width="300"
                                                        class="woocommerce-placeholder wp-post-image"
                                                        height="300"></a>
                                        </div>
                                        <div class="col-6">
                                            <a href="http://localhost/norcanna/product/product-4/"
                                               class="woocommerce-LoopProduct-link woocommerce-loop-product__link">
                                                <h2 class="woocommerce-loop-product__title">Humboldt Farms</h2>
                                                <p class="category">Classic Indica</p>
                                                <span class="price"><span class="woocommerce-Price-amount amount"><span
                                                                class="woocommerce-Price-currencySymbol">$&nbsp;</span>122.00</span></span>
                                            </a>
                                            <a href="/norcanna/product/product/?add-to-cart=26" data-quantity="1"
                                               class="button product_type_simple add_to_cart_button ajax_add_to_cart pull-right"
                                               data-product_id="26" data-product_sku=""
                                               aria-label="Add “Product” to your cart" rel="nofollow"><i
                                                        class="fa fa-plus" aria-hidden="true"></i></a>

                                        </div>
                                    </div><!--row-->
                                </li>

                                <li class="post-27 product type-product status-publish product_cat-uncategorized entry instock shipping-taxable purchasable product-type-simple">


                                    <div class="row">
                                        <div class="col-6">
                                            <a href="http://localhost/norcanna/product/product-4/"
                                               class="woocommerce-LoopProduct-link woocommerce-loop-product__link"><img
                                                        src="images/product2.png"
                                                        alt="Placeholder" width="300"
                                                        class="woocommerce-placeholder wp-post-image"
                                                        height="300"></a>
                                        </div>
                                        <div class="col-6">
                                            <a href="http://localhost/norcanna/product/product-4/"
                                               class="woocommerce-LoopProduct-link woocommerce-loop-product__link">
                                                <h2 class="woocommerce-loop-product__title">Humboldt Farms</h2>
                                                <p class="category">Classic Indica</p>
                                                <span class="price"><span class="woocommerce-Price-amount amount"><span
                                                                class="woocommerce-Price-currencySymbol">$&nbsp;</span>122.00</span></span>
                                            </a>
                                            <a href="/norcanna/product/product/?add-to-cart=26" data-quantity="1"
                                               class="button product_type_simple add_to_cart_button ajax_add_to_cart pull-right"
                                               data-product_id="26" data-product_sku=""
                                               aria-label="Add “Product” to your cart" rel="nofollow"><i
                                                        class="fa fa-plus" aria-hidden="true"></i></a>

                                        </div>
                                    </div><!--row-->
                                </li>


                                <li class="post-28 product type-product status-publish product_cat-uncategorized entry instock shipping-taxable purchasable product-type-simple">


                                    <div class="row">
                                        <div class="col-6">
                                            <a href="http://localhost/norcanna/product/product-4/"
                                               class="woocommerce-LoopProduct-link woocommerce-loop-product__link"><img
                                                        src="images/product1.png"
                                                        alt="Placeholder" width="300"
                                                        class="woocommerce-placeholder wp-post-image"
                                                        height="300"></a>
                                        </div>
                                        <div class="col-6">
                                            <a href="http://localhost/norcanna/product/product-4/"
                                               class="woocommerce-LoopProduct-link woocommerce-loop-product__link">
                                                <h2 class="woocommerce-loop-product__title">Humboldt Farms</h2>
                                                <p class="category">Classic Indica</p>
                                                <span class="price"><span class="woocommerce-Price-amount amount"><span
                                                                class="woocommerce-Price-currencySymbol">$&nbsp;</span>122.00</span></span>
                                            </a>
                                            <a href="/norcanna/product/product/?add-to-cart=26" data-quantity="1"
                                               class="button product_type_simple add_to_cart_button ajax_add_to_cart pull-right"
                                               data-product_id="26" data-product_sku=""
                                               aria-label="Add “Product” to your cart" rel="nofollow"><i
                                                        class="fa fa-plus" aria-hidden="true"></i></a>

                                        </div>
                                    </div><!--row-->
                                </li>

                                <li class="post-29 product type-product status-publish product_cat-uncategorized entry instock shipping-taxable purchasable product-type-simple">


                                    <div class="row">
                                        <div class="col-6">
                                            <a href="http://localhost/norcanna/product/product-4/"
                                               class="woocommerce-LoopProduct-link woocommerce-loop-product__link"><img
                                                        src="images/product2.png"
                                                        alt="Placeholder" width="300"
                                                        class="woocommerce-placeholder wp-post-image"
                                                        height="300"></a>
                                        </div>
                                        <div class="col-6">
                                            <a href="http://localhost/norcanna/product/product-4/"
                                               class="woocommerce-LoopProduct-link woocommerce-loop-product__link">
                                                <h2 class="woocommerce-loop-product__title">Humboldt Farms</h2>
                                                <p class="category">Classic Indica</p>
                                                <span class="price"><span class="woocommerce-Price-amount amount"><span
                                                                class="woocommerce-Price-currencySymbol">$&nbsp;</span>122.00</span></span>
                                            </a>
                                            <a href="/norcanna/product/product/?add-to-cart=26" data-quantity="1"
                                               class="button product_type_simple add_to_cart_button ajax_add_to_cart pull-right"
                                               data-product_id="26" data-product_sku=""
                                               aria-label="Add “Product” to your cart" rel="nofollow"><i
                                                        class="fa fa-plus" aria-hidden="true"></i></a>

                                        </div>
                                    </div><!--row-->
                                </li>
                            </ul>
                        </div>


                    </section>


                    <div class="woocommerce-tabs wc-tabs-wrapper review">
                        <div class="container">
                            <ul class="tabs wc-tabs" role="tablist">
                                <li class="additional_information_tab d-none" id="tab-title-additional_information"
                                    role="tab" aria-controls="tab-additional_information">
                                    <a href="#tab-additional_information">Additional information</a>
                                </li>
                                <li class="reviews_tab active" id="tab-title-reviews" role="tab"
                                    aria-controls="tab-reviews">
                                    <a href="#tab-reviews">What Our Customers Say</a>
                                </li>
                                <li class="pull-right">

                                    <div class="review-star text-center">
                                        <img src="images/rate_green.png" alt="">
                                        <img src="images/rate_green.png" alt="">
                                        <img src="images/rate_green.png" alt="">
                                        <img src="images/rate_gray.png" alt="">
                                        <img src="images/rate_gray.png" alt="">
                                    </div>
                                    <h2 class="woocommerce-Reviews-title">Based on 221 reviews </h2>

                                </li>
                            </ul>
                            <div class="woocommerce-Tabs-panel woocommerce-Tabs-panel--additional_information panel entry-content wc-tab"
                                 id="tab-additional_information" role="tabpanel"
                                 aria-labelledby="tab-title-additional_information" style="display: none;">

                                <h2>Additional information</h2>

                                <table class="shop_attributes">


                                    <tbody>
                                    <tr>
                                        <th>Color</th>
                                        <td><p>Blue, Green, Red</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Size</th>
                                        <td><p>Large, Medium, Small</p>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="woocommerce-Tabs-panel woocommerce-Tabs-panel--reviews panel entry-content wc-tab"
                             id="tab-reviews" role="tabpanel" aria-labelledby="tab-title-reviews"
                             style="display: block;">
                            <div id="reviews" class="woocommerce-Reviews">
                                <div id="comments" class="mb-5">


                                    <ol class="commentlist category-slider">
                                        <li class="review byuser comment-author-admin bypostauthor even thread-even depth-1"
                                            id="li-comment-2">

                                            <div id="comment-2" class="comment_container">


                                                <div class="comment-text">

                                                    <div class="row mb-5">
                                                        <div class="col-4 text-center">
                                                            <img alt=""
                                                                 src="http://2.gravatar.com/avatar/22ae23141425c47911ed7440f49788d6?s=60&amp;d=mm&amp;r=g"
                                                                 srcset="http://2.gravatar.com/avatar/22ae23141425c47911ed7440f49788d6?s=120&amp;d=mm&amp;r=g 2x"
                                                                 class="avatar avatar-60 photo" height="60"
                                                                 width="60">
                                                        </div>
                                                        <div class="col-8  ">
                                                            <p class="meta">
                                                                <strong class="woocommerce-review__author">Dan
                                                                    Rocha </strong>
                                                                <br>
                                                                <time class="woocommerce-review__published-date"
                                                                      datetime="2019-01-22T04:27:16+00:00">January
                                                                    22, 2019
                                                                </time>
                                                            </p>

                                                            <div class="star-rating">
                                                                <img src="images/rate_green.png" alt="">
                                                                <img src="images/rate_green.png" alt="">
                                                                <img src="images/rate_green.png" alt="">
                                                                <img src="images/rate_gray.png" alt="">
                                                                <img src="images/rate_gray.png" alt="">
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div>


                                                    <div class="description">
                                                        <p>This is a great product! I am in
                                                            love with it!</p>

                                                        <form action="">
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input"
                                                                >
                                                                <label class="form-check-label">I
                                                                    recommend</label>
                                                            </div>
                                                        </form>
                                                    </div>


                                                </div>
                                            </div>
                                        </li><!-- #comment-## -->

                                        <li class="review byuser comment-author-admin bypostauthor even thread-even depth-1"
                                            id="li-comment-2">

                                            <div id="comment-2" class="comment_container">


                                                <div class="comment-text">

                                                    <div class="row mb-5">
                                                        <div class="col-4 text-center">
                                                            <img alt=""
                                                                 src="http://2.gravatar.com/avatar/22ae23141425c47911ed7440f49788d6?s=60&amp;d=mm&amp;r=g"
                                                                 srcset="http://2.gravatar.com/avatar/22ae23141425c47911ed7440f49788d6?s=120&amp;d=mm&amp;r=g 2x"
                                                                 class="avatar avatar-60 photo" height="60"
                                                                 width="60">
                                                        </div>
                                                        <div class="col-8  ">
                                                            <p class="meta">
                                                                <strong class="woocommerce-review__author">Dan
                                                                    Rocha </strong>
                                                                <br>
                                                                <time class="woocommerce-review__published-date"
                                                                      datetime="2019-01-22T04:27:16+00:00">January
                                                                    22, 2019
                                                                </time>
                                                            </p>

                                                            <div class="star-rating">
                                                                <img src="images/rate_green.png" alt="">
                                                                <img src="images/rate_green.png" alt="">
                                                                <img src="images/rate_green.png" alt="">
                                                                <img src="images/rate_gray.png" alt="">
                                                                <img src="images/rate_gray.png" alt="">
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div>


                                                    <div class="description">
                                                        <p>This is a great product! I am in
                                                            love with it!</p>

                                                        <form action="">
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input"
                                                                >
                                                                <label class="form-check-label">I
                                                                    recommend</label>
                                                            </div>
                                                        </form>
                                                    </div>


                                                </div>
                                            </div>
                                        </li><!-- #comment-## -->

                                        <li class="review byuser comment-author-admin bypostauthor even thread-even depth-1"
                                            id="li-comment-2">

                                            <div id="comment-2" class="comment_container">


                                                <div class="comment-text">

                                                    <div class="row mb-5">
                                                        <div class="col-4 text-center">
                                                            <img alt=""
                                                                 src="http://2.gravatar.com/avatar/22ae23141425c47911ed7440f49788d6?s=60&amp;d=mm&amp;r=g"
                                                                 srcset="http://2.gravatar.com/avatar/22ae23141425c47911ed7440f49788d6?s=120&amp;d=mm&amp;r=g 2x"
                                                                 class="avatar avatar-60 photo" height="60"
                                                                 width="60">
                                                        </div>
                                                        <div class="col-8  ">
                                                            <p class="meta">
                                                                <strong class="woocommerce-review__author">Dan
                                                                    Rocha </strong>
                                                                <br>
                                                                <time class="woocommerce-review__published-date"
                                                                      datetime="2019-01-22T04:27:16+00:00">January
                                                                    22, 2019
                                                                </time>
                                                            </p>

                                                            <div class="star-rating">
                                                                <img src="images/rate_green.png" alt="">
                                                                <img src="images/rate_green.png" alt="">
                                                                <img src="images/rate_green.png" alt="">
                                                                <img src="images/rate_gray.png" alt="">
                                                                <img src="images/rate_gray.png" alt="">
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div>


                                                    <div class="description">
                                                        <p>This is a great product! I am in
                                                            love with it!</p>

                                                        <form action="">
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input"
                                                                >
                                                                <label class="form-check-label">I
                                                                    recommend</label>
                                                            </div>
                                                        </form>
                                                    </div>


                                                </div>
                                            </div>
                                        </li><!-- #comment-## -->

                                        <li class="review byuser comment-author-admin bypostauthor even thread-even depth-1"
                                            id="li-comment-2">

                                            <div id="comment-2" class="comment_container">


                                                <div class="comment-text">

                                                    <div class="row mb-5">
                                                        <div class="col-4 text-center">
                                                            <img alt=""
                                                                 src="http://2.gravatar.com/avatar/22ae23141425c47911ed7440f49788d6?s=60&amp;d=mm&amp;r=g"
                                                                 srcset="http://2.gravatar.com/avatar/22ae23141425c47911ed7440f49788d6?s=120&amp;d=mm&amp;r=g 2x"
                                                                 class="avatar avatar-60 photo" height="60"
                                                                 width="60">
                                                        </div>
                                                        <div class="col-8  ">
                                                            <p class="meta">
                                                                <strong class="woocommerce-review__author">Dan
                                                                    Rocha </strong>
                                                                <br>
                                                                <time class="woocommerce-review__published-date"
                                                                      datetime="2019-01-22T04:27:16+00:00">January
                                                                    22, 2019
                                                                </time>
                                                            </p>

                                                            <div class="star-rating">
                                                                <img src="images/rate_green.png" alt="">
                                                                <img src="images/rate_green.png" alt="">
                                                                <img src="images/rate_green.png" alt="">
                                                                <img src="images/rate_gray.png" alt="">
                                                                <img src="images/rate_gray.png" alt="">
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div>


                                                    <div class="description">
                                                        <p>This is a great product! I am in
                                                            love with it!</p>

                                                        <form action="">
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input">
                                                                <label class="form-check-label">I
                                                                    recommend</label>
                                                            </div>
                                                        </form>
                                                    </div>


                                                </div>
                                            </div>
                                        </li><!-- #comment-## -->

                                        <li class="review byuser comment-author-admin bypostauthor even thread-even depth-1"
                                            id="li-comment-2">

                                            <div id="comment-2" class="comment_container">


                                                <div class="comment-text">

                                                    <div class="row mb-5">
                                                        <div class="col-4 text-center">
                                                            <img alt=""
                                                                 src="http://2.gravatar.com/avatar/22ae23141425c47911ed7440f49788d6?s=60&amp;d=mm&amp;r=g"
                                                                 srcset="http://2.gravatar.com/avatar/22ae23141425c47911ed7440f49788d6?s=120&amp;d=mm&amp;r=g 2x"
                                                                 class="avatar avatar-60 photo" height="60"
                                                                 width="60">
                                                        </div>
                                                        <div class="col-8  ">
                                                            <p class="meta">
                                                                <strong class="woocommerce-review__author">Dan
                                                                    Rocha </strong>
                                                                <br>
                                                                <time class="woocommerce-review__published-date"
                                                                      datetime="2019-01-22T04:27:16+00:00">January
                                                                    22, 2019
                                                                </time>
                                                            </p>

                                                            <div class="star-rating">
                                                                <img src="images/rate_green.png" alt="">
                                                                <img src="images/rate_green.png" alt="">
                                                                <img src="images/rate_green.png" alt="">
                                                                <img src="images/rate_gray.png" alt="">
                                                                <img src="images/rate_gray.png" alt="">
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div>


                                                    <div class="description">
                                                        <p>This is a great product! I am in
                                                            love with it!</p>

                                                        <form action="">
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input">
                                                                <label class="form-check-label">I recommend</label>
                                                            </div>
                                                        </form>
                                                    </div>


                                                </div>
                                            </div>
                                        </li><!-- #comment-## -->


                                    </ol>


                                </div>


                                <div id="review_form_wrapper">
                                    <div id="review_form">
                                        <div id="respond" class="comment-respond">
                                            <div class="text-center">
                                                    <span id="reply-title"
                                                          class="comment-reply-title custom-btn mb-4 text-center text-capitalize">Add a review <small><a
                                                                    rel="nofollow" id="cancel-comment-reply-link"
                                                                    href="/norcanna/product/product/#respond"
                                                                    style="display:none;">Cancel reply</a></small></span>
                                            </div>
                                            <form action="http://localhost/norcanna/wp-comments-post.php"
                                                  method="post" id="commentform" class="comment-form "
                                                  novalidate="">
                                                <div class="comment-form-rating text-center"><label for="rating">Your
                                                        Review</label>

                                                    <p class="stars">
                                                            <span>
                                                                <a href=""><img src="images/rate_green.png" alt=""></a>
                                                                <a href=""><img src="images/rate_green.png" alt=""></a>
                                                                <a href=""><img src="images/rate_gray.png" alt=""></a>
                                                                <a href=""><img src="images/rate_gray.png" alt=""></a>
                                                                <a href=""><img src="images/rate_gray.png" alt=""></a>
                                                                <a href=""><img src="images/rate_gray.png" alt=""></a>

                                                            </span>
                                                    </p><select name="rating" id="rating" required=""
                                                                style="display: none;">
                                                        <option value="">Rate…</option>
                                                        <option value="5">Perfect</option>
                                                        <option value="4">Good</option>
                                                        <option value="3">Average</option>
                                                        <option value="2">Not that bad</option>
                                                        <option value="1">Very poor</option>
                                                    </select></div>
                                                <p class="comment-form-comment">
                                                    <label for="name"> Your name</label> <br>
                                                    <input id="name" name="name" class="form-control" required=""
                                                           value="Dan Rocha" placeholder="Dan Rocha">
                                                </p>
                                                <p class="comment-form-comment">
                                                    <label for="comment"> Your review</label>
                                                    <textarea id="comment" name="comment" class="form-control"
                                                              cols="45" rows="10" required=""
                                                              placeholder="Enter your message"></textarea>
                                                </p>
                                                <p class="comment-form-comment ">

                                                    <input type="checkbox" class="form-check-input" id="checkbox"
                                                           tabindex="0">
                                                    <label class="form-check-label" for="checkbox">I
                                                        recommend</label>

                                                </p>

                                                <p class="form-submit text-center"><input id="comment_sub"
                                                                                          name="submit"
                                                                                          type="submit"
                                                                                          class="custom-btn text-capitalize"
                                                                                          value="Add review ">
                                                    <input type="hidden"
                                                           name="comment_post_ID"
                                                           value="23"
                                                           id="comment_post_ID">
                                                    <input type="hidden" name="comment_parent" id="comment_parent"
                                                           value="0">
                                                </p><input type="hidden" id="_wp_unfiltered_html_comment_disabled"
                                                           name="_wp_unfiltered_html_comment" value="9981f74610">
                                                <script>(function () {
                                                        if (window === window.parent) {
                                                            document.getElementById(\'_wp_unfiltered_html_comment_disabled\').name = \'_wp_unfiltered_html_comment\';
                                                        }
                                                    })();</script>
                                            </form>
                                        </div><!-- #respond -->
                                    </div>
                                </div>


                                <div class="clear"></div>
                            </div>
                        </div>
                    </div>


                </div>';
    $response['html'] = $output;
    wp_send_json($response);
}

add_action('wp_ajax_nopriv_load_single_product', 'load_single_product');
add_action('wp_ajax_load_single_product', 'load_single_product');