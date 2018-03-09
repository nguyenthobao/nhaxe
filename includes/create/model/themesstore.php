<?php

class Themes {
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
        $obj = new Model('themes_category');

        $data = $obj->get();
        // foreach ($data as $key => $value) {
        //     $tmp = $this->check_category($value['id']);
        //     if ($tmp == true) {
        //         unset($data[$key]);
        //     }
        // }
        return $data;
    }
    /**
     * @return getCategory
     */
    public function getCategory($id) {
        $db  = db_connect_mod('notify');
        $obj = new Model('themes_category');
        $obj->where('id', $id);
        $data = $obj->getOne();
        return $data;
    }
    public function category_search($search) {
        $db  = db_connect_mod('notify');
        $obj = new Model('themes_category');

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
     * @param $check_category
     */
    public function check_category($id) {
        $db  = db_connect_mod('notify');
        $obj = new Model('themes');
        $obj->where('status', 1);
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
        $obj = new Model('themes');
        $obj->where('status', 1);
        $obj->where('cat_id', '%,' . $id . ',%', 'LIKE');
        $obj->where('title', '%'.$search.'%', 'LIKE');
        $data = $obj->get();
        if (!empty($data)) {
            return false;
        } else {
            return true;
        }

    }

    public function themesSearch($name) {
        $db  = db_connect_mod('notify');
        $obj = new Model('themes');
        $obj->orWhere('title', '%'.$name.'%', 'LIKE');
        $obj->orWhere('meta_keyword', '%' . $name . '%', 'like');
        $data = $obj->get();
        return $data;
    }
    
    
    /**
     * @return mixed
     */
    public function themes_cat() {
        $db  = db_connect_mod('notify');
        $obj = new Model('themes');

        return $obj->get();
    }
    /**
     * @return new
     */
    public function themes_new($dk) {
        $db  = db_connect_mod('notify');
        $obj = new Model('themes');
        if($dk==1)
        {
            $obj->where('price', 0);
        }elseif ($dk==2) {
            $obj->where('price',0,'!=');
        }
        $obj->where('status', 1);
        $obj->orderBy('create_time', 'DESC');
        return $obj->get();
    }
    /**
     * @return star
     */
    public function themes_star($dk) {
        $db  = db_connect_mod('notify');
        $obj = new Model('themes');
        if($dk==1)
        {
            $obj->where('price', 0);
        }elseif ($dk==2) {
            $obj->where('price',0,'!=');
        }
        $obj->where('status', 1);
        $obj->orderBy('star', 'DESC');
        return $obj->get();
    }
    /**
    * @return mixed
    */
    public function themes_cat_search($search) {
        $db  = db_connect_mod('notify');
        $obj = new Model('themes');
        $obj->where('status', 1);
        $obj->where('title', '%'.$search.'%', 'LIKE');
        return $obj->get();
    }
    
    /**
     * @param $id
     * @return mixed
     */
    public function themes_other($id) {
        $db  = db_connect_mod('notify');
        $obj = new Model('themes');
        $obj->where('id', $id, '!=');
        $obj->where('status', 1);
        $obj->orderBy('RAND()');
        return $obj->get();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function themesCategory($id) {
        $db  = db_connect_mod('notify');
        $obj = new Model('themes');
        $obj->where('cat_id', '%'.$id.'%', 'LIKE');
        return $obj->get();
    }
    /**
     * @param $id
     * @return mixed
     */
    public function themes_detail($id) {
        $db  = db_connect_mod('notify');
        $obj = new Model('themes');
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
    public function addContact($fullname, $email, $type = 1, $app_name = null, $content = null) {
        return false;
    }

}