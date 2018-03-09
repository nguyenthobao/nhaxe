<?php
/*
 * @Project BNC V2
 * @Author Lư Chí Tâm (tamlc@webbnc.vn)
 * Frontend Album Home Model
 */
if (!defined('BNC_CODE')) {
    exit('Access Denied');
}
/**
 * album Model
 */
class ModelHome {

    private $objTable;
    private $id_field;
    private $idw;

    public $B;
    public $sortLink;
    public $title;
    public $order_by = 'new';
    public $start;
    public $limit;
    public $category;
    public $total;
    public $home;
    public $dotEx;
    public $id_field_public;
    public $url_mod;

    function __construct($id_field) {
        global $_B, $web;
        $this->B            = $_B;
        $this->lang         = $_B['lang'];
        $this->lang_default = $_B['lang_default'];
        $this->id_field     = $this->id_field_public     = $id_field;
        $this->home         = $web['home'];
        $this->idw          = $web['idw'];
        $this->url_mod      = $_B['url_mod'];
        $this->dotEx        = $web['dotExtension'];
    }

    /*
     * show album
     */
    public function showAlbum() {
        $select         = array('id', 'id_lang', 'title', 'status', 'avatar', 'category_id', 'order_by', 'post_time', 'views', 'contents_description', 'alias');
        $this->objTable = new Model($this->lang . '_album');
        //paging
        $this->objTable->where('idw', $this->idw);
        if ($this->category != '') {
            $this->objTable->where('category_id', "%," . $this->category . ",%", 'LIKE');
        }

        if ($this->title != '') {
            $this->objTable->where('title', "%" . $this->title . "%", 'LIKE');
        }

        $this->objTable->where('post_time', date('Y-m-d H:i:s'), '<=');
        $this->objTable->where('status', 1);
        $this->objTable->where('hide_by_cate', 1, '<>');
        $this->total = $this->objTable->num_rows();
        //paging end*/

        $this->objTable->where('idw', $this->idw);
        if ($this->category != '') {
            $this->objTable->where('category_id', "%," . $this->category . ",%", 'LIKE');
        }

        if ($this->title != '') {
            $this->objTable->where('title', "%" . $this->title . "%", 'LIKE');
        }

        $this->objTable->where('post_time', date('Y-m-d H:i:s'), '<=');
        $this->objTable->where('status', 1);
        //$this->objTable->where('hide_by_cate', 1, '<>');

        if ($this->order_by == 'new' && $_GET['sort'] == 'new') {
            $this->objTable->orderBy($this->id_field, 'DESC');
        } elseif ($this->order_by == 'hot') {
            $this->objTable->orderBy('views', 'DESC');
        } elseif ($this->order_by == 'az') {
            $this->objTable->orderBy('title', 'ASC');
        } else {
            $this->objTable->orderBy('order_by', 'ASC');
        }

        $limit = array($this->start, $this->limit);
        $data  = $this->objTable->get(null, ($limit != '' ? $limit : 20), $select);

        if ($data) {
            if ($this->lang != $this->lang_default) {
                foreach ($data as $k => $v) {
                    $data[$k]['id'] = $v['id_lang'];
                }
            }
            return $data;
        }
    }

    public function showCateById($id) {
        $this->objTable = new Model($this->lang . '_album_category');
        $this->objTable->where($this->id_field, $id);
        $this->objTable->where('idw', $this->idw);
        $data = $this->objTable->getOne(null, array('id', 'id_lang', 'title', 'alias'));
        if ($data) {
            return $data;
        }
    }

    //hien nhung danh muc
    public function showCate() {
        $select         = '*';
        $this->objTable = new Model($this->lang . '_album_category');
        $this->objTable->where('idw', $this->idw);
        $this->objTable->where('parent_id', ($this->category != '' ? $this->category : 0));
        $this->objTable->where('status', 1);
        $this->objTable->orderBy('id', 'DESC');
        $data = $this->objTable->get(null, null, $select);
        if ($data) {
            return $data;
        }
    }

    //hien danh muc
    public function detailCate() {
        $this->objTable = new Model($this->lang . '_album_category');
        $this->objTable->where($this->id_field, $this->category);
        $this->objTable->where('status', 1);
        $this->objTable->where('idw', $this->idw);
        $data = $this->objTable->getOne();
        if ($data) {
            return $data;
        }
    }

    //link sort
    public function urlCustom($domain) {
        if (!empty($domain)) {
            $domain         = parse_url($domain);
            $path           = parse_url($_SERVER["REQUEST_URI"]);
            $this->sortLink = $domain['scheme'] . '://' . $domain['host'] . $path['path'];
            $this->home     = $domain['scheme'] . '://' . $this->home;
        }

    }

    //xu ly quotes
    public function html_decode($value = '') {
        $value = htmlspecialchars_decode($value);
        $value = html_entity_decode($value, ENT_QUOTES);
        $value = str_replace('"', "", $value);
        $value = str_replace("'", "", $value);

        return $value;
    }

    /**
     * [getChild description]
     * @author Truong Nguyen
     * @email  truongnx28111994@gmail.com
     * @date   2016-05-25
     * @return [type]                     [description]
     */
    public function getChild() {
        global $_B, $web;
        $idw_allow = array(3040);
        if (!in_array($web['idw'], $idw_allow)) {
            return false;
        }
        //Kiểm tra website có được show ko
        $id    = $_B['r']->get_int('id', 'GET');
        $child = $this->getChildById($id);
        //Lấy dữ liệu về album
        $albums = array();
        foreach ($child as $v) {
            $albums[] = array(
                'info'   => $v,
                'albums' => $this->getAlbum($v['id']),
            );
        }
        return $albums;

    }

    /**
     * [getChildById description]
     * @author Truong Nguyen
     * @email  truongnx28111994@gmail.com
     * @date   2016-05-25
     * @param  [type]                     $id [description]
     * @return [type]                         [description]
     */
    private function getChildById($id) {
        global $web;
        $this->objTable = new Model($this->lang . '_album_category');
        $this->objTable->where('status', 1);
        $this->objTable->where('idw', $this->idw);
        $this->objTable->where('parent_id', $id);
        $this->objTable->orderBy('order_by', 'ASC');
        $data = $this->objTable->get(null, null, 'id,title,contents,contents_description,avatar,icon,bg_image,create_time,id_lang,parent_id,views,alias');
        if (!empty($data)) {
            foreach ($data as &$v) {
                if ($this->lang != $this->lang_default) {
                    $v['id'] = $v['id_lang'];
                }
                $v['link'] = linkUrl($web, 'album', 'category', null, $v['id'], $v['alias']);
            }
        }
        return $data;
    }

    /**
     * [getAlbum description]
     * @author Truong Nguyen
     * @email  truongnx28111994@gmail.com
     * @date   2016-05-25
     * @param  [type]                     $id [description]
     * @return [type]                         [description]
     */
    private function getAlbum($id) {
        global $web;
        $this->objTable = new Model($this->lang . '_album');
        $this->objTable->where('category_id', '%,' . $id . ',%', 'LIKE');
        $this->objTable->where('status', 1);
        $this->objTable->orderBy('order_by', 'ASC');
        $data = $this->objTable->get(null, array(0, 10), 'id,id_lang,category_id,title,contents,contents_description,avatar,create_time,views');
        if (!empty($data)) {
            foreach ($data as &$v) {
                if ($this->lang_default != $this->lang) {
                    $v['id'] = $v['id_lang'];
                }
                $v['create_time'] = date('d/m/Y H:i:s', $v['create_time']);
                $v['link']        = linkUrl($web, 'album', 'detail', 'view', $v['id'], $v['alias']);

            }
        }
        return $data;
    }

}

?>