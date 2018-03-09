<?php
namespace module\template\slideShow;
use HomeGlobal;

include_once DIR_MODULES . 'template/model/slide.php';

Class BlockHome extends HomeGlobal {
	/**
	 * $returnData - bien chua data de xuat ra o giao dien
	 *@return array
	 */
	public $returnData = array();
	public $lang;
	public $idw;
	public $limit = 1;
	public $mod   = 'template';
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
		global $web;
		$data['slides'] = $this->getSlide();
		$data['slides'] = $this->ModifySlide($data['slides']);
		// $data['slide'] = $web['slide'];
		// echo "<pre>";
		// echo $web['slide'];
		// die();
		$this->returnData = $data;
		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";
	}

	private function ModifySlide($data) {
		$result = array();
		foreach ($data as $slide) {
			$images   = $this->getImageBySlide($slide['id']);
			$result[] = array(
				'id'          => $slide['id'],
				'title'       => $slide['title'],
				'description' => $slide['description'],
				'position'    => $slide['position'],
				// 'meta_title' => $slide['meta'],
				'image_slide' => $images,
			);
		}
		return $result;
	}

	/**
	 *funntion getData;
	 *gan du lieu cho returnData
	 *@param
	 *@return void
	 */
	private function getSlide() {

		$slideObj = new \Model($this->lang . '_slide');
		$slideObj->where('idw', $this->idw);
		$slideObj->where('status', 1);
		$slideObj->where('position', 1);
		$slideObj->orderBy('sort', 'ASC');
		$results = $slideObj->get(null, $this->limit, '*');

		return $results;
	}

	//Hàm lấy ảnh trong slide
	private function getImageBySlide($id) {
		$slideImageObj = new \Model($this->lang . '_slide_image');
		$slideImageObj->where('idw', $this->idw);
		$slideImageObj->where('status', 1);
		$slideImageObj->where('slide_id', $id);
		$slideImageObj->orderBy('sort', 'ASC');
		$results = $slideImageObj->get(null, null, '*');
		$data    = array();
		foreach ($results as $result) {
			// $image = loadImage($result['src_link']);
			$data[] = array(
				'id'          => $result['id'],
				'idw'         => $result['idw'],
				'id_lang'     => $result['id_lang'],
				'src_link'    => $result['src_link'],
				'title'       => $result['title'],
				'description' => $result['description'],
				'width'       => ($result['width'] == 0) ? 'null' : $result['width'],
				'height'      => ($result['height'] == 0) ? 'null' : $result['height'],
				'link'        => $result['link'],
			);
		}
		return $data;
	}
}