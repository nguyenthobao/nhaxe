var HomeProductTab = function () {
    var ajaxTab = function() {
        $('.tab-product').click(function() {
            var type = $(this).attr('data-type');
            var url_ajax = $('body').data('url_ajax') + '/product-ajaxHome-ajaxTab' + $('body').data('extension');
            var data = {
                'type' : type
            };
            $.post(url_ajax, data, function(response) {
                //alert(response);
            });

        });
    }
    return {
        init: function () {
            ajaxTab();    
        }
    };
}();