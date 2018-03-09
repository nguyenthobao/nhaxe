<?php
/**
 * @Project BNC v2 -> Module Info
 * @File info/controller/info.php
 * @Author An Nguyen Huu (annh@webbnc.vn)
 * @Createdate 11/18/2014, 09:25 AM
 */
if (!defined('BNC_CODE')) {
    exit('Access Denied');
}
Class Info extends Controller {
    public function index() {
        global $_B, $web;
        $uri = $_B['curUrl']['URI'];
        $re  = "/^\/(.*)\.html/";
        preg_match($re, $uri, $uriNew);
        $data['curUrl'] = $uriNew[0];

        $modelInfo = $this->loadModel('info');

        $infoS = $modelInfo->getInfoList();
        $total = $modelInfo->totalInfo();
        // echo "<pre>";
        // print_r($total);
        // echo "</pre>";
        if (isset($infoS)) {
            //Set nội dung cho header
            $head = array(
                'title'       => lang('title_info'),
                'keywords'    => lang('keyword_info'),
                'description' => lang('description_info'),
            );
            //set title breadcrumbs
            // $breadcrumbsHomeModule = array(
            //     'text'        => lang('title_info'),
            //     'href'      => '',
            //     );
            if (isset($infoS)) {
                foreach ($infoS as $info) {

                    $data['info'][$info[$this->id_field]] = $this->formatInfo($info);
                }
            } else {
                echo lang('notfound_data');
            }

            $breadcrumbsHomeModule = array(
                'text' => lang('title_info'),
                'href' => $modelInfo->url_mod,
            );

            $data['breadcrumbs'] = $this->setBreadcrumbs(null, $breadcrumbsHomeModule);
            unset($infoS);
            //Phân trang
            $data['pagination'] = $this->pagination(10, $total);
            //Gọi hàm set dữ liệu lên header
            $this->setTitle($head);
            //Gọi hàm đưa nội dung ra ngoài giao diện
            $this->setContent($data, 'info');
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
            $this->setContent($data, 'news_not_found');
        }
    }
    private function formatInfo($info) {
        global $_B;
        $id    = $info[$this->id_field];
        if ($this->id->last == 0) {
            $href = $this->linkUrl('detail', 'view', $this->id->string . $id, $info['alias']);
        }
        $infoS = array(
            'id'    => $id,
            'title' => $info['title'],
            'short' => $info['short'],
            'sort' => $info['sort'],
            'thumb' => $info['img'],
            'img'   => $info['img'],
            'href'  => $href,
        );
        return $infoS;
    }
}