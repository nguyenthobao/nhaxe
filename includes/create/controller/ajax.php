<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /create/controller/ajax.php 
 * @author Chau Tran Quang (chautq@webbnc.vn)
 * @Createdate 16/12/2014, 10:18 AM
 */
// error_reporting(E_ALL);
//     // error_reporting(E_ALL & ~E_NOTICE);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
// $action = $_B['r']->get_string('action','POST');
$action = $_B['r']->get_string('action');
$actions = array('copyall','registeranvui','login','copyweb','createweb','checktenrg','checkemail','chooseTheme','chooseThemeFirst','copywebmaster');
if(!in_array($action, $actions)){
	$action = 'createweb';
}

$w = new CreateWeb();
$return = $w->$action();
// $return = array(
// 	'status' => true,
// 	'message' => 'ok'
// );
header('Content-Type: application/json');
$json = json_encode($return);
exit($json);