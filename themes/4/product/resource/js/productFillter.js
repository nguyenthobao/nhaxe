
var ProductFillter = function () {
    var ajaxRagePrice=function(){
        var dataString=document.URL.split("?");

        if(dataString[1]!=undefined){
            var url=$('base').attr('href')+'/product-product-rangePrice.html?'+dataString[1];
        }else{
            var url=$('base').attr('href')+'/product-product-rangePrice.html?category=&supplier=';
        }

        //loadding('load');
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
        })
        .success(function(res){
            var is_min=$.cookie('min_price');
            var is_max=$.cookie('max_price');
            if(is_min==undefined){
                is_min=res.min;
            }
            if(is_max==undefined){
                is_max=res.max;

            }
            $('#BNC-slider-price').noUiSlider({
                start: [ is_min, is_max ],
                range: {
                    'min': Number(res.min),
                    'max': Number(res.max)
                }
            }, true);
            //console.log(res);
        })
        .done(function() {
            //console.log("done");
        })
        .fail(function() {
            //console.log("error");
        })
        .always(function() {
            if($(".f-page-tab").offset() != undefined){
                // $('html, body').animate({
                //     scrollTop: $(".f-page-tab").offset().top
                // }, 2000);
            }

            loadding('remove');
        });

    }

    return {
        init: function () {
            ajaxRagePrice();
        },

    };
}();