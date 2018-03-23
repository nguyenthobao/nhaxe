        if ($('#BNC-slider-price').length)
        {
          $('#BNC-slider-price').noUiSlider({
               start: [ 100, 5000 ],
               connect: true,
               behaviour: 'drag',
               //snap: true, 
                range: {
                    'min': [  2000 ],
                    'max': [ 10000 ]
                },
                format: wNumb({
                    decimals: 3,
                    thousand: '.',
                    postfix: ' (VND)',
                })
            });

          $("#BNC-slider-price").Link('lower').to('-inline-<div class="tooltip"></div>', function ( value ) {

                $(this).html(
                    '<span>' + value + '</span>'+
                    '<input id="BNC_gia_tu" type="hidden" value="' + value + '">'
                );
            });
            $("#BNC-slider-price").Link('upper').to('-inline-<div class="tooltip"></div>', function ( value ) {

                $(this).html(
                    '<span>' + value + '</span>'+
                    '<input id="BNC_gia_den" type="hidden" value="' + value + '">'
                );
            });
        }
       
        // $('#BNC-slider-price').Link('lower').to($('#BNC-slider-price-value-lower'));

        // $('#BNC-slider-price').Link('upper').to($('#BNC-slider-price-value-upper'));
        // 
        
        

var Product = function () {

    var ajaxSearchProduct=function(){
        $(document).on('click', '.BNC-search-product', function(event) {
            event.preventDefault();
            $( "#product-search" ).submit();
        });
       
    }

    
    var ajaxTab = function() {
        $('.product-tab').click(function() {
            var type = $(this).attr('data-type');
            var url_ajax = $('body').data('home_url')+'/product-ajaxHome-ajaxTab'+$('body').data('extension');
            var data = {
                'type' : type
            };
            $(this).parents('ul').find('li').removeClass('active');
            $(this).parent().addClass('active');
            $.post(url_ajax, data, function(response) {
                $('#product-tab').html(response);
            });
        });
    }
    var ajaxCategory = function() {
        $('.product-category').click(function() {
            if($(this).attr('data-ajax')!=0){
                loadding('load');
                 var cate_id = $(this).attr('data-id');
                    var block_id = $(this).attr('data-block');
                    var url_ajax = $('body').data('home_url')+'/product-ajaxHome-ajaxCategory'+$('body').data('extension');
                    var data = {
                        'cate_id' : cate_id
                    };
                    $(this).parents('ul').find('li').removeClass('active');
                    $(this).parent().addClass('active');
                    $('#product-category-'+block_id).find('li').removeClass('active');
                    $('#product-category-'+block_id).find('li:eq(0)').addClass('active');
                    $('#product-category-'+block_id).find('li a').attr('data-id', cate_id);
                    $.post(url_ajax, data, function(response) {
                        $('#product-content-'+block_id).html(response);
                         loadding('remove');
                    });
               
                    return false;
            }
           
        });
    }

    var ajaxCategoryTab = function() {
        $('body').on('click','.product-category-tab',function() {
            var type = $(this).attr('data-type');
            var cate_id = $(this).attr('data-id');
            var block_id = $(this).attr('data-block');
            var url_ajax = $('body').data('home_url')+'/product-ajaxHome-ajaxCategoryTab'+$('body').data('extension');
            var data = {
                'type' : type,
                'cate_id' : cate_id
            };
            $(this).parents('ul').find('li').removeClass('active');
            $(this).parent().addClass('active');
            $.post(url_ajax, data, function(response) {
                $('#product-content-'+block_id).html(response);
            });
        });
    }
    var filterProduct = function() {
        $('#sort_filter').change(function() {
            var sort = $(this).val();
            var params = $('#params').val();
            var url_ajax = $('body').data('home_url')+'/product-ajaxProduct-ajaxFilter'+$('body').data('extension');
            var data = {
                'sort'  : sort,
                'params' : params
            };
            $.post(url_ajax, data, function(response) {
                location.href = response;
            });
        });
        $('#limit_filter').change(function() {
            var limit = $(this).val();
            var params = $('#params').val();
            var url_ajax = $('body').data('home_url')+'/product-ajaxProduct-ajaxFilter'+$('body').data('extension');
            var data = {
                'limit' : limit,
                'params' : params
            };
            $.post(url_ajax, data, function(response) {
                location.href = response;
            });
        });
    }

    // cart
    var selectShop = function() {
        // case with size
        $('body').on('change', '#select-shop-size', function() {
            var idshop = $(this).val();
            if(idshop != ""){
                $('.f-pr-view-box-size').show();
                $('.select-shop-size').hide();
                $('#shop-size-'+idshop).show();
            }else{
                $('.f-pr-view-box-size').hide();
                $('.select-shop-size').hide();
            }
        });
        // case no size
        $('body').on('change', '#select-shop', function() {
            var idshop = $(this).val();
            if(idshop != ""){
                $('.f-pr-view-box-size').show();
                $('.select-shop').hide();
                $('#shop-'+idshop).show();
            }else{
                $('.f-pr-view-box-size').hide();
                $('.select-shop').hide();
            }
        });
        $('body').on('change','#size',function(){
            
            var size_name=$(this).val();
            $('#quantity').show();
            $('.quantity').hide();
            $('#quantity-'+size_name).show();
            $('.BNC-add-cart').attr('data-size',size_name);
        });

    }
    var popoper=function(){
        $('[data-toggle="popover"]').popover()
    }
    var miniCart = function() {
        $('body').on('click', ".miniv2-toolbar-name", function(){
            if ($(".f-miniCart-miniv2").attr("data-status")=='hide') {
                $(".f-miniCart-miniv2").animate({right: "0"}, 500,function() {
                    $(".miniv2-toolbar-close").css("visibility", "visible");
                    $(".f-miniCart-miniv2").attr("data-status", "show");
                });
            }else{
                $(".f-miniCart-miniv2").animate({right: "-250px"}, 500,function() {
                    $(".miniv2-toolbar-close").css("visibility", "hidden");
                    $(".f-miniCart-miniv2").attr("data-status", "hide");
                });
            };
        });
        $('body').on('click', ".miniv2-toolbar-close", function(){
            $(".f-miniCart-miniv2").animate({right: "-250px"}, 500,function() {
                $(".miniv2-toolbar-close").css("visibility", "hidden");
                $(".f-miniCart-miniv2").attr("data-status","hide");
            });
        });
        // case with size
        $('body').on('click', ".add-cart", function(){
            var idProduct = $(this).attr("data-product");
            var idShop = $(this).attr("data-shop");
            var idSize = $(this).attr("data-size");
            var quantity = $('#quantity').find("select[name='quantity']").val();
            if(quantity==undefined){
                var quantity = $('#select-quantity-'+idSize+'-'+idProduct).val();
                if(quantity==undefined){
                     var quantity = $('#select-quantity-'+idProduct).val();
                }
            }
           // console.log(quantity);
            var status = $(".f-miniCart-miniv2").attr('data-status');
            var url_ajax = $('body').data('home_url')+'/product-ajaxCart-ajaxAddCart'+$('body').data('extension');
            var data = {
                'idProduct' : idProduct,
                'idShop' : idShop,
                'idSize' : idSize,
                'quantity' : quantity
            };
            $.post(url_ajax, data, function(response) {
                $(".f-miniCart-miniv2").replaceWith(response);
                if(status == 'hide'){
                    $(".f-miniCart-miniv2").css('z-index', '10000');
                    $(".f-miniCart-miniv2").animate({right: "0px"}, 500, function() {
                        $(".miniv2-toolbar-close").css("visibility", "visible");
                        $(".f-miniCart-miniv2").attr("data-status", "show");
                        Product.flyToCart(idProduct);
                    }); 
                }else{
                    $(".f-miniCart-miniv2").css('z-index', '10000');
                    $(".miniv2-toolbar-close").css("visibility", "visible");
                    $(".f-miniCart-miniv2").attr("data-status", "show");
                    $(".f-miniCart-miniv2").css("right", "0px");
                    Product.flyToCart(idProduct);
                }    
            });
        });
        // case with size
        $('body').on('click', ".BNC-add-cart", function(){
            var idProduct = $(this).attr("data-product");
            var idShop = $(this).attr("data-shop");
            var idSize = $(this).attr("data-size");
            //1
            var quantity=$(this).attr('data-quantity');
            //2
            if(quantity==undefined){
                var quantity = $('.BNC-quantity-select-'+idSize+'-'+idProduct).val();    
            }
            
            //3
            if(quantity==undefined){
                var quantity = $('.BNC-quantity-'+idProduct).val();     
            }
            
            
            // if(idSize!=undefined){
            //     var quantity = $('.BNC-quantity-'+idProduct).val();    
            // }else{
            //     var quantity = $('.BNC-quantity-select-'+idSize+'-'+idProduct).val();
            // }
            
            // //Lay du lieu cua quantity
            // if(quantity==undefined){
            //     var quantity=$(this).attr('data-quantity');
            // }
            
            var status = $(".f-miniCart-miniv2").attr('data-status');
            var url_ajax = $('body').data('home_url')+'/product-ajaxCart-ajaxAddCart'+$('body').data('extension');
            if(quantity!=''){
                var data = {
                'idProduct' : idProduct,
                'idShop' : idShop,
                'idSize' : idSize,
                'quantity' : quantity
            };

            $.post(url_ajax, data, function(response) {
                $(".f-miniCart-miniv2").replaceWith(response);
                if(status == 'hide'){
                    $(".f-miniCart-miniv2").css('z-index', '10000');
                    $(".f-miniCart-miniv2").animate({right: "0px"}, 500, function() {
                        $(".miniv2-toolbar-close").css("visibility", "visible");
                        $(".f-miniCart-miniv2").attr("data-status", "show");
                        Product.flyToCart(idProduct);
                    }); 
                }else{
                    $(".f-miniCart-miniv2").css('z-index', '10000');
                    $(".miniv2-toolbar-close").css("visibility", "visible");
                    $(".f-miniCart-miniv2").attr("data-status", "show");
                    $(".f-miniCart-miniv2").css("right", "0px");
                    Product.flyToCart(idProduct);
                }    
            });
        }else{
            alert("Vui long chon so luong");
            return false;
        }
            
        });
        // case no size
        $('body').on('click', "#add-cart", function(){
            var idProduct = $(this).attr("data-product");
            var idShop = $('#select-shop').val();
            var quantity = $('#shop-1').find("select").val();
            if(quantity==undefined){
               var quantity= $(this).attr('data-quantity');
                var total_quantity= $(this).attr('data-total-quantity');
               $(this).attr('data-total-quantity',total_quantity-1);
               if(total_quantity<1){
                 var quantity=0;
               }
            }
            var status = $(".f-miniCart-miniv2").attr('data-status');
            if(idShop != ""){
                var url_ajax = $('body').data('home_url')+'/product-ajaxCart-ajaxAddCart'+$('body').data('extension');
                var data = {
                    'idProduct' : idProduct,
                    'idShop' : idShop,
                    'quantity' : quantity
                };
                $.post(url_ajax, data, function(response) {
                    $(".f-miniCart-miniv2").replaceWith(response);
                    if(status == 'hide'){
                        $(".f-miniCart-miniv2").animate({right: "0px"}, 500, function() {
                            $(".miniv2-toolbar-close").css("visibility", "visible");
                            $(".f-miniCart-miniv2").attr("data-status", "show");
                            Product.flyToCart(idProduct);
                        }); 
                    }else{
                        $(".miniv2-toolbar-close").css("visibility", "visible");
                        $(".f-miniCart-miniv2").attr("data-status", "show");
                        $(".f-miniCart-miniv2").css("right", "0px");
                        Product.flyToCart(idProduct);
                    }
                });
            }else{
                alert("Bạn chưa chọn cửa hàng và số lượng sản phẩm!!!");
                return false;
            }
        });
        // remove product from cart
        $('body').on('click', '.removeCartItem', function() {
            var idProduct = $(this).attr("data-product");
            var idSize = $(this).attr("data-size");
            var url_ajax = $('body').data('home_url')+'/product-ajaxCart-ajaxRemoveCart'+$('body').data('extension');
            var data = {
                'idProduct' : idProduct,
                'idSize' : idSize
            };
            $.post(url_ajax, data, function(response) {
                $(".f-miniCart-miniv2").replaceWith(response);
                $(".miniv2-toolbar-close").css("visibility", "visible");
                $(".f-miniCart-miniv2").attr("data-status", "show");
                $(".f-miniCart-miniv2").css("right", "0px");
                if($('.miniCartItem').find('li').length == 0){
                    $('.miniv2-toolbar-close').trigger('click');   
                }
            });
        });
    }
    var sizeProduct=function(){
            $('body').on('click','.BNC-size',function(event){
                event.preventDefault();
                
                var size_name=$(this).attr('data-name-size');
                var id_product=$(this).attr('data-id-product');
                $(this).css('border', 'rgb(66, 87, 106) solid 1px');
                $(this).css('border', 'rgb(255, 0, 0) solid 1px');
                //An het 
                $('.BNC-quantity-'+id_product).hide();
                //Show select
                $('.BNC-quantity-select-'+size_name+'-'+id_product).show();
                $('.BNC-add-cart-'+id_product).attr('data-size',size_name).prop('disabled',false);
                return false;
            });
    }
    var paymentCart = function() {
        $('body').on('click', '#payment', function(event) {
            event.preventDefault();
            var href = $(this).attr('href');
            var url_ajax = $('body').data('home_url')+'/product-ajaxCart-ajaxSaveCart'+$('body').data('extension');
            $.post(url_ajax, '', function(response) {
                location.href = href;
                // console.log(response);
                // console.log(123);
            });
            // console.log(url_ajax);
            // console.log(href);
            return false;
        });
    }
    var more_shop=function(){
        $('body').on('click','#more-shop',function(){
            if($('#shop-content').attr('data-is-more')==0){
                 $('#shop-content');
                 $('#shop-content').attr('data-is-more',1).css('overflow', 'auto').css('height', 'auto');
                  $(this).text('Thu gọn')
            }else{
                 $('#shop-content').attr('data-is-more',0).css('overflow', 'hidden').css('height', '127px');
                 $(this).text('Xem thêm')
            }
        });
    }
    var select_size=function(){
         $('body').on('click','.size',function(e){
            e.preventDefault() ;
            $('body').find('.size').css({
                'border': 'rgb(194, 209, 223) solid 1px'
            });
             $(this).css({
                'border': 'rgb(255, 0, 0) solid 1px'
             });

              var size_name=$(this).attr('data-name-size');
            $('#quantity').show();
            $('.quantity').hide();
            $('#quantity-'+size_name).show();
            $('.BNC-add-cart').attr('data-size',size_name);
        });


    }




    return {
        init: function () {
            ajaxTab(); 
            ajaxCategory();  
            ajaxCategoryTab();  
            filterProduct(); // page product
            selectShop(); // cart
            miniCart(); // cart mini
            paymentCart();
            more_shop();
            select_size();
            sizeProduct();
            popoper();
            ajaxSearchProduct();
        },
        flyToCart: function(id_product){

            var image = $(".BNC-image-add-cart-"+id_product);
            var currentCount = $(".miniv2-toolbar-count").text();
            var cartToolBar = $(".miniv2-toolbar-barclick");
            var cartPosition = cartToolBar.offset();
            var cartPositionTop =  cartPosition.top - $(window).scrollTop();
            var cartPositionLeft =  cartPosition.left - $(window).scrollLeft();

            var eTop = image.offset().top;
            var eLeft = image.offset().left;  
            var imagePositionTop =  eTop - $(window).scrollTop();
            var imagePositionLeft =  eLeft - $(window).scrollLeft();

            var newImage ="<img style='top:"+imagePositionTop+"px;left:"+imagePositionLeft+"px' class='moveimg' src="+image.attr("src")+" />";
            $("body").append(newImage);
            $(".moveimg").animate({
                top: cartPositionTop ,
                left: cartPositionLeft,
                height: "118px",
                width: "35px",
                opacity: 0.5,
            }, 1200, function(){
                $(this).remove();
            });
        }
    };
}();