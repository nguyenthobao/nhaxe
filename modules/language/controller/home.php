<?php
/*
 * @Project BNC V2
 * @author Huong Nguyen Ba <nguyenbahuong156@gmail.com>
 * Frontend language
 */
if (!defined('BNC_CODE')) {
    exit('Access Denied');
}

class home extends Controller {
    public function index()
    {
        global $webObj, $_B, $web;
        $json = array();
        $lang =  $this->request->get_string('lang','POST');
        $redirect  = $_POST['redirect'];

        if (!empty($lang)) {
            $_SESSION['lang_'.$web['idw']] = $lang;
            $_B['lang'] = $_SESSION['lang_'.$web['idw']];
            setcookie('language_cookie_'.$web['idw'],$_B['lang'],time()+86400);
            if (!empty($redirect)) {
                $json['status'] = true;
                $json['redirect'] = $redirect;
            }else{
                $json['status'] = true;
                $json['redirect'] = $web['home_url'];
            }
        }
        echo json_encode($json);exit();
    }
}

?>