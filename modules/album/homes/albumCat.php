<?php namespace module\album\albumCat;
/*
 * @File MOD/blocks/blockCatHome.php
 * @author Hùng (hunghm@webbnc.vn)
 * @Createdate 12/10/2014, 01:01 AM
 */
Class BlockHome extends \HomeGlobal {
    /**
     * $returnData - bien chua data de xuat ra o giao dien
     *@return array
     */
    public $returnData = array();
    public $lang;
    public $idw;
    public $mod   = 'album';
    public $limit = 10;
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
        $data['home_cat'] = $this->getContentCategory();

        $this->returnData = $data;
    }
    /**
     *funntion getData;
     *gan du lieu cho returnData
     *@param
     *@return void
     */
    public function getContentCategory() {
        $select = 'id, id_lang, parent_id, title, avatar, icon, bg_image,num_show';
        $cat    = new \Model('album.' . $this->lang . '_album_category');
        $cat->where('idw', $this->idw);
        $cat->where('status', 1);
        //$cat->where('is_home', 1);
        $cat->orderBy('order_by', 'ASC');
        $cat->orderBy('id', 'DESC');
        $data = $cat->get(null, null, $select);
        $data = $this->fixArray($data);

        if (!empty($data)) {
            foreach ($data as $k => $v) {
                $data[$k]['content_album'] = $this->getAlbumHome($v['id'], $v['num_show']);
            }
        }

        return $data;
    }
    public function getAlbumHome($id, $limit) {
        global $_L;
        $data = array();
        if ($limit == 0) {
            $limit = 4;
        }
        $select = 'id, id_lang, category_id, title, avatar, contents_description, status,alias';
        $model  = new \Model('album.' . $this->lang . '_album');
        $model->where('idw', $this->idw);
        $model->where('status', 1);
        $model->where('category_id', '%,' . $id . ',%', 'like');
        $model->orderBy('order_by', 'ASC');
        $data = $model->get(null, array(0, $limit), $select);
        if (!empty($data)) {
            foreach ($data as $k => $v) {
                $cat_id            = explode(',', $v['cat_id']);
                $parent_id         = $cat_id[1];
                $data[$k]['link']  = $this->linkUrl($this->mod, 'detail', 'view', $parent_id . '_' . $v['id'], $v['alias']);
                $data[$k]['thumb'] = $v['img'];
            }
        }
        return $data;
    }
    public function fixArray($data = array(), $parrent = 0) {
        global $_B;
        $result = array();
        foreach ($data as $k => $v) {
            if ($v['parent_id'] == $parrent) {
                $result[] = $v;
                unset($data[$k]);
            }
        }
        if (sizeof($result) > 0) {
            foreach ($result as $k => $v) {
                if ($_B['lang'] != $_B['lang_default']) {
                    $v['id']          = $v['id_lang'];
                    $result[$k]['id'] = $v['id_lang'];
                }
                $tmp                = $this->fixArray($data, $v['id']);
                $result[$k]['link'] = linkUrl($this->web, $this->mod, 'category', 'album', $v['id'], $v['alias']);
                if (sizeof($tmp) > 0) {
                    $result[$k]['sub'] = $tmp;
                } else {
                    $result[$k]['sub'] = '';
                }
            }
        }
        return $result;
    }
}