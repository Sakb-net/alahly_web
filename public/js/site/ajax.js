var url = $('body').attr('site-Homeurl');
$(document).ready(function () {
    var body_user_key = $('body').attr('data-user');
    var login_url = url + '/login';
    var login_register = url + '/register';
//    var loader = '';
//    var host = window.location.hostname;
    var body_lang = $('body').attr('data-homelang');
    if (body_lang == 'ar' || body_lang == "ar" || body_lang == '') {
        var reg_login = 'تسجيل الدخول';
        var meg_reg_login = 'لكى تتمكن من اضافة طلبك اضغط على  ';
        var enter_password_match = 'من فضلك ادخل كلمة المرور متطابقة';
        var email_not_correct = 'من فضلك ادخل بريد الكترونى صحيح';
        var email_already_use = 'البريد الالكترونى مستخدم بالفعل ';
        var please_phone_correct = 'من فضلك ادخل رقم هاتفك صحيحا';
        var please_terms_correct = 'من فضلك وافق على الشروط والأحكام';
        var phone_number_already_used = 'رقم الهاتف مستخدم بالفعل';
        var please_enter_name = 'من فضلك ادخل اسمك   ';
        var please_enter_city = 'من فضلك ادخل مدينتك   ';
        var please_enter_state = 'من فضلك ادخل الحى التى تسكنه   ';
        var please_enter_comment = 'من فضلك ادخل رسالتك/ تعليقك     ';
        var not_found = 'لا توجد بيانات !!!';
        var not_found_product = ' لا يوجد منتجات  ???';
        var type_price = ' ريال';
        var chang_img_profile_scuss = ' تم اضافة الصورة بنجاح';
        var add_scuss = ' تم الاضافة بنجاح';
    } else {
        var reg_login = 'Login';
        var meg_reg_login = 'To add your order click on';
        var enter_password_match = 'Please enter the match password';
        var email_not_correct = 'Email is incorrect';
        var email_already_use = 'Email already used';
        var please_phone_correct = 'Please enter your phone number correctly';
        var please_terms_correct = 'Please agree to the terms and conditions';
        var phone_number_already_used = 'Phone number already used';
        var please_enter_name = 'Please Enter Your Name';
        var please_enter_city = 'Please Enter Your City';
        var please_enter_state = 'Please Enter Your State';
        var please_enter_comment = 'Please Enter Your Comment';
        var not_found = 'Not Found Data !!!';
        var not_found_product = 'Not Found Products ???';
        var type_price = 'SR';
        var chang_img_profile_scuss = 'Image added successfully';
        var add_scuss = ' Successfully added';
    }
    $('body').find('#model_msg_booking').click();
    $('body').on('click', '.changeLanguage', function () { //change
        var obj = $(this);
        var locale = obj.attr('data-val');         // var locale = obj.val();
        $.ajax({
            type: "post",
            url: url + '/changeLanguage',
            data: {
                _token: $('meta[name="_token"]').attr('content'),
                locale: locale
            },
            cache: false,
            dataType: 'json',
            success: function (data) {
                if (data !== "") {
                    location.reload(true);
                }
            },
            complete: function (data) {
                return false;
            }});
        return false;
    });
//*********************************category*******************************************************
// add category
    $('body').on('click', '.get_section_modal', function () {
        var obj = $(this);
        var link = obj.attr('data-link');
        var match_link = obj.attr('data-match');
        var name = obj.attr('data-name');
        var type_state = obj.attr('data-model');
        //type_state --> normal,best,special,complete,not_valid
        if (type_state == '' || type_state == "" || type_state == 'not_valid' || type_state == "not_valid") {
//            $('.bi-noti-upload').html('<div class ="bi-noti-wrap show-noti alert alert-danger alert-dismissible" role="alert" ><button class="close" aria-label="Close" data-dismiss="alert" type="button"><span aria-hidden="true">×</span></button><p>هذا السكشن غير متاح للحجز والاشتراك</p> </div>');
            return false;
        }
        if (link == '' || link == "" || link == '0' || link == "0") {
            return false;
        }
        if (match_link == '' || match_link == "" || match_link == '0' || match_link == "0") {
            return false;
        }
        $.ajax({
            type: "post",
            url: url + '/get_section_modal',
            data: {
                _token: $('meta[name="_token"]').attr('content'),
                link: link,
                match_link: match_link,
                type_state: type_state
            },
            cache: false,
            dataType: 'json',
            success: function (data) {
                if (data != "") {
                    if (data.status == 1) {
                        $('body').find('.modal_section').click(); //$category
                        $(".draw_chair").text('');
                        $(".draw_chair").html(data.response);
                        $(".draw_title_section").html(data.category.name);
                        $(".tzaker").html('عدد التذاكر: <strong>' + data.count_cart + '</strong> ');
                        $(".egmaly_price").html('إجمالي السعر: <strong class="value">' + data.price_cart + type_price + '</strong>');
                        //draw_dataChair(data.category,data.posts);
                    } else if (data.status == 2) {
                        var content = ' هذا السكشن غير متاح للحجز والاشتراك';
                        if (data.category.content != '') {
                            content = data.category.content;
                        }
                        $('.bi-noti-upload').html('<div class ="bi-noti-wrap show-noti alert alert-info alert-dismissible" role="alert" ><button class="close" aria-label="Close" data-dismiss="alert" type="button"><span aria-hidden="true">×</span></button><p>' + content + '</p> </div>');
                    } else {
                        $('.bi-noti-upload').html('<div class ="bi-noti-wrap show-noti alert alert-danger alert-dismissible" role="alert" ><button class="close" aria-label="Close" data-dismiss="alert" type="button"><span aria-hidden="true">×</span></button><p>هذا السكشن غير متاح للحجز والاشتراك</p> </div>');
                    }
                }
            },
            complete: function (data) {
                return false;
            }});
        return false;
    });
    // add chair in cart
    $('body').on('click', '.tzaker_chair', function () {
        var obj = $(this);
        var link = obj.attr('data-link');
        var match_link = obj.attr('data-match');
        var name = obj.attr('data-name');
        if (link == '' || link == "" || link == '0' || link == "0") {
            return false;
        }
        if (match_link == '' || match_link == "" || match_link == '0' || match_link == "0") {
            return false;
        }
        $.ajax({
            type: "post",
            url: url + '/tzaker_chair',
            data: {
                _token: $('meta[name="_token"]').attr('content'),
                link: link,
                match_link: match_link,
                name: name
            },
            cache: false,
            dataType: 'json',
            success: function (data) {
                if (data != "") {
                    if (data.status == 1) {
                        $(".cir_" + data.post.link).removeClass('active');
                        $(".cir_" + data.post.link).addClass('cir_cart');
                        $(".tzaker").html('عدد التذاكر: <strong>' + data.count_cart + '</strong> ');
                        $(".egmaly_price").html('إجمالي السعر: <strong class="value">' + data.price_cart + type_price + '</strong>');
                        //draw_dataChair(data.category,data.posts);
                    } else {
                        $('.bi-noti-upload').html('<div class ="bi-noti-wrap show-noti alert alert-danger alert-dismissible" role="alert" ><button class="close" aria-label="Close" data-dismiss="alert" type="button"><span aria-hidden="true">×</span></button><p>هذا السكشن غير متاح للحجز والاشتراك</p> </div>');
                    }
                }
            },
            complete: function (data) {
                return false;
            }});
        return false;
    });
    // remove chair in cart
    $('body').on('click', '.remove_cart_chair', function () {
        var obj = $(this);
        var link = obj.attr('data-link');
        var name = obj.attr('data-name');
        if (link == '' || link == "" || link == '0' || link == "0") {
            return false;
        }
        $.ajax({
            type: "post",
            url: url + '/remove_cart_chair',
            data: {
                _token: $('meta[name="_token"]').attr('content'),
                link: link,
                name: name
            },
            cache: false,
            dataType: 'json',
            success: function (data) {
                if (data != "") {
                    if (data.status == 1) {
                        $(".tzaker").html('عدد التذاكر: <strong>' + data.count_cart + '</strong> ');
                        $(".egmaly_price").html('إجمالي السعر: <strong class="value">' + data.price_cart + type_price + '</strong>');
                        $(".draw_cart_chair").text('');
                        $(".draw_cart_chair").html(data.response);
                    } else {
                        $('.bi-noti-upload').html('<div class ="bi-noti-wrap show-noti alert alert-danger alert-dismissible" role="alert" ><button class="close" aria-label="Close" data-dismiss="alert" type="button"><span aria-hidden="true">×</span></button><p>هذا السكشن غير متاح للحجز والاشتراك</p> </div>');
                    }
                }
            },
            complete: function (data) {
                return false;
            }});
        return false;
    });

//*********************************validation register*******************************************************
    $('body').on('change', '.check_password_confirm', function () {
        var obj = $(this);
        var user_pass2 = obj.val();
        var user_pass = obj.parent().parent().find('.user_pass_buy').val();
        if (user_pass == undefined) {
            user_pass = obj.parent().parent().parent().parent().find('.user_pass_buy').val();
        }
        var comment_error_pass = $('.user_error_pass');
        comment_error_pass.addClass('hide');
        if (user_pass == user_pass2) {
            comment_error_pass.addClass('hide');
            $('.user_pass_buy').val(user_pass);
//            obj.val(user_pass);
        } else {
            comment_error_pass.removeClass('hide');
            comment_error_pass.html(enter_password_match);
            obj.val("");
            $('.user_pass_buy').val("");
            $('.user_pass_buy').focus();
        }
        return false;
    });
    $('body').on('change', '.db_user_email_buy', function () {
        var obj = $(this);
        var user_email = obj.val();
        var comment_error_email = $('.user_error_emailss');
//        var comment_error_phone = $('.user_error_phone');
        comment_error_email.addClass('hide');
//        comment_error_phone.addClass('hide');
        var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
//        if (user_email == '' || re.test(user_email) != true) {
//            comment_error_email.removeClass('hide');
//            comment_error_email.html(email_not_correct);
//            $('.user_email_buy').focus();
//            return false;
//        }
        $.ajax({
            type: "post",
            url: url + '/check_found_email',
            data: {
                _token: $('meta[name="_token"]').attr('content'),
                user_email: user_email
            },
            cache: false,
            dataType: 'json',
            success: function (data) {
                if (data != "") {
//                if (data.trim() != "") {
                    var response = data.response;
                    if (response == 1) {
                        comment_error_email.addClass('hide');
                        $('.user_email_buy').val(user_email);
                        return false;
                    } else if (response == 2) {
                        comment_error_email.removeClass('hide');
                        comment_error_email.html('( ' + user_email + ' ) ' + email_not_correct + '');
                        $('.user_email_buy').val(" ");
                        $('.db_user_email_buy').focus();
                        return false;
                    } else {
                        comment_error_email.removeClass('hide');
                        comment_error_email.html('( ' + user_email + ' ) ' + email_already_use + '');
                        $('.user_email_buy').val(" ");
                        $('.db_user_email_buy').focus();
                        return false;
                    }

                }
            },
            complete: function (data) {
                return false;
            }});
        return false;
    });
    $('body').on('change', '.db_user_phone_buy', function () {
        var obj = $(this);
        var user_phone = obj.val();
        var comment_error_phone = $('.user_error_phone');
//        comment_error_email.addClass('hide');
        comment_error_phone.addClass('hide');
        if (typeof user_phone == 'undefined' || user_phone == '' || user_phone == "") {
            comment_error_phone.removeClass('hide');
            comment_error_phone.html(please_phone_correct);
            $('.db_user_phone_buy').focus();
            return false;
        }
        if (user_phone == 0 || user_phone == "0" || user_phone == '0') {
            return false;
        }
        $.ajax({
            type: "post",
            url: url + '/check_found_phone',
            data: {
                _token: $('meta[name="_token"]').attr('content'),
                user_phone: user_phone
            },
            cache: false,
            dataType: 'json',
            success: function (data) {
                if (data != "") {
//              if (data.trim() != "") {
                    var response = data.response;
                    if (response == 1) {
                        comment_error_phone.addClass('hide');
                        $('.user_phone_buy').val(user_phone);
                        return false;
                    } else if (response == 2) {
                        comment_error_phone.removeClass('hide');
                        comment_error_phone.html('( ' + user_phone + ' )  ' + please_phone_correct + '');
                        $('.user_phone_buy').val(" ");
                        $('.db_user_phone_buy').focus();
                        return false;
                    } else {
                        comment_error_phone.removeClass('hide');
                        comment_error_phone.html('( ' + user_phone + ' )  ' + phone_number_already_used + '');
                        $('.user_phone_buy').val(" ");
                        $('.db_user_phone_buy').focus();
                        return false;
                    }
                }
            },
            complete: function (data) {
                return false;
            }});
        return false;
    });
    // add frist step to buy if not register
    $('body').on('click', '.add_register_buy', function () {
        var obj = $(this);
        var user_name = $(this).parent().parent().parent().parent().find('#user_name_buy').val();
        var user_terms = $(this).parent().parent().parent().parent().find('#user_terms_condition:checked').val();
        var user_email = $(this).parent().parent().parent().parent().find('#user_email_buy').val();
        var user_phone = $(this).parent().parent().parent().parent().find('#user_phone_buy').val();
        var user_pass = $(this).parent().parent().parent().parent().find('.user_pass_buy').val();
        var user_pass2 = $(this).parent().parent().parent().parent().find('#check_password_confirm').val();
//        var user_country = $("#country option:selected").val();
        var order_link = $(this).parent().parent().parent().parent().find('#current_order_buy').val();
        var comment_error_name = $('.user_error_namess');
        var comment_error_email = $('.user_error_emailss');
        var comment_error_pass = $('.user_error_pass');
        var comment_error_phone = $('.user_error_phone');
        var comment_error_terms = $('.user_error_terms');
        comment_error_pass.addClass('hide');
        comment_error_name.addClass('hide');
        comment_error_email.addClass('hide');
        comment_error_phone.addClass('hide');
        comment_error_terms.addClass('hide');
        if (typeof user_name == 'undefined' || user_name == '' || user_name == "") {
            comment_error_name.removeClass('hide');
            if (!comment_error_email.hasClass('hide')) {
                comment_error_email.addClass('hide');
            }
            if (!comment_error_pass.hasClass('hide')) {
                comment_error_pass.addClass('hide');
            }
            if (!comment_error_phone.hasClass('hide')) {
                comment_error_phone.addClass('hide');
            }
            if (!comment_error_terms.hasClass('hide')) {
                comment_error_terms.addClass('hide');
            }
            comment_error_name.html(please_enter_name);
            $('.user_name_buy').focus();
            return false;
        }
        var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if (typeof user_email == 'undefined' || user_email == '' || re.test(user_email) != true) {
            comment_error_email.removeClass('hide');
            if (!comment_error_pass.hasClass('hide')) {
                comment_error_pass.addClass('hide');
            }
            if (!comment_error_name.hasClass('hide')) {
                comment_error_name.addClass('hide');
            }
            if (!comment_error_phone.hasClass('hide')) {
                comment_error_phone.addClass('hide');
            }
            if (!comment_error_terms.hasClass('hide')) {
                comment_error_terms.addClass('hide');
            }
            comment_error_email.html(email_not_correct);
            $('.user_email_buy').val(" ");
            $('.db_user_email_buy').focus();
            return false;
        }
        var pho = /^([+]?)[0-9]{8,16}$/; // /^[0-9]{8,16}$/      ///^(\+91-|\+91|0)?\d{10}$/
        if (typeof user_phone == 'undefined' || user_phone == '' || user_phone == "" || pho.test(user_phone) != true) {
            comment_error_phone.removeClass('hide');
            if (!comment_error_email.hasClass('hide')) {
                comment_error_email.addClass('hide');
            }
            if (!comment_error_pass.hasClass('hide')) {
                comment_error_pass.addClass('hide');
            }
            if (!comment_error_name.hasClass('hide')) {
                comment_error_name.addClass('hide');
            }
            if (!comment_error_terms.hasClass('hide')) {
                comment_error_terms.addClass('hide');
            }
            comment_error_phone.html(please_phone_correct);
            $('.user_phone_buy').val(" ");
            $('.db_user_phone_buy').focus();
            return false;
        }
        if (user_pass != user_pass2) {
            comment_error_pass.removeClass('hide');
            if (!comment_error_email.hasClass('hide')) {
                comment_error_email.addClass('hide');
            }
            if (!comment_error_name.hasClass('hide')) {
                comment_error_name.addClass('hide');
            }
            if (!comment_error_phone.hasClass('hide')) {
                comment_error_phone.addClass('hide');
            }
            if (!comment_error_terms.hasClass('hide')) {
                comment_error_terms.addClass('hide');
            }
            comment_error_pass.html(enter_password_match);
            obj.val("");
            $('.user_pass_buy').val("");
            $('.user_pass_buy').focus();
            return false;
        }
        if (typeof user_terms == 'undefined' || user_terms != 'on' || user_terms != "on" || user_terms == 0 || user_terms == "0" || user_terms == '0') {
            comment_error_terms.removeClass('hide');
            if (!comment_error_email.hasClass('hide')) {
                comment_error_email.addClass('hide');
            }
            if (!comment_error_pass.hasClass('hide')) {
                comment_error_pass.addClass('hide');
            }
            if (!comment_error_name.hasClass('hide')) {
                comment_error_name.addClass('hide');
            }
            if (!comment_error_phone.hasClass('hide')) {
                comment_error_phone.addClass('hide');
            }
            comment_error_terms.html(please_terms_correct);
            $('.user_terms_condition').focus();
            return false;
        }
        $.ajax({
            type: "post",
            url: url + '/add_register_buy',
            data: {
                _token: $('meta[name="_token"]').attr('content'),
                name: user_name,
                email: user_email,
                password: user_pass,
                password_confirmation: user_pass2,
                phone: user_phone,
                terms: user_terms,
                order_link: order_link
            },
            cache: false,
            dataType: 'json',
            success: function (data) {
                if (data != "") {
                    var response = data.response;
                    var status = data.status;
                    var buy = data.buy;
                    $(".draw_payment_step").text('');
                    $(".draw_payment_step").html(response);
                    if (status == 1) {
                        //$('body').find('.buy-desc').html('');
                    }
                }
            },
            complete: function (data) {
                return false;
            }});
        return false;
    });
    //******************************** upload user Image profile and add***************************************
    $('body').on('click', '.add_image', function () {
        $('.change_photo_input').click();
    });
    $('.change_photo_input').change(function () {
        var progress = $('.progress');
        var progress_bar = $('.progress-bar');
        var thumbnail = $('.member_image_update');
        var files = !!this.files ? this.files : [];
        if (!files.length || !window.FileReader)
            return; // no file selected, or no FileReader support
        if (/^image/.test(files[0].type)) { // only image file
            var reader = new FileReader(); // instance of the FileReader
            reader.readAsDataURL(files[0]); // read the local file
            reader.onloadend = function () { // set image data as background of div
                // handel file before upload
                var data = new FormData();
                $.each(files, function (key, value) {
                    data.append(key, value);
                });
                progress.removeClass('hide');
                data.append('_token', $('meta[name="_token"]').attr('content'));
                data.append('yes_compress', 1);
                $.ajax({
                    xhr: function () {
                        var xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener("progress", function (evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = evt.loaded / evt.total;
                                progress_bar.css({
                                    width: percentComplete * 100 + '%'
                                });
                                progress_bar.text(
                                        percentComplete * 100 + '%'
                                        );
                            }
                        }, false);
                        xhr.addEventListener("progress", function (evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = evt.loaded / evt.total;
                                progress_bar.css({
                                    width: percentComplete * 100 + '%'
                                });
                                progress_bar.text(
                                        percentComplete * 100 + '%'
                                        );
                            }
                        }, false);
                        return xhr;
                    },
                    url: url + '/add_image_user',
                    type: 'POST',
                    data: data,
                    cache: false,
                    dataType: 'json',
                    processData: false, // Don't process the files
                    contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                    success: function (data) {
                        var s = data.response;
                        if (Math.abs(s) == 1) {
                            progress.addClass('hide');
                            $('.img-addcir').removeClass('img-addcir');
                            thumbnail.attr('src', data.path);
                            $('.bi-noti').html('<div class ="bi-noti-wrap show-noti alert alert-success alert-dismissible" role="alert" ><button class="close" aria-label="Close" data-dismiss="alert" type="button"><span aria-hidden="true">×</span></button><p>' + chang_img_profile_scuss + '</p> </div>');
                            setTimeout(function () {
                                $('.show-noti').remove();
                            }, 5000);
                        } else {
                            progress.addClass('hide');
                            $('.bi-noti').html('<div class ="bi-noti-wrap show-noti alert alert-success alert-dismissible" role="alert" ><button class="close" aria-label="Close" data-dismiss="alert" type="button"><span aria-hidden="true">×</span></button><p>' + chang_img_profile_false + '</p> </div>');
                            setTimeout(function () {
                                $('.show-noti').remove();
                            }, 50000);
                        }
                    }
                });
            }
        }
    });
    //*********************************************************************
    $('body').on('click', '.add_contact_Us', function () {
        var obj = $(this);
        var user_message = $('.user_message').val();
        var user_email = $('.user_email').val();
        var user_name = $('.user_name').val();
        var type_message = $('.type_message').val();
        var comment_error_user = $('.comment_error_user');
        var comment_error_email = $('.comment_error_email');
        var comment_error_content = $('.comment_error_content');
        comment_error_user.addClass('hide');
        comment_error_email.addClass('hide');
        comment_error_content.addClass('hide');
        if (user_name == '') {
            comment_error_user.removeClass('hide');
            if (!comment_error_email.hasClass('hide')) {
                comment_error_email.addClass('hide');
            }
            if (!comment_error_content.hasClass('hide')) {
                comment_error_content.addClass('hide');
            }
            comment_error_user.html(please_enter_name);
            $('.user_name').focus();
            return false;
        }
        var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if (user_email == '' || re.test(user_email) != true) {
            comment_error_email.removeClass('hide');
            if (!comment_error_user.hasClass('hide')) {
                comment_error_user.addClass('hide');
            }
            if (!comment_error_content.hasClass('hide')) {
                comment_error_content.addClass('hide');
            }
            comment_error_email.html('' + email_not_correct + '(ex: aaa@gmail.com)');
            $('.user_email').focus();
            return false;
        }
        if (user_message == '') {
            comment_error_content.removeClass('hide');
            if (!comment_error_user.hasClass('hide')) {
                comment_error_user.addClass('hide');
            }
            if (!comment_error_email.hasClass('hide')) {
                comment_error_email.addClass('hide');
            }
            comment_error_content.html(please_enter_comment);
            $('.user_message').focus();
            return false;
        }
        $.ajax({
            type: "post",
            url: url + '/add_contact_Us',
            data: {
                _token: $('meta[name="_token"]').attr('content'),
                content: user_message,
                name: user_name,
                email: user_email,
                type: type_message
            },
            cache: false,
            dataType: 'json',
            success: function (data) {
                if (data != "") {
                    var state_add = data.state_add;
//                    if (state_add == 1) {
//                        $('.user_comment_focus').focus();
                    $('.user_message').focus();
                    $('#user_message').val('');
                    if (body_user_key == '') {
                        $('#user_email').val('');
                        $('#user_name').val('');
                    }
                    $('.stat_questions_found').addClass('hide');
//                    } else {
                    $("#draw_correct_wrong").text('');
                    $("#draw_correct_wrong").html(data.response);
//                    }
                    $('body').find('#parent_two_id').val('');
                }
            },
            complete: function (data) {
                return false;
            }});
        return false;
    });
    //********************* add product in cart****************
    // add product in cart
    $('body').on('click', '.add_cart_productDetails', function () {
        var obj = $(this);
        var link = obj.attr('data-link');
        var name = obj.attr('data-name');
        var name_print_bur = obj.parent().parent().find('.name_print_Product').val();
        var name_print = '';
        var fees = [];
        $('body').find('.groub_name_print').addClass('hidden');
        $('body').find('.name_print_Product').val('');
        $('body').find('.name_print_Product').prop('required', false);
        $("input:checkbox[name=fees]:checked").each(function () {
            fees.push($(this).val());
            if ($(this).val() == 'رسوم_طباعه_اسمكiBo7VTUc') {
                $('body').find('.groub_name_print').removeClass('hidden');
                $('body').find('.name_print_Product').val(name_print_bur);
                var name_print = name_print_bur;
                if (name_print == '' || name_print == "" || name_print == '0' || name_print == "0") {
                    $('body').find('.name_print_Product').prop('required', true);
                    $('body').find('.name_print_Product').focus();
                }
            }
        });
        var code_weight = $("#select_weight_Product option:selected").val();
        var color = $("#select_color_Product option:selected").val();
        var quantity = obj.parent().find('.quantity_numProduct').val();
        if (link == '' || link == "" || link == '0' || link == "0") {
            return false;
        }
        if (code_weight != undefined) {
            if (code_weight == '' || code_weight == "" || code_weight == '0' || code_weight == "0") {
                return false;
            }
        }
//        if (fees != undefined || fees == '' || fees == "" || fees == '0' || fees == "0") {
//            fees = '';
//        } 

        if (color != undefined || color == '' || color == "" || color == '0' || color == "0") {
            color = '';
        }
        if (quantity == undefined || quantity == 'undefined' || quantity == '' || quantity == "" || quantity == '0' || quantity == "0") {
            quantity = 1;
        }
        $.ajax({
            type: "post",
            url: url + '/add_cart_productDetails',
            data: {
                _token: $('meta[name="_token"]').attr('content'),
                link: link,
                quantity: quantity,
                code_weight: code_weight,
                color: color,
                name_print: name_print,
                fees: fees,
                name: name
            },
            cache: false,
            dataType: 'json',
            success: function (data) {
                if (data != "") {
                    if (data.status == 1) {
                        $("#draw_cartProducts").text('');
                        $("#draw_cartProducts").html(data.response);
                        $(".count_product_cart").html(data.count_product_cart);
                        $('.bi-noti-upload').html('<div style="padding-bottom: 0px;" class ="bi-noti-wrap show-noti alert alert-success alert-dismissible" role="alert" ><button class="close" aria-label="Close" data-dismiss="alert" type="button"><span aria-hidden="true">×</span></button><p>' + add_scuss + '</p> </div>');
                        setTimeout(function () {
                            $('.show-noti').remove();
                        }, 5000);
                    } else {
                        $('.bi-noti-upload').html('<div style="padding-bottom: 0px;" class ="bi-noti-wrap show-noti alert alert-danger alert-dismissible" role="alert" ><button class="close" aria-label="Close" data-dismiss="alert" type="button"><span aria-hidden="true">×</span></button><p>' + not_found + '</p> </div>');
                    }
                }
            },
            complete: function (data) {
                return false;
            }});
        return false;
    });
    $('body').on('click', '.add_cart_product', function () {
        var obj = $(this);
        var link = obj.attr('data-link');
        var name = obj.attr('data-name');
        if (link == '' || link == "" || link == '0' || link == "0") {
            return false;
        }
        $.ajax({
            type: "post",
            url: url + '/add_cart_product',
            data: {
                _token: $('meta[name="_token"]').attr('content'),
                link: link,
                name: name
            },
            cache: false,
            dataType: 'json',
            success: function (data) {
                if (data != "") {
                    if (data.status == 1) {
                        $("#draw_cartProducts").text('');
                        $("#draw_cartProducts").html(data.response);
                        $(".count_product_cart").html(data.count_product_cart);
                    } else {
                        $('.bi-noti-upload').html('<div class ="bi-noti-wrap show-noti alert alert-danger alert-dismissible" role="alert" ><button class="close" aria-label="Close" data-dismiss="alert" type="button"><span aria-hidden="true">×</span></button><p>' + not_found + '</p> </div>');
                    }
                }
            },
            complete: function (data) {
                return false;
            }});
        return false;
    });
    //*************************************champions********************************
    $('body').on('change', '.select_sport', function () {
        var obj = $(this);
        var link = obj.val();
        if (link == '' || link == "" || link == '0' || link == "0") {
            $("#select_subteam_sport").html('<option value="0">اختر الرياضة</option>');
            return false;
        }
        $.ajax({
            type: "post",
            url: url + '/select_sport',
            data: {
                _token: $('meta[name="_token"]').attr('content'),
                link: link
            },
            cache: false,
            dataType: 'json',
            success: function (data) {
                if (data != "") {
                    if (data.status == 1) {
                        $("#draw_select_subteam").text('');
                        $("#draw_select_subteam").html(data.response);
                    } else {
                        $('.bi-noti-upload').html('<div class ="bi-noti-wrap show-noti alert alert-danger alert-dismissible" role="alert" ><button class="close" aria-label="Close" data-dismiss="alert" type="button"><span aria-hidden="true">×</span></button><p>' + not_found + '</p> </div>');
                    }
                }
            },
            complete: function (data) {
                return false;
            }});
        return false;
    });
    $('body').on('click', '.search_champions', function () {
        var obj = $(this);
        var up_link = $("#select_sport option:selected").val();
        var team_link = $("#select_subteam_sport option:selected").val();
        if (up_link == '' || up_link == "" || up_link == '0' || up_link == "0") {
            return false;
        }
        $.ajax({
            type: "post",
            url: url + '/search_champions',
            data: {
                _token: $('meta[name="_token"]').attr('content'),
                up_link: up_link,
                team_link: team_link
            },
            cache: false,
            dataType: 'json',
            success: function (data) {
                if (data != "") {
                    if (data.status == 1) {
                        $("#draw_data_champions").text('');
                        $("#draw_data_champions").html(data.response);
                    } else {
                        $('.bi-noti-upload').html('<div class ="bi-noti-wrap show-noti alert alert-danger alert-dismissible" role="alert" ><button class="close" aria-label="Close" data-dismiss="alert" type="button"><span aria-hidden="true">×</span></button><p>' + not_found + '</p> </div>');
                    }
                }
            },
            complete: function (data) {
                return false;
            }});
        return false;
    });
    //*************************************
});

//*********End

function draw_dataChair(category, posts) {
    var div_section = '';
    $.each(posts, function (index, value) {
        div_section += '<div class="col-xs-12 col-sm-3"><div class="item_team">';

        if (value.instagram != '' && value.instagram != null) {
            div_section += '<li><a href="' + value.instagram + '"><i class="fab fa-instagram"> </i> </a></li>';
            div_section += '<a href="#">';
            div_section += '<div class="circle active" title="سعر التذكرة :100 ر.س" data-toggle="tooltip">';
            div_section += '<i class="fa fa-wheelchair" aria-hidden="true"></i>';
            div_section += '</div>';
            div_section += '</a>';
        }
        div_section += '</ul></div></div>';
    });
    $(".draw_chair").text('');
    $('.draw_chair').html(div_section);
}

function draw_cartTableBill(total_price_cart, cart_fees, type_price) {
    var div_section = '';
    $.each(cart_fees, function (ind_fees, val_fees) {
        div_section += '<tr>';
        div_section += '<td class="pro-title">' + val_fees.name + '</td>';
        div_section += '<td class="pro-price"><span>' + val_fees.total_price + type_price + ' </span></td>';
        div_section += '</tr>';
        total_price_cart = total_price_cart + val_fees.total_price;
    });
    div_section += '<tr>';
    div_section += '<td class="pro-title">الإجمالي</td>';
    div_section += '<td class="pro-price"><span>' + total_price_cart + type_price + '</span></td>';
    div_section += '</tr>';
    $("#draw_table_fees").text('');
    $("#draw_table_fees").html(div_section);
}
function draw_cartProducts(data, total_price_cart, count_product_cart, not_found_product, cart_fees, type_price) {
    var div_section = '';
    if (count_product_cart > 0) {
        $(".count_product_cart").html(count_product_cart);
        $.each(data, function (index, value) {
            var pro_link = url + '/categories/' + value.cat_link + '/products/' + value.link;
            div_section += '<li>';
            div_section += '<a href="' + pro_link + '" class="photo">';
            div_section += '<img src="' + value.image + '" class="cart-thumb" alt="" />';
            div_section += '</a>';
            div_section += '<h6><a href="' + pro_link + '">' + value.name + '</a></h6>';
            div_section += '<p>' + value.quantity + 'x <span class="price">' + value.total_price + type_price + ' </span></p>';
            div_section += '</li>';

        });
        div_section += ' <li class="total">';
        $.each(cart_fees, function (ind_fees, val_fees) {
            div_section += '<span class="pull-left"><strong>' + val_fees.name + '</strong>:' + val_fees.total_price + type_price + '</span>';
            total_price_cart = total_price_cart + val_fees.total_price;
        });
    } else {
        $(".count_product_cart").html('');
        div_section += '<li><div class="row"> <div class="col-md-12 col-xs-12 no-courses-found">';
        div_section += '<div class="alert alert-info alert-dismissible" role="alert" style="color:#000;">';
        div_section += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
        div_section += '<span class="icon icon-info"></span>' + not_found_product;
        div_section += '</div>';
        div_section += '</div></div></li>';
        div_section += ' <li class="total">';
    }
    div_section += '<span class="pull-left"><strong>الإجمالي</strong>:' + total_price_cart + type_price + '</span>';
    div_section += '<a href="' + url + '/products/cart" class="btn btn-default btn-cart">الذهاب للسلة</a>';
    div_section += '</li>';
    $("#draw_cartProducts").text('');
    $("#draw_cartProducts").html(div_section);
}