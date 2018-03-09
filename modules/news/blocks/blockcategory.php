<?php namespace module\news\blockcategory;
/**
 * @File MOD/blocks/blockcategory.php
 * @author An Nguyen Huu (annh@webbnc.vn)
 * @Createdate 12/10/2014, 08:53 PM
 */
Class Block extends \BlockGlobal {
    /**
     * $returnData - bien chua data de xuat ra o giao dien
     *@return array
     */
    public $returnData = array();
    public $lang;
    public $idw;
    public $mod = 'news';
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
        $data = $this->getCategory();
       
        $this->returnData = $data;
    }
    /**
     *funntion getData;
     *gan du lieu cho returnData
     *@param
     *@return void
     */
    private function getCategory() {
        global $_B;
        $newObj = new \Model('news.'.$this->lang . '_category');
        $newObj->where('idw', $this->idw);
        $newObj->where('status', 1);
        $newObj->orderBy('sort', 'ASC');
        //$newObj->orderBy('create_time', 'DESC');
        $cols   = array('id', 'id_lang', 'title', 'description', 'img', 'icon', 'bg', 'parent_id', 'alias');
        $result = $newObj->get(null, null, $cols);
        if ($_B['lang'] != $_B['lang_default']) {
            foreach ($result as $k => $v) {
                $v['id']    = $v['id_lang'];
                $result[$k] = $v;
            }
        }
        $dataCat = $this->getCategoryChild($result);
        if ($dataCat) {
            return $dataCat;
        }
    }
    private function getCategoryChild($data = array(), $parent = 0) {
        global $_B, $web;
        $current = array();
        if (is_array($data)) {
            foreach ($data as $key => $val) {
                if ($val['parent_id'] == $parent) {
                    $current[] = $val;
                    unset($data[$key]);
                }
            }
        }
        if (sizeof($current) > 0) {
            foreach ($current as $k => $v) {
                $current[$k]['title'] = $v['title'];
                $current[$k]['sub']   = $this->getCategoryChild($data, $v['id']);
                if ($parent != 0) {
                    $current[$k]['link'] = linkUrl($web, $this->mod, 'category', 'cat', $parent . '_' . $v['id'], $v['alias']);
                } else {
                    $current[$k]['link'] = linkUrl($web, $this->mod, 'category', 'cat', $v['id'], $v['alias']);
                }
                if ($v['img']) {
                    $current[$k]['img'] = $v['img'];
                }
                if ($v['icon']) {
                    $current[$k]['icon'] = $v['icon'];
                }
                if ($v['bg']) {
                    $current[$k]['bg'] = $v['bg'];
                }
            }
        }
        return $current;
    }
}