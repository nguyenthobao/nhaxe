<?php

class App {
    /**
     * @var mixed
     */
    public $tenrg;
    /**
     * @var mixed
     */
    public $email;
    /**
     * @var mixed
     */
    public $passwd;
    /**
     * @var mixed
     */
    private $r;
    public function __construct() {
        global $_B;
        $this->r = $_B['r'];
    }
    /**
     * @return mixed
     */
    public function category() {
        $db  = db_connect_mod('notify');
        $obj = new Model('apps_settings_category');

        $data = $obj->get();
        foreach ($data as $key => $value) {
            $tmp = $this->check_category($value['id']);
            if ($tmp == true) {
                unset($data[$key]);
            }
        }
        return $data;
    }
    public function category_search($search) {
        $db  = db_connect_mod('notify');
        $obj = new Model('apps_settings_category');

        $data = $obj->get();
        foreach ($data as $key => $value) {
            $tmp = $this->check_category_search($value['id'],$search);
            if ($tmp == true) {
                unset($data[$key]);
            }
        }
        return $data;
    }

    /**
     * @param $id
     */
    public function check_category($id) {
        $db  = db_connect_mod('notify');
        $obj = new Model('apps_setting');
        $obj->where('cat_id', '%,' . $id . ',%', 'LIKE');
        $data = $obj->get();
        if (!empty($data)) {
            return false;
        } else {
            return true;
        }

    }
    public function check_category_search($id,$search) {
        $db  = db_connect_mod('notify');
        $obj = new Model('apps_setting');
        $obj->where('cat_id', '%,' . $id . ',%', 'LIKE');
        $obj->where('title', '%'.$search.'%', 'LIKE');
        $data = $obj->get();
        if (!empty($data)) {
            return false;
        } else {
            return true;
        }

    }

    /**
     * @return mixed
     */
    public function app_cat() {
        $db  = db_connect_mod('notify');
        $obj = new Model('apps_setting');

        return $obj->get();
    }
    /**
    * @return mixed
    */
    public function app_cat_search($search) {
        $db  = db_connect_mod('notify');
        $obj = new Model('apps_setting');
        $obj->where('title', '%'.$search.'%', 'LIKE');
        return $obj->get();
    }
    
    /**
     * @param $id
     * @return mixed
     */
    public function app_other($id) {
        $db  = db_connect_mod('notify');
        $obj = new Model('apps_setting');
        $obj->where('id', $id, '!=');

        return $obj->get();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function app_detail($id) {
        $db  = db_connect_mod('notify');
        $obj = new Model('apps_setting');
        $obj->where('id', $id);

        return $obj->getOne();
    }

    /**
     * @param $fullname
     * @param $email
     * @param $phone
     * @param $website
     * @param $content
     */
    public function addContact($fullname, $email, $phone, $website, $type = 1, $app_name = null, $content = null) {
        return false;
    }

}