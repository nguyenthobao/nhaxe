<?php

if(!defined('BNC_CODE')) {
    exit('Access Denied');
}
Class Contact extends Controller{

	public function index(){
		global $_B,$web;
			//Gọi hàm set dữ liệu lên header
		
			//Gọi hàm đưa nội dung ra ngoài giao diện
			$this->setContent(null,'success');
	}
	
}