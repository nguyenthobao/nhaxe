<?php
/**
 * @Project BNC v2 -> Module News
 * @File news/controller/category.php
 * @author Ba Huong Nguyen (nguyenbahuong156@gmail.com)
 * @Createdate 10/27/2014, 11:25 AM
 */
if (!defined('BNC_CODE')) {
    exit('Access Denied');
}
Class Category extends Controller {
    public function cat() {
        global $_B, $web;

        $uri = $_B['curUrl']['URI'];
        $re  = "/^\/(.*)\.html/";
        preg_match($re, $uri, $uriNew);
        $data['curUrl']        = $uriNew[0];
        $modelCategory         = $this->loadModel('category');
        $configHome            = $this->cf->setting_page;
        $breadcrumbsHomeModule = array(
            'text' => $configHome['title'],
            'href' => linkUrl($web, 'news'),
        );

        if ($this->id->last == false) {
            $categorys = $configHome;
            //$categorys = $modelCategory->getCategoryById();
        } else {
            //Load dữ liệu cho danh mục hiện tại
            $categorys = $modelCategory->getCategoryById((int) $this->id->last);
        }
        // preg_match("/(.*)-2-2-([0-9]+).html/", $_B['curUrl']['URI'], $matches_alias);
        // if (isset($matches_alias[1]) && str_replace('/', '', $matches_alias[1]) != $categorys['alias'] && $_B['lang'] == 'vi') {
        //     //redirect
        //     $nxt_url = str_replace($matches_alias[1], $categorys['alias'], $matches_alias[0]);
        //     header('location:' . $nxt_url);
        //     exit();
        //     error404();
        // }

        if (isset($categorys)) {
            foreach ($categorys as $k => $v) {
                if ($k == 'icon') {
                    $icon     = $v;
                    $data[$k] = $icon;
                } elseif ($k == 'bg') {
                    $bg       = $v;
                    $data[$k] = $bg;
                } elseif ($k == 'img') {
                    $img = $v;
                    //$img  =  $v;
                    $data[$k] = $img;
                } else {
                    $data[$k] = $v;
                }
            }
            //Set nội dung cho header
            if (!empty($data['meta_title'])) {
                $title = $data['meta_title'];
            } else {
                $title = $data['title'];
            }
            
            //if($breadcrumbsHomeModule['text']==$data['title'])
            $newsTitle = $breadcrumbsHomeModule['text'];
            if (isset($web['query_string']['page'])) {
                $breadcrumbsHomeModule['text'] = $data['title'];
            }

            //set title breadcrumbs
            $breadcrumbs_title = array();
            if (isset($this->id->ids)) {
                foreach ($this->id->ids as $id) {
                    $cat = $modelCategory->getCategoryById($id);
                    //$breadcrumbs_title[$id] = $cat['title'];
                }
            }
            if(empty($cat['id'])){
                $link_canonical = $web['home_url'].'/news.html';
            }else{
                $link_canonical = $web['home_url'].'/'.$cat['alias'].'-2-2-'.$cat['id'].'.html';
            }
            $head = array(
                'link'          => $link_canonical,
                'title'         => $title,
                'keywords'      => $data['meta_keyword'],
                'description'   => $data['meta_description'],
                'ogtitle'       => $title,
                'ogimage'       => $data['img'],
                'ogsite_name'   => $title,
                'ogdescription' => $data['meta_description'],
            );
            $breadcrumbs = array(
                'title' => $breadcrumbs_title,
            );
            $breadcrumbs2        = $this->getBreadcrumbsCategory($id);
            $data['breadcrumbs'] = $this->setBreadcrumbs($data['breadcrumbs'], $breadcrumbsHomeModule);
            $data['breadcrumbs'] = array_merge($data['breadcrumbs'], $breadcrumbs2);

            $data['breadcrumbs'][1]['text'] = $newsTitle;
            foreach ($data['breadcrumbs'] as $k => $v) {
                if ($v['text'] == '') {
                    unset($data['breadcrumbs'][$k]);
                }
            }
           
            //Lấy danh mục con thuộc danh mục này
            $filter_category = array(
                'parent_id' => $this->id->last,
                'sort'      => 'title',
                'order'     => 'DESC',
                'start'     => 0,
                'limit'     => 20,
            );
            // var_dump($filter_category);
            $filter_news = array();
            //Số lượng tin lấy ra trên 1 trang

            $limit = $this->request->get_string('limit', 'GET');
            if (!empty($limit)) {
                $limit                = $this->request->get_string('limit', 'GET');
                $data['filter_limit'] = $limit;
            } else {
                $limit = $configHome['quantity_news'];
            }

            $title = $this->request->get_string('title', 'GET');
            if (!empty($title)) {
                $filter_news['title'] = urlencode(html_entity_decode($title, ENT_QUOTES, 'UTF-8'));
                $data['filter_title'] = $title;
            }
            $type = $this->request->get_string('type', 'GET');
            if (!empty($type)) {
                if ($type == 'news_latsted') {
                    $filter_news['type'] = 'create_time';
                } elseif ($type == 'news_vip') {
                    $filter_news['type'] = 'is_vip';
                } elseif ($type == 'news_az') {
                    $filter_news['type'] = 'is_hot';
                }
                $data['filter_type'] = $type;
            }
            $filter_news = array(
                'cat_id' => $this->id->last,
                'sort'   => (isset($filter_news['type'])) ? $filter_news['type'] : 'sort',
                'order'  => 'DESC',
                'start'  => ($this->p - 1) * $limit,
                'limit'  => $limit,
                'title'  => (isset($data['filter_title'])) ? $data['filter_title'] : '',
            );
            //var_dump($filter_news);

            $listCategory = $modelCategory->getListCategoryByParentId($filter_category);

            foreach ($listCategory as $k => $v) {
                if ($_B['lang'] != 'vi') {
                    $v['id'] = $v['id_lang'];
                }
                $data['listCategory'][] = array(
                    'id'    => $v[$this->id_field],
                    'title' => $v['title'],
                    'href'  => $this->linkUrl('category', 'cat', $this->id->string . $v['id'], $v['alias']),
                    'icon'  => $v['icon'],
                );
            }
            //var_dump($listCategory['href']);
            //Đếm tổng số bản ghi cần lấy theo điều kiện filter
            $total = $modelCategory->totalNews($filter_news);
            $newsS = $modelCategory->getNewsList($filter_news);

            if (isset($newsS)) {
                foreach ($newsS as $news) {
                    $data['news'][$news[$this->id_field]] = $this->formatNews($news);
                }
            } else {
                echo lang('notfound_data');
            }
            unset($newsS);
            //Phân trang
            $data['pagination'] = $this->pagination($limit, $total);
            //Gọi hàm set dữ liệu lên header
            $this->setTitle($head);

            
            $data['title'] = $breadcrumbsHomeModule['text'];
            // xuat tin theo dang danh muc
            if ($web['idw']==3467 || $web['idw']==4820 || $web['idw']==5818) {
                foreach ($data['listCategory'] as $key => $value) {
                   $data_cat['catCat'] =$value;
                   $data_cat['newsTab'] = $this->findNews($data['news'],$value['id']);
                   $data['catTab'][] = $data_cat;
                }
                
                //var_dump($data['catTab']);
            }
            //Gọi hàm đưa nội dung ra ngoài giao diện
            $this->setContent($data, 'news');


        } else {
            //Trang bạn tìm kiếm không tồn tại
            $data['breadcrumbs'][] = array(
                'text'      => lang('title_notfound'),
                'href'      => '',
                'separator' => true,
            );
            //Set nội dung cho header
            $head = array(
                'title'       => lang('title_notfound'),
                'keywords'    => lang('title_notfound'),
                'description' => lang('description_notfound'),
            );
            $data['title']       = lang('title_notfound');
            $data['description'] = lang('description_notfound');
            $this->setTitle($head);
            //Gọi hàm đưa nội dung ra ngoài giao diện
            $data['title'] = $configHome['title'];
            $this->setContent($data, 'news_not_found');
        }
        if ($_COOKIE['sv']) {
            var_dump($data['pagination']);
        }
        
    }
     /**
     * @param $findNews
     * @return mixed
     */
     // private function findNews($data,$id)
     // {
     //    $ids=(string)$id;
     //    foreach ($data as $k => $v) {
     //       if (strlen(strstr($v['cat_id'], $ids)) > 0) 
     //       {
     //            $res[]= $v;
     //       }
     //    }
     //    return $res;
     // }
      private function findNews($data,$id)
     {
        $ids=(string)$id;
        
        foreach ($data as $k => $v) {
           $tmp = explode(",", $v['cat_id']);
           if (in_array($ids,$tmp) == true) 
           {
                $res[]= $v;
           }
        }
        return $res;
     }
     
    /**
     * @param $news
     * @return mixed
     */
    private function formatNews($news) {
        global $_B;
        $id    = $news[$this->id_field];
        $thumb = $news['img'];
        if ($this->id->last == 0) {
            $cat_id    = explode(',', $news['cat_id']);
            $parent_id = $cat_id[1];
            $href      = $this->linkUrl('detail', 'view', $parent_id . '_' . $id, $news['alias']);
        } else {
            $href = $this->linkUrl('detail', 'view', $this->id->string . $id, $news['alias']);
        }
        $newsS = array(
            'id'          => $id,
            'title'       => $news['title'],
            'short'       => $news['short'],
            'details'     => $news['details'],
            'thumb'       => $thumb,
            'img'         => $news['img'], //$this->loadImage($news['img'],'none'),
            'href'        => $href,
            'create_time' => date("H:i:s d-m-Y", $news['create_time']),
            'sort'        => $news['sort'],
            'cat_id'      => $news['cat_id'],  
        );

        return $newsS;
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