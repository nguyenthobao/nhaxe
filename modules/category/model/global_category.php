<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /model/global.php 
 * @Author Hùng
 * @Createdate 08/17/2014, 15:46 PM
 */
if(!defined('BNC_CODE')) {
    exit('Access Denied');
}

class GlobalCategory{
	public $lang_use;
	public function __construct() {
		global $_B, $_DATA;
		//$this->idw         = $_B['web']['idw'];
		$this->lang_use    = $_B['cf']['lang_use'];
	}
	//Đêm danh mục 
	public function countCategory(){
			$lang = (empty($this->lang))?'vi':$this->lang;
			$this->catego = new Model($lang.'_category');
			$this->catego->where('idw',$this->idw);
			$this->catego->where('status',1);
			$result = $this->catego->num_rows();
			return $result;
	}
	//
	//Chuyển đổi từ mảng đa chiều thành mảng 1 chiều
	public function multipleToSimpleArray($array,$categoarray = array()){
		foreach ($array as $k => $v) {
			$tmp = $v['sub'];
			unset($v['sub']);
			$categoarray[] = $v;
			if(sizeof($tmp) > 0){
				$categoarray = $this->multipleToSimpleArray($tmp,$newarray);
			}
		}
		return $categoarray;
	}
	public function getCatParent(){
		$id = $this->r->get_int('id', 'GET');
		$getLangAndID = getLangAndID();
		$this->catego = new Model($getLangAndID['lang'].'_category');
		$select = array('id','id_lang','title','status');
		$this->catego->where('idw',$this->idw);
		if($id){
			$this->catego->where('id',$id,"!=");
		}
		
		$this->catego->orderBy('sort','ASC');
		$data = $this->catego->get(null,null,$select);
		if ($getLangAndID['lang']!='vi') {
			foreach ($data as $k => $v) {
				$v['id'] = $v['id_lang'];
				$data[$k] = $v;
			}
		}

		$result = $this->getCategory($data);
		if ($result) {
			return $result;
		}
	}
	public function getCatParentVD(){
		$id = $this->r->get_int('id', 'GET');
		$getLangAndID = getLangAndID();
		$this->catVideoObj = new Model($getLangAndID['lang'].'_category');
		$select = array('id','id_lang','title','parent_id','status','sort');
		$this->catVideoObj->where('idw',$this->idw);
		$this->catVideoObj->orderBy('sort','ASC');
		$data = $this->catVideoObj->get(null,null,$select);
		if ($getLangAndID['lang']!='vi') {
			foreach ($data as $k => $v) {
				$v['id'] = $v['id_lang'];
				$data[$k] = $v;
			}
		}

		$result = $this->getCategory($data);
		if ($result) {
			return $result;
		}
	}

	
	protected function fixParentCat($data,$parent_id,$id){
		global $_B;
		$lang_user = explode(',',$_B['cf']['lang_use']);
		foreach ($lang_user as $k => $v) {
			if ($v!='vi') {
				$this->catVideoObj = new Model($v.'_category');
				$this->catVideoObj->where('id_lang',$id);
				$this->catVideoObj->where('idw',$this->idw);
				$result = $this->catego->update($data);		
			}
		}
		if ($result) {
			return true;
		}
	}
	protected function fixCategoID($data,$id,$action){
		global $_B;
		$lang_user = explode(',',$_B['cf']['lang_use']);
		foreach ($lang_user as $k => $v) {
			if ($v!='vi') {
				$this->catego = new Model($v.'_category');
				$this->catego->where('id_lang',$id);
				$this->catego->where('idw',$this->idw);
				if ($action=='update') {
					$result = $this->catego->update($data);	
				}else if($action=='delete'){
					$result = $this->catego->delete();	
				}				
			}
		}
		if ($result) {
			return true;
		}
	}
	protected function CategoryVideoID($data,$id,$action){
		global $_B;
		$lang_user = explode(',',$_B['cf']['lang_use']);
		foreach ($lang_user as $k => $v) {
			if ($v!='vi') {
				$this->catVideoObj = new Model($v.'_category');
				$this->catVideoObj->where('id_lang',$id);
				$this->catVideoObj->where('idw',$this->idw);
				if ($action=='update') {
					$result = $this->catVideoObj->update($data);	
				}else if($action=='delete'){
					$result = $this->catVideoObj->delete();	
				}				
			}
		}
		if ($result) {
			return true;
		}
	}
	protected function checkExist($id,$lang,$page){
		$this->catego = new Model($lang.'_'.$page);
		$this->catego->where('id_lang',$id);
		$this->catego->where('idw',$this->idw);
		$result = $this->catego->num_rows();
		if ($result) {
			return true;
		}
		return false;
	}
	public function get_lang_id($lang = null) {
		if($lang == null){
			$lang = $this->lang;
		}
		if($lang == 'vi'){
			$result = 'id';
		}else{
			$result = 'id_lang';
		}
		return $result;
	}
	

}