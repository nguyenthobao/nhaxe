<?php
namespace module\template\blockTags;
use BlockGlobal;
include DIR_MODULES . 'template/model/tags.php';
use ModelTagsBlock;
class Block extends BlockGlobal {
	public $returnData = array();
	public $lang;
	public $idw;

	public function __construct() {
		parent::__construct();
		$this->setData();
	}

	public function setData() {
		global $_B,$web;

		$Obj                 = new ModelTagsBlock;
		$data['content']     = $Obj->getTags();
		$this->returnData    = $data;
	}

}
