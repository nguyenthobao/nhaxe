<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /create/index.php
 * @author Chau Tran Quang (chautq@webbnc.vn)
 * @Createdate 12/12/2014, 00:34 AM
 */
//error_reporting(E_ALL);
//error_reporting(E_ALL & ~E_NOTICE);
error_reporting(7);
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);

//Kiểm tra ssl
if (isset($_SERVER['HTTPS'])) {
	$protocol = 'https://';
} else {
	$protocol = 'http://';
}

 

$_B['home'] = 'web.anvui.vn';
$_B['static'] = $protocol . 'web.anvui.vn/themes/web/'; 
$_B['static_origin'] = $protocol . $_SERVER['HTTP_HOST'] . '/includes/create/themes/';
$_B['create_home'] = $protocol . $_SERVER['HTTP_HOST'] . '/';
$_B['create_admin'] = 'http://adminweb.anvui.vn/';

include DIR_ROOT . 'includes/create/model/create_web.php';
$mods = array('index', 'ajax', 'ssl', 'ungdung', 'themesstore');

$mod = $_B['r']->get_string('mod', 'GET');

if (!in_array($mod, $mods)) {
	$mod = 'index';
}
if (isset($_GET['temp'])) {
	$_SESSION['theme_id'] = $_GET['temp'];
}

include DIR_ROOT . 'includes/create/controller/' . $mod . '.php';