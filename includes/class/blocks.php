<?php
/**
 * @File uncludes/class/blocks.php
 *@author Quang Chau Tran (quangchauvn@gmail.com)
 * @Createdate 12/02/2014, 08:53 AM
 */
class BlockGlobal {
	public $idw;
	public $lang;
	public function __construct() {
		global $_B, $web;
		$this->lang = $_B['lang'];
		$this->idw  = $web['idw'];
	}
	public function getReturnData() {
		//$this->setData();
		return $this->returnData;
	}
	public function linkUrl($mod, $page=null, $sub = null, $id = null, $alias = null, $notRewrite = null) {
		global $_B, $web;
		return linkUrl($web, $mod, $page, $sub, $id, $alias, $notRewrite);
	}
	public function loadModel($model) {
		$file = DIR_MODULES . $this->mod . "/model/" . $model . ".php";
		if (file_exists($file)) {
			include_once $file;
			$class = 'Model' . preg_replace('/[^a-zA-Z0-9]/', '', $model);
			return new $class($this->id_field);
		} else {
			trigger_error('Error: Không thể load model ' . $model . '!');
		}

	}
	public function loadImage($img, $op = 'resize', $width = null, $height = null) {
		global $_B;
		return loadImage($img, $op, $width, $height);
	}

}