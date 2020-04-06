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

//  ************************** Cart Product ****************************************************  
    // change num product in cart ( add or sub  )
    $('body').on('change input click', '.changnum_cartProduct,.qtybtn', function () {
        var obj = $(this);
        var quantity = obj.parent().find('.changnum_cartProduct').val();
        if (quantity <= 0 || quantity == '' || quantity == "") {
            var quantity = obj.val();
            if (quantity <= 0 || quantity == '' || quantity == "") {
                quantity = 0;
            }
        }
        var link = obj.parent().find('.changnum_cartProduct').attr('data-link');
        var name = obj.parent().find('.changnum_cartProduct').attr('data-name');
        if (link == '' || link == "" || link == '0' || link == "0") {
            var link = obj.attr('data-link');
            var name = obj.attr('data-name');
            if (link == '' || link == "" || link == '0' || link == "0") {
                return false;
            }
        }
        $.ajax({
            type: "post",
            url: url + '/changnum_cartProduct',
            data: {
                _token: $('meta[name="_token"]').attr('content'),
                link: link,
                name: name,
                quantity: quantity
            },
            cache: false,
            dataType: 'json',
            success: function (data) {
                if (data != "") {
                    if (data.status == 1) {
                        draw_cartProducts(data.product_cart, data.total_price_cart, data.count_product_cart, not_found_product,data.cart_fees,type_price);
                        $(".draw_cartProductTable").text('');
                        $(".draw_cartProductTable").html(data.response);
                        draw_counterQuantity();
                        draw_cartTableBill(data.total_price_cart,data.cart_fees,type_price);
                    } else {
                        $('.bi-cart-upload').html('<div class ="bi-noti-wrap show-noti alert alert-danger alert-dismissible" role="alert" ><button class="close" aria-label="Close" data-dismiss="alert" type="button"><span aria-hidden="true">×</span></button><p>' + not_found + '</p> </div>');
                    }
                }
            },
            complete: function (data) {
                return false;
            }});
        return false;
    });
    // remove product in cart
    $('body').on('click', '.remove_cartProduct', function () {
        var obj = $(this);
        var link = obj.attr('data-link');
        var name = obj.attr('data-name');
        if (link == '' || link == "" || link == '0' || link == "0") {
            return false;
        }
        $.ajax({
            type: "post",
            url: url + '/remove_cartProduct',
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
                        draw_cartProducts(data.product_cart, data.total_price_cart, data.count_product_cart, not_found_product,data.cart_fees,type_price);
                        $(".draw_cartProductTable").text('');
                        $(".draw_cartProductTable").html(data.response);
                        draw_counterQuantity();
                        draw_cartTableBill(data.total_price_cart,data.cart_fees,type_price);
                    } else {
                        $('.bi-cart-upload').html('<div class ="bi-noti-wrap show-noti alert alert-danger alert-dismissible" role="alert" ><button class="close" aria-label="Close" data-dismiss="alert" type="button"><span aria-hidden="true">×</span></button><p>' + not_found + '</p> </div>');
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