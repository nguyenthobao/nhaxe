<?php namespace module\album\albumTab;
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
		global $_B, $web, $mod;
		$this->lang = $_B['lang'];
		$this->idw  = $web['idw'];
		$this->setData();
		include_once DIR_MODULES . $this->mod . '/lang/' . $this->lang . '/main.php';
	}
	/**
	 *funntion setData;
	 *gan du lieu cho returnData
	 *@param
	 *@return void
	 */
	private function setData() {
		$data['new']      = $this->getAlbum('new');
		$data['hot']      = $this->getAlbum('hot');
		$data['vip']      = $this->getAlbum('vip');
		$data['new']      = $this->ModifyAlbum($data['new']);
		$data['hot']      = $this->ModifyAlbum($data['hot']);
		$data['vip']      = $this->ModifyAlbum($data['vip']);
		
		$this->returnData = $data;
	}
	private function ModifyAlbum($data) {
		foreach ($data as $key => $value) {

			$data[$key]['link'] = $this->linkUrl($this->mod, 'detail', 'view', $value['id'], $value['alias']);

			$data[$key]['thumb'] = $value['img'];
		}
		return $data;
	}
	/**
	 *funntion getData;
	 *gan du lieu cho returnData
	 *@param
	 *@return void
	 */
	private function getAlbum($type) {
		$videoObj = new \Model('album.'.$this->lang . '_album');
		$videoObj->where('idw', $this->idw);
		$videoObj->where('status', 1);
		//$videoObj->where('is_vip',1);
		if ($type == 'new') {
			$videoObj->orderBy('id', 'DESC');
		} else if ($type == 'vip') {
			$videoObj->orderBy('id', 'DESC');
			$videoObj->where('album_vip', 1);
		} else {
			$videoObj->orderBy('id', 'DESC');
			$videoObj->where('album_hot', 1);
		}
		$cols = array('*');
		return $videoObj->get(null, $this->limit, $cols);
	}
}