<?php 
$action = $_B['r']->get_string('action','POST');
$actions = array('registerSsl');
if(!in_array($action, $actions)){
	$action='index';
}

if($action=='index'){
	$_B['static']=str_replace('https','http',$_B['static']);
	$_B['static']=str_replace('http','https',$_B['static']);
	
	include DIR_ROOT . 'includes/create/themes/ssl.php';
	die();
}else{
	$w = new CreateWeb();
	$return = $w->$action();
	header('Content-Type: application/json');
	$json = json_encode($return);
	exit($json);
}
