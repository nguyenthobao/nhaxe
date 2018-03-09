<?php
/**
 * @Project BNC v2 -> Module Home
 * @File home/captcha.php
 * @author Huong Nguyen Ba ( nguyenbahuong156@gmail.com )
 * @Createdate 12/12/2014, 14:38 PM
 */
if (!defined('BNC_CODE')) {
	exit('Access Denied');
}

Class QrcodeBnc extends Controller {
	public function index() {
		genQRcode();
	}
	public function genQRcodeProduct() {
		$value   = $this->request->get_string('key', 'GET');
		$value   = base64_decode($value);
		$product = json_decode($value, true); 
		if (isset($product)) {
			return genQRcodeProduct($product);
			exit();
		} else {
			echo "Access Denied";die();
		}

	}
}