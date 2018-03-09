<?php namespace module\album\blockNew;
/**
 * @File MOD/blocks/new.php
 *@author Quang Chau Tran (quangchauvn@gmail.com)
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
	public $mod = 'album';
	public $limit;
	public function __construct() {
		global $_B, $web;
		$this->limit = 5;
		if ($web['idw']== 4547) {
            $this->limit = 10;
        }
        if ($web['idw']== 5660) {
            $this->limit = 12;
        }
		$this->lang  = $_B['lang'];
		$this->idw   = $web['idw'];
		$this->setData();
	}
	/**
	 *funntion setData;
	 *gan du lieu cho returnData
	 *@param
	 *@return void
	 */
	public function setData() {
		$data             = $this->getNew();
		$data             = $this->ModifyNew($data);	
		$this->returnData = $data;
	}
	private function ModifyNew($data) {
		foreach ($data as $key => $value) {
			$cat_id              = explode(',', $value['category_id']);
			$parent_id           = $cat_id[1];
			$data[$key]['link']  = $this->linkUrl('album', 'detail', 'view', $value['id'], $value['alias']);
			$data[$key]['thumb'] = $value['avatar'];
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
		$newObj->orderBy('id', 'DESC');
		$cols = array('id', 'title', 'contents_description', 'avatar', 'category_id', 'alias');
		return $newObj->get(null, $this->limit, $cols);
	}
}