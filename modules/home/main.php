<?php
/**
 * @Project BNC v2 -> Module Home
 * @File home/main.php
 * @Author Quang Chau Tran (nquangchauvn@gmail.com)
 * @Createdate 10/29/2014, 09:23 AM
 */
if (!defined('BNC_CODE')) {
	exit('Access Denied');
}

// thong tin yeu cau tu client
$page = $_B['r']->get_string('page', 'GET');
$sub  = $_B['r']->get_string('sub', 'GET');
$lang = $_B['lang'];

//xu ly yeu cau
$pages = array('signupfooter', 'home', 'captcha', 'qrcodebnc', 'thememanager');
if (!in_array($page, $pages)) {
	$page         = 'home';
	$data['page'] = $page;
}
if (empty($sub)) {
	$sub = "index";
}


include_once DIR_MODULES . 'product/lang/' . $_B['lang'] . '/main.php';
include_once DIR_MODULES . 'news/lang/' . $_B['lang'] . '/main.php';

//kiem tra controler tra loi yeu cau ton tai hay ko
if (file_exists(DIR_MODULES . $mod . "/controller/" . $page . ".php")) {
	include_once DIR_MODULES . $mod . "/controller/" . $page . ".php";
} else {
	trigger_error('No exits controller in module Home');
}

//khoi tao controler
$controller = new $page($sub);

// thuc hien yeu cau va tra du lieu ve cho core để trả về client
if (method_exists($controller, $sub)) {

	$controller->$sub();

} else {
	trigger_error('No method ' . $sub . ' in module Home');
}
?>
