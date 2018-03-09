<?php
/**
 * @Project BNC v2 -> Module Category
 * @File category/controller/detail.php
 * @Author An Nguyen Huu(annh@webbnc.vn)
 * @Createdate 11/18/2014, 10:25 AM
 */
if (!defined('BNC_CODE')) {
    exit('Access Denied');
}
Class Detail extends Controller {

    public function view() {
        global $_B, $web;
        $uri = $_B['curUrl']['URI'];
        $re  = "/^\/(.*)\.html/";
        preg_match($re, $uri, $uriNew);
        $data['curUrl'] = $uriNew[0];

        $modelCategory = $this->loadModel('category');
        //$curUrl = $this->linkUrl('detail','view',$id);
        $id                    = $this->request->get_string('id', 'GET');
        $category              = $modelCategory->getDetail($id);
        $breadcrumbsHomeModule = array(
            'text' => lang('title_category'),
            'href' => $this->linkUrl('category'),
        );
        if (isset($this->id->ids) && $this->id->count == 1) {
            $breadcrumbs_title[$this->id->last] = $category['title'];
            $breadcrumbs                        = array(
                'title' => $breadcrumbs_title,
                'page'  => 'detail',
                'sub'   => 'view',
            );
            $data['breadcrumbs'] = $this->setBreadcrumbs($breadcrumbs, $breadcrumbsHomeModule);
        }
        $tags = explode(',', $category['meta_keyword']);
        foreach ($tags as $k => $v) {
            if (!empty($v)) {
                $href         = $this->linkUrl('meta_keyword', fixTitle(trim($v)));
                $tagss[$href] = $v;
            }
        }
        if ($category['create_time'] == false) {
            $category['create_time'] = $category['update_time'];
        }

        $data['categoryDetail'] = array(
            'id'               => $category[$this->id_field],
            'title'            => $category['title'],
            'details'          => htmlspecialchars_decode(html_entity_decode(urldecode($category['details']))),
            'create_time'      => date("H:i:s d-m-Y", $category['create_time']),
            'tags'             => (isset($tagss)) ? $tagss : null,
            'meta_description' => $category['meta_description'],
            'view'             => $category['view'],
            'img'              => $category['img'],
            'icon'             => $category['icon'],
            'bg'               => $category['bg'],
        );

        if ($data['categoryDetail']['title'] != false) {
            $title = $data['categoryDetail']['title'];
        } else {
            $title = lang('title_category');
        }
        $head = array(
            'title'       => $title,
            'keywords'    => $category['meta_keyword'],
            'description' => $category['meta_description'],
            //lang('description_category'))
        );
        $head = array(
            'title'         => $title,
            'keywords'      => $category['meta_keyword'],
            'description'   => $category['meta_description'],
            'ogtitle'       => $title,
            'ogsite_name'   => $title,
            'ogdescription' => $category['meta_description'],
        );

        $this->setTitle($head);
        $data['categoryDetail']['details'] = $this->getForm($data['categoryDetail']['details']);
        if ($_COOKIE['sv']) {
            var_dump($data);
        }
        $modelCategory->setView($id, $category['view']);
        $this->setContent($data, 'category_details');
    }
}