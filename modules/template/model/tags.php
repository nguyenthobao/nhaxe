<?php
if (!defined('BNC_CODE')) {
	exit('Access Denied');
}

class ModelTagsBlock {

	function __construct() {
		global $_B, $web;
		$this->mod = 'contact';
		db_connect($this->mod);
		$this->lang         = $_B['lang'];
		$this->lang_default = $_B['lang_default'];
		$this->idw          = $web['idw'];
		$this->web          = $web;
		$this->home_url     = $web['home_url'];
		$this->request      = $_B['r'];
		$this->mT           = new Model('tags');
	}

	public function getTags() {
		global $_B;
		$this->mT->where('idw',$this->idw);
		$this->mT->where('tag','','!=');
		$res=$this->mT->get(null,50,'*');
		foreach ($res as $k => $v) {
			if($v['alias']==''){
				unset($res[$k]);
			}else{
				$v['link']='http://'.$_B['curDomain'].'/tag/'.$v['alias'];
				$res[$k]=$v;
			}
		}
		return $res;
	}

	
}