<?php
/**
 * @Project BNC v2 -> Controller
 * @File includes/class/controller.php
 * @author Ba Huong Nguyen (nguyenbahuong156@gmail.com)
 * @Createdate 10/27/2014, 12:28 [ AM]
 */
if (!defined('BNC_CODE')) {
    exit('Access Denied');
}
Class Controller {
    /**
     * @var mixed
     */
    public $idw, $id, $lang, $page, $mod, $request, $cf, $id_field = 'id';
    /**
     * @var array
     */
    private $data = array();
    /**
     * @param $sub
     */
    public function __construct($sub = null) {
        global $_B, $web, $mod;
        $this->mod     = $mod;
        $this->page    = get_class($this);
        $this->sub     = ($sub != null) ? $sub : $_B['r']->get_string('sub', 'GET');
        $this->idw     = $web['idw'];
        $this->request = $_B['r'];
        $this->lang    = $_B['lang'];
        if ($this->lang != 'vi') {
            $this->id_field = 'id_lang';
        }
        $p       = $_B['r']->get_string('p', 'GET');
        $this->p = ($p) ? $p : 1;
        if (empty($this->sub)) {
            $this->sub = 'index';
        }
        $this->curUrl   = $_B['curUrl']['URI_Not_dotExtension'];
        $this->fullLink = $_B['curUrl']['fullLink'];
        $this->parseId();
        $this->setDataDefault();
        if ($this->mod == 'news' || $this->mod == 'album' || $this->mod == 'maps' || $this->mod == 'qaa' || $this->mod == 'recruit') {
            $this->getConfigModule();
        }

    }
    /**
     * @return mixed
     */
    public function getData() {

        $this->data['content'] = $this->data[$this->data['key']];
        unset($this->data[$this->data['key']]);

        return $this->data;
    }

    private function setDataDefault() {
        global $web;
        $this->data = array(
            'ajax'      => false,
            'ajax_temp' => false,
            'head'      => array(
                'link'          => $web['home_url'],
                'title'         => $web['info']['meta_title'],
                'keywords'      => $web['info']['meta_keyword'],
                'description'   => $web['info']['meta_description'],
                'favicon'       => $web['info']['icon'],
                'image'         => $web['info']['img'],
                'ogtitle'       => $web['info']['meta_title'],
                'ogimage'       => $web['info']['img'],
                'ogsite_name'   => $web['info']['business'],
                'ogdescription' => $web['info']['meta_description'],
                'ogadmins'      => $web['info']['facebook_admin'],
            ),
        );
    }
    /**
     * @param $value
     */
    protected function setTitle($value = null) {
        if ($value != null) {
            foreach ($this->data['head'] as $k => $v) {
                if (!empty($value[$k])) {
                    $this->data['head'][$k] = $value[$k];
                }
            }
        }
    }
    /**
     * @param $value
     * @param $temp
     */
    protected function setContent($value, $temp = null) {
        $value['curUrl']                = $this->fullLink;
        $this->data['key']              = $this->mod . '_' . $this->page . '_' . $this->sub . '_' . $this->id->last;
        $this->data[$this->data['key']] = $value;
        $this->data['ajax']             = (isset($value['ajax'])) ? $value['ajax'] : false;
        $this->data['load_temp']        = $temp;

    }
    /**
     * @param $model
     */
    public function loadModel($model) {

        $file = DIR_MODULES . $this->mod . "/model/" . $model . ".php";
        if (file_exists($file)) {
            include_once $file;
            $class = 'Model' . preg_replace('/[^a-zA-Z0-9]/', '', $model);

            return new $class($this->id_field);
        } else {
            trigger_error('Error: Không thể load model ' . $model . '!');
        }

    }
    /**
     * @param $string
     * @param $start
     * @param $end
     * @return mixed
     */
    public function cut_string($string, $start, $end) {
        $new_string = mb_substr(strip_tags(html_entity_decode($string, ENT_QUOTES, 'UTF-8')), $start, $end);

        return $new_string;
    }
    /**
     * @param $img
     * @param $op
     * @param $width
     * @param null $height
     */
    public function loadImage($img, $op = 'resize', $width = null, $height = null) {
        return loadImage($img, $op, $width, $height);
    }
    /**
     * @return mixed
     */
    private function parseId() {
        global $_B;
        $this->id         = new stdClass();
        $this->id->string = '';
        $this->id->count  = 0;
        $ids              = array();
        $id               = $_B['r']->get_string('id', 'GET');
        if (empty($id)) {
            $this->id->last = 0;
        } else {
            $ids             = explode('_', $id);
            $count           = count($ids);
            $this->id->ids   = $ids;
            $this->id->count = $count;
            $this->id->first = array_shift($ids);
            $this->id->last  = (int) array_pop($ids);
            if ($count >= 2) {
                $string = '';
                foreach ($ids as $k => $v) {
                    $string .= $v . '_';
                }
                $this->id->string = $this->id->first . '_' . $string . $this->id->last . '_';
            } else if ($count == 1) {
                $this->id->last   = $this->id->first;
                $this->id->string = $this->id->last . '_';
                $this->id->first  = '';
            }
        }

        return $this->id;
    }

    /**
     * @param $br
     * @param array $breadHomeModule
     * @param $breadcrumbs_cat
     * @param null $breadcrumbs_news
     * @return mixed
     */
    public function setBreadcrumbs($br = null, $breadHomeModule = array(), $breadcrumbs_cat = null, $breadcrumbs_news = null) {
        global $web;

        if (!isset($br['page'])) {$page = $this->page;} else { $page = $br['page'];}
        if (!isset($br['sub'])) {$sub = $this->sub;} else { $sub = $br['sub'];}

        //Tạo breadcrumbs mặc định của trang chủ
        $breadcrumbs   = array();
        $breadcrumbs[] = array(
            'text'      => lang('home'),
            'href'      => $web['home_url'],
            'separator' => false,
        );
        if (isset($breadHomeModule)) {
            $breadcrumbs[] = array(
                'text'      => (isset($breadHomeModule['text'])) ? $breadHomeModule['text'] : '',
                'href'      => (isset($breadHomeModule['href'])) ? $breadHomeModule['href'] : '',
                'separator' => true,
            );
        }
        if ($this->id->count >= 2) {
            //set breadcrumbs
            $id_string = '';
            foreach ($this->id->ids as $v) {
                $id_string .= $v . '_';
                $id = preg_replace('/_$/', '', $id_string);
                if (isset($br['alias'][$v])) {
                    $alias = $br['alias'][$v];
                } else {
                    $alias = fixTitle($br['title'][$v]);
                }

                $breadcrumbs[] = array(
                    'text'      => $br['title'][$v],
                    'href'      => $this->linkUrl($page, $sub, $id, $alias),
                    'separator' => true,
                );
            }

            if (isset($breadcrumbs_news)) {
                $breadcrumbs[] = array(
                    'text'      => $breadcrumbs_news['text'],
                    'href'      => $breadcrumbs_news['href'],
                    'separator' => true,
                );
            }
        } elseif ($this->id->count == 1) {
            //Tạo breadcrumbs trang tin tức

            if (isset($breadcrumbs_cat)) {
                if (isset($breadcrumbs_cat['text'])) {
                    $breadcrumbs[] = array(
                        'text'      => $breadcrumbs_cat['text'],
                        'href'      => $breadcrumbs_cat['href'],
                        'separator' => true,
                    );
                } else {
                    foreach ($breadcrumbs_cat as $k => $v) {
                        $breadcrumbs[] = array(
                            'text'      => $v['text'],
                            'href'      => $v['href'],
                            'separator' => true,
                        );
                    }
                }
                if (isset($br['alias'][$this->id->last])) {
                    $alias = $br['alias'][$this->id->last];
                } else {
                    $alias = fixTitle($br['title'][$this->id->last]);
                }

                //Tạo breadcrumbs cuối cùng (Tức danh mục hiện tại đang xem)
                $breadcrumbs[] = array(
                    'text'      => $br['title'][$this->id->last],
                    'href'      => $this->linkUrl($page, $sub, $breadcrumbs_cat['id'] . '_' . $this->id->last, $alias),
                    'separator' => true,
                );
            } else {
                //Tạo breadcrumbs cuối cùng (Tức danh mục hiện tại đang xem)
                $breadcrumbs[] = array(
                    'text'      => $br['title'][$this->id->last],
                    'href'      => $this->linkUrl($page, $sub, preg_replace('/_$/', '', $this->id->string)),
                    'separator' => true,
                );
            }

        }
        $br_clear = array();
        foreach ($breadcrumbs as $k => $v) {
            $br_clear[] = $v['text'];
        }

        foreach ($br_clear as $k => $v) {
            unset($br_clear[$k]);
            if (in_array($v, $br_clear) || $v == false) {
                unset($breadcrumbs[$k]);
            }
        }

        $breadcrumbs_new = array();
        foreach ($breadcrumbs as $v) {
            $breadcrumbs_new[] = $v;
        }
        
        return $breadcrumbs_new;
    }
    /**
     * @param $page
     * @param $sub
     * @param null $id
     * @param null $alias
     * @param null $notRewrite
     */
    public function linkUrl($page, $sub = null, $id = null, $alias = null, $notRewrite = null) {
        global $web, $mod;

        return linkUrl($web, $mod, $page, $sub, $id, $alias, $notRewrite);
    }
    /**
     * @return mixed
     */
    public function getConfigModule() {
        global $_B;
        $this->cf = new stdClass();
        //$cfs      = new Model($this->lang . '_config');
        //$exist    = $cfs->existTable();
        $db    = db_connect_mod($_GET['mod']);
        $exist = 1;
        if ($exist == 1) {
            $cfs = new Model($this->lang . '_config', $db);
            $cfs->where('idw', $this->idw);
            $cfss = $cfs->get(null, null, '`key`,value_string');
            foreach ($cfss as $v) {
                if (empty($v['value_string'])) {
                    continue;
                }

                $this->cf->{$v['key']} = json_decode($v['value_string'], true);
            }
        } else {
            $this->cf = false;
        }

        return $this->cf;

    }
    /**
     * @param $limit
     * @param $total
     * @param $href
     * @param null $max_item
     * @return mixed
     */
    public function pagination($limit, $total, $href = null, $max_item = null) {
        include_once DIR_CLASS . "pagination.php";
        if ($href == null) {
            $href = $this->curUrl;
            $rule = '/-p[0-9]+$/';
            $href = preg_replace($rule, '', $href);
        }

        $pagination = new Pagination($href, $limit, $total, $max_item = 10);

        return $pagination->pagination;
    }

    /**
     * @param $content
     * @return mixed
     */
    public function getForm($content = null) {
        global $_B, $webObj;
        $regex = preg_match('/\{\[form=([0-9]+)\]\}/i', $content, $match);
        if (isset($match[1]) && $match[1] != false) {
            $form = $this->printForm($match[1]);
            $form = str_replace('id="formCustom_' . $match[1] . '"', 'id="formCustom_' . $match[1] . '" role="form"', $form);
            // $form = str_replace('<label>', '<div class="form-group"><label>', $form);
            $form = str_replace('<select', '<select class="form-control"', $form);
            //$form = str_replace('</select>', '</select>', $form);
            //$form = str_replace('</textarea>', '</textarea>', $form);
            $form = str_replace('<textarea', '<textarea class="form-control"', $form);
            $form = str_replace('<input', '<input class="form-control"', $form);

            //label

            preg_match_all("/<label>(.*)<\\/label>/", $form, $matches_lb);
            if (isset($matches_lb[0])) {
                foreach ($matches_lb[0] as $k => $v) {
                    $form = str_replace($v, '<div class="form_custom_' . $match[1] . '_input_' . $k . '">' . $v, $form);
                }
            }

            preg_match_all("/<input(.*)\\/>/", $form, $matches_input);
            if (isset($matches_input[0])) {
                unset($matches_input[0][count($matches_input[0]) - 1]);
                foreach ($matches_input[0] as $k => $v) {
                    $form = str_replace($v, $v . '</div>', $form);
                }
            }

            $form = str_replace('</textarea>', '</textarea></div>', $form);
            $form = str_replace('</select>', '</select></div>', $form);

            //$form=str_replace('<label>', '<div class=""><label>', $form);
            //Button
            // preg_match_all("/<input(.*)/", $form, $matches);
            // if (isset($matches[1])) {
            //     foreach ($matches[1] as $k => $v) {
            //         preg_match("/type=\"hidden\"/i", $v, $tmp_match);
            //         if (!isset($tmp_match[1])) {
            //             //$form = str_replace($matches[0][$k], '<input class="form-control" ' . $v . '</div>', $form);
            //             $form = str_replace($matches[0][$k], '<input class="form-control" ' . $v, $form);
            //         }
            //     }
            // }
            $form = preg_replace("/type=\"submit\"/i", 'type="submit" class="btn btn-success"', $form);
            $form = preg_replace("/type=\"reset\"/i", 'type="reset" class="btn btn-danger"', $form);
            preg_match_all("/<button(.*)/", $form, $matches_btn);
            if (isset($matches_btn[1])) {
                foreach ($matches_btn[1] as $k => $v) {
                    if ($k == 0) {
                        $form = str_replace($matches_btn[0][$k], '<br/>' . $matches_btn[0][$k], $form);
                    }

                }
            }

            return str_replace('{[form=' . $match[1] . ']}', $form, $content);
        } else {
            return $content;
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function printForm($id) {
        global $_B,$web;
        $formObj = new Model('template.' . $this->lang . '_formcustom');
        $formObj->where('idw', $web['idw']);
        $formObj->where('id_form', $id);
        $formObj->where('status', 1);
        $forms = $formObj->getOne(null, 'id,id_lang,form_frontend,title,status,id_form');
        if ($forms['id_lang'] != false) {
            $forms['id'] = $forms['id_lang'];
        }
        $form = '<div class="form_' . $forms['id_form'] . '_title_"><p class="text-center text-danger p_form_' . $forms['id_form'] . '_title_">' . $forms['title'] . '</p></div>';
        //Notify
        if (isset($_SESSION['notify_form'])) {
            if ($web['idw'] == 693) {
                $form .= '<div class="alert alert-success">
                            Cảm ơn bạn đã gửi yêu cầu, yêu cầu của bạn đã được gửi thành công.
                         </div>';
            } else {
                $form .= '<div class="alert alert-success">
                            <strong>Thành công!</strong> Thông tin của bạn đã được gửi tới chủ website.
                         </div>';
            }
            unset($_SESSION['notify_form']);
        }
        $capcha = $_B['captcha'];
        $tailai = 'https://cdn-gd-v2.webbnc.net/modules/contact/themes/resource/img/view-refresh-small.png';
        $form .= '<form id="formCustom_' . $forms['id_form'] . '" method="POST" action="' . $web['home_url'] . '/template-form-add' . $web['dotExtension'] . '" name="formCustom_' . $forms['id'] . '"  enctype="multipart/form-data">';
        $form .= $forms['form_frontend'];
        $form .='<div class="form-group check_capcha" >
                <input type="hidden" name="captcha" id="cap_md" value="0" />
                <div class="col-md-9">
                    <img id="capt_img_ct" src="'.$capcha.'" /> <img title="Tải lại mã capcha" id="f5capt_cha" src="'.$tailai.'" /> 
                    <div style="float: left; padding: 1px 5px 0 0; width: 40%;"><input type="text" class="form-control" name="captcha" value="" /></div>
                    <div class="warning" id="capchaError"  style="display:none" ><span style="color: red;">Capcha</span></div>
                </div>


            </div>';
        $form .= '<input type="hidden" name="lang" value="' . $this->lang . '" />';
        $form .= '<input type="hidden" name="form_id" value="' . $forms['id'] . '" />';
        $form .= '</form>';

        return $form;
    }
    
    /**
     * @param $url
     * @param $token
     */
    public function GetAnvui($url,$token){
        if(empty($token)){
            $token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ2IjowLCJkIjp7InVpZCI6IkFETTExMDk3Nzg4NTI0MTQ2MjIiLCJmdWxsTmFtZSI6IkFkbWluIHdlYiIsImF2YXRhciI6Imh0dHBzOi8vc3RvcmFnZS5nb29nbGVhcGlzLmNvbS9kb2JvZHktZ29ub3cuYXBwc3BvdC5jb20vZGVmYXVsdC9pbWdwc2hfZnVsbHNpemUucG5nIn0sImlhdCI6MTQ5MjQ5MjA3NX0.PLipjLQLBZ-vfIWOFw1QAcGLPAXxAjpy4pRTPUozBpw';
        }
        $request_header = [
            'Content-Type:application/json',
            sprintf('DOBODY6969: %s', $token)
        ];
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $url.'&timeZone=7');
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch,CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($ch,CURLOPT_TIMEOUT, 30);
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $request_header);

        $response = curl_exec($ch);
        return json_decode($response,1);
    }
     public function PostAnvui($url,$data,$token){
        $data['timeZone'] = 7;
        if(empty($token)){
            $token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ2IjowLCJkIjp7InVpZCI6IkFETTExMDk3Nzg4NTI0MTQ2MjIiLCJmdWxsTmFtZSI6IkFkbWluIHdlYiIsImF2YXRhciI6Imh0dHBzOi8vc3RvcmFnZS5nb29nbGVhcGlzLmNvbS9kb2JvZHktZ29ub3cuYXBwc3BvdC5jb20vZGVmYXVsdC9pbWdwc2hfZnVsbHNpemUucG5nIn0sImlhdCI6MTQ5MjQ5MjA3NX0.PLipjLQLBZ-vfIWOFw1QAcGLPAXxAjpy4pRTPUozBpw';
        }
        $request_header = [
            'Content-Type:application/x-www-form-urlencoded',
            sprintf('DOBODY6969: %s', $token)
        ];

        $ch = curl_init();

     
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $request_header);
 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec ($ch);

        curl_close ($ch);


        // $ch = curl_init();
        // curl_setopt($ch,CURLOPT_URL, $url);
        // curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
        // curl_setopt($ch,CURLOPT_SSL_VERIFYHOST, false);
        // curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);

        // curl_setopt($ch,CURLOPT_FOLLOWLOCATION, false);
        // curl_setopt($ch,CURLOPT_TIMEOUT, 30);
        // curl_setopt($ch,CURLOPT_CONNECTTIMEOUT, 30);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, $request_header);

        // $response = curl_exec($ch);
        return json_decode($response,1);
    }

}
?>