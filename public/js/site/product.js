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
    }
//*********************************categoryProduct*******************************************************
// get categoryProduct
    $('body').on('click', '.get_categoriesProduct', function () {
        var obj = $(this);
        var val_sort = $("#sort_cat_Product option:selected").val();
        var link = obj.attr('data-link');
        var offset = 0;// obj.attr('data-offset');
        if (link == '' || link == "" || link == '0' || link == "0") {
            return false;
        }
        $.ajax({
            type: "post",
            url: url + '/get_categoriesProduct',
            data: {
                _token: $('meta[name="_token"]').attr('content'),
                link: link,
                val_sort: val_sort,
                offset: offset
            },
            cache: false,
            dataType: 'json',
            success: function (data) {
                if (data != "") {
                    if (data.status == 1) {
                        history.replaceState('data to be passed', 'Title of the page', data.state_url);
                        $(".draw_category_product").text('');
                        $(".draw_category_product").html(data.response);
                        $("#input_cat_sort").val(data.active_cat_link);
                        $(".count_product_cat").html('<p>' + data.count_product + '</p>'); //<p>عرض 9 من 27 </p>
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

    $('body').on('change', '.sort_cat_Product', function () {
        var obj = $(this);
        var val_sort = obj.val();
        var link = $("#input_cat_sort").val();
        var offset = 0;// obj.attr('data-offset');
        if (link == '' || link == "" || link == '0' || link == "0") {
            return false;
        }
        if (val_sort == '' || val_sort == "" || val_sort == '0' || val_sort == "0") {
            return false;
        }
        $.ajax({
            type: "post",
            url: url + '/sort_cat_Product',
            data: {
                _token: $('meta[name="_token"]').attr('content'),
                val_sort: val_sort,
                link: link,
                offset: offset
            },
            cache: false,
            dataType: 'json',
            success: function (data) {
                if (data != "") {
                    if (data.status == 1) {
                        $(".draw_category_product").text('');
                        $(".draw_category_product").html(data.response);
                        $(".count_product_cat").html('<p>' + data.count_product + '</p>'); //<p>عرض 9 من 27 </p>
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

//  ************************** Cart Product ****************************************************  
    // add product in cart in ajax.js
    //change main price with select weight
    $('body').on('change', '.select_weight_Product', function () {
        var obj = $(this);
        var code_weight = obj.val();
        var fees = [];
        $("input:checkbox[name=fees]:checked").each(function () {
//        $.each($(".select_fees_Product:checked"), function () {
            fees.push($(this).val());
        });
        var link = $("#input_cat_sort").val();
        if (link == '' || link == "" || link == '0' || link == "0") {
            return false;
        }
        if (code_weight == '' || code_weight == "" || code_weight == '0' || code_weight == "0") {
            return false;
        }
        $.ajax({
            type: "post",
            url: url + '/select_weight_fees_Product',
            data: {
                _token: $('meta[name="_token"]').attr('content'),
                code_weight: code_weight,
                link: link,
                fees: fees
            },
            cache: false,
            dataType: 'json',
            success: function (data) {
                if (data != "") {
                    if (data.status == 1) {
                        $(".product_price").html(data.total_price + ' ' + type_price);
                        if (data.ok_discount == 1) {
                            $(".product_oldprice").html(data.price + ' ' + type_price);
                        } else {
                            $(".product_oldprice").html('');
                        }
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
    //change main price with select fees    
    $('body').on('change', '.select_fees_Product', function () {
        var obj = $(this);
        var code_weight = $(".select_weight_Product").val();
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
        var link = $("#input_cat_sort").val();
        if (link == '' || link == "" || link == '0' || link == "0") {
            return false;
        }
//        if (fees != undefined || fees == '' || fees == "" || fees == '0' || fees == "0") {
//            return false;
//        }
        $.ajax({
            type: "post",
            url: url + '/select_weight_fees_Product',
            data: {
                _token: $('meta[name="_token"]').attr('content'),
                code_weight: code_weight,
                link: link,
                fees: fees
            },
            cache: false,
            dataType: 'json',
            success: function (data) {
                if (data != "") {
                    if (data.status == 1) {
                        $(".product_price").html(data.total_price + ' ' + type_price);
                        if (data.ok_discount == 1) {
                            $(".product_oldprice").html(data.price + ' ' + type_price);
                        } else {
                            $(".product_oldprice").html('');
                        }
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

function draw_counterQuantity() {
    $('.pro-qty').prepend('<span class="dec qtybtn">-</span>');
    $('.pro-qty').append('<span class="inc qtybtn">+</span>');
    $('.qtybtn').on('click', function () {
        var $button = $(this);
        var oldValue = $button.parent().find('input').val();
        if ($button.hasClass('inc')) {
            var newVal = parseFloat(oldValue) + 1;
        } else {
            // Don't allow decrementing below zero
            if (oldValue > 1) {
                var newVal = parseFloat(oldValue) - 1;
            } else {
                newVal = 1;
            }
        }
        $button.parent().find('input').val(newVal);
    });
}