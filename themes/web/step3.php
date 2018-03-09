<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Tạo website</title>
<link rel="stylesheet" type="text/css" href="http://v2.webbnc.net/includes/create/themes/resources/plugins/bootstrapv3/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="http://v2.webbnc.net/includes/create/themes/resources/css/style.css">
<link rel="stylesheet" type="text/css" href="http://v2.webbnc.net/includes/create/themes/resources/plugins/font-awesome-4.2.0/css/font-awesome.min.css">
<script src="http://v2.webbnc.net/includes/create/themes/resources/js/jquery-1.11.1.min.js"></script>
<script src="http://v2.webbnc.net/includes/create/themes/resources/plugins/bootstrapv3/js/bootstrap.min.js"></script>
</head>

<body class="wbodystep3">
<div class="web-body">
  <? include(DIR_ROOT.'includes/create/themes/head.php'); ?> 

  
  <div class="mystep">
    <div class="container">
       
        <ul>
          <li>
              <i>1</i><span>Đăng ký tài khoản</span>
            </li>
            <li>
              <i>2</i><span>Chọn mẫu giao diện</span>
            </li>
            <li class="active">
              <i>3</i><span>Khởi tạo dữ liệu website</span>
            </li>
        </ul>
    </div>
  </div>
  <div class="prgr2 progress progress-striped active">
                <div class="progress-bar" style="width: 0%"></div>
  </div>
  <div id="clouds">
  <div class="cloud x1"></div>
  <div class="cloud x2"></div>
  <div class="cloud x3"></div>
  <div class="cloud x4"></div>
  <div class="cloud x5"></div>
    <div class="cloud x6"></div>
</div>
  
  
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <div class="pd-20">
          <div class="procesweb panel panel-danger">
            <div class="panel-heading">
              <h3 class="panel-title"><i class="fa fa-cog fa-spin"></i> Vui lòng không ấn f5 trong quá trình copy dữ liệu...</h3>
            </div>
            <div class="panel-body pd-20"> <span class="loadingweb fa fa-spinner fa-spin fa-5x"></span>
              <h4>Đang xử lý...</h4>
              <div class="prgr1 progress progress-striped active">
                <div class="progress-bar" style="width: 0%"></div>
              </div>
                 
              <a target="_black" href="<?=$data['webhome']?>" class="gowebsite btn btn-primary" style="display:none">Vào website của bạn</a>
              <a target="_black" href="<?=$data['webadmin']?>" class="gowebsite btn btn-primary" style="display:none">Vào quản trị</a>
           
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<style>
 .modal-dialog {
width: 400px;
margin: 10% auto;
text-align:center;
}
 </style>
<script>
function copyDataWeb(step){
    $.ajax({
          url: '<?=$_B['create_home']?>?mod=ajax',
          type: 'POST', 
          dataType: 'JSON',
          data: {action:'copyweb',step: step,token: '<?=$data['token']?>'},
          success: function(data){ 
            console.log(data);
            if(data.status){ 
              if(data.done){
                   window.setTimeout(function(){

                    $(".progress-bar").css("width","100%");
                    
                    window.setTimeout(function(){
                      $(".procesweb").removeClass("panel-danger");
                      $(".prgr2").removeClass("active");
                      $(".procesweb").addClass("panel-success");
                      $(".panel-title").html("<i class='fa fa-check'></i> Dữ liệu đã copy xong");
                      $(".procesweb h4").html("Dữ liệu đã copy xong");
                      $(".loadingweb").removeClass("fa-spinner");
                      $(".loadingweb").removeClass("fa-spin");
                      $(".loadingweb").addClass("fa-check-circle-o");
                      $(".loadingweb").css("color","#4CAF50");
                      $(".progress").hide();
                      $(".gowebsite").show();
                       $("body").css("background","url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAQACAIAAAAP+8yGAAAE9UlEQVR4Ae3dYY7dRgwD4CXwgN6lh+n9b8P+DFJg667HerXnff4ZBBmIFCVKM5t9/fHnX1+T3+s//S0HOMABDgiItj8gnwBRVg7IQ0hWi3AwgFOnS0XogNB++OnJR0R1uqPlg0gOoTG/+sGpT5rSQWSRA26aplHsdLTbp6mFlCzqlUXvtbgmRTKI8vXKAUJLeZu19T6SzclIHjggZxT/+sp1HIQvuukBGRcaDkw4OFit1Z0mOZty0OkI8kCh9ZjkNfuQS0kOd81dv5nkH2Vep69Ywpsuf52OIDt70/Cm5gMzmhltCSJ7Uxx420IHOPiR+eWLLMf5ovWjOq2D8KZ80cQBwQFfNAvRgKvAAV8kTTudpnkUB0aoTkOUvayjNO10msaUyV0bQAwg5oPbZpErlk5DlMsg6nQWZXNfFNt3gziI1g9w1RhZZD4wZd7L2RnEvRSURcp1PlhoVgkeboDogULTcMwHdNBpDuIG5MN6sgnHKgFEerLdtRsQl0SmTFMmiOYj6PQvPcobIeo0yfny9GRzJXc6TaPYHX4gOkjMrkbQg8TMKgdR7PSDg8ybiSAGkKuLXafH2IxD1Ol+ENsWCynGyw1Islp+coKD3A4iP83lmgtE1vv5bKFlAZjhYpdP/Z+Kw/yqpsfSeOplaTbPosEN/CveeJmTQSSLcvTHG2RRjoPnKma+eKX2jiwCUW7bMrVMEMVrzd9ReGXHYqcfxHJcFl3y5f9uOPEEy+8/ANFbD8gbIcqc8eKuQQQivmgDknNhHe03HFxGRbZc50SpUCq0zBVHRwd0wDr6vbG5DKIgeZ5k2xYNB0RIRnJHJuQBDroIkWrKVXAVB3rPegTRMidJpgPF7kDcOcdBf3bMgqugA/siE44JR0/udAS5B8l9C8k5A/oAyWG8NBwczECE5PTDOOh0BFGLRIDkQ8HNOzsczB/A2eGgAzs7JIvgOAQcFMmEZtL/5rZq8dz+A6LL5Za903T9zE6XiuzaDzJNcteZ7nQ/iH7w5AhykDQza80YxHeLIOcuS9PzWZLVCPoEDhYaviuWTEdQHDwoTT2Dk6b9eaZmGqK+HaLsnaZdgWY6gv7ggFDyOZLjBuS+Qst0BH0TRNmO5PyCcPgBUy6OgNA8e+il4u3ifFCD+E5puuAxOk1yFtJUNX1ksTsiOgvm6TU6fUSabpKmIJKmlEzJIPIUcVeIlGsQ7a+DTEfQjyO5dMDZcXacHWcHool+oFyD6MQHIk2/IJJFIDq+QpuFqG+HSBYp15mGqHe0LTZePUtypiOoKfMx7rrddsLJNAd9TMMxBFpIbQCRZQiSP8BV9I0QdRqizByAZO76AT0ZRHoyoenJhDYP0aGnyfSc3CeV6x7gM7B9L6Fp+nyRjjYHUVhHtWh0Oe6SKNMQVbnmi275cCPetijXW0GU6Qh611qU4+jXbmN79yzSMkF0+1Lh4YY0NYg/px/gAETSNLsPgXSAg99QyjQHxcGH6gAHOMABDsYWdpm+R+u9ObBKwIFiVyQTmisWHFzOQSYfFbtq9CrBAYZAPRnJOMDBJiTjIMvucIGD/lqN9YM5+Bfz3qvStJM0q6ZDEfT+HJw4lLsu4/U9JnxRmV8Q0UFtvI5JlqaUbE4+9+9nGqLuVK4pGURcRaYjKFdBaOaDwTQ1H/ziPtPGq3SgVLgJVIsIjZKVCiTf7oAO/Jz1328hSdeuDSPrAAAAAElFTkSuQmCC)");
                       $("#clouds").hide();
 



                    },1500);
                    
                  },1500);
              }
              else
              {
                window.setTimeout(function(){
                  $(".prgr1 .progress-bar").css("width",data.precent +"%");
                  $(".prgr2 .progress-bar").css("width",data.precent +"%");
                  
                  copyDataWeb(data.step);
                },1500);
              }
              
            }
            else
            {
                copyDataWeb(step);
            }
          }
    });
}
$(document).ready(function() {  
  copyDataWeb(1);

  $('.gowebsite').click(function(){
      window.onbeforeunload = null;
  });

});
  // window.setTimeout(function(){
     
  //   window.setTimeout(function(){
  //     $(".procesweb .progress-bar").css("width","90%");
      
  //   },500);
  //   window.setTimeout(function(){
  //     $(".procesweb .progress-bar").css("width","100%");
  //     $(".procesweb").removeClass("panel-danger");
  //     $(".procesweb").addClass("panel-success");
  //     $(".panel-title").html("<i class='fa fa-check'></i> Dữ liệu đã copy xong");
  //     $(".procesweb h4").html("Dữ liệu đã copy xong");
  //     $(".loadingweb").removeClass("fa-spinner");
  //     $(".loadingweb").removeClass("fa-spin");
  //     $(".loadingweb").addClass("fa-check-circle-o");
  //     $(".loadingweb").css("color","#4CAF50");
  //     $(".procesweb .progress").hide();
  //     $(".gowebsite").show();
  //      $("body").css("background","#0069A3");
  //   },2000);
  // },2000);
 
 
window.onbeforeunload = function(e) {
    return 'Bạn chưa hoàn thành quy trình tạo web, hãy chọn giao diện để tiếp tục quá trình tạo web!';
}; 
 </script>
</body>
</html>
