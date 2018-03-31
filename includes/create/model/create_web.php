<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /create/model/create_web.php
 * @author Chau Tran Quang (chautq@webbnc.vn)
 * @Createdate 16/12/2014, 01:46 PM
 */

class CreateWeb {
    /**
     * @var mixed
     */
    public $tenrg;
    /**
     * @var mixed
     */
    public $email;
    /**
     * @var mixed
     */
    public $passwd;
    /**
     * @var mixed
     */
    private $r;
    public function __construct() {
        global $_B;
        $this->r = $_B['r'];
    }
     public function PostAnvui($url,$data){
        $data['timeZone'] = 7;
        if(empty($token)){
            $token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ2IjowLCJkIjp7InVpZCI6IkFETTExMDk3Nzg4NTI0MTQ2MjIiLCJmdWxsTmFtZSI6IkFkbWluIHdlYiIsImF2YXRhciI6Imh0dHBzOi8vc3RvcmFnZS5nb29nbGVhcGlzLmNvbS9kb2JvZHktZ29ub3cuYXBwc3BvdC5jb20vZGVmYXVsdC9pbWdwc2hfZnVsbHNpemUucG5nIn0sImlhdCI6MTQ5MjQ5MjA3NX0.PLipjLQLBZ-vfIWOFw1QAcGLPAXxAjpy4pRTPUozBpw';
        }
        $request_header = [
            'Content-Type:text/plain',
            sprintf('DOBODY6969: %s', $token)
        ];

        $ch = curl_init();

     
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $request_header);
 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec ($ch);

        curl_close ($ch); 
        return json_decode($response,1);
    }
    public function login() {
        $d['userName'] = $this->r->get_string('userName', 'POST');
        $d['password'] = $this->r->get_string('password', 'POST');
        $rt = $this->PostAnvui('https://dobody-anvui.appspot.com/user/rlogin',$d);

        return $rt;
    }
    public function registeranvui() {

        // $api_url     = 'https://www.google.com/recaptcha/api/siteverify';
        // $site_key    = '6LfquiEUAAAAAIzGTTU09vBMI05sLkzxWzYc56Db';
        // $secret_key  = '6LfquiEUAAAAALiHwY3uPNk5MKf5wwmfsWGtwKLT'; 
        // $recaptcha = $this->r->get_string('recaptcha', 'POST');
        // if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        //     $remoteip = $_SERVER['HTTP_CLIENT_IP'];
        // } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        //     $remoteip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        // } else {
        //     $remoteip = $_SERVER['REMOTE_ADDR'];
        // } 
        // $api_url = $api_url.'?secret='.$secret_key.'&response='.$recaptcha.'&remoteip='.$remoteip; 
        // $response = file_get_contents($api_url); 
        // $response = json_decode($response);
        // if(!isset($response->success))
        // {
        //     return array('status' => false,'message'=>'Captcha không hợp lệ');
        // }
        // if($response->success == true)
        // {
            
        // }else{
        //     return array('status' => false,'message'=>'Captcha không hợp lệ');
        // } 

        $d['userName'] = $this->r->get_string('userName', 'POST');
        $d['password'] = $this->r->get_string('password', 'POST');
        $d['fullName'] = $this->r->get_string('fullName', 'POST');
        $d['companyName'] = $this->r->get_string('companyName', 'POST');
        $d['phoneNumber'] = $this->r->get_string('phoneNumber', 'POST');
        // $d['TRANSPORT_COMPANY_SERVICE_PACK_ID_NULL'] = 'SP00000002';
        $d['servicePackId'] = 'SP00000002';



        $d['stateCode'] = "84";
        $d['servicePackName'] = "ULTIMATE"; 

        $webObj = new Model('root.web');
        $webObj->where('s_name', $d['userName']);

        if ($webObj->num_rows() > 0) {
            $data['status']  = false;
            $data['message'] = 'Tên tài khoản đã đã tồn tại, hãy chọn tên khác!'; 

            return $data;
        } 

        $rt = $this->PostAnvui('https://dobody-anvui.appspot.com/company/create',$d);

        // var_dump($d);
        // var_dump($rt);
         // die;
        // return $rt;

        if($rt['code'] == 200 ){
            $data = array();
            $data['status'] = true;

            $this->tenrg   = $d['userName'];  
            $this->phone   = $d['phoneNumber'];   
            $this->anvui_id   = $rt['results']['User']['companyId'];   

            

            if ( $this->addWeb($rt['results']['User']['userId']) ) {
                return $data;
            } else {
                $data['status']  = false;
                $data['message'] = 'Có lỗi xảy ra, hãy thử lại!'; 

                return $data;
            }
 
        }
        else
        {
            return array('status' => false,'message'=>'Số điện thoại đã được đăng ký, hãy chọn số khác');
        } 
    }

    //Hàm gửi lại mã xác thực
    public function resendCode() {
        $d['stateCode'] = "84";
        $d['phoneNumber'] = $this->r->get_string('phoneNumber', 'POST');

        $rt = $this->PostAnvui('https://dobody-anvui.appspot.com/user/sendverify',$d);
        if($rt['code'] == 200 ){
            $data['status']  = true;
            $data['message'] = 'Hệ thống sẽ gửi lại mã xác nhận';
        } else {
            $data['status']  = false;
            $data['message'] = 'Có lỗi xảy ra, hãy thử lại!';
        }

        return $data;
    }

    //Xác thực số điện thoại
    public function verifyPhone() {
        $d['stateCode'] = "84";
        $d['phoneNumber'] = $this->r->get_string('phoneNumber', 'POST');
        $d['otpCode'] = $this->r->get_string('otpCode', 'POST');
        $rt = $this->PostAnvui('https://dobody-anvui.appspot.com/user/verifyphonenumber',$d);
        if($rt['code'] == 200 ){
            $data['status']  = true;
            $data['message'] = 'Xác thực thành công';
        } else {
            $data['status']  = false;
            $data['message'] = 'Mã xác thực không chính xác!';
        }

        return $data;
    }

    /**
     * @return mixed
     */
    private function addWeb($userId) {
        global $_B;

        $return = false;

        // $uid = $this->addUser();

        if ($userId) {
            $data = array(
                's_name'     => $this->tenrg,
                'anvui_id'     => $this->anvui_id,
                // 'email_user' => $this->email,
                'start_date' => time(),
                'end_date'   => time() + (int) $_B['day_try'] * 86400,
                'userId'        => $userId,
                'uid'        => 1,
                // 'address'    => $this->address,
                'phone'      => $this->phone
            );
            $webObj             = new Model('root.web');
            $_SESSION['idw']    = $webObj->insert($data);
            $_SESSION['s_name'] = $this->tenrg;
            //$webObj = New Web($this->tenrg);

            $return = true;
        }

        return $return;
    }
    /**
     * @return mixed
     */
    public function createweb() {
        global $_B;
        $data = array(
            'status' => true,
        );

        $this->tenrg   = $this->r->get_string('tenrg', 'POST');
        $this->email   = $this->r->get_string('email', 'POST');
        $this->passwd  = $this->r->get_string('passwd', 'POST');
        $this->phone   = $this->r->get_string('phone', 'POST');
        $this->address = $this->r->get_string('address', 'POST'); 
        $this->idtemp  = $this->r->get_int('idtemp', 'POST');

        if (!empty($this->idtemp)) {
            $_SESSION['theme_id_first'] = $this->idtemp;
        }

        $webObj = new Model('root.web');
        $webObj->where('s_name', $this->tenrg);

        if ($webObj->num_rows() > 0) {
            $data['status']  = false;
            $data['message'] = 'Tên rút gọn đã tồn tại, hãy chọn tên khác!';
            $data['type']    = 'tenrg';

            return $data;
        }
        $webObj->where('email_user', $this->email);
        if ($webObj->num_rows() > 0) {
            $data['status']  = false;
            $data['message'] = 'Email này đã được đăng ký, hãy chọn email khác!';
            $data['type']    = 'email';

            return $data;
        }

        if ($this->addWeb()) {
            return $data;
        } else {
            $data['status']  = false;
            $data['message'] = 'Email này đã được đăng ký, hãy chọn email khác!';
            $data['type']    = 'email';

            return $data;
        }

    }
    
    /**
     * @return mixed
     */
    private function addUser() {
        $passwd = md5('BNCID@' . $this->passwd . '@QCVN');
        $data   = array(
            'email'    => $this->email,
            'password' => $passwd,
        );
        $dbm = get_db_mod('useridbnc');
        //$db = db_connect_mod('useridbnc');
        $msla = new mysqli($dbm['db_host'], $dbm['db_user'], $dbm['db_password'], $dbm['db_name'], $dbm['db_port']);
        $msla->set_charset("utf8");
        $con = new MysqliDb($msla);
        $u   = $con->where('email', $this->email)->get('user');

        if (!empty($u)) {
            return false;
        } else {
            return $con->insert('user', $data);
        }

    }

    public function step1() {

    }
    /**
     * @return mixed
     */
    public function step2() {
        if ($_SESSION['theme_id_first']) {
            $_SESSION['theme_id'] = $_SESSION['theme_id_first'];
            unset($_SESSION['theme_id_first']);
            header("Location: " . $_B['create_home'] . "?step=3");
        }
        $data           = array();
        $data['themes'] = $this->getThemes();

        return $data;
    }
    /**
     * @return mixed
     */
    public function step3() {
        global $_B;
        $idw      = $_SESSION['idw'];
        $s_name   = $_SESSION['s_name'];
        $theme_id = $_SESSION['theme_id'];

        $data['webhome']  =  'http://'.$s_name.'.nhaxe.vn';
        // $data['webhome']  = 'http://' . str_replace('http://', '', str_replace('https://', '', $data['webhome']));
        $data['webadmin'] = $_B['create_admin'] . $s_name . '.admin';
        
        //update theme_id
        if (!empty($idw) && !empty($theme_id) && !empty($s_name)) {
            $webObj = new Model('web');
            $webObj->where('idw', $idw);
            $dataUpdate = array('theme_id' => $theme_id);
            $webObj->update($dataUpdate);
            $data['token'] = $this->getTokenCopyWeb($idw, $s_name, $theme_id);
            $this->setConfigLang($idw, $theme_id);
            //Send mail ở đây
            //Web name
            $webObj = new Model('web');
            $webObj->where('idw', $idw);
            $infoNxt = $webObj->getOne();
 
            return $data;
        } else {
            header("Location: " . $_B['create_home'] . "?step=1");
        }
    }
    /**
     * @return mixed
     */
    public function copyall(){
        die;
        $idw  = $this->r->get_int('idw', 'GET');
        $s_name  = $this->r->get_string('s_name', 'GET');

        if(empty($idw)){
            die('ko idw');
        }
        if(empty($s_name)){
            die('ko s_name');
        }

        $data['w0']['idw']    = 5;
        $data['w0']['s_name'] = 'demo';

        $data['w1']['idw']    = $idw;
        $data['w1']['s_name'] = $s_name;


       $this->copyWeb1($data);
       $this->copyWeb2($data);
       $this->copyWeb3($data);
       die;
    }
    public function copyweb() {

        $step  = $this->r->get_int('step', 'POST');
        $token = $this->r->get_string('token', 'POST');
        $info  = $this->decodeTokenCopyWeb($token);

        if (!empty($info['w1']['idw']) && !empty($info['w0']['idw'])) {
            switch ($step) {
            case 1:$rt = $this->copyWeb1($info);
                break;
            case 2:$rt = $this->copyWeb2($info);
                break;
            case 3:$rt = $this->copyWeb3($info);
                break;
            case 4:$rt = $this->copyWeb4($info);
                break;
            case 5:$rt = $this->copyWeb5($info);
                break;
            }

            return $rt;
        } else {
            $data['status'] = false;
            $data['token']  = $token;

            return $data;
        }

    }
    /**
     * @param $info
     * @return mixed
     */
    public function copyWeb1($info) {

        $this->copyDataMod('menu', 'vi_menu', 'id', $info);
        // $this->copyDataMod('menu','vi_menubottom','id',$info);
        //$this->copyDataMod('lists','vi_listinfo','id',$info);
        $this->copyDataMod('feedback', 'vi_feedback', 'id', $info);
        $this->copyDataMod('recruit', 'vi_recruit', 'id', $info);
        $this->copyDataMod('maps', 'vi_gmaps', 'id', $info);
        $this->copyDataMod('maps', 'vi_config', 'id', $info);

        $data['status']  = true;
        $data['done']    = false;
        $data['step']    = 2;
        $data['precent'] = 10;

        return $data;
    }
    /**
     * @param $info
     * @return mixed
     */
    public function copyWeb2($info) {

        $this->copyDataMod('template', 'vi_home', 'id', $info);
        $this->copyDataMod('template', 'vi_block', 'id', $info);
        $this->copyDataMod('template', 'vi_logo', 'id', $info);

        $this->copyDataMod('news', 'vi_config', 'id', $info);

        $this->copyDataModReCoreOne('template', 'vi_adv_flash', 'id', $info, 'advertisers', 'id', "ads_id");
        $this->copyDataModReCoreOne('template', 'vi_adv_ggadsense', 'id', $info, 'advertisers', 'id', "ads_id");
        $this->copyDataModReCoreOne('template', 'vi_adv_image', 'id', $info, 'advertisers', 'id', "ads_id");
        $this->copyDataModReCoreOne('template', 'vi_adv_text', 'id', $info, 'advertisers', 'id', "ads_id");

        $this->copyDataModReCoreOne('template', 'vi_slide', 'id', $info, 'vi_slide_image', 'id', "slide_id");

        $re_tables = null;
        $this->copyDataModReCore('news', 'vi_category', 'id', $info, "parent_id", 'vi_news', 'id', "news_id", $re_tables, 'cat_id');

        $data['status']  = true;
        $data['done']    = false;
        $data['step']    = 3;
        $data['precent'] = 30;

        return $data;
    }
    // public function copywebmaster() {

    //     $info['w0']['idw'] = 183; //$this->r->get_int('w0');
    //     $info['w1']['idw'] = 182; //$this->r->get_int('w1');

    //     $this->copyDataMod('menu', 'en_menu', 'id', $info);
    //     // $this->copyDataMod('menu','vi_menubottom','id',$info);
    //     //$this->copyDataMod('lists','vi_listinfo','id',$info);
    //     $this->copyDataMod('feedback', 'en_feedback', 'id', $info);
    //     $this->copyDataMod('recruit', 'en_recruit', 'id', $info);
    //     $this->copyDataMod('maps', 'en_gmaps', 'id', $info);
    //     $this->copyDataMod('maps', 'en_config', 'id', $info);

    //     $this->copyDataMod('template', 'en_home', 'id', $info);
    //     $this->copyDataMod('template', 'en_block', 'id', $info);
    //     $this->copyDataMod('template', 'en_logo', 'id', $info);

    //     $this->copyDataMod('news', 'en_config', 'id', $info);

    //     $this->copyDataModReCoreOne('template', 'en_adv_flash', 'id', $info, 'advertisers', 'id', "ads_id");
    //     $this->copyDataModReCoreOne('template', 'en_adv_ggadsense', 'id', $info, 'advertisers', 'id', "ads_id");
    //     $this->copyDataModReCoreOne('template', 'en_adv_image', 'id', $info, 'advertisers', 'id', "ads_id");
    //     $this->copyDataModReCoreOne('template', 'en_adv_text', 'id', $info, 'advertisers', 'id', "ads_id");

    //     $this->copyDataModReCoreOne('template', 'en_slide', 'id', $info, 'en_slide_image', 'id', "slide_id");

    //     $re_tables = null;
    //     $this->copyDataModReCore('news', 'en_category', 'id', $info, "parent_id", 'en_news', 'id', "news_id", $re_tables, 'cat_id');

    //     $this->copyDataMod('contact', 'en_contactinfo', 'id', $info);
    //     $this->copyDataMod('infoweb', 'en_footer', 'id', $info);
    //     $this->copyDataMod('infoweb', 'en_information', 'id', $info);

    //     $this->copyDataMod('album', 'en_config', 'id', $info);

    //     $this->copyDataMod('product', 'en_setting', 'id', $info);
    //     $this->copyDataMod('product', 'en_unit', 'id', $info);
    //     $this->copyDataMod('product', 'en_properties', 'id', $info);
    //     $this->copyDataMod('product', 'en_supplier', 'id', $info);
    //     $this->copyDataMod('product', 'en_shop', 'id', $info);
    //     $this->copyDataMod('product', 'en_color', 'id', $info);
    //     $this->copyDataMod('product', 'en_brand', 'id', $info);

    //     $re_tables = array(
    //         'en_product_description' => 'id',
    //         'en_product_detail'      => 'id',
    //         'en_product_image'       => 'id',
    //         'en_product_size'        => 'id',
    //     );

    //     $this->copyDataModReCore('product', 'en_category', 'id', $info, "parent", 'en_product_basic', 'id', "id_product", $re_tables);

    //     die('DONE');
    // }
    /**
     * @param $info
     * @return mixed
     */
    public function copyWeb3($info) {

        $this->copyDataMod('contact', 'vi_contactinfo', 'id', $info);
        $this->copyDataMod('infoweb', 'vi_footer', 'id', $info);
        $this->copyDataMod('infoweb', 'vi_information', 'id', $info);

        $this->copyDataMod('album', 'vi_config', 'id', $info);

        // $this->copyDataMod('product', 'vi_setting', 'id', $info);
        // $this->copyDataMod('product', 'vi_unit', 'id', $info);
        // $this->copyDataMod('product', 'vi_properties', 'id', $info);
        // $this->copyDataMod('product', 'vi_supplier', 'id', $info);
        // $this->copyDataMod('product', 'vi_shop', 'id', $info);
        // $this->copyDataMod('product', 'vi_config', 'id', $info);
        // $this->copyDataMod('product', 'vi_color', 'id', $info);
        // $this->copyDataMod('product', 'vi_brand', 'id', $info);

        $re_tables = array(
            'vi_album_images' => 'id',
        );
        // $this->copyDataModReCore('album', 'vi_album_category', 'id', $info, "parent_id", 'vi_album', 'id', "album_id", $re_tables, 'category_id');

        // $this->copyDataMod('video', 'vi_setting', 'id', $info);
        // $re_tables = null;
        /// $this->copyDataModReCore('video', 'vi_category', 'id', $info, "parent_id", 'vi_video', 'id', "vi_video", $re_tables, 'cat_id');

        $this->copyDataModReCoreOne('lists', 'vi_listname', 'id', $info, 'vi_listinfo', 'id', "listoption");

        $re_tables = array(
            'vi_product_description' => 'id',
            'vi_product_detail'      => 'id',
            'vi_product_image'       => 'id',
            'vi_product_size'        => 'id',
        );

        // $this->copyDataModReCore('product', 'vi_category', 'id', $info, "parent", 'vi_product_basic', 'id', "id_product", $re_tables);

        $data['status']  = true;
        $data['done']    = false;
        $data['step']    = 4;
        $data['precent'] = 70;

        return $data;
    }
    /**
     * @param $info
     * @return mixed
     */
    public function copyWeb4($info) {

        $data['status']  = true;
        $data['done']    = false;
        $data['step']    = 5;
        $data['precent'] = 90;

        return $data;
    }
    /**
     * @param $info
     * @return mixed
     */
    public function copyWeb5($info) {

        $data['status']  = true;
        $data['done']    = true;
        $data['s_name']  = $info['w1']['s_name'];
        $data['precent'] = 100;

        return $data;
    }
    /**
     * @param $mod
     * @param $table
     * @param $key
     * @param $info
     * @param $re_table
     * @param $key_re
     * @param $cat_key
     */
    private function copyDataModReCoreOne($mod, $table, $key, $info, $re_table, $key_re, $cat_key) {
        global $map_cat;
        $db = db_connect_mod($mod);

        $obj = new Model($table, $db);
        $obj->where('idw', $info['w0']['idw']);
        $data = $obj->get();

        $map_cat = array(); //array de map id danh muc

        $this->copyDataModTableReOne($table, $db, $info, $data, $key);

        $obj = new Model($re_table, $db);
        $obj->where('idw', $info['w0']['idw']);
        $data = $obj->get();

        $obj->where('idw', $info['w1']['idw']);
        $obj->delete();

        $map_view = array();

        foreach ($data as $k => $v) {

            unset($v[$key_re]);

            $v['idw'] = $info['w1']['idw'];

            $v[$cat_key] = $map_cat[$v[$cat_key]];

            $vdata = $v;
            $id    = $obj->insert($vdata);
        }

    }
    /**
     * @param $table
     * @param $db
     * @param $info
     * @param $data
     * @param $key
     */
    private function copyDataModTableReOne($table, $db, $info, $data, $key) {
        global $map_cat;
        $obj = new Model($table, $db);
        $obj->where('idw', $info['w1']['idw']);
        $obj->delete();
        foreach ($data as $k => $v) {

            if ($v[$parent_key] != $parent) {
                continue;
            }

            $tmp = $v[$key];
            unset($v[$key]);

            $v['idw'] = $info['w1']['idw'];

            $vdata = $v;
            unset($vdata['sub']);
            $id = $obj->insert($vdata);

            $map_cat[$tmp] = $id;
        }
    }
    /**
     * @param $mod
     * @param $table
     * @param $key
     * @param $info
     * @param $parent_key
     * @param $re_table
     * @param $re_table_key
     * @param $re_key
     * @param array $re_tables
     * @param $cat_key
     */
    private function copyDataModReCore($mod, $table, $key, $info, $parent_key = "parent_id", $re_table = 'vi_product_basic', $re_table_key = 'id', $re_key = "id_product", $re_tables = array(), $cat_key = 'category') {
        global $map_cat;

        $db = db_connect_mod($mod);

        $obj = new Model($table, $db);
        $obj->where('idw', $info['w0']['idw']);
        $data = $obj->get();
        $data = $this->recursive($data, $key, $parent_key);

        $map_cat = array(); //array de map id danh muc

        $this->copyDataModTableRe($table, $db, $info, $data, $key, $parent_key);

        $obj = new Model($re_table, $db);
        $obj->where('idw', $info['w0']['idw']);
        $data = $obj->get();

        $map_view = array();

        $obj->where('idw', $info['w1']['idw']);
        $obj->delete();

        foreach ($data as $k => $v) {

            $tmp = $v[$re_table_key];
            unset($v[$key]);

            $v['idw']  = $info['w1']['idw'];
            $category  = explode('|', $v[$cat_key]);
            $categoryn = array();

            foreach ($category as $kc => $vc) {
                if (empty($vc)) {
                    continue;
                }

                $categoryn[] = $map_cat[$vc];
            }

            $v[$cat_key] = '|' . implode('|', $categoryn) . '|';

            $vdata = $v;
            unset($vdata['sub']);
            $id = $obj->insert($vdata);

            $map_view[$tmp] = $id;
        }

        if ($re_tables != null) {
            foreach ($re_tables as $key => $value) {
                $obj = new Model($key, $db);
                $obj->where('idw', $info['w0']['idw']);
                $data = $obj->get();

                $obj->where('idw', $info['w1']['idw']);
                $obj->delete();

                foreach ($data as $k => $v) {
                    unset($v['id']);

                    $v['idw']   = $info['w1']['idw'];
                    $v[$re_key] = $map_view[$v[$re_key]];

                    $obj->insert($v);
                }
            }
        }

    }
    /**
     * @param $table
     * @param $db
     * @param $info
     * @param $data
     * @param $key
     * @param $parent_key
     * @param $parent
     * @param $newid
     * @param null $ft
     */
    private function copyDataModTableRe($table, $db, $info, $data, $key, $parent_key = "parent_id", $parent = 0, $newid = null, $ft = true) {
        global $map_cat;
        $obj = new Model($table, $db);
        if ($ft) {
            $obj->where('idw', $info['w1']['idw']);
            $obj->delete();
        }

        foreach ($data as $k => $v) {

            if ($v[$parent_key] != $parent) {
                continue;
            }

            $tmp = $v[$key];
            unset($v[$key]);

            $v['idw'] = $info['w1']['idw'];
            if ($newid != null) {
                $v[$parent_key] = $newid;
            }

            $vdata = $v;
            unset($vdata['sub']);
            $id = $obj->insert($vdata);

            $map_cat[$tmp] = $id;

            if (isset($v['sub']) && count($v['sub']) > 0) {
                $this->copyDataModTableRe($table, $db, $info, $v['sub'], $key, $parent_key, $tmp, $id, false);
            }
        }
    }
    /**
     * @param $mod
     * @param $table
     * @param $key
     * @param $info
     * @param $parent_key
     */
    private function copyDataMod($mod, $table, $key, $info, $parent_key = "parent_id") {
        $db = db_connect_mod($mod);

        $obj = new Model($table, $db);
        $obj->where('idw', $info['w0']['idw']);
        $data = $obj->get();

        $obj->where('idw', $info['w1']['idw']);
        $obj->delete();

        $data = $this->recursive($data, $key, $parent_key);
        $this->copyDataModTable($table, $db, $info, $data, $key, $parent_key);
    }
    /**
     * @param $table
     * @param $db
     * @param $info
     * @param $data
     * @param $key
     * @param $parent_key
     * @param $parent
     * @param $newid
     */
    private function copyDataModTable($table, $db, $info, $data, $key, $parent_key = "parent_id", $parent = 0, $newid = null) {

        $obj = new Model($table, $db);

        foreach ($data as $k => $v) {

            if ($v[$parent_key] != $parent) {
                continue;
            }

            $tmp = $v[$key];
            unset($v[$key]);

            $v['idw'] = $info['w1']['idw'];
            if ($newid != null) {
                $v[$parent_key] = $newid;
            }

            $vdata = $v;
            unset($vdata['sub']);
            $id = $obj->insert($vdata);

            if (isset($v['sub']) && count($v['sub']) > 0) {
                $this->copyDataModTable($table, $db, $info, $v['sub'], $key, $parent_key, $tmp, $id);
            }
        }
    }
    /**
     * @param $menu
     * @param $id_field
     * @param $parent_field
     * @param $parent
     * @return mixed
     */
    private function recursive($menu, $id_field = "id", $parent_field = "parent_id", $parent = 0) {
        $current_menus = array();
        foreach ($menu as $key => $value) {
            if ($value[$parent_field] == $parent) {
                $k                 = $value[$id_field];
                $current_menus[$k] = $value;
                unset($menu[$key]);
            }
        }
        if (sizeof($current_menus) > 0) {
            foreach ($current_menus as $key => $value) {
                $current_menus[$key]['sub'] = $this->recursive($menu, $id_field, $parent_field, $value[$id_field]);
            }
        }

        return $current_menus;
    }
    /**
     * @param $token
     * @return mixed
     */
    private function decodeTokenCopyWeb($token) {
        $token = base64_decode($token);
        $token = json_decode($token, true);

        return $token;
    }
    /**
     * @param $idw
     * @param $s_name
     * @param $theme_id
     * @return mixed
     */
    private function getTokenCopyWeb($idw, $s_name, $theme_id) {
        $temp = new Model('web_themes');
        $temp->where('id_dir', $theme_id);
        $themme = $temp->getOne();
        if (empty($themme)) {
            unset($temp);
            $temp = new Model('themes');
            $temp->where('sub_id', $theme_id);
            $themme = $temp->getOne();
            if (!empty($themme)) {
                preg_match('/http:\/\/(v2bnc[0-9]+).v2.webbnc.net/', $themme['link_demo'], $match);
                if (isset($match[1])) {
                    $themme['link'] = $match[1];
                }
            }
        }
        if (!isset($themme['idw']) || empty($themme['idw'])) {
            return false;
        }
        $data['w0']['idw']    = $themme['idw'];
        $data['w0']['s_name'] = $themme['link'];

        $data['w1']['idw']    = $idw;
        $data['w1']['s_name'] = $s_name;

        $json   = json_encode($data);
        $base64 = base64_encode($json);

        return $base64;
    }
    /**
     * @param $idw
     * @param $theme_id
     */
    private function setConfigLang($idw, $theme_id) {

        $webCf = new Model('web_cf_front_end');
        $webCf->where('idw', $idw);
        $webCf->where('`key`', 'lang');
        $webCf->delete();
        $data = array('idw' => $idw, 'key' => 'lang', 'value_string' => 'vi');
        $webCf->insert($data);

        $webCf = new Model('web_cf_front_end');
        $webCf->where('idw', $idw);
        $webCf->where('`key`', 'lang_use');
        $webCf->delete();
        $data = array('idw' => $idw, 'key' => 'lang_use', 'value_string' => 'vi');
        $webCf->insert($data);

        $webCf = new Model('web_cf_admin');
        $webCf->where('idw', $idw);
        $webCf->where('`key`', 'lang');
        $webCf->delete();
        $data = array('idw' => $idw, 'key' => 'lang', 'value_string' => 'vi');
        $webCf->insert($data);

        $webCf = new Model('web_cf_admin');
        $webCf->where('idw', $idw);
        $webCf->where('`key`', 'lang_use');
        $webCf->delete();
        $data = array('idw' => $idw, 'key' => 'lang_use', 'value_string' => 'vi');
        $webCf->insert($data);

        $webCf = new Model('web_cf_admin');
        $webCf->where('idw', $idw);
        $webCf->where('`key`', 'dotExtension');
        $webCf->delete();
        $data = array('idw' => $idw, 'key' => 'dotExtension', 'value_string' => '.html');
        $webCf->insert($data);
    }
    /**
     * @return mixed
     */
    public function chooseTheme() {
        $data = array(
            'status' => true,
        );

        $_SESSION['theme_id'] = $this->r->get_int('idgd', 'POST');

        return $data;
    }
    /**
     * @return mixed
     */
    public function chooseThemeFirst() {
        $data = array(
            'status' => true,
        );

        $_SESSION['theme_id_first'] = $this->r->get_int('idgd', 'POST');

        return $data;
    }
    /**
     * @return mixed
     */
    public function checktenrg() {
        global $_B;
        $data = array(
            'status' => true,
        );

        $this->tenrg = $this->r->get_string('tenrg', 'POST');
        $webObj      = new Model('web');
        $webObj->where('s_name', $this->tenrg);

        if ($webObj->num_rows() > 0) {
            $data['status'] = false;
        }

        return $data;

    }
    /**
     * @return mixed
     */
    public function checkemail() {
        global $_B;
        $data = array(
            'status' => true,
        );

        $this->email = $this->r->get_string('email', 'POST');
        $webObj      = new Model('web');
        $webObj->where('email_user', $this->email);

        if ($webObj->num_rows() > 0) {
            $data['status'] = false;
        }

        return $data;

    }
    
    /**
     * @return mixed
     */
    private function getThemes() {
        $u = new Model('root.web_themes');
        $u->where('status', 1);

        return $u->get();
    }

    /*--------------------------SSL----------------------*/
    /**
     * @return mixed
     */
    public function registerSsl() {
        return false;

    }

    /**
     * @param $domain
     * @return mixed
     */
    private function checkSsl($domain) {
        return false;
    }

}