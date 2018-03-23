
$(document).ready(function() {
	// $('.popup-with-zoom-anim').magnificPopup({
		
	// 	type: 'inline',

	// 	fixedContentPos: false,
	// 	fixedBgPos: true,

	// 	overflowY: 'auto',

	// 	closeBtnInside: true,
	// 	preloader: false,
		
	// 	midClick: true,
	// 	removalDelay: 300,
	// 	mainClass: 'my-mfp-zoom-in'
	// });

	// $('.nbh-popup-with-move-anim').magnificPopup({
	// 	// type: 'inline',

	// 	// fixedContentPos: false,
	// 	// fixedBgPos: true,

	// 	// overflowY: 'auto',

	// 	// closeBtnInside: true,
	// 	// preloader: false,
		
	// 	// midClick: true,
	// 	// removalDelay: 300,
	// 	// mainClass: 'my-mfp-zoom-in'

	// });
	$('.nbh-popup-with-move-anim').magnificPopup({
		  callbacks: {
		   beforeClose: function() {
		    	if(history.pushState) {
				    history.pushState(null, null, urlNow);
				}
		  	}
		  },
		 closeOnContentClick: false,
		closeOnBgClick:false,
		type: 'inline',
		fixedContentPos: true,
		fixedBgPos: false,
		overflowY: 'scroll',
		overflowX: 'hidden',
		closeBtnInside: true,
		preloader: true,
		midClick: true,
		removalDelay: 300,
		mainClass:'my-mfp-slide-bottom',

	});
		// $(document).on('click','.mfp-close',function(event){
		// 		// event.preventDefault();
		// 		//  if(history.pushState) {
		// 		//     history.pushState(null, null, urlNow);
		// 		//   }	
		// 		//   $.pjax({
		// 		//       url:urlNow,
		// 		//       container: '#fast-container',
		// 		//    });
		// });

		//  $(document).on('click','.mfp-wrap',function(event){
		// 		event.preventDefault();

		// 		 if(history.pushState) {
		// 		    history.pushState(null, null, urlNow);
		// 		  }	
		// 		  $.pjax({
		// 		      url:urlNow,
		// 		      container: '#fast-container',
		// 		   });
		// 	});
		// $(document).on('click','#fast-dialog',function(event){
		// 		event.preventDefault();
				
		// 		 //alert(123);
		// 		 console.log(123);
		// 		 return false;
		// 	});
		
});
	$(function(){
		$('body').on('click','.BNC_detailed',function(event){
			event.preventDefault();
			var url=$(this).attr('href');
			window.location.href=url;
		});
	});
	var direction = "right";
	$(document).pjax('a[data-pjax]', '#fast-container');
	$(document).ready(function(){
		$.pjax.defaults.timeout = 1200;	
	});
	$('body').on('click','.quickview',function  (event) {
		//event.preventDefault();
		$('#fast-product-content').html('');
		var product_id = $(this).attr('data-product-id');
		var link = $('base').attr('href')+'/product-product-ajaxProductViewFast.html';
		 loadding('load');
		 //$(".mfp-bg").css('background', 'transparent');
				$.ajax({
					url:link,
					type:'POST',
					dataType:'html',
					cache: true,
					data:{product_id:product_id},
					success:function(res){
						$('#fast-product-content').html(res);
						loadding('remove');
						$.magnificPopup.open({
							  items: {
							    src: '<div id="fast-dialog" class="fast-dialog zoom-anim-dialog"><div id="fast-product-content">'+res+'</div><button title="Close (Esc)" type="button" class="mfp-close">×</button></div>', // can be a HTML string, jQuery object, or CSS selector
							    type: 'inline',
							     closeOnContentClick: false,
							     closeOnBgClick:false
							  },
							  
							}, 0);
						//$(".mfp-bg").css('background', '#0b0b0b');
						//$('.mfp-content').html('<div id="fast-dialog" class="fast-dialog zoom-anim-dialog"><div id="fast-product-content">'+res+'</div><button title="Close (Esc)" type="button" class="mfp-close">×</button></div>');
					},
					error:function (error) {
						console.log('err');
					}
				});
		
	})
	

