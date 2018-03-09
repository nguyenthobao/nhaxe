<?php
/**
 * @Project BNC v2 -> Module News
 * @File news/model/category.php
 * @Author Ba Huong Nguyen (nguyenbahuong156@gmail.com)
 * @Createdate 10/27/2014, 11:22 AM
 */
class ModelCategory {
    private $idw, $catObj, $catNewsObj, $id_field, $lang;
    public function __construct($id_field) {
        global $_B, $web;
        $this->lang       = $_B['lang'];
        $this->idw        = $web['idw'];
        $this->id_field   = $id_field;
        $db               = db_connect('news');
        $this->catObj     = new Model($this->lang . '_category', $db);
        $this->catNewsObj = new Model($this->lang . '_news', $db);
    }

    public function getNewsList($filter) {
        if (isset($filter['start']) || isset($filter['limit'])) {
            if ($filter['start'] < 0) {
                $filter['start'] = 0;
            }
            if ($filter['limit'] < 1) {
                $filter['limit'] = 15;
            }
            $limit = array($filter['start'], $filter['limit']);
        }
        $this->catNewsObj->where('idw', $this->idw);
        $this->catNewsObj->where('status', 1);

        if (!empty($filter['cat_id'])) {
            $this->catNewsObj->where('cat_id', '%,' . (int) $filter['cat_id'] . ',%', 'LIKE');
        }
        if (!empty($filter['title'])) {
            $cl_array   = array();
            $cl         = '(0 or title LIKE ? or short LIKE ? or details LIKE ?)';
            $cl_array[] = '%' . (string) $filter['title'] . '%';
            $cl_array[] = '%' . (string) $filter['title'] . '%';
            $cl_array[] = '%' . (string) $filter['title'] . '%';
            $this->catNewsObj->where($cl, $cl_array);
        }

        $arrs_idw = array(996, 1406);
        if (in_array($this->idw, $arrs_idw)) {
            $this->catNewsObj->orderBy('sort', 'ASC');
        } else {
            $this->catNewsObj->orderBy('create_time', 'DESC');
        }
        // if ($filter['sort'] != 'title') {
        //     $this->catNewsObj->orderBy($filter['sort'], 'ASC');
        // // } elseif ($filter['sort'] != false) {
        // //     $this->catNewsObj->orderBy($filter['sort'], 'ASC');
        // // } else {
        // }else{

        //}

        $result = $this->catNewsObj->get(null, (isset($limit)) ? $limit : null, '*');

        return $result;

    }
    public function getCategoryById($id) {
        $this->catObj->where('idw', $this->idw);
        if (!empty($id)) {
            $this->catObj->where($this->id_field, $id);
        }
        //$this->catObj->orderBy('sort', 'ASC');
        $select = 'id,title,description,meta_title,meta_keyword,meta_description,parent_id,icon,bg,img,alias';
        $result = $this->catObj->getOne(null, $select);
        return $result;
    }
    public function getListCategoryByParentId($filter) {
        if (isset($filter['start']) || isset($filter['limit'])) {
            if ($filter['start'] < 0) {
                $filter['start'] = 0;
            }
            if ($filter['limit'] < 1) {
                $filter['limit'] = 15;
            }
            $limit = array($filter['start'], $filter['limit']);
        }
        $this->catObj->where('idw', $this->idw);
        $this->catObj->where('status', 1);
        $this->catObj->where('parent_id', (int) $filter['parent_id']);
        $result = $this->catObj->get(null, (isset($limit)) ? $limit : null, 'id,id_lang,title,icon,alias');
        return $result;
    }
    public function listCategory() {
        $this->catObj->where('idw', $this->idw);
        $this->catObj->where('status', 1);
        $category = $this->catObj->get(null, null, '*');
        $category = $this->recursive($category, $this->id_field, $parent_field = 'parent_id', $parent = 0);
        return $category;
    }
    private function recursive($category, $id_field, $parent_field = "parent_id", $parent = 0) {
        $current_categorys = array();
        foreach ($category as $key => $value) {
            if ($value[$parent_field] == $parent) {
                $k                     = $value[$id_field];
                $current_categorys[$k] = $value;
                unset($category[$key]);
            }
        }
        if (sizeof($current_categorys) > 0) {
            foreach ($current_categorys as $key => $value) {
                $current_categorys[$key]['sub'] = $this->recursive($category, $id_field, $parent_field, $value[$id_field]);
            }
        }
        return $current_categorys;
    }
    public function totalNews($filter) {
        $this->catNewsObj->where('idw', $this->idw);
        $this->catNewsObj->where('status', 1);
        if ($filter['cat_id'] != 0) {
            $this->catNewsObj->where('cat_id', ',%' . $filter['cat_id'] . ',%', 'LIKE');
        }
        $total = $this->catNewsObj->num_rows();

        return $total;
    }
    public function loadCate($id) {
        $limit = $this->getNumNewsCate($id);
        if ($limit == 0) {
            $limit = 4;
        }
        $this->catNewsObj->where('idw', $this->idw);
        $this->catNewsObj->where('status', 1);
        $this->catNewsObj->where('cat_id', '%,' . $id . ',%', 'LIKE');
        $this->catNewsObj->orderBy('create_time', 'DESC');
        $result = $this->catNewsObj->get(null, array(0, $limit), '*');
        return $result;
    }
    public function getNumNewsCate($id) {
        $this->catObj->where('idw', $this->idw);
        $this->catObj->where('status', 1);
        $this->catObj->where($this->id_field, $id);
        $result = $this->catObj->getOne(null, 'id,number_home,alias');
        $tmp    = $result['number_home'];
        return $tmp;
    }
}