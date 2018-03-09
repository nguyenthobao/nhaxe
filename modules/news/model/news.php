<?php
/**
 * @Project BNC v2 -> Module News
 * @File news/model/news.php
 * @author Ba Huong Nguyen (nguyenbahuong156@gmail.com)
 * @Createdate 10/27/2014, 11:22 AM
 */
if (!defined('BNC_CODE')) {
	exit('Access Denied');
}
class ModelNews {
	private $idw, $newsObj, $newsRelated, $newsSameCat, $id_field, $lang, $newsSetting;
	public function __construct($id_field) {
		global $_B, $web;
		$this->idw         = $web['idw'];
		$this->lang        = $_B['lang'];
		$this->id_field    = $id_field;
		$this->newsObj     = new Model('news.'.$this->lang . '_news');
		$this->newsSetting = new Model('news.'.$this->lang . '_config');

	}
	public function getDetail($id) {

		$this->newsObj->where('idw', $this->idw);
		$this->newsObj->where('status', 1);
		$this->newsObj->where($this->id_field, $id);
		$result = $this->newsObj->getOne(null, '*');
		if(!$_COOKIE['news_'].$id){
			$this->plusView($id,$result['views']);
			setcookie('new_'.$id,1,time()+86400,'/');
		}
		return $result;
	}

	public function plusView($id,$view)
	{
		$this->newsObj->where('idw',$this->idw);
		$this->newsObj->where($this->id_field, $id);
		$data = Array (
			'views' => $view+1,
		);
		$this->newsObj->update($data);
	}

	public function getNewsOtherCat($id, $cat_id, $limit) {

		$where  = '';
		$where2 = array();
		$select = '`id`,`id_lang`,`img`,`title`,`short`,`cat_id`,`alias`,`views`';
		$this->newsObj->where('idw', $this->idw);
		$this->newsObj->where('status', 1);
		foreach ($cat_id as $key => $value) {
			if ($key == 0) {
				$where .= 'cat_id LIKE ?';
			} else {
				$where .= ' OR cat_id LIKE ?';
			}
			$where2[] = '%,' . $value . ',%';
		}
		$this->newsObj->where('(' . $where . ')', $where2);
		$this->newsObj->where('id', $id, '!=');
		$result = $this->newsObj->get(null, array('0', $limit), $select);
		return $result;
	}

	public function getNewsOtherRelated($related_id, $limit) {
		$this->newsObj->where('idw', $this->idw);
		$this->newsObj->where('status', 1);
		$this->newsObj->where($this->id_field, $related_id, 'IN');
		$select = '`id`,`id_lang`,`img`,`title`,`short`,`cat_id`,`alias`,`views`';
		$result = $this->newsObj->get(null, array('0', $limit), $select);
		return $result;
	}

	public function getNewsByID($data) {
		if (is_array($data['id'])) {
			$this->newsObj->where($this->id_field, $data['id'], 'IN');
		} else {
			$this->newsObj->where($this->id_field, $data['id']);
		}
		$this->newsObj->where('status', 1);
		$result = $this->newsObj->get(null, array('0', $data['limit']), 'id,id_lang,img,title,cat_id,short,alias,views,author,news_source');
		return $result;

	}

	public function getSettingRelatedPrivate($id) {
		$this->newsRelated = new Model('news.'.'news_related');
		$this->newsRelated->where('idw', $this->idw);
		$this->newsRelated->where('news_id', $id);
		$this->newsRelated->where('status', 1);
		$result = $this->newsRelated->getOne(null, '*');
		return $result;
	}
	public function getSettingSameCatPrivate($id) {
		$this->newsSameCat = new Model('news.'.'news_same_category');
		$this->newsSameCat->where('idw', $this->idw);
		$this->newsRelated->where('news_id', $id);
		$this->newsSameCat->where('status', 1);
		$result = $this->newsSameCat->getOne(null, '*');
		return $result;
	}

	public function getConfig() {
		$this->newsSetting->where('idw', $this->idw);
		return $this->newsSetting->get();
	}
}