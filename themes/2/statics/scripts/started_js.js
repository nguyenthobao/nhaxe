  function clickTabContact(tabid,tabpanel){
        //var tabpanel=tabid+"_panel";
      $(".tab-contact .tab-contact-header li a").attr("class","");
      $(tabid).attr("class","active");
      $(".tab_contact_panel").css("display","none");
      $(tabpanel).css("display","block");
    }
 
   //Hàm add sản phẩm vào khung so sánh
 
   // Jcallros
  //  if($('#galleria').length > 0){
  //           Galleria.loadTheme('resources/plugins/galleria/themes/classic/galleria.classic.min.js');
    //   Galleria.run('#galleria', {
    //            autoplay: 3000, // will move forward every 7 seconds
    //            fullscreenDoubleTap:true
    //  }); 
    // }


    $(document).ready(function() {

            var owl = $("#owl-demo-5");

            owl.owlCarousel({

            items : 1, //10 items above 1000px browser width
            itemsDesktop : [1000,1], //5 items between 1000px and 901px
            itemsDesktopSmall : [900,1], // 3 items betweem 900px and 601px
            itemsTablet: [768,1], //2 items between 600 and 0;
            itemsMobile : [480,1], // itemsMobile disabled - inherit from itemsTablet option
      autoPlay:true,
            
            });

            // Custom Navigation Events
            // $(".next-{$value['id']}").click(function(){
            //   owl.trigger('owl.next');
            // })
            // $(".prev-{$value['id']}").click(function(){
            //   owl.trigger('owl.prev');
            // })


          });
      