<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Tạo website</title>
<link rel="stylesheet" type="text/css" href="http://v2.webbnc.net/includes/create/themes/resources/plugins/bootstrapv3/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="http://v2.webbnc.net/includes/create/themes/resources/css/style_if.css">
<link rel="stylesheet" type="text/css" href="http://v2.webbnc.net/includes/create/themes/resources/plugins/font-awesome-4.2.0/css/font-awesome.min.css">
<script src="http://v2.webbnc.net/includes/create/themes/resources/js/jquery-1.11.1.min.js"></script>
<script src="http://v2.webbnc.net/includes/create/themes/resources/plugins/bootstrapv3/js/bootstrap.min.js"></script>
</head>

<body class="wbody">
<div class="web-body"> 

 
  <div class="container"> 
      <div class="main-web">  
        <div class="col-lg-12">  
              <form class="form-horizontal">
                <fieldset> 
                  <div class="form-group">
                    <div class="col-lg-12">
                      <div class="input-group">
                        
                        <input id="website" name="website" class="form-control" placeholder="Tên website" type="text" data-container="body" data-toggle="popover" data-placement="left" data-content="Tên rút gọn của bạn sử dụng trên hệ thống webbnc, bạn viết liền và không có dấu. ( ví dụ: tendoanhnghiep ). Bạn có thể thêm tên miền các của bạn sau khi tạo website." data-original-title="" title="" data-trigger="focus" >
                        <span class="input-group-addon"><strong>.V2.WEBBNC.NET</strong></span> 
  
                      </div>
                      <p class="showerror_tenrg text-danger" style="display:none"><i class="fa fa-exclamation-circle"></i> Tên website đã tồn tại, vui lòng chọn tên khác !</p>
                      <p class="showsucess_tenrg text-success" style="display:none"><i class="fa fa-check-circle"></i> Bạn có thể sử dụng tên này !</p>
                      
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-lg-12">
                      <input type="text" class="form-control" id="inputEmail" placeholder="Email" data-container="body" data-toggle="popover" data-placement="left" data-content="Nhập email của bạn, chú ý một email tương đương 1 website trên hệ thống." data-original-title="" title="" data-trigger="focus" >
                    </div>
                  </div>
                      <p class="showerror_email text-danger" style="display:none"><i class="fa fa-exclamation-circle"></i> Tên website đã tồn tại, vui lòng chọn tên khác !</p>
                      <p class="showsucess_email text-success" style="display:none"><i class="fa fa-check-circle"></i> Bạn có thể sử dụng tên này !</p>
                      
                  <div class="form-group">
                    <div class="col-lg-12">
                      <input type="password" class="form-control" id="inputPassword" placeholder="Mật khẩu" data-container="body" data-toggle="popover" data-placement="left" data-content="Mật khẩu >6 ký tự." data-original-title="" title="" data-trigger="focus" >
                    </div>
                  </div>
                    <p class="showerror_passwd text-danger" style="display:none"><i class="fa fa-exclamation-circle"></i> Tên website đã tồn tại, vui lòng chọn tên khác !</p>
                    <p class="showsucess_passwdtext-success" style="display:none"><i class="fa fa-check-circle"></i> Bạn có thể sử dụng tên này !</p>
                    
                  <br/>
                  <div class="form-group">
                    <div class="col-lg-12 text-center ">
                      <a   class="btn btn-primary btn-lg createweb"><i style="display:none;" class="fa fa-cog fa-spin"></i> Tạo website miễn phí</a>
                    </div>
                  </div>
                  <div class="bs-component">
              
            </div>
                </fieldset>
              </form>
              
              <!-- Modal -->
                <div class="modal fade" id="showAlert" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      
                      <div class="modal-body">
                        <h4>Website đã tạo thành công !</h4>
                        <p>
                            <a href="<?=$_B['create_home']?>?step=2" target="_black" class="btn btn-primary btn-lg createweb"> Chọn giao diện</a>
                        </p>
                      </div>
                      
                    </div>
                  </div>
                </div> 
        </div>
      </div> 
  </div>
</div> 
<script> 
function IsEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}
function IsTenrg(tenrg) {
  var regex = /^([a-z0-9])+$/;
  return regex.test(tenrg);
}
function reset_noti(){
  $('.showerror_tenrg').fadeOut();
  $('.showerror_email').fadeOut();
  $('.showerror_passwd').fadeOut();
  $('.showsucess_tenrg').fadeOut();
  $('.showsucess_email').fadeOut();
  $('.showsucess_passwd').fadeOut();
}
function show_mes(value,mess,type){
  var nameclass_error = '.showerror_'+value;
  var nameclass_sucess = '.showsucess_'+value;

  if(type == 1){
    $(nameclass_error).html('<i class="fa fa-exclamation-circle"></i>'+mess);

    $(nameclass_error).fadeIn();
    $(nameclass_sucess).fadeOut();
  }
  else
  {
    $(nameclass_sucess).html('<i class="fa fa-check-circle">'+mess);

    $(nameclass_sucess).fadeIn();
    $(nameclass_error).fadeOut();
  }

}

 
  $('#website').keypress(function(){
    $('.showerror_tenrg').fadeOut();
    $('.showsucess_tenrg').fadeOut();
  }); 
  $('#website').change(function(){
      var tenrg = $('#website').val(); 
      $('.showerror_tenrg').fadeOut();
      $('.showsucess_tenrg').fadeOut();
      if ( tenrg.trim() == '') {
          show_mes('tenrg','Tên rút gọn không thể để trống!',1);
          $('#website').focus();
          return false;
      }
      if ( !IsTenrg(tenrg.trim()) ) {
          show_mes('tenrg','Tên rút gọn không đúng định dạng, tên rút gọn chỉ chấp nhận chữ cái tiếng Anh viết thường và chữ số!',1);
          $('#website').focus();
          return false;
      }  
      //console.log(tenrg);
      $.ajax({
            url: '<?=$_B['create_home']?>?mod=ajax',
            type: 'POST', 
            data: {action:'checktenrg',tenrg: tenrg},
            success: function(data){ 
              console.log(data);
              if(data.status){ 
                show_mes('tenrg','Bạn có thể sử dụng tên này !',0);
              }
              else
              {
                  show_mes('tenrg','Tên rút gọn đã được dùng, hãy chọn tên khác!',1);
                  $('#website').focus();
                  return false;
              }
            }
      });
  });
   $('#inputEmail').keypress(function(){
    $('.showerror_email').fadeOut();
    $('.showsucess_email').fadeOut();
  }); 
  $('#inputEmail').change(function(){
    $('.showerror_email').fadeOut();
    $('.showsucess_email').fadeOut();
        var email = $('#inputEmail').val();  

        if ( email.trim() == '') {
          show_mes('email','Email không thể để trống!',1);
          $('#inputEmail').focus();
          return false;
        }
        if ( !IsEmail(email.trim()) ) {
          show_mes('email','Email không đúng định dạng!',1);
          $('#inputEmail').focus();
          return false;
        }  
         $.ajax({
            url: '<?=$_B['create_home']?>?mod=ajax',
            type: 'POST', 
            dataType: 'JSON',
            data: {action:'checkemail',email: email},
            success: function(data){ 
              console.log(data);
              if(data.status){ 
                show_mes('email','Bạn có thể sử dụng email này !',0);
              }
              else
              {
                  show_mes('email','Email đã được sữ dụng, hãy chọn tên khác!',1);
                  $('#inputEmail').focus();
                  return false;
              }
            }
      });
  });


  $(".createweb").on('click',function(){
        reset_noti();
        var tenrg = $('#website').val();
        var email = $('#inputEmail').val();
        var passwd = $('#inputPassword').val();

        if ( tenrg.trim() == '') {
          show_mes('tenrg','Tên rút gọn không được để trống!',1);
          $('#website').focus();
          return false;
        }

        if ( email.trim() == '') {
          show_mes('email','Email không được để trống!',1);
          $('#inputEmail').focus();
          return false;
        }
        if ( !IsEmail(email.trim()) ) {
          show_mes('email','Email không đúng định dạng!',1);
          $('#inputEmail').focus();
          return false;
        }
        if ( passwd.trim() == '') {
          show_mes('passwd','Mật khẩu không được để trống!',1);
          $('#inputPassword').focus();
          return false;
        }
        if ( passwd.trim() == '123456') {
          show_mes('passwd','Mật khẩu 123456 quá đơn giản, hảy chọn mật khẩu khác!',1);
          $('#inputPassword').focus();
          return false;
        }
        if ( passwd.trim() == tenrg.trim()) {
          show_mes('passwd','Mật khẩu không được trùng với tên rút gọn, hãy chọn mật khẩu khác!',1);
          $('#inputPassword').focus();
          return false;
        }
        if ( passwd.trim().length < 6) {
          show_mes('passwd','Mật khẩu quá ngắn, hãy chọn mật khẩu lớn hơn 6 ký tự!',1);
          $('#inputPassword').focus();
          return false;
        }

        $(this).find("i").css("display","inline-block");  
        reset_noti();
        $.ajax({
            url: '<?=$_B['create_home']?>?mod=ajax',
            type: 'POST', 
            data: {action:'createweb',tenrg: tenrg, email: email, passwd: passwd},
            success: function(data){
              console.log(data); 
              if(data.status){
                  
                  window.setTimeout(function(){
                    $('#showAlert').modal('show');
                    // window.setTimeout(function() {
                    //   window.open('<?=$_B['create_home']?>?step=2', '_blank');
                    //   // window.location.href = '<?=$_B['create_home']?>?step=2';
                    // }, 1500);
                  }, 500);

              }
              else
              {
                  show_mes(data.type,data.message,1);
              }
            }
        }); 
  });
  
  

</script>
</body>
</html>
