
function GetLocation(location) {
    // alert(location.coords.latitude);
    // alert(location.coords.longitude);
    // alert(location.coords.accuracy);
    $.removeCookie('province',{ path: '/' });
    $.cookie('localtion', location.coords.latitude+'|'+location.coords.longitude, { path: '/' });
    window.location.reload();
}
var Deal = function () {
    var checkSelectPro=function(){
        if(($.cookie('province')==undefined || $.cookie('province')==false) && ($.cookie('localtion')==undefined || $.cookie('localtion')==false)){
            $('.BNC_modal_select_pro').modal('show');
        }
    }
    var selectModal=function(){
        $('.BNC_modal_select_pro').on('click', '.BNC_select_province', function(event) {
            event.preventDefault();
            var province=$('.BNC_modal_select_pro select[name="select_province"]').val();
            if(province=='near'){
                navigator.geolocation.getCurrentPosition(GetLocation);
            }else{
                $.removeCookie('localtion',{ path: '/' });
                $.cookie('province', province, { path: '/' });
                window.location.reload();
            }
        });
         $('.BNC_modal_select_pro').on('click', '.BNC_select_province_close', function(event) {
            event.preventDefault();
            $.removeCookie('localtion',{ path: '/' });
            $.cookie('province', 'all', { path: '/' });
            window.location.reload();
        });

    }

    var downTime=function(){
        var allDownTime=$('body').find('.BNC_value_downtime');
        $.each(allDownTime, function(k, v) {
            var id=$(this).attr('data-id');
            var time=parseInt($(this).attr('data-time'));
            var downTime = new Date(time*1000);
            if(time!=0){
                $('.BNC_down_time_'+id).countdown({until: downTime});
            }else{
                $('.BNC_down_time_'+id).html('Hết hạn');
            }
        });
    }

    var filterDeal = function() {
        var url_ajax = '/deal-deal-ajaxFilter';
        $('#sort_filter_deal').change(function() {
            var sort = $(this).val();
            var params = $('#params').val();

            var data = {
                'sort'  : sort,
                'params' : params,

            };
            var data=ajax_global(data,url_ajax,'POST','json');
            location.href = urlOr+data.url;
        });
        $('#limit_filter_deal').change(function() {
            var limit = $(this).val();
            var params = $('#params').val();
            var data = {
                'limit' : limit,
                'params' : params,

            };
            var data=ajax_global(data,url_ajax,'POST','json');
            location.href = urlOr+data.url;
        });

         $('#category_filter_deal').change(function() {
            var category = $(this).val();
            var params = $('#params').val();
            var data = {
                'category' : category,
                'params' : params,

            };
            var data=ajax_global(data,url_ajax,'POST','json');
            location.href = urlOr+data.url;
        });

        $('#type_filter_deal').change(function() {
            var type = $(this).val();
            var params = $('#params').val();
            var data = {
                'type' : type,
                'params' : params,

            };
            var data=ajax_global(data,url_ajax,'POST','json');
            location.href = urlOr+data.url;
        });

        $('#method_filter_deal').change(function() {
            var method = $(this).val();
            var params = $('#params').val();
            var data = {
                'method' : method,
                'params' : params,

            };
        var data=ajax_global(data,url_ajax,'POST','json');
            location.href = urlOr+data.url;
        });

         $('.BNC-search-deal').click(function() {
            var keyword = $('.BNC_txt_search').val();
            var params = $('#params').val();
            var data = {
                'keyword' : keyword,
                'params' : params,

            };
        var data=ajax_global(data,url_ajax,'POST','json');
            location.href = urlOr+data.url;
        });

    }

    return {
        init: function () {
            checkSelectPro();
            selectModal();
            downTime();
            filterDeal();
        },

    };
}();