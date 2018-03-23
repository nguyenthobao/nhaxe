
var Subscribe = function () {
    var ajaxsubscribe=function(){
       $('body').on('click', '.BNC_submit_subscribe', function(){
          loadding('load');
          var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
          var email=$('#subscribe_email');
          var gender=$(this).attr('data-gender');
          $('#alert-subscribe').hide();
          if(re.test(email.val())==false){
            $('#notify-subscribe').html($('#alert-subscribe').attr('data-lang'));
            $('#alert-subscribe').removeClass('alert-success').removeClass('alert-warning').addClass('alert-danger').show(); 
            email.focus();
          }else{
            var url_home=$('base').attr('href');
            var ext=$('base').attr('extention');
            var urlSend=url_home+'/subscribe-ajaxSubscribe-ajaxSubscribeMethod'+ext;
            $.ajax({
              url: urlSend,
              type: 'POST',
              dataType: 'json',
              data: {email: email.val(),gender:gender},
            }).success(function(res) {
               console.log(123);
              if(res.status==false){
                 $('#notify-subscribe').html(res.msg);
                $('#alert-subscribe').removeClass('alert-danger').removeClass('alert-success').addClass('alert-warning').show();
               
              }else{
                $('#notify-subscribe').html(res.msg);
                $('#alert-subscribe').removeClass('alert-danger').removeClass('alert-warning').addClass('alert-success').show();                
              }
              
              
            });
           

          }
          loadding('remove');
       		return false;
       })
    }
    var ajaxsubscribefooter=function(){
       $('body').on('click', '.BNC_submit_subscribe_footer', function(){
          loadding('load');
          var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
          var email=$('#subscribe-email-footer');
          var gender=$(this).attr('data-gender');
          $('#alert-subscribe-footer').hide();
          if(re.test(email.val())==false){
            $('#notify-subscribe-footer').html($('#alert-subscribe').attr('data-lang'));
            $('#alert-subscribe-footer').removeClass('alert-success').removeClass('alert-warning').addClass('alert-danger').show(); 
            email.focus();
            
          }else{
            var url_home=$('base').attr('href');
            var ext=$('base').attr('extention');
            var urlSend=url_home+'/subscribe-ajaxSubscribe-ajaxSubscribeMethod'+ext;
            $.ajax({
              url: urlSend,
              type: 'POST',
              dataType: 'json',
              data: {email: email.val(),gender:gender},
            }).success(function(res) {
              if(res.status==false){
                 $('#notify-subscribe-footer').html(res.msg);
                $('#alert-subscribe-footer').removeClass('alert-danger').removeClass('alert-success').addClass('alert-warning').show();
              }else{
                $('#notify-subscribe-footer').html(res.msg);
                $('#alert-subscribe-footer').removeClass('alert-danger').removeClass('alert-warning').addClass('alert-success').show();                
              }
              
            });
          }
          loadding('remove');
          return false;
       })
    }
    return {
        init: function () {
            ajaxsubscribe();
            ajaxsubscribefooter();
        },
        
    };
}();