<?php

if(!defined('BNC_CODE')) {
    exit('Access Denied');
}
Class Contact extends Controller{

	public function index(){
		global $_B,$web;
		
		$action = $this->request->get_string('action','POST');
		$action_block = $this->request->get_string('action_block','POST');
		$data['url']    = $this->linkUrl('contact');
		$data['check_captcha_url'] = $this->linkUrl('ajax', 'checkCaptcha');
		if(!empty($action)){
			$data= array(
				'customers'          => $this->request->get_string('txtName','POST'),
				'email'              => $this->request->get_string('txtEmail','POST'),
				'phone'              => $this->request->get_string('txtPhone','POST'),
				'address'            => $this->request->get_string('txtAddress','POST'),
				'content'            => $this->request->get_string('txtContent','POST'),
				'create_time'        => time(),
		);
			$isSendMail=false;
			$modelContact  = $this->loadModel('contact');
			$result = $modelContact->addContat($data);
			if ($result['status']) { 
				$data["success"]="success";
				$isSendMail=true;
				/*header("location:".$data['url']);
				exit();*/
			}else{
			    $data['success']="error";
			}
		}

		if(!empty($action_block)){
			$data_block = array(
			'customers'          => $this->request->get_string('name_block','POST'),
			'email'              => $this->request->get_string('email_block','POST'),
			'phone'              => $this->request->get_string('phone_block','POST'),
			'address'            => $this->request->get_string('address_block','POST'),
			'content'            => $this->request->get_string('content_block','POST'),
			'create_time'        => time(),
		);
			$modelContact  = $this->loadModel('contact');
			$result        = $modelContact->addContat($data_block);
			if ($result['status']) { 
				$data["success"] = "success";
			}else{
			    $data['success'] = "error";
			}
		}
		

		$modelContact  = $this->loadModel('contact');
		$ab            = $modelContact->getContact();
		$contacts      = $modelContact->getContactInfo();

		// var_dump($ab);
		// var_dump($contacts);
		// die;
		
		if(!empty($action) && !empty($contacts['email']) && $isSendMail!=false){
			$body=file_get_contents(DIR_MODULES.'contact/themes/temp_mail.htm');
			$body=str_replace('{name}', $contacts['email'], $body);
			$body=str_replace('{custom}', $data['customers'], $body);
			$body=str_replace('{phone}', $data['phone'], $body);
			$body=str_replace('{email}',$data['email'], $body);
			$body=str_replace('{address}', $data['address'], $body);
			$body=str_replace('{content}', $data['content'], $body);
			$data2 = array(
	                'type'            => 'SMTP',
	                'debug'           => 0, //Defaul 0
	                'multi'           => false,
	                'setFrom'         => array('noreply@bncmails.com', 'Liên hệ'),
	                'addReplyTo'      => null, //array('noreply@mailbnc.vn', 'BNC system'),
	                'addAddress'      => array($contacts['email'],  $data['customers']),
	                'arrayAddAddress' => null,
	                'subject'         => 'Liên hệ',
	                'content'         => $body,
	                'shop_name'         => 'Liên hệ',
	            );
	        // $send = sendMail($data2);
	    }

		if(isset($contacts)){

			//Set nội dung cho header
			$head  = array(
				'title'         => lang('title_contact'),
				'keywords'      => lang('keyword_contact'),
				'description'   => lang('description_contact'),
			);

			$breadcrumbsHomeModule = array(
				'text'		=> lang('title_contact'),
				'href'      => $modelContact->url_mod
				);
			//set title breadcrumbs		
			if (isset($contacts['info'])) {
				$data['info'] = $contacts['info']; 
				$data['maps'] = base64_decode($contacts['maps']);	
			}else{
				echo lang('notfound_data');
			}
			//unset($contacts);
			$data['breadcrumbs'] = $this->setBreadcrumbs(null,$breadcrumbsHomeModule);
			//Gọi hàm set dữ liệu lên header
			$this->setTitle($head);
			//Gọi hàm đưa nội dung ra ngoài giao diện
			$this->setContent($data,'contact');
		}else{
			$data['breadcrumbs'][] = array(
	       		'text'      => lang('title_notfound'),
				'href'      => '',
	       		'separator' => true
	   		);
			//Set nội dung cho header
			$head  = array(
				'title'         => lang('title_notfound'),
				'keywords'      => lang('title_notfound'),
				'description'   => lang('description_notfound'),
			);
			$data['title']       = lang('title_notfound');
			$data['description'] = lang('description_notfound');
			$data['info']        = 'Not found data';
			$this->setTitle($head);
			//Gọi hàm đưa nội dung ra ngoài giao diện
			$this->setContent($data,'contact');
		}	
	}
}