var Lang = function () {
    var LangSwitch = function () {
        $('.language').bind('click',function(){
        	var lang = $(this).attr('data-language');
            var home_url = $('base').attr('href');
            $.ajax({
                url:home_url+'/language.html',
                type:'POST',
                dataType:'json',
                data:{redirect:$('#langRedirectUrl').val()},
                success:function (res) {
                    console.log(res);
                },
                error:function (error) {
                    console.log(error);
                }
            });
        });
    }
    return {
        init: function () {
            LangSwitch();
        }
    };

}();