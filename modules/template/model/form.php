<?php
if (!defined('BNC_CODE')) {
	exit('Access Denied');
}

class ModelForm {

	function __construct() {
		global $_B, $web;
		$this->mod = 'template';
		db_connect($this->mod);
		$this->lang         = $_B['lang'];
		$this->lang_default = $_B['lang_default'];
		$this->idw          = $web['idw'];
		$this->web          = $web;
		$this->home_url     = $web['home_url'];
		$this->request      = $_B['r'];
		$this->mF           = new Model('data_formcustom');
		$this->mEF           = new Model($this->lang.'_email_form');
		$this->mFC= new Model($this->lang.'_formcustom');

	}
	/**
	 * [saveForm description]
	 * @author Truong Nguyen
	 * @email  truongnx28111994@gmail.com
	 * @date   2015-05-27
	 * @param  [type]                     $data [description]
	 * @return [type]                           [description]
	 */
	public function saveForm($data) {
		$result = $this->mF->insert($data);
		return $result;
	}

	/**
	 * [getMailForm description]
	 * @author Truong Nguyen
	 * @email  truongnx28111994@gmail.com
	 * @date   2015-09-24
	 * @param  [type]                     $id_form [description]
	 * @return [type]                              [description]
	 */
	public function getMailForm($id_form)
	{
		$this->mEF->where('idw',$this->idw);
		$this->mEF->where('id_form',$id_form);
		return $this->mEF->get(null,null,'email,name');
	}

	/**
	 * [getFieldForm description]
	 * @author Truong Nguyen
	 * @email  truongnx28111994@gmail.com
	 * @date   2015-09-24
	 * @param  [type]                     $id_form [description]
	 * @return [type]                              [description]
	 */
	public function getFieldForm($id_form)
	{
		$this->mFC->where('idw',$this->idw);
		$this->mFC->where('id',$id_form);
		return $this->mFC->getOne(null,'title,field');
	}
}