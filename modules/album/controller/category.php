<?php
/*
 * @Project BNC V2
 * @Author Lư Chí Tâm (tamlc@webbnc.vn)
 * Frontend Album Category Controller
 */
if (!defined('BNC_CODE')) {
    exit('Access Denied');
}

/**
 * album category
 */
class category extends Controller {
    /*
     * show album by cate
     */
    public function album() {
        global $web, $_B;
        $modelHome           = $this->loadModel('home');
        $homeConfig          = @$this->cf->home_config;
        $modelHome->order_by = $homeConfig['display_sort'];
        if (in_array($this->request->get_string('sort', 'GET'), array('new', 'hot', 'az'))) {
            $modelHome->order_by = $this->request->get_string('sort', 'GET');
        }
        $data['sort']          = $modelHome->order_by;
        $data['search_string'] = $modelHome->title = htmlspecialchars($this->request->get_string('q', 'GET'), ENT_QUOTES);

        //request
        $modelHome->category = $this->id->last;
        $meta                = $modelHome->detailCate();

        //home info
        $data['home_title']        = $meta['title'];
        $data['home_description']  = $meta['contents_description'];
        $data['home_avatar']       = $meta['avatar'];
        $data['home_icon']         = $meta['icon'];
        $data['home_bg_image']     = ($meta['bg_image'] != '' ? HTTP_STATIC . $meta['bg_image'] : HTTP_STATIC . 'upload/web/1/1/no-img.gif');
        $data['home_display_type'] = (isset($homeConfig['display_type']) ? $homeConfig['display_type'] : '');
        if(empty($meta['id'])){
                $link_canonical = $web['home_url'].'/news.html';
        }else{
                $link_canonical = $web['home_url'].'/'.$meta['alias'].'-2-3-'.$meta['id'].'.html';
        }
        if (!empty($meta)) {
            $head = array(
                'link'        => $link_canonical,  
                'title'       => $modelHome->html_decode(($meta['meta_title'] != '' ? $meta['meta_title'] : $meta['title'])),
                'keywords'    => $modelHome->html_decode($meta['meta_keywords']),
                'description' => $modelHome->html_decode($meta['meta_description']),
            );
        }

        $limit                = $data['default_limit']                = $homeConfig['display_number'];
        $get_limit            = $this->request->get_int('limit', 'GET');
        $data['search_limit'] = '';
        if ($get_limit AND $data['default_limit'] != $get_limit AND $get_limit > $limit AND $get_limit < 100) //max record 100
        {
            $data['search_limit'] = $limit = $this->request->get_int('limit', 'GET');
        }

        //
        $modelHome->urlCustom($this->linkUrl($modelHome->url_mod));
        $data['url_sort_new'] = $modelHome->sortLink . '?sort=new' . (!empty($data['search_limit']) ? '&limit=' . $limit : '') . (!empty($modelHome->title) ? '&q=' . $modelHome->title : '');
        $data['url_sort_hot'] = $modelHome->sortLink . '?sort=hot' . (!empty($data['search_limit']) ? '&limit=' . $limit : '') . (!empty($modelHome->title) ? '&q=' . $modelHome->title : '');
        $data['url_sort_az']  = $modelHome->sortLink . '?sort=az' . (!empty($data['search_limit']) ? '&limit=' . $limit : '') . (!empty($modelHome->title) ? '&q=' . $modelHome->title : '');
        //$data['home']         = $this->linkUrl('category', $modelHome->category);
        $data['home'] = 'http://' . $_B['info_cache']['domain'] . '/album.html';

        $limit            = $modelHome->limit            = ($limit != '' ? $limit : 20);
        $start            = ($this->p - 1) * $limit;
        $modelHome->start = ($start != '' ? $start : 0);

        $data['no_img'] = 'upload/web/1/1/no-img.gif';

        $data['albumList'] = $modelHome->showAlbum();
        if (isset($data['albumList'])) {
            foreach ($data['albumList'] as $k => $v) {
                if ($this->id->last == 0) {
                    $cate_id = explode(",", $v['category_id']);
                    $cate_id = array_filter($cate_id);
                    $cate_id = array_unique($cate_id);
                    $cate_id = $cate_id[1];
                    $href    = $this->linkUrl('detail', 'view', $cate_id . '_' . $v[$modelHome->id_field_public], $v['alias']);
                } else {
                    $href = $this->linkUrl('detail', 'view', $this->id->string . $v[$modelHome->id_field_public], $v['alias']);
                }
                $v['link']             = $href; //$this->linkUrl('detail','view',$v['id']);
                $data['albumList'][$k] = $v;

            }

            $data['pagination'] = $this->pagination($limit, $modelHome->total, null, 5);
            //breadcrumbs
            $breadcrumbsHomeModule = array(
                'text' => (!empty($homeConfig['title']) ? $homeConfig['title'] : lang('module_name')),
                'href' => $modelHome->url_mod,
            );
            foreach ($this->id->ids as $id) {
                $cat                    = $modelHome->showCateById($id);
                $breadcrumbs_title[$id] = $cat['title'];
            }
            $breadcrumbs = array(
                'title' => $breadcrumbs_title,
                'page'  => 'category',
                'sub'   => '',
            );
            $data['breadcrumbs'] = $this->setBreadcrumbs($breadcrumbs, $breadcrumbsHomeModule);
            //breadcrumbs end
            $data['restmedia'] = rand();
            //Chi mo 1 vai website thoi
            $data['child_category'] = $modelHome->getChild();
            //danh muc la day
            $data['cateList'] = $modelHome->showCate();
            if (!empty($data['cateList'])) {
                foreach ($data['cateList'] as $k => $v) {
                    $v['link']            = linkUrl($web, 'album', 'category', 'album', $this->id->string . $v[$modelHome->id_field_public], $v['alias']); //$this->linkUrl('category',$v['id']);
                    $data['cateList'][$k] = $v;
                }
            }
            
            //run it
            $this->setTitle($head);
            
            // $str = substr($_SERVER['REQUEST_URI'],1);
            // preg_match('/([a-zA-Z0-9-]+)-2-3-([0-9]+).html/',$str,$match);
            // if(isset($match[1])){  
            //         $tmp_alias=$match[1];   
            // }
            // if($tmp_alias!=$cat['alias']){     
            //         header('Location: /');
            // }
             

            $this->setContent($data, 'home');

        } else {

            //khong tim thay gi
            if (!empty($data['search_string'])) {
                $head = array(
                    'title' => $modelHome->html_decode(($meta['meta_title'] != '' ? $meta['meta_title'] : $meta['title']) . ' - ' . lang('tim_kiem')),
                );

                $data['home']  = $this->linkUrl('category', $modelHome->category);
                $data['alert'] = lang('could_not_find_any_results') . ' (' . $data['search_string'] . ')';
            }
            $this->notFound('home');
        }

    }

    public function notFound($temp) {
        //Trang bạn tìm kiếm không tồn tại
        $data['breadcrumbs'][] = array(
            'text'      => lang('title_notfound'),
            'href'      => '#',
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
        //Gọi hàm đưa nội dung ra ngoài giao diện
        $this->setTitle($head);
        $this->setContent($data, $temp);
    }
}
?>