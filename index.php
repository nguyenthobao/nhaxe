<?php

 
 
date_default_timezone_set('Asia/Ho_Chi_Minh');
session_start();
    
header('X-XSS-Protection: 0');
set_time_limit(30);
//ini_set('max_execution_time', 60);
if (isset($_COOKIE['chau'])  ) { 
    error_reporting(E_ALL ^ E_DEPRECATED ^ E_WARNING ^ E_NOTICE) ;
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
}

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Max-Age: 1000');

if (isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] == 2) {
    $_GET['mod']       = $_GET['sub'];
    $_GET['sub']       = $_GET['page'];
    $urlRequest        = explode('-', substr($_SERVER['REQUEST_URI'], 1));
    $_GET['customurl'] = $urlRequest[0];
    unset($_GET['page']);
} elseif (isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['sub'] == 9) {
    $_GET['mod']       = $_GET['sub'];
    $_GET['sub']       = $_GET['page'];
    $urlRequest        = explode('-', substr($_SERVER['REQUEST_URI'], 1));
    $_GET['customurl'] = $urlRequest[0];
    unset($_GET['page']);
}

/* Define PATH */
define('BNC_CODE', TRUE);
define('DIR_ROOT', dirname(__FILE__) . DIRECTORY_SEPARATOR);
define('DIR_CONFIG', DIR_ROOT . 'config/');
define('DIR_TMP', DIR_ROOT . 'tmp/');
define('DIR_LOG', DIR_ROOT . 'logs/');
define('DIR_THEME', DIR_ROOT . 'themes/');
define('DIR_CLASS', DIR_ROOT . 'includes/class/');
define('DIR_PAYMENT', DIR_ROOT . 'includes/class/payment/');
define('DIR_ADDRESS', DIR_ROOT . 'includes/class/address.php');
define('DIR_MODULES', DIR_ROOT . 'modules/');
define('DIR_LANG', DIR_ROOT . 'lang/');
define('DIR_LANG_CUSTOM', DIR_TMP . 'lang/');
define('DIR_FUNS', DIR_ROOT . 'includes/functions/');
define('DIR_HELPER', DIR_ROOT . 'includes/helper/');
define('DIR_HELPER_UPLOAD', DIR_HELPER . 'upload.helper/upload.client.php');
define('DIR_NHANH_VN', DIR_ROOT . 'includes/partner/nhanh_vn/');
define('HTTP_STATIC', 'http://cdn.anvui.vn/'); 
define('HTTP_STATIC_RESIZE', 'http://cdn.anvui.vn/view.php?image=');
// define('HTTP_STATIC_RESIZE', 'https://cdn-img-v2.ibnc.vn/');

include DIR_ROOT . 'includes/global.php';

?>