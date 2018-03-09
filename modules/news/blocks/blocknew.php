<?php namespace module\news\blocknew;
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
    public $limit = 10;
    public $mod   = 'news';
    public function __construct() {
        global $_B, $web;
        $this->lang = $_B['lang'];
        $this->idw  = $web['idw'];
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
        foreach ($data as $key => $value) {
            $cat_id                    = explode(',', $value['cat_id']);
            $parent_id                 = $cat_id[1];
            $data[$key]['link']        = $this->linkUrl('news', 'detail', 'view', $parent_id . '_' . $value['id'], $value['alias']);
            $data[$key]['thumb']       = $value['img'];
            $data[$key]['create_time'] = date("H:i:s d-m-Y", $value['create_time']);
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
        global $_B, $web;
        $newObj = new \Model('news.' . $this->lang . '_news');
        $newObj->where('idw', $this->idw);
        $newObj->where('status', 1);
        $newObj->orderBy('create_time', 'DESC');
        $cols = array('id', 'title', 'short', 'img', 'cat_id', 'create_time', 'alias', 'views', 'id_lang');
        $res  = $newObj->get(null, $this->limit, $cols);
        foreach ($res as &$v) {
            if ($_B['lang'] != $_B['lang_default']) {
                $v['id'] = $v['id_lang'];
            }
            $tmp_cat = array_filter(array_values(explode(',', $v['cat_id'])));
            if (!empty($tmp_cat)) {
                $tmp_cat_arrs = $this->getCategory($tmp_cat);
                foreach ($tmp_cat_arrs as $kc => $vc) {
                    $tmp_cat_arrs[$kc]['link'] = linkUrl($web, 'news', 'category', 'cat', $vc['id'], $vc['alias']);
                }
                $v['cat'] = $tmp_cat_arrs;
            }

        }

        return $res;
    }

    private function getCategory($arrs) {

        $newObj = new \Model('news.' . $this->lang . '_category');
        $newObj->where('idw', $this->idw);
        $newObj->where('status', 1);
        $newObj->where('id', $arrs, 'IN');
        $cols = array('id', 'title','alias');
        $res  = $newObj->get(null, null, $cols);
        return $res;
    }
}