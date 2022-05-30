<?php
/**
 * norcanna functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package norcanna
 */
define("URL",get_template_directory_uri());

require __DIR__ . '/inc/custom_funcs.php';
if ( ! function_exists( 'norcanna_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function norcanna_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on norcanna, use a find and replace
		 * to change 'norcanna' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'norcanna', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'norcanna' ),
			'footer-menu' => esc_html__( 'Footer Menu', 'norcanna' ),
			'side-menu' => esc_html__( 'Side Menu', 'norcanna' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'norcanna_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'norcanna_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function norcanna_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'norcanna_content_width', 640 );
}
add_action( 'after_setup_theme', 'norcanna_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function norcanna_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'norcanna' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'norcanna' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'norcanna_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function norcanna_scripts() {

    wp_register_style('bootstrap', URL . '/css/bootstrap.min.css', array(), '0.1');
    wp_register_style('jquery-ui', URL . '/css/jquery-ui.min.css', array(), '0.1');
    wp_register_style('dropzone', 'https://rawgit.com/enyo/dropzone/master/dist/dropzone.css', array(), '0.1');
    wp_register_style('timepicker-addon', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.css', array(), '0.1');
    wp_register_style('font-awesome', URL . '/css/font-awesome.min.css', array(), '0.1');
    wp_register_style('styles', URL . '/css/styles.css', array(), '0.1');



    wp_register_style('google-fonts1', 'https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i&amp;subset=latin-ext', array(), '0.1');
    wp_register_style('google-fonts2', 'https://fonts.googleapis.com/css?family=Montserrat:300,400,400i,500,600,700,800,900', array(), '0.1');

    wp_register_style('chosen-css', URL . '/css/chosen.min.css', array(), '0.1');


    wp_register_script('popper-js', "https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js", array('jquery'), '0.1', true);
    wp_register_script('bootstrap-js', URL."/js/bootstrap.min.js", array('jquery'), '0.1', true);
    wp_register_script('jquery-ui-js', URL."/js/jquery-ui.min.js", array('jquery'), '0.1', true);
    wp_register_script('timepicker-addon-js', "https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.js", array('jquery'), '0.1', true);
    wp_register_script('dropzone-js', "https://rawgit.com/enyo/dropzone/master/dist/dropzone.js", array('jquery'), '0.1', true);
    wp_register_script('chosen-js', URL."/js/chosen.jquery.min.js", array('jquery'), '0.1', true);
    wp_register_script('slick-js', URL."/js/slick.min.js", array('jquery'), '0.1', true);
    wp_register_script('functions-js', URL."/js/functions.js", array('jquery'), '0.1', true);
    wp_register_script('google-map-api-js', "http://maps.google.com/maps/api/js?key=AIzaSyABqK-5ngi3F1hrEsk7-mCcBPsjHM5_Gj0", array('jquery'), '0.1', true);
    wp_register_script('google-map-js', URL."/js/google-map.js", array('jquery'), '0.1', true);
    wp_register_script('bootstrap-slider', URL."/js/bootstrap-slider.js", array('jquery'), '0.1', true);



    wp_enqueue_style( 'bootstrap' );
    wp_enqueue_style( 'jquery-ui' );
    wp_enqueue_style( 'dropzone' );
    wp_enqueue_style( 'timepicker-addon' );
    wp_enqueue_style( 'font-awesome' );
    wp_enqueue_style( 'chosen-css' );
    wp_enqueue_style( 'styles' );

    wp_enqueue_style( 'google-fonts1' );
    wp_enqueue_style( 'google-fonts2' );
    wp_enqueue_style( 'norcanna-style', get_stylesheet_uri() );

    wp_enqueue_script('popper-js');
    wp_enqueue_script('bootstrap-js');
    wp_enqueue_script('jquery-ui-js');
    wp_enqueue_script('timepicker-addon-js');
    wp_enqueue_script('dropzone-js');
    wp_enqueue_script('chosen-js');
    wp_enqueue_script('slick-js');

    if (is_page('Service')){
        wp_enqueue_script('google-map-api-js');
        wp_enqueue_script('google-map-js');
    }
    wp_enqueue_script('bootstrap-slider');



	wp_enqueue_script( 'norcanna-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'norcanna-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}


	$available_service = get_field('available_service_area', 'option');
	$available_service = preg_replace('/\s+/', ' ', $available_service);
	$available_service = explode(",",$available_service);

	wp_localize_script( 'jquery', 'js_vars',
		array(
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'homeurl' => trailingslashit(home_url()),
			'r_status' => !empty($GLOBALS['success']) ? $GLOBALS['success'] : '',
            'available_service' => $available_service,
		)
	);


	wp_enqueue_script('functions-js');

}
add_action( 'wp_enqueue_scripts', 'norcanna_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

// Ajax Search
require get_template_directory() . '/ajax-search/functions.php';

// Register Custom Navigation Walker
if ( ! file_exists( get_template_directory() . '/inc/class-wp-bootstrap-navwalker.php' ) ) {
    // file does not exist... return an error.
    return new WP_Error( 'class-wp-bootstrap-navwalker-missing', __( 'It appears the class-wp-bootstrap-navwalker.php file may be missing.', 'wp-bootstrap-navwalker' ) );
} else {
    // file exists... require it.
    require_once get_template_directory() . '/inc/class-wp-bootstrap-navwalker.php';
}

// ACF Option Page
if( function_exists('acf_add_options_page') ) {
    acf_add_options_page(array(
        'page_title' 	=> 'General Settings',
        'menu_title'	=> 'Theme Settings',
        'menu_slug' 	=> 'theme-general-settings',
        'capability'	=> 'edit_posts',
        'redirect'		=> false
    ));

    acf_add_options_sub_page(array(
        'page_title' 	=> 'Header Settings',
        'menu_title'	=> 'Header',
        'parent_slug'	=> 'theme-general-settings',
    ));

    acf_add_options_sub_page(array(
        'page_title' 	=> 'Footer Settings',
        'menu_title'	=> 'Footer',
        'parent_slug'	=> 'theme-general-settings',
    ));

    acf_add_options_sub_page(array(
        'page_title' 	=> 'Social Links',
        'menu_title'	=> 'Social Links',
        'parent_slug'	=> 'theme-general-settings',
    ));

    acf_add_options_sub_page(array(
        'page_title' 	=> 'Home Page',
        'menu_title'	=> 'Home Page',
        'parent_slug'	=> 'theme-general-settings',
    ));
    acf_add_options_sub_page(array(
        'page_title' 	=> 'Contact Us Page',
        'menu_title'	=> 'Contact Us Page',
        'parent_slug'	=> 'theme-general-settings',
    ));
    acf_add_options_sub_page(array(
        'page_title' 	=> 'Service Page',
        'menu_title'	=> 'Service Page',
        'parent_slug'	=> 'theme-general-settings',
    ));
    acf_add_options_sub_page(array(
        'page_title' 	=> 'FAQ Page',
        'menu_title'	=> 'FAQ Page',
        'parent_slug'	=> 'theme-general-settings',
    ));

    acf_add_options_sub_page(array(
        'page_title' 	=> 'Registration Page',
        'menu_title'	=> 'Registration Page',
        'parent_slug'	=> 'theme-general-settings',
    ));

    acf_add_options_sub_page(array(
        'page_title' 	=> 'Login Page',
        'menu_title'	=> 'Login Page',
        'parent_slug'	=> 'theme-general-settings',
    ));

    acf_add_options_sub_page(array(
        'page_title' 	=> 'Forgot Password Page',
        'menu_title'	=> 'Forgot Password Page',
        'parent_slug'	=> 'theme-general-settings',
    ));

    acf_add_options_sub_page(array(
        'page_title' 	=> 'Age Verification Page',
        'menu_title'	=> 'Age Verification Page',
        'parent_slug'	=> 'theme-general-settings',
    ));

    acf_add_options_sub_page(array(
        'page_title' 	=> 'WooCommerce Settings',
        'menu_title'	=> 'WooCommerce Settings',
        'parent_slug'	=> 'theme-general-settings',
    ));

    acf_add_options_sub_page(array(
        'page_title' 	=> 'Email & SMS Settings',
        'menu_title'	=> 'Email & SMS Settings',
        'parent_slug'	=> 'theme-general-settings',
    ));

    acf_add_options_sub_page(array(
        'page_title' 	=> 'Service Area',
        'menu_title'	=> 'Service Area',
        'parent_slug'	=> 'theme-general-settings',
    ));
}
function filter_plugin_updates( $value ) {
    unset( $value->response['advanced-custom-fields/acf.php'] );
    return $value;
}
add_filter( 'site_transient_update_plugins', 'filter_plugin_updates' );


function faq_custom_post_types() {
    $labels = array(
        'name'               => _x( 'FAQ', 'FAQ general name', 'norcanna' ),
        'singular_name'      => _x( 'FAQ', 'FAQ singular name', 'norcanna' ),
        'menu_name'          => _x( 'FAQ', 'admin menu', 'norcanna' ),
        'name_admin_bar'     => _x( 'FAQ ', 'add new on admin bar', 'norcanna' ),
        'add_new'            => _x( 'Add New', 'FAQ', 'norcanna' ),
        'add_new_item'       => __( 'Add New FAQ', 'norcanna' ),
        'new_item'           => __( 'New FAQ', 'norcanna' ),
        'edit_item'          => __( 'Edit FAQ', 'norcanna' ),
        'view_item'          => __( 'View FAQ', 'norcanna' ),
        'all_items'          => __( 'All FAQ', 'norcanna' ),
        'search_items'       => __( 'Search FAQ', 'norcanna' ),
        'parent_item_colon'  => __( 'Parent FAQ:', 'norcanna' ),
        'not_found'          => __( 'No Faq found.', 'norcanna' ),
        'not_found_in_trash' => __( 'No Faq found in Trash.', 'norcanna' )
    );

    $args = array(
        'labels'             => $labels,
        'description'        => __( 'Description.', 'norcanna' ),
        'public'             => true,
        'has_archive' => 'faq',
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'menu_icon'    => 'dashicons-admin-post',
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'faq' ),
        'capability_type'    => 'post',
        'hierarchical'       => false,
        'menu_position'      => null,
        'taxonomies' => array('category'),
        'supports'     => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'revisions', 'page-attributes')

    );

    register_post_type( 'faq', $args );
}

add_action( 'init', 'faq_custom_post_types' );



function rules_custom_post_types() {
    $labels = array(
        'name'               => _x( 'Rules', 'Rules general name', 'norcanna' ),
        'singular_name'      => _x( 'Rules', 'Rules singular name', 'norcanna' ),
        'menu_name'          => _x( 'Rules', 'admin menu', 'norcanna' ),
        'name_admin_bar'     => _x( 'Rules ', 'add new on admin bar', 'norcanna' ),
        'add_new'            => _x( 'Add New', 'Rules', 'norcanna' ),
        'add_new_item'       => __( 'Add New Rules', 'norcanna' ),
        'new_item'           => __( 'New Rules', 'norcanna' ),
        'edit_item'          => __( 'Edit Rules', 'norcanna' ),
        'view_item'          => __( 'View Rules', 'norcanna' ),
        'all_items'          => __( 'All Rules', 'norcanna' ),
        'search_items'       => __( 'Search Rules', 'norcanna' ),
        'parent_item_colon'  => __( 'Parent Rules:', 'norcanna' ),
        'not_found'          => __( 'No Rules found.', 'norcanna' ),
        'not_found_in_trash' => __( 'No Rules found in Trash.', 'norcanna' )
    );

    $args = array(
        'labels'             => $labels,
        'description'        => __( 'Description.', 'norcanna' ),
        'public'             => true,
        'has_archive' => 'rules',
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'menu_icon'    => 'dashicons-admin-network',
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'rules' ),
        'capability_type'    => 'post',
        'hierarchical'       => false,
        'menu_position'      => null,
        'taxonomies' => array('category'),
        'supports'     => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'revisions', 'page-attributes')

    );

    register_post_type( 'rules', $args );
}

add_action( 'init', 'rules_custom_post_types' );


/*add_action( 'init', function(){

    if(isset($_POST['create_user']) && $_POST['create_user'] == 1 ) {

        $full_name = sanitize_text_field($_POST['full-name']);
        $birth_date = sanitize_text_field($_POST['birth-date']);
        $user_email = sanitize_text_field($_POST['email']);
        $user_phone = sanitize_text_field($_POST['phone']);
        $zip_code = sanitize_text_field($_POST['zip-code']);
        $user_password = sanitize_text_field($_POST['user-password']);
        $confirm_pass = sanitize_text_field($_POST['confirm-pass']);
        $address = sanitize_text_field($_POST['address']);
        $front_side = $_POST['front_side'];
        $back_side = $_POST['back_side'];
        $medical_id = $_POST['medical_id'];
        $photo_id = $_POST['photo_id'];
        $allow_text_message = $_POST['allow_text_message'] ? $_POST['allow_text_message'] : 0;
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
                    $send_to_admin = get_option('admin_email');
                    $send_to_user = $user_email;
                    $nonce = wp_create_nonce( 'approve-user' );
                    //$send_to_admin = 'developer2@puredevs.com';
                    //$send_to_user = 'assad@puredevs.com';
                    $admin_subject = 'New user registration';
                    $user_subject = 'Registration complete';

                    //$admin_message = get_email_template('template-parts/email/admin-register-email');

                    $admin_message = "<html>
                                    <body>
                                        <p>New User has been registered! Please check and approve from <a herf='".admin_url('users.php?approve_user='.$user_id.'&_wpnonce='.$nonce)."'>here</a>.</p>
                                    </body>
                                 </html>";
                    $user_message = "<html>
                                    <body>
                                        <p>We received your registration request. Your account is under review!</p>
                                        <p>You will be get confirmation email after approved!</p>
                                    </body>
                                 </html>";
                    //$headers = array('Content-Type: text/html; charset=UTF-8');

                    send_email_notification($send_to_admin, $admin_subject, $admin_message);
                    send_email_notification($send_to_user, $user_subject, $user_message);

                    //wp_mail($send_to_admin, $admin_subject, $admin_message, $headers);
                    //wp_mail($send_to_user, $user_subject, $user_message, $headers);
                }

                $send_sms = get_field('send_sms','option');
                if($send_sms == 'All Users' && $allow_text_message == 1) {
                    $user_message = "We received your registration request. Your account is under review! You will be get confirmation email after approved!";
	                send_msg_notification($user_phone, $user_message);
                }
                $GLOBALS['success'] = 1;
            } else {
                //$GLOBALS['failed'] = 1;
            }
        } else {
            //$GLOBALS['exist'] = 1;
        }
    }
} );*/


function send_email_notification($to,$subject,$body = NULL, $args = array()){
    $headers = array('Content-Type: text/html; charset=UTF-8');

    if(!empty($args) && $body !== NULL){
        foreach($args as $key => $value){
            $body = str_replace('{'.strtoupper($key).'}', $value, $body);
        }
    }

    wp_mail($to, $subject, $body, $headers);
}

function send_msg_notification($to, $body){
	$to = '+' . str_replace('+', '', $to);
	$data = array(
		'to' => $to,
//		'to' => '+8801711040736',
		'body' => $body,
		'from' => true,
	);
	$twl = new Twilio_Integration(false, $data);
	return $twl->sendMessage();
}

function custom_user_profile_fields($user) {
    $user_meta = get_user_meta($user->ID);
    $birth_date = $user_meta['birth_date'][0] ? $user_meta['birth_date'][0] : '';
    $user_phone = $user_meta['user_phone'][0] ? $user_meta['user_phone'][0] : '';
    $zip_code = $user_meta['zip_code'][0] ? $user_meta['zip_code'][0] : '';
    $address = $user_meta['address'][0] ? $user_meta['address'][0] : '';
    $front_side = $user_meta['front_side'][0] ? $user_meta['front_side'][0] : '';
    $back_side = $user_meta['back_side'][0] ? $user_meta['back_side'][0] : '';
    $medical_id = $user_meta['medical_id'][0] ? $user_meta['medical_id'][0] : '';
    $photo_id = $user_meta['photo_id'][0] ? $user_meta['photo_id'][0] : '';
    $expired_date = $user_meta['expired_date'][0] ? $user_meta['expired_date'][0] : '';
    $status = $user_meta['status'][0] ? $user_meta['status'][0] : '';
    if(!empty($birth_date)):
    ?>
    <h2>Registration Information</h2>
    <table class="form-table">
        <?php if(!empty($birth_date)):?>
            <tr>
                <th>
                    <label for="user_birth_date"><?php _e('Birth Date'); ?></label>
                </th>
                <td>
                    <span class="user_birth_date"><?php echo date('d M, Y',strtotime($birth_date)); ?></span>
                </td>
            </tr>
        <?php endif;?>
        <?php if(!empty($user_phone)):?>
            <tr>
                <th>
                    <label for="user_user_phone"><?php _e('Phone'); ?></label>
                </th>
                <td>
                    <span class="user_user_phone"><?php echo $user_phone; ?></span>
                </td>
            </tr>
        <?php endif;?>
        <?php if(!empty($zip_code)):?>
            <tr>
                <th>
                    <label for="user_zip_code"><?php _e('Zip Code'); ?></label>
                </th>
                <td>
                    <span class="user_zip_code"><?php echo $zip_code; ?></span>
                </td>
            </tr>
        <?php endif;?>
        <?php if(!empty($address)):?>
            <tr>
                <th>
                    <label for="user_address"><?php _e('Address'); ?></label>
                </th>
                <td>
                    <span class="user_address"><?php echo $address; ?></span>
                </td>
            </tr>
        <?php endif;?>
        <?php if(!empty($front_side)):?>
            <tr>
                <th>
                    <label for="user_front_side"><?php _e('Front Side'); ?></label>
                </th>
                <td>
                    <a class="fancybox" rel="group" href="<?php echo $front_side; ?>"><img src="<?php echo $front_side; ?>" width="70px"></a>
                </td>
            </tr>
        <?php endif;?>
        <?php if(!empty($back_side)):?>
            <tr>
                <th>
                    <label for="user_back_side"><?php _e('Back Side'); ?></label>
                </th>
                <td>
                    <a class="fancybox" rel="group" href="<?php echo $back_side; ?>"><img src="<?php echo $back_side; ?>" width="70px"></a>
                </td>
            </tr>
        <?php endif;?>
        <?php if(!empty($medical_id)):?>
            <tr>
                <th>
                    <label for="user_medical_id"><?php _e('Medical ID'); ?></label>
                </th>
                <td>
                    <a class="fancybox" rel="group" href="<?php echo $medical_id; ?>"><img src="<?php echo $medical_id; ?>" width="70px"></a>
                </td>
            </tr>
        <?php endif;?>
        <?php if(!empty($photo_id)):?>
            <tr>
                <th>
                    <label for="user_photo_id"><?php _e('Photo ID'); ?></label>
                </th>
                <td>
                    <a class="fancybox" rel="group" href="<?php echo $photo_id; ?>"><img src="<?php echo $photo_id; ?>" width="70px"></a>
                </td>
            </tr>
        <?php endif;?>
        <?php if(!empty($expired_date)):?>
            <tr>
                <th>
                    <label for="medical_expired_date"><?php _e('Medical ID Expired On'); ?></label>
                </th>
                <td>
                    <span class="medical_expired_date"><?php echo date('d M, Y',strtotime($expired_date)); ?></span>
                </td>
            </tr>
        <?php endif;?>
        <?php if(!empty($status)):?>
            <tr>
                <th>
                    <label for="user_birth_date"><?php _e('Current Status'); ?></label>
                </th>
                <td>
                    <select name="user_status">
                        <option value="unapproved" <?php if(!empty($status) && $status == 'unapproved'){?>selected<?php };?>>Unapproved</option>
                        <option value="active" <?php if(!empty($status) && $status == 'active'){?>selected<?php };?>>Active</option>
                        <option value="inactive" <?php if(!empty($status) && $status == 'inactive'){?>selected<?php };?>>Inactive</option>
                </td>
            </tr>
        <?php endif;?>
    </table>
    <?php
    endif;
}

add_action('show_user_profile', 'custom_user_profile_fields', 100, 1);
add_action('edit_user_profile', 'custom_user_profile_fields', 100, 1);


add_action('edit_user_profile_update', 'update_user_status_data');

function update_user_status_data($user_id) {
    $userdata = get_userdata( $user_id );
    $user_email = $userdata->user_email;

    $full_name = get_user_meta($user_id, 'full_name', true);

    update_user_meta($user_id, 'status', $_POST['user_status']);

    if($_POST['user_status'] == 'active') {
        $approve_notification_email_send = get_field('approve_notification_email_send', 'option');
        if ($approve_notification_email_send) {
            $sub = get_field('approve_notification_email_subject','option');
            $subject = $sub ? $sub : 'Account approved.';
            $message = get_email_template('template-parts/email/user-approve-email');
            $u_args = array(
                'full_name' => $full_name
            );
            send_email_notification($user_email, $subject, $message, $u_args);
        }

        //Send SMS

        $allow_text_message = get_user_meta($user_id, 'allow_text_message', true);
        $user_phone = get_user_meta($user_id, 'user_phone', true);

        $send_sms = get_field('send_sms','option');
        if($send_sms == 'All Users' && $allow_text_message == 1) {
            $user_message = get_field('sms_text_for_approve_account','option');
            send_msg_notification($user_phone, $user_message);
        }
    }

    //Send SMS
    if($_POST['user_status'] == 'inactive') {
        $allow_text_message = get_user_meta($user_id, 'allow_text_message', true);
        $user_phone = get_user_meta($user_id, 'user_phone', true);

        $send_sms = get_field('send_sms','option');
        if($send_sms == 'All Users' && $allow_text_message == 1) {
            $user_message = get_field('sms_text_when_inactive_user','option');
            send_msg_notification($user_phone, $user_message);
        }
    }
}


function wp_registration_step_data_table_create() {

    if ( is_admin() && isset($_GET['activated'] )) {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        $table_name = $wpdb->prefix . 'registration_step_data';

        $sql = "CREATE TABLE $table_name (
		id int(11) NOT NULL AUTO_INCREMENT,
		user_email varchar(50) NOT NULL,
		form_data text NOT NULL,
		created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		status int(2) NOT NULL,
		PRIMARY KEY (id)
	) $charset_collate;";
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
    }

}

add_action("after_switch_theme", "wp_registration_step_data_table_create");

// Order items limit per page
add_filter( 'woocommerce_my_account_my_orders_query', 'my_account_orders_limits', 10, 1 );
function my_account_orders_limits( $args ) {
    $args['posts_per_page'] = 5;
    return $args;
}