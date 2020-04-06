<script type="text/javascript">
    $(document).ready(function () {
        $("#type_cost").change(function () {
            var type_cost = $("#type_cost option:selected").val();
            if(type_cost=="discount" || type_cost=='discount'){
                $('.allow_discount').removeClass("hide");
            }else{
                $('.allow_discount').addClass("hide");
            }
        });

    });
    </script>
<script type="text/javascript">
     $(".my-colorpicker2").colorpicker();
     $(".my-colorpicker1").colorpicker();
    $('body').on('click', '.remove_image_link', function () {
        $(this).prev().prev().prev().val('');
        $(this).prev().prev().attr('src', '').hide();
    });
    
    $('.iframe-btn').fancybox({
        'type': 'iframe',
        maxWidth: 900,
        maxHeight: 600,
        fitToView: true,
        width: '100%',
        height: '100%',
        autoSize: false,
        closeClick: true,
        closeBtn: true
    });

    function responsive_filemanager_callback(field_id) {
//        alert(field_id);
        $('#' + field_id).next().attr('src', document.getElementById(field_id).value).show();
        parent.$.fancybox.close();
    }

    $(document).ready(function () {



        $('.image-repeater').repeater({
            defaultValues: {
            'image_link' : '',
            'content' : ''
            },
            show: function () {
                $(this).fadeIn();
                var value = $(this).prev().find('.image_number').val();
                        var value_sum = Number(value) + Number(1);
                        var href = $(this).find('.iframe-btn').attr("href");
                        var id_key = 'image_link_0_' + value_sum;
                        $(this).find('.iframe-btn').attr("href", href + "_" + value_sum);
                        $(this).find('#image_link_0').attr('id', id_key);
                        $(this).find('.image_number').val(value_sum);
                        $(this).find('.iframe-btn').click();
            },
            hide: function (deleteElement) {
                $(this).fadeOut(deleteElement);
            }
        });



    });


//*************for course bundle*********************
    $('.course-repeater').repeater({
        defaultValues: {
        },
        show: function () {
        },
        hide: function (deleteElement) {
            $(this).fadeOut(deleteElement);
        }
    });

    $('.course-add-repeater').repeater({
        defaultValues: {
        },
        show: function () {
            
//            var value = $(this).prev().find('.course_number').val();
//            var value_sum = Number(value) + Number(1);
//            var href = $(this).find('.iframe-btn').attr("href");
//            var id = 'course_content_'+value_sum;
//            $(this).find('.iframe-btn').attr("href", href +"_"+value_sum);
//            $(this).find('#course_content').attr('id', id);
//            $(this).find('.course_number').val(value_sum);
//            $(this).find('.iframe-btn').click();
            $(this).fadeIn();
            
            $('.course-add-repeater').find(".select2-container--default").remove();
            $('.course-add-repeater').find(".select").select2({ dir: "rtl"});
        },
        hide: function (deleteElement) {
            $(this).fadeOut(deleteElement);
        }
    });

    $('body').on('click', '.course-add-show', function () {
        obj = $(this);
        obj.parent().next().next().removeClass('hide');
//        obj.parent().next().next().find('.iframe-btn').click();
        obj.parent().prev().remove();
        obj.parent().next().remove();
        obj.parent().remove();
    });

</script>