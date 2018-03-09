
var HomeProductCategory = function () {
    var ajaxCategoryTab = function() {
        $('.product-category-tab').click(function(event) {
            event.preventDefault();
            var type = $(this).attr('data-type');
            var cate_id=$(this).attr('data-id');
            var url_ajax = $('base').attr('href') + '/product-ajaxHome-ajaxCategoryTab.html';
            var data = {
                'cate_id':cate_id,
                'type' : type
            };
            var cookie=$.cookie(cate_id);
            if(cookie==type){
              throw '';
            }else{
                loadding('load');
                $.ajax({
                    url:url_ajax,
                    type:'POST',
                    dataType:'html',
                    data:data,
                    success:function(response){
                        $('#product-content-'+cate_id).html(response);
                        loadding('remove');
                        var date = new Date();
                         var minutes = 1;
                         date.setTime(date.getTime() + (minutes * 60 * 1000));
                        $.cookie(cate_id, type, {expires: date,path: '/'});
                    },
                    error:function (error) {
                        console.log('err');
                    }
                });
            }  
        });
    }
    return {
        init: function () {
            ajaxCategoryTab();    
        }
    };
}();