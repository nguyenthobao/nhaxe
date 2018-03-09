<?php
/**
 * @Project BNC v2 -> News
 * @File /controller/ajax.php
 * @Createdate 08/24/2014, 13:32 PM
 */
if (!defined('BNC_CODE')) {
    exit('Access Denied');
}

class ajax extends Controller {
    public function loadcate() {
        global $_B;
        $id     = $_B['r']->get_int('key', 'POST');
        $action = $_B['r']->get_string('action', 'POST');
        $cat    = $this->loadModel('category');
        if (!empty($action)) {
            $tmp = $cat->$action($id);
            if (isset($tmp)) {
                foreach ($tmp as $_news) {
                    $data['newsItem'][$_news[$this->id_field]] = $this->formatNews($_news);
                }
            }
        }
        $data['ajax']        = true;
        $data['mod_in_home'] = 'news';
        $this->setContent($data, 'homes/newsItemCat');
    }
    /**
     * @param $_news
     * @return mixed
     */
    private function formatNews($_news) {
        global $_B;
        $id    = $_news[$this->id_field];
        $thumb = $this->loadImage($_news['img'], 'crop', 300, 180);
        $href  = $this->linkUrl('detail', 'view', $this->id->string . $id, $_news['alias']);
        $newsS = array(
            'id'    => $id,
            'title' => $_news['title'],
            'short' => $_news['short'],
            'thumb' => $thumb,
            'img'   => $_news['img'],
            'href'  => $href,
        );
        return $newsS;
    }
}
