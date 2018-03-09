<?php
namespace module\template\blockAdvBottom;
use BlockGlobal;
use ModelAdv;

include_once DIR_MODULES . 'template/model/adv.php';
class Block extends BlockGlobal {
	public $returnData = array();
	public $lang;
	public $idw;

	public function __construct() {
		parent::__construct();
		$this->setData();
	}

	public function setData() {
		global $_B;
		$Obj                 = new ModelAdv;
		$data['content']     = $Obj->getPosition(3);
		$data['upload_path'] = $_B['upload_path'];
		$this->returnData    = $data;
	}

}
