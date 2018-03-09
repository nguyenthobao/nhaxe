<?php
/**
 * @Project BNC v2 -> Frontend
 * @File /includes/class/idvg.php 
 * @Author Huong Nguyen Ba (nguyenbahuong156@gmail.com)
 * @Createdate 23/03/2015, 10:55 AM
 */
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}
include_once DIR_HELPER.'idvg/symetricTicket.php';

class Idvg {
	private $token;
	public function __construct() {
		global $_B;
		$this->request = $_B['r'];
		$access_code = $this->request->get_string('access_code','GET');
		if (!empty($access_code)) {
			$arr_idvg = $this->access_token($access_code,'','');
			$json = json_decode($arr_idvg,'json');
			$this->token =  $json['objects'][0]['access_token'];
		}
	}
	public function getInfoIdVG(){
		if (!empty($this->token)) {
				$stt_token = $this->access_token('',$this->token,'acc');
				 if ($stt_token) {
		         	$json_acc = json_decode($stt_token,'json');
	        	}
			}
	}
	public function getBlanBaoKim(){
		$url = "https://www.baokim.vn/accounts/rest/sso_oauth_api/get_account_info/".$this->token;
		$blan = $this->bao_kim($url);
		$bk = json_decode($blan,'json');
		return $bk;
	}
	public function getTicketIdvg($username,$password){
		 $s = new SymetricTicket(array(
                'username'=>$username,
                'password'=>$password,
                'timestamp'=>time(),
                'remember'=>true,
            ), '7b674ca3487e2afdfeaf201cf03e704a8845be5a705c0b35a8723ac495cb05ed|01e6d28a6328a13c501fe7127b282d74');

    		$ticket = $s->encrypt();
    		$ticket = urlencode($ticket);
    		return $ticket;
	}
	private function access_token($accessCode,$token='',$with=''){ 
		if ($accessCode) {
			$url = 'https://id.vatgia.com/oauth2/accessCode/'.$accessCode;
		}else if ($token) {
			$url  = "https://id.vatgia.com/oauth2/accessToken/".$token."?with=acc";
		}
	        $ch = curl_init(); 
	        curl_setopt($ch, CURLOPT_URL, $url);
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	        curl_setopt($ch, CURLOPT_USERPWD, "webbnc_2:SJzhQMHCdWr0YO1pwvBN");
	        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	        $output = curl_exec($ch);
	        $info = curl_getinfo($ch);
	        curl_close($ch);
	        return $output;
	}
	//get blance baokim
	private function bao_kim($url){ 
	        $ch = curl_init(); 
	        curl_setopt($ch, CURLOPT_URL, $url);
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	        $output = curl_exec($ch);
	        $info = curl_getinfo($ch);
	        curl_close($ch);
	        return $output;     
	}
}
?>