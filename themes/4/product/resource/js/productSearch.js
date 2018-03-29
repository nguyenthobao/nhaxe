var ProductSearch = function () {
    var baseUrl=$('base').attr('href');
    var ext=$('base').attr('extention');
    var searchCategory = function() {
        $('#search-category > li > span').on('click',function() {
            if($(this).parent().find('input').is(':checked') == false){
                $(this).parent().find('input').attr('checked', true);
            }else{
                $(this).parent().find('input').attr('checked', false);
            }
            var array_id = new Array();
            $('#search-category > li').each(function(){
                if($(this).find('input').is(':checked') == true){
                    var id = $(this).find('input:checked').val();
                    array_id.push(id);
                }
            });
            if(array_id.length == 0){
                array_id = '';
            }

            var params = $('#params').val();

            var url_ajax = baseUrl+'/product-ajaxProduct-ajaxFilter'+ext;
            var data = {
                'category' : array_id,
                'params' : params
            };
            $.post(url_ajax, data, function(response) {
                location.href = response;
            });
        });
        $('#search-category > li > input[type="checkbox"]').click(function() {
            var array_id = new Array();
            $('#search-category > li').each(function(){
                if($(this).find('input').is(':checked') == true){
                    var id = $(this).find('input:checked').val();
                    array_id.push(id);
                }
            });
            if(array_id.length == 0){
                array_id = '';
            }
            var params = $('#params').val();
            var url_ajax = baseUrl+'/product-ajaxProduct-ajaxFilter'+ext;
            var data = {
                'category' : array_id,
                'params' : params
            };
            $.post(url_ajax, data, function(response) {
                location.href = response;
            });
        });
    }

    var searchSize = function() {
            $('#search-size > li > input[type="checkbox"]').on('click',function() {
              
                        var array_id = new Array();
                        $('#search-size > li').each(function(){
                            if($(this).find('input').is(':checked') == true){
                                var id = $(this).find('input:checked').val();
                                array_id.push(id);
                            }
                        });
                        if(array_id.length == 0){
                            array_id = '';
                        }
                        var params = $('#params').val();
                        var url_ajax = baseUrl+'/product-ajaxProduct-ajaxFilter'+ext;
                        var data = {
                            'size' : array_id,
                            'params' : params
                        };
                        $.post(url_ajax, data, function(response) {
                            location.href = response;
                            
                        });
                    });
            
        }

        var searchSupplier = function() {
            
            $('#search-supplier > li > input[type="checkbox"]').on('click',function() {

                        var array_id = new Array();
                        $('#search-supplier > li').each(function(){
                            if($(this).find('input').is(':checked') == true){
                                var id = $(this).find('input:checked').val();
                                array_id.push(id);
                            }
                        });
                        if(array_id.length == 0){
                            array_id = '';
                        }
                        var params = $('#params').val();
                        var url_ajax = baseUrl+'/product-ajaxProduct-ajaxFilter'+ext;
                        var data = {
                            'supplier' : array_id,
                            'params' : params
                        };
                        $.post(url_ajax, data, function(response) {
                            location.href = response;
                            //console.log(response);
                        });
                    });
            
        }

    var searchColor = function() {
        $('#search-color > li > a').click(function() {
            if($(this).parent().attr('class') == 'active'){
                $(this).parent().removeClass('active');
            }else{
                $(this).parent().addClass('active');
            }
            var array_color = new Array();
            $('#search-color > li').each(function(){
                if($(this).attr('class') == 'active'){
                    var color = $(this).find('a').attr('data-color');
                    array_color.push(color);
                }
            });
            if(array_color.length == 0){
                array_color = '';
            }
            var params = $('#params').val();
            var url_ajax = baseUrl+'/product-ajaxProduct-ajaxFilter'+ext;
            var data = {
                'color' : array_color,
                'params' : params
            };

            $.post(url_ajax, data, function(response) {
                window.location.href = response;
                //console.log(response);
            });
        });
    }
    var searchProperties = function() {
        $('.search-properties > li > span').click(function() {
            if($(this).parent().find('input').is(':checked') == false){
                $(this).parent().find('input').attr('checked', true);
            }else{
                $(this).parent().find('input').attr('checked', false);
            }
            var array_id = new Array();
            $('.search-properties > li').each(function(){
                if($(this).find('input').is(':checked') == true){
                    var id = $(this).find('input:checked').val();
                    array_id.push(id);
                }
            });
            if(array_id.length == 0){
                array_id = '';
            }
            var params = $('#params').val();
            var url_ajax = baseUrl+'/product-ajaxProduct-ajaxFilter'+ext;
            var data = {
                'properties' : array_id,
                'params' : params
            };
            $.post(url_ajax, data, function(response) {
                location.href = response;
            });
        });
        $('.search-properties > li > input[type="checkbox"]').click(function() {
            var array_id = new Array();
            $('.search-properties > li').each(function(){
                if($(this).find('input').is(':checked') == true){
                    var id = $(this).find('input:checked').val();
                    array_id.push(id);
                }
            });
            if(array_id.length == 0){
                array_id = '';
            }
            var params = $('#params').val();
            var url_ajax = baseUrl+'/product-ajaxProduct-ajaxFilter'+ext;
            var data = {
                'properties' : array_id,
                'params' : params
            };
            $.post(url_ajax, data, function(response) {
                location.href = response;
            });
        });
    }
    var searchPrice = function() {
        // $("#range_price").ionRangeSlider({
        //     type: 'double',
        //     grid: true,
        //     /*onStart: function (data) {
        //         console.log(data);
        //     },
        //     onChange: function (data) {
        //         console.log(data);
        //     },*/
        //     onFinish: function (data) {
        //         //console.log(data);
        //         var min = data.from;
        //         var max = data.to;
        //         var params = $('#params').val();
        //         var url_ajax = baseUrl+'/product-ajaxProduct-ajaxFilter'+ext;
        //         var data = {
        //             'min' : min,
        //             'max' : max,
        //             'params' : params
        //         };
        //         $.post(url_ajax, data, function(response) {
        //             location.href = response;
        //         });
        //     },
        //     /*onUpdate: function (data) {
        //         console.log(data);
        //     }*/
        // });
        
        $("#BNC-slider-price").on({
            change: function(res){
                var min = $('input#BNC_gia_tu').val().trim();
                var max = $('input#BNC_gia_den').val().trim();
                var params   = $('#params').val();
                var url_ajax = baseUrl+'/product-ajaxProduct-ajaxFilter'+ext;
                min = min.replace("(VND)", "");
                max = max.replace("(VND)", "");
                min = min.split('.').join('');
                max = max.split('.').join('');
                var data = {
                    'min' : min,
                    'max' : max,
                    'params' : params
                };
                $.cookie('min_price', min.trim(), { expires: 7, path: '/' });
                $.cookie('max_price', max.trim(), { expires: 7, path: '/' });
                $.post(url_ajax, data, function(response) {
                    location.href=response;
                });
            }
        });
    }
    
    return {
        init: function () {
            searchCategory(); 
            searchColor();
            searchProperties();
            searchPrice();
            searchSize();
            searchSupplier();
        }
    };
}();