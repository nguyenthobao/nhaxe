<?php
/*
 * @Project BNC V2
 * @Author Lư Chí Tâm (tamlc@webbnc.vn)
 * Frontend Album Home Controller
 */
if (!defined('BNC_CODE')) {
    exit('Access Denied');
}

/**
 * album home
 */
class home extends Controller {
    /*
     *show album
     */
    public function album() {
        global $web;
        $modelHome           = $this->loadModel('home');
        $homeConfig          = @$this->cf->home_config;
        $modelHome->order_by = $homeConfig['display_sort'];
        if (in_array($this->request->get_string('sort', 'GET'), array('new', 'hot', 'az'))) {
            $modelHome->order_by = $this->request->get_string('sort', 'GET');
        }
        $data['sort']          = $modelHome->order_by;
        $data['search_string'] = $modelHome->title = htmlspecialchars($this->request->get_string('q', 'GET'), ENT_QUOTES);

        //home info
        $data['home_title']        = $homeConfig['title'];
        $data['home_description']  = $homeConfig['description'];
        $data['home_avatar']       = $homeConfig['avatar'];
        $data['home_icon']         = $homeConfig['icon'];
        $data['home_bg_image']     = (!empty($homeConfig['bg_image']) ? HTTP_STATIC . $homeConfig['bg_image'] : '');
        $data['home_display_type'] = (isset($homeConfig['display_type']) ? $homeConfig['display_type'] : '');

        $title = ($homeConfig['meta_title'] != '' ? $homeConfig['meta_title'] : $homeConfig['title']) . (!empty($data['search_string']) ? ' - ' . lang('module_name') : '');
        $head  = array(
            'link'          => $web['home_url'].'/album.html',
            'title'         => $modelHome->html_decode($title),
            'keywords'      => $modelHome->html_decode($homeConfig['meta_keywords']),
            'description'   => $modelHome->html_decode($homeConfig['description']),
            'ogtitle'       => $modelHome->html_decode($title),
            'ogimage'       => HTTP_STATIC . $homeConfig['avatar'],
            'ogsite_name'   => $modelHome->html_decode($homeConfig['meta_keywords']),
            'ogdescription' => $modelHome->html_decode($homeConfig['description']),
        );

        $limit                = $data['default_limit']                = $homeConfig['display_number'];
        $get_limit            = $this->request->get_int('limit', 'GET');
        $data['search_limit'] = '';
        if ($get_limit AND $data['default_limit'] != $get_limit AND $get_limit > $limit AND $get_limit < 100) //max record 100
        {
            $data['search_limit'] = $limit = $this->request->get_int('limit', 'GET');
        }

        //
        $modelHome->urlCustom($modelHome->url_mod);
        $data['url_sort_new'] = $modelHome->sortLink . '?sort=new' . (!empty($data['search_limit']) ? '&limit=' . $limit : '') . (!empty($modelHome->title) ? '&q=' . $modelHome->title : '');
        $data['url_sort_hot'] = $modelHome->sortLink . '?sort=hot' . (!empty($data['search_limit']) ? '&limit=' . $limit : '') . (!empty($modelHome->title) ? '&q=' . $modelHome->title : '');
        $data['url_sort_az']  = $modelHome->sortLink . '?sort=az' . (!empty($data['search_limit']) ? '&limit=' . $limit : '') . (!empty($modelHome->title) ? '&q=' . $modelHome->title : '');
        $data['home']         = $modelHome->url_mod;

        $limit            = $modelHome->limit            = ($limit != '' ? $limit : 20);
        $start            = ($this->p - 1) * $limit;
        $modelHome->start = ($start != '' ? $start : 0);

        $data['no_img'] = 'upload/web/1/1/no-img.gif';

        $data['albumList'] = $modelHome->showAlbum();
        if (isset($data['albumList'])) {
            foreach ($data['albumList'] as $k => $v) {
                $v['link']             = $this->linkUrl('detail', 'view', $v['id'], $v['alias']);
                $data['albumList'][$k] = $v;
            }

            $data['pagination'] = $this->pagination($limit, $modelHome->total, null, 5);
            //Chi mo 1 vai website thoi
            $data['child_category'] = $modelHome->getChild();
            //danh muc la day
            $data['cateList'] = $modelHome->showCate();
            if (!empty($data['cateList'])) {
                foreach ($data['cateList'] as $k => $v) {
                    $v['link']            = $this->linkUrl('category', null, $v['id'], $v['alias']);
                    $data['cateList'][$k] = $v;
                }
            }
            //breadcrumbs
            $breadcrumbsHomeModule = array(
                'text' => (!empty($homeConfig['title']) ? $homeConfig['title'] : lang('module_name')),
                'href' => $modelHome->url_mod,
            );

            $data['breadcrumbs'] = $this->setBreadcrumbs(null, $breadcrumbsHomeModule);
            //breadcrumbs end
            $data['restmedia'] = rand();
            $this->setTitle($head);
            $this->setContent($data, 'home');
        } else {
            $data['alert'] = lang('no_record_exists');
            //khong tim thay gi
            if (!empty($data['search_string'])) {
                $head = array(
                    'title' => $modelHome->html_decode($title),
                );
                $data['alert'] = lang('could_not_find_any_results') . ' (' . $data['search_string'] . ')';
            }
            $this->setTitle($head);
            $this->setContent($data, 'home');
            //$this->notFound('home');
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