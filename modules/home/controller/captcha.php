<?php 
/**
 * @Project BNC v2 -> Module Home
 * @File home/captcha.php
 * @author Huong Nguyen Ba ( nguyenbahuong156@gmail.com )
 * @Createdate 12/12/2014, 14:38 PM
 */
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}
Class Captcha extends Controller{
	public function index(){ 
	    //header("Content-type: image/jpg");
	    gencaptcha();
	}
}