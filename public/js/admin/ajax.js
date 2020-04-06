$(document).ready(function () {
//    var url = $('body').attr('');
    var url = $('body').attr('site-Homeurl');
    var user_id = $('body').attr('data-user');
    var login_url = url + '/login';
    var login_register = url + '/register';
    var loader = '';
    if ($(window).width() < 800) {
        $('body').find('.main-sidebar').addClass('hide');
    }
    $('body').on('click', '.sidebar-toggle', function () {
        if ($(window).width() < 800) {
            var found = $('body').find('.main-sidebar').hasClass("hide");
            if (found == 'true' || found == true) {
                $('body').find('.main-sidebar').removeClass('hide');
            } else {
                $('body').find('.main-sidebar').addClass('hide');
            }
            return false;
        }
    });
    $('body').on('change', '.changeLanguage', function () {
        var obj = $(this);
        var locale = obj.val();
        $.ajax({
            type: "post",
            url: url + '/admin/changeLanguage', // URL 
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

    $('body').on('change', '.ajax_get_subcategory', function () {
        var obj = $(this);
        var id = obj.val();
        $.ajax({
            type: "post",
            url: url + '/admin/posts/ajax_subcategory', // URL 
            data: {
                _token: $('meta[name="_token"]').attr('content'),
                id: id
            },
            cache: false,
            dataType: 'json',
            success: function (data) {
                if (data !== "") {
//                    if (data.trim() != "") {
                    $("#draw_get_subcategory").html('');
                    $('#draw_get_subcategory').html(data.response);
                    $(".select").select2({
                        dir: "rtl"
                    });
                }
            },
//            error: function (data) {
//            
//            },
            complete: function (data) {
                return false;
            }});
        return false;
    });
    
    $('body').on('change', '.ajax_get_subteam', function () {
        var obj = $(this);
        var id = obj.val();
        $.ajax({
            type: "post",
            url: url + '/admin/ajax_get_subteam', // URL 
            data: {
                _token: $('meta[name="_token"]').attr('content'),
                id: id
            },
            cache: false,
            dataType: 'json',
            success: function (data) {
                if (data !== "") {
//                    if (data.trim() != "") {
                    $("#draw_get_subteam").html('');
                    $('#draw_get_subteam').html(data.response);
                    $(".select").select2({
                        dir: "rtl"
                    });
                }
            },
//            error: function (data) {
//            
//            },
            complete: function (data) {
                return false;
            }});
        return false;
    });
    
    $('body').on('change', '.ajax_get_subcategoryProduct', function () {
        var obj = $(this);
        var id = obj.val();
        $.ajax({
            type: "post",
            url: url + '/admin/products/ajax_subcategoryProduct', // URL 
            data: {
                _token: $('meta[name="_token"]').attr('content'),
                id: id
            },
            cache: false,
            dataType: 'json',
            success: function (data) {
                if (data !== "") {
//                    if (data.trim() != "") {
                    $("#draw_get_subcategory").html('');
                    $('#draw_get_subcategory').html(data.response);
                    $(".select").select2({
                        dir: "rtl"
                    });
                }
            },
//            error: function (data) {
//            
//            },
            complete: function (data) {
                return false;
            }});
        return false;
    });
    $('body').on('click', '.file_excel_content', function () {
        var obj = $(this);
        var start_end_date = ($('.active_start_end').val());
        var post_id = ($('#active_post_id').val());
       // var is_active = 1;
        if (post_id == '' || post_id == 0 || post_id == '0' || start_end_date == "" || start_end_date == '') {
            return false;
        }
        window.location.href = url + '/admin/reports/excelorderUser/' + post_id + '/' + start_end_date;
        return false;

    });
    $('body').on('click', '.file_excel_course', function () {
        var obj = $(this);
        var start_end_date = ($('.active_start_end').val());
        var post_id = ($('#active_post_id').val());
       // var is_active = 1;
        if (post_id == '' || post_id == 0 || post_id == '0' || start_end_date == "" || start_end_date == '') {
            return false;
        }
        window.location.href = url + '/admin/reports/excelorderCourse/' + post_id + '/' + start_end_date;
        return false;

    });
    $('body').on('click', '.active_UserCourse_order', function () {
        var obj = $(this);
        var start_end_date = ($('.active_start_end').val());
        var post_id = ($('#active_post_id').val());
        var is_active = 1;
        if (post_id == '' || post_id == 0 || post_id == '0' || start_end_date == "" || start_end_date == '') {
            return false;
        }
        $.ajax({
            type: "post",
            url: url + '/admin/reports/active_UserCourse_order',
            data: {
                _token: $('meta[name="_token"]').attr('content'),
                post_id: post_id,
                start_end_date: start_end_date,
                is_active: is_active
            },
            cache: false,
            dataType: 'json',
            success: function (data) {
                if (data !== "") {
                    $("#draw_active_Active").html('');
                    $('#draw_active_Active').html(data.response);
                    // datatables
                    $.fn.dataTable.ext.errMode = 'none';
                    $('[data-ride="datatable_search"]').dataTable({
                        "sPaginationType": "full_numbers",
                        "bProcessing": true,
                        "bAutoWidth": false,
                        "order": [[2, "desc"]]
                    });
                }
            },
            complete: function (data) {
                return false;
            }});
        return false;

    });
    $('body').on('click', '.active_course_order', function () {
        var obj = $(this);
        var start_end_date = ($('.active_start_end').val());
        var post_id = ($('#active_post_id').val());
        var is_active = 1;
        if (post_id == '' || post_id == 0 || post_id == '0' || start_end_date == "" || start_end_date == '') {
            return false;
        }
        $.ajax({
            type: "post",
            url: url + '/admin/reports/active_course_order',
            data: {
                _token: $('meta[name="_token"]').attr('content'),
                post_id: post_id,
                start_end_date: start_end_date,
                is_active: is_active
            },
            cache: false,
            dataType: 'json',
            success: function (data) {
                if (data !== "") {
                    $("#draw_active_Active").html('');
                    $('#draw_active_Active').html(data.response);
                    // datatables
                    $.fn.dataTable.ext.errMode = 'none';
                    $('[data-ride="datatable_search"]').dataTable({
                        "sPaginationType": "full_numbers",
                        "bProcessing": true,
                        "bAutoWidth": false,
                        "order": [[2, "desc"]]
                    });
                }
            },
            complete: function (data) {
                return false;
            }});
        return false;

    });
    $('body').on('click', '.notactive_course_order', function () {
        var obj = $(this);
        var start_end_date = ($('.notactive_start_end').val());
        var post_id = ($('#notactive_post_id').val());
        var is_active = 0;
        if (post_id == '' || post_id == 0 || post_id == '0' || start_end_date == "" || start_end_date == '') {
            return false;
        }
        $.ajax({
            type: "post",
            url: url + '/admin/reports/active_course_order',
            data: {
                _token: $('meta[name="_token"]').attr('content'),
                post_id: post_id,
                start_end_date: start_end_date,
                is_active: is_active
            },
            cache: false,
            dataType: 'json',
            success: function (data) {
                if (data !== "") {
                    $("#draw_active_notActive").html('');
                    $('#draw_active_notActive').html(data.response);
                    //datatables
                    $.fn.dataTable.ext.errMode = 'none';
                    $('[data-ride="datatable_search"]').dataTable({
                        "sPaginationType": "full_numbers",
                        "bProcessing": true,
                        "bAutoWidth": false,
                        "order": [[2, "desc"]]
                    });
                }
            },
            complete: function (data) {
                return false;
            }});
        return false;

    });
    //****Search***********************************
    $('body').on('click', '.searchUserBtn', function () {
        var obj = $(this);
        var search = ($('.searchInput').val());
        if (search == 0 || search == '0' || search == "" || search == '') {
            return false;
        }
        $.ajax({
            type: "post",
            url: url + '/admin/users/searchUser',
            data: {
                _token: $('meta[name="_token"]').attr('content'),
                search: search
            },
            cache: false,
            dataType: 'json',
            success: function (data) {
                if (data !== "") {
                    $("#draw_data_search").html('');
                    $('#draw_data_search').html(data.response);
                    //datatables
                    $.fn.dataTable.ext.errMode = 'none';
                    $('[data-ride="datatable_search"]').dataTable({
                        "sPaginationType": "full_numbers",
                        "bProcessing": true,
                        "bAutoWidth": false,
                        "order": [[2, "desc"]]
                    });
                }
            },
            complete: function (data) {
                return false;
            }});
        return false;

    });
    $('body').on('click', '.searchPostBtn', function () {
        var obj = $(this);
        var search = ($('.searchInput').val());
        var type = ($('.searchType').val());
        if (search == 0 || search == '0' || search == "" || search == '') {
            return false;
        }
        $.ajax({
            type: "post",
            url: url + '/admin/posts/searchPost',
            data: {
                _token: $('meta[name="_token"]').attr('content'),
                search: search,
                type: type
            },
            cache: false,
            dataType: 'json',
            success: function (data) {
                if (data !== "") {
                    $("#draw_data_search").html('');
                    $('#draw_data_search').html(data.response);
                    //datatables
                    $.fn.dataTable.ext.errMode = 'none';
                    $('[data-ride="datatable_search"]').dataTable({
                        "sPaginationType": "full_numbers",
                        "bProcessing": true,
                        "bAutoWidth": false,
                        "order": [[2, "desc"]]
                    });
                }
            },
            complete: function (data) {
                return false;
            }});
        return false;

    });
    $('body').on('click', '.searchSectionBtn', function () {
        var obj = $(this);
        var search = ($('.searchInput').val());
        var type = ($('.searchType').val());
        if (search == 0 || search == '0' || search == "" || search == '') {
            return false;
        }
        $.ajax({
            type: "post",
            url: url + '/admin/sections/searchSection',
            data: {
                _token: $('meta[name="_token"]').attr('content'),
                search: search,
                type: type
            },
            cache: false,
            dataType: 'json',
            success: function (data) {
                if (data !== "") {
                    $("#draw_data_search").html('');
                    $('#draw_data_search').html(data.response);
                    //datatables
                    $.fn.dataTable.ext.errMode = 'none';
                    $('[data-ride="datatable_search"]').dataTable({
                        "sPaginationType": "full_numbers",
                        "bProcessing": true,
                        "bAutoWidth": false,
                        "order": [[2, "desc"]]
                    });
                }
            },
            complete: function (data) {
                return false;
            }});
        return false;

    });
    $('body').on('click', '.searchCategoryBtn', function () {
        var obj = $(this);
        var search = ($('.searchInput').val());
        var type = ($('.searchType').val());
        if (search == 0 || search == '0' || search == "" || search == '') {
            return false;
        }
        $.ajax({
            type: "post",
            url: url + '/admin/categories/searchCategory',
            data: {
                _token: $('meta[name="_token"]').attr('content'),
                search: search,
                type: type
            },
            cache: false,
            dataType: 'json',
            success: function (data) {
                if (data !== "") {
                    $("#draw_data_search").html('');
                    $('#draw_data_search').html(data.response);
                    //datatables
                    $.fn.dataTable.ext.errMode = 'none';
                    $('[data-ride="datatable_search"]').dataTable({
                        "sPaginationType": "full_numbers",
                        "bProcessing": true,
                        "bAutoWidth": false,
                        "order": [[2, "desc"]]
                    });
                }
            },
            complete: function (data) {
                return false;
            }});
        return false;

    });
    $('body').on('click', '.searchBundleBtn', function () {
        var obj = $(this);
        var search = ($('.searchInput').val());
        var type = ($('.searchType').val());
        if (search == 0 || search == '0' || search == "" || search == '') {
            return false;
        }
        $.ajax({
            type: "post",
            url: url + '/admin/bundles/searchBundle',
            data: {
                _token: $('meta[name="_token"]').attr('content'),
                search: search,
                type: type
            },
            cache: false,
            dataType: 'json',
            success: function (data) {
                if (data !== "") {
                    $("#draw_data_search").html('');
                    $('#draw_data_search').html(data.response);
                    //datatables
                    $.fn.dataTable.ext.errMode = 'none';
                    $('[data-ride="datatable_search"]').dataTable({
                        "sPaginationType": "full_numbers",
                        "bProcessing": true,
                        "bAutoWidth": false,
                        "order": [[2, "desc"]]
                    });
                }
            },
            complete: function (data) {
                return false;
            }});
        return false;

    });
    $('body').on('click', '.searchOrderBtn', function () {
        var obj = $(this);
        var search = ($('.searchInput').val());
        var type = ($('.searchType').val());
        if (search == 0 || search == '0' || search == "" || search == '') {
            return false;
        }
        $.ajax({
            type: "post",
            url: url + '/admin/orders/searchOrder',
            data: {
                _token: $('meta[name="_token"]').attr('content'),
                search: search,
                type: type
            },
            cache: false,
            dataType: 'json',
            success: function (data) {
                if (data !== "") {
                    $("#draw_data_search").html('');
                    $('#draw_data_search').html(data.response);
                    //datatables
                    $.fn.dataTable.ext.errMode = 'none';
                    $('[data-ride="datatable_search"]').dataTable({
                        "sPaginationType": "full_numbers",
                        "bProcessing": true,
                        "bAutoWidth": false,
                        "order": [[2, "desc"]]
                    });
                }
            },
            complete: function (data) {
                return false;
            }});
        return false;

    });
    $('body').on('click', '.searchCommentBtn', function () {
        var obj = $(this);
        var search = ($('.searchInput').val());
        var type = ($('.searchType').val());
        if (search == 0 || search == '0' || search == "" || search == '') {
            return false;
        }
        $.ajax({
            type: "post",
            url: url + '/admin/comments/searchComment',
            data: {
                _token: $('meta[name="_token"]').attr('content'),
                search: search,
                type: type
            },
            cache: false,
            dataType: 'json',
            success: function (data) {
                if (data !== "") {
                    $("#draw_data_search").html('');
                    $('#draw_data_search').html(data.response);
                    //datatables
                    $.fn.dataTable.ext.errMode = 'none';
                    $('[data-ride="datatable_search"]').dataTable({
                        "sPaginationType": "full_numbers",
                        "bProcessing": true,
                        "bAutoWidth": false,
                        "order": [[2, "desc"]]
                    });
                }
            },
            complete: function (data) {
                return false;
            }});
        return false;

    });
    $('body').on('click', '.searchApimobileBtn', function () {
        var obj = $(this);
        var search = ($('.searchInput').val());
        var type = ($('.searchType').val());
        if (search == 0 || search == '0' || search == "" || search == '') {
            return false;
        }
        $.ajax({
            type: "post",
            url: url + '/admin/apimobiles/searchapi',
            data: {
                _token: $('meta[name="_token"]').attr('content'),
                search: search,
                type: type
            },
            cache: false,
            dataType: 'json',
            success: function (data) {
                if (data !== "") {
                    $("#draw_data_search").html('');
                    $('#draw_data_search').html(data.response);
                    //datatables
                    $.fn.dataTable.ext.errMode = 'none';
                    $('[data-ride="datatable_search"]').dataTable({
                        "sPaginationType": "full_numbers",
                        "bProcessing": true,
                        "bAutoWidth": false,
                        "order": [[2, "desc"]]
                    });
                }
            },
            complete: function (data) {
                return false;
            }});
        return false;

    });
});



