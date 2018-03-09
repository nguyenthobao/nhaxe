// $(document).ready(function() {
//     $(".nav li a").click(function() {
//         if ($(this).siblings('.sub-nav').css('display') == 'none') {
//             $(this).siblings('.sub-nav').css( "display", "block" );
//         }else{
//             $(this).siblings('.sub-nav').css( "display", "none" );
//         }
//     });
// });
$(document).ready(function() {
    $("#slide-box").owlCarousel({
        navigation: false,
        pagination:false,
        items:3,
        itemsCustom:[[480,1],[320,1],[768,2],[767,2],[991,3],[1200,3]],
        slideSpeed : 200,
        paginationSpeed : 800,
        rewindSpeed : 1000,
        //Autoplay
        autoPlay : 5000,
        responsive:true,
        navigationText: [
            "<a class='hidden-xs flex-prev-slideshow'><i class='fa fa-arrow-left'></i></a>",
            "<a class='hidden-xs flex-next-slideshow'><i class='fa fa-arrow-right'></i></a>"
        ]
    });
    // $(".slide-photo-home").owlCarousel({
    //     navigation: true,
    //     pagination:true,
    //     items:1,
    //     singleItem: true,
    //     slideSpeed : 200,
    //     paginationSpeed : 800,
    //     rewindSpeed : 1000,
    //     //Autoplay
    //     autoPlay : 4000,
    //     responsive:true,
    //     navigationText: [
    //         "<a class='flex-prev-slideshow'><i class='fa fa-angle-left'></i></a>",
    //         "<a class=' flex-next-slideshow'><i class='fa fa-angle-right'></i></a>"
    //     ]
    // });
    // $(".slide-video-home").owlCarousel({
    //     navigation: false,
    //     pagination:false,
    //     items:1,
    //     singleItem: true,
    //     slideSpeed : 200,
    //     paginationSpeed : 800,
    //     rewindSpeed : 1000,
    //     //Autoplay
    //     autoPlay : 4000,
    //     responsive:true,
    //     navigationText: [
    //         "<a class='hidden-xs flex-prev-slideshow'><i class='fa fa-angle-left'></i></a>",
    //         "<a class='hidden-xs flex-next-slideshow'><i class='fa fa-angle-right'></i></a>"
    //     ]
    // });
    // $(".slide-photo-home11").owlCarousel({
    //     navigation: false,
    //     pagination:false,
    //     items:1,
    //     slideSpeed : 200,
    //     paginationSpeed : 800,
    //     rewindSpeed : 1000,
    //     //Autoplay
    //     autoPlay : true,
    //     itemsCustom:[[480,2],[320,2],[768,3],[767,3],[991,4],[1200,4]],
    //     responsive:true,
    // });
});
// $(document).ready(function(){
//     $(".username span").click(function(){
//         $(".user-setup").toggle();
//     });

//     $('[data-fancybox]').fancybox({
//         // buttons : false,
//         // closeBtn:false,
//         closeTpl : '<button data-fancybox-close class="fancybox-close-small">Đóng</button>',

//     });
//     $('[data-fancybox]').fancybox({
//         // buttons : false,
//         // closeBtn:false,
//         closeTpl : '<button data-fancybox-close class="fancybox-close-small">Đóng</button>',

//     });
//     $('[data-fancybox=singup]').fancybox({
//         // buttons : false,
//         // closeBtn:false,
//         closeTpl : '<button data-fancybox-close class="fancybox-close-small"></button>',

//     });
//     $('[data-fancybox=singin]').fancybox({
//         // buttons : false,
//         // closeBtn:false,
//         closeTpl : '<button data-fancybox-close class="fancybox-close-small"></button>',

//     });
//     $("#newgrid").pinto({
//       itemWidth:200,
//       gapX:10,
//       gapY:10,
//     });



// });
$(window).load(function() {
    // Run code
});

$(window).resize(function() {
    // Run code
});


// Menu mobile
$(document).ready(function() {
    var removeClass = true;
    $menuLeft = $('.pushmenu-left');
    $nav_list = $('.button_menu_mobile');

    $nav_list.click(function(e) {
        $(this).toggleClass('active');
        $('body').toggleClass('pushmenu-push-toright');
        $menuLeft.toggleClass('pushmenu-open');
        removeClass = false;
    });
    $('html').click(function() {
        if (removeClass) {
            $('body').removeClass('pushmenu-push-toright');
            $('.pushmenu-left').removeClass('pushmenu-open');
        }
        removeClass = true;
    });

    $('.navbar-nav').find('.parent').append('<span></span>');

    $('.navbar-nav .parent span').on("click", function() {
        if ($(this).attr('class') == 'opened') {
            $(this).removeClass().parent('.parent').find('ul').slideToggle();
        } else {
            $(this).addClass('opened').parent('.parent').find('ul').slideToggle();
        }
        removeClass = false;
    });
});
