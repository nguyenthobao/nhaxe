<?php
/**
 * @Project BNC v2 -> Module Home
 * @File home/main.php
 * @Author Quang Chau Tran (nquangchauvn@gmail.com)
 * @Createdate 10/29/2014, 09:38 AM
 */
if (!defined('BNC_CODE')) {
	exit('Access Denied');
}
Class Datve extends Controller {
	public function index() {
		global $web; 
		$routeId   = $this->request->get_string('routeId', 'GET');
		$tripId   = $this->request->get_string('tripId', 'GET');
		$scheduleId   = $this->request->get_string('scheduleId', 'GET');
		$companyId   = $this->request->get_string('companyId', 'GET');

        $data['khuhoi'] = '';

        if(isset($_POST) && $_POST['khuhoi'] == 1)
        {
            $_SESSION['khuhoi'] = $_POST;
        } else if (empty($routeId)){
//            echo "error";exit();
            unset($_SESSION['khuhoi']);
        }

        if(isset($_SESSION['khuhoi']))
        {
            $data['khuhoi'] = $_SESSION['khuhoi'];
        }

		if( !empty($companyId) ) $web['anvui_id'] = $companyId;
		if(!empty($tripId)){
			return $this->trip($tripId,$companyId,$scheduleId);
		}
		if(!empty($routeId)){ 
			return $this->route($routeId,$companyId);
		}
		if(!empty($web['anvui_id'])){
			$data['chuyen'] = $this->GetAnvui('https://dobody-anvui.appspot.com/web/route-getlist?page=0&count=100&companyId='.$web['anvui_id'].'&version=0.1');
			$data['chuyen'] = $data['chuyen']['results']['listRoute'];

//			 echo '<pre>';
//			 var_dump($data['khuhoi']);
//			 die;
			$routeId = '';

			foreach ($data['chuyen'] as $key => &$value) {
				if($routeId == ''){
					$routeId = $value['routeId'];
				}
				$value['price'] = number_format(max($value['listPriceByVehicleType'])).' đ';
				$value['link'] = 'http://'.$web['home'].'/dat-ve?routeId='.$value['routeId'];
			}

			 



			$beginOfDay = strtotime("midnight"); 
			$endOfDay   = strtotime("tomorrow", $beginOfDay) - 1;

			$data['days'][] = date("d-m-Y",$endOfDay);
			for ($i=1; $i < 30 ; $i++) { 
				$data['days'][] = date("d-m-Y",$endOfDay+$i*24*60*60);
			}

			$beginOfDay = $beginOfDay*1000;
			$endOfDay = $endOfDay*1000;

			$rt= $this->GetAnvui('https://dobody-anvui.appspot.com/web/route-view-by-id?page=0&count=100&routeId='.$routeId.'&startDate='.$beginOfDay.'&endDate='.$endOfDay);
	 		
	 		

	 		$data['listPoint'] = $rt['results']['listPoint'];


	 		$data['routeId'] = $routeId; 



		}
		$this->setContent($data, 'index');
	} 
	function order(){
		$phoneNumber   = $this->request->get_string('phoneNumber', 'POST');
		$fullName   = $this->request->get_string('fullName', 'POST');

        if(isset($_SESSION['khuhoi'])) {
            unset($_SESSION['khuhoi']);
        }
		
		$_POST['ticketStartDate'] = $_POST['getInTimePlan'];

		$rt = $this->PostAnvui('https://dobody-anvui.appspot.com/web/ticket-order',$_POST);

		header('Content-Type: application/json');
		echo json_encode($rt); 
		die;
	}

	function epay() {
        $rt = $this->PostAnvui('https://dobody-anvui.appspot.com/web/ticket-order',$_POST);
        header('Content-Type: application/json');
        echo json_encode($rt);
        die;
    }

	function huykhuhoi(){
	    $routeId = $_SESSION['khuhoi']['routeId'];
        if(isset($_SESSION['khuhoi'])) {
            unset($_SESSION['khuhoi']);
        }
        header('Location: /dat-ve?routeId='.$routeId);
        die();
    }
	function getpayoo(){
		$data = array();
		$data['customerName']   = $this->request->get_string('customerName', 'POST');
		$data['ticketId']   = $this->request->get_string('ticketId', 'POST');
		$data['cyberCash']   = $this->request->get_string('cyberCash', 'POST');
		$data['customerPhone']   = $this->request->get_string('customerPhone', 'POST');
		$data['timeZone']   = 7;
		 
// var_dump($data); die;
		$rt = $this->PostAnvuiCus('https://dobody-anvui.appspot.com/payoo/create-order',$data);
		 
		header('Content-Type: application/json');
		echo json_encode($rt); 
		die;
	}
	function route($routeId,$companyId){  
		global $web;
		$beginOfDay = strtotime("midnight"); 
		$endOfDay   = strtotime("tomorrow", $beginOfDay) - 1;
$data['days'][] = date("d-m-Y",$endOfDay);
		for ($i=1; $i < 30 ; $i++) { 
			$data['days'][] = date("d-m-Y",$endOfDay+$i*24*60*60);
		}
		$beginOfDay = $beginOfDay*1000;
		$endOfDay = $endOfDay*1000;

        $data['khuhoi'] = '';
			
			 



		$rt= $this->GetAnvui('https://dobody-anvui.appspot.com/web/route-view-by-id?page=0&count=100&routeId='.$routeId.'&startDate='.$beginOfDay.'&endDate='.$endOfDay);
 		
 		

 		$data['listPoint'] = $rt['results']['listPoint'];


 		$data['routeId'] = $routeId;
		$data['route'] = $rt['results']['route'];

		
		$data['startPointId']   = $this->request->get_string('startPointId', 'GET');
		$data['endPointId']  = $this->request->get_string('endPointId', 'GET');
		$data['date']  = $this->request->get_string('date', 'GET');
		if(empty($data['date'])){
			$data['date'] = date('d-m-Y');
		}
		$date = explode('-', $data['date']);
		$datetimestamp = (mktime(0,0,0,(int)$date[1],(int)$date[0],(int)$date[2])  + 60*60*24 )* 1000;

		$customtuyen = false;

		if( empty($data['startPointId']) ){
			$data['startPointId'] = reset($data['listPoint']);
			$data['startPointId'] = $data['startPointId']['pointId'];
			$customtuyen = true;
		}
		if( empty($data['endPointId']) ){
			$data['endPointId'] = end($data['listPoint']);
			$data['endPointId'] = $data['endPointId']['pointId'];
		}

		
		if( 
			!empty($data['startPointId'])
			&& !empty($data['endPointId'])
			&& !empty($data['date'])
		){
		$url = 'https://dobody-anvui.appspot.com/web/find-schedule?page=0&count=100&startPointId='.$data['startPointId'].'&endPointId='.$data['endPointId'].'&date='.$datetimestamp.'&routeId='.$routeId;
		
		// echo $url;
		$rt1= $this->GetAnvui($url);

		 

			$data['listSchedule'] = $rt1['results']['result'];
		 // echo '<pre>'; var_dump($data['listSchedule'] ); die;


// header('Content-Type: application/json');
// echo json_encode($rt1); 
// die;

			foreach ($data['listSchedule'] as $keysch => &$valuesch) {
				$valuesch['startTime'] = date('H:i d/m/Y',$valuesch['startTime']/1000); 
				
				$valuesch['link'] = 'http://'.$web['home'].'/dat-ve?tripId='.$valuesch['tripId'];
				// if($valuesch['tripId'] == -1){
				// 	unset($data['listSchedule'][$keysch]);
				// }
				$valuesch['ticketPrice1'] = number_format($valuesch['ticketPrice']);
			}

		}
		
		$data['route']['childrenTicketRatio'] =  (int)($data['route']['childrenTicketRatio']*100);
		// var_dump($data['route']['childrenTicketRatio']); die;


	 		foreach ($data['listPoint'] as $kl => $vl) {
	 			if ($data['startPointId'] == $vl['pointId'] )$tuyen = $vl['pointName'].' đi ';
	 		}
	 		foreach ($data['listPoint'] as $kl => $vl) {
	 			if ($data['endPointId'] == $vl['pointId'] )$tuyen .= $vl['pointName'];
	 		}

	 		if($tuyen && !$customtuyen){
	 			$data['route']['routeName'] = $tuyen;
	 		}

	 		if($routeId == $_SESSION['khuhoi']['routeId'])
            {
                unset($_SESSION['khuhoi']);
            }

        if(isset($_SESSION['khuhoi'])) {
            $data['khuhoi'] = $_SESSION['khuhoi'];
        }
//        echo "<pre>";var_dump($data['khuhoi']);echo "</pre>";exit();

        $data['companyId'] = $web['anvui_id'];

		$this->setContent($data, 'datve');
	}
	function trip($tripId,$companyId,$scheduleId){
		$rt= $this->GetAnvui('https://dobody-anvui.appspot.com/web/view-seatmap-by-schedule?scheduleId='.$scheduleId.'&tripId='.$tripId);
		// echo 'https://dobody-anvui.appspot.com/web/view-seatmap-by-schedule?scheduleId='.$scheduleId.'&tripId='.$tripId;
		// echo 'https://dobody-anvui.appspot.com/web/view-seatmap-by-schedule?scheduleId=-1&tripId='.$tripId;
 		

 		header('Content-Type: application/json');
		echo json_encode($rt['results']); 
		die;
	}

	public function PostAnvuiCus($url,$data,$token=null){
        if(empty($token)){
            $token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ2IjowLCJkIjp7InVpZCI6IkFETTExMDk3Nzg4NTI0MTQ2MjIiLCJmdWxsTmFtZSI6IkFkbWluIHdlYiIsImF2YXRhciI6Imh0dHBzOi8vc3RvcmFnZS5nb29nbGVhcGlzLmNvbS9kb2JvZHktZ29ub3cuYXBwc3BvdC5jb20vZGVmYXVsdC9pbWdwc2hfZnVsbHNpemUucG5nIn0sImlhdCI6MTQ5MjQ5MjA3NX0.PLipjLQLBZ-vfIWOFw1QAcGLPAXxAjpy4pRTPUozBpw';
        }
        $request_header = [
            'Content-Type:text/plain',
            sprintf('DOBODY6969: %s', $token)
        ];

        $ch = curl_init();

     
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $request_header);
 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec ($ch);

        curl_close ($ch); 
        // return  $response;
        return json_decode($response,1);
    }

}