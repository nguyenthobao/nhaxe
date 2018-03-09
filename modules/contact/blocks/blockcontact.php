<?php namespace module\contact\blockcontact;

Class Block extends \BlockGlobal{
		public $returnData = array();
		public $lang;
		public $idw;
		public $request;///?
		public $action_block; //?
		public $r; //?
		public $mod ='contact';

	public function __construct(){
		global $_B,$web;
		$this->lang = $_B['lang'];
		$this->idw = $web['idw'];
		db_connect($this->mod);
		$this->setData();
		
		
	}

	public function setData(){
		$this->conObj = new \Model($this->lang.'_contactinfo');
		$this->conObj->where('idw',$this->idw);
		$this->conObj->where('status',1);
		$select 	= 'info';
		$result = $this->conObj->getone(null,null,$select);
		$this->returnData = $result;
	}

} 