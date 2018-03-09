var News = function () {
    var news_filter = function () {
        var url = '?';
        $('.limit_filter').change(function(){
            var type_filter = $('select[name="type_filter"]').val();
            var name_filter = $('input[name="name_filter"]').val();
            var limit_filter = $('select[name="limit_filter"]').val();           
            if (limit_filter) {
                url += '&limit='+limit_filter;
            }
            var uri = $('#news_filter').attr('action');
            window.location.href = uri+url;
            
        });        
        $('.type_filter').change(function(){
            var type_filter = $('select[name="type_filter"]').val();
            var name_filter = $('input[name="name_filter"]').val();
            var limit_filter = $('select[name="limit_filter"]').val();
            var url = '?';
            if (type_filter) {
                url += 'type='+type_filter;
            }
            var uri = $('#news_filter').attr('action');
            window.location.href = uri+url;
        });
        $('#submitSearch').bind('click',function(){
            var name_filter = $('input[name="name_filter"]').val();
            if (name_filter) {
                url += '&title='+name_filter;
            }
            var uri = $('#news_filter').attr('action');
            window.location.href = uri+url;
        });
        $('#news_filter').keydown(function(e){
            if (e.keyCode == 13) {
                $('#news_filter').trigger('click');
            }
        });
        // $('.form-filter').keydown(function(e) {
        //     if (e.keyCode == 13) {// mã của phím enter              
        //         var name_filter = $('input[name="name_filter"]').val();
        //         if (name_filter) {
        //             url += '&title='+name_filter;
        //         }
        //         var uri = $('#news_filter').attr('action');
        //         window.location.href = uri+url;
        //     }
        // });
    }
    return {
        init: function () {
            news_filter();
        }
    };
}();