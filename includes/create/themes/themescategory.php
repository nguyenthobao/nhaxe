<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
     <title>BNC Group - Themes Store - <? if(!empty($_DATA['category_info']['title'])) { echo $_DATA['category_info']['title']; } ?></title>
     <link rel="shortcut icon" href="http://webbnc.net/img/bnc/favicon.png" type="image/x-icon"/>
     <meta name="Description" content="<?php echo $_DATA['category_info']['meta_description']; ?>" />
    <meta name="Keywords" content="<?php echo $_DATA['category_info']['meta_keyword']; ?>" />  
    <meta property=”og:site_name” content="Thiết kế website chuyên nghiệp <?php echo $_DATA['category_info']['meta_title']; ?>"/>
    <meta property=”og:url” content="<?php echo $_B['current_url']; ?>" />
    <meta property=”og:title” content="<?php echo $_DATA['category_info']['meta_title']; ?>" />
     <link rel="shortcut icon" href="http://webbnc.net/img/bnc/favicon.png" type="image/x-icon"/>
    <!--  CSS -->
    <link rel="stylesheet" href="<?php echo $_B['static'] ?>/themesstore/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $_B['static'] ?>/themesstore/css/animate.css">
    <link href="<?php echo $_B['static'] ?>/themesstore/css/owl.carousel.css" rel="stylesheet">
    <link href="<?php echo $_B['static'] ?>/themesstore/css/owl.theme.css" rel="stylesheet">
    <link href="<?php echo $_B['static'] ?>/themesstore/css/owl.transitions.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $_B['static'] ?>/themesstore/css/style.css?v=26">
    <link rel="stylesheet" href="<?php echo $_B['static'] ?>/themesstore/css/mobile.css">

    <!-- Font Icon -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

    <!-- Fonts Web-->
    <link href="https://fonts.googleapis.com/css?family=Shadows+Into+Light" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i&subset=vietnamese" rel="stylesheet">

    <!-- JS --> 
    <script src="<?php echo $_B['static'] ?>/themesstore/js/jquery.js"></script>
    <script src="<?php echo $_B['static'] ?>/themesstore/js/bootstrap.min.js"></script>
    <script src="<?php echo $_B['static'] ?>/themesstore/js/wow.min_.js"></script>
    <script src="<?php echo $_B['static'] ?>/themesstore/js/owl.carousel.js"></script>
    <script src="<?php echo $_B['static'] ?>/themesstore/js/owl_full.js"></script>
    <script src="<?php echo $_B['static'] ?>/themesstore/js/jquery.devrama.slider-0.9.4.js" type="text/javascript"></script>

    <!-- Scroll-top-->
    <script type="text/javascript" src="<?php echo $_B['static'] ?>/themesstore/js/scroll_top.js"></script>
    <!--End Scroll-top-->

    <script>
        new WOW().init();
    </script>
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
<!-- Header -->
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5JKLDLZ"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<header class="header_main">
    <div class="header_main_inner">
        <div class="container">
            <div class="row">
                <!-- Logo -->
                <div class="col-md-3 col-sm-4 col-xs-12">
                    <div class="logo">
                        <h1><a href="http://themes.webbnc.net/" title="BNC_Group"><img src="/includes/create/themes//themesstore/images/logo2.png" alt="BNC group"></a></h1>
                    </div>  
                </div>
                <!-- End Logo -->
                <!-- Menu Mobile -->
                <div class="overlay"></div>
                <nav class="navbar">
                  <div class="container">
                    <div class="navbar-header">
                      <button type="button" class="navbar-toggle collapsed pull-right" data-toggle="offcanvas">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                      </button>
                    </div>
                    <div id="navbar" class="collapse navbar-collapse sidebar-offcanvas">
                      <ul class="nav navbar-nav">
                           <li><a href="http://webbnc.net/<?php echo $_DATA['link_svg']; ?>" target="_blank">Trang chủ</a></li>
                            <li><a href="http://webbnc.net/pricing.html<?php echo $_DATA['link_svg']; ?>" target="_blank">Bảng giá</a></li>
                             <li class="active"><a href="http://themes.webbnc.net/<?php echo $_DATA['link_svg']; ?>">Kho giao diện</a></li>
                                          
                            <li><a href="http://app.webbnc.net/<?php echo $_DATA['link_svg']; ?>" target="_blank">Kho ứng dụng</a></li>
                            
                            <li><a href="http://marketing.webbnc.net/<?php echo $_DATA['link_svg']; ?>" target="_blank">Marketing</a></li>
                            <li><a href="http://webbnc.net/about.html<?php echo $_DATA['link_svg']; ?>" target="_blank">Giới thiệu </a></li>
                            <li><a href="http://webbnc.net/recruit.html<?php echo $_DATA['link_svg']; ?>" target="_blank">Tuyển dụng</a></li>
                            <li><a href="http://webbnc.net/contact.html<?php echo $_DATA['link_svg']; ?>" target="_blank">Liên hệ</a></li>
                      </ul>
                    </div>
                  </div>
                </nav>
                <!-- End Menu Mobile -->    
                <!-- Menu Main -->
                <div class="col-md-9 col-sm-8 col-xs-12">
                    <nav class="nav_main">
                        <ul>
                            
                            <li><a href="http://webbnc.net/<?php echo $_DATA['link_svg']; ?>" target="_blank">Trang chủ</a></li>
                            <li><a href="http://webbnc.net/pricing.html<?php echo $_DATA['link_svg']; ?>" target="_blank">Bảng giá</a></li>
                             <li class="active"><a href="http://themes.webbnc.net/<?php echo $_DATA['link_svg']; ?>">Kho giao diện</a></li>
                                          
                            <li><a href="http://app.webbnc.net/<?php echo $_DATA['link_svg']; ?>" target="_blank">Kho ứng dụng</a></li>
                            
                            <li><a href="http://marketing.webbnc.net/<?php echo $_DATA['link_svg']; ?>" target="_blank">Marketing</a></li>
                            <li><a href="http://webbnc.net/about.html<?php echo $_DATA['link_svg']; ?>" target="_blank">Giới thiệu </a></li>
                            <li><a href="http://webbnc.net/recruit.html<?php echo $_DATA['link_svg']; ?>" target="_blank">Tuyển dụng</a></li>
                            <li><a href="http://webbnc.net/contact.html<?php echo $_DATA['link_svg']; ?>" target="_blank">Liên hệ</a></li>
                        </ul>
                    </nav>
                </div>
                <!-- Menu Main -->
            </div>
        </div>
    </div>
</header>
<!-- End Header -->

<!-- Content -->
<section class="content_main">
   <!-- Background Title Breadcrumb -->
        <div class="background_title_breadcrumb">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <h2 class="wow zoomIn data-wow-duration="1s" data-wow-delay="0.1s"">Kho Giao Diện
                        </h2>
                        <ol class="breadcrumb wow zoomIn data-wow-duration="1s" data-wow-delay="0.1s"">
                            <li><a href="http://webbnc.net/<?php echo $_DATA['link_svg']; ?>">Trang chủ</a></li>
                            <li><a href="http://themes.webbnc.net/<?php echo $_DATA['link_svg']; ?>">Kho Giao Diện</a></li>
                            <li class="active"><?php echo $_DATA['category_info']['title']; ?></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    <!-- End Background Title Breadcrumb -->

    <!-- Search Products And Link Categories -->
    <section class="search_products_and_link_categories">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <form action="" method="POST" role="form" class="searh_products wow zoomIn data-wow-duration="1s" data-wow-delay="0.9s"">
                        <div class="form-group">
                            <input type="text" class="form-control searh_products_input" id="" placeholder="Từ khóa tìm kiếm">
                        </div>
                        <button type="submit" class="searh_products_action" value=""></button>
                    </form>
                </div>
                <div class="col-md-9 col-md-offset-30">
                    <form action="" class="hiden-md visible-xs wow zoomIn data-wow-duration="0.5s" data-wow-delay="0.2s"">
                        <div class="form-group">
                            <label for="sel1">Chọn Giao Diện</label>
                            <select class="form-control" id="sel1">
                                <option><a href="/themesstore-all.html<?php echo $_DATA['link_svg']; ?>">Tất cả</a></option>
                                <option <?php if($_DATA['active']==2) { ?>class="active" <?php }?>><a href="/mien-phi.html<?php echo $_DATA['link_svg']; ?>">Miễn phí</a></option>
                                <option <?php if($_DATA['active']==3) { ?>class="active" <?php }?>><a href="/tinh-phi.html<?php echo $_DATA['link_svg']; ?>">Tính phí</a></option>
                                <?php
                                foreach ($_DATA['category'] as $ki => $vi)
                                {
                                ?>
                                <option <?php if($_DATA['category_info']['id']==$vi['id']) { ?> class="active" <?php }?>><a href="<?php echo $vi['link'] ?>"><?php echo $vi['title'] ?></a> </option>
                               <?php } ?>
                            </select>
                        </div>
                    </form> 
                    <div class="hidden-xs link_categories wow zoomIn data-wow-duration="0.5s" data-wow-delay="0.2s"">
                         <ul>
                                <li <?php if($_DATA['active']==1) { ?>class="active" <?php }?>><a href="/themesstore-all.html<?php echo $_DATA['link_svg']; ?>">Tất cả</a></li>
                                <li <?php if($_DATA['active']==2) { ?>class="active" <?php }?>><a href="/mien-phi.html<?php echo $_DATA['link_svg']; ?>">Miễn phí</a></li>
                                <li <?php if($_DATA['active']==3) { ?>class="active" <?php }?>><a href="/tinh-phi.html<?php echo $_DATA['link_svg']; ?>">Tính phí</a></li>
                                <?php
                                foreach ($_DATA['category'] as $ki => $vi)
                                {
                                ?>
                                <li <?php if($_DATA['category_info']['id']==$vi['id']) { ?> class="active" <?php }?>><a href="<?php echo $vi['link'] ?>"><?php echo $vi['title'] ?></a> </li>
                               <?php } ?>
                          </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Search Products And Link Categories -->

 

    <!--Top Products-->
    <section class="top_products_main">
        <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="top_products_box wow fadeInUp data-wow-duration="0.2s" data-wow-delay="0.2s"">
                                <div class="top_products_title">
                                 <h2>Lĩnh vực <span class="top_products_text"><?php echo $_DATA['category_info']['title']; ?></span> bạn đang xem</h2>
                                   
                                    <p>Bạn có thể tự tạo theme của riêng bạn hoặc chọn các theme có sẵn được thiết kế và hỗ trợ bởi những partner có nhiều kinh nghiệm trong lĩnh vực online.</p>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                 <?php 
               
                foreach ($_DATA['themes'] as $k => $v)
                {
                ?>
                    <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
                        <div class="top_products_box_info data-wow-duration="0.2s" data-wow-delay="0.2s"">
                            <figure>
                                <a title="<?php echo $v['title'] ?>" href="<?php echo $v['link'];?>"><img src="<?php echo loadImage($v['img'], 'none', 0, 0); ?>" alt="<?php echo $v['title'] ?>"></a>
                            </figure>
                            <figcaption>
                                <div class="top_products_box_info_title">
                                    <h3><a title="<?php echo $v['title'] ?>" href="<?php echo $v['link'];?>"><?php echo $v['title'] ?></a></h3>
                                    
                                </div>
                                <div class="top_products_box_info_start">
                                    <?php for ($i=0; $i < $v['star']; $i++) { 
                                        ?>
                                         <i class="fa fa-star"></i>
                                    <?php    
                                    }  ?>

                                </div>
                                <?php if(number_format($v['price'], 0, ',', '.')==0){ ?>
                               
                                <p class="top_products_box_info_price">Miễn phí</p>
                                <?php 
                                }else{
                                ?>
                                 <p class="top_products_box_info_price"><?php echo number_format($v['price'], 0, ',', '.');?> vnđ </p>
                                <?php } ?>
                                <div class="top_products_box_info_buy">
                                    <a href="<?php echo $v['link'];?>" class="top_products_box_info_btn_buy">Xem</a>
                                </div>          
                            </figcaption>
                        </div>
                    </div>
                    <?php } ?>
                 
                </div>
             <!--    <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <a href="" class="top_products_view_all wow fadeInUp data-wow-duration="1s" data-wow-delay="1.3s"">Xem tất cả giao diện</a>
                    </div>
                </div>   -->
        </div>
    </section>
    <!--End Top Products-->


   

    <!--Contact-->
    <section class="contact_main">
        <div class="container">
            <div class="row">
                <div class="contact_inner">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="contact_inner_title">
                            <h3 class="wow flipInX data-wow-duration="1s" data-wow-delay="1.1s"">Bạn vẫn chưa tìm được giao diện vừa ý</h3>
                            <p class="wow flipInX data-wow-duration="1s" data-wow-delay="1.2s"">Bạn có thể gợi ý cho chúng tôi về giao diện mong muốncủa bạn, giao diện có thể giúp bạn kinh doanh hiệu quả.</p>
                        </div>
                        <figure class="contact_inner_images wow zoomIn data-wow-duration="1s" data-wow-delay="1.3s"">
                            <img src="<?php echo $_B['static'] ?>/themesstore/images/info_contact.png" alt="BNC group" class="img-responsive">
                        </figure>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <form class="form-horizontal contact_form wow zoomIn data-wow-duration="1s" data-wow-delay="1.5s"" accept-charset="UTF-8" action="/contact" method="post" id="form-themes">
                           <div id="thongbaotam"> Đang gửi ! chờ chút nhé ... </div> 
                           <div id="thongbao">Gửi thành công !</div>
                              <div class="col-md-6 col-sm-6 col-xs-12 no-padding">
                                <input type="text" class="form-control txt-input" id="name" placeholder="Họ và tên của bạn" required>
                              </div>
                              <div class="col-md-6 col-sm-6 col-xs-12 no-padding">
                                <input type="email" class="form-control txt-input" id="email" placeholder="Email" required>
                              </div>
                              <div class="col-md-12 col-sm-12 col-xs-12 no-padding">
                                <textarea name="" id="text-content" cols="30" rows="10" required placeholder="Bạn vui lòng nhập yêu cầu làm website"></textarea>
                              </div>
                              <div class="col-md-12 col-sm-12 col-xs-12 no-padding">
                                <button type="button" class="btn btn-danger send-contact">Gửi Yêu Cầu</button>
                                <button type="reset" class="btn btn-success">Hủy</button>
                              </div>
                          </form>
                    </div>
                </div>  
            </div>
        </div>
    </section>
    <!--End Contact-->

</section>
<!-- End Content -->

<!-- Footer -->
<footer class="footer_main" id="footer">
<div class="container">
    <div class="row">
        <div class="footer-ribbon wow fadeInUp data-wow-duration="1s" data-wow-delay="0.1s""><span>Về chúng tôi</span>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12 wow fadeInUp data-wow-duration="1s" data-wow-delay="0.2s"">
            <div class="newsletter">
                <h4>Đơn vị chủ quản</h4>
                <p> Công ty cổ phần công nghệ BNC Việt Nam
                    <br>Thành viên của VNP Group VatGia.com</p>
                <p> <a href="http://gia247.com/<?php echo $_DATA['link_svg']; ?>">Gia247.com</a> - <a href="http://bncgroup.com.vn">BNCGroup.com.vn</a>
                </p>
                <p><img src="<?php echo $_B['static'] ?>/themesstore/images/vnp.png" alt="#"></p>
            </div>
        </div>
        <div class="col-md-5 col-sm-6 col-xs-12 wow fadeInUp data-wow-duration="1s" data-wow-delay="0.3s"">
            <div class="contact-details">
                <h4>Liên hệ với chúng tôi</h4>
                <ul class="contact">
                    <li>
                        <p><i class="fa fa-map-marker"></i> <strong>Trụ sở chính:</strong> Tầng 8, 51 Lê Đại Hành, Hai Bà Trưng, Hà Nội, Việt Nam</p>
                    </li>
                    <li>
                        <p><i class="fa fa-map-marker"></i> <strong>Chi nhánh HCM:</strong> 70 Lữ Gia, Phường 15, Quận 11, Tp.HCM</p>
                    </li>
                    <li>
                        <p><i class="fa fa-phone"></i><strong>Hỗ trợ Hà Nội:</strong> 1900.2008 - <strong>Hỗ trợ Hồ Chí Minh:</strong> (08) 7300 9579 </p>
                    </li>
                    <li>
                        <p><i class="fa fa-phone"></i><strong>Hotline :</strong> <?php echo $_DATA['svg']; ?></p>
                    </li>
                    <li>
                        <p><i class="fa fa-envelope"></i> <strong>Email:</strong> <a href="#mailto:support@ibnc.vn">contact@bncgroup.com.vn</a>
                        </p>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-xs-12 wow fadeInUp data-wow-duration="1s" data-wow-delay="0.4s"">
         <div class="newsletter">
           <iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2FBNCvietnam%2F%3Ffref%3Dts&tabs=timeline&width=328&height=214&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId" width="100%" height="214" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
            </div>
        </div>
        <script type="text/rocketscript" data-rocketoptimized="true"> (function(d, s, id) { var js, fjs = d.getElementsByTagName(s)[0]; if (d.getElementById(id)) return; js = d.createElement(s); js.id = id; js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=1410629775843049&version=v2.0"; fjs.parentNode.insertBefore(js, fjs); }(document, 'script', 'facebook-jssdk')); </script>
    </div>
</div>
</footer>
<!-- End Footer -->

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.7";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<!-- Scroll fixed top change navabar-->
    <script>
        $(document).ready(function(){
            var header = $('.header_main_inner');
            $(window).scroll(function(){
                 var scroll = $(window).scrollTop();
                if(scroll >= 200){
                    header.addClass('navbar-shrink');
                }
                else{
                    header.removeClass('navbar-shrink');
                }
            });

        });
        $('.send-contact').click(function(){
            var $this = $(this);
           // alert(1);
            var name = $('#name').val();
            var email = $('#email').val();
            var message = $('#text-content').val();
            // var web=$('#web').val();;
            // var sdt =$('#phone').val();
            if(name==false){
                //alert("Vui lòng nhập tên");
                $('#name').focus();
                return false;
            }
            if(email==false){
                //alert("Vui lòng nhập email !");
                $('#email').focus();
                return false;
            }
            var atpos = email.indexOf("@");
            var dotpos = email.lastIndexOf(".");
            if (atpos<1 || dotpos<atpos+2 || dotpos+2>=email.length) {
               // alert("Vui lòng nhập đúng địa chỉ email !");
                return false;
            }
            $('#thongbaotam').show(); 
            $.ajax({
                url: '/themesstore-contact.html',
                type: 'POST',
                dataType: 'json',
                data: {name:name,email:email,message:message,type:1},
                success: function(res){ 
                    $('#thongbaotam').hide();               
                    $('#thongbao').show();            
                }
            });

        });
    </script>
    <!-- Scroll fixed top change navabar-->
<!-- Mobile Menu Boostrap -->
    <script type="text/javascript" src="<?php echo $_B['static'] ?>/themesstore/js/mobile_menu.js"></script>
<!-- End Mobile Menu Boostrap -->
</body>
</html>