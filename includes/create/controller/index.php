<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /create/controller/index.php
 * @author Chau Tran Quang (chautq@webbnc.vn)
 * @Createdate 16/12/2014, 10:10 AM
 */

$mod = $_B['r']->get_string('mod', 'GET');
$step = $_B['r']->get_int('step', 'GET');
$steps = array(1, 2, 3);

if (!in_array($step, $steps)) {
	$step = 1;
}
$idw = (isset($_SESSION['idw'])) ? (int) $_SESSION['idw'] : false;
if ($step != 1 && !$idw && empty($mod)) {
	header("Location: " . $_B['create_home'] . "?step=1");
}

if (!empty($mod)) {
	$db  = db_connect_mod('notify');
	$u = new Model('themes');
	$u->where('status', 1);
	$u->orderBy('create_time', 'DESC');
	$data['themes'] = $u->get();
	//var_dump($data);
	//Category
	$c = new Model('themes_category');
	//$c->where('status', 1);
	//$c->orderBy('order', 'ASC');
	$data['category'] = $c->get();

	if ($mod == 'api_temp') {
		exit(json_encode($data['themes']));
	} else {
		include DIR_ROOT . 'includes/create/themes/' . $mod . '.php';
	}
} else {
	$w = new CreateWeb();
	$action = 'step' . $step;
	$data = $w->$action();

	$db  = db_connect_mod('notify');
	$u = new Model('themes');
	$u->where('status', 1);
	$u->orderBy('create_time', 'DESC');
	$data['themes'] = $u->get();
	
	if (isset($_GET['iframe']) && $_GET['iframe'] == 'webbnc') {
		include DIR_ROOT . 'includes/create/themes/iframe_step' . $step . '.php';
	} else {
		include DIR_ROOT . 'includes/create/themes/step' . $step . '.php';
	}
}
