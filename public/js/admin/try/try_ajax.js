$(document).ready(function () {
    var url = $('body').attr('site-Homeurl');

    var user_id = $('body').attr('data-user');

    var login_url = url + '/login';

    var login_register = url + '/register';

    var loader = '';
    
    $("body").on('change', '.center_id', function () {
        var obj = $(this);
        var id = obj.val();
        var copies = $('.center_copies').val();
        if(id == ""){
            $('.teacher_id').html('<option value="" selected="">Choose Teacher </option>');
            $('.center_price').val(1);
            $('.center_total').text('');
            return false;
        }
        
        $.ajax({
            type: "post",
            url: url + '/teachers', // URL 
            data: {
                _token: $('meta[name="_token"]').attr('content'),
                id: id
            },
            cache: false,
            dataType: 'json',
            success: function (data) {
                    if (data !== "") {
                        $('.teacher_id').html(data.teacher);
                        $('.center_price').val(data.price);
                        var total = (Number(data.price)) * Number(copies);
                        $('.center_total').text(total);
                    } 
                },
                complete: function (data) {
                }});
        return false;
    });
    
    $("body").on('change', '.teacher_id', function () {

        var obj = $(this);
        var id = obj.val();
        var copies = $('.center_copies').val();
        if(id == ""){
            $('.center_price').val(1);
            $('.center_total').text('');
            return false;
        }
        
        $.ajax({
            type: "post",
            url: url + '/teachers/price', // URL 
            data: {
                _token: $('meta[name="_token"]').attr('content'),
                id: id
            },
            cache: false,
            dataType: 'json',
            success: function (data) {
                    if (data !== "") {
                        var price = data;
                        var total = (Number(price)) * Number(copies);
                        $('.center_price').val(data);
                        $('.center_total').text(total);
                    } 
                },
                complete: function (data) {
                }});
        return false;
    });

    $("body").on('change keyup blur', '.center_copies', function () {

        var obj = $(this);
        var id = $('.teacher_id').val();
        var price = $('.center_price').val();
        var copies = obj.val();
        if(id == ""){
            $('.center_price').val(1);
            $('.center_total').text('');
            return false;
        }
        var total = (Number(price)) * Number(copies);
        $('.center_total').text(total);
        return false;
    });  

    $("body").on('change', '.time_id', function () {
        
        var obj = $(this);
        var id = obj.val();
        $.ajax({
            type: "post",
            url: url + '/times/price', // URL 
            data: {
                _token: $('meta[name="_token"]').attr('content'),
                id: id
            },
            cache: false,
            dataType: 'json',
            success: function (data) {
                    if (data !== "") {
                       $('.time_price').text(data.price);
                       $('.time_name').text(data.name);
                    } 
                },
                complete: function (data) {
                }});
        return false;
    });
    
    $("body").on('change', '.type_id', function () {
        
        var obj = $(this);
        var id = obj.val();
        var copies = $('.print_copies').val();
        var start = $('.print_start').val();
        var end = $('.print_end').val();
//        var color = $('.print_color').val();
        var size = $('.print_size').val();
        var papers = (Number(end)) - Number(start) + 1;
        if (papers < 1) {
            papers = 1;
        }
        var all_paper = (Number(papers)) * Number(copies);
        if(id == ""){
            $('.print_price').val(1);
            $('.print_total').text('');
            return false;
        }
        
        $.ajax({
            type: "post",
            url: url + '/types/price', // URL 
            data: {
                _token: $('meta[name="_token"]').attr('content'),
                id: id
            },
            cache: false,
            dataType: 'json',
            success: function (data) {
                    if (data !== "") {
                                $('.print_type').val(data.price);
                                $('.total_type').text(data.name);
                                var total = parseFloat(data.price) + parseFloat(size) ;
                                var total_paper = total.toFixed(2);
                                var all_total = (Number(total_paper)) * Number(all_paper);
                                $(".print_total").text(all_total.toFixed(2));
                    } 
                },
                complete: function (data) {
                }});
        return false;
    });
    
    $("body").on('change', '.size_id', function () {
        
        var obj = $(this);
        var id = obj.val();
        var copies = $('.print_copies').val();
        var start = $('.print_start').val();
        var end = $('.print_end').val();
//        var color = $('.print_color').val();
        var type = $('.print_type').val();
        var papers = (Number(end)) - Number(start) + 1;
        if (papers < 1) {
            papers = 1;
        }
        var all_paper = (Number(papers)) * Number(copies);
        if(id == ""){
            $('.print_price').val(1);
            $('.print_total').text('');
            return false;
        }
        
        $.ajax({
            type: "post",
            url: url + '/sizes/price', // URL 
            data: {
                _token: $('meta[name="_token"]').attr('content'),
                id: id
            },
            cache: false,
            dataType: 'json',
            success: function (data) {
                    if (data !== "") {
                                $('.print_size').val(data.price);
                                $('.total_size').text(data.name);
                                var total = parseFloat(data.price) +  parseFloat(type) ;
                                var total_paper = total.toFixed(2);
                                var all_total = (Number(total_paper)) * Number(all_paper);
                                $(".print_total").text(all_total.toFixed(2));
                    } 
                },
                complete: function (data) {
                }});
        return false;
    });
    
//    $("body").on('change', '.color_id', function () {
//        
//        var obj = $(this);
//        var id = obj.val();
//        var copies = $('.print_copies').val();
//        var start = $('.print_start').val();
//        var end = $('.print_end').val();
//        var type = $('.print_type').val();
//        var size = $('.print_size').val();
//        var papers = (Number(end)) - Number(start) + 1;
//        if (papers < 1) {
//            papers = 1;
//        }
//        var all_paper = (Number(papers)) * Number(copies);
//        if(id == ""){
//            $('.print_price').val(1);
//            $('.print_total').text('');
//            return false;
//        }
//        
//        $.ajax({
//            type: "post",
//            url: url + '/colors/price', // URL 
//            data: {
//                _token: $('meta[name="_token"]').attr('content'),
//                id: id
//            },
//            cache: false,
//            dataType: 'json',
//            success: function (data) {
//                    if (data !== "") {
//                                $('.print_color').val(data.price);
//                                $('.total_color').text(data.name);
//                                var total = parseFloat(data.price) + parseFloat(type) + parseFloat(size) ;
//                                var total_paper = total.toFixed(2);
//                                var all_total = (Number(total_paper)) * Number(all_paper);
//                                $(".print_total").text(all_total.toFixed(2));
//                    } 
//                },
//                complete: function (data) {
//                }});
//        return false;
//    });
    
    $("body").on('change keyup blur', '.print_copies', function () {
        
        var obj = $(this);
        var copies = obj.val();
        var start = $('.print_start').val();
        var end = $('.print_end').val();
        var type = $('.print_type').val();
        var size = $('.print_size').val();
//        var color = $('.print_color').val();
        var papers = (Number(end)) - Number(start) + 1;
        if (papers < 1) {
            papers = 1;
        }
        var all_paper = (Number(papers)) * Number(copies);
        var total = parseFloat(type) + parseFloat(size);
        var total_paper = total.toFixed(2);
        var all_total = (Number(total_paper)) * Number(all_paper);
        $(".print_total").text(all_total.toFixed(2));
        return false;
    });
    
    $("body").on('change keyup blur', '.print_start', function () {
        
        var obj = $(this);
        var start = obj.val();
        var copies = $('.print_copies').val();
        var end = $('.print_end').val();
        var type = $('.print_type').val();
        var size = $('.print_size').val();
//        var color = $('.print_color').val();
        var papers = (Number(end)) - Number(start) + 1;
        if (papers < 1) {
            papers = 1;
        }
        var all_paper = (Number(papers)) * Number(copies);
        var total = parseFloat(type) + parseFloat(size);
        var total_paper = total.toFixed(2);
        var all_total = (Number(total_paper)) * Number(all_paper);
        $(".print_total").text(all_total.toFixed(2));
        return false;
    });
    
    $("body").on('change keyup blur', '.print_end', function () {
        
        var obj = $(this);
        var end = obj.val();
        var start = $('.print_start').val();
        var copies = $('.print_copies').val();
        var type = $('.print_type').val();
        var size = $('.print_size').val();
//        var color = $('.print_color').val();
        var papers = (Number(end)) - Number(start) + 1;
        if (papers < 1) {
            papers = 1;
        }
        var all_paper = (Number(papers)) * Number(copies);
        var total = parseFloat(type) + parseFloat(size);
        var total_paper = total.toFixed(2);
        var all_total = (Number(total_paper)) * Number(all_paper);
        $(".print_total").text(all_total.toFixed(2));
        return false;
    });
    
    $("body").on('change', '.binding_id', function () {
        
        var obj = $(this);
        var id = obj.val();
        $.ajax({
            type: "post",
            url: url + '/bindings/price', // URL 
            data: {
                _token: $('meta[name="_token"]').attr('content'),
                id: id
            },
            cache: false,
            dataType: 'json',
            success: function (data) {
                    if (data !== "") {
                       $('.binding_price').text(data.price);
                       $('.binding_name').text(data.name);
                    } 
                },
                complete: function (data) {
                }});
        return false;
    });
    
});



