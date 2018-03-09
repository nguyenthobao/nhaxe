<?php

// echo '<pre>';
// print_r("TRUONG NGUYEN");
// echo '</pre>';
// die();

$action  = $_B['r']->get_string('action', 'GET');
$actions = array('detail', 'contact', 'search','mienphi','tinhphi','category','viewdemo','tatca');
if (!in_array($action, $actions)) {
    $action = 'index';
}
$svg  = $_B['r']->get_string('svg', 'GET');
if ($svg) {
        $link_svg='?svg='.$svg;
}else{
        $svg = '1900 2008';
        $link_svg ='';
}
if ($action == 'index') {
    //$search = $_B['r']->get_string('name', 'GET');
    include DIR_ROOT . 'includes/create/model/themesstore.php';
    $obj = new Themes();
    $dk=0;
    $themes_new         = $obj->themes_new($dk);
    foreach ($themes_new as &$v) {
        $v['link'] = 'http://themes.webbnc.net/themesview-' . fixTitle($v['title']) . '-' . $v['id'] . '.html'.$link_svg;
        unset($v);
    }
    $themes_star         = $obj->themes_star($dk);
    foreach ($themes_star as &$v) {
        $v['link'] = 'http://themes.webbnc.net/themesview-' . fixTitle($v['title']) . '-' . $v['id'] . '.html'.$link_svg;
        unset($v);
    }
    $category = $obj->category();
    foreach ($category as &$value) {
        $value['link'] = 'http://themes.webbnc.net/themesstore-' . fixTitle($value['title']) . '-' . $value['id'] . '.html'.$link_svg;
        unset($value);
    }
    $_DATA['category']= $category;
    //$_DATA['active']=1;
    $_DATA['themes_new'] = $themes_new;
    $_DATA['themes_star'] = $themes_star;
    $_DATA['svg'] = $svg;
    $_DATA['link_svg'] = $link_svg;
    // var_dump($themes_new);
    $_B['static']          = str_replace('https', 'http', $_B['static']);
    $_B['static']          = str_replace('http', 'https', $_B['static']);
    $_B['static']          = str_replace('ibnc.vn', 'webbnc.net', $_B['static']);
    $_B['static']          = 'http://themes.webbnc.net/includes/create/themes';
    include DIR_ROOT . 'includes/create/themes/themesstore.php';
    die();

} elseif ($action == 'contact') {
    include DIR_ROOT . 'includes/create/model/themesstore.php';
    $obj = new Themes();

    $fullname = $_B['r']->get_string('name', 'POST');
    $email    = $_B['r']->get_string('email', 'POST');
    // $phone    = $_B['r']->get_string('sdt', 'POST');
    // $website  = $_B['r']->get_string('web', 'POST');
    $content  = $_B['r']->get_string('message', 'POST');
    $type     = $_B['r']->get_int('type', 'POST');
   // $app_name = $_B['r']->get_string('app_name', 'POST');
    if (($fullname == false || $email == false) && $type == 1) {
        $res = array(
            'status' => false,
        );
    } else {
        $dt  = $obj->addContact($fullname, $email, $type, $content);
        $res = array(
            'status' => $dt,
        );
    }
    echo json_encode($res);
    die();

} elseif($action=='category'){
    include DIR_ROOT . 'includes/create/model/themesstore.php';
    $obj = new Themes();
    $id  = $_B['r']->get_string('id', 'GET');
    
    $category = $obj->category();
    foreach ($category as &$value) {
        $value['link'] = 'http://themes.webbnc.net/themesstore-' . fixTitle($value['title']) . '-' . $value['id'] . '.html'.$link_svg;
        unset($value);
    }
    $_DATA['category']= $category;
    // get thong tin danh muc
    $_DATA['category_info'] = $obj->getCategory($id);
    // xuat themes theo danh muc
    $themesCategory   = $obj->themesCategory($id);
    foreach ($themesCategory as &$v) {
        $v['link'] = 'http://themes.webbnc.net/themesview-' . fixTitle($v['title']) . '-' . $v['id'] . '.html'.$link_svg;
        unset($v);
    }
    $_DATA['svg'] = $svg;
    $_DATA['link_svg'] = $link_svg;
    $_DATA['themes'] = $themesCategory;
    $_B['static']          = str_replace('https', 'http', $_B['static']);
    $_B['static']          = str_replace('http', 'https', $_B['static']);
    $_B['static']          = str_replace('ibnc.vn', 'webbnc.net', $_B['static']);
    $_B['static']          = 'http://themes.webbnc.net/includes/create/themes';
    include DIR_ROOT . 'includes/create/themes/themescategory.php';
    die();
}elseif($action=='mienphi'||$action=='tinhphi'){
    include DIR_ROOT . 'includes/create/model/themesstore.php';
    $obj = new Themes();
    if ($action=='tinhphi') {
        $dk=2;
        $_DATA['active']=3;
        $_DATA['search'] = "Tính phí";

    }else{
        $dk=1;
        $_DATA['active']=2;
        $_DATA['search'] = "Miễn phí";
    } 
    $themes_new         = $obj->themes_new($dk);
    foreach ($themes_new as &$v) {
        $v['link'] = 'http://themes.webbnc.net/themesview-' . fixTitle($v['title']) . '-' . $v['id'] . '.html'.$link_svg;
        unset($v);
    }
    $category = $obj->category();
    foreach ($category as &$value) {
        $value['link'] = 'http://themes.webbnc.net/themesstore-' . fixTitle($value['title']) . '-' . $value['id'] . '.html'.$link_svg;
        unset($value);
    }
    $_DATA['category']= $category;
    $_DATA['themes_new'] = $themes_new;
    $_DATA['svg'] = $svg;
    $_DATA['link_svg'] = $link_svg;
    //$_DATA['themes_star'] = $themes_star;
    $_B['static']          = str_replace('https', 'http', $_B['static']);
    $_B['static']          = str_replace('http', 'https', $_B['static']);
    $_B['static']          = str_replace('ibnc.vn', 'webbnc.net', $_B['static']);
    $_B['static']          = 'http://themes.webbnc.net/includes/create/themes';
    include DIR_ROOT . 'includes/create/themes/themesstatus.php';
    die();
}elseif($action=='tatca'){
    include DIR_ROOT . 'includes/create/model/themesstore.php';
    $obj = new Themes();
    $themes_new         = $obj->themes_new();
    foreach ($themes_new as &$v) {
        $v['link'] = 'http://themes.webbnc.net/themesview-' . fixTitle($v['title']) . '-' . $v['id'] . '.html'.$link_svg;
        unset($v);
    } 
    $category = $obj->category();
    foreach ($category as &$value) {
        $value['link'] = 'http://themes.webbnc.net/themesstore-' . fixTitle($value['title']) . '-' . $value['id'] . '.html'.$link_svg;
        unset($value);
    }
    $_DATA['active']=1;
    $_DATA['search'] = "Kho giao diện";
    $_DATA['category']= $category;
    $_DATA['themes_new'] = $themes_new;
    $_DATA['svg'] = $svg;
    $_DATA['link_svg'] = $link_svg;
    //$_DATA['themes_star'] = $themes_star;
    $_B['static']          = str_replace('https', 'http', $_B['static']);
    $_B['static']          = str_replace('http', 'https', $_B['static']);
    $_B['static']          = str_replace('ibnc.vn', 'webbnc.net', $_B['static']);
    $_B['static']          = 'http://themes.webbnc.net/includes/create/themes';
    include DIR_ROOT . 'includes/create/themes/themesstatus.php';
    die();
}
elseif($action=='search'){
    $name  = $_B['r']->get_string('name', 'GET');
    include DIR_ROOT . 'includes/create/model/themesstore.php';
    $obj = new Themes();
    $id  = $_B['r']->get_string('id', 'GET');
    
    $category = $obj->category();
    foreach ($category as &$value) {
        $value['link'] = 'http://themes.webbnc.net/themesstore-' . fixTitle($value['title']) . '-' . $value['id'] . '.html'.$link_svg;
        unset($value);
    }
    $_DATA['category']= $category;
    // get thong tin danh muc
    $_DATA['title_search'] = $name;
    // xuat themes theo danh muc
    $themesSearch   = $obj->themesSearch($name);
    foreach ($themesSearch as &$v) {
        $v['link'] = 'http://themes.webbnc.net/themesview-' . fixTitle($v['title']) . '-' . $v['id'] . '.html'.$link_svg;
        unset($v);
    }
    $_DATA['svg'] = $svg;
    $_DATA['link_svg'] = $link_svg;
    $_DATA['themes'] = $themesSearch;
    $_B['static']          = str_replace('https', 'http', $_B['static']);
    $_B['static']          = str_replace('http', 'https', $_B['static']);
    $_B['static']          = str_replace('ibnc.vn', 'webbnc.net', $_B['static']);
    $_B['static']          = 'http://themes.webbnc.net/includes/create/themes';
    include DIR_ROOT . 'includes/create/themes/themessearch.php';
    die();
}elseif($action=='viewdemo'){
    $pageURL = 'http';
    if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
    } else {
        $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    }
    include DIR_ROOT . 'includes/create/model/themesstore.php';
    $obj = new Themes();
    //var_dump(expression);
   
    $id = $_B['r']->get_int('id', 'GET');
  //  var_dump($id);
    $_DATA['svg'] = $svg;
    $_DATA['link_svg'] = $link_svg;
    $_DATA['viewdemo']    = $obj->themes_detail($id);
    $_DATA['link'] = 'http://themes.webbnc.net/themesview-' . fixTitle($_DATA['viewdemo']['title']) . '-' . $_DATA['viewdemo']['id'] . '.html'.$link_svg;
    include DIR_ROOT . 'includes/create/themes/themesviewdemo.php';
    $_B['static']          = str_replace('https', 'http', $_B['static']);
    $_B['static']          = str_replace('http', 'https', $_B['static']);
    $_B['static']          = str_replace('ibnc.vn', 'webbnc.net', $_B['static']);
    $_B['static']          = 'http://themes.webbnc.net/includes/create/themes';
    die();

}else {
    $pageURL = 'http';
    if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
    } else {
        $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    }
    
    include DIR_ROOT . 'includes/create/model/themesstore.php';
    $obj = new Themes();

    $category = $obj->category();
    foreach ($category as &$value) {
        $value['link'] = 'http://themes.webbnc.net/themesstore-' . fixTitle($value['title']) . '-' . $value['id'] . '.html'.$link_svg;
        unset($value);
    }
    $_DATA['category']= $category;
    // include DIR_ROOT . 'includes/create/themes/detail.php';
    $id = $_B['r']->get_int('id', 'GET');
    $_DATA['svg'] = $svg;
    $_DATA['link_svg'] = $link_svg;
    $themes_item = $obj->themes_other($id);
    foreach ($themes_item as &$v) {
        $v['link'] = 'http://themes.webbnc.net/themesview-' . fixTitle($v['title']) . '-' . $v['id'] . '.html'.$link_svg;
        unset($v);
    }
    $_DATA['themes_other'] = $themes_item;
    $_DATA['detail']    = $obj->themes_detail($id);
    $_DATA['link_demo'] = 'http://themes.webbnc.net/viewdemo-' . fixTitle($_DATA['detail']['title']) . '-' . $_DATA['detail']['id'] . '.html'.$link_svg;
    include DIR_ROOT . 'includes/create/themes/themesdetail.php';
    $_B['static']          = str_replace('https', 'http', $_B['static']);
    $_B['static']          = str_replace('http', 'https', $_B['static']);
    $_B['static']          = str_replace('ibnc.vn', 'webbnc.net', $_B['static']);
    $_B['static']          = 'http://themes.webbnc.net/includes/create/themes';
    die();

}
