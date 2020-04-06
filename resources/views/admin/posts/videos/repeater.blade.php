<script type="text/javascript">
    $('body').on('click', '.remove_image_link', function () {
        $(this).prev().prev().prev().val('');
        $(this).prev().prev().attr('src', '').hide();
    });
    
$('body').on('click','.remove_video_image',function(){
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
    $('.imgframe-btn').fancybox({	

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
            parent.$.fancybox.close();
        } 
        
        
    $('.video-repeater').repeater({
        defaultValues: {
        },
        show: function () {
        },
        hide: function (deleteElement) {
            $(this).fadeOut(deleteElement);
        }
    });

    $('.video-add-repeater').repeater({
        defaultValues: {
        },
        show: function () {
            var value = $(this).prev().find('.video_number').val();
            var img_value = $(this).prev().find('.image_number').val();
            var value_sum = Number(value) + Number(1);
            var img_value_sum = Number(img_value) + Number(1);
            var href = $(this).find('.iframe-btn').attr("href");
            var img_href = $(this).find('.imgframe-btn').attr("href");
            var id_img = 'video_image_'+img_value_sum;
            var id_video = 'video_content_'+value_sum;
            $(this).find('.iframe-btn').attr("href", href +"_"+value_sum);
            $(this).find('.imgframe-btn').attr("href", img_href +"_"+img_value_sum);
            $(this).find('#video_image').attr('id', id_img);
            $(this).find('#video_content').attr('id', id_video);
            
            $(this).find('.image_number').val(img_value_sum);
            $(this).find('.video_number').val(value_sum);
         
//            $(this).find('.iframe-btn').click();
            $(this).fadeIn();
            
            $('.video-add-repeater').find(".select2-container--default").remove();
            $('.video-add-repeater').find(".select").select2({ dir: "rtl"});
        },
        hide: function (deleteElement) {
            $(this).fadeOut(deleteElement);
        }
    });

    $('body').on('click', '.video-add-show', function () {
        obj = $(this);
        obj.parent().next().next().removeClass('hide');
//        obj.parent().next().next().find('.iframe-btn').click();
        obj.parent().prev().remove();
        obj.parent().next().remove();
        obj.parent().remove();
    });

</script>
<script>
    var iframe = document.querySelector('iframe');
    var player = new Vimeo.Player(iframe);

    player.on('play', function() {
//        console.log('played the video!');
    });

    player.getVideoTitle().then(function(title) {
//        console.log('title:', title);
    });
</script>