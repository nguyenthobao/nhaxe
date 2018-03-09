<?php
/**
 * @Project BNC v2 -> Module News
 * @File news/main.php
 * @Author Ba Huong Nguyen (nguyenbahuong156@gmail.com)
 * @Createdate 10/27/2014, 11:07 AM
 */
if(!defined('BNC_CODE')) {
    exit('Access Denied');
} 
$page = $_B['r']->get_string('page','GET');
$sub  = $_B['r']->get_string('sub','GET');
$lang = $_B['lang'];


$pages = array('category','detail','ajax');
if (!in_array($page, $pages)||empty($page)) {
	$page = 'category';
}

if(empty($sub)) {
	$sub = "cat";
}

if(file_exists(DIR_MODULES.$mod."/controller/".$page.".php")){
	include_once(DIR_MODULES.$mod."/controller/".$page.".php");
}else{
	header("location:".$_B['home']."/".$web['s_name']."/".$mod."-".$page.$_['dotExtension']);
	exit();
}

$controller = new $page($sub);


if(method_exists($controller, $sub)){
	$controller->$sub();
	    	
}else{
	header("location:".$_B['home']."/".$web['s_name']."/".$mod."-".$page.$_['dotExtension']);
	exit();
}


?>
