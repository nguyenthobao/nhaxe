<?php
namespace module\news\newsCatHome;
/*
 * @File MOD/blocks/blockCatHome.php
 * @author An Nguyen Huu (annh@webbnc.vn)
 * @Createdate 12/10/2014, 01:01 AM
 */
Class BlockHome extends \HomeGlobal {
    /**
     * $returnData - bien chua data de xuat ra o giao dien
     *@return array
     */
    public $returnData = array();
    /**
     * @var mixed
     */
    public $lang;
    /**
     * @var mixed
     */
    public $idw;
    /**
     * @var string
     */
    public $mod = 'news';
    public function __construct() {
        global $_B, $web;
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
        $select = 'id, id_lang, parent_id, title, description, img, icon, bg, number_home,alias';
        $cat    = new \Model($this->lang . '_category');
        $cat->where('idw', $this->idw);
        $cat->where('status', 1);
        $cat->where('is_home', 1);
        $cat->orderBy('sort', 'ASC');
        //$cat->orderBy('create_time', 'DESC');
        $data = $cat->get(null, null, $select);
        $data = $this->fixArray($data);
        if (!empty($data)) {
            foreach ($data as $k => $v) {
                if ($this->lang != 'vi') {
                    $data[$k]['content_news'] = $this->getNewsHome($v['id_lang'], $v['number_home']);
                } else {
                    $data[$k]['content_news'] = $this->getNewsHome($v['id'], $v['number_home']);
                }
            }
        }

        return $data;
    }
    /**
     * @param $id
     * @param $limit
     * @return mixed
     */
    public function getNewsHome($id, $limit) {
        global $_L;
        $data = array();
        if ($limit == 0) {
            $limit = 4;
        }

        $select = 'id, id_lang, cat_id, title, img, short, status, create_time,alias,author,news_source,sort';
        $model  = new \Model($this->lang . '_news');
        $model->where('idw', $this->idw);
        $model->where('status', 1);
        $model->where('cat_id', '%,' . $id . ',%', 'like');
        if ($this->idw == 2548 || $this->idw == 1406) {
            $model->orderBy('sort', 'ASC');
        } else {
            $model->orderBy('create_time', 'DESC');
        }
        $data = $model->get(null, array(0, $limit), $select);
        if (!empty($data)) {
            foreach ($data as $k => $v) {
                $cat_id    = explode(',', $v['cat_id']);
                $parent_id = $cat_id[1];
                if ($this->lang != 'vi') {
                    $v['id'] = $v['id_lang'];
                }
                $data[$k]['link']        = $this->linkUrl($this->mod, 'detail', 'view', $parent_id . '_' . $v['id'], $v['alias']);
                $data[$k]['thumb']       = $this->loadImage($v['img'], 'resize', 200, 180);
                $data[$k]['create_time'] = date("H:i:s d-m-Y", $v['create_time']);
            }
        }
        // if($_COOKIE['sv']){
        //     echo '<pre>';
        //     print_r($data);
        //     echo '</pre>';

        // }

        return $data;
    }
    /**
     * @param array $data
     * @param $parrent
     * @return mixed
     */
    public function fixArray($data = array(), $parrent = 0) {
        $result = array();
        foreach ($data as $k => $v) {
            if ($v['parent_id'] == $parrent) {
                $result[] = $v;
                unset($data[$k]);
            }
        }
        if (sizeof($result) > 0) {
            foreach ($result as $k => $v) {
                if ($this->lang != 'vi') {
                    $v['id'] = $v['id_lang'];
                }
                $tmp                = $this->fixArray($data, $v['id']);
                $result[$k]['link'] = $this->linkUrl($this->mod, 'news', 'cat', $v['id'], $v['alias']);
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