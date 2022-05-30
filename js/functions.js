;(function ($, window, document, undefined) {
    var $win = $(window);
    var $doc = $(document);
    var $body = $('body');

    $doc.ready(function () {
        if(js_vars.r_status == 1){
            $(".reg-success-model").modal("show");
            setTimeout(function() {$('.reg-success-model').modal('hide');}, 4000);
        }

        var today = new Date();
            $register_form = $body.find('.register-modal'),
                $pc_category_wrap = $body.find('.pc-category-wrap'),
                $pf_form = $body.find( "#product_filter_form" ),
                $register_bar_list = $register_form.find('.register-top-bar li'),
                dz_upload1, dz_upload2, dz_upload3,dz_upload4,
                $dz_upload1 = $body.find('#dz_upload1'),
                $dz_upload2 = $body.find("#dz_upload2"),
                $dz_upload3 = $body.find("#dz_upload3"),
                $dz_upload4 = $body.find("#dz_upload4"),
                $md_expire_date = $body.find('#expired-date'),
                $datepicker = $body.find( "#datepicker" ),
                $expired_date = $body.find( "#expired_date" );

        // Open Menu
        $body.on("click", '.menu-toggle-btn', function (e) {
            e.preventDefault();
            $(".header").toggleClass('menu-opened');
            $(".main-menu").toggleClass('opened-left');
            $body.toggleClass('menu-has');
        });

        if ( $(".sign-success-msg").length > 0 ){

        }
        // Mini cart
        $body.on("click", '.cart-btn-trig', function (e) {
            e.preventDefault();
            var header = $(".header");
            header.removeClass('menu-opened');
            $body.removeClass('menu-has');
            $body.toggleClass('cart-has');
            $(".main-menu").removeClass('opened-left');
            header.toggleClass('cart-opened');
            $(".mini-cart").toggleClass('opened-right');
        });
        // Scroll Down
        $body.on("click", '.scroll-down-action', function (e) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: $("main").offset().top
            }, 2000);
        });
        //deleteCookie('AgeVerified');
        if (getCookie("AgeVerified") != "true") {
            // age-verification
            $(".age-verification").modal("show");
        }
        // Popup Contact form radio button event
        var orderField = $(".order-field");
        orderField.hide();
        $(".radio input[type='radio']").click(function(){

            var that = $(this).val();
            orderField.hide();

            if( that == 'order-support' ){
                orderField.show();
            }

        });
        // Order status click event
        $body.on("click", '.delivered-processed a', function (e) {
            e.preventDefault();

            var This = $(this).attr('data-com-pro');
            var hideShow = $('.woocommerce-MyAccount-content table tbody tr');

            hideShow.css('display', 'none');
            $('.woocommerce-MyAccount-content table tbody tr[data-order-event="'+ This +'"]').css('display', 'table-row');

            if( This == 'all' ){
                hideShow.css('display', 'table-row');
            }

        });

        $body.on("click", '.sing-up', function (e) {
            e.preventDefault();
            $(".register-modal").modal("show");
        });
        $body.on("click", '.account-register a', function (e) {
            e.preventDefault();
            $(".login-modal").modal("hide");
            $(".register-modal").modal("show");
        });

        // Login
        $body.on("click", '.sing-in', function (e) {
            e.preventDefault();
            $(".login-modal").modal("show");
        });
        $body.on("click", '.already-have-account a', function (e) {
            e.preventDefault();
            $(".register-modal").modal("hide");
            $(".login-modal").modal("show");
        });

        // Forgot Pass
        $body.on("click", '.forgot-action', function (e) {
            e.preventDefault();
            $(".login-modal").modal("hide");
            $(".forgot-password-modal").modal("show");
        });

        //header-search
        $body.on("click", '.header-search', function () {
            $body.toggleClass('advance-search-modal-has');
            $(".advanced-search-model").modal("show");
        });
        // Age Exit
        $body.on("click", '.age-exit', function (e) {
            e.preventDefault();
            window.location.replace("https://www.google.com/");
        });
        // Age Enter
        $body.on("click", '.age-enter', function (e) {
            e.preventDefault();
            SetCookieForAge();
            $(".age-verification").modal("hide");
        });
        $(".category-slider").slick({
            dots: false,
            infinite: true,
            slidesToShow: 3,
            slidesToScroll: 1,
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1,
                        infinite: true,
                        dots: false
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        dots: false,
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        dots: false,
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]

        });
        $(".pr-category-slider").slick({
            dots: false,
            infinite: true,
            slidesToShow: 3,
            slidesToScroll: 1,
            responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1,
                        infinite: true,
                        dots: false
                    }
                },
                {
                    breakpoint: 980,
                    settings: {
                        dots: false,
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        dots: false,
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]

        });

        var $slider1 = $(".pcsw-slider"),
            sl1_length = $slider1.children('div').length - 1;
        $slider1.slick({
            dots: true,
            infinite: false,
            slidesToShow: 1,
            slidesToScroll: 1,
        });

        // Age Enter
        $('#commentform').hide();
        $('#comment_sub').hide();
        $body.on("click", '#reply-title', function (e) {
            e.preventDefault();
            $(this).hide();
            $('#commentform').show();
            $('#comment_sub').show();
        });

        $body.on("click", '#comment_sub', function (e) {
            e.preventDefault();
            $(this).hide();
            $('#reply-title').show();
            $('#commentform').hide();
        });


        //$(".single-product-model").modal("show");
        $body.on( "click", '.product .woocommerce-loop-product__link', function (e) {
            e.preventDefault();
            var pid = $(this).attr('data-pid');
            $.ajax({
                method: 'POST',
                url: js_vars.ajaxurl,
                data: { action: "load_single_product", pid: pid},
                dataType: "json",
                async:false,
                success: function (response) {
                    $('.single-product-model .modal-body').append(response.html);
                    $(".single-product-model").modal("show");
                    cat_slider('category-slider');
                }
            });
        });

        // Slider Resize in Quick View Modal
        $(".single-product-model").on('shown.bs.modal', function () {
            $(".category-slider").resize();
        });


        $(".service-message-model").modal("show");
        $(".service-message-model-avaiable").modal("show");

        $(".payment-method-model").modal("show");
        $(".delivery-model").modal("show");
        $body.on("click", '#continue', function (e) {
            e.preventDefault();
            $(".payment-method-model").modal("show");
            $(".delivery-model").modal("hide");
        });

        $datepicker.datepicker({
            beforeShow: function(input, inst) {
                $(document).off('focusin.bs.modal');
            },
            onClose:function(){
                $(document).on('focusin.bs.modal');
                $datepicker.trigger('blur');
            },
            changeYear: true,
            dateFormat: 'mm/dd/yy',
            yearRange : '-100:+0'
        });


        $expired_date.datepicker({
                onClose:function(){
                    $(document).on('focusin.bs.modal');
                    $expired_date.trigger('blur');
                },
                changeYear: true,
                dateFormat: 'mm/dd/yy',
                yearRange : today.getFullYear() +':+10'
        });

        $('#timepicker').timepicker({timeFormat: 'hh/mm'});


        $(".product-filter-select").chosen({disable_search_threshold: 10});

        //$("#price_slide_input").slider({});
        var quantitiy = 0;
        $('.quantity-right-plus').click(function (e) {
            e.preventDefault();
            // Get the field name
            var quantity = parseInt($('#quantity').val());
            $('#quantity').val(quantity + 1);
        });
        $('.quantity-left-minus').click(function (e) {
            // Stop acting like a button
            e.preventDefault();
            // Get the field name
            var quantity = parseInt($('#quantity').val());
            if (quantity > 0) {
                $('#quantity').val(quantity - 1);
            }
        });



        //$('.register-form').addClass('d-none');
         $('.upload-id').addClass('d-none');
        $('.upload-photo').addClass('d-none');

        function validateEmail(email) {
            var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(email);
        }

        function setTabIndex() {
            $register_form.find('.register-form input').each(function (i) {

                var $this = $(this),
                    index = i+1;
                if($this.attr('name') == 'zip-code'){
                    index += 1;
                } else if($this.attr('name') == 'confirm-pass'){
                    index -= 1;
                }
                $this.attr('tabindex', index);
            });
        }
        setTabIndex();

        $register_form.find('.register-form input').on('focus', function () {
            $(this).closest('.input-group-items').addClass('focused');
        }).on('blur', function () {
            $(this).closest('.input-group-items').removeClass('focused');
        });

        function setClassOnCondition($elem, condition) {
            if(condition){
                $elem.addClass('validation-success').removeClass('validation-error');
            } else {
                $elem.addClass('validation-error').removeClass('validation-success');
            }
        }

        function modify_error_txt($elem, $is_ajax){
            $elem.text($elem.attr('data-invalid'));
            if($is_ajax){
                $elem.text($elem.attr('data-ajax'));
            }
        }

        function check_validation_form($elem){
            var validation = true;

            $elem.find('.validation_required').each(function () {
                var $this = $(this),
                    elem_val = true;
                if($this.hasClass('validation-error') || !$this.hasClass('validation-success')){
                    elem_val = false;
                    setClassOnCondition($this, false);
                }
                if(validation){
                    validation = elem_val;
                }
            });

            return validation;
        }

        /**
         * Register Validation
         */
        $body.on('blur', 'input[name="full-name"]', function (e) {
            var $this = $(this);
            setClassOnCondition(
                $this.closest('.validation_required'),
                ($this.val().length > 2)
                );
        }).on('blur', 'input[name="birth-date"]', function (e) {
            var $this = $(this),
                elem = $this.closest('.validation_required'),
                val = $this.val(),
                condition = val.length;

            if(condition){
                var age = getAge(val);
                if (age >= 18) {

                    if (age >= 18 && age <= 20) {
                        $dz_upload3.show().addClass("dz-upload3-photo");
                        $md_expire_date.removeClass('d-none');
                        $register_form.find('#dz_upload3_err').addClass('validation_required');
                        $md_expire_date.addClass('validation_required');
                    }else{
                        $dz_upload3.hide();
                        $md_expire_date.addClass('d-none');
                        $register_form.find('#dz_upload3_err').removeClass('validation_required');
                        $md_expire_date.removeClass('validation_required');
                    }

                } else {
                    condition = false;
                    $dz_upload3.hide();
                }

            }
            setClassOnCondition(elem, condition);
        }).on('blur', 'input[name="email"]', function (e) {
            var $this = $(this),
                val = $this.val(),
            condition = validateEmail(val),
                $elem =  $this.closest('.validation_required');
            modify_error_txt($elem.next('.error-span'), false);
            if(condition){
                $elem.addClass('yloader-open');
                $.ajax({
                    method: 'POST',
                    url: js_vars.ajaxurl,
                    data: { action: "norcanna_validate_email", email: val},
                    dataType: "json",
                    async:false,
                    success: function (response) {
                        if(response.status == 'error'){
                            condition = false;
                            modify_error_txt($elem.next('.error-span'), true);
                        }
                        setClassOnCondition(
                            $elem,
                            condition
                        );
                        setTimeout(function () {
                            $elem.removeClass('yloader-open');
                        }, 500);
                    }
                });
            } else {
                setClassOnCondition(
                    $elem,
                    condition
                )
            }
        }).on('blur', 'input[name="user-password"]', function (e) {
            var $this = $(this);
            setClassOnCondition(
                $this.closest('.validation_required'),
                ($this.val().length > 2)
            )
        }).on('blur', 'input[name="confirm-pass"]', function (e) {
            var $this = $(this);
            setClassOnCondition(
                $this.closest('.validation_required'),
                ($this.val().length > 2 && $register_form.find('input[name="user-password"]').val() == $this.val())
            )
        }).on('blur', 'input[name="zip-code"]', function (e) {
            var $this = $(this),
                val = $.trim($this.val()),
                condition = (val.length == 5 && jQuery.isNumeric( val )),
                $elem =  $this.closest('.validation_required');
            modify_error_txt($elem.next('.error-span'), false);
            if(condition) {
                condition = $.isArray(js_vars.available_service) && ($.inArray(val, js_vars.available_service) !== -1);
                if(!condition){
                    modify_error_txt($elem.next('.error-span'), true);
                }
            }
            setClassOnCondition(
                $this.closest('.validation_required'),
                condition
            )
        }).on("change", '#agree-terams', function (e) {
            var $this = $(this);
            setClassOnCondition($this.closest('.validation_required'), $this.is(':checked'));
        }).on("blur", '#expired_date', function (e) {
            var $this = $(this),
                val = $this.val();
            setClassOnCondition($this.closest('.validation_required'), (val.length && today <= new Date(val)));
        });


        var index_show = 0;
        function next_action($elem){
            $elem.next().removeClass('d-none');
            $elem.addClass('d-none');
            index_show += 1;
            $register_bar_list.removeClass('active');
            $register_bar_list.eq(index_show).addClass('active');
        }
        function back_action($elem){
            $elem.prev().removeClass('d-none');
            $elem.addClass('d-none');
            index_show -= 1;
            $register_bar_list.removeClass('active');
            $register_bar_list.eq(index_show).addClass('active');
        }
        $body.on("click", '#next', function (e) {
            e.preventDefault();
            /*var confrim_pass = $("#confrim_pass").val();
            var name = document.forms["RegForm"]["full-name"];
            var email = document.forms["RegForm"]["email"];
            var birth_date = document.forms["RegForm"]["birth-date"];
            var zip = document.forms["RegForm"]["zip-code"];
            var user_password = document.forms["RegForm"]["user-password"];
            if (name.value == "") {
                $('#emty_name').removeClass('d-none');
                $('#emty_name').html('Please provide your full name!');

                name.focus();
                return false;
            } else {
                $('#emty_name').addClass('d-none');
            }

            if (birth_date.value == "") {
                $('#emty_date').removeClass('d-none');
                $('#emty_date').html('Please provide your Birth Date!');
                birth_date.focus();
                return false;
            } else {
                $('#emty_date').addClass('d-none');
                $('#age_mgs').removeClass('d-none');
            }

            $('#expired-date').addClass('d-none');
            if (getAge(birth_date.value) >= 18) {
                $('#age_mgs').addClass('d-none');

                if (getAge(birth_date.value) >= 18 && getAge(birth_date.value) <= 20) {
                    $("#dz_upload3").show();
                    $("#dz_upload3").addClass("dz-upload3-photo");
                    $('#expired-date').removeClass('d-none');
                }else{
                    $("#dz_upload3").hide();
                    $('#expired-date').addClass('d-none');
                }


            } else {
                $('#age_mgs').removeClass('d-none');
                $("#dz_upload3").hide();
                birth_date.focus();
                return false;
            }

            if (email.value == "") {
                $('#emty_email').removeClass('d-none');
                $('#emty_email').html('Please provide your Email!');
                email.focus();
                return false;
            } else {
                $('#emty_email').addClass('d-none');
            }

            if (!validateEmail(email.value)) {
                $('#email_valid').removeClass('d-none');
                $('#email_valid').html('Please provide your valid Email!');
                email.focus();

                return false;
            } else {
                $('#email_valid').addClass('d-none');

            }

            if (user_password.value == "") {
                $('#emty').removeClass('d-none');
                $('#mgs_not').addClass('d-none');
                $('#mgs_pass').addClass('d-none');

                $('#emty_pass').removeClass('d-none');
                $('#emty_pass').html('Please provide your Password!');
                user_password.focus();
                return false;
            } else {
                $('#emty_pass').addClass('d-none');

                if (user_password.value == confrim_pass) {
                    //$('#mgs_pass').removeClass('d-none');
                    $('#emty').removeClass('d-none');
                    $('#mgs_not').addClass('d-none');
                    $('#emty').addClass('d-none');
                } else {
                    $('#mgs_not').removeClass('d-none');
                    $('#emty').addClass('d-none');
                    $('#mgs_pass').addClass('d-none');
                    confrim_pass.focus();
                    return false;
                }
            }

            if (zip.value == "" || isNaN(zip.value) || zip.value.length != 5) {
                $('#emty_zip').removeClass('d-none');
                zip.focus();
                return false;
            } else {
                $('#emty_zip').addClass('d-none');
            }

            if ($("#agree-terams").is(":checked")) {
                $('.upload-id').removeClass('d-none');
                $('#mgs').addClass('d-none');
                $('.register-form').hide();
                $('.register-wrapper').find('ul>li:nth-child(2)').addClass('active');
            } else {
                $('#mgs').removeClass('d-none');
            }*/

            var $this = $(this),
                $elem = $this.closest('.rform_wrap'),
                is_valid = check_validation_form($elem);
            if(is_valid){
                next_action($elem);

                var email = $("input[name=email]").val();
                var formData = $('.register-wrapper form#regForm').serialize();

                $.ajax({
                    method: 'POST',
                    url: js_vars.ajaxurl,
                    data: { action: "save_registration_first_step_data", email: email, formdata: formData},
                    dataType: "json",
                    success: function (msg) {

                    }
                });
            }
        });

        $body.on("click", '#back, #back_up', function (e) {
            e.preventDefault();
            var $this = $(this),
                $elem = $this.closest('.rform_wrap');
            back_action($elem);
        });

        $body.on("click", '#more_cat', function (e) {
            e.preventDefault();

            $(this).parents('.categories').find(".cat").removeClass('d-none');
            $(this).parents('.categories').find(".more-btn").hide();
        });

        function getAge(birthDateString) {
            var birthDate = new Date(birthDateString),
                age = today.getFullYear() - birthDate.getFullYear(),
                m = today.getMonth() - birthDate.getMonth(),
                n = today.getDay() - birthDate.getDay();
            if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }
            if(age == 20 && n > 0){
                age++;
            }

            return age;
        }


        if ($('.register-wrapper').length) {

            function hide_show_dropzone($elem, $hide_elem) {
                $elem.show();
                $hide_elem.hide();
                var img = $("#dz_preview_wrap img[data-dz-thumbnail]");
                if (!img.length) {
                    $dz_upload1.show();
                    $dz_upload2.hide();
                    $dz_upload3.show();
                    $dz_upload4.show();
                }
            }

            function remove_old_file($this) {
                if ($this.files[1] != null) {
                    $this.removeFile($this.files[0]);
                }
            }

            function dropzone_id_init(id) {
                var msg, preview;
                if (id === 'dz_upload1') {
                    msg = '<p>Front Side</p>';
                    preview = '.preview_container_front';
                } else if (id === 'dz_upload2') {
                    msg = '<p>Back Side</p>';
                    preview = '.preview_container_back';
                } else if (id === 'dz_upload3') {
                    msg = '<p>Medical ID</p>';
                    preview = '.preview_container_mid';
                }
                else if (id === 'dz_upload4') {
                    msg = '';
                    preview = '.preview_container_pto';
                }

                return new Dropzone("#" + id, {
                    url: js_vars.homeurl + '?file_upload=1',
                    previewsContainer: preview,
                    autoProcessQueue: false,
                    addRemoveLinks: true,
                    maxFiles: 1,
                    previewTemplate: '<div class="dz-preview dz-file-preview">\n' +
                        '  <div class="dz-details">\n' +
                        '  <img data-dz-thumbnail />\n' +
                        msg +
                        '  </div>\n' +
                        '</div>'

                });
            }

            dz_upload1 = dropzone_id_init('dz_upload1');
            dz_upload2 = dropzone_id_init('dz_upload2');
            dz_upload3 = dropzone_id_init('dz_upload3');
            dz_upload4 = dropzone_id_init('dz_upload4');

            dz_upload1.on("addedfile", function (file) {
                hide_show_dropzone($dz_upload2, $dz_upload1);
                remove_old_file(this);
                if (this.files[1] != null) {
                    this.removeFile(this.files[0]);
                }
            }).on("removedfile", function (file) {
                hide_show_dropzone($dz_upload1, $dz_upload2);
            });

            dz_upload2.on("addedfile", function (file) {
                remove_old_file(this);
            }).on("removedfile", function (file) {
                hide_show_dropzone($dz_upload2, $dz_upload1);
            });

            dz_upload3.on("addedfile", function (file) {
                remove_old_file(this);
            });

            dz_upload4.on("addedfile", function (file) {
                remove_old_file(this);
                setClassOnCondition($register_form.find('#dz_upload4_err'), true);
            }).on("removedfile", function (file) {
                setClassOnCondition($register_form.find('#dz_upload4_err'), false);
            });

            function process_dropzone_upload(id) {
                //alert(id);
                $.ajax({
                    method: 'POST',
                    url: js_vars.ajaxurl,
                    data: getImage(id),
                    processData: false, // required for FormData with jQuery
                    contentType: false, // required for FormData with jQuery
                    success: function (response) {
                        if(response.type == 'success' && id == 'dz_upload1'){
                            $('#front_side').val(response.data.url);
                        }
                        if(response.type == 'success' && id == 'dz_upload2'){
                            $('#back_side').val(response.data.url);
                        }
                        if(response.type == 'success' && id == 'dz_upload3'){
                            $('#medical_id').val(response.data.url);
                        }
                        if(response.type == 'success' && id == 'dz_upload4'){
                            $('#photo_id').val(response.data.url);
                            //$('.register-modal').modal({backdrop:'static', keyboard:false});
                            setTimeout(function(){
                                //$("#regForm").submit();
                                var fname = $("input[name=full-name]").val();
                                var birthdate = $("input[name=birth-date]").val();
                                var email = $("input[name=email]").val();
                                var phone = $("input[name=phone]").val();
                                if($("input[name=allow_text_message]").is(':checked'))
                                    var allow_text_message = 1;
                                else
                                    var allow_text_message = 0;

                                var userpassword = $("input[name=user-password]").val();
                                var zipcode = $("input[name=zip-code]").val();
                                var address = $("input[name=address]").val();
                                var expired_date = $("input[name=expired_date]").val();
                                var front_side = $("input[name=front_side]").val();
                                var back_side = $("input[name=back_side]").val();
                                var medical_id = $("input[name=medical_id]").val();
                                var photo_id = $("input[name=photo_id]").val();

                                $.ajax({
                                    method: 'POST',
                                    url: js_vars.ajaxurl,
                                    data: { action: "save_registration_data", fname: fname, birthdate: birthdate, email: email, phone: phone, allow_text_message: allow_text_message, userpassword: userpassword, zipcode: zipcode, address: address, expired_date: expired_date, front_side: front_side, back_side: back_side, medical_id: medical_id, photo_id: photo_id},
                                    dataType: "json",
                                    async:false,
                                    success: function (msg) {
                                        var $succ = $register_form.find('.success_msg').show().removeClass('err');
                                        $register_form.find('.wait-reg').hide();
                                        if(msg.status == 1){
                                            $succ.text('Registration successfully completed!');
                                            setTimeout(function(){
                                                //location.reload(true);
                                                window.location.href = js_vars.homeurl+"next-steps";
                                            },4000);
                                        }else if(msg.status == 2){
                                            $succ.addClass('err');
                                            $succ.text('Registration failed.Please try again.');
                                        }else if(msg.status == 3){
                                            $succ.addClass('err');
                                            $succ.text('User already exist with this name or email. Please try with different name and email.');
                                        }
                                    }
                                });

                                }, 2000);
                        }
                    }
                });
            }

            function getImage(id) {

                var formData = new FormData();
                if (id === 'dz_upload1') {
                    formData.append('image', dz_upload1.getAcceptedFiles()[0]);
                } else if (id === 'dz_upload2') {
                    formData.append('image', dz_upload2.getAcceptedFiles()[0]);
                } else {

                }
                if (id === 'dz_upload3') {
                    formData.append('image', dz_upload3.getAcceptedFiles()[0]);
                } else {

                }
                if (id === 'dz_upload4') {
                    formData.append('image', dz_upload4.getAcceptedFiles()[0]);
                } else {

                }
                formData.append("action", 'id_image_upload');
                formData.append("id", id);
                // formData.append("_method", 'PUT');
                return formData;
            }

            $("#next_up").on('click', function (e) {
                e.preventDefault();
                var $this = $(this),
                    $elem = $this.closest('.rform_wrap'),
                    fb_validation = $('#preview_container_front').find('img[data-dz-thumbnail]').length
                        && $('#preview_container_back').find('img[data-dz-thumbnail]').length,
                    mid_validation = $('#preview_container_mid').find('img[data-dz-thumbnail]').length,
                    mid_lenght = $register_form.find('#dz_upload3_err').hasClass('validation_required'),
                    is_valid;


                setClassOnCondition($('#dz_upload1_err'),
                    fb_validation
                );

                if(mid_lenght){
                    setClassOnCondition($('#dz_upload3_err'),
                        mid_validation
                    );
                } else {
                    mid_validation = true;
                }

                is_valid = check_validation_form($elem);
                if(is_valid){
                    if(fb_validation && mid_validation) {
                        process_dropzone_upload('dz_upload1');
                        process_dropzone_upload('dz_upload2');
                    }
                    if(mid_validation && mid_lenght) {
                        process_dropzone_upload('dz_upload3');
                    }
                    next_action($elem);
                }
            });

            $("#create_account").on('click', function (e) {
                e.preventDefault();
                var $this = $(this),
                    $elem = $this.closest('.rform_wrap'),
                    is_valid = check_validation_form($elem);


                if(is_valid){
                    $register_form.find('.success_msg').hide();
                    $register_form.find('.wait-reg').show();
                    process_dropzone_upload('dz_upload4');
                }
            });

        }

        var page = 0,
            $window = $(window),
            lastScrollTop = 0,
            ajax_called = false,
            loadmore = $('.product-category .loadMore'),
            loadmore2 = $('.product-category .loadMore2'),
            all_shown = false;
        if(loadmore.length > 0) {
            $window.scroll(function () {
                var position = loadmore.offset().top,
                    $this = $(this),
                    st = $this.scrollTop() + 650;

                if ($window.width() < 767) {
                    st -= 150;
                }

                if ((st > lastScrollTop) && st > position && !ajax_called && !all_shown) {
                    $('#wait2').show();
                    ajax_called = true;

                    $.ajax({
                        method: 'POST',
                        url: js_vars.ajaxurl,
                        data: {action: "load_category_products_ajax", page: page},
                        dataType: "json",
                        async: false,
                        success: function (response) {
                            $('#wait2').hide();
                            if (response.output !== null) {
                                $('.cp_container').append(response.output);
                                page++;
                                cat_slider(response.className);
                            } else {
                                $('.loadMore h6').text('No more category');
                                $('.loadMore .wait').remove();
                                all_shown = true;
                            }
                            ajax_called = false;
                        }
                    });
                }
                lastScrollTop = st;
            });
        }

        if(loadmore2.length > 0) {
            $window.scroll(function () {
                loadmore2 = $('.product-category .loadMore2');
                if(loadmore2.length == 0) {
                    loadmore3 = $('.product-category .filterMore');
                    if(loadmore3.length > 0) {
                        var position = loadmore3.offset().top,
                            $this = $(this),
                            st = $this.scrollTop() + 650;

                        if ($window.width() < 767) {
                            st -= 150;
                        }

                        if ((st > lastScrollTop) && st > position && !ajax_called && !all_shown) {
                            $('#wait2').show();
                            ajax_called = true;

                            /*$.ajax({
                                method: 'POST',
                                url: js_vars.ajaxurl,
                                data: {action: "load_shop_page_category_products_ajax", page: page},
                                dataType: "json",
                                async: false,
                                success: function (response) {
                                    $('#wait2').hide();
                                    if (response.output !== null) {
                                        $('.cp_container').append(response.output);
                                        page++;
                                        cat_slider(response.className);
                                    } else {
                                        $('.loadMore2 h6').text('No more category');
                                        $('.loadMore2 .wait').remove();
                                        all_shown = true;
                                    }
                                    ajax_called = false;
                                }
                            });*/

                            ajax_show_product($pf_form, 'loadmore')

                        }
                        lastScrollTop = st;
                    }
                }else {
                    var position = loadmore2.offset().top,
                        $this = $(this),
                        st = $this.scrollTop() + 650;

                    if ($window.width() < 767) {
                        st -= 150;
                    }

                    if ((st > lastScrollTop) && st > position && !ajax_called && !all_shown) {
                        $('#wait2').show();
                        ajax_called = true;

                        $.ajax({
                            method: 'POST',
                            url: js_vars.ajaxurl,
                            data: {action: "load_shop_page_category_products_ajax", page: page},
                            dataType: "json",
                            async: false,
                            success: function (response) {
                                $('#wait2').hide();
                                if (response.output !== null) {
                                    $('.cp_container').append(response.output);
                                    page++;
                                    cat_slider(response.className);
                                } else {
                                    $('.loadMore2 h6').text('No more category');
                                    $('.loadMore2 .wait').remove();
                                    all_shown = true;
                                }
                                ajax_called = false;
                            }
                        });
                    }
                    lastScrollTop = st;
                }
            });
        }

        function cat_slider(className){
            $('.'+className+'').each(function(){
                var slickInduvidual = $(this);
                slickInduvidual.slick({
                    dots: false,
                    infinite: true,
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    responsive: [
                        {
                            breakpoint: 1024,
                            settings: {
                                slidesToShow: 3,
                                slidesToScroll: 1,
                                infinite: true,
                                dots: false
                            }
                        },
                        {
                            breakpoint: 768,
                            settings: {
                                dots: false,
                                slidesToShow: 1,
                                slidesToScroll:1
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                                dots: false,
                                slidesToShow: 1,
                                slidesToScroll: 1
                            }
                        }
                    ]
                });
            });
        }

        $('select.category_by').on('change', function() {
            var sitm = this.value;
            $.ajax({
                method: 'POST',
                url: js_vars.ajaxurl,
                data: { action: "load_category_by_id", catId: this.value},
                dataType: "json",
                async:false,
                success: function (response) {
                    if(response.output !== null){
                        $('.cp_container').html(response.output);
                        if(sitm.length > 0)
                            $('.loadMore').css('display','none');
                        else
                            $('.loadMore').css('display','block');
                        cat_slider('category-slider-ajax');
                    }
                }
            });
        });

        $body.on("click", '.loginBtn', function (e) {
            e.preventDefault();
            $('.wait-login').show();
            $('.error-alert').addClass('d-none');
            var log = $("input[name=log]").val();
            var pwd = $("input[name=pwd]").val();
            $.ajax({
                method: 'POST',
                url: js_vars.ajaxurl,
                data: { action: "check_authentication", logname: log, pwd: pwd},
                dataType: "json",
                async:false,
                success: function (msg) {
                    if(msg.status == 2){
                        $('.wait-login').hide();
                        $('.error-alert').text('Your account is not approve yet!');
                        $('.error-alert').removeClass('d-none');
                    }else if(msg.status == 1){
                        $('#loginFrm').submit();
                    }else if(msg.status == 3){
                        $('.wait-login').hide();
                        $('.error-alert').text('Username or password not match!');
                        $('.error-alert').removeClass('d-none');
                    }
                }
            });
        });

        /*$body.on("click", '.product-grid .custom_checkbox', function (e) {
            e.preventDefault();
        });*/



        var cat_shown = 0;

        function ajax_show_product($form, action){
            var fdata = $pf_form.serialize();
            if(action == 'filter'){
                cat_shown = 0;
            } else {
                cat_shown += 3;
            }
            $.ajax({
                method: 'POST',
                url: js_vars.ajaxurl,
                data: { action: "product_filter_action", data: fdata, cat_shown: cat_shown},
                dataType: "json",
                async:false,
                success: function (response) {
                    //console.log(response);
                    $('#wait2').hide();
                    $pc_category_wrap.find('.wait-reg').hide();
                    if(response.status == 'success'){
                        if (!response.html.trim()) {
                            $('.filterMore h6').text('No more category');
                            //$('.filterMore .wait').remove();
                            all_shown = true;
                       }

                        if(action == 'loadmore'){
                            $('.cp_container').append(response.html);
                            cat_slider(response.className);
                        }else {
                            $('.cp_container').html(response.html);
                            cat_slider(response.className);
                            $('.loadMore2').addClass('filterMore');
                            $('.filterMore').removeClass('loadMore2');
                        }
                    }else{
                        $('.cp_container').html(response.html);
                    }
                    ajax_called = false;
                }
            });
        }
        $pf_form.on('submit', function (e) {
            e.preventDefault();
            return false;
        }).on('change', 'input', function (e) {
            $('.pc-category-wrap .full-wait.wait-reg').show();
            $('.filterMore h6').text('load more');
            all_shown = false;
            ajax_show_product($pf_form, 'filter')

        });

        var slider = new Slider("#price_slide_input");
        //slider.on("slide", function(slideEvt) {
        slider.on("slideStop", function(slideEvt) {
            $('#range_first').val($('.min-slider-handle').attr('aria-valuenow'));
            $('#range_last').val($('.max-slider-handle').attr('aria-valuenow'));
            ajax_show_product($pf_form, 'filter');
        });

        $body.on("click", '.woocommerce-product-gallery__image a', function (e) {
            e.preventDefault();
            var thumbnail = $(this).find('img').attr('src');
            var large_image = $(this).attr('herf');
            var data_large_image_width = $(this).find('img').attr('data-large_image_width');
            var data_large_image_height = $(this).find('img').attr('data-large_image_height');
            var title = $(this).find('img').attr('title');
        });




       if($win.width() >= 991 && $win.width() <= 1023) {


           var fixmeTop = $('.product-sidebar').offset().top;
           //var sidebarheight = $('.product-sidebar').height();

           //var dd = sidebarheight - 800;

           $win.scroll(function () {
               var currentScroll = $(window).scrollTop();

               console.log((currentScroll + 700));

               if (currentScroll >= fixmeTop) {
                   $('.product-sidebar').css({
                       position: 'fixed',
                       top: '0',
                       left: "auto",
                       width: "240"
                   });

                   $('.product-content').css({
                       marginLeft: "auto"
                   });


               } else {
                   $('.product-sidebar').css({
                       position: 'static',
                   });
                   $('.product-content').css({
                       marginLeft: "auto"
                   });
               }
               if  ($(window).scrollTop() == $(document).height() - $(window).height()){
                   $('.product-sidebar').css({
                       position: 'static',
                   });
               }




           });

       }
       if($win.width() >= 1024 && $win.width() <= 1199) {
            var fixmeTop = $('.product-sidebar').offset().top;

           $win.scroll(function () {
                    var currentScroll = $(window).scrollTop();

                    if (currentScroll >= fixmeTop) {
                        $('.product-sidebar').css({
                            position: 'fixed',
                            top: '0',
                            left: "auto",
                            width: "240"
                        });

                        $('.product-content').css({
                            marginLeft: "auto"
                        });


                    } else {
                        $('.product-sidebar').css({
                            position: 'static',
                            zindex:99
                        });
                        $('.product-content').css({
                            marginLeft: "auto"
                        });
                    }

               if  ($(window).scrollTop() == $(document).height() - $(window).height()){
                   $('.product-sidebar').css({
                       position: 'static',
                   });
               }



            });
        }
        if($win.width() >= 1200 && $win.width() <= 1600 ) {
            var fixmeTop = $('.product-sidebar').offset().top;

            $win.scroll(function () {
                var currentScroll = $(window).scrollTop();

                if (currentScroll >= fixmeTop) {
                    $('.product-sidebar').css({
                        position: 'fixed',
                        top: '0',
                        left: "auto"
                    });

                    $('.product-content').css({
                        marginLeft: "auto"
                    });


                } else {
                    $('.product-sidebar').css({
                        position: 'static',
                        zindex:99
                    });
                    $('.product-content').css({
                        marginLeft: "auto"
                    });
                }


                if  ($(window).scrollTop() == $(document).height() - $(window).height()){
                    $('.product-sidebar').css({
                        position: 'static',
                    });
                }


            });
        }

        if($win.width() > 1600 ) {
            var fixmeTop = $('.product-sidebar').offset().top;
            //var sidebarheight = $('.product-sidebar').height();
            //var dd = sidebarheight - 3000;

            $win.scroll(function () {
                var currentScroll = $(window).scrollTop();

                if (currentScroll >= fixmeTop) {
                    $('.product-sidebar').css({
                        position: 'fixed',
                        top: '0',
                        left: "auto",
                        width: "362"
                    });

                    $('.product-content').css({
                        marginLeft: "auto"
                    });


                } else {
                    $('.product-sidebar').css({
                        position: 'static',
                        zindex:99
                    });
                    $('.product-content').css({
                        marginLeft: "auto"
                    });
                }

                if  ($(window).scrollTop() == $(document).height() - $(window).height()){
                    $('.product-sidebar').css({
                        position: 'static',
                    });
                }
            });
        }




    } );


})(jQuery, window, document);

function SetCookieForAge(){
    setCookie('AgeVerified','true',7);
}

function getCookie(name) {
    var v = document.cookie.match('(^|;) ?' + name + '=([^;]*)(;|$)');
    return v ? v[2] : null;
}

function setCookie(name, value, days) {
    var d = new Date;
    d.setTime(d.getTime() + 24*60*60*1000*days);
    document.cookie = name + "=" + value + ";path=/;expires=" + d.toGMTString();
}

function deleteCookie(name) { setCookie(name, '', -1); }