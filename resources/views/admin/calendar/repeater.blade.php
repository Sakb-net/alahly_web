<script type="text/javascript">
      
   $(".my-colorpicker2").colorpicker();
     $(".my-colorpicker1").colorpicker();
    $('body').on('click', '.remove_video_link', function () {
        $(this).prev().prev().prev().prev().val('');
        $(this).prev().prev().prev().attr('src', '').hide();
        $(this).prev().prev().attr('data', '').hide();
//        $(this).prev().parent().attr('value','').hide();
    });

    $('body').on('click','.remove_image_link',function(){
        $(this).prev().prev().prev().val('');
        $(this).prev().prev().attr('src','').hide();
    });
    $('.iframe-btn').fancybox({	

               'type'		: 'iframe',
                maxWidth	: 900,
		maxHeight	: 600,
		fitToView	: true,
		width		: '100%',
		height		: '100%',
		autoSize	: false,
		closeClick	: true,
		closeBtn	: true
    });
    
    function responsive_filemanager_callback(field_id){ 
            $('#'+field_id).next().attr('src',document.getElementById(field_id).value).show();
    //        $('#'+field_id).next().attr('value',document.getElementById(field_id).value).show();
            $('#'+field_id).next().attr('data', document.getElementById(field_id).value).show();
            parent.$.fancybox.close();
        } 
    $('body').on('click','.remove_itemvote_image',function(){
        $(this).prev().prev().prev().val('');
        $(this).prev().prev().attr('src','').hide();
    });
   $('.itemvote-repeater').repeater({
        defaultValues: {
        },
        show: function () {
        },
        hide: function (deleteElement) {
            $(this).fadeOut(deleteElement);
        }
    });

    $('.itemvote-add-repeater').repeater({
        defaultValues: {
        },
        show: function () {
            var value = $(this).prev().find('.itemvote_number').val();
            var img_value = $(this).prev().find('.image_number').val();
            var value_sum = Number(value) + Number(1);
            var img_value_sum = Number(img_value) + Number(1);
            var href = $(this).find('.iframe-btn').attr("href");
            var img_href = $(this).find('.imgframe-btn').attr("href");
            var id_img = 'itemvote_image_'+img_value_sum;
            var id_itemvote = 'itemvote_content_'+value_sum;
            $(this).find('.iframe-btn').attr("href", href +"_"+value_sum);
            $(this).find('.imgframe-btn').attr("href", img_href +"_"+img_value_sum);
            $(this).find('#itemvote_image').attr('id', id_img);
            $(this).find('#itemvote_content').attr('id', id_itemvote);
            
            $(this).find('.image_number').val(img_value_sum);
            $(this).find('.itemvote_number').val(value_sum);
         
//            $(this).find('.iframe-btn').click();
            $(this).fadeIn();
            
            $('.itemvote-add-repeater').find(".select2-container--default").remove();
            $('.itemvote-add-repeater').find(".select").select2({ dir: "rtl"});
        },
        hide: function (deleteElement) {
            $(this).fadeOut(deleteElement);
        }
    });

    $('body').on('click', '.itemvote-add-show', function () {
        obj = $(this);
        obj.parent().next().next().removeClass('hide');
//        obj.parent().next().next().find('.iframe-btn').click();
        obj.parent().prev().remove();
        obj.parent().next().remove();
        obj.parent().remove();
    });

 </script>
