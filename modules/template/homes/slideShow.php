<?php
namespace module\template\slideShow;
use HomeGlobal;
use ModelSlide;

include_once DIR_MODULES . 'template/model/slide.php';

Class BlockHome extends HomeGlobal {
	public $returnData = array();
	public $lang;
	public $idw;

	public function __construct() {
		parent::__construct();
		$this->setData();
	}

	public function setData() {
		$Obj              = new ModelSlide;
		$data['slides']   = $Obj->slide(1);
		$data['slides']   = null;
		
		$this->returnData = $data;
	}
}