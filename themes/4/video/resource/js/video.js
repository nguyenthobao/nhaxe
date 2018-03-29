var Video = function () {

    var video_filter = function () {
        var url = '?';
        $('.limit_filter').change(function(){
            var type_filter = $('select[name="type_filter"]').val();
            var name_filter = $('input[name="name_filter"]').val();
            var limit_filter = $('select[name="limit_filter"]').val();
           
            if (limit_filter) {
                url += '&limit='+limit_filter;
            }
            
            var uri = $('#video_filter').attr('action');
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
           
            var uri = $('#video_filter').attr('action');
           window.location.href = uri+url;
            
        });

        $('#submitSearch').bind('click',function(){
        	var name_filter = $('input[name="name_filter"]').val();

            if (name_filter) {
                url += '&title='+name_filter;
            }
            var uri = $('#video_filter').attr('action');
           window.location.href = uri+url;
        	
        });
        $('#video_filter').keydown(function(e){
        	if (e.keyCode == 13) {
        		$('#video_filter').trigger('click');
        	}
        });
    }
    
    return {
        init: function () {
            video_filter();
        }
    };

}();