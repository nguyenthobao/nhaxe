<?php
namespace module\template\blockSupport;
use BlockGlobal;

class Block extends BlockGlobal {
	public $returnData = array();
	public function __construct() {
		parent::__construct();
		$this->setData();
	}

	public function setData() {
		$data=$block;
		$this->returnData = $data;
	}
	
	
}
