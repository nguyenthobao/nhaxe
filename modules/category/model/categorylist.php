<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /model/categorylist.php
 * @Author Hùng (hungdct1083@gmail.com)
 * @Createdate 08/21/2014, 14:31 PM
 */
if (!defined('BNC_CODE')) {
	exit('Access Denied');
}

class CategoryList extends GlobalCategory {
	public $idw, $catego, $r, $lang;
	public function __construct() {
		global $_B;
		$this->r        = $_B['r'];
		$this->idw      = $_B['web']['idw'];
		$this->lang     = $_B['cf']['lang'];
		$this->lang_use = $_B['cf']['lang_use'];
	}
	public function activeStatusCategory() {
		global $_B;
		$getLangAndID = getLangAndID();
		$this->catego = new Model($getLangAndID['lang'] . '_category');
		$status       = $this->r->get_string('status', 'POST');
		$id           = $this->r->get_int('key', 'POST');
		$update       = array('status' => $status, 'update_time' => time());
		if ($getLangAndID['lang'] != 'vi') {
			$this->catego->where('idw', $this->idw);
			$this->catego->where($getLangAndID['field_id'], $id);
			$result = $this->catego->update($update);
			//$result = $this->getCategoryByParent($id);
		} else {
			$this->catego->where('idw', $this->idw);
			$this->catego->where('id', $id);
			$result = $this->catego->update($update);
		}

	}
	public function deleteMulti() {
		global $_B;
		$result       = array();
		$getLangAndID = getLangAndID();
		$daiid        = $this->r->get_array('key', 'POST');
		if ($getLangAndID['lang'] != 'vi') {
			$this->catego = new Model($getLangAndID['lang'] . '_category');
			foreach ($daiid as $k => $v) {
				$this->catego->where($getLangAndID['field_id'], $v);
				$this->catego->where('idw', $this->idw);
				$this->catego->delete();
				$result[] = $v;
			}
		} else {
			//$this->catVideoObj = new Model($getLangAndID['lang'].'_video');
			$language = explode(',', $this->lang_use);
			foreach ($daiid as $k => $v) {
				if (!empty($language)) {
					foreach ($language as $key => $value) {
						$this->catego = new Model($value . '_category');
						$this->catego->where('idw', $this->idw);
						$this->catego->where($this->get_lang_id($value), $v);
						$this->catego->delete();

					}
				}
				$result[] = $v;

			}
		}

		echo implode(",", $result);

	}

	public function deleteCategory() {
		$id           = $this->r->get_int('key', 'POST');
		$getLangAndID = getLangAndID();

		if ($getLangAndID['lang'] != 'vi') {
			$this->catego = new Model($getLangAndID['lang'] . '_category');
			$this->catego->where('idw', $this->idw);
			$this->catego->where($getLangAndID['field_id'], $id);
			$this->catego->delete();

		} else {
			$language = explode(',', $this->lang_use);
			if (!empty($language)) {
				foreach ($language as $k => $v) {
					$this->catego = new Model($v . '_category');
					$this->catego->where('idw', $this->idw);
					$this->catego->where($this->get_lang_id($v), $id);
					$this->catego->delete();
					//$result[]=$v;
				}
			}

		}
		//return $result;

	}

	public function getCatCategory($value = null) {

		$getLangAndID = getLangAndID();
		$this->catego = new Model($getLangAndID['lang'] . '_category');

		if ($value['action'] == 'searchCategory') {
			$value['cat_title'] = trim($value['cat_title']);
			if (($value['status_cat'] != '') and ($value['status_cat'] != 'default')) {
				$this->catego->where('status', $value['status_cat']);
			}
			if ($value['cat_title'] != '') {

				$this->catego->Where('title', '%' . $value['cat_title'] . '%', 'like');
			}
		}
		$this->catego->where('idw', $this->idw);
		$total = $this->catego->num_rows();

		$max    = 10;
		$maxNum = 5;
		if ($value['action'] == 'searchCategory') {
			$url = 'category-categorylist-lang-' . $getLangAndID['lang'] . '-value-' . $_GET['value'];
		} else {
			$url = 'category-categorylist-lang-' . $getLangAndID['lang'];
		}
		$url  = 'category-categorylist-lang-' . $getLangAndID['lang'];
		$page = pagination($max, $total, $maxNum, $url);

		$start      = $page['start'];
		$pagination = $page['pagination'];
		$select     = '`id`,`id_lang`,`title`,`status`';

		$this->catego->where('idw', $this->idw);
		if ($value['action'] == 'searchCategory') {

			if (($value['status_cat'] != '') and ($value['status_cat'] != 'default')) {
				$this->catego->where('status', $value['status_cat']);
			}
			if ($value['cat_title'] != '') {
				$this->catego->Where('title', '%' . $value['cat_title'] . '%', 'like');
			}
		}
		$this->catego->orderBy('id', 'DESC');
		$result['data'] = $this->catego->get(null, array($start, $max), $select);
		if ($getLangAndID['lang'] != 'vi') {
			foreach ($result['data'] as $k => $v) {
				$v['id']            = $v['id_lang'];
				$result['data'][$k] = $v;
			}
		}
		if ($total > 10) {
			$result['pagination'] = $pagination;
		}

		return $result;

	}

	public function editTitleCategory() {
		$id    = $this->r->get_int('pk', 'POST');
		$title = $this->r->get_string('value', 'POST');
		$title = strip_tags($title);
		$title = trim($title);
		//Cắt bỏ chuỗi -- đằng trước của danh mục.
		$rule = "/([^-+\s]).+$/";
		//$rule="";
		if (!empty($title)) {
			preg_match($rule, $title, $pr_title);

			$getLangAndID = getLangAndID();
			$this->catego = new Model($getLangAndID['lang'] . '_category');
			$this->catego->where($getLangAndID['field_id'], $id);
			$this->catego->where('idw', $this->idw);
			$result = $this->catego->update(array('title' => $pr_title[0], 'update_time' => time()));
		}

	}
	public function copyCate() {
		global $_B;
		$getLangAndID = getLangAndID();
		$this->catego = new Model($getLangAndID['lang'] . '_category');
		$daiid        = $this->r->get_array('key', 'POST');
		//print_r($daiid);
		if ($daiid) {
			$this->catego->where($getLangAndID['field_id'], $daiid, 'IN');
			$this->catego->where('idw', $this->idw);
			$data = $this->catego->get(null, null, '*');
			//print_r($data);
			foreach ($data as $key => $value) {
				$timeCopy = date('H:i:s d-m');
				$value['title'] .= ' - Copy - ' . $timeCopy;
				$imp = array(
					'idw'              => $this->idw,
					'title'            => $value['title'],
					'short'            => $value['short'],
					'status'           => $value['status'],
					'details'          => $value['details'],
					'meta_title'       => $value['meta_title'],
					'meta_keyword'     => $value['meta_keyword'],
					'meta_description' => $value['meta_description'],
					'create_uid'       => $_B['uid'],
					'create_time'      => time(),
				);
				$latest_id = $this->catego->insert($imp);

			}
		}
	}

}