$(document).ready(function () {
    var url = $('body').attr('site-Homeurl');
    var body_user_key = $('body').attr('data-user');
    var login_url = url + '/login';
    var login_register = url + '/register';
//    var loader = '';
//    var host = window.location.hostname;
//    var name_serv = window.location.origin;
//    var server_url = name_serv + '/';
    var body_lang = $('body').attr('data-homelang');
    if (body_lang == 'ar' || body_lang == "ar" || body_lang == '') {
        var reg_login = 'تسجيل الدخول';
        var log_add_fav = 'لكى تتمكن من اضافة للمفضلة اضغط على  ';
        var delete_from_fav = 'تم الالغاء من المفضلة';
        var add_from_fav = 'تم الاضافة للمفضلة بنجاح';
        var email_not_correct = 'من فضلك ادخل بريد الكترونى صحيح';
        var please_enter_name = 'من فضلك ادخل اسمك   ';
        var please_enter_comment = 'من فضلك ادخل التعليق ';
        var run_upload_video = 'جارى تحميل الفديو ...';
    } else {
        var reg_login = 'Login';
        var log_add_fav = 'To be able to add favorites';
        var delete_from_fav = 'Delete from favorite';
        var add_from_fav = 'Successfully added to favorites';
        var email_not_correct = 'Email is incorrect';
        var please_enter_name = 'Please Enter Your Name';
        var please_enter_comment = 'Please Enter Your Comment';
        var run_upload_video = 'Run Upload Video...';
    }

//**********************************fav & like course***************************************************************
// add or delete fav course
    $('body').on('click', '.data_favourites', function () {
        var obj = $(this);
        var user_key = obj.attr('data-user');
        var data_link = obj.attr('data-link');
        if ((body_user_key != user_key) || user_key == '' || user_key == "") {
            $('.bi-noti-fav').html('<div class ="bi-noti-wrap show-noti alert alert-danger" role="alert" ><button class="close" aria-label="Close" data-dismiss="alert" type="button"><span aria-hidden="true">×</span></button><p style="margin: 0px;">' + log_add_fav + '<a style="color:blue;" href="' + login_url + '">' + reg_login + '</a></p> </div>');
            setTimeout(function () {
                $('.show-noti').remove();
            }, 5000);
            return false;
        }
        if (typeof data_link == 'undefined' || data_link == '' || data_link == "") {
            return false;
        }
        $.ajax({
            type: "post",
            url: url + '/add_delete_fav',
            data: {
                _token: $('meta[name="_token"]').attr('content'),
                link: data_link,
                type: 'course'
            },
            cache: false,
            dataType: 'json',
            success: function (data) {
                if (data != "") {
                    var state_fav = data.state_action;
                    if (state_fav == 0 || state_fav == "0" || state_fav == '0') {
//                        obj.toggleClass('active');
//                        $('.bi-noti-fav').html('<div class ="bi-noti-wrap show-noti alert alert-danger " role="alert" ><button class="close" aria-label="Close" data-dismiss="alert" type="button"><span aria-hidden="true">×</span></button><p>' + delete_from_fav + '</p> </div>');
//                        setTimeout(function () {
//                            $('.show-noti').remove();
//                        }, 6000);
                        $('body').find('.img_' + data_link).attr('src', '/images/icon/like_gray.svg');
                    } else if (state_fav == 1 || state_fav == "1" || state_fav == '1') {
//                        obj.toggleClass('active');
//                        $('.bi-noti-fav').html('<div class ="bi-noti-wrap show-noti alert alert-success " role="alert" ><button class="close" aria-label="Close" data-dismiss="alert" type="button"><span aria-hidden="true">×</span></button><p>' + add_from_fav + '</p> </div>');
//                        setTimeout(function () {
//                            $('.show-noti').remove();
//                        }, 6000);
                        $('body').find('.img_' + data_link).attr('src', '/images/icon/like.svg');
                    } else if (state_fav == 2 || state_fav == "2" || state_fav == '2') {
                        $('body').find('.bi-noti-fav').html('<div class ="bi-noti-wrap show-noti alert alert-danger " role="alert" ><button class="close" aria-label="Close" data-dismiss="alert" type="button"><span aria-hidden="true">×</span></button><p style="margin: 0px;">' + log_add_fav + '<a href="' + login_url + '">' + reg_login + '</a></p> </div>');
                        setTimeout(function () {
                            $('.show-noti').remove();
                        }, 6000);
                    }
                    if (state_fav == 0 || state_fav == 1 || state_fav == "0" || state_fav == '0' || state_fav == "1" || state_fav == '1') {
                        $('body').find('.count_' + data_link).text('');
                        $('body').find('.count_' + data_link).html(data.num_like);
                    }
                }
            },
            complete: function (data) {
                return false;
            }});
        return false;
    });
    $('body').on('click', '.comment_favourites', function () {
        var obj = $(this);
        var user_key = obj.attr('data-user');
        var type = obj.attr('data-type');
        var data_link = obj.attr('data-link'); //this link in comment table
        if ((body_user_key != user_key) || user_key == '' || user_key == "") {
            $('.bi-noti-like' + data_link).html('<div class ="bi-noti-wrap show-noti alert alert-danger " role="alert" ><button class="close" aria-label="Close" data-dismiss="alert" type="button"><span aria-hidden="true">×</span></button><p style="margin: 0px;">' + log_add_fav + '<a style="color:blue;" href="' + login_url + '">' + reg_login + '</a></p> </div>');
            setTimeout(function () {
                $('.show-noti').remove();
            }, 5000);
            return false;
        }
        if (typeof data_link == 'undefined' || data_link == '' || data_link == "") {
            return false;
        }
        $.ajax({
            type: "post",
            url: url + '/add_delete_fav',
            data: {
                _token: $('meta[name="_token"]').attr('content'),
                link: data_link,
                type: type
            },
            cache: false,
            dataType: 'json',
            success: function (data) {
                if (data != "") {
                    var state_fav = data.state_action;
                    if (state_fav == 0 || state_fav == "0" || state_fav == '0') {
//                        obj.toggleClass('active');
//                        $('.bi-noti-like' + data_link).html('<div style="margin-bottom: 0px;padding: 1px 0.25rem;" class ="bi-noti-wrap show-noti alert alert-danger " role="alert" ><button class="close" aria-label="Close" data-dismiss="alert" type="button"><span aria-hidden="true">×</span></button><p>' + delete_from_fav + '</p> </div>');
//                        setTimeout(function () {
//                            $('.show-noti').remove();
//                        }, 6000);
                        $('body').find('.img_' + data_link).attr('src', '/images/icon/like_gray.svg');
                    } else if (state_fav == 1 || state_fav == "1" || state_fav == '1') {
//                        obj.toggleClass('active');
//                        $('.bi-noti-like' + data_link).html('<div style="margin-bottom: 0px;padding: 1px 0.25rem;" class ="bi-noti-wrap show-noti alert alert-success " role="alert" ><button class="close" aria-label="Close" data-dismiss="alert" type="button"><span aria-hidden="true">×</span></button><p>' + add_from_fav + '</p> </div>');
//                        setTimeout(function () {
//                            $('.show-noti').remove();
//                        }, 6000);
                        $('body').find('.img_' + data_link).attr('src', '/images/icon/like.svg');
                    } else if (state_fav == 2 || state_fav == "2" || state_fav == '2') {
                        $('body').find('.bi-noti-like' + data_link).html('<div style="margin-bottom: 0px;padding: 1px 0.25rem;" class ="bi-noti-wrap show-noti alert alert-danger " role="alert" ><button class="close" aria-label="Close" data-dismiss="alert" type="button"><span aria-hidden="true">×</span></button><p style="margin: 0px;">' + log_add_fav + '<a href="' + login_url + '">' + reg_login + '</a></p> </div>');
                        setTimeout(function () {
                            $('.show-noti').remove();
                        }, 6000);
                    }
                    if (state_fav == 0 || state_fav == 1 || state_fav == "0" || state_fav == '0' || state_fav == "1" || state_fav == '1') {
                        $('body').find('.count_' + data_link).text('');
                        $('body').find('.count_' + data_link).html(data.num_like);
                    }
                }
            },
            complete: function (data) {
                return false;
            }});
        return false;
    });

//***************************** comment ********************************************************************
    $('body').on('click', '.drawss_replay_comment', function () {
        var obj = $(this);
        var comment_link = obj.attr('data-comment');
        if (comment_link == '' || comment_link == 0 || comment_link == '0') {
            return false;
        }
        if (body_user_key != '') {
            setTimeout(function () {
                $('.user_message').focus();
            }, 0);
        } else {
            setTimeout(function () {
                $('.user_name').focus();
            }, 0);
        }
        $('body').find('#parent_two_id').val(comment_link);
        return false;
    });
    $('body').on('click', '.add_post_user_message', function () {
        var obj = $(this);
        var type_comment = 'comment';
        var type = obj.attr('data-type');
        var link = obj.attr('data-link');
        if (link == '' || link == 0 || link == '0') {
            return false;
        }
        var link_parent = $('#parent_two_id').val();
        var rate = $('#user_ratting').val();
        var user_message = $('#user_message').val();
        var user_email = $('#user_email').val();
        var user_name = $('#user_name').val();
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
            url: url + '/add_post_comment',
            data: {
                _token: $('meta[name="_token"]').attr('content'),
                type: type,
                type_comment: type_comment,
                link: link,
                content: user_message,
                name: user_name,
                email: user_email,
                rate: rate,
                link_parent: link_parent
            },
            cache: false,
            dataType: 'json',
            success: function (data) {
                if (data != "") {
                    var state_add = data.state_add;
                    if (state_add == 1) {
//                        $('.user_comment_focus').focus();
                        $('.user_message').focus();
                        $('#user_message').val('');
                        $('#user_ratting').val('');
                        if (body_user_key == '') {
                            $('#user_email').val('');
                            $('#user_name').val('');
                        }
                        $('.stat_Data_found').addClass('hide');
                        $("#count_comment").text('');
                        $("#count_comment").html(data.comt_quest_count);
                        $("#draw_display_comments").text('');
                        $("#draw_display_comments").html(data.response);
                    } else {
                        $("#draw_correct_wrong").text('');
                        $("#draw_correct_wrong").html(data.response);
                    }
                    $('body').find('#parent_two_id').val('');
                }
            },
            complete: function (data) {
                return false;
            }});
        return false;
    });
// remove typecomment is comment
    $('body').on('click', '.remove_comments', function () {
        var obj = $(this);
        var comment_link = obj.attr('data-comment');
        var type = obj.attr('data-type');
        var type_comment = 'comment';
        if (comment_link == '' || comment_link == 0 || comment_link == '0') {
            return false;
        }
        $.ajax({
            type: "post",
            url: url + '/remove_comments',
            data: {
                _token: $('meta[name="_token"]').attr('content'),
                comment_link: comment_link,
                type_comment: type_comment,
                type: type
            },
            cache: false,
            dataType: 'json',
            success: function (data) {
                if (data != "") {
                    if (data.state_add == 1) {
                        //draw_question_content(data.comt_quest_count);
                        $("#count_comment").text('');
                        $("#count_comment").html(data.comt_quest_count);
                        $("#draw_display_comments").text('');
                        $("#draw_display_comments").html(data.response);
                    } else {
                        $("#draw_correct_wrong").text('');
                        $("#draw_correct_wrong").html(data.response);
                    }
                }
            },
            complete: function (data) {
//                $(".select").select2({
//                    dir: "rtl"
//                });
                return false;
            }});
        return false;
    });
    //****************************** End comment *******************************************************************
});