 $('.newstab').bind('click',function(){
    var keyid = $(this).attr('data-id');
    var keyidparent = $(this).attr('data-id-parent');
    var link = $(this).attr('data-url');
    var return_content = '#f-news-cat-home'+keyidparent+keyid;
    var url_ajax = link + '/news-ajax-loadcate.html';
    $.ajax({
        url: url_ajax, 
        type: 'POST',
        data: {action:'loadCate',key:keyid},
        success: function(data){                
            setTimeout(function(){
            $(return_content).html(data);
            },0);
        }
    });
});