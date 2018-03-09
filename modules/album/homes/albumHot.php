<?php namespace module\album\albumHot;
/**
 * @File MOD/blocks/new.php
 *@author Quang Chau Tran (quangchauvn@gmail.com)
 * @Createdate 12/02/2014, 08:53 AM
 */
//Class Block extends BlockGlobal{
Class BlockHome extends \HomeGlobal {
	/**
	 * $returnData - bien chua data de xuat ra o giao dien
	 *@return array
	 */
	public $returnData = array();
	public $lang;
	public $idw;
	public $limit = 10;
	public $mod   = 'album';
	public function __construct() {
		global $_B, $web;
		$this->lang = $_B['lang'];
		$this->idw  = $web['idw'];
		if($this->idw==1244){
			$this->limit=30;
		}
		
		$this->setData();
	}
	/**
	 *funntion setData;
	 *gan du lieu cho returnData
	 *@param
	 *@return void
	 */
	private function setData() {
		
		$data['album']    = $this->getNew();
		$data['album']    = $this->ModifyNew($data['album']);
		$this->returnData = $data;
	}
	private function ModifyNew($data) {
		global $_B,$web;
		foreach ($data as $key => $value) {
			if($_B['lang']!=$_B['lang_default']){
				$data[$key]['id']=$data[$key]['id_lang'];
			}
			$data[$key]['link'] = $this->linkUrl($this->mod, 'detail', 'view', $data[$key]['id'], $value['alias']);
			$data[$key]['thumb'] =$value['avatar'];
		}
		return $data;
	}
	/**
	 *funntion getData;
	 *gan du lieu cho returnData
	 *@param
	 *@return void
	 */
	private function getNew() {
		$newObj = new \Model('album.'.$this->lang . '_album');
		$newObj->where('idw', $this->idw);
		$newObj->where('status', 1);
		$newObj->where('album_hot', 1);
		$newObj->orderBy('order_by', 'ASC');
		// $newObj->orderBy('id', 'DESC');
		// $newObj->orderBy('update_time', 'DESC');
		$cols = array('id','id_lang', 'title', 'contents_description', 'avatar', 'category_id', 'alias');
		return $newObj->get(null, $this->limit, $cols);
	}
}