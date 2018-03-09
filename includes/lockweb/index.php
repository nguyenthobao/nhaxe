<?php
$_B['static'] ='http://dev3.webbnc.vn/includes/lockweb/themes/';
?>
<!DOCTYPE html>
<!-- 
Author: Công ty cổ phần WebBNC Việt Nam
Website: https://webbnc.net
Contact: admin@webbnc.vn
Admin  : nguyenbahuong156@gmail.com
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8"/>
<title>Website hết hạn</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta content="Website hết hạn" name="description"/>
<meta content="huongnb" name="author"/>
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
<link href="<?=$_B['static']?>assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
<link href="<?=$_B['static']?>assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
<link href="<?=$_B['static']?>assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="<?=$_B['static']?>assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL STYLES -->
<link href="<?=$_B['static']?>assets/admin/pages/css/lock.css" rel="stylesheet" type="text/css"/>
<!-- END PAGE LEVEL STYLES -->
<!-- BEGIN THEME STYLES -->
<link href="<?=$_B['static']?>assets/global/css/components.css" id="style_components" rel="stylesheet" type="text/css"/>
<link href="<?=$_B['static']?>assets/global/css/plugins.css" rel="stylesheet" type="text/css"/>
<link href="<?=$_B['static']?>assets/admin/layout/css/layout.css" rel="stylesheet" type="text/css"/>
<link href="<?=$_B['static']?>assets/admin/layout/css/themes/darkblue.css" rel="stylesheet" type="text/css" id="style_color"/>
<link href="<?=$_B['static']?>assets/admin/layout/css/custom.css" rel="stylesheet" type="text/css"/>
<!-- END THEME STYLES -->
<link rel="shortcut icon" href="favicon.ico"/>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body>
<div class="page-lock">
	<div class="page-logo">
		<a class="brand" href="https://webbnc.net" target="_blank">
		<img src="http://webbnc.net/img/logo_bnc_v2.png" style="background: transparent;" alt="Công ty cổ phần Webbnc Việt Nam"/>
		</a>
	</div>
	<div class="page-body">
		<div class="lock-head">
			 Website hết hạn sử dụng
		</div>
		<div class="lock-body">
			<!-- <div class="pull-left lock-avatar-block">
				<img src="<?=$_B['static']?>assets/admin/pages/media/profile/photo3.jpg" class="lock-avatar">
			</div> -->
			<p>Hệ thống WebBNC thấy rằng website 
				<b><?=$_WLock['domain']?></b> của quý khách đã hết hạn vào ngày 
				<b><?=date('d-m-Y',$_WLock['enddate'])?></b>.
			<p>Quý khách vui lòng gia hạn để tiếp tục sử dụng dịch vụ.
			<p>Sau 07 ngày toàn bộ dịch vụ sẽ tự động bị hủy (không thể gia hạn và phục hồi được).
			<p>Rất xin lỗi Quý khách vì sự bất tiện này. 
			<div class="col-md-6" style="text-align:center;margin-bottom:2px;"><b>Miền Bắc </b></div>
			<div class="col-md-6" style="text-align:center;margin-bottom:2px;"><b>Miền Nam </b></div>
			<div class="col-md-6 contact-icon" style="text-align:center">
				 Hỗ trợ: 1900.2008
				<!-- <a href="Tel:0978398756" title="0978398756"><span class="glyphicon glyphicon-phone"></span></a>
				<a href="Tel:19006024" title="19006024"><span class="glyphicon glyphicon-phone-alt"></span></a>
				<a href="mailto:admin@webbnc.vn" title="admin@webbnc.vn"><span class="glyphicon glyphicon-envelope"></span></a> -->
			</div>
			<div class="col-md-6 contact-icon" style="text-align:center">
				Hỗ trợ: (08) 7300 9579
				<!-- 
				<a href="Tel:0961255924" title="0961255924"><span class="glyphicon glyphicon-phone"></span></a>
				<a href="Tel:0873025588" title="0873025588"><span class="glyphicon glyphicon-phone-alt"></span></a>
				<a href="mailto:admin@webbnc.vn" title="admin@webbnc.vn"><span class="glyphicon glyphicon-envelope"></span></a> -->
			</div>
					
				
		</div>
		<div class="lock-bottom">
			<a href="https://webbnc.net" target="_blank">Xin chân thành cảm ơn !</a>
		</div>
	</div>
	<div class="page-footer-custom">
		 2011 &copy; Webbnc Việt Nam.
	</div>
</div>
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="<?=$_B['static']?>assets/global/plugins/respond.min.js"></script>
<script src="<?=$_B['static']?>assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->
<script src="<?=$_B['static']?>assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="<?=$_B['static']?>assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<script src="<?=$_B['static']?>assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?=$_B['static']?>assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="<?=$_B['static']?>assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="<?=$_B['static']?>assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?=$_B['static']?>assets/global/plugins/backstretch/jquery.backstretch.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<script src="<?=$_B['static']?>assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="<?=$_B['static']?>assets/admin/layout/scripts/demo.js" type="text/javascript"></script>
<script src="<?=$_B['static']?>assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script>
jQuery(document).ready(function() {    
	Metronic.init(); // init metronic core components
	Layout.init(); // init current layout
	Demo.init();
});
</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>