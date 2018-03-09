<?php 
/**
 * @Project BNC v2 -> Module Home
 * @File home/main.php
 * @Author Quang Chau Tran (nquangchauvn@gmail.com)
 * @Createdate 10/29/2014, 09:38 AM
 */
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}
Class thememanager extends Controller{
	public function __construct(){
		parent::__construct();
		// $username = 'copytheme';
		// $pass     = 'bananhhuong@2205';
		// if (!(isset($_SERVER['PHP_AUTH_USER']) && $_SERVER['PHP_AUTH_USER'] == $username && $_SERVER['PHP_AUTH_PW'] == $pass)) {
		//     header("WWW-Authenticate: Basic realm=\"dev3.webbnc.vn\"");
		//     header("HTTP/1.0 401 Unauthorized");
		//     header('Content-Type: application/json');
		//     echo json_encode($json);
		//     exit();
		// }
	}
	public function index(){ 
		global $_B,$web;
		
		// if (!isset($_B['uid'])) {
		// 	header("Location:".$web['home_url'].'/user-login.html');
		// }
		
		$data['copytheme'] = $web['home_url'].'/home-thememanager-copytheme.html';
		$data['ajax'] = true;
		$this->setContent($data,'theme_index');
	}
	public function copytheme(){
		global $web;
		$folderNumber = $this->request->get_int('folderNumber','POST');
		
		$src = DIR_MODULES;
		$dh  = opendir($src);
		while (false !== ($filename = readdir($dh) )) {
			if (preg_match("/[a-zA-Z0-9\_]+/", $filename) 
				&& $filename!='dev3.sublime-project'
				&& $filename!='themes_root'
				&& $filename!='lang'
				&& $filename!='document'
				&& $filename!='deal')
			{
				$modules[] = $filename;
			}
		    
		}
		unset($data['error']);
		if (!empty($folderNumber)){
			header( 'Content-type: text/html; charset=utf-8' );
			if(preg_match("/[0-9]+/",$folderNumber)) {
				include_once DIR_CLASS.'filemanager.php';
				    $filemanager = new FileManager();
					$theme_id = $web['theme_id'];
					$dir = DIR_THEME.'/'.$folderNumber;
					if (!is_dir($dir)) {
						mkdir($dir);
						//chown($dir,'ftp_dev3_themes');
						@chmod($dir,0775);

						foreach ($modules as $k => $v) {
							$dir_from = $src.$v.'/themes';
							$dir_to = $dir.'/'.$v;
							//echo $dir_from.'<br/>';
							// mkdir($dir_to);
							// chmod($dir_to,0775);
							$filemanager->copyFolderFile($dir_from,$dir_to);
							flush();
						 	ob_flush();
						}

						//copy common
						$filemanager->copyFolderFile(DIR_THEME.'/1/common',$dir.'/common');
						//copy layout
						$filemanager->copyFolderFile(DIR_THEME.'/1/layout',$dir.'/layout');
						//copy statics
						$filemanager->copyFolderFile(DIR_THEME.'/1/statics',$dir.'/statics');
						//copy file layout.htm
						copy(DIR_THEME.'/1/layout.htm', $dir.'/layout.htm');
						chmod($dir.'/layout.htm',0664);
						$data['success'] = "Tạo thành công";
					}else{
						$data['error']['exist'] = "Đã tồn tại folder này rồi. Mời chọn folder khác !";
					}
			}else{
				$data['error']['post'] = "Mời bạn nhập số.";
			}
		}

		$data['postCopyTheme'] = $web['home_url'].'/home-thememanager-copytheme.html';
		$data['ajax'] = true;
		$this->setContent($data,'theme_copy');	
	}
}