<?php namespace module\news\newsHot;
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
	public $mod   = 'news';
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
	private function setData() {
		$config           = $this->getConfig();
		$this->limit=$config['quantity_hot'];
		$data['news']     = $this->getNew();
		$data['news']     = $this->ModifyNew($data['news']);
		$this->returnData = $data;
	}
	private function ModifyNew($data) {
		foreach ($data as $key => $value) {
			$cat_id    = explode(',', $value['cat_id']);
			$parent_id = $cat_id[1];
			if ($this->lang != 'vi') {
				$data[$key]['link'] = $this->linkUrl($this->mod, 'detail', 'view', $parent_id . '_' . $value['id_lang'], $value['alias']);
			} else {
				$data[$key]['link'] = $this->linkUrl($this->mod, 'detail', 'view', $parent_id . '_' . $value['id'], $value['alias']);
			}
			$data[$key]['thumb']       = $this->loadImage($value['img'], 'resize', 200, 180);
			$data[$key]['create_time'] = date("H:i:s d-m-Y", $value['create_time']);
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
		$newObj->where('is_hot', 1);
		$newObj->orderBy('id', 'DESC');
		$cols = array('id', 'id_lang', 'title', 'short', 'img', 'cat_id', 'create_time', 'alias','author','news_source','details');
		return $newObj->get(null, $this->limit, $cols);
	}
	/**
	 * [getConfig description]
	 * @author Truong Nguyen
	 * @email  truongnx28111994@gmail.com
	 * @date   2015-08-21
	 * @return [type]                     [description]
	 */
	private function getConfig() {
		$newsSetting = new \Model($this->lang . '_config');
		$newsSetting->where('idw', $this->idw);
		$newsSetting->where('`key`', 'setting_home');
		$data=$newsSetting->getOne();
		$res=json_decode($data['value_string'],true);
		return $res;
	}
}