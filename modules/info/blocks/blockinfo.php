<?php namespace module\info\blockinfo;
/**
 * @File MOD/blocks/info.php
 *@author An Nguyen Huu (annh@webbnc.vn)
 * @Createdate 12/02/2014, 08:53 AM
 */
//Class Block extends BlockGlobal{
Class Block extends \BlockGlobal {
	/**
	 * $returnData - bien chua data de xuat ra o giao dien
	 *@return array
	 */
	public $returnData = array();
	public $lang;
	public $idw;
	public $mod = "info";
	public function __construct() {
		global $_B, $web;
		$this->lang = $_B['lang'];
		$this->idw  = $web['idw'];
		db_connect($this->mod);
		$this->setData();
	}
	/**
	 *funntion setData;
	 *gan du lieu cho returnData
	 *@param
	 *@return void
	 */
	public function setData() {
		$data             = $this->getInfo();
		$data             = $this->ModifyInfo($data);
		
		$this->returnData = $data;
	}
	private function ModifyInfo($data) {
		foreach ($data as $key => $value) {
			$data[$key]['link']  = $this->linkUrl('info', 'detail', 'view', $value['id'], $value['alias']);
			$data[$key]['thumb'] = $this->loadImage($value['img'], 'resize', 200, 180);
		}
		return $data;
	}
	/**
	 *funntion getData;
	 *gan du lieu cho returnData
	 *@param
	 *@return void
	 */
	private function getInfo() {
		global $_B;
		$infoObj = new \Model($this->lang . '_info');
		$infoObj->where('idw', $this->idw);
		$infoObj->where('status', 1);
		$infoObj->orderBy('id', 'DESC');
		$cols = array('id', 'title', 'short', 'img', 'details','sort', 'alias','id_lang');
		$res=$infoObj->get(null, 10, $cols);
		if($_B['lang']!=$_B['lang_default']){
			foreach ($res as &$v) {
				$v['id']=$v['id_lang'];	
			}
		}
		
		return $res;
	}
}