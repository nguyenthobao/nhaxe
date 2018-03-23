var Likeproduct = function() {
    var Like = function() {
        $('body').on('click', '.like-product', function(event) {
            event.preventDefault(); /* Act on the event */
            var urlHome = $('body').data('home_url');
            var ext=$('body').data('extension');
            var product = $(this).attr('data-id');
            var product_name = $(this).attr('data-name');
            var is_like = $(this).attr('data-like');
            var product_class = $('.like-product-' + product);
            var text_like = $(this).attr('data-text-like');
            var text_unlike = $(this).attr('data-text-unlike');
            var text_login=$(this).attr('data-login');
            var is_info_page=$(this).attr('data-is-info-page');
            var dataString = {
                'product': product
            };
            if (is_like == 1 || is_like == 3) {

                var urlSend = urlHome + '/product-UserProduct-ajaxUnLike' + ext;
                $.getJSON(urlSend, dataString)
                    .done(function(msg) {
                        product_class.attr('data-like', 0);
                        if(is_info_page!=1){
                            product_class.removeClass('btn-danger').addClass('btn-success');
                            product_class.find('.fa-thumbs-down').removeClass('fa-thumbs-down').addClass('fa-thumbs-up');
                            //product_class.find('#text-like-' + product).text(text_like);
                        }else{
                            var tmp_html='<i class="fa fa-thumbs-o-up"></i>'+text_like;
                            product_class.html(tmp_html);

                        }
                        
                        toastr.info(msg.msg + ' ' + product_name);
                        if(is_like==3){
                        	$('#like-product-item-'+product).remove();	
                        }
                        
                    })
                    .fail(function(jqxhr, textStatus, error) {
                        var err = textStatus + ", " + error;
                        console.log("Request Failed: " + err);
                    });
            } else if (is_like == 0) {
                var urlSend = urlHome + '/product-UserProduct-ajaxCheckLikeProduct' + ext;

                $.getJSON(urlSend, dataString)
                    .done(function(msg) {
                        product_class.attr('data-like', 1);
                        if(is_info_page!=1){
                            product_class.removeClass('btn-success').addClass('btn-danger');
                            product_class.find('.fa-thumbs-up').removeClass('fa-thumbs-up').addClass('fa-thumbs-down');
                            //product_class.find('#text-like-' + product).text(text_unlike);
                        }else{
                            var tmp_html='<i class="fa fa-thumbs-o-down"></i>'+text_unlike;
                            product_class.html(tmp_html);    
                        }
                        toastr.success('<a href="'+urlHome+'/product-UserProduct'+ext+'">'+msg.msg + ' ' + product_name+'</a>');
                    })
                    .fail(function(jqxhr, textStatus, error) {
                        var err = textStatus + ", " + error;
                        console.log("Request Failed: " + err);
                    });
            } else {
                toastr.error(text_login);
            }

        });
    }

    return {
        init: function() {
            Like();
        }
    };
}();