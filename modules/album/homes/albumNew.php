<?php namespace module\album\albumNew;
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
				$value['id']=$value['id_lang'];
				$data[$key]['id']=$value['id_lang'];
			}
			$cat_id    = array_values(array_filter(explode(',', $value['category_id'])));
			$parent_id = $cat_id[0];
			if (!empty($parent_id)) {
				$data[$key]['link'] = $this->linkUrl($this->mod, 'detail', 'view', $parent_id . '_' . $value['id'], $value['alias']);
			} else {
				$data[$key]['link'] = $this->linkUrl($this->mod, 'detail', 'view', $value['id'], $value['alias']);
			}

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
		//$newObj->where('album_vip', 1);
		$newObj->orderBy('id', 'DESC');
		// $newObj->orderBy('update_time', 'DESC');
		$cols = array('id', 'title', 'contents_description', 'avatar', 'category_id', 'alias','id_lang');
		return $newObj->get(null, $this->limit, $cols);
	}
}