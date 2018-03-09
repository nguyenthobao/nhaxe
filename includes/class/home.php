<?php
/** 
 * @File uncludes/class/home.php
 *@author Quang Chau Tran (quangchauvn@gmail.com)
 * @Createdate 12/04/2014, 11:15 AM
 */
class HomeGlobal{
	public $idw;
	public $lang; 
	public function __construct(){
		global $_B,$web;
		$this->lang = $_B['lang'];
		$this->idw = $web['idw'];
	}
	public function linkUrl($mod,$page,$sub=null,$id=null,$alias = null,$notRewrite = null){
		global $_B,$web;
		return linkUrl($web,$mod,$page,$sub,$id,$alias,$notRewrite);
		if ($web['ssl'] == true) {
			$url = 'https://';
			//$web['HTTP_SERVER'] = 'https://';
		}else{
			$url = 'http://';
			//$web['HTTP_SERVER'] = 'http://';
		}
		if (isset($id)) {
			$id = '-'.$id;
		}
		if ($sub!=null) {
			$sub = '-'.strtolower($sub);
		}
		$newUrl = $url.$web['home'].'/'.strtolower($mod).'-'.strtolower($page).$sub.$id.strtolower($web['dotExtension']);
		return $newUrl;
	}
	public function loadImage($img,$op='resize',$width=null,$height=null){
		global $_B;
		return loadImage($img,$op,$width,$height);
	}

}