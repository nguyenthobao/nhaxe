<?php namespace module\category\blockCategory;
/**
 * @File MOD/blocks/info.php
 *@author An Nguyen Huu (annh@webbnc.vn)
 * @Createdate 12/02/2014, 08:53 AM
 */
//Class Block extends BlockGlobal{
Class Block extends \BlockGlobal {
    /**
     * $returnData - bien chua data de xuat ra o giao dien
     *@return array
     */
    public $returnData = array();
    public $lang;
    public $idw;
    public $mod = 'category';
    public function __construct() {
        global $_B, $web, $mod;
        $this->lang = $_B['lang'];
        $this->idw  = $web['idw'];
        db_connect($this->mod);
        $this->setData();
    }
    /**
     *funntion setData;
     *gan du lieu cho returnData
     *@param
     *@return void
     */
    public function setData() {
        $data             = $this->getCategory();
        $data             = $this->ModifyCategory($data);
        $this->returnData = $data;
    }
    private function ModifyCategory($data) {
        global $_B;
        foreach ($data as $key => $value) {
            if ($_B['lang'] != $_B['lang_default']) {
                $data[$key]['id'] = $value['id_lang'];
            }
            $data[$key]['link'] = $this->linkUrl('category', 'detail', 'view', $value['id'], $value['alias']);
        }
        return $data;
    }
    /**
     *funntion getData;
     *gan du lieu cho returnData
     *@param
     *@return void
     */
    private function getCategory() {

        $infoObj = new \Model($this->lang . '_category');
        $infoObj->where('idw', $this->idw);
        $infoObj->where('status', 1);
        $infoObj->orderBy('id', 'DESC');
        $cols = array('id', 'id_lang', 'title', 'short', 'alias');
        $res  = $infoObj->get(null, 5, $cols);

        return $res;
    }
}