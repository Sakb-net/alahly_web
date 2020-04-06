$(document).ready(function () {
    var url = $('body').attr('site-Homeurl');

    var user_id = $('body').attr('data-user');

    var login_url = url + '/login';

    var login_register = url + '/register';

    var loader = '';
    
    $("body").on('change', '.ajax_get_subcategory', function () {
        var obj = $(this);
        var id = obj.val();
        $.ajax({
            type: "post",
            url: url + '/admin/courses/ajax_subcategory', // URL 
            data: {
                _token: $('meta[name="_token"]').attr('content'),
                id: id
            },
            cache: false,
            dataType: 'json',
            success: function (data) {
                    if (data !== "") {
//                        if (data.hasOwnProperty('subcategories')) {
                            $("#draw_get_subcategory").text('');
                            $('#draw_get_subcategory').html(data); //subcategories
//                        }  
                    $(".select").select2({
                        dir: "rtl"
                    });
                        return false;
                    } 
                },
//                done: function (data) {
//                complete: function (data) {
                error: function (data) {
                     return false;
                }});
        return false;
    });
    
});



