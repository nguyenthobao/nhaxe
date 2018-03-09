<?php
/*
 * @Project BNC V2
 * @Author Lư Chí Tâm (tamlc@webbnc.vn)
 * Frontend Maps Module
 */
if (!defined('BNC_CODE')) {
    exit('Access Denied');
}

$page = $_B['r'] -> get_string('page', 'GET');
$sub = $_B['r'] -> get_string('sub', 'GET');
$lang = $_B['lang'];

$pages = array('home');
if (!in_array($page, $pages) || empty($page)) {
    $page = 'home';
}

if (empty($sub)) {
    $sub = "index";
}

if (file_exists(DIR_MODULES . $mod . "/controller/" . $page . ".php")) {
    include_once (DIR_MODULES . $mod . "/controller/" . $page . ".php");
} else {
    header("location: " . $_B['home'] . "/" . $web['s_name'] . "/" . $mod . "-" . $page . $_['dotExtension']);
    exit();
}

$controller = new $page($sub);

if (method_exists($controller, $sub)) {
    $controller -> $sub();

} else {
    header("location: " . $_B['home'] . "/" . $web['s_name'] . "/" . $mod . "-" . $page . $_['dotExtension']);
    exit();
}
?>