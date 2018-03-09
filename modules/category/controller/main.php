<?php

$_S['title_header'] = lang('title_header');
$_S['title_module'] = lang('title_module');
$_S['title_module_m'] = lang('title_module_m');
$_S['title_manager_mod'] = lang('title_manager_mod');
$_S['breadcrumb_mod'] = lang('breadcrumb_mod');
$pages = array('category','categorylist','ajax');
$page = $_B['r']->get_string('page','GET');
if (!in_array($page, $pages)) {
	$page = 'home';
} 
include_once(DIR_MODULES.$mod."/model/global_category.php");//Load model dùng chung (nếu function nào dùng dung thì viết vào model này)
if (file_exists(DIR_MODULES.$mod."/model/".$page.".php")) {
	include_once(DIR_MODULES.$mod."/model/".$page.".php");
}  
include_once(DIR_MODULES.$mod."/controller/".$page.".php");

// xoa session thong bao thao tac
//unset($_SESSION['success']);
//unset($_SESSION['error_submit']);