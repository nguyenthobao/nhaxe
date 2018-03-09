<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Kho giao diện</title>
<link rel="stylesheet" type="text/css" href="http://v2.webbnc.net/includes/create/themes/resources/plugins/bootstrapv3/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="http://v2.webbnc.net/includes/create/themes/resources/css/style.css?v=2">
<link rel="stylesheet" type="text/css" href="http://v2.webbnc.net/includes/create/themes/resources/plugins/font-awesome-4.2.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="http://v2.webbnc.net/includes/create/themes/resources/plugins/fancyapps-fancyBox-18d1712/source/jquery.fancybox.css">
<script src="http://v2.webbnc.net/includes/create/themes/resources/js/jquery-1.11.1.min.js"></script>
<script src="http://v2.webbnc.net/includes/create/themes/resources/js/jquery.autocomplete.min.js"></script>
<script src="http://v2.webbnc.net/includes/create/themes/resources/plugins/bootstrapv3/js/bootstrap.min.js"></script>
<script src="http://v2.webbnc.net/includes/create/themes/resources/plugins/fancyapps-fancyBox-18d1712/source/jquery.fancybox.pack.js"></script>
</head>

<body>
<div class="web-body">
   <? include(DIR_ROOT.'includes/create/themes/head.php'); ?> 

<div class="mystep">
    <div class="container">
        <h2>KHO GIAO DIỆN</h2>
    </div>
  </div>
 
 <div id="gd" class="r-templete">
    
    <div class="container ">
      
      <!-- Nav tabs -->
      <?php
            $category=array();
      ?>
      <ul class="nav nav-tabs r-templete-tab hide" role="tablist">
                    <li class="active"><a href="#"><i class="itab nb"></i><span>Mới nhất</span></a></li>
                    <?php foreach($data['category'] as $k => $v){?>
                      <?php 
                        $category[$v['idtc']]=$v['title'];
                      ?>
                      <li><a href="#"><i class="itab dm"></i><span><?php echo $v['title'];?></span></a></li>    
                    <?php } ?>
     </ul>
      <div class="row">
          <div class="col-sm-6 col-sm-offset-3">
               <input type="text" class="form-control" name="search" id="autocomplete" placeholder="Nhập từ khóa cần tìm kiếm." >
               <div id="outputbox">
                <p id="outputcontent">VD: Thương mại điện tử, mẹ và bé, hoa tươi...</p>
              </div>
          </div>
      </div>
      <!-- Tab panes -->
      <div class="tab-content">
        <div class="tab-pane active" id="noibat">
          <ul class="owl-nb row">
            <?php
              $cat_themes=array();
            ?>
            <?php foreach ($data['themes'] as $k => $v) { ?>
              <?php
                $cat_themes[$category[$v['idt_cat']]] .=$v['idt'].',';
              ?>
              <li class="col-md-4 liShow" data-id="<?php echo $v['idw'];?>">
                <div class="r-tem-item">
                  <div class="r-tem-boder"> <a class="r-tem-item-a" href="" title=""> <img src="http://<?=$_B['home']?>/themes/<?=$v['sub_id']?>/thumb.jpg"  onerror="this.onerror=null;this.src='<?php echo loadImage($v['img'], 'none', 0, 0); ?>'" class="img-responsive"> </a>
                    <div class="r-item-overlay">
                      <div class="takebottom"> <h3><?=$v['title']?></h3> <a href="<?php echo loadImage($v['img'], 'none', 0, 0); ?>" title="Xem giao diện dưới dạng ảnh" class="r-item-zoom fancybox" data-fancybox-group="gallery"><img src="<?=$_B['static']?>resources/css/imgs/view.png"></a>
                        <a href="javascript:;" data-id="<?=$v['sub_id']?>" title="Chọn giao diện" class="r-tem-select-bt">Chọn</a>
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

  $(function(){
  var currencies = [
    <?php foreach ($cat_themes as $k => $v) {  if ($k!=''){?>
      { value: '<?php echo $k;?>', data: '<?php echo $v?>' },
    <?php  }} ;?>
  ];
  
  // setup autocomplete function pulling from currencies[] array
  $('#autocomplete').autocomplete({
    lookup: currencies,
    onSelect: function (suggestion) {
      var data= suggestion.data;
      var data_arrs=data.split(',');
      var themes_arrs=[];
      $.each(data_arrs, function(k, v) {
         if(v!=''){
            themes_arrs.push(v);
         }
      });
      $.each($('.liShow'),function(k, v) {
        var el=$(v);
        var dataId=el.attr('data-id'); 

        if($.inArray(dataId, themes_arrs)==-1){
          el.slideUp();
        }else{
          el.slideDown();
        }
      });
      //console.log(suggestion);
      // var thehtml = '<strong>Currency Name:</strong> ' + suggestion.value + ' <br> <strong>Symbol:</strong> ' + suggestion.data;
      // $('#outputcontent').html(thehtml);
    }
  });
  

});


   $(document).ready(function() {
    $('.fancybox').fancybox({
      fitToView: false
    });

  });
  
$('.r-tem-select-bt').click(function () {

    window.onbeforeunload = null;
    var idgd = $(this).attr('data-id');
    $.ajax({
          url: '<?=$_B['create_home']?>?mod=ajax',
          type: 'POST', 
          dataType: 'JSON',
          data: {action:'chooseThemeFirst',idgd: idgd},
          success: function(data){ 
            console.log(data);
            if(data.status){ 
              
              window.location.href = '<?=$_B['create_home']?>?step=1';
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
