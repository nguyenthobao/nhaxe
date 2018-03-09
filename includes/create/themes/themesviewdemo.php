<!DOCTYPE html>
<html lang="vi">
    <head>
       <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
         <title>BNC Group - Themes Store - View demo <?php echo $_DATA['viewdemo']['title']; ?></title>
         <link rel="shortcut icon" href="http://webbnc.net/img/bnc/favicon.png" type="image/x-icon"/>
        <link href="<?php echo $_B['static'] ?>/themesstore/assets/font-awesome-4.6.3/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="<?php echo $_B['static'] ?>/themesstore/css/bootstrap.min.css">
         <link rel="stylesheet" href="<?php echo $_B['static'] ?>/themesstore/css/style.css?v=21">
        <!--JS-->
        <script src="<?php echo $_B['static'] ?>/assets/jquery/1.12.3/jquery-1.12.3.min.js" type="text/javascript"></script>
        <script src="<?php echo $_B['static'] ?>/themesstore/js/functions.js" type="text/javascript"></script>
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
        <div id="view-demo" class="">
            <div class="demo-header">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <a href="<?php echo $_DATA['link']; ?>" class="view-back">
                            <i class="icon-view-back"></i>
                            Quay về xem chi tiết
                        </a>
                    </div>
                    <div class="col-md-5 hidden-sm hidden-xs text-center view-type">
                        <a class="desktop current" href="javascript:void()">
                            <svg viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                <path d="M14 0H2C.897 0 0 .897 0 2v8c0 1.103.897 2 2 2h4.667v2h-2c-.552 0-1 .447-1 1 0 .553.448 1 1 1h6.667c.552 0 1-.447 1-1 0-.553-.448-1-1-1h-2v-2H14c1.104 0 2-.897 2-2V2c0-1.103-.896-2-2-2zM2 10V2h12v8H2z"></path>
                            </svg>
                            Desktop
                        </a>
                        <a class="mobile" href="javascript:void()">
                            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M18.7 0H6.3C5.6 0 5 .6 5 1.3v21.3c0 .8.6 1.4 1.3 1.4h12.3c.7 0 1.4-.587 1.4-1.287V1.3c0-.7-.6-1.3-1.3-1.3zm-6.2 22.6c-.7 0-1.3-.6-1.3-1.3 0-.7.6-1.3 1.3-1.3.7 0 1.3.6 1.3 1.3 0 .7-.6 1.3-1.3 1.3zm4.5-4c0 .2-.2.4-.4.4H8.4c-.2 0-.4-.2-.4-.4V3.4c0-.2.2-.4.4-.4h8.1c.3 0 .5.2.5.4v15.2z"></path>
                            </svg>
                            Mobile
                        </a>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-4 text-right" style="line-height: 40px;">

                        <?php if(number_format($_DATA['viewdemo']['price'], 0, ',', '.')==0){ ?>
                             <a href="http://v2.webbnc.net/?temp=<?php echo $_DATA['viewdemo']['sub_id']; ?>" class="hidden-xs btn-registration banner-home-registration event-Template-apply-form-open">Sử dụng giao diện này</a>
                        <?php } else {?>
                                  <a href="javascript:" class="hidden-xs btn-registration banner-home-registration event-Template-apply-form-open">Vui lòng liên hệ tới 19002008</a>
                        <?php } ?>

                       
                        <a href="<?php echo $_DATA['viewdemo']['link_demo']; ?>" class="view-normal hidden-sm hidden-xs">X</a>
                    </div>
                </div>
            </div>
            <div id="demo-wrapper" class="desktop-view">
                <div id="demo-container" style="max-width: 100%; max-height: 100%; margin: 0px; top: 0px; left: 0px;">
                    <iframe id="frame" src="<?php echo $_DATA['viewdemo']['link_demo']; ?>"></iframe>
                </div>
            </div>
            <script>
                $(function () {
                    $(".view-type a.desktop").click(function () {
                        $(".view-type a").removeClass("current");
                        $(this).addClass("current");
                        $("#demo-container").attr('style', 'max-width: 100%; max-height: 100%; margin: 0px; top: 0px; left: 0px;');
                    });

                    $(".view-type a.mobile").click(function () {
                        $(".view-type a").removeClass("current");
                        $(this).addClass("current");
                        $("#demo-container").attr('style', 'max-width: 420px; max-height: 568px; margin: -311px 0px 0px -160px; top: 50%; left: 50%;');
                    });
                });
            </script>
            <style type="text/css">
                body, html {
                    height: 100%;
                }
                body {
                    padding: 0 0;
                    margin: 0 0;
                    font-family: "Roboto",Helvetica Neue,Helvetica,Arial,sans-serif;
                    font-size: 1.3em;
                    height: 100%;
                    overflow: hidden;
                }

            </style>
        </div>
    </body>
</html>