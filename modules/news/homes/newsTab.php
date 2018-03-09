<?php namespace module\news\newsTab;
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
	// public $limit = 6;
	public $mod = 'news';
	public function __construct() {
		global $_B, $web, $mod;
		$this->lang = $_B['lang'];
		$this->idw  = $web['idw'];
		//db_connect($this->mod);
		$this->setData();
	}
	/**
	 *funntion setData;
	 *gan du lieu cho returnData
	 *@param
	 *@return void
	 */
	private function setData() {
		$data['config'] = $this->getConfig();
		$data['config'] = $this->ModifyConfig($data['config']);
		if($data['config']['status_new']!=false){
			$data['new']    = $this->getNew('new', $data['config']['quantity_new']);
			$data['new']    = $this->ModifyNew($data['new']);
		}
		if($data['config']['status_hot']!=false){
			$data['hot']    = $this->getNew('hot', $data['config']['quantity_hot']);
			$data['hot']    = $this->ModifyNew($data['hot']);
		}
		if($data['config']['status_vip']!=false){
			$data['vip']    = $this->getNew('vip', $data['config']['quantity_vip']);
			$data['vip']    = $this->ModifyNew($data['vip']);
		}
		
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
	private function ModifyConfig($data) {
		foreach ($data as $key => $value) {
			if ($value['key'] == 'setting_home') {
				$data_config = json_decode($value['value_string'], 1);
			}
		}
		return $data_config;
	}

	private function getConfig() {
		$newConfig = new \Model($this->lang . '_config',db_connect('news'));
		$newConfig->where('idw', $this->idw);
		return $newConfig->get(null, null, '`key`,`value_string`');
	}
	private function getNew($type, $limit) {
		$cols = array('id', 'id_lang', 'title', 'short', 'img', 'cat_id', 'create_time', 'alias','author','news_source','details');
		$newObj = new \Model($this->lang . '_news',db_connect('news'));
		$newObj->where('idw', $this->idw);
		$newObj->where('status', 1);
		if ($type == 'new') {
			$newObj->orderBy('create_time', 'DESC');
			return $newObj->get(null, $limit, $cols);
		}
		if ($type == 'hot') {
			$newObj->where('is_hot', 1);
			$newObj->orderBy('create_time', 'DESC');
			return $newObj->get(null, $limit, $cols);
		}
		if ($type == 'vip') {
			$newObj->where('is_vip', 1);
			$newObj->orderBy('create_time', 'DESC');
			$res=$newObj->get(null, $limit, $cols);
			return $res;
		}

	}
}