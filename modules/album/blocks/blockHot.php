<?php namespace module\album\blockHot;
/**
 * @File MOD/blocks/new.php
 *@author Quang Chau Tran (quangchauvn@gmail.com)
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
    public $mod = 'album';
    public $limit;
    public function __construct() {
        global $_B, $web;
        $this->limit = 5;
        if ($web['idw']== 5660) {
            $this->limit = 12;
        }
        $this->lang  = $_B['lang'];
        $this->idw   = $web['idw'];
        $this->setData();
    }
    /**
     *funntion setData;
     *gan du lieu cho returnData
     *@param
     *@return void
     */
    public function setData() {
        $data             = $this->getNew();
        $data             = $this->ModifyNew($data);
        $this->returnData = $data;
    }
    private function ModifyNew($data) {
        global $_B;
        foreach ($data as $key => $value) {
            if ($_B['lang'] != $_B['lang_default']) {
                $data[$key]['id'] = $value['id'] = $value['id_lang'];
            }
            $cat_id              = explode(',', $value['category_id']);
            $parent_id           = $cat_id[1];
            $data[$key]['link']  = $this->linkUrl('album', 'detail', 'view', $value['id'], $value['alias']);
            $data[$key]['thumb'] = $this->loadImage($value['avatar'], 'crop', 200, 180);
        }
        return $data;
    }
    /**
     *funntion getData;
     *gan du lieu cho returnData
     *@param
     *@return void
     */
    private function getNew() {
        global $web;
        if ($web['idw'] == 3365) {
            $this->limit = 9;
        }
        if ($web['idw'] == 3665) {
            $this->limit = 8;
        }
        if ($web['idw']== 4547) {
            $this->limit = 10;
        }
        
        $newObj = new \Model('album.' . $this->lang . '_album');
        $newObj->where('idw', $this->idw);
        $newObj->where('status', 1);
        $newObj->where('album_hot', 1);
        $newObj->orderBy('order_by', 'ASC');
        $cols = array('id', 'title', 'id_lang', 'contents_description', 'avatar', 'category_id', 'alias');
        return $newObj->get(null, $this->limit, $cols);
    }
}