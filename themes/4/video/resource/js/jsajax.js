var jsajax = function () {
    var video_ajax = function () {
        $('.videotab').bind('click',function(){
            var node = $(this);
            var key = node.attr('id');
            var link = node.attr('data-id');
            var data ='<div class="loadding"> <img src="http://bncvn.net/manhhung/themes/web/common/loading.gif"/> </div>';
            node.parents('.f-center-title').parent().find('.tab-content').html(data);
            //alert(1);
            var url_ajax = link + '/video-ajax-loadcate.html';
            $.ajax({
                url: url_ajax, 
                type: 'POST',
                data: {action:'loadCate',key:key},
                success: function(data){
                setTimeout(function(){
                 node.parents('.f-center-title').parent().find('.tab-content').html(data);
                },500);
                }
            });
        });
    }
    return {
        init: function () {
            video_ajax();
        }
    };
}();