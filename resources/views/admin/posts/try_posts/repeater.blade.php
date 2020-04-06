<script type="text/javascript">
    
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

</script>