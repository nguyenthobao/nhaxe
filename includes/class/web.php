<?php
/**
 * @project BNC v2 -> Frontend
 * @file /includes/class/web.php
 * @createdate 10/23/2014, 11:44 PM
 * @author Quang Chau Tran (quangchauvn@gmail.com)
 */
if (!defined('BNC_CODE')) {
    exit('Access Denied');
}
class Web {
    /**
     * @var mixed
     */
    public $idw;
    /**
     * @var mixed
     */
    public $s_name;
    /**
     * @var mixed
     */
    public $info;
    /**
     * @var mixed
     */
    public $lang;
    /**
     * @var mixed
     */
    public $config;
    /**
     * @var mixed
     */
    public $menu;
    /**
     * @var mixed
     */
    private $db, $r, $cache;
    /**
     * @var string
     */
    private $name_cookie = 'webbnc';
    /**
     * @var mixed
     */
    private $options;
    /**
     * @var mixed
     */
    public $cfAdmin;
    /**
     * @param $value
     * @param $type
     */
    public function __construct($value, $type = 's_name') {
        global $_B, $web;
        $this->cache = $_B['cache'];
        $this->db    = $_B['db'];
        $this->r     = $_B['r'];
        $this->$type = $value;
        //Kiểm tra mobile
        $Mobile_Detect = new Mobile_Detect;

        $Mobile         = $Mobile_Detect->isMobile();
        $Tablet         = $Mobile_Detect->isTablet();
        $this->isMobile = false;

        if ($this->get_info_web()) {
            //Kiểm tra module active
            $mod_active = array_filter(array_values(explode(',', $this->get_config_mod_active()['customs_mod'])));
            if (!empty($mod_active)) {
                $mod_active[] = 'home';
                $mod_active[] = 'user';
                $mod_active[] = 'payment';
                if (!in_array('all', $mod_active) && !in_array($_B['info_cache']['mod'], $mod_active)) {
                    header('location:http://' . $_B['info_cache']['domain']);
                    exit();
                }
            }

            $this->cfF                 = $this->get_config_fe();
            $this->cfAdmin             = $this->get_config_admin();
            $this->info['seo_url_mod'] = json_decode($this->cfAdmin['seo_url_mod'], true);
            $this->name_cookie         = $this->name_cookie . $this->idw;
            $this->checkLogin();
            $this->info['user_info'] = $this->getUserinfo();
            //Config fontend
            $this->info['cfFrontEnd'] = $this->cfF;
            //Thông tin resp
            if (isset($this->cfAdmin['responsive_active']) && $this->cfAdmin['responsive_active'] === 1 && ($Mobile == true || $Tablet == true || isset($_COOKIE['xteam_m']))) {
                $this->info['responsive'] = 1;
                $this->isMobile           = true;
            } else {
                $this->info['responsive'] = 0;
                $this->isMobile           = false;
            }
            //Check type PC
            if (isset($_COOKIE['mobile_to_pc'])) {
                $this->info['responsive'] = 0;
                $this->isMobile           = false;
            }
            if ($Mobile == true || $Tablet == true) {
                $this->info['mobile'] = true;
            } else {
                $this->info['mobile'] = false;
            }
            $this->themeMobile();
            //$this->connectBaokim();
            //Direct primary domain
            //Not direct
            $not_direct = array(5049, 4485, 4138, 1255, 654, 3891, 4152, 873, 4157, 3309, 1151, 1945, 1993, 1389, 429, 2301, 2548, 2588, 2578, 2599, 1654, 2921, 2863, 3709, 3008, 2205, 3828, 2880, 3889, 4496, 4239, 4500, 3925, 2648, 4775, 5101, 4174, 5143, 5223, 5245, 5203, 5280, 4492, 339, 5268, 5271, 6033);
            if ((!isset($_COOKIE['xteam']) && !isset($_COOKIE['truong'])) && ($this->info['domain'] != null && $_B['curDomain'] != $this->info['domain']) && $_B['curDomain'] != 'fbstore.webbnc.vn' && $_GET['w'] != 'demo' && in_array($this->info['idw'], $not_direct) == false) {
                if (isset($_SERVER['REQUEST_URI'])) {
                    header('Location:http://' . $this->info['domain'] . $_SERVER['REQUEST_URI']);
                } else {
                    header('Location:http://' . $this->info['domain']);
                }
            }
        }
        //add public token for apps
        $this->info['tokenforapp'] = $this->getTokenForApps($_B['curUrl']['fullLink']);
        //Đưa ngôn ngữ đang sử dụng vào
        if (isset($_COOKIE['language_cookie_' . $this->info['idw']])) {
            $this->info['lang_use'] = $_COOKIE['language_cookie_' . $this->info['idw']];
        } else {
            $this->info['lang_use'] = $this->cfF['lang'];
        }
        if ($this->info['lang_use'] == false) {
            $this->info['lang_use'] = 'vi';
        }
        //WEBBBNC['lang_use'] = vi || en
        if (count($this->info) <= 2) {
            http_response_code(500);
            header('location: http://'.$_B['home']);
            die();
            //header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
            exit();
        }

        $this->info['currentcy'] = $this->getCurrentcy($this->info);
        $config_theme_cf         = $this->cache->get($this->info['theme_id'] . '_config_theme');
        if (!empty($config_theme_cf) && !isset($_COOKIE['xteam'])) {
            $tmp_theme_cf_content = $config_theme_cf;
        } else {
            $tmp_theme_cf         = $this->info['dir_theme'] . $this->info['theme_id'] . '/config.json';
            $tmp_theme_cf_content = json_decode(file_get_contents($tmp_theme_cf), true);
            $this->cache->set($this->info['theme_id'] . '_config_theme', $tmp_theme_cf_content);
        }
        $this->info['config_theme'] = $tmp_theme_cf_content;

        if (isset($this->cfF['cart_prefix']) && $this->cfF['cart_prefix'] != false) {
            $this->info['cart_prefix'] = $this->cfF['cart_prefix'];
        } else {
            $this->info['cart_prefix'] = 'BNC';
        }

        if (isset($this->cfF['mail_cart']) && $this->cfF['mail_cart'] != false) {
            $this->info['mail_cart'] = json_decode($this->cfF['mail_cart'], true);
        }

    }

    // get public token for apps
    /**
     * @param $url
     */
    private function getTokenForApps($url) {
        global $_B;
        $data = array(
            'idw' => $this->info['idw'],
            'url' => $url,
        );
        if (isset($_B['email'])) {
            $data['email'] = $_B['email'];
        }
        if (isset($_B['uid'])) {
            $data['uid'] = $_B['uid'];
        }
        if (isset($this->info['user_info']['first_name'])) {
            $data['first_name'] = $this->info['user_info']['first_name'];
        }
        if (isset($this->info['user_info']['last_name'])) {
            $data['last_name'] = $this->info['user_info']['last_name'];
        }

        return encode(base64_encode(json_encode($data)), 'qcvn');
    }

    public function generateUrl() {
        global $_B;
        // $cf = new Model('web_cf_front_end');
        // $cfig = $cf->get();

        // foreach ($cfig as $key => $value) {
        //     $cf->where('`key`','copyright');
        //     $cf->where('idw',$value['idw']);
        //     $cf->delete();
        //     $data = array('idw'=>$value['idw'],'key'=>'copyright','value_int'=>1);
        //     //
        //     $cf->insert($data);
        // }

        //$db_news = db_connect_mod('product');
        // $proObj = new Model('vi_brand',$db_news);
        // $result = $proObj->get(null,null,'id,name');
        // foreach ($result as $key => $value) {
        //     $url = utf8_strtolower(fixTitle($value['name']));
        //     $proObj->where('id',$value['id']);
        //     $proObj->update(array('alias'=>'thuong-hieu-'.$url));
        // }
    }

    /**
     * @return mixed
     */
    public function get_menu() {
        global $_B;
        $db_menu    = db_connect_mod('menu');
        $MenuTopObj = new Model($_B['lang'] . '_menu', $db_menu);
        $MenuTopObj->where('idw', $this->idw);
        $MenuTopObj->where('status', 1);
        $MenuTopObj->orderBy('sort', 'ASC');
        $menus = $MenuTopObj->get();
        $menus = $this->recursiveMenu($menus);
        foreach ($menus as $key => $value) {
            $drLink = json_decode($value['direct_link'], 1);
            if ($value['type'] == 1) {
                $menu['top'][$key] = $value;

            } elseif ($value['type'] == 2) {
                $menu['bottom'][$key] = $value;
            }
        }
        //Menu tuỳ chọn
        $db_menu_op    = db_connect_mod('menuOption');
        $MenuOptionObj = new Model($_B['lang'] . '_listinfo', $db_menu_op);
        $MenuOptionObj->where('idw', $this->idw);
        $MenuOptionObj->where('status', 1);
        $MenuOptionObj->orderBy('sort', 'ASC');
        $menuoption     = $MenuOptionObj->get();
        $menuoption     = $this->recursiveMenu($menuoption);
        $menu['option'] = $menuoption;

        return $menu;

    }

    /**
     * Show static url cua giao dien
     */
    public function get_static_theme_mod($module = null) {
        global $mod, $_B;
        if ($module == null) {
            $module = $mod;
        }
        if ($_B['dmr']) {
            $staticUrl = 'http://' . $_B['curDomain'] . '/modules/' . $module . '/themes';
        } else {
            $staticUrl = 'http://' . $_B['curDomain'] . '/modules/' . $module . '/themes';
        }
        $staticUrl = 'https://cdn-gd-v2.webbnc.net/modules/' . $module . '/themes';

        return $staticUrl;
    }

    /**
     * Dang nhap
     */
    public function RegisWebUser($data) {
        if ($data['email'] == '') {
            $return['status'] = false;
            $return['error']  = lang('no_email');

            return $return;
        }
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $return['status'] = false;
            $return['error']  = lang('invalid_email');

            return $return;
        }
        if ($data['username'] == '') {
            $return['status'] = false;
            $return['error']  = lang('no_username');

            return $return;
        }
        if ($data['password'] == '') {
            $return['status'] = false;
            $return['error']  = lang('no_pass');

            return $return;
        }
        if ($data['password'] != $data['repassword']) {
            $return['status'] = false;
            $return['error']  = lang('pass_no_match');

            return $return;
        }
        $userObj = new Model('web_user');
        $userObj->where('idw', $this->idw);
        $userObj->where('email', $data['email']);
        if ($userObj->num_rows() > 0) {
            $return['status'] = false;
            $return['error']  = lang('user_email_exits');

            return $return;
        }
        $userObj = new Model('web_user');
        $userObj->where('idw', $this->idw);
        $userObj->where('username', $data['username']);
        if ($userObj->num_rows() > 0) {
            $return['status'] = false;
            $return['error']  = lang('user_username_exits');

            return $return;
        }
        $datai['password']    = md5($data['password'] . '|quangchauvn');
        $datai['idw']         = $this->idw;
        $datai['email']       = $data['email'];
        $datai['username']    = $data['username'];
        $datai['create_time'] = time();
        $datai['uid']         = $userObj->insert($datai);

        $this->CookieWebUser($datai['email'], 0);
        $return['status'] = true;

        return $return;
    }
    public function LogoutWebUser() {
        global $_B;
        setcookie($this->name_cookie, '', time() - 86400 * 36, '/');
        $userlogin = new Model('web_user_login');
        $userlogin->where('cookie', $_B['cookie']);
        $userlogin->delete();

        return true;
    }

    //Dang ki bang faceboook
    /**
     * @param  $data
     * @return mixed
     */
    public function loginFb($data) {
        $userObj = new Model('web_user');
        $userObj->where('idw', $this->idw);
        $userObj->where('facebook_id', $data['facebook_id']);
        $checkExist = $userObj->num_rows();
        if ($checkExist) {
            //Nếu đã tồn tại thì chuyển qua đăng nhập
            return $this->LoginWebUser($data['email'], 'bnc@123@FB', 1);

        }
        $datai['password']    = md5('bnc@123@FB|quangchauvn');
        $datai['idw']         = $this->idw;
        $datai['email']       = $data['email'];
        $datai['username']    = $data['username'];
        $datai['facebook_id'] = $data['facebook_id'];
        $datai['create_time'] = time();
        $datai['uid']         = $userObj->insert($datai);
        //Chuyển qua đăng nhập
        //Nếu đã tồn tại thì chuyển qua đăng nhập

        return $this->LoginWebUser($datai['email'], 'bnc@123@FB', 1);

    }

    /**
     * @param  $data
     * @return mixed
     */
    public function loginGo($data) {
        $userObj = new Model('web_user');
        $userObj->where('idw', $this->idw);
        $userObj->where('google_id', $data['google_id']);
        $checkExist = $userObj->num_rows();
        if ($checkExist) {
            //Nếu đã tồn tại thì chuyển qua đăng nhập
            return $this->LoginWebUser($data['email'], 'bnc@123@GO', 1);

        }
        $datai['password']    = md5('bnc@123@GO|quangchauvn');
        $datai['idw']         = $this->idw;
        $datai['email']       = $data['email'];
        $datai['username']    = $data['username'];
        $datai['google_id']   = $data['google_id'];
        $datai['create_time'] = time();
        $datai['uid']         = $userObj->insert($datai);
        //Chuyển qua đăng nhập
        //Nếu đã tồn tại thì chuyển qua đăng nhập

        return $this->LoginWebUser($datai['email'], 'bnc@123@GO', 1);

    }

    /**
     * @param  $email
     * @param  $password
     * @param  $remember
     * @param  $idw
     * @return mixed
     */
    public function LoginWebUser($email, $password, $remember, $idw = null) {
        if ($email == '') {
            $return['status'] = false;
            $return['error']  = lang('no_email');

            return $return;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $return['status'] = false;
            $return['error']  = lang('invalid_email');

            return $return;
        }
        if ($password == '') {
            $return['status'] = false;
            $return['error']  = lang('no_pass');

            return $return;
        }
        $password = md5($password . '|quangchauvn');
        $db_user  = db_connect_mod('user');
        $userObj  = new Model('web_user', $db_user);
        if ($idw == null) {
            $userObj->where('idw', $this->idw);
        } else {
            $userObj->where('idw', $idw);
        }
        $userObj->where('email', $email);
        $userObj->where('password', $password);
        $login = $userObj->getOne();
        if (!empty($login)) {
            $return['status'] = true;
            $return['data']   = $login;

            $this->CookieWebUser($email, $remember);
        } else {
            $return['status'] = false;
            $return['error']  = lang('no_email_wrong_pass');
        }

        return $return;
    }
    /**
     * @param  $token
     * @return mixed
     */
    public function compareToken($token) {
        if (!empty($token)) {
            $db_user = db_connect_mod('user');
            $userObj = new Model('web_user_forgot', $db_user);
            $userObj->where('token', $token);
            $userObj->where('status', 1);
            $check = $userObj->getOne();
            if ($check) {
                $result['status'] = true;
            } else {
                $result['status']  = false;
                $result['message'] = "Đường dẫn của bạn đã hết hạn hoặc không tồn tại.";
            }
        } else {
            $result['status']  = false;
            $result['message'] = "Đường dẫn của bạn không hợp lệ.";
        }

        return $result;

    }
    /**
     * @param  $name_or_mail
     * @param  $page_reset
     * @return mixed
     */
    public function forgotPassword($name_or_mail, $page_reset) {
        return false; 
    }
    /**
     * @param  $token
     * @param  $newpassword
     * @param  $confirmpassword
     * @return mixed
     */
    public function resetPassWebUser($token, $newpassword, $confirmpassword) {
        if (!empty($token) && !empty($newpassword) && !empty($confirmpassword)) {
            if ($newpassword === $confirmpassword) {
                $db_user = db_connect_mod('user');
                $userObj = new Model('web_user_forgot', $db_user);
                $userObj->where('token', $token);
                $userObj->where('status', 1);
                $uid = $userObj->getOne();
                if ($uid) {
                    $uObj        = new Model('web_user', $db_user);
                    $newpassword = md5($newpassword . '|quangchauvn');
                    $uObj->where('uid', $uid['uid']);
                    $uObj->update(array('password' => $newpassword));
                    //update lại token
                    $userObj->where('uid', $uid['uid']);
                    $userObj->update(array('status' => 0));
                    $result['status']  = true;
                    $result['message'] = "Thiết lập mật khẩu thành công. Vui lòng đăng nhập lại";
                }
            } else {
                $result['status']  = false;
                $result['message'] = "Mật khẩu mới và mật khẩu xác nhận không giống nhau";
            }

        } else {
            $result['status']  = false;
            $result['message'] = "Không được bỏ trống các trường bắt buộc";
        }

        return $result;
    }
    /**
     * @param $email
     * @param $remember
     */
    private function CookieWebUser($email, $remember) {
        $db_user = db_connect_mod('user');
        $userObj = new Model('web_user', $db_user);
        $userObj->where('idw', $this->idw);
        $userObj->where('email', $email);
        $user = $userObj->getOne();

        if (isset($user['uid'])) {
            $this->setcookie($user, $remember);
        }

        return true;
    }
    /**
     * @param $u
     * @param $remember
     */
    private function setcookie($u, $remember) {
        global $_B;

        if ($remember == 1) {
            $expire = time() + 8640000;
        } else {
            $expire = 0;
        }

        $arr = str_split('ABCDEFGHIJKLMNOPXYZTKUV123456789');
        shuffle($arr);
        $arr    = array_slice($arr, 0, 10);
        $cookie = implode('', $arr);
        $cookie = md5($cookie . '|quangchauvn|' . $this->idw . $u['email']);

        $login_data = array(
            'idw'      => $this->idw,
            'uid'      => $u['uid'],
            'email'    => $u['email'],
            'username' => $u['username'],
            'time'     => time(),
            'expire'   => $expire,
            'cookie'   => $cookie,
            'ip'       => $_B['ip'],
        );
        $db_user   = db_connect_mod('user');
        $userlogin = new Model('web_user_login', $db_user);

        $cookieId = $userlogin->insert($login_data);
        //set cookie
        if ($cookieId) {
            setcookie($this->name_cookie, $cookie, $expire, '/');

            return true;
        } else {
            setcookie($this->name_cookie, '', time() - 86400 * 36, '/');

            return false;
        }
    }
    /**
     * @param $key
     * @param $value
     * @param $password
     */
    public function checkUserWeb($key, $value, $password) {
        $password = md5($password . '|quangchauvn');
        $userObj  = new Model('web_user');
        $userObj->where('idw', $this->idw);
        $userObj->where($key, $value);
        $userObj->where('password', $password);
        if ($userObj->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    private function checkLogin() {
        global $_B;
        $_B['user_url_login'] = linkUrl($this->info, 'user', 'login');
        $_B['user_url_regis'] = linkUrl($this->info, 'user', 'regis');
        $_B['action_login']   = linkUrl($this->info, 'user', 'login', 'submit');
        if (!isset($_COOKIE[$this->name_cookie])) {
            return false;
        }
        $cookie    = $_COOKIE[$this->name_cookie];
        $userlogin = new Model('web_user_login');
        $userlogin->where('cookie', $cookie);
        if ($userlogin->num_rows() > 0) {
            $userlogin->where('cookie', $cookie);
            $datalogin = $userlogin->getOne();
            $_B['uid'] = $datalogin['uid'];
            $user_info = new Model('web_user');
            $user_info->where('uid', $datalogin['uid']);
            $info = $user_info->getOne(null, 'permission,idw');
            //Xu ly tiep theo phan quyen
            $perm_front_arrs = array();
            $perm_txt        = '';
            $perm_front      = array_filter(array_values(explode(',', $info['permission'])));
            if (!empty($perm_front)) {
                foreach ($perm_front as $k => $v) {
                    $obj_perm = new Model('web_features_groups');
                    $obj_perm->where('idw', $info['idw']);
                    $obj_perm->where('id', $v);
                    $res_perm = $obj_perm->getOne(null, 'perm');
                    $perm_txt .= $res_perm['perm'];
                }

                $perm_txt = array_unique(array_filter(array_values(explode(',', $perm_txt))));
                foreach ($perm_txt as $k => $v) {
                    $perm_front_arrs[] = $v;
                }
            }

            //$perm_front_arrs[]=$v;
            $_B['perm']             = $perm_front_arrs;
            $_B['email']            = $datalogin['email'];
            $_B['username']         = $datalogin['username'];
            $_B['avatar']           = 'http://id.webbnc.vn/data/img/avatar_default.jpg';
            $_B['cookie']           = $cookie;
            $_B['user_url_setting'] = linkUrl($this->info, 'user', 'setting');
            $_B['user_url_logout']  = linkUrl($this->info, 'user', 'login', 'logout');
            $this->uid              = $_B['uid'];
        } else {
            return false;
        }

    }
    /**
     * Đệ quy
     */
    private function recursiveMenu($menu, $id_field = 'id', $parent_field = 'parent_id', $parent = 0) {
        global $_B, $web;

        $seo_url_mod = false;
        if (isset($this->cfAdmin['seo_url_mod'])) {
            $seo_url_mod = json_decode($this->cfAdmin['seo_url_mod'], true);
        }

        $current_menus = array();
        foreach ($menu as $key => $value) {
            if ($value[$parent_field] == $parent) {
                $k                 = $value[$id_field];
                $current_menus[$k] = $value;
                unset($menu[$key]);
            }
        }
        if (count($current_menus) > 0) {
            foreach ($current_menus as $key => $value) {
                $drLink = json_decode($value['direct_link'], 1);
                if (empty($value['direct_link']) || ($drLink['page'] == null && $drLink['mod'] == '/')) {
                    $tmp_link = str_replace('http://dev3.webbnc.vn/demo', $this->info['home_url'], $value['link']);
                } else {
                    if (isset($value['title'])) {
                        $title = $value['title'];
                    } elseif ($value['alias']) {
                        $title = $value['alias'];
                    } else {
                        $title = $value['namemenu'];
                    }
                    if ($drLink['page'] == '' && !empty($seo_url_mod[$drLink['mod']])) {
                        $tmp_link = 'http://' . $_B['curDomain'] . '/trang-' . $seo_url_mod[$drLink['mod']] . '.html';
                    } else {
                        $alias = $value['alias'];
                        if ($alias == false) {
                            $alias = fixTitle($title);
                        }
                        $tmp_link = linkUrl($this->info, $drLink['mod'], $drLink['page'], $drLink['sub'], $drLink['id'], $alias);
                    }
                }
                $tmp_link = preg_replace("/(\-)+/i", '-', $tmp_link);
                $tmp_link = preg_replace("/-.html/i", '.html', $tmp_link);

                $current_menus[$key]['link'] = $tmp_link;
                $current_menus[$key]['sub']  = $this->recursiveMenu($menu, $id_field, $parent_field, $value[$id_field]);
            }
        }

        return $current_menus;
    }

    /**
     * Get info web (by idw or by s_name)
     *
     * @return info array
     */
    private function get_info_web() {
        global $_B, $mod;
        $web = new Model('web');
        $web->where('s_name', $this->s_name);
        if ($web->num_rows() == 0) {
            return false;
        }
        if (!empty($this->idw)) {
            $web->where('idw', $this->idw);
        } else {
            $web->where('s_name', $this->s_name);
        }
        $this->info = $web->getOne();
        //check redirect link

        $this->info['domain']        = $this->firstDomain($this->info['domain']);
        $this->idw                   = $this->info['idw'];
        $this->s_name                = $this->info['s_name'];
        $this->info['static_upload'] = $_B['upload_path'];
        if ($this->idw == 1376) {
            $this->info['static_upload'] = preg_replace("/https:\\/\\//", 'http://', $this->info['static_upload']);
        }
        $this->info['layout'] = 'default';
        $this->info['ssl']    = false;
        if ($this->idw == 3789 || $this->idw == 4678 || $this->idw == 5547 || $this->idw == 5624) {
            $this->info['ssl'] = true;
        }

        $cf = $this->get_config_fe();
        if (isset($cf['themes_custom']) && $cf['themes_custom'] == 1) {
            $themes_custom           = 'themes_custom/';
            $this->info['dir_theme'] = DIR_THEME . $themes_custom;
            $this->info['temp']      = $this->info['theme_id'] . '/' . $this->idw;

        } else {
            $themes_custom           = '';
            $this->info['dir_theme'] = DIR_THEME;
            $this->info['temp']      = $this->info['theme_id'];
        }
        $cfAdmin = $this->get_config_admin();

        $_B['curDomain'] = (!empty($cfAdmin['www']) && $cfAdmin['www'] == 1) ? $_B['curDomain'] : str_replace('www.', '', $_B['curDomain']);
        // if ($_COOKIE['sv']) {
        //     header('Location:' . $_B['curDomain']);
        //     exit;
        // }
        if ($_B['dmr']) {
            $this->info['home']        = $_B['curDomain'];
            $this->info['home_url']    = 'http://' . $_B['curDomain'];
            $this->info['static_temp'] = 'http://' . $_B['curDomain'] . '/themes/' . $themes_custom;
        } else {
            $this->info['home']        = $this->info['s_name'].'.anvui.vn';
            $this->info['home_url']    = 'http://' .$this->info['s_name'].'.anvui.vn';
            $this->info['static_temp'] = $_B['static_default'] . $themes_custom;
        }
        if (@$cfAdmin['layout_deal'] == 1) {
            $this->info['layout'] = 'deal';
        }
        $this->info['dotExtension'] = @$cfAdmin['dotExtension']; //'.html'; //Đuôi mở rộng của url
        $this->info['seo_url']      = @$cfAdmin['seo_url'];
        $this->info['vchat']        = $this->getVchat();
        $seo_cf                     = $this->getGa();
        $this->info['ga']           = $seo_cf['ga'];
        $this->info['id_google']    = $seo_cf['id_google'];
        $this->info['name_google']  = $seo_cf['name'];
        $this->info['robots']       = $seo_cf['robots'];

        $infoBasic = new Model('vi_information');
        $infoBasic->where('idw',$this->idw);
        $this->info['basic'] = $infoBasic->getOne();

        $this->getRedirectLink();

        return $this->info;
    }

    public function themeMobile() {
        //Kiểm tra xem có sử dụng phiên bản mobile không
        if ($this->isMobile == true && ($this->cfF['themes_custom'] != 1 || !isset($this->cfF['themes_custom']))) {
            $themes_custom           = '';
            $this->info['dir_theme'] = DIR_THEME;
            if ($this->isMobile == true && file_exists(DIR_THEME . $this->info['theme_id'] . '_m/') == true) {
                $this->info['theme_id'] .= '_m';
            }
            $this->info['temp'] = $this->info['theme_id'];
        }
    }

    private function getVchat() {
        $db = db_connect('user');
        $cf = new Model('web_cf_front_end', $db);
        $cf->where('idw', $this->idw);
        $cf->where('`key`', 'vchat_active');
        $cfVchat = $cf->getOne();
        if (isset($cfVchat['value_int']) && $cfVchat['value_int'] == 1) {
            $cf->where('idw', $this->idw);
            $cf->where('`key`', 'vchat_js');
            $jsVchat = $cf->getOne();
            if ($jsVchat['value_int'] == 1) {
                return base64_decode($jsVchat['value_string']);
            }
        }
    }
    /**
     * [loadLayouts description]
     * @email  truongnx28111994@gmail.com
     * @date   2015-09-08
     * @author Truong Nguyen
     *
     * @param  [type] $router         [description]
     * @param  [type] $category       [description]
     * @return [type] [description]
     */
    public function loadLayouts($router, $category = null) {
        $db     = db_connect();
        $layout = new Model('web_layouts', $db);

        //Xu ly regex
        $regex = false;
        if (!empty($category)) {
            $layout->where('idw', $this->idw);
            $allRouter = $layout->get();
            foreach ($allRouter as $k => $v) {
                if ($regex == false) {
                    $re = "/\\*(.[0-9]+)/i";
                    preg_match($re, $v['router'], $matches);
                    if (isset($matches[1]) && in_array($matches[1], $category) == true) {
                        $regex = $v['layout_name'];
                    }
                }
            }
        }

        if ($regex != false) {
            return $regex;
        } else {
            $routers = explode('-', $router);
            $rout    = $routers[0];
            unset($routers[0]);
            array_push($routers, ""); //thêm 1 phần tử để lặp thêm 1 lần do unset mất 1 phần tử
            foreach ($routers as $k => $v) {
                $layout->where('idw', $this->idw);
                $layout->where('router', $rout);
                $layouts[$k] = $layout->getOne(null, 'layout_name');
                if (!empty($layouts[$k])) {
                    $layoutss = $layouts[$k];
                } else {
                    $layoutss = $layouts[$k - 1];
                }
                $rout .= '-' . $v;
            }
            if (!empty($layoutss)) {
                return $layoutss['layout_name'];
            }
        }

    }
    /**
     * @param  $domain
     * @return null
     */
    private function firstDomain($domain) {
        $domains = explode(",", $domain);
        foreach ($domains as $k => $v) {
            if (!empty($v)) {
                return $v;
            }
        }

        return;
    }
    /**
     * @return null
     */
    public function getLanguage() {
        global $_B, $mod, $web;
        $db       = db_connect('user');
        $mLang    = new Model('language', $db);
        $language = explode(',', $this->config['lang_use']);
        foreach ($language as $k => $v) {
            $mLang->where('code', $v);
            $lang = $mLang->getOne();
            if (!empty($lang)) {
                $langs[] = array(
                    'code'  => $lang['code'],
                    'name'  => $lang['name'],
                    'image' => $lang['image'],
                );
            }
        }
        $cookie_name = 'language_cookie_' . $this->info['idw'];
        if ($_B['lang_default'] != 'vi') {
            $lang_default = 'vi';
            $lang         = $_B['lang_default'];
            //Set cookie
            if (!isset($_COOKIE['language_cookie_' . $this->info['idw']])) {
                setcookie('language_cookie_' . $this->info['idw'], $lang, time() + 84600, '/');
            }
            $_B['lang_default'] = $lang_default;
            $_B['lang']         = $lang;
        }
        if (count($langs) >= 2) {
            return $langs;
        }

        return;
    }

    public function get_info_temp() {
        global $_B;
        if (empty($_B['lang'])){
            $_B['lang'] = 'vi';
        }
        $this->info['logo']       = $this->getLogo();
        $this->info['background'] = $this->getBackground();
        $this->info['audio']      = $this->getAudio();
        $this->info['menu']       = $this->get_menu();
        $this->info['footer']     = $this->getFooter();
        $this->info['info']       = $this->getInfo();
    }
    /**
     * @param $sitemap
     * @param null       $filename
     */
    public function getHtml($url, $post = null) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        if (!empty($post)) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        }
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
    /**
     * @param $sitemap
     * @param null       $filename
     */
    public function genSitemap($sitemap = null, $filename = null) {
        global $_B, $mod;

        $idw = $this->idw;
        //Kiem tra site map custom khong
        $sitemap_custom = DIR_ROOT . 'sitemaps/' . $idw . '/' . $filename;
        if ($filename != null && file_exists($sitemap_custom)) {
            $path_parts = pathinfo($sitemap_custom);

            header('location:http://' . $_SERVER['HTTP_HOST'] . '/sitemaps/' . $idw . '/' . $filename);
            die();
            //$content    = trim(file_get_contents($sitemap_custom));
            // $content = $this->getHtml('http://dtmediavn.com/sitemaps/403/sitemap.xml');
            // $content = trim($content);
            switch ($path_parts['extension']) {
            case 'xml':
                header("Content-type: text/xml");
                break;
            case 'txt':
                header("Content-Type: text/plain");
                break;
            default:
                header("Content-Type: text/html");
                break;
            }
            echo $content;
            die();
        } else {
            if (is_file(DIR_THEME . $this->idw . '/sitemap.xsl')) {
                $idw = $this->idw;
            } else {
                $idw = 1;
            }
            $href = '/themes/' . $idw . '/sitemap.xsl';
            header('Content-Type: application/xml');
            echo '<?xml version="1.0" encoding="utf-8"?>' . "\n";
            echo '<?xml-stylesheet type="text/xsl" href="' . $href . '"?>' . "\n";

            $prio = 1;

            $domain      = $this->info['home_url'];
            $sitemapList = array();
            if (!empty($sitemap)) {
                switch ($sitemap) {
                case 'album':;
                    $pageCat = array(
                        'table' => '_album_category',
                        'page'  => 'category',
                        'sub'   => null,
                    );
                    $pageDetail = array(
                        'table'    => '_album',
                        'page'     => 'detail',
                        'sub'      => 'view',
                        'fieldCat' => 'category_id',
                    );
                    $sitemapList = $this->getAlias($sitemap, $pageCat, $pageDetail);
                    break;
                case 'video':;
                    $pageCat = array(
                        'table' => '_category',
                        'page'  => 'category',
                        'sub'   => 'cat',
                    );
                    $pageDetail = array(
                        'table'    => '_video',
                        'page'     => 'detail',
                        'sub'      => 'view',
                        'fieldCat' => 'cat_id',
                    );
                    $sitemapList = $this->getAlias($sitemap, $pageCat, $pageDetail);
                    break;
                case 'news':;
                    $pageCat = array(
                        'table' => '_category',
                        'page'  => 'category',
                        'sub'   => 'cat',
                    );
                    $pageDetail = array(
                        'table'    => '_news',
                        'page'     => 'detail',
                        'sub'      => 'view',
                        'fieldCat' => 'cat_id',
                    );
                    $sitemapList = $this->getAlias($sitemap, $pageCat, $pageDetail);

                    break;
                case 'product':;
                    $pageCat = array(
                        'table' => '_category',
                        'page'  => 'product',
                        'sub'   => 'category',
                    );
                    $pageDetail = array(
                        'table'    => '_product_basic',
                        'page'     => 'product',
                        'sub'      => 'detail',
                        'fieldCat' => 'category',
                        'dot'      => '|',
                    );
                    $sitemapList = $this->getAlias($sitemap, $pageCat, $pageDetail);
                    break;
                default:
                    //$sitemapList = $this->getAlias('vi_category','vi_product_basic',$sitemap,'product','category','detail');
                    break;
                }
                //Thiết lập sub sitemap
                echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
                $urlRoot = array(
                    'url'        => $this->info['home_url'] . '/' . $sitemap . $this->info['dotExtension'],
                    'priority'   => 0.8,
                    'changefreq' => 'weekly',
                    'lastmod'    => date('Y-m-d'),
                );
                echo '<url>' . "\n";
                //echo '<loc>'.rawurlencode($v).'</loc>'."\n";
                echo '<loc>' . $urlRoot['url'] . '</loc>' . "\n";
                echo '<changefreq>' . $urlRoot['changefreq'] . '</changefreq>' . "\n";
                echo '<priority>' . $urlRoot['priority'] . '</priority>' . "\n";
                echo '<lastmod>' . $urlRoot['lastmod'] . '</lastmod>' . "\n";
                echo '</url>' . "\n";
                foreach ($sitemapList as $k => $v1) {
                    foreach ($v1 as $key => $v) {
                        if ($v['lastmod'] == '') {
                            $v['lastmod'] = date('Y-m-d');
                        }
                        echo '<url>' . "\n";
                        //echo '<loc>'.rawurlencode($v).'</loc>'."\n";
                        echo '<loc>' . $v['url'] . '</loc>' . "\n";
                        //echo '<xhtml:link rel="alternate" hreflang="de-ch" href="http://www.example.com/schweiz-deutsch/"/>' . "\n";
                        //echo '<xhtml:link rel="alternate" hreflang="de" href="http://www.example.com/deutsch/"/>' . "\n";
                        echo '<changefreq>' . $v['changefreq'] . '</changefreq>' . "\n";
                        echo '<priority>' . $v['priority'] . '</priority>' . "\n";
                        echo '<lastmod>' . $v['lastmod'] . '</lastmod>' . "\n";
                        echo '</url>' . "\n";
                    }
                }
                echo '</urlset>';

            } else {
                $modArray = array('product', 'news', 'album', 'video');
                //Thiết lập site map index
                echo '<sitemapindex  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/siteindex.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
                foreach ($modArray as $k => $v) {
                    $lastmod = $this->getTimeLatestMod($v);
                    echo '<sitemap>' . "\n";
                    //echo '<loc>'.rawurlencode($v).'</loc>'."\n";
                    echo '<loc>' . $domain . '/sitemap-' . $v . '.xml</loc>' . "\n";
                    echo '<lastmod>' . $lastmod . '</lastmod>' . "\n";
                    echo '</sitemap>' . "\n";
                }
                echo '</sitemapindex>';
            }
        }

    }

    /**
     * @param $modItem
     */
    private function getTimeLatestMod($modItem) {
        $db_mod = db_connect_mod($modItem);
        if ($modItem == 'product') {
            $table = 'vi_product_basic';
        } else {
            $table = 'vi_' . $modItem;
        }
        $mItem = new Model($table, $db_mod);
        $mItem->where('idw', $this->idw);
        $pItem = $mItem->get(null, null, 'id,update_time,create_time');

        $timeArr = array();
        foreach ($pItem as $k => $v) {
            $time      = (!empty($v['update_time'])) ? $v['update_time'] : $v['create_time'];
            $timeArr[] = $time;
        }
        $lastTime = max($timeArr);

        return date('Y-m-d', $lastTime);
    }
    /**
     * @param  $mod
     * @param  $pageCat
     * @param  $pageDetail
     * @return mixed
     */
    private function getAlias($mod, $pageCat, $pageDetail) {
        $db_mod = db_connect_mod($mod);
        $mCat   = new Model('vi' . $pageCat['table'], $db_mod);
        $mItem  = new Model('vi' . $pageDetail['table'], $db_mod);
        $mCat->where('idw', $this->idw);
        $p         = $mCat->get(null, null, 'alias,id,update_time,create_time');
        $trashItem = array();
        foreach ($p as $k => $v) {
            if (!empty($v['alias'])) {
                $cat_url   = linkUrl($this->info, $mod, $pageCat['page'], $pageCat['sub'], $v['id'], $v['alias']);
                $lastmodC1 = (!empty($v['update_time'])) ? $v['update_time'] : $v['create_time'];
                $lastmodC  = date('Y-m-d', $lastmodC1);
                $lastmodC  = (empty($vItem['create_time'])) ? "" : $lastmodC;
                $cat       = array('url' => $cat_url, 'priority' => 0.7, 'changefreq' => 'weekly', 'lastmod' => $lastmodC);

                $dot = (isset($pageDetail['dot'])) ? $pageDetail['dot'] : ',';
                $mItem->where('idw', $this->idw);
                $mItem->where($pageDetail['fieldCat'], '%' . $dot . $v['id'] . $dot . '%', 'LIKE');
                $pItem = $mItem->get(null, null, 'alias,id,update_time,create_time');
                foreach ($pItem as $kItem => $vItem) {
                    if (in_array($vItem['id'], $trashItem)) {
                        unset($vItem);
                        continue;
                    } else {
                        array_push($trashItem, $vItem['id']);
                        $result[$v['id']][0] = $cat;
                        $lastmod             = (!empty($vItem['update_time'])) ? $vItem['update_time'] : $vItem['create_time'];
                        //$lastmodArray[] =  $lastmod;
                        $lastmod            = date('Y-m-d', $lastmod);
                        $lastmod            = (empty($vItem['create_time'])) ? "" : $lastmod;
                        $result[$v['id']][] = array('url' => linkUrl($this->info, $mod, $pageDetail['page'], $pageDetail['sub'], $vItem['id'], $vItem['alias']), 'priority' => 0.5, 'changefreq' => 'monthly', 'lastmod' => $lastmod);
                    }
                }
            }
        }

        return $result;
    }
    /**
     * @return mixed
     */
    private function getInfo() {
        global $_B;
        $db      = db_connect_mod('infoweb');
        $infoObj = new Model($_B['lang'] . '_information', $db);
        $infoObj->where('idw', $this->idw);
        $data = $infoObj->getOne();

        return $data;
    }
    /**
     * @return mixed
     */
    private function getFooter() {
        global $_B;
        $db        = db_connect_mod('infoweb');
        $footerObj = new Model($_B['lang'] . '_footer', $db);
        $footerObj->where('idw', $this->idw);
        $data = $footerObj->getOne();
        if ($data != null) {
            $data = $data['footer'];
        }

        return $data;
    }
    /**
     * @return mixed
     */
    private function getLogo() {
        global $_B;
        $db      = db_connect_mod('template');
        $logoObj = new Model($_B['lang'] . '_logo', $db);
        $logoObj->where('idw', $this->idw);
        $logoObj->where('status', 1);
        $data = $logoObj->getOne(); 
        if ($data != null) {
            if (substr($data['img'], -3) == 'swf') {
                $data['is_swf'] = true;
            } else {
                $data['is_swf'] = false;
            }
        }

        return $data;
    }
    /**
     * @return mixed
     */
    private function getBackground() {
        $db         = db_connect_mod('template');
        $background = new Model('background', $db);
        $background->where('idw', $this->idw);
        $data = $background->getOne();
        if ($data != null) {
            switch ($data['repeat']) {
            case 1:$data['repeat'] = 'background-attachment: fixed;';
                break;
            case 2:$data['repeat'] = 'background-repeat: no-repeat;';
                break;
            case 3:$data['repeat'] = 'background-repeat: repeat-x;';
                break;
            case 4:$data['repeat'] = 'background-repeat: repeat-y;';
                break;
            case 5:$data['repeat'] = 'background-repeat: repeat;';
                break;
            default:$data['repeat'] = '';
                break;
            }
        }

        return $data;
    }
    /**
     * @return mixed
     */
    private function getAudio() {
        global $mod;
        $db    = db_connect_mod('template');
        $audio = new Model('audio', $db);
        $audio->where('idw', $this->idw);
        $audio->where('status', 1);
        $data = $audio->getOne();
        if ($data != null) {

            if ($data['is_home'] == 0 && $mod == 'home') {
                $data = null;
            } else if ($data['is_page'] == 0 && $mod != 'home') {
                $data = null;
            }
        }

        return $data;
    }
    /**
     * Check perm
     *
     * @return perm boolean
     */
    private function check_perm($mod, $page, $id, $act) {
        return true;
    }
    /**
     * Get config
     *
     * @return info array
     */
    private function get_config_fe() {
        $db = db_connect('user');
        $cf = new Model('web_cf_front_end', $db);
        $cf->where('idw', $this->idw);
        $this->config = $cf->get();
        foreach ($this->config as $k => $v) {
            if (!empty($v['value_int'])) {
                $config[$v['key']] = $v['value_int'];
            } else {
                $config[$v['key']] = $v['value_string'];
            }
        }
        $this->config = $config;

        return $this->config;
    }
    /**
     * @return mixed
     */
    private function get_config_mod_active() {
        $db = db_connect('user');
        $cf = new Model('web_mod', $db);
        $cf->where('idw', $this->idw);
        $data = $cf->getOne();

        return $data;
    }
    /**
     * @return mixed
     */
    private function get_config_admin() {
        //$config = $this->cache->get($this->s_name.'_config_admin');
        if ($config == null || 1) {
            $cf = new Model('web_cf_admin', false);
            $cf->where('idw', $this->idw);
            $cfs = $cf->get();
            foreach ($cfs as $k => $v) {
                if (!empty($v['value_int'])) {
                    $config[$v['key']] = $v['value_int'];
                } else {
                    $config[$v['key']] = $v['value_string'];
                }
            }
            $this->cache->set($this->s_name . '_config_admin', $config);
        }

        return $config;
    }

    /**
     * @return mixed
     */
    private function getUserinfo() {
        global $_B;
        if (!isset($_B['uid'])) {
            return false;
        }
        $userObj = new Model('web_user', false);
        $userObj->where('uid', $_B['uid']);
        $u               = $userObj->getOne();
        $u['birthday']   = date('d/m/Y', $u['birthday']);
        $u['city_id']    = str_pad($u['city_id'], 2, '0', STR_PAD_LEFT);
        $u['distric_id'] = str_pad($u['distric_id'], 3, '0', STR_PAD_LEFT);

        return $u;
    }
    private function connectBaokim() {
        if (isset($this->config['payment_setting_baokim'])) {
            $bk = json_decode($this->config['payment_setting_baokim'], 1);
            define('EMAIL_BUSINESS', $bk['reseller']['email']); //Email Bảo kim
            define('MERCHANT_ID', $bk['reseller']['merchant_id']); // Mã website tích hợp
            define('SECURE_PASS', $bk['reseller']['secure_pass']); // Mật khẩu
        } else {
            //CẤU HÌNH TÀI KHOẢN (Configure account)
            // define('EMAIL_BUSINESS', 'huongnb6869@gmail.com'); //Email Bảo kim
            // define('MERCHANT_ID', '15915'); // Mã website tích hợp
            // define('SECURE_PASS', '1bb45eec75a1c3ef'); // Mật khẩu
            die();
        }

    }

    /**
     * @return mixed
     */
    public function getGa() {
        global $_B, $web;
        $obj = new Model('vi_seo', db_connect('infoweb'));
        $obj->where('idw', $this->idw);
        $data = $obj->getOne();

        return $data;

    }

    /**
     * @param $idw
     */
    public function getRedirectLink() {
        global $_B;
        $obj = new Model('redirect_url', db_connect('infoweb'));
        $obj->where('idw', $this->idw);
        $obj->where('url_source', $_B['info_cache']['current_url']);
        $rs = $obj->getOne(null, 'url_destination');
        if ($rs) {
            $des = $rs['url_destination'];
            if ($des == '/') {
                $tmp_des = parse_url($_B['info_cache']['current_url']);
                $des     = $tmp_des['scheme'] . '://' . $tmp_des['host'];
            }
            header('Location:' . $des);
            exit;

        }
    }

    /**
     * @param  array   $info
     * @return mixed
     */
    public function getCurrentcy($info = array()) {
        global $_B, $web;
        $dbNx = db_connect('product');
        $obj  = new Model($info['lang_use'] . '_unit', $dbNx);
        $obj->where('idw', $this->idw);
        $obj->where('type', 3);
        $data = $obj->getOne(null, 'unit');

        if (!empty($data)) {
            return $data['unit'];
        } else {
            return 'đ';
        }

    }
    /**
     * @param $link
     */
    public function getAccessLink($link) {
        global $_B, $web;
        $dbNx = db_connect('notify');
        $obj  = new Model('web_features_access', $dbNx);
        $obj->where('idw', $this->idw);
        $obj->where('link', $link);
        $data = $obj->num_rows();

        if ($data) {
            if (!isset($_B['uid']) || $_B['uid'] == false || !in_array(2, $_B['perm'])) {
                die("Bạn không có quyền xem nội dung này !");
            }
        }
    }
}

?>