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
        var email_not_correct = 'من فضلك ادخل بريد الكترونى صحيح';
        var please_enter_name = 'من فضلك ادخل اسمك   ';
        var please_enter_comment = 'من فضلك ادخل التعليق / السؤال';
        var run_upload_video = 'جارى تحميل الفديو ...';
    } else {
        var email_not_correct = 'Email is incorrect';
        var please_enter_name = 'Please Enter Your Name';
        var please_enter_comment = 'Please Enter Your Comment/Question';
        var run_upload_video = 'Run Upload Video...';

    }
    
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
        var type = obj.attr('data-type');
        var link = obj.attr('data-link');
        if (link == '' || link == 0 || link == '0') {
            return false;
        }
        var link_parent = $('#parent_two_id').val();
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
                link: link,
                content: user_message,
                name: user_name,
                email: user_email,
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
                        if (body_user_key == '') {
                            $('#user_email').val('');
                            $('#user_name').val('');
                        }
                        $('.stat_questions_found').addClass('hide');
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
//****************************** comment *******************************************************************
    $('body').on('input', '#content_question', function () { //not use
        var obj = $(this);
        var state_update = obj.attr('data-state');  //update add
        var content_question = obj.val();//$('#content_question').val();
        var image_val = $('body').find('.data_Course_input').val();
        var video_val = $('body').find('.data_videoCourse_input').val();
        if (state_update == '' || state_update == "" || state_update == null) {
            if ((content_question == '' || content_question == "" || content_question == null) && (image_val == '' || image_val == null) && (video_val == '' || video_val == null)) {
                $('body').find('.dataFound_question_submit').removeClass('hide');
                $('body').find('.question_submit').addClass('hide');
            } else {
                $('body').find('.dataFound_question_submit').addClass('hide');
                $('body').find('.question_submit').removeClass('hide');
            }
        } else {
            if ((content_question == '' || content_question == "" || content_question == null) && (image_val == '' || image_val == null) && (video_val == '' || video_val == null)) {
                $('body').find('.dataFound_question_submit').removeClass('hide');
                $('body').find('.question_data_submit').addClass('hide');
            } else {
                $('body').find('.dataFound_question_submit').addClass('hide');
                $('body').find('.question_data_submit').removeClass('hide');
            }
        }
    });
// add typecomment is question
    $('body').on('click', '.question_submit', function () {
        //$('#equat-Modal').attr("style", "display :none");
        //$('.comment-img').addClass('hide');
        var obj = $(this);
        var link = obj.attr('data-link');
        if (link == '' || link == 0 || link == '0') {
            return false;
        }
        var link_parent = $('#parent_two_id').val();
        var user_message = $('#user_message').val();
        var comment_img = $('#data_Course_input').val();
        var comment_video = $('#data_videoCourse_input').val();
        var time_task = '00:00';//$('#equation_time_video_stop').val();
//        if (time_task == '' || time_task == '0' || time_task == 0) {
//            time_task = '00:00';
//        }
        var comment_error_content = $('.comment_error_content');
        comment_error_content.addClass('hide');
        if (user_message == '' && comment_img == '' && comment_video == '') {
            comment_error_content.removeClass('hide');
            comment_error_content.html(please_enter_comment);
            $('.user_message').focus();
            return false;
        }
        if (comment_video != '') {
            $('.bi-noti-upload').html('<div class ="bi-noti-wrap show-noti alert alert-success alert-dismissible" role="alert" ><button class="close" aria-label="Close" data-dismiss="alert" type="button"><span aria-hidden="true">×</span></button><p>' + run_upload_video + '</p> </div>');
        }
        $.ajax({
            type: "post",
            url: url + '/add_post_question',
            data: {
                _token: $('meta[name="_token"]').attr('content'),
                link: link,
                link_parent: link_parent,
                content: user_message,
                image: comment_img,
                video: comment_video,
                time_task: time_task
            },
            cache: false,
            dataType: 'json',
            success: function (data) {
                if (data != "") {
                    $('.bi-noti-upload').html('');
                    $('.user_message').focus();
                    $('#user_message').val('');
                    $('#data_Course_input').val('');
                    $('#data_videoCourse_input').val('');
                    $('body').find('.course_video_update').addClass('hide');
                    $('body').find('.course_image_update').addClass('hide');
                    if (data.state_add == 1) {
                        $('.stat_questions_found').addClass('hide');
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
                $(".select").select2({
                    dir: "rtl"
                });
                return false;
            }});
        return false;
    });
// update typecomment is question
    $('body').on('click', '.question_data_submit', function () { //not use
        //$('#equat-Modal').attr("style", "display :none");
        // $('.comment-img').addClass('hide');
        var obj = $(this);
        var link = obj.attr('data-link');
        if (link == '' || link == 0 || link == '0') {
            return false;
        }
        var comment_link = $('#link_parent_question').val();
        //var link_parent = $('#parent_two_id').val();
        var user_message = $('#user_message').val();
        var comment_img = $('#data_Course_input').val();
        var comment_video = $('#data_videoCourse_input').val();

        var comment_error_content = $('.comment_error_content');
        comment_error_content.addClass('hide');
        if (user_message == '' && comment_img == '' && comment_video == '') {
            comment_error_content.removeClass('hide');
            comment_error_content.html(please_enter_comment);
            $('.user_message').focus();
            return false;
        }
        if (comment_video != '') {
            $('.bi-noti-upload').html('<div class ="bi-noti-wrap show-noti alert alert-success alert-dismissible" role="alert" ><button class="close" aria-label="Close" data-dismiss="alert" type="button"><span aria-hidden="true">×</span></button><p>' + run_upload_video + '</p> </div>');
        }
        $.ajax({
            type: "post",
            url: url + '/update_post_question',
            data: {
                _token: $('meta[name="_token"]').attr('content'),
                link: link,
                comment_link: comment_link,
                content: user_message,
                image: comment_img,
                video: comment_video
            },
            cache: false,
            dataType: 'json',
            success: function (data) {
                if (data != "") {
                    $('.bi-noti-upload').html('');
                    $('.user_message').focus();
                    $('#user_message').val('');
                    $('#data_Course_input').val('');
                    $('#data_videoCourse_input').val('');
                    $('body').find('.course_video_update').addClass('hide');
                    $('body').find('.course_image_update').addClass('hide');
                    if (data.state_add == 1) {
                        $("#draw_display_comments").text('');
                        $("#draw_display_comments").html(data.response);
                    } else {
                        $("#draw_correct_wrong").text('');
                        $("#draw_correct_wrong").html(data.response);
                    }
                }
            },
            complete: function (data) {
                $(".select").select2({
                    dir: "rtl"
                });
                return false;
            }});
        return false;
    });
// remove typecomment is question
    $('body').on('click', '.remove_questions', function () {
        var obj = $(this);
        var comment_link = obj.attr('data-comment');
        var type = obj.attr('data-type');
        if (comment_link == '' || comment_link == 0 || comment_link == '0') {
            return false;
        }
        $.ajax({
            type: "post",
            url: url + '/remove_post_question',
            data: {
                _token: $('meta[name="_token"]').attr('content'),
                comment_link: comment_link,
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
                $(".select").select2({
                    dir: "rtl"
                });
                return false;
            }});
        return false;
    });

//****************************** order question*****************************************************************
    $('body').on('change', '.name_order,.type_order,.switch_myequation', function () {
        var obj = $(this);
        var link = $('#post_link').val();
        var name_order = $("#name_order option:selected").val();
        if (typeof name_order == 'undefined' || name_order == '') {
            name_order = 'time';
        }
        var type_order = $("#type_order option:selected").val();
        if (typeof type_order == 'undefined' || type_order == '') {
            type_order = 'desc';
        }
        var myquestion = $('#value_switch_myequation:checked').val();
        if (myquestion == 'on' || myquestion == "on") {
            myquestion = 'yes';
        } else {
            myquestion = 'no';
        }
        $.ajax({
            type: "post",
            url: url + '/order_equation',
            data: {
                _token: $('meta[name="_token"]').attr('content'),
                link: link,
                name_order: name_order,
                type_order: type_order,
                myquestion: myquestion
            },
            cache: false,
            dataType: 'json',
            success: function (data) {
                if (data != "") {
                    $("#draw_comment_question_submit").text('');
                    $("#draw_comment_question_submit").html(data.response);
                }
            },
            complete: function (data) {
                $(".select").select2({
                    dir: "rtl"
                });
                return false;
            }});
        return false;
    });
//***************************** comment on courses site********************************************************************
    $('body').on('click', '.add_courses_comment', function () {
        var obj = $(this);
        var link = obj.attr('data-link');
        if (link == '' || link == 0 || link == '0') {
            return false;
        }
        var link_parent = $('#parent_two_id').val();
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
            url: url + '/add_courses_comment',
            data: {
                _token: $('meta[name="_token"]').attr('content'),
                link: link,
                content: user_message,
                name: user_name,
                email: user_email,
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
                        if (body_user_key == '') {
                            $('#user_email').val('');
                            $('#user_name').val('');
                        }
                        $('.stat_questions_found').addClass('hide');
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
});