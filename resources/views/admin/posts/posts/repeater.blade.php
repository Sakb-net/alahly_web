<script type="text/javascript">
    $(document).ready(function () {
        $("#type_cat").change(function () {
            var type_cat = $("#type_cat option:selected").val();
            if(type_cat==25 || type_cat=="25" || type_cat=='25' || type_cat==12 || type_cat=="12" || type_cat=='12' || type_cat==20 || type_cat=="20" || type_cat=='20'){
                $('.type_Video').removeClass("hide");
            }else{
                $('.type_Video').addClass("hide");
            }
        });
    });
</script>
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
        $('.brand-repeater').repeater({
            defaultValues: {
            },
            show: function () {
            },
            hide: function (deleteElement) {
            $(this).fadeOut(deleteElement);
            }
        });
        
        $('.brand-add-repeater').repeater({
            defaultValues: {
            },
            show: function () {
            var value = $(this).prev().find('.image_number').val();
            var value_sum = Number(value) + Number(1);
            var href = $(this).find('.iframe-btn').attr("href");
            var id = 'image_link_'+value_sum;
            $(this).find('.iframe-btn').attr("href", href +"_"+value_sum);
            $(this).find('#image_link').attr('id', id);
            $(this).find('.image_number').val(value_sum);
            $(this).find('.iframe-btn').click();
            $(this).fadeIn();
            },
            hide: function (deleteElement) {
            $(this).fadeOut(deleteElement);
            }
        });
        
    $('body').on('click','.brand-add-show',function () {
    obj = $(this);
    obj.parent().next().next().removeClass('hide');
    obj.parent().prev().remove();
    obj.parent().next().remove();
    obj.parent().remove();
    });
        
    //*****************************************
    $('body').on('click','.remove_appoint_image',function(){
        $(this).prev().prev().prev().val('');
        $(this).prev().prev().attr('src','').hide();
    });
            $('.appoint-repeater').repeater({
        defaultValues: {
        },
        show: function () {
        },
        hide: function (deleteElement) {
            $(this).fadeOut(deleteElement);
        }
    });

    $('.appoint-add-repeater').repeater({
        defaultValues: {
        },
        show: function () {
            var value = $(this).prev().find('.appoint_number').val();
            var img_value = $(this).prev().find('.image_number').val();
            var value_sum = Number(value) + Number(1);
            var img_value_sum = Number(img_value) + Number(1);
            var href = $(this).find('.iframe-btn').attr("href");
            var img_href = $(this).find('.imgframe-btn').attr("href");
            var id_img = 'appoint_image_'+img_value_sum;
            var id_appoint = 'appoint_content_'+value_sum;
            $(this).find('.iframe-btn').attr("href", href +"_"+value_sum);
            $(this).find('.imgframe-btn').attr("href", img_href +"_"+img_value_sum);
            $(this).find('#appoint_image').attr('id', id_img);
            $(this).find('#appoint_content').attr('id', id_appoint);
            
            $(this).find('.image_number').val(img_value_sum);
            $(this).find('.appoint_number').val(value_sum);
         
//            $(this).find('.iframe-btn').click();
            $(this).fadeIn();
            
            $('.appoint-add-repeater').find(".select2-container--default").remove();
            $('.appoint-add-repeater').find(".select").select2({ dir: "rtl"});
        },
        hide: function (deleteElement) {
            $(this).fadeOut(deleteElement);
        }
    });

    $('body').on('click', '.appoint-add-show', function () {
        obj = $(this);
        obj.parent().next().next().removeClass('hide');
//        obj.parent().next().next().find('.iframe-btn').click();
        obj.parent().prev().remove();
        obj.parent().next().remove();
        obj.parent().remove();
    });

 </script>
