<?php

if (!defined('BNC_CODE')) {
	exit('Access Denied');
}

Class Signupfooter extends Controller {
	public function index() {
		echo '<pre>';
		print_r($_POST);
		echo '</pre>';
		die();
	}

}