<?php namespace module\news\blocknew;
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
	public $limit;
	public function __construct() {
		global $_B, $web;
		$this->limit = 5;
		$this->lang  = $_B['lang'];
		$this->idw   = $web['idw'];
		db_connect('news');
		$this->setData();
	}
	/**
	 *funntion setData;
	 *gan du lieu cho returnData
	 *@param
	 *@return void
	 */
	private function setData() {
		$data             = $this->getNew();
		$data             = $this->ModifyNew($data);
		$this->returnData = $data;
	}
	private function ModifyNew($data) {
		foreach ($data as $key => $value) {
			$cat_id              = explode(',', $value['cat_id']);
			$parent_id           = $cat_id[1];
			$data[$key]['link']  = $this->linkUrl('news', 'detail', 'view', $value['id'], $value['alias']);
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
	private function getNew() {
		$newObj = new \Model($this->lang . '_news');
		$newObj->where('idw', $this->idw);
		$newObj->where('status', 1);
		$newObj->orderBy('id', 'DESC');
		$cols = array('id', 'title', 'short', 'img', 'cat_id', 'alias');
		return $newObj->get(null, $this->limit, $cols);
	}
}