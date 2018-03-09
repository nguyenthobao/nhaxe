<?php
if (!defined('BNC_CODE')) {
    exit('Access Denied');
}

class ModelSlide {

    function __construct() {
        global $_B, $web;
        $this->mod = 'template';
        db_connect($this->mod);
        $this->lang         = $_B['lang'];
        $this->lang_default = $_B['lang_default'];
        $this->idw          = $web['idw'];
        $this->web          = $web;
        $this->home_url     = $web['home_url'];
        $this->request      = $_B['r'];
        

    }

    public function slide($position) {
        $DataSlideNoImage = $this->getSlide($position);
        $result           = $this->ModifySlide($DataSlideNoImage);
        return $result;
    }

    private function ModifySlide($DataSlideNoImage) {
        $result = array();
        foreach ($DataSlideNoImage as $k => $v) {
            $images   = $this->getImageBySlide($v['id']);
            $result[] = array(
                'id'          => $v['id'],
                'title'       => $v['title'],
                'description' => $v['description'],
                'position'    => $v['position'],
                'meta_title'  => $v['meta'],
                'image_slide' => $images,
            );
        }
        return $result;
    }

    private function getSlide($position) {
        global $web;
        $mod = $web['query_string']['mod'];
        $mS           = new Model('template.' . $this->lang . '_slide');
        $mS->where('idw', $this->idw);
        $mS->where('status', 1);
        $mS->where('position', $position);
        $mS->orderBy('sort', 'ASC');
        $results = $mS->get(null, null, '*');

        // foreach ($results as $k => $v) {
        //     $tmp_active_mod=array_filter(array_values(explode(',', $v['active_mod'])));
        //     if($v['active_mod']!=null && in_array($mod, $tmp_active_mod)==false){
        //         unset($results[$k]);
        //     }
        // }

        return $results;
    }

    private function getImageBySlide($id) {
        $mSI = new Model('template.' . $this->lang . '_slide_image');
        $mSI->where('idw', $this->idw);
        $mSI->where('status', 1);
        $mSI->where('slide_id', $id);
        $mSI->orderBy('sort', 'ASC');
        $results = $mSI->get(null, null, '*');
        // $data    = array();
        // foreach ($results as $key => $value) {
        //     $image  = loadImage($value['src_link'], 'resize', 300, 250);
        //     $data[] = array(
        //         'id'          => $value['id'],
        //         'idw'         => $value['idw'],
        //         'id_lang'     => $value['id_lang'],
        //         'thumb'       => $image,
        //         'title'       => $value['title'],
        //         'description' => $value['description'],
        //         'width'       => $value['width'],
        //         'height'      => $value['height'],
        //         'link'        => $value['link'],
        //     );
        // }
        return $results;
    }
}