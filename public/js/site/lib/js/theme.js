
(function($) {
    "use strict";
    
    
    $(document).on ('ready', function (){
        
        // -------------------- Navigation Scroll
        $(window).scroll(function() {    
          var sticky = $('.mymenu-wrapper'),
          scroll = $(window).scrollTop();
          if (scroll >= 190) sticky.addClass('fixed');
          else sticky.removeClass('fixed');

        });


        // ------------------------------- WOW Animation 
        var wow = new WOW({
            boxClass:     'wow',      // animated element css class (default is wow)
            animateClass: 'animated', // animation css class (default is animated)
            offset:       80,          // distance to the element when triggering the animation (default is 0)
            mobile:       true,       // trigger animations on mobile devices (default is true)
            live:         true,       // act on asynchronously loaded content (default is true)
          });
          wow.init();


        
        // -------------------- Remove Placeholder When Focus Or Click
        $("input,textarea").each( function(){
            $(this).data('holder',$(this).attr('placeholder'));
            $(this).on('focusin', function() {
                $(this).attr('placeholder','');
            });
            $(this).on('focusout', function() {
                $(this).attr('placeholder',$(this).data('holder'));
            });     
        });
        


        // hero slider 
            /* Slider active */
    $('.slider-active').owlCarousel({
        loop: true,
        rtl:true,
        nav: false,
        autoplay: true,
        autoplayHoverPause:true,
        autoplayTimeout: 5000,
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        item: 1,
        responsive: {
            0: {
                items: 1
            },
            768: {
                items: 1
            },
            1000: {
                items: 1
            }
        }
    })


    // latest carousel 
          $(".latest-slider").owlCarousel({
              rtl: true,
              autoplay: false,
              dots: false,
              nav: true,
              navText: ['<i class="fa fa-angle-right"></i>', '<i class="fa fa-angle-left"></i>'],
              loop: true,
              margin:20,
              responsive: {
                  0: {items: 1}, 768: {items: 2}, 900: {items: 4}
              }
          });

/* Related product active */
    $('.related-product-active').owlCarousel({
        loop: true,
        rtl:true,
        nav: true,
        navText: ['<i class="fa fa-angle-right"></i>', '<i class="fa fa-angle-left"></i>'],
        autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause:true,
        item: 4,
        margin: 30,
        responsive: {
            0: {
                items: 1
            },
            576: {
                items: 2
            },
            768: {
                items: 2
            },
            992: {
                items: 3
            },
            1200: {
                items: 4
            }
        }
    })

      /*-----------
        product detalis
      */
          if ($('#prod-slider').length > 0) {
            $("#prod-thumbs").flexslider({
                animation: "slide",
                controlNav: false,
                animationLoop: false,
                slideshow: false,
                itemWidth: 97,
                itemMargin: 0,
                minItems: 4,
                maxItems: 4,
              asNavFor: '#prod-slider', 
                start: function(slider){
                    $("#prod-thumbs").resize();
                }
            });
            $('#prod-slider').flexslider({
                animation: "fade",
                animationSpeed: 500,
                slideshow: false,
                animationLoop: false,
                smoothHeight: false,
              controlNav: false,
                sync: "#prod-thumbs",
            });
          }
        /*----- 
            Quantity
        --------------------------------*/
        $('.pro-qty').prepend('<span class="dec qtybtn">-</span>');
        $('.pro-qty').append('<span class="inc qtybtn">+</span>');
        $('.qtybtn').on('click', function() {
            var $button = $(this);
            var oldValue = $button.parent().find('input').val();
            if ($button.hasClass('inc')) {
              var newVal = parseFloat(oldValue) + 1;
            } else {
               // Don't allow decrementing below zero
              if (oldValue > 1) {
                var newVal = parseFloat(oldValue) - 1;
                } else {
                newVal = 1;
              }
              }
            $button.parent().find('input').val(newVal);
        }); 


        // -------------------- From Bottom to Top Button
            //Check to see if the window is top if not then display button
        $(window).on('scroll', function (){
          if ($(this).scrollTop() > 200) {
            $('.scroll-top').fadeIn();
          } else {
            $('.scroll-top').fadeOut();
          }
        });
            //Click event to scroll to top
        $('.scroll-top').on('click', function() {
          $('html, body').animate({scrollTop : 0},1500);
          return false;
        });

      // TICKETS SLIDER 
      /*----------------------------
            START - Vega slider
            ------------------------------ */
            $("#slideslow-bg").vegas({
              overlay: true,
              autoHeight: true,
              transition: 'fade',
              transitionDuration: 3000,
              delay: 4000,
              color: '#000',
              animation: 'random',
              animationDuration: 30000,
              slides: [
                {
                  src: '/images/vega-slider/1.jpg'
                },
                {
                  src: '/images/vega-slider/2.jpg'
                }
              ]
            });



    });
    
    $(window).on ('load', function (){ // makes sure the whole site is loaded

        // -------------------- Site Preloader
        $('#loader').fadeOut(); // will first fade out the loading animation
        $('#loader-wrapper').delay(350).fadeOut('slow'); // will fade out the white DIV that covers the website.
        $('body').delay(350).css({'overflow':'visible'});
    })

    
})(jQuery)

