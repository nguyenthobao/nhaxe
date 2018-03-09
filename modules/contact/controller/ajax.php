<?php

if (!defined('BNC_CODE')) {
    exit('Access Denied');
}

class ajax extends Controller {

    public function checkCaptcha()
    {
        if(!$_POST) exit('Access Denied');
        $ca = $this->request->get_string('captcha','POST');
        $captcha = checkCaptcha($ca);
        $data['ajax']=true;
        if($captcha){
            $data['captcha'] = $ca;
        }else{
            $data['captcha'] =  '0';
        }
        echo $data['captcha'];
        exit;
    }
}


?>