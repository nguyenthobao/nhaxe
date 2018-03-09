var WebCommon = function () {
    var LangSwitch = function () {
        $('.flag_language').bind('click',function(){
        	var lang = $(this).attr('data-language');
            var home_url = $('base').attr('href');
            $.ajax({
                url:home_url+'/language.html',
                type:'POST',
                dataType:'json',
                data:{redirect:$('#langRedirectUrl').val(),lang:lang},
                success:function (res) {
                    if (res.status==true) {
                        window.location.href=res.redirect;
                    }
                },
                error:function (error) {
                    console.log(error);
                }
            });
           
        });
    }
    var searchBasic = function(){
        $('body').on('click','#BNC_btn_search',function(){
            redirectUrl();
        });
        $('#BNC_txt_search').keypress(function(event){
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if(keycode == 13){
                redirectUrl();
            }
        });
    }
    var redirectUrl = function(){
        var base_url = $('base').attr('href');
        var cate = $('select[name="BNC_searchCategory"]').val();
            var text = $('#BNC_txt_search').val();
            if (text!='') {
                if (cate=='product') {
                    var url = '/product.html?title='+encodeURIComponent(text);
                }
                if (cate=='news') {
                    var url = '/news.html?title='+encodeURIComponent(text);
                }
                if (cate=='video') {
                    var url = '/video.html?title='+encodeURIComponent(text);
                }
                if (cate=='album') {
                    var url = '/album.html?q='+encodeURIComponent(text);
                }
                if (cate=='recruit') {
                    var url = '/recruit.html?q='+encodeURIComponent(text);
                }
                window.location.href= base_url+url;
            }
    }
    return {
        init: function () {
            LangSwitch();
            searchBasic();
        }
    };

}();