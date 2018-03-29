$(document).ajaxStart(function() {
  loadding('load');
});
$(document).ajaxSuccess(function() {
  loadding('remove');
});
$('body').on('click', '#BNC_reset_password_token', function(event) {
        event.preventDefault();

        var textPassword=$('#txtPassword');
        var textRePassword=$('#txtRePassword');
        var token=$(this).attr('data-token');
        $('#BNC_reset_error').hide();
        $('#BNC_reset_success').hide();

        if(textPassword.val().length<6){
          textPassword.focus();
          $('#BNC_reset_error').html('Mật khẩu phải lớn hơn 6 kí tự');
          $('#BNC_reset_error').show();
          return false;
        }


        if(textPassword.val()==false){
          textPassword.focus();
          $('#BNC_reset_error').html('Vui lòng điền mật khẩu');
          $('#BNC_reset_error').show();
          return false;
        }

        if(textRePassword.val()!=textPassword.val()){
          textRePassword.focus();
          $('#BNC_reset_error').html('Mật khẩu không khớp');
          $('#BNC_reset_error').show();
          return false;
        }
        var dataString={
            password: textPassword.val(),
            repassword:textRePassword.val(),
            token:token  
          };
        $.ajax({
          url:  $('base').attr('href')+'/user-ajax-ajaxResetPassword'+$('base').attr('extention'),
          type: 'POST',
          dataType: 'json',
          data:dataString,
        }).success(function(res) {
          if(res.status==false){
            $('#BNC_reset_error').html(res.message);
            $('#BNC_reset_error').show();
            return false;
          }else{
            window.location.href=$('base').attr('href')+'/user-login'+$('base').attr('extention');
          }
          
        });
       
        return false;

      });



// var PasswordReset = function () {

//     var initResetPassword=function(){
      
  
//     return {
//         //main function to initiate the module
//         init: function () {
//             initResetPassword();
//         }
//     };


// }();