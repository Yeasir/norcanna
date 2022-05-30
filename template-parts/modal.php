<?php
/**
 * All Modal
 */
?>

<!-- /.age-verification start -->
<div class="modal age-verification" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="d-lg-none d-md-none d-sm-block">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body p-0 m-0">
                <div class="container-fluid">
                    <div class="row d-flex align-items-md-center text-center">
                        <?php

                        $age_verification_title = get_field('age_verification_title', 'option');
                        $age_verification_content = get_field('age_verification_content', 'option');
                        $age_verification_enter = get_field('age_verification_enter', 'option');
                        $age_verification_exit = get_field('age_verification_exit', 'option');

                        $age_verification_footer_text = get_field('age_verification_footer_text', 'option');
                        $age_verification_image = get_field('age_verification_image', 'option');

                        if ( $age_verification_image ) :?>
                        <div class="col-md-6 col-12 bg-banner p-0">
                            <img src="<?php echo $age_verification_image; ?>" class="img-fluid" alt="">
                        </div>
                        <?php endif; ?>

                        <div class="col-md-6 col-12 p-0">
                            <div class="age-wrapper modal-content-wrapper">
                                <?php

                                if( $age_verification_title ) : ?>
                                <h4 class="modal-title"><?php echo $age_verification_title; ?></h4>
                                <hr class="mt-30 mb-0"/>
                                <?php endif;

                                if( $age_verification_content ) : ?>
                                <p class="mt-30 mb-0"><?php echo $age_verification_content; ?></p>
                                <?php endif;

                                if( $age_verification_enter ) : ?>
                                <a href="#" class="age-enter btn orange text-uppercase btn-block mt-30"><?php echo $age_verification_enter; ?></a>
                                <?php endif; ?>

                                <p class="enter-or-exit mt-30 mb-0"><span>OR</span></p>

                                <?php
                                if( $age_verification_exit ) : ?>
                                <a href="#" class="age-exit btn blue text-uppercase btn-block mt-30"><?php echo $age_verification_exit; ?></a>
                                <?php endif;

                                if( $age_verification_footer_text ) : ?>
                                <p class="mt-30"><span class="small"><?php echo $age_verification_footer_text; ?></span></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.age-verification end -->

<?php
if( !is_user_logged_in() ) :
    /**
     * Login Value
     */
    $login_title = get_field('login_title', 'option');
    $login_email_icon = get_field('login_email_icon', 'option');
    $password_email_icon = get_field('password_email_icon', 'option');
    $password_email_icon = get_field('password_email_icon', 'option');
    $login_submit_button = get_field('login_submit_button', 'option');
    $login_forgot_pass = get_field('login_forgot_pass', 'option');
    $login_dont_have_account_singup = get_field('login_dont_have_account_singup', 'option');
    $login_background_image = get_field('login_background_image', 'option');

    // If logged in then redirect my account page
    /*if ( class_exists( 'WooCommerce' ) ) {

        if ( !is_user_logged_in() ) {
            $redirect_to_myaccount_page =  wp_redirect( get_permalink( get_option('woocommerce_myaccount_page_id')) );
        }

    }*/

    //$redirect_to = '/';
    /**
     * Forgot Password Value
     */
    $forgot_password_title = get_field('forgot_password_title', 'option');
    $forgot_password_button_text = get_field('forgot_password_button_text', 'option');
    $forgot_password_input_icon = get_field('forgot_password_input_icon', 'option');
    $forgot_password_background_image = get_field('forgot_password_background_image', 'option');

    ?>
<!-- /.login-modal start -->
<div class="modal login-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="d-lg-none d-md-none d-sm-block">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body p-0 m-0">
                <div class="container-fluid">

                    <div class="row d-flex align-items-md-center text-center">
                        <div class="col-md-6 col-12 p-0">
                            <div class="login-wrapper modal-content-wrapper">
                                <?php

                                if( $login_title ) : ?>
                                    <h4 class="modal-title"><?php echo $login_title; ?></h4>
                                    <hr/>
                                <?php endif; ?>

                                <form name="loginform" id="loginFrm" action="<?php echo site_url( '/wp-login.php' ); ?>" method="post">
                                    <div class="form-row align-items-center">

                                        <div class="input-group mb-2">

                                            <?php if( $login_email_icon ) : ?>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="fa <?php echo $login_email_icon; ?>"></i></div>
                                            </div>
                                            <?php endif; ?>

                                            <input type="text" class="form-control" name="log" value="" placeholder="Email or Username" required>
                                        </div>

                                        <div class="input-group mb-2">
                                            <?php if( $password_email_icon ) : ?>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="fa <?php echo $password_email_icon; ?>"></i></div>
                                            </div>
                                            <?php endif; ?>
                                            <input type="password" class="form-control" name="pwd" value="" placeholder="Password" required>
                                        </div>
                                        <div class="ml-auto mr-auto submit-forget-pass width-100">

                                            <?php if( $login_submit_button ) : ?>
                                                <span class="error-alert d-none" style="color: #e3142a;position: absolute;right: 0;left: 0;"></span>
                                                <div class="wait wait-login" id="wait2" style="display:none; position: absolute;right: 46%;width: 40px;top: 52%;"></div>
                                            <button type="submit" class="btn orange loginBtn"><?php echo $login_submit_button; ?></button>
                                            <?php endif;

                                            if( $login_forgot_pass ) :  ?>
                                            <a href="#" class="d-block forgot-action"><?php echo $login_forgot_pass; ?></a>
                                            <?php endif; ?>

                                        </div>

                                        <?php if( $login_dont_have_account_singup ) : ?>
                                        <div class="clearfix"></div>
                                        <div class="account-register d-block">
                                            <a href="#"><?php echo esc_html( $login_dont_have_account_singup ); ?><span class="sing-up"> Sign up</span></a>
                                        </div>
                                        <?php endif; ?>

                                    </div>

                                    <!--<input type="hidden" value="<?php //echo esc_attr( $redirect_to_myaccount_page ); ?>" name="redirect_to">-->
                                    <input type="hidden" value="1" name="norconnalogin">
                                </form>
                            </div>
                        </div>

                        <?php if ( $login_background_image ) : ?>
                            <div class="col-md-6 col-12 bg-banner p-0">
                            <img src="<?php echo $login_background_image; ?>" class="img-fluid" alt="">
                        </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.login-modal end -->

<!-- /.forgot-password-modal start -->
<div class="modal forgot-password-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="d-lg-none d-md-none d-sm-block">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body p-0 m-0">
                <div class="container-fluid">
                    <div class="row d-flex align-items-md-center text-center">
                        <div class="col-md-6 col-12 p-0">
                            <div class="login-wrapper modal-content-wrapper">
                                <?php

                                if( $forgot_password_title ) : ?>
                                    <h4 class="modal-title text-capitalize"><?php echo $forgot_password_title; ?></h4>
                                    <hr/>
                                <?php endif; ?>

                                <form action="<?php echo site_url( '/wp-login.php?action=lostpassword' ); ?>" method="post">
                                    <div class="form-row align-items-center">
                                        <p>Username or email</p>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="fa <?php echo $forgot_password_input_icon; ?>"></i></div>
                                            </div>
                                            <input type="text" class="form-control" name="user_login" value="" placeholder="Username or Email" required>
                                        </div>
                                        <div class="ml-auto mr-auto submit-forget-pass width-100">
                                            <button type="submit" class="btn orange"><?php echo $forgot_password_button_text; ?></button>
                                        </div>
                                    </div>
                                    <!--<input type="hidden" name="redirect_to" value="<?php //echo $redirect_to; ?>">-->
                                </form>
                            </div>
                        </div>
                        <?php if ( $forgot_password_background_image ) : ?>
                            <div class="col-md-6 col-12 bg-banner p-0">
                                <img src="<?php echo $forgot_password_background_image; ?>" class="img-fluid" alt="">
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.forgot-password-modal end -->
<?php endif; ?>
<!-- /.register-modal start -->
<div class="modal register-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="d-lg-none d-md-none d-sm-block">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body p-0 m-0">
<div class="container-fluid">
<div class="row d-flex align-items-md-center text-center">
<div class="col-md-12 col-12 p-0">
<div class="register-wrapper modal-content-wrapper">
<form action="" name="RegForm" id="regForm"  method="post">
    <ul class="list-inline text-uppercase mb-4 progress-bar-fix register-top-bar">
        <li class="active list-inline-item mb-1">1. Registration</li>
        <li class="list-inline-item mb-1">2. Upload ID</li>
        <li class="list-inline-item mb-1">3. Upload photo</li>
    </ul>
    <!-- /.register-form start -->
    <?php
    //if(isset($_GET['autosave']) && wp_verify_nonce( $_GET['_wpnonce'], 'back-user' ) ) {
    if(isset($_GET['autosave'])) {
        global $wpdb;
        $id = $_GET['autosave'];
        $table_registration = $wpdb->prefix . 'registration_step_data';
        $sql = "SELECT * FROM $table_registration WHERE id = $id";
        $res = $wpdb->get_row( $sql );
        $id = $res->id;
        $user_email = $res->user_email;
        $form_data = unserialize($res->form_data);
        $status = $res->status;
        ?>
            <script>
                jQuery(document).ready(function(){
                    jQuery(".register-modal").modal("show");
                    jQuery('input#datepicker' )[0].focus();
                });
            </script>
    <?php
    }
    ?>
    <div class="row register-form rform_wrap">
        <div class="col-12 col-md-6">
            <div class="input-group-items position-relative validation_required <?php if(!empty($form_data['full-name'])){ echo 'validation-success';}?>" id="fname_validation">
                <i class="fa fa-user"></i>
                <input type="text" class="form-control" name="full-name" id="full-name"
                       placeholder="FULL NAME" value="<?php if(!empty($form_data['full-name'])){ echo $form_data['full-name'];}?>" required>
            </div>
            <span class="error-span">Please provide your full name!</span>
        </div>
        <div class="col-12 col-md-6">
            <div class="input-group-items position-relative validation_required <?php if(!empty($form_data['birth-date'])){ echo 'validation-success';}?>" id="date_validation">
                <i class="fa fa-calendar"></i>
                <input type="text" class="form-control" id="datepicker" name="birth-date"
                       placeholder="BIRTH DATE" value="<?php if(!empty($form_data['birth-date'])){ echo $form_data['birth-date'];}?>" required>
            </div>
            <span class="error-span">You must be 18+</span>
        </div>
        <div class="col-12 col-md-6">
            <div class="input-group-items position-relative validation_required <?php if(!empty($form_data['email'])){ echo 'validation-success';}?>" id="email_validation">
                <i class="fa fa-envelope-o"></i>
                <input type="email" class="form-control" name="email"
                       placeholder="E-MAIL" value="<?php if(!empty($form_data['email'])){ echo $form_data['email'];}?>" required>
                <div class="yloader"></div>
            </div>
            <span class="error-span" data-invalid="Invalid Email!" data-ajax="Your email is not available">Invalid Email</span>
        </div>
        <div class="col-12 col-md-6">
            <div class="input-group-items position-relative" id="phone_validation">
                <i class="fa fa-phone"></i>
                <input type="tel" class="form-control" name="phone"
                       placeholder="PHONE NUMBER" value="<?php if(!empty($form_data['phone'])){ echo $form_data['phone'];}?>">
            </div>

            <label class="checkbox-inline" style="font-size: 12px;vertical-align: top">
                <input type="checkbox" name="allow_text_message" value="1" style="margin-right: 5px" <?php if(isset($form_data['allow_text_message']) && $form_data['allow_text_message'] == 1){ echo 'checked';}?>> Allow SMS (TexT) Messages
            </label>
        </div>

        <div class="col-12 col-md-6">
            <div class="input-group-items position-relative validation_required <?php if(!empty($form_data['user-password'])){ echo 'validation-success';}?>" id="pass_validation">
                <i class="fa fa-lock"></i>
                <input id="password" type="password" class="form-control" name="user-password"
                       placeholder="PASSWORD" value="<?php if(!empty($form_data['user-password'])){ echo $form_data['user-password'];}?>" required>
            </div>
            <span class="error-span">Please provide your Password!</span>
        </div>
        <div class="col-12 col-md-6">
            <div class="input-group-items position-relative validation_required <?php if(!empty($form_data['zip-code'])){ echo 'validation-success';}?>" id="zip_validation">
                <i class="fa fa-home"></i>
                <input type="text" class="form-control" name="zip-code"
                       placeholder="ZIP CODE" value="<?php if(!empty($form_data['zip-code'])){ echo $form_data['zip-code'];}?>">
            </div>
            <span class="error-span" data-invalid="Please provide a zip in the format #####" data-ajax="Sorry, our service is not available in your area.">Please provide a zip in the format #####</span>
        </div>
        <div class="col-12 col-md-6">
            <div class="input-group-items position-relative validation_required <?php if(!empty($form_data['confirm-pass'])){ echo 'validation-success';}?>" id="confirm_pass_validation">
                <i class="fa fa-lock"></i>
                <input id="confrim_pass" type="password" class="form-control" name="confirm-pass"
                       placeholder="CONFIRM PASSWORD" value="<?php if(!empty($form_data['confirm-pass'])){ echo $form_data['confirm-pass'];}?>">
            </div>
            <span class="error-span">Password Does not match..!</span>
        </div>
        <div class="col-12 col-md-6">
            <div class="input-group-items position-relative" id="address_validation">
                <i class="fa fa-map-marker"></i>
                <input type="text" class="form-control" name="address"
                       placeholder="ADDRESS" value="<?php if(!empty($form_data['address'])){ echo $form_data['address'];}?>">
            </div>
        </div>
        <div class="clearfix"></div>

        <div class="col-lg-6 col-md-6 col-sm-7 col-12 text-left mt-lg-5 mt-md-4 mt-sm-4 mt-4">

            <div class="clearfix"></div>

            <div class="checkbox-style mb-sm-2 validation_required <?php if(!empty($form_data['email'])){ echo 'validation-success';}?>" id="terms_validation">
                <input type="checkbox" id="agree-terams" <?php if(!empty($form_data['email'])){ echo 'checked';}?>>
                <label class="form-check-label inline" for="agree-terams">I agree the <a
                        href="#" class="underline">terms and conditions</a></label>
                <span class="error-span">You must agree to our Terms and Conditions to Continue.</span>
            </div>

        </div>
        <div class="col-lg-6 col-md-6 col-sm-5 col-12 mt-lg-5 mt-md-3 mt-sm-4 mt-3 text-lg-right text-sm-right text-left">
            <a href="#" id="next" class="next btn back-btn text-uppercase ">next
                <i class="fa fa-angle-right"></i></a>
        </div>
        <div class="already-have-account mt-5 col-12 text-left">
            <a href="#">Already have an account? <span>Log In</span></a>
        </div>
    </div>
    <!-- /.register-form end -->
    <!-- /.upload-id start -->
    <div class="row upload-id rform_wrap">
        <h5 class='alert alert-warning col-12 d-none photo-back-front-alert'></h5>
        <div class="col-lg-8 col-md-8 col-sm-12 text-center back-side-id">
            <div id="dz_upload1" class="dz-message needsclick id-upload-fix">
                <img src="<?php echo URL; ?>/images/back-side.png" class="img-fluid" >
                <h5>Front Side</h5>
                <p>Drag and drop photo here or just click to <span class="dz-message needsclick dz-clickable">browse</span> files</p>
            </div>

            <div id="dz_upload2" class="dz-message needsclick id-upload-fix" style="display: none;">
                <img src="<?php echo URL; ?>/images/back-side.png" class="img-fluid" >
                <h5>Back Side</h5>
                <p>Drag and drop photo here or just click to <span class="dz-message needsclick dz-clickable">browse</span> files</p>
            </div>

            <p id="dz_upload1_err" class="validation_required"><span class="error-span">Please Upload both Front &amp; Back Side of your ID</span></p>

            <div id="dz_upload3" class="dz-message needsclick id-upload-fix" style="margin-top: 30px; display: none">
                <img src="<?php echo URL; ?>/images/back-side.png" class="img-fluid" >
                <h5>Medical ID</h5>
                <p>Drag and drop photo here or just click to <span class="dz-message needsclick dz-clickable">browse</span> files</p>
            </div>

            <p id="dz_upload3_err" class=""><span class="error-span">Please upload medical ID</span></p>

            <div id="expired-date" class="input-group-items expired-date d-none">
                <i class="fa fa-calendar"></i>
                <input type="text" class="form-control" id="expired_date" name="expired_date"
                       placeholder="Expired Date">
                <span class="error-span">Please select a valid expire date.</span>
            </div>

        </div>
        <div  class="col-lg-4 col-md-4 col-sm-12 font-side-fix text-left" id="dz_preview_wrap">
            <div class="preview_container_front dropzone-previews" id="preview_container_front"></div>
            <div class="preview_container_back dropzone-previews" id="preview_container_back"></div>
            <div class="preview_container_mid dropzone-previews" id="preview_container_mid"></div>
        </div>
        <div class="clearfix"></div>

        <div class="col-lg-6 col-md-6 col-sm-12 text-lg-left text-md-left text-sm-center mt-3">
            <div class="text-uppercase">
                <a href="#" id="back" class="back btn back-btn "><i class="fa fa-angle-left ml-0 mr-2"></i> back</a>
            </div>

        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 text-lg-right text-md-right text-sm-center  mt-3">

            <div class="ml-lg-auto ml-sm-auto ml-auto text-uppercase">
                <a href="#" id="next_up" class="next btn back-btn ">next <i class="fa fa-angle-right ml-2 mr-0"></i></a>
            </div>
        </div>


    </div>
    <!-- /.upload-id end -->
    <!-- /.upload-photo start -->
    <div class="row upload-photo rform_wrap">
        <div class="col-12 col-md-8 text-center font-side-id">
            <h4 class="success_msg" style="display: none;"></h4>
            <div id="dz_upload4" class="dz-message needsclick photo-upload-fix">
                <img src="<?php echo URL; ?>/images/back-side.png" class="img-fluid" >
                <h5 class="text-uppercase">upload photo</h5>
                <p>Drag and drop photo here or just click to <span class="dz-message needsclick dz-clickable">browse</span> files</p>
            </div>

            <p id="dz_upload4_err" class="validation_required"><span class="error-span">Please Upload Your Photo</span></p>
        </div>

        <div class="col-12 col-md-4 font-side-fix text-left"  id="dz_preview_wrap">
            <div class="preview_container_pto dropzone-previews" id="preview_container_pto"></div>
        </div>
        <div class="clearfix"></div>

        <div class="col-lg-6 col-md-6 col-sm-12 text-lg-left text-md-left text-sm-center mt-3">
            <div class="text-uppercase"><a href="#" id="back_up" class="back btn back-btn "><i class="fa fa-angle-left ml-0 mr-2"></i> back</a></div>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 text-lg-right text-md-right text-sm-center  mt-3">
            <div class="ml-lg-auto ml-auto text-uppercase">

                <input type="hidden" name="front_side" id="front_side" value="">
                <input type="hidden" name="back_side" id="back_side" value="">
                <input type="hidden" name="medical_id" id="medical_id" value="">
                <input type="hidden" name="photo_id" id="photo_id" value="">
                <input type="hidden" name="create_user" value="1">
                <button type="submit" class="btn orange" id="create_account">CREATE ACCOUNT</button>

            </div>
        </div>

    </div>
    <!-- /.upload-photo end -->
</form>
</div>
</div>
</div>
</div>
            </div>

            <div class="wait wait-reg" id="wait2"></div>
        </div>
    </div>
</div>
<!-- /.register-modal end -->



<!-- /.contact-us-model start -->
<div class="modal contact-us-model" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="d-lg-none d-md-none d-sm-block">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="container">
                    <div class="row">
                        <div class="col-lg-7 col-md-8 col-sm-12 mt-5">
                            <h2>Contact Us</h2>
                            <p>You can easily write to us right now</p>
                            <form action="" method="post" class="form-inline mt-4 overflow-hidden">
                                <div class="radio">
                                    <input id="General_Inquiry" value="" name="choseTtype" type="radio" checked value="general-inquiry">
                                    <label for="General_Inquiry" class="radio-label form-check-label text-capitalize">General
                                        Inquiry</label>
                                </div>
                                <div class="radio order-Support">
                                    <input id="Order_Support" name="choseTtype" type="radio" value="order-support">
                                    <label for="Order_Support" class="radio-label form-check-label text-capitalize">Order
                                        Support</label>
                                </div>
                                <div class="radio">
                                    <input id="Website_Error" name="choseTtype" type="radio" value="website-error">
                                    <label for="Website_Error" class="radio-label form-check-label text-capitalize">Website
                                        Error</label>
                                </div>
                                <div class="row mt-5">
                                    <div class="col-md-6 col-12">
                                        <input type="text" class="form-control" placeholder="You name" name="name"
                                               value="">
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <input type="text" class="form-control" placeholder="Your e-mail" name="email"
                                               value="">
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <textarea class="form-control" rows="3" cols="48"
                                                  placeholder="Your message" name="message"></textarea>
                                    </div>
                                    <div class="col-md-12 col-12  order-field">
                                        <input type="number" class="form-control" placeholder="Order Number" name="ordernumber" value="">
                                    </div>
                                </div>
                                <div class="ml-lg-auto ml-0 mt-4">
                                    <button type="submit" class="btn orange text-uppercase" name="senMessage">Send message</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-5 col-md-4 col-sm-12 popup-contact-info">
                            <img src="images/contact-us-logo.png" class="img-fluid">
                            <ul class="list-unstyled">
                                <li>
                                    E-mail:
                                    <a href="mailto:norcanna@gmail.com">norcanna@gmail.com</a>
                                </li>
                                <li>
                                    Phone
                                    <a href="tel:1-877-420-2015">1-877-420-2015</a>
                                </li>
                                <li>
                                    Address:
                                    <p>2795 East Bidwell St. Suite 100 #242 Folsom, California 95630</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- /.contact-us-model end -->

<!-- /.advanced-search-model start -->
<div class="modal advanced-search-model" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <form action="" class="col-12">
                            <!-- /.search-target start -->
                            <div class="position-relative search-target">
                                <button type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                                <input type="text" class="form-control" value="" name="search" />
                            </div>
                            <!-- /.search-target end -->
                            <!-- /.advanced-search-wrapper start -->
                            <div class="advanced-search-wrapper">
                                <!-- /.search-padding start -->
                                <div class="search-padding mb-4">
                                    <h6 class="text-uppercase">shop</h6>
                                    <!-- /.search-product-items start -->
                                    <div class="search-product-items d-flex align-items-center">
                                        <div class="product-thumbs mr-lg-5 mr-sm-2 mr-1">
                                            <span></span>
                                            <a href="#">
                                                <img src="images/search-product.png" class="img-fluid" alt="" >
                                            </a>
                                        </div>
                                        <a href="#" class="product-title mr-lg-5 mr-sm-2 mr-1">Old Pal</a>
                                        <a href="#" class="product-cat mr-lg-5 mr-sm-2 mr-1">Sativa</a>
                                        <p class="mb-0 highlight"><span>Marijuana</span></p>
                                    </div>
                                    <!-- /.search-product-items end -->
                                    <!-- /.search-product-items start -->
                                    <div class="search-product-items d-flex align-items-center">
                                        <div class="product-thumbs mr-lg-5 mr-sm-2 mr-1">
                                            <span></span>
                                            <a href="#">
                                                <img src="images/search-product.png" class="img-fluid" alt="" >
                                            </a>
                                        </div>
                                        <a href="#" class="product-title mr-lg-5 mr-sm-2 mr-1">Old Pal</a>
                                        <a href="#" class="product-cat mr-lg-5 mr-sm-2 mr-1">Sativa</a>
                                        <p class="mb-0 highlight"><span>Marijuana</span></p>
                                    </div>
                                    <!-- /.search-product-items end -->
                                    <!-- /.search-product-items start -->
                                    <div class="search-product-items d-flex align-items-center">
                                        <div class="product-thumbs mr-lg-5 mr-sm-2 mr-1">
                                            <span></span>
                                            <a href="#">
                                                <img src="images/search-product.png" class="img-fluid" alt="" >
                                            </a>
                                        </div>
                                        <a href="#" class="product-title mr-lg-5 mr-sm-2 mr-1">Old Pal</a>
                                        <a href="#" class="product-cat mr-lg-5 mr-sm-2 mr-1">Sativa</a>
                                        <p class="mb-0 highlight"><span>Marijuana</span></p>
                                    </div>
                                    <!-- /.search-product-items end -->
                                    <div class="show-more-search">
                                        <span><span></span></span>Show all 7 results
                                    </div>
                                </div>
                                <!-- /.search-padding end -->
                                <!-- /.search-padding start -->
                                <div class="search-padding mb-4">
                                    <h6 class="text-uppercase">FAQ</h6>
                                    <!-- /.search-faq start -->
                                    <div class="search-faq fa-style">
                                        <p><a href="#">
                                                <i class="fa fa-question"></i>
                                                Is medical <span class="highlight">marijuana</span> legal?
                                            </a></p>
                                        <p><a href="#">
                                                <i class="fa fa-question"></i>
                                                How can I get medical <span class="highlight">marijuana</span> recommendation?
                                            </a></p>
                                        <div class="show-more-search">
                                            <span><span></span></span>Show all 10 results
                                        </div>
                                    </div>
                                    <!-- /.search-faq end -->
                                </div>
                                <!-- /.search-padding end -->
                                <!-- /.search-padding start -->
                                <div class="search-padding">
                                    <h6 class="text-uppercase">Rules</h6>
                                    <!-- /.search-faq start -->
                                    <div class="search-faq fa-style">
                                        <p>
                                            <a href="#">
                                                <i class="fa fa-file"></i>
                                                ...lorem ipsum <span class="highlight">marijuana</span> dolor... Is medical
                                            </a>
                                        </p>
                                        <p>
                                            <a href="#">
                                                <i class="fa fa-file"></i>
                                                ...lorem ipsum <span class="highlight">marijuana</span> dolor... Is medical
                                            </a>
                                        </p>
                                        <div class="show-more-search">
                                            <span><span></span></span>Show all 3 results
                                        </div>
                                    </div>
                                    <!-- /.search-faq end -->
                                </div>
                                <!-- /.search-padding end -->
                            </div>
                            <!-- /.advanced-search-wrapper end -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.advanced-search-model end -->



<!-- /.advanced-search-model start -->
<div class="modal reg-success-model" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <p style="padding: 10px;color: green;">Registration successfully completed!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.advanced-search-model end -->

<!-- /.single-product start -->
<div class="modal single-product-model" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="d-lg-none d-md-none d-sm-block">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="woocommerce-notices-wrapper"></div>

            </div>
        </div>
    </div>
</div>
<!-- /.single-product end -->