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
		
		$beginOfDay = strtotime("midnight"); 
		$endOfDay   = strtotime("tomorrow", $beginOfDay) - 1;

		$beginOfDay = $beginOfDay*1000;
		$endOfDay = $endOfDay*1000;

		$rt= $this->GetAnvui('https://dobody-anvui.appspot.com/web/route-view-by-id?page=0&count=10&routeId='.$routeId.'&startDate='.$beginOfDay.'&endDate='.$endOfDay);
 
		$data['listSchedule'] = $rt['results']['listSchedule'];

		foreach ($data['listSchedule'] as $key => &$value) {
			$value['startTime'] = date('H:m d/m/Y',$value['startTime']/1000);
		}

		// var_dump($rt['results']['listSchedule']); die;

		$this->setContent($data, 'datve');
	} 
}