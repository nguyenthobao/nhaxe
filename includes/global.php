<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /includes/global.php
 * @Author Quang Chau Tran (quangchauvn@gmail.com)
 * @Createdate 10/21/2014, 10:23 PM
 */
if (!defined('BNC_CODE')) {
    exit('Access Denied');
}

function curPageURL2() {
    $pageURL = 'http';
    if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
    } else {
        $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    }

    return $pageURL;
}
include_once DIR_CLASS . 'cache.php';
include_once DIR_ROOT . 'config/config.php';
include_once DIR_CLASS . 'Mobile_Detect.php';
include_once DIR_CLASS . 'api.php';
include_once DIR_CLASS . 'model_core.php';
include_once DIR_CLASS . 'model.php';
//Khi extend lớp controller nếu tồn tại cache đó rồi thì xử lý luôn cho nó
$_B['info_cache']['domain']          = str_replace('www.', '', $_SERVER['HTTP_HOST']);
$_B['info_cache']['current_url']     = curPageURL2();
$_B['info_cache']['md5_current_url'] = md5($_B['info_cache']['current_url']);
$_B['info_cache']['mod']             = ($_GET['mod'] ? $_GET['mod'] : 'home');
$_B['info_cache']['page']            = $_GET['page'];
$_B['info_cache']['sub']             = $_GET['sub'];
 

include_once DIR_CLASS . 'controller.php';
// include_once DIR_HELPER . 'cache/Cache.php';
include_once DIR_CLASS . 'db/mysqliDB3.php'; //mysqliDB2.php
include_once DIR_CLASS . 'web.php';
include_once DIR_CLASS . 'template.php';
include_once DIR_FUNS . 'global.php';

 

//default time zone

//for dev
$time0       = (float) microtime_float();
$_B['cache'] = new CacheBNC();
//db connect
db_connect();

//session_start();
if (version_compare(PHP_VERSION, '5.4.0', '>=')) {
    ob_start(null, 0, PHP_OUTPUT_HANDLER_STDFLAGS ^
        PHP_OUTPUT_HANDLER_REMOVABLE);
} else {
    ob_start(null, 0, false);
}

include DIR_CLASS . "request.php";
 

$s_name          = $_B['r']->get_string('w', 'GET');

 
$_B['curDomain'] = curDomain();

$_B['curUrl'] = curPageURL();


if (
    $_B['curDomain'] != $_B['home'] 
) {
    $_B['dmr'] = true;
    $curDomain = str_replace('www.', '', $_B['curDomain']);
    $s_name    = getWebNameByDomain($curDomain);
    
} else {
    $_B['dmr'] = false;
}
 

if ($s_name == '') {
    include DIR_ROOT . 'includes/create/index.php';
    die;
}
 

// lay thong tin web
$webObj = new Web($s_name);

if (!isset($webObj->info)) {
    header("Location: http://" . $_B['home']);
}

//Set tên rút gọn vào quản trị
if ($_GET['setweb'] == 1) { 
    header("Location:http://adminweb.anvui.vn/index.php?set_web=" . $s_name);
    exit();
}

// $_WLock['enddate'] = $webObj->info['end_date'];
// if ($_WLock['enddate'] < time() && $_WLock['enddate'] > 0) {
//     $_WLock['domain'] = $webObj->info['domain'];
//     include_once DIR_ROOT . 'includes/lockweb/index.php';die();
// }

$config = $webObj->config;
// if (isset($_B['uid'])) {
//     $_SESSION['I3NBNCU'] = $_B['uid'];
// }


$_B['customurl'] = $_B['r']->get_string('customurl', 'GET');
//Customize url mod
if (isset($webObj->cfAdmin['seo_url_mod'])) {
    $seo_mod = json_decode($webObj->cfAdmin['seo_url_mod'], 1);
    if (in_array($_GET['mod'], $seo_mod)) {
        $_GET['mod'] = array_search($_GET['mod'], $seo_mod);
    }
}

if (!empty($_B['customurl'])) {
    seoRewrite();
} else {
    rewrite();
}
$webObj->getAccessLink($_B['curUrl']['fullLink']);


$_B['ip'] = getIp();

$mod = $_B['r']->get_string('mod', 'GET');

$mods = array(
    'home',
    'datve',
    'user',
    'product',
    'news',
    'album',
    'video',
    'info',
    'contact',
    'feedback',
    'document',
    'category',
    'maps',
    'recruit',
    'qaa',
    'payment',
    'support',
    'language',
    'template',
    'subscribe',
    'deal',
    'lists',
    'tag',
    'apiproduct',
);
$idw = $webObj->idw;
 
if ($mod != '' && !in_array($mod, $mods)) {
    header("HTTP/1.0 404 Not Found");
    
        $content404 = '<!DOCTYPE html PUBLIC "-//IETF//DTD HTML 2.0//EN">
        <html><head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
        <title>404 Not Found</title>
        </head><body>
        <h1>Not Found</h1>
        <p>The requested URL ' . $_SERVER['REQUEST_URI'] . ' was not found on this server 1.</p>
        <p>Additionally, a 404 Not Found
        error was encountered while trying to use an ErrorDocument to handle the request.</p>
        </body></html>';
     
    echo $content404;
    exit();
} elseif ($mod == '') {
    $mod = 'home';
}


//Xử lý robots.txt
$robots = $_B['r']->get_string('robots', 'GET');
if (!empty($robots) && $robots == 1) {
    $bot = $webObj->getGa();
    if (empty($bot['robots'])) {
        $bot['robots'] = 'User-agent: *';
        $bot['robots'] .= 'Disallow: /cgi-bin/';
        $bot['robots'] .= 'Disallow: /admin/';
        $bot['robots'] .= 'Sitemap:';
    }
    header("Content-Type:text/plain");
    echo $bot['robots'];
    exit();

}

$_B['lang_default'] = $config['lang'];
$_B['lang']         = $config['lang'];
$_B['language']     = $webObj->getLanguage($config['lang_use']);




if (isset($_SESSION['lang_' . $idw])) {
    $_B['lang'] = $_SESSION['lang_' . $idw];
} elseif (isset($_COOKIE['language_cookie_' . $idw])) {
    $_B['lang'] = $_COOKIE['language_cookie_' . $idw];
}
// else {
//     $_B['lang'] = $_B['lang_default'];
//     $_B['lang'] = $_B['lang_default'];
// }

if (isset($_GET['title'])) {
    $searchBasic = $_GET['title'];
}
if (isset($_GET['q'])) {
    $searchBasic = $_GET['q'];
}

 

$webObj->get_info_temp();
$web = $webObj->info;

// var_dump($web); die;
$_B['webinfo'] = $web;

$web['configAdmin'] = $config;
unset($web['configAdmin']['payment_setting_baokim']);
unset($web['configAdmin']['banks']);
$web['query_string'] = $_GET;

require_once DIR_FUNS . 'global_after.php';
//Đóng site;
$closeweb = json_decode($web['closeweb'], 1);
if (isset($closeweb['status']) && $closeweb['status'] == 0) {
    $web['temp'] = $web['theme_id'] = 1;
    $_B['temp']  = new Template();
    include $_B['temp']->load('closeweb/style' . $closeweb['style']);
    die();
}
$sitemap = $_B['r']->get_string('seo', 'GET');

if (!empty($sitemap) && $sitemap == 'sitemap') {
    $sitemap = $_B['r']->get_string('sitemap', 'GET');
    if (isset($_GET['filename'])) {
        $sitemap_file = $_B['r']->get_string('filename', 'GET');
    } else {
        $sitemap_file = null;
    }
    $webObj->genSitemap($sitemap, $sitemap_file);
    exit();
}

$settemp = $_B['r']->get_int('settemp', 'GET');
if (!empty($settemp)) {
    set_temp_web($web['idw'], $settemp);
    die();
}
// if ($_B['uid']==29 || $_B['uid']==28) {
//     $web['temp'] = 2;
// }
// $_B['curUrl'] = curPageURL();

if ($web == false) {
    die('Web khong ton tai');
}
$menu = $web['menu'];

//phan luong module

$_B['url_mod'] = $web['home_url'] . '/' . $mod . $web['dotExtension'];
$_B['captcha'] = $web['home_url'].'/home-captcha.html';
$_B['qrcode']  = $web['home_url'].'/home-qrcodebnc.html';
include_once DIR_LANG . $_B['lang'] . '/main.php';
if (isset($_B['lang'])) {
    //kiem tra custom lang
    $langCustomPath = DIR_LANG_CUSTOM . $web['idw'] . '/' . $_B['lang'] . '/' . $mod . '/main.php';

    if (isset($config['langCus']) && $config['langCus'] == 1 && file_exists($langCustomPath)) {
        include_once $langCustomPath;
    } else {
        include_once DIR_MODULES . $mod . '/lang/' . $_B['lang'] . '/main.php';
    }

} else {
    $langCustomPath = DIR_LANG_CUSTOM . $web['idw'] . '/' . $_B['lang'] . '/' . $mod . '/main.php';
    if (isset($config['langCus']) && $config['langCus'] == 1 && file_exists($langCustomPath)) {
        include_once $langCustomPath;
    } else {
        include_once DIR_MODULES . $mod . '/lang/' . $_B['lang_default'] . '/main.php';
    }

}
$flag_cache = false;
$info_cache = $_B['info_cache'];
$cache_key  = md5($info_cache['md5_current_url'] . $_B['lang']);
$cache_tag  = $info_cache['mod'];
if ($_B['cache_on'] == true) {
    $flag_cache = true;
    //Set tags cache
    $data = $_B['cache']->get_tags($cache_tag, $cache_key);
    if (empty($data)) {
        $flag_cache = false;
    }
}

if (!$flag_cache) {
    db_connect($mod);
    include_once DIR_MODULES . "{$mod}/main.php";
    $data = $controller->getData();
    if (!$data['ajax'] && (empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest')) {
        $_B['cache']->set($cache_key, $data);
        $_B['cache']->set_tags($cache_tag, $cache_key);
    }
}

/**
 * Chia layout theo cài đặt trong bảng web_layous
 */
if ($mod != 'home') {
    if ($web['query_string']['mod'] == 'product' && isset($web['query_string']['id'])) {
        $Route_id     = $web['query_string']['id'];
        $Route_id_arr = explode('_', $Route_id);
        if (count($Route_id_arr) == 2) {
            $Route_id = $Route_id_arr[1];
        }
        //Neu khong co category dung dau
        $objRoute = new Model('vi_product_basic', db_connect('product'));
        $objRoute->where('id', $Route_id);
        $dataRoute      = $objRoute->getOne(null, 'category');
        $Route_category = array_filter(array_values(array_unique(explode('|', $dataRoute['category']))));
    } elseif ($web['query_string']['mod'] == 'news' && isset($web['query_string']['id'])) {
        $Route_id     = $web['query_string']['id'];
        $Route_id_arr = explode('_', $Route_id);
        if (count($Route_id_arr) == 2) {
            $Route_id = $Route_id_arr[1];
        }

        $objRoute = new Model('news.vi_news');
        $objRoute->where('id', $Route_id);
        $dataRoute      = $objRoute->getOne(null, 'cat_id');
        $Route_category = array_filter(array_values(array_unique(explode(',', $dataRoute['cat_id']))));

    }

    $route = array();
    if (isset($web['query_string']['mod'])) {
        $route[] = $web['query_string']['mod'];
    }
    if (isset($web['query_string']['page'])) {
        $route[] = $web['query_string']['page'];
    }
    if (isset($web['query_string']['sub'])) {
        $route[] = $web['query_string']['sub'];
    }
    if (isset($web['query_string']['id'])) {
        $route[] = $web['query_string']['id'];
    }
    $router      = implode('-', $route);
    $layout_name = $webObj->loadLayouts($router, $Route_category);
    if (!empty($layout_name)) {
        $web['layout'] = $layout_name;
    } else {
        $web['layout'] = 'left_body';
    }
}

unset($_BC);
//xuat data
$_B['temp'] = new Template();
//dong ket noi DB chinh va mo ket noi DB theo tung module
$web['static_temp_mod']         = $webObj->get_static_theme_mod();
$web['static_temp_mod_product'] = $webObj->get_static_theme_mod('product');

//No CDN
$web['static_temp_mod_product_no_cdn'] = $web['static_temp_mod_product'];
$web['static_temp_mod_no_cdn']         = $web['static_temp_mod'];
//
$parse_static_temp_mod          = parse_url($web['static_temp_mod']);
$parse_static_temp_mod_product  = parse_url($web['static_temp_mod_product']);
$web['static_temp_mod']         = str_replace($parse_static_temp_mod['host'], 'cdn-gd-v2.webbnc.net', $web['static_temp_mod']);
$web['static_temp_mod_product'] = str_replace($parse_static_temp_mod_product['host'], 'cdn-gd-v2.webbnc.net', $web['static_temp_mod_product']);
//Loai bo bien nay se tro lai link cua website
$web['static_temp_no_cdn'] = $web['static_temp'];
$parse_static_temp         = parse_url($web['static_temp']);
$web['static_temp']        = str_replace($parse_static_temp['host'], 'cdn-gd-v2.webbnc.net', $web['static_temp']);

//FIX
// $web['static_temp_mod_product_no_cdn'] = $web['static_temp_mod_product'];
// $web['static_temp_mod_no_cdn']         = $web['static_temp_mod'];
// $web['static_temp_no_cdn']             = $web['static_temp'];

if ($_B['cloudflare'] == false || $web['idw'] == 605 || $web['idw'] == 1237 || $web['idw'] == 2202 || $web['idw'] == 3996 || $web['idw'] == 3438) {
    $web['static_temp_mod_product'] = $web['static_temp_mod_product_no_cdn'];
    $web['static_temp_mod']         = $web['static_temp_mod_no_cdn'];
    $web['static_temp']             = $web['static_temp_no_cdn'];

}

if ($web['ssl']) {
    $web['static_temp_no_cdn']             = str_replace('http://', 'https://', $web['static_temp_no_cdn']);
    $web['static_temp']                    = $web['static_temp_no_cdn'];
    $web['home_url']                       = str_replace('http://', 'https://', $web['home_url']);
    $web['static_temp']                    = str_replace('http://', 'https://', $web['static_temp']);
    $web['static_temp_mod']                = str_replace('http://', 'https://', $web['static_temp_mod']);
    $web['static_temp_mod_product']        = str_replace('http://', 'https://', $web['static_temp_mod_product']);
    $web['static_temp_mod_product_no_cdn'] = str_replace('http://', 'https://', $web['static_temp_mod_product_no_cdn']);
    $web['static_temp_mod_no_cdn']         = str_replace('http://', 'https://', $web['static_temp_mod_no_cdn']);
    $web['static_upload']                  = 'http://cdn.anvui.vn/';
}

 

if ($data['ajax'] == true) {
    if ($data['load_temp'] != null) {
        //$mod_in_home = (isset($data['mod_in_home']))?$data['mod_in_home']:null;
        include_once $_B['temp']->loadajax($data['load_temp']);
    }

} else {
    if (empty($data['load_temp'])) {
        trigger_error('No template to load');
        exit;
    }
    if ($s_name == 'khodienmay' && $mod == 'home' && !isset($_GET['mod'])) {
        include_once $_B['temp']->load('intro');
    } else {
        if (isset($_COOKIE['admin'])) {
            // var_dump($web['layout'].'_ádasd1123456'); die;

        }
        include_once $_B['temp']->load('layout');
    }
}

if ($data['ajax'] == false && isset($_COOKIE['sv'])) {
    // for dev
    $time1 = microtime_float();
    $time  = $time1 - $time0;
    echo '<div style="position: fixed; bottom: 0; right: 250px; z-index: 10000; font-size: 12px; background: red; color: #fff; padding: 2px;">';
    echo 'Time: ' . number_format($time, 5) . " - ";
    echo 'Memory: ' . convert(memory_get_usage());
    echo '</div>';
}
?>