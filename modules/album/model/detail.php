<?php
/*
 * @Project BNC V2
 * @Author Lư Chí Tâm (tamlc@webbnc.vn)
 * Frontend Album Detail Model
 */
if (!defined('BNC_CODE')) {
	exit('Access Denied');
}
/**
 * detail album Model
 */
class ModelDetail {

	private $objTable, $id_field;
	private $idw;

	public $B;
	public $id;
	public $title;
	public $array;
	public $views;
	public $url_mod;

	function __construct($id_field) {
		global $_B, $web;
		$this->B        = $_B;
		$this->lang     = $_B['lang'];
		if($_B['lang']==$_B['lang_default']){
			$this->id_field = 'id';
		}else{
			$this->id_field = 'id_lang';
		}
		
		$this->url_mod  = $_B['url_mod'];
		$this->idw      = $web['idw'];
	}

	public function detailAlbum() {
		$this->objTable = new Model($this->lang . '_album');
		$this->objTable->where($this->id_field, $this->id);
		$this->objTable->where('idw', $this->idw);
		$this->objTable->where('status', 1);
		$this->objTable->where('post_time', date('Y-m-d H:i:s'), '<=');
		$data = $this->objTable->getOne();

		if ($data) {
			//$this->views = $data['views'];
			if (!empty($data['related'])) {
//lien quan tu chon
				$related_my = json_decode($data['related']); //show,show_quantity,related_order
				if ($related_my->{'show'}) {
					$data['related'] = explode(",", $related_my->{'related_list'});
					$data['related'] = array_filter($data['related']);
					$data['related'] = array_unique($data['related']);
					if (!empty($data['related'])) {
						$this->array        = $data['related'];
						$data['my_related'] = $this->getRelated($data['related'], $related_my->{'show_quantity'}, $related_my->{'related_order'});
					}

				}
			}
			if (!empty($data['related_cate'])) {
//lien quan theo danh muc
				$related_cate = json_decode($data['related_cate']); //show,show_quantity,related_order
				if ($related_cate->{'show'}) {
					$data['related_cate'] = explode(",", $data['category_id']);
					$data['related_cate'] = array_filter($data['related_cate']);
					$data['related_cate'] = array_unique($data['related_cate']);
					if (!empty($data['related_cate'])) {
						$data['cate_related'] = $this->getRelatedByCate($data['related_cate'], $related_cate->{'show_quantity'}, $related_cate->{'related_order'});
					}

				}
			}

			return $data;
		}
	}

	/*
	 * lay album lien quan tu chon
	 * @param $ids|array
	 * @param $limit|int
	 * @param $sort|int
	 */
	public function getRelated($ids, $limit, $sort) {
		$this->objTable = new Model($this->lang . '_album');
		$this->objTable->where('idw', $this->idw);
		$this->objTable->where($this->id_field, $ids, 'IN');
		$this->objTable->where('status', 1);
		$this->objTable->where('hide_by_cate', 1, '<>');
		$this->objTable->where('post_time', date('Y-m-d H:i:s'), '<=');

		$this->objTable->orderBy('id', 'DESC');
		if ($sort == 2) {
			$this->objTable->orderBy('views', 'DESC');
		}

		if ($sort == 3) {
			$this->objTable->orderBy('title', 'ASC');
		}

		$data = $this->objTable->get(null, array(0, ($limit > 50 ? 50 : $limit)), '*');

		if ($data) {
			return $data;
		}
	}
	/*
	 * lay album lien quan theo danh muc
	 * @param $ids|array
	 * @param $limit|int
	 * @param $sort|int
	 */
	public function getRelatedByCate($ids, $limit, $sort) {
		global $_B;
		$this->objTable = new Model($this->lang . '_album');
		$this->objTable->where('idw', $this->idw);
		$this->objTable->where($this->id_field, $this->id, '<>');
		if ($this->array) {
			$this->objTable->where($this->id_field, $this->array, 'NOT IN');
		}

		$this->objTable->where('status', 1);
		$this->objTable->where('hide_by_cate', 1, '<>');
		$this->objTable->where('post_time', date('Y-m-d H:i:s'), '<=');

		foreach ($ids as $k => $v) {
			$this->objTable->where('category_id', "%," . $v . ",%", 'LIKE');
		}

		$this->objTable->orderBy('id', 'DESC');
		if ($sort == 2) {
			$this->objTable->orderBy('views', 'DESC');
		}

		if ($sort == 3) {
			$this->objTable->orderBy('title', 'ASC');
		}

		$data = $this->objTable->get(null, array(0, ($limit > 50 ? 50 : $limit)), '*');
		if($_B['lang']!=$_B['lang_default']){
			foreach ($data as $k => $v) {
				$data[$k]['id']=$v['id_lang'];
			}
		}
		
		if ($data) {
			return $data;
		}
	}

	public function showCateById($id) {
		$this->objTable = new Model($this->lang . '_album_category');
		$this->objTable->where($this->id_field, $id);
		$this->objTable->where('idw', $this->idw);
		$data = $this->objTable->getOne(null, array('id', 'id_lang', 'title'));
		if ($data) {
			return $data;
		}
	}

	public function showImages() {
			
		$this->objTable = new Model($this->lang . '_album_images');
		$this->objTable->where('album_id', $this->id);
		$this->objTable->where('idw', $this->idw);
		$this->objTable->orderBy('order_by', 'ASC');
		$data = $this->objTable->get(null, null, '*');
		if ($data) {
			return $data;
		}
	}

	public function visit() {
		$this->objTable = new Model($this->lang . '_album');
		$this->objTable->where($this->id_field, $this->id);
		$this->objTable->where('idw', $this->idw);
		$data['views'] = $this->views + 1;
		$this->objTable->update($data);
		return $data['views'];
	}

	//xu ly quotes
	public function html_decode($value = '') {
		$value = htmlspecialchars_decode($value);
		$value = html_entity_decode($value, ENT_QUOTES);
		$value = str_replace('"', "", $value);
		$value = str_replace("'", "", $value);

		return $value;
	}
}

?>