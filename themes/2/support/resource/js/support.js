var Support = function () {

    var news_filter = function () {
        $('#submitSearch').bind('click',function(){
          var type_filter = $('select[name="type_filter"]').val();
          var name_filter = $('input[name="name_filter"]').val();
          var limit_filter = $('select[name="limit_filter"]').val();
          var url = '?';

          if (type_filter) {
            url += 'type='+type_filter;
          }
          if (limit_filter) {
            url += '&group='+limit_filter;
          }
            if (name_filter) {
                url += '&title='+name_filter;
            }
            var uri = $('#news_filter').attr('action');
           window.location.href = uri+url;
          
        });
        $('#name_member').keydown(function(e){
          if (e.keyCode == 13) {
            $('#news_filter').trigger('click');
          }
        });
    }
    
    return {
        init: function () {
            news_filter();
        }
    };

}();