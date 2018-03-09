<?php
namespace module\template\blockSlideRight;
use BlockGlobal;
use ModelSlide;

include_once DIR_MODULES . 'template/model/slide.php';
class Block extends BlockGlobal {
	public $returnData = array();
	public $lang;
	public $idw;

	public function __construct() {
		parent::__construct();
		$this->setData();
	}

	public function setData() {
		$Obj  = new ModelSlide;
		$data = $Obj->slide(2);
		
		if (!is_array($data) == '') {
			$data = $Obj->slide(7); //Cho a Nam
		}
		$this->returnData = $data;
	}

}
