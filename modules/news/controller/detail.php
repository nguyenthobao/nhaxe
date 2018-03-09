<?php
/**
 * @Project BNC v2 -> Module News
 * @File news/controller/detail.php
 * @author Ba Huong Nguyen (nguyenbahuong156@gmail.com)
 * @Createdate 10/27/2014, 15:25 PM
 */
if (!defined('BNC_CODE')) {
    exit('Access Denied');
}
Class Detail extends Controller {

    public function view() {
        global $web;
        $modelNews     = $this->loadModel('news');
        $modelCategory = $this->loadModel('category');
        $curUrl        = $this->linkUrl('detail', 'view', ($this->id->ids) ? preg_replace('/_$/', '', $this->id->string) : $this->id->last);
        $info = $modelNews->getDetail($this->id->last);

        
        // $str = substr($_SERVER['REQUEST_URI'],1);
        // preg_match('/([a-zA-Z0-9-]+)-1-2-([0-9]+).html/',$str,$match);
        // if(isset($match[1])){  
        //         $tmp_alias=$match[1];   
        // }
        // if($tmp_alias!=$info['alias']){     
        //          header('Location: /');
        // }
            //var_dump($web);
        

        
        //$cat_id = explode(',',$info['cat_id']);
        $id_cat = preg_replace("/^,{1}/", "", $info['cat_id']);
        $id_cat = preg_replace("/,$/", "", $id_cat);
        $cat_id = explode(',', $id_cat);

        $id_related = preg_replace("/^,{1}/", "", $info['related_news']);
        $id_related = preg_replace("/,$/", "", $id_related);
        $related_id = explode(',', $id_related);
        if (isset($info['config_news_cat'])) {
            $config_cat     = json_decode($info['config_news_cat'], 1);
            $list_other_cat = $modelNews->getNewsOtherCat($this->id->last, $cat_id, $config_cat['show_quantity']);
        }
        if (isset($info['config_news_related'])) {
            $config_related     = json_decode($info['config_news_related'], 1);
            $list_other_related = $modelNews->getNewsOtherRelated($related_id, $config_related['show_quantity']);
        }

        $config         = $modelNews->getConfig();
        $newsRelatedNXT = '';
        foreach ($config as $k => $v) {
            if ($v['key'] == 'news_relateds') {
                $newsRelatedNXT = json_decode($v['value_string'], true);
            }
        }
        if (!isset($list_other_cat)) {
            @$list_other_cat = $modelNews->getNewsOtherCat($this->id->last, $cat_id, $newsRelatedNXT['news_cate']['quantity']);
        }

        if (!isset($list_other_related)) {
            @$list_other_related = $modelNews->getNewsOtherRelated($related_id, $newsRelatedNXT['news_related']['quantity']);
        }

        // echo "<pre>";
        // print_r($list_other_related);
        // echo "</pre>";
        //Lấy 1 danh mục bất kỳ của tin để tạo breadcrumbs

        // $parent_id = $cat_id[1];
        $parent_id = $cat_id[0];
        //set title trang chủ
        $config                = $this->cf->setting_page;
        $breadcrumbsHomeModule = array(
            'text' => $config['title'],
            'href' => linkUrl($web, 'news'),
        );
        if (isset($this->id->ids) && $this->id->count >= 2) {
            //Loại bỏ đi 1 phần tử cuối cùng(vì phần tử cuối cùng là id của tin)
            $id_news = array_pop($this->id->ids);
            foreach ($this->id->ids as $id) {
                $cat                    = $modelCategory->getCategoryById($id);
                $breadcrumbs_title[$id] = $cat['title'];
            }
            $breadcrumbs_news = array(
                'text' => $info['title'],
                'href' => $curUrl,
            );
            $breadcrumbs = array(
                'title' => $breadcrumbs_title,
                'page'  => 'category',
                'sub'   => 'cat',
            );
            $data['breadcrumbs'] = $this->setBreadcrumbs($breadcrumbs, $breadcrumbsHomeModule, null, $breadcrumbs_news);
        } else {
            $cat = $modelCategory->getCategoryById($parent_id);

            $cat_id     = array_filter(array_values(explode(',', $info['cat_id'])));
            $refeder    = $_SERVER['HTTP_REFERER'];
            $id_refeder = false;
            foreach ($cat_id as $k => $v) {
                if ($id_refeder == false) {
                    if ($refeder != null) {
                        preg_match("/" . $v . "/", $refeder, $matches);
                        if (!empty($matches)) {
                            $id_refeder = $v;
                        }
                    } else {
                        $id_refeder = $v;
                    }
                }
            }
            if ($id_refeder == false) {
                foreach ($cat_id as $k => $v) {
                    $id_refeder = $v;
                }
            }

            $breadcrumbs_cat = array();
            $breadcrumbs_cat = $this->getBreadcrumbsCategory($id_refeder);

            // $breadcrumbs_cat = array(
            //     'id'   => $parent_id,
            //     'text' => $cat['title'],
            //     'href' => $this->linkUrl('category', 'cat', $parent_id, $cat['alias']),
            // );

            $breadcrumbs_title[$this->id->last] = $info['title'];
            $breadcrumbs                        = array(
                'title' => $breadcrumbs_title,
                'page'  => 'detail',
                'sub'   => 'view',
            );

            $data['breadcrumbs'] = $this->setBreadcrumbs($breadcrumbs, $breadcrumbsHomeModule, $breadcrumbs_cat);

        }

        //Tags
        $tags = explode(',', $info['tags']);
        $tags = array_unique(array_values(array_filter($tags)));
        foreach ($tags as $k => $v) {
            $tmp_tag = getTag($v);
            if (!empty($v)) {
                $href             = $web['home_url'] . '/tag/' . $tmp_tag['alias'];
                $meta_tags[$href] = $tmp_tag['tag'];
            }
        }

        $thumb = $info['img'];
        if ($info['create_time'] == false) {
            $info['create_time'] = $info['update_time'];
        } 
        $data['newsDetail'] = array(
            'id'               => $info[$this->id_field],
            'title'            => $info['title'],
            'thumb'            => $thumb,
            'img'              => $info['img'], //Load ảnh gốc,
            'details'          => $info['details'],
            'create_time'      => date("H:i:s d-m-Y", $info['create_time']),
            'tags'             => (isset($meta_tags)) ? $meta_tags : null,
            'meta_keyword'     => $info['meta_keyword'],
            'meta_description' => $info['meta_description'],
            'view'             => $info['views'],
            'author'           => $info['author'],
            'news_source'      => $info['news_source'],
            'link'             => $this->linkUrl('detail', 'view', $info[$this->id_field], $info['alias']),
            'category'         => array_filter(array_values(explode(',', $info['cat_id']))),
        );

        if (!empty($info['meta_title'])) {
            $title = $info['meta_title'];
        } else {
            $title = $info['title'];
        }
        $link_canonical = $web['home_url'].'/'.$info['alias'].'-1-2-'.$info['id'].'.html';
        $head = array(
            'link'          => $link_canonical,
            'title'         => $title,
            'keywords'      => $data['newsDetail']['meta_keyword'],
            'description'   => $data['newsDetail']['meta_description'],
            'ogtitle'       => $title,
            'ogimage'       => HTTP_STATIC . $data['newsDetail']['img'],
            'ogsite_name'   => $title,
            'ogdescription' => $data['newsDetail']['meta_description'],
        );
        //Kiểm tra cài đặt riêng của tin tức hiện tại

        if (isset($list_other_cat)) {
            foreach ($list_other_cat as $new) {
                $id     = $new[$this->id_field];
                $thumb  = $new['img'];
                $id_cat = preg_replace("/^,{1}/", "", $new['cat_id']);
                $id_cat = preg_replace("/,$/", "", $id_cat);
                $cat_id = explode(',', $id_cat);
                // $cat_id = explode(',',$new['cat_id']);
                $parent_id = $cat_id[0];
                $news[]    = array(
                    'id'    => $id,
                    'title' => $new['title'],
                    'short' => $new['short'],
                    'thumb' => $thumb, //Load ảnh theo ý muốn
                    'img'   => $new['img'], //Load ảnh gốc
                    'href'  => $this->linkUrl('detail', 'view', $parent_id . '_' . $id, $new['alias']),
                );
            }
        }

        $data['newsOther'] = array(
            'news' => (isset($news)) ? $news : null,
        );
        if (isset($news)) {
            unset($news);
        }
        if (isset($list_other_related)) {
            foreach ($list_other_related as $newr) {
                $id     = $newr[$this->id_field];
                $thumb  = $newr['img'];
                $id_cat = preg_replace("/^,{1}/", "", $newr['cat_id']);
                $id_cat = preg_replace("/,$/", "", $id_cat);
                $cat_id = explode(',', $id_cat);
                // $cat_id = explode(',',$new['cat_id']);
                $parent_id = $cat_id[0];
                $newsr[]   = array(
                    'id'    => $id,
                    'title' => $newr['title'],
                    'short' => $newr['short'],
                    'thumb' => $thumb, //Load ảnh theo ý muốn
                    'img'   => $newr['img'], //Load ảnh gốc
                    'href'  => $this->linkUrl('detail', 'view', $parent_id . '_' . $id, $newr['alias']),
                );
            }
        }

        $data['newsRelated'] = array(
            'newsr' => (isset($newsr)) ? $newsr : null,
        );
        if (isset($newsr)) {
            unset($newsr);
        }

        $this->setTitle($head);
        $this->setContent($data, 'news_details');
    }
    /**
     * @return mixed
     */
    protected function getSettingRelatedGeneral() {
        $modelSetting = $this->loadModel('news');
        $data         = array(
            'key' => 'news_relateds',
        );
        $result = $modelSetting->getSettingRelatedGeneral($data);
        $result = json_decode($result, 1);

        return $result;
    }

    /**
     * @param $idCate
     * @param array $data
     * @return mixed
     */
    public function getBreadcrumbsCategory($idCate, $data = array()) {
        global $_B, $web;

        $model = new Model($this->lang . '_category');
        $model->where('idw', $this->idw);
        $model->where('status', 1);
        if ($_B['lang'] != $_B['lang_default']) {
            $model->where('id_lang', $idCate);
        } else {
            $model->where('id', $idCate);
        }
        $model->where('id', $idCate);
        $category = $model->getOne(null, 'id, id_lang, parent_id, title,alias');
        if ($_B['lang'] != $_B['lang_default']) {
            $category['id'] = $category['id_lang'];
        }
        $category['link'] = linkUrl($web, 'news', 'category', 'cat', $category['id'], $category['alias']);
        $data[]           = array(
            'text'      => (isset($category['title']) ? $category['title'] : ''),
            'href'      => $category['link'],
            'separator' => 1,
        );
        if (isset($category['parent_id']) && $category['parent_id'] > 0) {
            $data = $this->getBreadcrumbsCategory($category['parent_id'], $data);
        }
        krsort($data);

        return $data;
    }
}