
<!DOCTYPE html>
<html lang="vi">

<head>

    <title>BNC Group - APP - <?php echo $_DATA['detail']['meta_title']; ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Description" content="<?php echo $_DATA['detail']['meta_description']; ?>" />
    <meta name="Keywords" content="<?php echo $_DATA['detail']['meta_keyword']; ?>" />  
    <meta property=”og:site_name” content="Thiết kế website chuyên nghiệp <?php echo $_DATA['detail']['meta_title']; ?>"/>
    <meta property=”og:url” content="<?php echo $_B['current_url']; ?>" />
    <meta property=”og:title” content="<?php echo $_DATA['detail']['meta_title']; ?>" />
    <meta property=”og:image” content="<?php echo loadImage($_DATA['detail']['img'], 'none', 0, 0); ?>" />
    <link href="<?php echo $_B['static'] ?>/app/bootstrap/css/bootstrap.css" type="text/css" rel="stylesheet">
    <link rel="shortcut icon" href="http://webbnc.net/img/bnc/favicon.png" type="image/x-icon"/>
    <link rel="apple-touch-icon" href="http://webbnc.net/img/bnc/favicon.png">
    <link rel="stylesheet" type="text/css" href="<?php echo $_B['static'] ?>/app/css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="<?php echo $_B['static'] ?>/app/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">


     <!-- bxSlider CSS file -->
    <link href="<?php echo $_B['static'] ?>/app/css/jquery.bxslider.css" rel="stylesheet" />

<!-- CSS fancybox -->
        <link rel="stylesheet" href="<?php echo $_B['static'] ?>/app/css/fancybox/jquery.fancybox-buttons.css">
        <link rel="stylesheet" href="<?php echo $_B['static'] ?>/app/css/fancybox/jquery.fancybox-thumbs.css">
        <link rel="stylesheet" href="<?php echo $_B['static'] ?>/app/css/fancybox/jquery.fancybox.css">

        <link rel="stylesheet" href="<?php echo $_B['static'] ?>/app/css/fancybox/myfancybox.css"><!-- DELETE -->
<!--end CSS fancybox -->
<script lang="javascript">(function() {var pname = ( (document.title !='')? document.title : document.querySelector('h1').innerHTML );var ga = document.createElement('script'); ga.type = 'text/javascript';ga.src = '//live.vnpgroup.net/js/web_client_box.php?hash=2eb7d3febaa9c63a3f439e90c554d8ec&data=eyJzc29faWQiOjIwMDAyLCJoYXNoIjoiNmIxZjZjZGZjOWU4MjM4MzU0MDZiNzkxY2JjNjAxMGMifQ--&pname='+pname;var s = document.getElementsByTagName('script');s[0].parentNode.insertBefore(ga, s[0]);})();</script>    
<!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-5JKLDLZ');</script>
    <!-- End Google Tag Manager -->   

</head>

<body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5JKLDLZ"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
    <!--strat header -->
    <header>
        <div class="container">
            <div id="header">
                <div class="row">
                    <div class="col-md-2 col-sm-2 col-xs-6">
                        <div class="logo">
                            <a href="http://app.webbnc.net<?php echo $_DATA['link_svg']; ?>" title="BNC Group" alt="logo BNC Groups"><img src="<?php echo $_B['static'] ?>/app/images/logo.png" title="BNC Group" alt="logo"></a>
                        </div>
                    </div>
                    <div class="col-md-10 col-sm-10 col-xs-6">
                      <div class="header-column"><div class="header-row"><div class="header-nav header-nav-stripe"><button class="btn header-btn-collapse-nav"><i class="fa fa-bars"></i></button> 
                      <div class="header-nav-main header-nav-main-square header-nav-main-effect-2 header-nav-main-sub-effect-1 collapse"><nav><ul class="nav nav-pills" id="mainNav"><li><a href="http://webbnc.net/<?php echo $_DATA['link_svg']; ?>">Trang chủ</a> </li><li class="dropdown"><a class="dropdown-toggle" href="#">Tạo website<i class="fa fa-caret-down"></i></a><ul class="dropdown-menu"><li><a href="http://webbnc.net/features.html<?php echo $_DATA['link_svg']; ?>">Tính năng</a></li><li><a href="http://webbnc.net/templates.html<?php echo $_DATA['link_svg']; ?>">Kho giao diện</a></li><li><a href="http://webbnc.net/app.html<?php echo $_DATA['link_svg']; ?>">Kho ứng dụng</a></li></ul></li><li class=""><a href="http://webbnc.net/pricing.html<?php echo $_DATA['link_svg']; ?>">Bảng giá</a> </li> <li class=""><a target="_blank" href="http://marketing.webbnc.net<?php echo $_DATA['link_svg']; ?>">Marketing</a> </li> <li class=""><a href="http://webbnc.net/about.html<?php echo $_DATA['link_svg']; ?>">Giới thiệu</a> </li><li class=""><a href="http://webbnc.net/recruit.html<?php echo $_DATA['link_svg']; ?>">Tuyển dụng</a> </li> <li class=""><a href="http://webbnc.net/contact.html<?php echo $_DATA['link_svg']; ?>">Liên hệ</a> </li></ul></nav></div></div></div></div>

                    </div>
                </div>
                <!-- End row-->
            </div>
        </div>
    </header>
    <!--end header -->

    <!-- dau trang -->
    <aside class="dautrang">
      <div class="dautrang-ab">
        <div class="container">
          <div class="row">
            <div class="col-lg-6 col-md-5 col-sm-6 col-xs-12">
                <h2>
                Tạo website ngay ! <br>
                trải nghiệm các ứng dụng<br>
                giúp bạn bán hàng tốt hơn<br>
                </h2>
                <h3><button onclick="window.location.href='http://v2.webbnc.net/<?php echo $_DATA['link_svg']; ?>'" target="_blank">Tạo website ngay</button></h3>
            </div>
            <div class="col-lg-6 col-md-7 col-sm-6 col-xs-12"></div>
          </div>
        </div>
      </div>
      <img src="<?php echo $_B['static'] ?>/app/images/banner.png" alt="banner">
    </aside>
    <!--End dau trang -->


     <!-- start Container all -->
    <div id="single" class="container">
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-7 col-xs-12 ">
                <p><span class="page-before"><a href="http://app.webbnc.net<?php echo $_DATA['link_svg']; ?>" title="Tất cả ứng dụng">Tất cả ứng dụng </a></span>/<span> <?php echo $_DATA['detail']['title']; ?></span></p>
                <h1 id="appName"><?php echo $_DATA['detail']['title']; ?></h1>
                <hr>
                <?php echo $_DATA['detail']['details']; ?>

                <br>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-5 col-xs-12 ">
                <!-- aside chon cai dat app -->
                <div class="install">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#showPop"><i class="fa fa-cart-arrow-down"></i>  Cài đặt ứng dụng</button>
                    <div class="install-ct">
                        <p><span>Phí cài đặt</span><span class="right"> <?php if ($_DATA['detail']['price'] != 0) {echo number_format($_DATA['detail']['price'], 0, ',', '.');?> vnđ / Năm<?php } else {?> miễn phí <?php }?> <span></p>
                        <hr>
                        <p><span>Nhà phát triển:</span><span class="right"><a href="https://webbnc.net<?php echo $_DATA['link_svg']; ?>" title="thiết kế web, thiết kế web miễn phí">WebBNC.net</a></span></p>
                    </div>
                </div>
                <!-- End aside chon cai dat app -->
                <!-- aside ho tro -->
                <div class="aside-support">
                    <button type="submit"> <i class="fa fa-support"></i>  Hỗ trợ</button>
                    <div class="install-ct">
                        <p><span>Phone:</span><span class="right"> 1900.2008</span></p>
                        <hr>
                        <p><span>Email:</span><span class="right"> info@ibnc.vn</span></p>
                    </div>
                </div>
                <!-- End aside ho tro -->
                <!-- aside view hinh anh -->
                <div class="sidebar-img-app">
                    <h3>Hình ảnh ứng dụng</h3>
                    <hr>
                    <div class="gal">
                        <ul class="bxslider">
                        <?php if (!empty($_DATA['detail']['anh1'])) {?>
                          <li><a class="fancybox" rel="group" href="<?php echo loadImage($_DATA['detail']['anh1'], 'none', 0, 0); ?>" title="<?php echo $_DATA['detail']['title']; ?>"><img src="<?php echo loadImage($_DATA['detail']['anh1'], 'none', 0, 0); ?>" alt="<?php echo $_DATA['detail']['title']; ?>"></a></li>
                        <?php }?>
                        <?php if (!empty($_DATA['detail']['anh2'])) {?>
                          <li><a class="fancybox" rel="group" href="<?php echo loadImage($_DATA['detail']['anh2'], 'none', 0, 0); ?>" title="<?php echo $_DATA['detail']['title']; ?>"><img src="<?php echo loadImage($_DATA['detail']['anh2'], 'none', 0, 0); ?>" alt="<?php echo $_DATA['detail']['title']; ?>"></a></li>
                         <?php }?>
                        <?php if (!empty($_DATA['detail']['anh3'])) {?>
                          <li><a class="fancybox" rel="group" href="<?php echo loadImage($_DATA['detail']['anh3'], 'none', 0, 0); ?>" title="<?php echo $_DATA['detail']['title']; ?>"><img src="<?php echo loadImage($_DATA['detail']['anh3'], 'none', 0, 0); ?>" alt="<?php echo $_DATA['detail']['title']; ?>"></a></li>
                          <?php }?>
                        <?php if (!empty($_DATA['detail']['anh4'])) {?>
                          <li><a class="fancybox" rel="group" href="<?php echo loadImage($_DATA['detail']['anh4'], 'none', 0, 0); ?>" title="<?php echo $_DATA['detail']['title']; ?>"><img src="<?php echo loadImage($_DATA['detail']['anh4'], 'none', 0, 0); ?>" alt="<?php echo $_DATA['detail']['title']; ?>"></a></li>
                          <?php }?>

                        </ul>
                   </div>
                </div>
                <!-- End aside view hinh anh -->
            </div>
        </div>
    </div>
    <!--end Container -->

    <!--start san pham lien quan -->
    <div class="container">
        <h2>Các ứng dụng khác</h2>
        <hr>
        <div class="row">
             <?php foreach ($_DATA['app_other'] as $k => $v) {if ($k < 4) {?>
                        	<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                             <input class="price" type="hidden" value="<?php echo $v['price']; ?>" />
		                            <div class="box-item">
		                                <!-- noi dung default -->
		                                <div class="box-main">
		                                    <img src="<?php echo loadImage($v['img'], 'none', 0, 0); ?>" alt="<?php echo $v['title'] ?>" title="<?php echo $v['title'] ?>">
		                                    <div class="title">
		                                        <h3><a href="<?php echo $v['link']; ?>" class="title_apps" title="<?php echo $v['title'] ?>"><?php echo $v['title'] ?></a></h3>
		                                        <p> <span class="text-red"><?php if ($v['price'] != 0) { ?> Giá <?php echo number_format($v['price'], 0, ',', '.');?> vnđ / Năm<?php } else {?> Miễn phí <?php }?> <span></p>
		                                    </div>
		                                </div>
		                                <hr>
		                                <div class="box-btn">
		                                    <span class="author glyphicon glyphicon-star"></span>
		                                    <span class="author glyphicon glyphicon-star"></span>
		                                    <span class="author glyphicon glyphicon-star"></span>
		                                    <span class="author glyphicon glyphicon-star"></span>
		                                    <span class="author glyphicon glyphicon-star-empty"></span>
		                                    <span class="right"><?php echo implode(', ', $v['category']); ?></span>
		                                </div>
		                                <!-- End noi dung default -->
		                                <!-- noi dung hover -->
		                                <div class="box-item-info">
		                                    <div class="title-in">
		                                        <div class="tag">
		                                            <h3><a href="<?php echo $v['link']; ?>"  title="<?php echo $v['title'] ?>"><?php echo $v['title'] ?></a></h3>
		                                        </div>
		                                    </div>
		                                    <div class="price-in">
		                                             <span class="text-yellow"> <?php if ($v['price'] != 0) { ?> Giá <?php echo number_format($v['price'], 0, ',', '.');?> vnđ / Năm<?php } else {?> Miễn phí <?php }?> <span>

		                                                <p class="right">
		                                            <span class="author glyphicon glyphicon-star"></span>
		                                            <span class="author glyphicon glyphicon-star"></span>
		                                            <span class="author glyphicon glyphicon-star"></span>
		                                            <span class="author glyphicon glyphicon-star"></span>
		                                            <span class="author glyphicon glyphicon-star-empty"></span>
		                                        </p>
		                                    </div>
		                                    <div class="description-in">
		                                        <p>
		                                             <?php echo $v['short'] ?>
		                                        </p>
		                                    </div>
		                                </div>
		                                <!-- End noi dung hover -->
		                            </div>
		                       </div>
                        <?}}?>
        </div>
    </div>
    <!--end san pham lien quan -->


    <!--start support -->
    <div class="support">
        <div class="form-dangky">
            <div class="container">
                <h2>Bạn vẫn chưa tìm được ứng dụng hỗ trợ</h2>
                <h3>
                    Bạn có thể gợi ý cho chúng tôi về ứng dụng mong muốn của bạn, các ứng dụng có thể giúp bạn quản lý website hiệu quả.
                </h3>
                <br>
                <div class="row">

                    <div id="form-email" class="container">
                        <div class="">
                     <form accept-charset="UTF-8" action="/contact" class="contact-form" method="post" id="form-app">

                    <div class="row clearfix">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <span class="input">
                                    <input required="" type="text" id="contactFormName" class="form-control form-input input-lg" name="contactFormName" placeholder="Họ tên của bạn" autocapitalize="words" value="">
                                  
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <span class="input">
                                    <input required="" type="email" name="contactFormEmail" placeholder="Email của bạn" id="contactFormEmail" class="form-control input-lg" autocorrect="off" autocapitalize="off" value="">
                                   
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <span class="input">
                                    <input required="" type="text" id="web" class="form-control form-input input-lg" name="web" placeholder="Website" autocapitalize="words" value="">
                                   
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <span class="input">
                                    <input required="" type="text" name="phone" placeholder="Phone" id="phone" class="form-control input-lg" >
                                   
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="contactFormMessage" class="sr-only">Nội dung</label>
                        <textarea required="" rows="6" name="contact_body" class="form-control input-lg" placeholder="Bạn vui lòng nhập nội dung" id="contactFormMessage"></textarea>
                    </div>

                    <button type="button"  data-toggle="modal" data-target="#showPop2" class="btn btn-primary btn-lg send-contact" value="GỬI GÓP Ý">GỬI YÊU CẦU</button>
                    <input type="reset" class="btn btn-primary btn-lg reset_bnt" value="LÀM LẠI">
                </div>
                </form>
            </div>
        </div>


                </div>
            </div>
        </div>
    </div>
    <!--end support -->


    <div class="first-ft">
        <!-- <div class="container">
            <div class="row">
                <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
                    <p>
                        Hơn 20,000 doanh nghiệp và chủ shop đang bán hàng như thế nào?
                        Đăng ký dùng thử miễn phí 15 ngày để khám phá
                    </p>
                </div>
                <div class="col-lg-7 col-md-5 col-sm-6 col-xs-12">
                    <div class="col-lg-7 col-md-7 col-sm-6 col-xs-12">
                        <input type="text" id-"company" name="name_company" placeholder="Nhập tên doanh nghiệp cá nhân của bạn">
                    </div>
                    <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
                        <button class="btn use-try">Dùng thử miễn phí</button>
                    </div>
                </div>
            </div>
        </div> -->



        <!-- Modal -->
        <div id="showPop" class="modal fade" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Cài đặt ứng dụng</h4>
              </div>
              <div class="modal-body">
              <label>Nhập website của bạn</label>
                <div class="col-lg-9">
                    
                    <input name="website_name" value="" class="form-control">
                </div>
                <div class="col-lg-3">
                    <button type="button" class="btn btn-default" id="sendRequest">Cài đặt</button>
                </div>
              </div>
              <div class="modal-footer">
                
              </div>
            </div>

          </div>
        </div>
        <div id="showPop2" class="modal fade" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Gửi yêu cầu ứng dụng</h4>
              </div>
              <div class="modal-body">
                    <!--  <img alt="loading" src="<?php echo $_B['static'] ?>/app/images/google-loading-icon.gif"> -->
                    Đang gửi ! Vui lòng chờ ...
              </div>
              <div class="modal-footer">
                
              </div>
            </div>

          </div>
        </div>

    </div>
   
    <!-- start footer -->
    <footer>
        <div class="container">
           
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <h3><strong>Đơn vị chủ quản</strong></h3>
                    <p>Công ty cổ phần công nghệ BNC Việt Nam.</p>
                    <p>Thành viên của VNP Group VatGia.com.</p>
                    <p class="strong"><a href="https://webbnc.net/<?php echo $_DATA['link_svg']; ?>" title="thiết kế web, thiết kế web miễn phí" target="_blank">WebBNC.net</a> - <a href="https://gia247.com/<?php echo $_DATA['link_svg']; ?>" title="giá rẻ nhất" target="_blank"> Gia247.com </a></p>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-6 col-xs-12">
                    <h3><strong>Liên hệ với chúng tôi</strong></h3>
                    <p><i class="fa fa-building-o"></i> Trụ sở chính: Trụ sở chính: Tầng 8, 51 Lê Đại Hành, Hai Bà Trưng, Hà Nội, Việt Nam</p>
                    <p><i class="fa fa-building"></i> Chi nhánh Hồ Chí Minh: 70 Lữ Gia, Phường 15, Quận 11, tp.HCM</p>
                   <p><i class="fa fa-support"></i> Hỗ trợ Hà Nội: 1900.2008 - Hỗ trợ Hồ CHí Minh: (08) 7300 9579</p>
                    <p><i class="fa fa-envelope-o"></i> Email: <span class="strong">contact@bncgroup.com.vn</span></p>
                    <p><i class="fa fa-phone"></i> Hotline : <span class="strong"><?php echo $_DATA['svg']; ?></span></p>
                </div>
            </div>
        </div>
    </footer>
    <!-- End footer -->

    <div id="goTop">
        <div class="go_top" style="display: block; background-size: 20px 20px;" title="Lên trên"></div>
    </div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script src="<?php echo $_B['static'] ?>/app/js/bnc.js" type="text/javascript"></script>
 <!-- FancyBox -->
<script src="<?php echo $_B['static'] ?>/app/js/fancybox/jquery.fancybox.js"></script>
<script src="<?php echo $_B['static'] ?>/app/js/fancybox/jquery.fancybox-buttons.js"></script>
<script src="<?php echo $_B['static'] ?>/app/js/fancybox/jquery.fancybox-thumbs.js"></script>
<script src="<?php echo $_B['static'] ?>/app/js/fancybox/jquery.easing-1.3.pack.js"></script>
<script src="<?php echo $_B['static'] ?>/app/js/fancybox/jquery.mousewheel-3.0.6.pack.js"></script>
<script type="text/javascript">
        $(document).ready(function() {
            $(".fancybox").fancybox();
        });

    </script>
<script src="<?php echo $_B['static'] ?>/app/js/jquery.bxslider.min.js"></script>

<script type="text/javascript">
        $(document).ready(function(){
            $('.bxslider').bxSlider({
              minSlides: 2,
              maxSlides: 3,
              slideWidth: 170,
              slideMargin: 10,
              options: false,
            });
        });

        $('.send-contact').click(function(){
            var $this = $(this);

            var name = $('#contactFormName').val();
            var email = $('#contactFormEmail').val();
            var message = $('#contactFormMessage').val();
            var web=$('#web').val();;
            var sdt =$('#phone').val();
            if(name==false){
            	//alert("Vui lòng nhập tên");
            	$('#contactFormName').focus();
            	return false;
            }
            if(email==false){
            	//alert("Vui lòng nhập email !");
            	$('#contactFormEmail').focus();
            	return false;
            }
            var atpos = email.indexOf("@");
		    var dotpos = email.lastIndexOf(".");
		    if (atpos<1 || dotpos<atpos+2 || dotpos+2>=email.length) {
		       // alert("Vui lòng nhập đúng địa chỉ email !");
		        return false;
		    }
            if(web==false){
            	//alert("Vui lòng nhập website");
            	$('#web').focus();
            	return false;
            }
             if(sdt==false){
            	//alert("Vui lòng nhập sdt");
            	$('#phone').focus();
            	return false;
            }

             
            $.ajax({
                url: '/app-contact.html',
                type: 'POST',
                dataType: 'json',
                data: {name:name,email:email,message:message,sdt:sdt,web:web,type:1},
                success: function(res){
               
                  $('#showPop2').find('.modal-body').text('Cảm ơn quý khách đã gửi hỗ trợ. Chúng tôi sẽ liên hệ lại với quý khách trong thời gian sớm nhất.'); 
                  $('#showPop2').find('.modal-footer').remove();            
                  $("#form-app")[0].reset();
                 
                }
            });

        });

        $('body').on('click','#sendRequest',function(){
            var website=$('input[name="website_name"]').val();
            if(website==false){
                $('input[name="website_name"]').focus();
                return false;
            }
          
            $.ajax({
                url: '/app-contact.html',
                type: 'POST',
                dataType: 'json',
                data: {web:website,type:2,app_name:$('#appName').text()},
                success: function(res){
                   if(res.status){
              
                     $('#showPop').find('.modal-body').text('Cảm ơn quý khách đã đăng kí sử dụng. Chúng tôi sẽ liên hệ lại với quý khách trong thời gian sớm nhất.'); 
                     $('#showPop').find('.modal-footer').remove();
                   }
                   

                }
            });
        });
     $('input[id="phone"]').keyup(function() {
                var number = $(this).val().replace(/[^0-9]/g, '');
                $(this).val(number);
                });
     $('body').on('click','.header-btn-collapse-nav',function(){
       $('.header-nav-main').toggle(); 
    });
    $(window).resize(function() {
      if ($(window).width() < 767) {
         $('body').on('click','.dropdown-toggle',function(){
           $('.dropdown-menu').toggle(); 
        });
      }
    });
    </script>


</body>

</html>
