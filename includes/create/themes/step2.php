<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Tạo website</title>
<link rel="stylesheet" type="text/css" href="http://nhaxe.vn/themes/web/resources/plugins/bootstrapv3/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="http://nhaxe.vn/themes/web/resources/css/style.css">
<link rel="stylesheet" type="text/css" href="http://nhaxe.vn/themes/web/resources/plugins/font-awesome-4.2.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="http://nhaxe.vn/themes/web/resources/plugins/fancyapps-fancyBox-18d1712/source/jquery.fancybox.css">
<script src="http://nhaxe.vn/themes/web/resources/js/jquery-1.11.1.min.js"></script>
<script src="http://nhaxe.vn/themes/web/resources/plugins/bootstrapv3/js/bootstrap.min.js"></script>
<script src="http://nhaxe.vn/themes/web/resources/plugins/fancyapps-fancyBox-18d1712/source/jquery.fancybox.pack.js"></script>
</head>

<body>
<div class="web-body">
  
<div class="mystep">
    <div class="container">
        <ul>
          <li>
              <i>1</i><span>Đăng ký tài khoản</span>
            </li>
           <li class="active">
              <i>2</i><span>Chọn mẫu giao diện</span>
            </li>
            <li>
              <i>3</i><span>Khởi tạo dữ liệu website</span>
            </li></i><!-- <span>Copy dữ liệu website</span> -->
            </li>
        </ul>
    </div>
  </div>
 
 <div id="gd" class="r-templete">
    
    <div class="container ">
      
     

     

      <div class="tab-content">
          <div class="tab-pane active" id="noibat">
          <ul class="owl-nb row" id="search_subid">

            <?php foreach ($data['themes'] as $k => $v) { ?>
              <li class="col-md-4" data="<?=$v['sub_id']?>">
              <div class="r-tem-item">
                <div class="r-tem-boder"> <a class="r-tem-item-a" href="" title=""> <img src="<?php echo loadImage($v['img'], 'none', 0, 0); ?>"  onerror="this.onerror=null;this.src='<?php echo loadImage($v['img'], 'none', 0, 0); ?>'"  class="img-responsive"> </a>
                  <div class="r-item-overlay">
                    <div class="takebottom"> <h3><?=$v['title']?></h3> <a href="<?php echo loadImage($v['img'], 'none', 0, 0); ?>" title="Xem giao diện dưới dạng ảnh" class="r-item-zoom fancybox" data-fancybox-group="gallery"><img src="<?=$_B['static']?>resources/css/imgs/view.png"></a>
                     <?php if(number_format($v['price'], 0, ',', '.')==0){ ?>
                      <a href="javascript:;" data-id="<?=$v['sub_id']?>" title="Chọn giao diện" class="r-tem-select-bt">Chọn</a>
                      <?php } ?>
                      <a href="<?=$v['link_demo']?>" title="Xem chi tiết giao diện" class="r-tem-detail-bt" target="_blank">Xem chi tiết</a> </div>
                  </div>
                </div>
              </div>
            </li>
            <? } ?>
          </ul>
        
      </div>
    </div>
  </div>
  
</div>
 
 <script>
   $(document).ready(function() {

    $('.fancybox').fancybox({

      fitToView: false

    });

    $("#searh_themes").keyup(function(event){
      if(event.keyCode == 13){
        var key = $("#searh_themes").val();
        $('#search_subid').find('li').each(function() {
            $(this).show();
            var sea = $(this).attr('data');
            if(sea.search(key) == -1){
              $(this).hide();
            }  
        });
      }
    });
    
  });
window.onbeforeunload = function(e) {
    return 'Bạn chưa hoàn thành quy trình tạo web, hãy chọn giao diện để tiếp tục quá trình tạo web!';
}; 
$('.r-tem-select-bt').click(function () {

    window.onbeforeunload = null;
    var idgd = $(this).attr('data-id');
    $.ajax({
          url: '<?=$_B['create_home']?>?mod=ajax',
          type: 'POST', 
          dataType: 'JSON',
          data: {action:'chooseTheme',idgd: idgd},
          success: function(data){ 
            console.log(data);
            if(data.status){ 
              
              window.location.href = '<?=$_B['create_home']?>?step=3';
            }
            else
            {
                return false;
            }
          }
    });
});
 </script>
</body>
</html>