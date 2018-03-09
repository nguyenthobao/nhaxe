var ProductSearchAdvance = function () {
    var filterProduct = function() {
        base_url = $('base').attr('href');
        $('body').on('click','.BNC_filter',function(){
            var $this = $(this);
            loadding('load');
            var current = $('#BNC_current_url').val();
            var arrFirst = current.split('?');
            var $name = $this.attr('data-name');
            var $value = $this.attr('data-value');
            var newKey  = $name+'='+$value;
            var keys = [];
            url_filter_1  = "";
            url_filter_2  = "";
            if(typeof(arrFirst[1]) != 'undefined' && arrFirst[1]!=""){
                var arrFilter = arrFirst[1].split('&');
                $.each(arrFilter,function(k,v){
                    if (v!=null && v!='undefined') {
                        keys.push(v);
                    }
                });
            }else{
                keys.push(newKey);
            }
            keys = $.unique(keys);
            if ($.inArray(newKey,keys) > -1) {
            }else{
                keys.push(newKey);
            }
            $.each(keys,function(k,v){
                var vs = v.split('=');
                if (vs[0].toString() == $name) {

                    url_filter_1 = $name + "=" + $value;
                }else{
                    url_filter_2 += '&'+v;
                }
            });


            var url_filter = arrFirst[0] + '?' + url_filter_1+url_filter_2;
            var dataString=url_filter_1+url_filter_2;


           var jqxhr = $.ajax({
                url:base_url+'/product-ajaxProduct-ajaxFilterAdvance.html?'+dataString,
                type:'GET',
                //data:{data:dataString},
                dataType:'html',
                success:function(data){
                    $('#BNC_current_url').val(url_filter);
                    window.history.pushState("", "",url_filter);
                    $(".tab-content").html(data);
                    if ($name=='category') {
                        var url_load = base_url+'/product-ajaxProduct-getSubCategory-'+$value+'.html';
                        //$('.filter').load(url_load + ' .filter > *');

                        $('.f-cate-ul').load(url_load,function(resrponseText, statusText, xhr){
                            if(statusText == "success")
                                loadding('remove');
                                //$(this).html(resrponseText);
                                // //console.log(resrponseText);
                                // $('html, body').animate({
                                //     scrollTop: $(".f-page-tab").offset().top
                                //  }, 2000);

                        });
                    }else{
                        loadding('remove');
                         // $('html, body').animate({
                         //    scrollTop: $(".f-page-tab").offset().top
                         // }, 2000);
                    }
                    //console.log(data);
                },
                error:function(xhr, ajaxOptions, thrownError){
                    //console.log(thrownError);
                }
            });
        });

    }

    return {
        init: function () {
            //searchCategory();
            filterProduct();
            $('.BNC_showhide').click(function(){
                var parent=$(this).parent();
                var full = $(this).parent().hasClass('full');
                if (full==true) {
                    parent.removeClass('full');
                }else{
                    parent.addClass('full');
                }
            });
        }
    };
}();