<?php
/**
 * @Project BNC v2 -> Module News
 * @File info/model/info.php
 * @Author An Nguyen Huu (annh@webbnc.vn)
 * @Createdate 11/18/2014, 11:22 AM
 */
class ModelInfo {
    private $idw, $infoObj, $id_field, $lang;
    public $url_mod;
    public function __construct($id_field) {
        global $_B, $web;
        $this->lang     = $_B['lang'];
        $this->id_field = $id_field;
        $this->url_mod  = $_B['url_mod'];
        $this->idw      = $web['idw'];
        $this->infoObj  = new Model($this->lang . '_info');
    }
    public function getInfoList() {
        $this->infoObj->where('idw', $this->idw);
        $this->infoObj->where('status', 1);
        $result = $this->infoObj->get(null, null, '*');
        return $result;
    }
    public function totalInfo() {
        $this->infoObj->where('idw', $this->idw);
        $this->infoObj->where('status', 1);
        $total = $this->infoObj->num_rows();
        return $total;
    }
    public function getDetail($id) {
        $this->infoObj->where('idw', $this->idw);
        $this->infoObj->where('status', 1);
        $this->infoObj->where($this->id_field, $id);
        $result = $this->infoObj->getOne(null, '*');
        return $result;
    }
    public function setView($id, $view) {
        $data = array(
            'view' => $view,
        );
        $this->infoObj->where('idw', $this->idw);
        $this->infoObj->where($this->id_field, $id);
        return $this->infoObj->update($data);
    }
}