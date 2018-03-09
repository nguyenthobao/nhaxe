$(document).ajaxStart(function() {
  loadding('load');
});
// $(document).ajaxSuccess(function() {
//   loadding('remove');
// });
var Forgot = function () {
    var initResetPassword=function(){
      $('body').on('click', '#BNC_reset_password', function(event) {
        event.preventDefault();

        var textEmailOrUsername=$('#txtEmailorUsername');
        var captCha=$('#captcha_cha_reset');
        $('#BNC_reset_error').hide();
        $('#BNC_reset_success').hide();

        if(textEmailOrUsername.val()==false){
          textEmailOrUsername.focus();
          $('#BNC_reset_error').html('Vui lòng điền email hoặc tên tài khoản');
          $('#BNC_reset_error').show();
          return false;
        }

        if(captCha.val()==false){
          captCha.focus();
          $('#BNC_reset_error').html('Vui lòng nhập chính xác mã bảo vệ');
          $('#BNC_reset_error').show();

          return false;
        }

        //Check Captcha
        $.ajax({
          url: $('base').attr('href')+'/user-ajax-ajaxCheckCaptcha'+$('base').attr('extention'),
          type: 'POST',
          dataType: 'json',
          data: {captcha: captCha.val()},
        })
        .success(function(res) {
          if(res.status==true){
              //Xu ly gui di
              $.ajax({
                url: $('base').attr('href')+'/user-ajax-ajaxSendReset'+$('base').attr('extention'),
                type: 'POST',
                dataType: 'json',
                data: {email_username: textEmailOrUsername.val()},
              })
              .success(function(resp) {
                loadding('remove');
                if(resp.status==false){
                   textEmailOrUsername.focus();
                  $('#BNC_reset_error').html(resp.message);
                  $('#BNC_reset_error').show();
                }else{
                  textEmailOrUsername.remove();
                  $('.check_capcha').remove();
                  $(this).prop('disabled', 'disabled');
                  $('#BNC_reset_success').html('Yêu cầu khởi tạo lại mật khẩu đã được gửi tới email của bạn. Vui lòng kiểm tra email').show();
                  setTimeout(function () {
                    window.location.href=$('base').attr('href');
                  }, 3000);
                }
              });
              return false;
          }else{
            $('#BNC_reset_error').html('Vui lòng nhập chính xác mã bảo vệ');
            $('#BNC_reset_error').show();
            loadding('remove');
            return false;
          }
        });
        return false;

      });
    }
    var initComponents = function() {
        $("#f5capt_cha").click(function() {
        $("#cap_md").val(0);
        d = new Date();
        var src = $("#capt_img_ct").attr("src");
          $("#capt_img_ct").attr("src", src+'?'+d.getTime());
        });
      }
    return {
        //main function to initiate the module
        init: function () {
            initComponents();
            initResetPassword();
        }
    };

}();