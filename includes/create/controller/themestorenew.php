<?php

echo '<pre>';
print_r("TRUONG NGUYEN");
echo '</pre>';
die();

$action  = $_B['r']->get_string('action', 'GET');
$actions = array('detail', 'contact', 'search');
if (!in_array($action, $actions)) {
    $action = 'index';
}
if ($action == 'index') {
    $search = $_B['r']->get_string('name', 'GET');
    include DIR_ROOT . 'includes/create/model/app.php';
    $obj = new App();

    //echo $search;
    if (!empty($search)) {
        $_DATA['category'] = $obj->category_search($search);
        $app_item          = $obj->app_cat_search($search);
        $_DATA['search']   = $search;
    } else {
        $_DATA['category'] = $obj->category();
        $app_item          = $obj->app_cat();
    }
    foreach ($app_item as &$v) {
        $v['link'] = 'http://app.webbnc.net/app-' . fixTitle($v['title']) . '-' . $v['id'] . '.html';
        unset($v);
    }
    $app_items = array();
    foreach ($_DATA['category'] as $k => $v) {
        foreach ($app_item as $k_app => $v_app) {
            $tmp_cat = array_filter(array_values(explode(',', $v_app['cat_id'])));
            if (in_array($v['id'], $tmp_cat)) {
                $app_items[$v['id']][]          = $v_app;
                $app_item[$k_app]['category'][] = $v['title'];
            }
        }
    }
    $_DATA['app_item']     = $app_item;
    $_DATA['app_item_cat'] = $app_items;
    $_B['static']          = str_replace('https', 'http', $_B['static']);
    $_B['static']          = str_replace('http', 'https', $_B['static']);
    $_B['static']          = str_replace('ibnc.vn', 'webbnc.net', $_B['static']);
    $_B['static']          = 'http://app.webbnc.net/includes/create/themes';
    include DIR_ROOT . 'includes/create/themes/app.php';
    die();

} elseif ($action == 'contact') {
    include DIR_ROOT . 'includes/create/model/app.php';
    $obj = new App();

    $fullname = $_B['r']->get_string('name', 'POST');
    $email    = $_B['r']->get_string('email', 'POST');
    $phone    = $_B['r']->get_string('sdt', 'POST');
    $website  = $_B['r']->get_string('web', 'POST');
    $content  = $_B['r']->get_string('message', 'POST');
    $type     = $_B['r']->get_int('type', 'POST');
    $app_name = $_B['r']->get_string('app_name', 'POST');
    if (($fullname == false || $email == false || $phone == false || $website == false) && $type == 1) {
        $res = array(
            'status' => false,
        );
    } else {
        $dt  = $obj->addContact($fullname, $email, $phone, $website, $type, $app_name, $content);
        $res = array(
            'status' => $dt,
        );
    }
    echo json_encode($res);
    die();

} else {
    $pageURL = 'http';
    if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
    } else {
        $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    }
    $_B['static']      = str_replace('https', 'http', $_B['static']);
    $_B['static']      = str_replace('http', 'https', $_B['static']);
    $_B['static']      = str_replace('ibnc.vn', 'webbnc.net', $_B['static']);
    $_B['static']      = 'http://app.webbnc.net/includes/create/themes';
    $_B['current_url'] = $pageURL;
    include DIR_ROOT . 'includes/create/model/app.php';
    $obj = new App();

    // include DIR_ROOT . 'includes/create/themes/detail.php';
    $id = $_B['r']->get_int('id', 'GET');

    $app_item = $obj->app_other($id);
    foreach ($app_item as &$v) {
        $v['link'] = 'http://app.webbnc.net/app-' . fixTitle($v['title']) . '-' . $v['id'] . '.html';
        unset($v);
    }
    $_DATA['app_other'] = $app_item;
    $_DATA['detail']    = $obj->app_detail($id);
    include DIR_ROOT . 'includes/create/themes/app_detail.php';
    die();

}
