<?php
/**
 * @Project BNC v2 -> Module Category
 * @File category/model/category.php
 * @Author An Nguyen Huu (annh@webbnc.vn)
 * @Createdate 11/18/2014, 11:22 AM
 */
class ModelCategory {
    private $idw, $categoryObj, $id_field, $lang;
    public function __construct($id_field) {
        global $_B, $web;
        $this->idw         = $web['idw'];
        $this->lang        = $_B['lang'];
        $this->id_field    = $id_field;
        $this->categoryObj = new Model($this->lang . '_category');
    }
    public function getCategoryList() {
        global $web;
        $page = $_GET['p'];
        if ($page == false || $page == 1) {
            $page = 0;
        }
        $limit = 10;
        $start = $limit * $page;

        $this->categoryObj->where('idw', $this->idw);
        $this->categoryObj->where('status', 1);
        $result = $this->categoryObj->get(null, array($start, $limit), '*');
        return $result;
    }
    public function totalCategory() {
        $this->categoryObj->where('idw', $this->idw);
        $this->categoryObj->where('status', 1);
        $total = $this->categoryObj->num_rows();
        return $total;
    }
    public function getDetail($id) {
        $this->categoryObj->where('idw', $this->idw);
        $this->categoryObj->where('status', 1);
        $this->categoryObj->where($this->id_field, $id);
        $result = $this->categoryObj->getOne(null, '*');
        return $result;
    }

    public function setView($id, $view = 1) {
        $data = array(
            'view' => $view + 1,
        );
        $this->categoryObj->where('idw', $this->idw);
        $this->categoryObj->where($this->id_field, $id);
        return $this->categoryObj->update($data);
    }
}