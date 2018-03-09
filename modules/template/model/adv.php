<?php
if (!defined('BNC_CODE')) {
	exit('Access Denied');
}

class ModelAdv {

	function __construct() {
		global $_B, $web;
		$this->mod = 'template';
		db_connect($this->mod);
		$this->lang         = $_B['lang'];
		$this->lang_default = $_B['lang_default'];
		$this->idw          = $web['idw'];
		$this->web          = $web;
		$this->home_url     = $web['home_url'];
		$this->request      = $_B['r'];
		$this->mAF          = new Model($this->lang . '_adv_flash');
		$this->mAG          = new Model($this->lang . '_adv_ggadsense');
		$this->mAI          = new Model($this->lang . '_adv_image');
		$this->mAT          = new Model($this->lang . '_adv_text');

	}
	/**
	 * [getPosition description]
	 * @author Truong Nguyen
	 * @email  truongnx28111994@gmail.com
	 * @param  [type]                     $key [description]
	 * @return [type]                          [description]
	 */
	public function getPosition($key) {
		//Query 4 table
		$AF     = $this->getPositionF($key);
		$AG     = $this->getPositionG($key);
		$AI     = $this->getPositionI($key);
		$AT     = $this->getPositionT($key);
		$result = array_merge($AF, $AG, $AI, $AT);

		$result_ok = array();
		foreach ($result as $key => $row) {
			$result_ok[$key] = $row['sort'];
			if ($this->lang != $this->lang_default) {
				$result[$key]['id'] = $row['id_lang'];
			}
			if (isset($row['flash'])) {
				$result[$key]['flash'] = loadFlash($row['flash'], $row['width'], $row['height']);
			}
			unset($result[$k]['id_lang']);

			if ($result[$key]['finish_time'] != false) {
				//Kiem tra xem no co nho hon thoi gian ko
				if ($result[$key]['finish_time'] <= time()) {
					unset($result[$key]);
					unset($result_ok[$key]);
				}
			}

			if ($result[$key]['start_time'] != false) {
				//Kiem tra xem no co nho hon thoi gian ko
				if ($result[$key]['start_time'] > time()) {
					unset($result[$key]);
					unset($result_ok[$key]);
				}
			}

		}
		array_multisort($result_ok, SORT_ASC, $result);
		return $result;
	}

	/**
	 * [getPositionF description]
	 * @author Truong Nguyen
	 * @email  truongnx28111994@gmail.com
	 * @param  [type]                     $key [description]
	 * @return [type]                          [description]
	 */
	private function getPositionF($key) {
		$select = 'id,id_lang,flash,title,width,height,position,sort,link_GA,description,start_time,finish_time';
		$this->mAF->where('idw', $this->idw);
		$this->mAF->where('position', $key);
		$this->mAF->where('status', 1);
		/*$this->mAF->where('start_time', time(), '<=');
		$this->mAF->where('finish_time', time(), '>=');*/
		$this->mAF->orderBy('sort', 'ASC');
		$result = $this->mAF->get(null, null, $select);
		return $result;
	}
	/**
	 * [getPositionG description]
	 * @author Truong Nguyen
	 * @email  truongnx28111994@gmail.com
	 * @param  [type]                     $key [description]
	 * @return [type]                          [description]
	 */
	private function getPositionG($key) {
		$select = 'id,id_lang,code_adv,title,position,sort,link_GA,description,start_time,finish_time';
		$this->mAG->where('idw', $this->idw);
		$this->mAG->where('position', $key);
		$this->mAG->where('status', 1);
		/*	$this->mAG->where('start_time', time(), '<=');
		$this->mAG->where('finish_time', time(), '>=');*/
		$this->mAG->orderBy('sort', 'ASC');
		$result = $this->mAG->get(null, null, $select);
		return $result;
	}

	/**
	 * [getPositionI description]
	 * @author Truong Nguyen
	 * @email  truongnx28111994@gmail.com
	 * @param  [type]                     $key [description]
	 * @return [type]                          [description]
	 */
	private function getPositionI($key) {
		$select = 'id,id_lang,img,title,width,height,position,sort,link_GA,description,start_time,finish_time';
		$this->mAI->where('idw', $this->idw);
		$this->mAI->where('position', $key);
		$this->mAI->where('status', 1);
		/*$this->mAI->where('start_time', time(), '<=');
		$this->mAI->where('finish_time', time(), '>=');*/
		$this->mAI->orderBy('sort', 'ASC');
		$result = $this->mAI->get(null, null, $select);
		return $result;
	}

	/**
	 * [getPositionT description]
	 * @author Truong Nguyen
	 * @email  truongnx28111994@gmail.com
	 * @param  [type]                     $key [description]
	 * @return [type]                          [description]
	 */
	private function getPositionT($key) {
		$select = 'id,id_lang,content,title,position,sort,short,link_GA,description,start_time,finish_time';
		$this->mAT->where('idw', $this->idw);
		$this->mAT->where('position', $key);
		$this->mAT->where('status', 1);
		/*$this->mAT->where('start_time', time(), '<=');
		$this->mAT->where('finish_time', time(), '>=');*/
		$this->mAT->orderBy('sort', 'ASC');
		$result = $this->mAT->get(null, null, $select);
		return $result;
	}

}