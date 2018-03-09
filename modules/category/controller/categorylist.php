<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /controller/home.php 
 * @Author Hồ Mạnh Hùng (hungdct1083@gmail.com)
 * @Createdate 08/21/2014, 14:27 PM
 */  
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}

// thong tin danh cho title va breadcrumb
$_S['breadcrumb_page'] = lang('breadcrumb_manager_categolist');

$_S['title'] = lang('title_manager_category');
$_S['description'] = lang('description');

$get_lang = $_B['r']->get_string('lang','GET');
$addcategory = $_B['home'].'/'.$mod.'-category-lang-'.$get_lang;

//goi Model Videolist
$categoList = new CategoryList();

$lang_use = explode(',',$_B['cf']['lang_use']);
//Get ngôn ngữ đã config trong db để set làm menu lang
foreach ($lang_use as $k => $v) {
			if ($v=='vi') {
				$url_lang[$v]['url'] = $_B['home'].'/'.$mod.'-categorylist-lang-vi';
				//su dung de check khi add noi dung voi ngon ngu khac.
			}else{
				//In url trang doi voi truong hop them noi dung.
				$url_lang[$v]['url'] = $_B['home'].'/'.$mod.'-categorylist-'.'lang'.'-'.$v;
				//$url_lang[$v]['exist']='notExist';
			}
		}

$cat = array();

$action = $_B['r']->get_string('action','POST');


if (!empty($action)){
 //xu ly rieng cho phan tim kiem;
 	if($action =="searchCategory"){
 	$name = $_B['r']->get_string('cat_title', 'POST');
 	$status_cat = $_B['r']->get_string('status_cat', 'POST');
 	$post = array(
	    'cat_title'     => $name,
	    'action'     	=>$action,
	    'status_cat'    =>$status_cat,
	   );
  	$value = json_encode($post);
  	$value = base64_encode($value);
  	header("Location:".$_B['home']."/".$mod.'-categorylist-lang-'.$get_lang.'-value-'.$value);
  	
 	}
 	else // cac action con lai
 	{
  		$result = $categoList->$action();
  		if ($result['status']) {
			$_SESSION['success'] = lang('success');
			header("Location:".$_B['home']."/".$mod.'-categorylist-lang-'.$get_lang);
			exit();
		}else{
			$_SESSION['error_submit'] =  $result['notify_error'];
		}
 	}  

}
else
{
	if(!empty($_GET['value'])){
		$value = $_B['r']->get_string('value','GET');
		$value = base64_decode($value);
		$value = json_decode($value,1);
	}
	else
	{
		$value = null;
	}
	
} 
if ($ad->tableExits($get_lang.'_category')) {
	$cat = $categoList->getCatCategory($value);
} 
$content_module = $_B['temp']->load('categorylist');
