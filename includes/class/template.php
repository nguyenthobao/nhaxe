<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /includes/class/template.php
 * @Createdate 08/15/2014, 08:58 PM
 * @Author Quang Chau Tran (quangchauvn@gmail.com)
 * @Author Modify Nguyen Xuan Truong (truongnx28111994@gmail.com)
 */
if (!defined('BNC_CODE')) {
    exit('Access Denied');
}
include DIR_CLASS . "blocks.php";
include DIR_CLASS . "home.php";
//Minify
include_once DIR_ROOT . 'min/lib/Minify/HTML.php';
include_once DIR_ROOT . 'min/lib/Minify/CSS.php';
include_once DIR_ROOT . 'min/lib/JSMin.php';

class Template {
    /**
     * @var mixed
     */
    private $dir_theme;
    /**
     * @var mixed
     */
    private $dir_file;
    /**
     * @var mixed
     */
    private $mod = false;
    /**
     * @var int
     */
    private $temp = 1;
    /**
     * @var mixed
     */
    private $g;
    /**
     * @var mixed
     */
    private $lang;
    /**
     * @var mixed
     */
    private $idw;
    /**
     * @var mixed
     */
    private $dirThemes;
    /**
     * @var mixed
     */
    private $reCreate = false;
    //private $arr_block = array("adv_1","adv_2","adv_3","adv_4");

    /**
     * Contructor
     */
    public function __construct() {
        global $_B, $web, $mod;
        if (isset($_COOKIE['chau'])  
        ) {
            $this->reCreate = true;
        }
        $web['current_url'] = $this->full_url($_SERVER);
        $this->g['i']       = 0;
        $this->temp         = $web['temp'];
        $this->lang         = $_B['lang'];
        $this->idw          = $web['idw'];
        $this->mod          = $mod;
        $this->dirThemes    = $web['dir_theme'];
        // if ($this->idw==172) {
        //     $this->dirThemes = DIR_THEME.'themes_custom/';
        // }else{
        //     $this->dirThemes = DIR_THEME;
        // }
        $temps        = explode('/', $this->temp);
        $dir_temp_new = DIR_TMP . 'themes/';
        if (count($temps) > 1) {
            for ($i = 0; $i < count($temps) - 1; $i++) {
                $dir_temp_new .= $temps[$i];
                if (!is_dir($dir_temp_new)) {
                    mkdir($dir_temp_new);
                    chmod($dir_temp_new, 0775);
                }
                $dir_temp_new .= '/';
            }
        }

        $this->dir_file = DIR_TMP . 'themes/' . $this->temp . '/';
        if (!is_dir($this->dir_file)) {
            mkdir($this->dir_file);
            chmod($this->dir_file, 0775);
        }
    }

    /**
     * [url_origin description]
     * @email  truongnx28111994@gmail.com
     * @date   2015-08-22
     * @author Truong Nguyen
     *
     * @param  [type]  $s                  [description]
     * @param  boolean $use_forwarded_host [description]
     * @return [type]  [description]
     */
    private function url_origin($s, $use_forwarded_host = false) {
        $ssl      = (!empty($s['HTTPS']) && $s['HTTPS'] == 'on') ? true : false;
        $sp       = strtolower($s['SERVER_PROTOCOL']);
        $protocol = substr($sp, 0, strpos($sp, '/')) . (($ssl) ? 's' : '');
        $port     = $s['SERVER_PORT'];
        $port     = ((!$ssl && $port == '80') || ($ssl && $port == '443')) ? '' : ':' . $port;
        $host     = ($use_forwarded_host && isset($s['HTTP_X_FORWARDED_HOST'])) ? $s['HTTP_X_FORWARDED_HOST'] : (isset($s['HTTP_HOST']) ? $s['HTTP_HOST'] : null);
        $host     = isset($host) ? $host : $s['SERVER_NAME'] . $port;

        return $protocol . '://' . $host;
    }
    /**
     * [full_url description]
     * @email  truongnx28111994@gmail.com
     * @date   2015-08-22
     * @author Truong Nguyen
     *
     * @param  [type]  $s                  [description]
     * @param  boolean $use_forwarded_host [description]
     * @return [type]  [description]
     */
    private function full_url($s, $use_forwarded_host = false) {
        return $this->url_origin($s, $use_forwarded_host) . $s['REQUEST_URI'];
    }

    /**
     * Load teamplete
     * @param  string $name    duong dan cua file template htm;
     * @return string $objfile duong dan file xu ly php tuong ung voi file htm
     */
    public function load($name) {
        global $_B;

        $this->dir_theme = $this->dirThemes . $this->temp . '/';
        $names           = explode('/', $name);

        if (!file_exists($this->dir_theme . $name . '.htm') || $this->mod == 'payment') {
            $this->dir_theme = DIR_MODULES . $this->mod . '/themes/';
            $name            = str_replace($this->mod . '/', '', $name);
        }

        $dir_new = $this->dir_file;

        if (count($names) > 1) {
            for ($i = 0; $i < count($names) - 1; $i++) {
                $dir_new .= $names[$i];
                if (!is_dir($dir_new)) {
                    mkdir($dir_new);
                    chmod($dir_new, 0775);
                }
                $dir_temp_new .= '/';

            }
        }

        //echo $this->dir_theme.$name.'.htm';

        $objfile = $this->dir_file . $name . '.php';

        if ($this->reCreate || !file_exists($objfile)) {
            // if (  !file_exists($objfile)) {
            //Check Exist File
            $this->parse_template($name);
        }

        return $objfile;
    }
    /**C
     * Load teamplete  ajax
     * @param string $name duong dan cua file template htm;
     * @return string $objfile duong dan file xu ly php tuong ung voi file htm
     */
    /**
     * @param  $name
     * @return mixed
     */
    public function loadajax($name) {
        global $_B;

        if ($this->mod == 'payment') {
            $dirThemes       = DIR_MODULES . $this->mod . '/themes/';
            $this->dir_theme = $dirThemes;
        } else {
            $this->dir_theme = $this->dirThemes . $this->temp . '/';
        }

        $names   = explode('/', $name);
        $dir_new = $this->dir_file;
        if (count($names) > 1) {
            for ($i = 0; $i < count($names) - 1; $i++) {
                $dir_new .= $names[$i];
                if (!is_dir($dir_new)) {
                    mkdir($dir_new);
                    chmod($dir_new, 0775);
                }
                $dir_temp_new .= '/';

            }
        }

        if (file_exists($this->dir_theme . $this->mod . '/' . $name . '.htm')) {
            $this->dir_theme = $this->dir_theme . $this->mod . '/';
            //$name = str_replace($this->mod.'/', '', $name);
        } elseif (!file_exists($this->dir_theme . $name . '.htm')) {
            $this->dir_theme = DIR_MODULES . $this->mod . '/themes/';
            $name            = str_replace($this->mod . '/', '', $name);
        }

        $objfile = $this->dir_file . $name . '.php';

        if ($this->reCreate || !file_exists($objfile)) {
            $this->parse_template($name, null, true);
        }

        return $objfile;
    }
    /**
     * @param  $name
     * @param  $module
     * @return mixed
     */
    public function load_block($name, $module) {
        global $_B;

        $this->dir_theme = $this->dirThemes . $this->temp . '/' . $module . '/';

        $names   = explode('/', $name);
        $dir_new = $this->dir_file;

        if (count($names) > 1) {
            for ($i = 0; $i < count($names) - 1; $i++) {
                $dir_new .= $names[$i];
                if (!is_dir($dir_new)) {
                    mkdir($dir_new);
                    chmod($dir_new, 0775);
                }
                $dir_temp_new .= '/';

            }
        }

        if (!file_exists($this->dir_theme . $name . '.htm')) {
            $this->dir_theme = DIR_MODULES . $module . '/themes/';
            $name            = str_replace($module . '/', '', $name);
        }

        $objfile = $this->dir_file . $module . '/' . $name . '.php';
        if ($this->reCreate || !file_exists($objfile)) {
            $this->parse_template($name, $module);
        }

        return $objfile;
    }
    /**
     * @param  $name
     * @param  $module
     * @return mixed
     */
    public function load_home($name, $module) {
        global $_B;

        $this->dir_theme = $this->dirThemes . $this->temp . '/' . $module . '/';

        $names   = explode('/', $name);
        $dir_new = $this->dir_file;
        if (count($names) > 1) {
            for ($i = 0; $i < count($names) - 1; $i++) {
                $dir_new .= $names[$i];
                if (!is_dir($dir_new)) {
                    mkdir($dir_new);
                    chmod($dir_new, 0775);
                }
                $dir_temp_new .= '/';
            }
        }

        //echo $this->dir_theme.$name.'.htm';
        //die;

        if (!file_exists($this->dir_theme . $name . '.htm')) {
            $this->dir_theme = DIR_MODULES . $module . '/themes/';
            $name            = str_replace($module . '/', '', $name);
        }
        $objfile = $this->dir_file . $module . '/' . $name . '.php';
        if ($this->reCreate || !file_exists($objfile)) {
            $this->parse_template($name, $module);
        }

        return $objfile;
    }
    /**
     * Xy ly template dinh nghia cac the tai file html
     * @param string $tpl ten cua file templete
     */
    private function parse_template($tpl, $module = null, $ajax = false) {
        global $_B, $web;
        $web['uid'] = $_B['uid'];
        $tplfile    = $this->dir_theme . $tpl . '.htm';
        $objfile    = $this->dir_file . $module . '/' . $tpl . '.php';
        $template   = $this->sreadfile($tplfile);
        if (empty($template)) {
            exit("Template file : $tplfile Not found or have no access!");
        }

        // var_dump($data['head']['link']);
        $template = preg_replace('/<meta name="keywords" content="(.*)">/', '<meta name="keywords" content="$data[\'head\'][\'keywords\']">', $template);
        $template = preg_replace('/<head>/', '<head><link rel="canonical" href="$data[\'head\'][\'link\']">', $template);
        //$template = preg_replace('/\$\_([^GET][a-zA_Z0-9\_\-]+)/i', '$data[\'content\'][\'\\1\']', $template);
        $template   = preg_replace('/\$\_([a-zA_Z0-9\_\-]+)/i', '$data[\'content\'][\'\\1\']', $template);
        $template   = preg_replace('/\<\!DOCTYPE/i', '<?php echo @qc@_B[\'temp\']->checkGzip();?>', $template);
        $template   = preg_replace('/BNCGLOBAL\[\'([a-zA_Z0-9\_\-]+)\'\]/i', '$_B[\'\\1\']', $template);
        $template   = preg_replace('/WEBGLOBAL\[\'([a-zA_Z0-9\_\-]+)\'\]/i', '$web[\'\\1\']', $template);
        $template   = preg_replace("/\<\!\-\-\{loadImage\s+\\\$([a-z0-9_\[\]\']+)\s+([a-z]+)\s+([0-9a-z]+)\s+([a-z0-9]+)\s+false\}\-\-\>[\s+]?/i", "<?php  echo loadImage(@qc@\\1,'\\2','\\3','\\4',false); ?>", $template);
        $template   = preg_replace("/src\=\"[\s+]?\<\!\-\-\{loadImage\s+\\\$([a-z0-9_\[\]\']+)\s+([a-z]+)\s+([0-9a-z]+)\s+([a-z0-9]+)\}\-\-\>\"[\s+]?/i", "<?php  echo loadImage(@qc@\\1,'\\2','\\3','\\4',true); ?>", $template);
        $template   = preg_replace("/src\=\"[\s+]?\<\!\-\-\{loadImage\s+\\\$([a-z0-9A-Z\[\]\'\_]+)\s+([a-z]+)\s+\\\$([a-z0-9A-Z\[\]\'\_]+)\s+\\\$([a-z0-9A-Z\[\]\'\_]+)\}\-\-\>\"[\s+]?/i", "<?php  echo  loadImage(@qc@\\1,'\\2',@qc@\\3,@qc@\\4,true); ?>", $template);
        $template   = preg_replace("/href\=\"[\s+]?\<\!\-\-\{loadImage\s+\\\$([a-z0-9A-Z\[\]\'\_]+)\s+([a-z]+)\s+\\\$([a-z0-9A-Z\[\]\'\_]+)\s+\\\$([a-z0-9A-Z\[\]\'\_]+)\}\-\-\>\"[\s+]?/i", "href='<?php  echo  loadImage(@qc@\\1,'\\2',@qc@\\3,@qc@\\4,false); ?>'", $template);
        $template   = preg_replace("/href\=\"[\s+]?\<\!\-\-\{loadImage\s+\\\$([a-z0-9_\[\]\']+)\s+([a-z]+)\s+([0-9a-z]+)\s+([a-z0-9]+)\}\-\-\>\"[\s+]?/i", "href='<?php  echo loadImage(@qc@\\1,'\\2','\\3','\\4'); ?>'", $template);
        $template   = preg_replace("/image\=\"[\s+]?\<\!\-\-\{loadImage\s+\\\$([a-z0-9_\[\]\']+)\s+([a-z]+)\s+([0-9a-z]+)\s+([a-z0-9]+)\}\-\-\>\"[\s+]?/i", "href='<?php  echo loadImage(@qc@\\1,'\\2','\\3','\\4'); ?>'", $template);
        $template   = preg_replace("/\<\!\-\-\{cutString\s+\\\$([a-z0-9_,\[\]\']+)\s+([0-9]+)\s+([0-9]+)\s*\}\-\-\>/i", "<?php echo cutString(@qc@\\1,\\2,\\3); ?>", $template);
        $template   = preg_replace("/\<\!\-\-\{formatNumber\s+\\\$([a-z0-9_,\[\]\']+)\s+\\\$([a-z0-9_,\[\]\']+)\s*\}\-\-\>/i", "<?php echo formatNumber(@qc@\\1,@qc@\\2); ?>", $template);
        $template   = preg_replace("/\<\!\-\-\{temp\s+([a-z0-9_\/]+)\}\-\-\>/ie", "\$this->looptemp('\\1')", $template);
        $template   = preg_replace("/\<\!\-\-\{temphome\s+([a-z0-9_\/]+)\}\-\-\>/ie", "\$this->looptemphome(\$module,'\\1')", $template);
        $template   = preg_replace("/\<\!\-\-\{tempblock\s+([a-z0-9_\/]+)\}\-\-\>/ie", "\$this->looptempblock(\$module,'\\1')", $template);
        $template   = preg_replace("/\<\!\-\-\{tempglobal\s+([a-z0-9_\/]+)\s+([a-z0-9_\/]+)\}\-\-\>/ie", "\$this->looptempblock('\\1','\\2')", $template);
        $template   = preg_replace("/\<\!\-\-\{looptemp\s+([a-z0-9_\/]+)\}\-\-\>/ie", "\$this->looptemp('\\1')", $template);
        $template   = preg_replace("/\{lang\s+(\w+?)\s*\}/i", "<?php echo lang('\\1');?>", $template);
        $template   = preg_replace("/\{lang\s+\{\\\$([a-z0-9_,\[\]\']+)\}\s*\}/i", "<?php echo lang(@qc@\\1);?>", $template);
        $template   = preg_replace("/\{show_ss\s+(\w+?)\s*\}/i", "<?php echo show_ss('\\1');?>", $template);
        $template   = preg_replace("/\{lang\s+(\w+?)\s+([a-z0-9_,]+)\s*\}/i", "<?php echo lang('\\1','\\2');?>", $template);
        $template   = preg_replace("/\{lang\s+(\w+?)\s+\{\\\$([a-z0-9_,\[\]\']+)\}\s*\}/i", "<?php echo lang('\\1',@qc@\\2);?>", $template);
        $template   = preg_replace("/\{lang\s+(\w+?)\s+(\w+)\{\\\$([a-z0-9_,\[\]\']+)\}\s*\}/i", "<?php echo lang('\\1','\\2'.@qc@\\3);?>", $template);
        $template   = preg_replace("/\{lang\s+(\w+)\{\\\$([a-z0-9_,\[\]\']+)\}\s*\}/i", "<?php echo lang('\\1'.@qc@\\2);?>", $template);
        $template   = preg_replace("/\<\!\-\-\{eval\s+(.+?)\s*\}\-\-\>/ies", "\$this->evaltags('\\1')", $template);
        $var_regexp = "((\\\$[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)(\[[a-zA-Z0-9_\-\.\"\'\[\]\$\x7f-\xff]+\])*)";
        $template   = preg_replace("/\<\!\-\-\{(.+?)\}\-\-\>/s", "{\\1}", $template);
        $template   = preg_replace("/([\n\r]+)\t+/s", "\\1", $template);
        $template   = preg_replace("/(\\\$[a-zA-Z0-9_\[\]\'\"\$\x7f-\xff]+)\.([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)/s", "\\1['\\2']", $template);
        $template   = preg_replace("/\{(\\\$[a-zA-Z0-9_\[\]\'\"\$\.\x7f-\xff]+)\}/s", "<?=\\1?>", $template);
        $template   = preg_replace("/$var_regexp/es", "\$this->addquote('<?=\\1?>')", $template);
        $template   = preg_replace("/\<\?\=\<\?\=$var_regexp\?\>\?\>/es", "\$this->addquote('<?=\\1?>')", $template);

        $template = preg_replace("/\{elseif\s+(.+?)\}/ies", "\$this->stripvtags('<?php } elseif(\\1) { ?>','')", $template);
        $template = preg_replace("/\{else\}/is", "<?php } else { ?>", $template);

        for ($i = 0; $i < 10; $i++) {
            $template = preg_replace("/\{loopfor\s+(\S+)\s+(\S+)\s+(\S+)\}(.+?)\{\/loopfor\}/ies", "\$this->stripvtags('<?php for(\\1 ; \\2 ; \\3) { ?>','\\4<?php }  ?>')", $template);
            $template = preg_replace("/\{loop\s+(\S+)\s+(\S+)\}(.+?)\{\/loop\}/ies", "\$this->stripvtags('<?php if(is_array(\\1)) { foreach(\\1 as \\2) { ?>','\\3<?php } } ?>')", $template);
            $template = preg_replace("/\{loop\s+(\S+)\s+(\S+)\s+(\S+)\}(.+?)\{\/loop\}/ies", "\$this->stripvtags('<?php if(is_array(\\1)) { foreach(\\1 as \\2 => \\3) { ?>','\\4<?php } } ?>')", $template);
            $template = preg_replace("/\{if\s+(.+?)\}(.+?)\{\/if\}/ies", "\$this->stripvtags('<?php if(\\1) { ?>','\\2<?php } ?>')", $template);
        }
        $template = preg_replace("/\{([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)\}/s", "<?=\\1?>", $template);
        if (!empty($this->g['block_search'])) {
            $template = str_replace($this->g['block_search'], $this->g['block_replace'], $template);
        }
        $template = preg_replace("/ \?\>[\n\r]*\<\? /s", " ", $template);
        $template = str_replace('@qc@', '$', $template);

        $template = str_replace('web_layout', '<?php include_once $_B[\'temp\']->load(\'layout/layout_\'.$web[\'layout\']);  ?>', $template);

        $dir_config_theme = $this->dirThemes . $this->temp . '/config.json';
        //No Change
        if (file_exists($dir_config_theme)) {
            $post = $this->readConfigJson($dir_config_theme);

            if (!empty($post['positions'])) {
                $positions_adv = array();
                foreach ($post['positions'] as $k_adv => $v_adv) {
                    preg_match("/adv_([0-9]+)/i", $k_adv, $matches_adv);
                    if ($matches_adv[1]) {
                        $positions_adv[$matches_adv[1]] = $v_adv;
                    }
                }
                krsort($positions_adv);
                foreach ($positions_adv as $kp => $vp) {
                    $kp = 'adv_' . $kp;
                    if (!in_array($kp, $post['arr_block_post'])) {
                        $template = str_replace('bnc_position_adv_' . $kp, '<?php  include $_B[\'temp\']->printposAd("' . $kp . '"); ?>', $template);
                    }
                }
            }
            if (!empty($post['blocks'])) {
                krsort($post['blocks']);
                foreach ($post['blocks'] as $kp => $vp) {
                    $template = str_replace('bnc_position_block_' . $kp, '<?php $_B[\'temp\']->printpos("' . $kp . '"); ?>', $template);
                }
            }
        }

        $template = str_replace('load_temp', '<?php include_once $_B[\'temp\']->load($mod.\'/\'.$data[\'load_temp\']); ?>', $template);
        $template = str_replace('bnc_position_home', '<?php $_B[\'temp\']->printhome(); ?>', $template);

        $template = preg_replace('/\{\[form=([0-9]+)\]\}/i', '<?php echo $_B[\'temp\']->printForm(\'\\1\'); ?>', $template);
        //Lang themes
        $template = preg_replace("/{lang_theme\\s([a-zA-Z0-9_-]+)}/i", '<?php echo $_B[\'temp\']->langTheme(\'$1\');?>', $template);

        //Count all Product in cat
        $template = preg_replace("/{count_product_incat\\s<\\?\\=([a-zA-Z0-9$\"_'[\\]]+)\\?>}/i", '<?php echo $_B[\'temp\']->countProductInCat($1);?>', $template);
        //Show s_name
        $template = str_replace('<base href=', '<base s_name="' . $web['s_name'] . '" href=', $template);
        // if (isset($_COOKIE['truong'])) {
        // if($web['idw']!=336){
        // if (isset($_COOKIE['truong']) || isset($_COOKIE['xteam']) || $web['idw'] == 406 || $web['idw'] == 408 || $web['idw'] == 693) {

        // } else {
        //     $template = Minify_HTML::minify($template, array(
        //         'cssMinifier',
        //         'jsMinifier',
        //     ));
        // }

        // }

        // $template = preg_replace( '/<!--(.|\s)*?-->/' , '' , $template);
        // $template = preg_replace("/[^\"|'|http:\\/\\/|https:\\/\\/]\\/\\/(.*)/i", '', $template);
        // $search   = array("/\>[^\S ]+/s", '/[^\S ]+\</s', '/(\s)+/s');
        // $replace  = array('>', '<', '\\1');
        // $template = preg_replace($search, $replace, $template);
        // $template = str_replace(array("\n","\r","\t"),'',$template);
        //$template = preg_replace(array('/<!--(.*)-->/Uis',"/[[:blank:]]+/"),array('',' '),str_replace(array("\n","\r","\t"),'',$template));
        //}
        $template = preg_replace("/<meta property=\"fb:app_id\"\\s+content=\"(.*)\"\\/>/", '', $template);
        $template = preg_replace("/<meta property=\"fb:admins\"\\s+content=\"(.*)\"\\/>/", '', $template);
        if ($web['info']['facebook_ver_app']) {
            $facebook_ver = $web['info']['facebook_ver_app'];
        } else {
            $facebook_ver = '2.7';
        }
        //Loại bỏ include js của facebook
        if ($web['info']['facebook_app'] != false) {

            $facebook_app = '&appId=' . $web['info']['facebook_app'];
            $template     = str_replace('</head>', '<meta property="fb:app_id" content="' . $web['info']['facebook_app'] . '"/></head>', $template);
        } else {
            $facebook_app = '';
        }

   

 

      
        if ($web['info']['facebook_admin'] != false) {
            $template = str_replace('</head>', '<meta property="fb:admins" content="' . $web['info']['facebook_admin'] . '"/></head>', $template);
        }

        $template = preg_replace("/<script>\\(function\\(d,(.*)'facebook-jssdk'\\)\\);<\\/script>/s", '', $template);
        $template = str_replace('<div id="fb-root"></div>', '', $template);
        //connect.facebook.net/en_GB/all.js
        ////connect.facebook.net/vi_VN/sdk.js
//         $template = preg_replace("/<body(.*)>/", '<body$1><div id="fb-root"></div>
// <script>(function(d, s, id) {
//   var js, fjs = d.getElementsByTagName(s)[0];
//   if (d.getElementById(id)) return;
//   js = d.createElement(s); js.id = id;
//   js.src = "//connect.facebook.net/vi_VN/all.js#xfbml=1' . $facebook_app . '";
//   fjs.parentNode.insertBefore(js, fjs);
// }(document, "script", "facebook-jssdk"));</script>', $template);

     

        /*$template = preg_replace("/[^\"|'|http:\\/\\/|https:\\/\\/]\\/\\/(.*)/i", '', $template);
        $search   = array('/\>[^\S ]+/s', '/[^\S ]+\</s', '/(\s)+/s');
        $replace  = array('>', '<', '\\1');
        $template = preg_replace($search, $replace, $template);*/
        
        //Chữ thiết kế website

     

        // if ($web['idw'] == 127) {
        //     $template = str_replace('<html', '<html manifest="manifest.appcache" ', $template);
        // }

        $template = "<?php
                    /**
                     * @Project BNC v2 -> Template
                     * @File $objfile
                     * @Author Quang Chau Tran (quangchauvn@gmail.com)
                     */
                    if(!defined('BNC_CODE')) {
                        exit('Access Denied');
                    }
                    ?>$template";

        if (!$this->swritefile($objfile, $template)) {
            exit("File: $objfile can not be write!");
        }
    }
    public function checkGzip() {

        // if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) {
        //     ob_start('ob_gzhandler');
        // } else {
        //     ob_end_clean();
        //     ob_start();
        // }

        return '<!DOCTYPE';
    }

    /**
     * Doc noi dung file
     * @param  string $filename file can doc
     * @return string $content noi dung cua file
     */
    private function sreadfile($filename) {
        $content = '';
        if (function_exists('file_get_contents')) {
            @$content = file_get_contents($filename);
        } else {
            if (@$fp = fopen($filename, 'r')) {
                @$content = fread($fp, filesize($filename));
                @fclose($fp);
            }
        }

        return $content;
    }
    /**
     *
     */
    private function readConfigJson($dir) {
        $json = json_decode(file_get_contents($dir), 1);
        if (!empty($json['config']['blocks'])) {
            foreach ($json['config']['blocks'] as $k => $v) {
                $j['blocks'][$v['key']]         = $v['name'];
                $j['arr_block_post'][$v['key']] = $v['key'];
            }
        }
        if (!empty($json['config']['blocks'])) {
            foreach ($json['config']['positions'] as $k => $v) {
                $j['positions'][$v['key']] = $v['name'];
            }
        }

        return $j;
    }

    /**
     * Doc noi dung file template
     * @param  string $name    ten cua file html
     * @return string $content noi dung cua file html
     */
    private function readtemplate($name) {
        global $_B;
        $tplfile = $this->dir_theme . $name . '.htm';
        $content = $this->sreadfile($tplfile);

        return $content;
    }

    /**
     * Ghi file
     * @param  string $filename  ten file can ghi
     * @param  string $writetext du lieu su dung ghi
     * @param  string $openmod   che do thao tac voi file (mac dinh la 'w')
     * @return bool   : true neu ghi thanh cong : false neu ghi that bai
     */
    private function swritefile($filename, $writetext, $openmod = 'w') {
        $filename_arr = explode('/', $filename);
        unset($filename_arr[count($filename_arr) - 1]);
        $folder = implode('/', $filename_arr);
        $this->rmkdir($folder, 0775);
        if (@$fp = fopen($filename, $openmod)) {
            flock($fp, 2);
            fwrite($fp, $writetext);
            fclose($fp);
            chmod($filename, 0664);

            return true;
        } else {
            return false;
        }
    }

    /**
     * addquote
     * @param  string $var  chuoi ki tu
     * @return string chuoi ki tu da addqoute
     */
    private function addquote($var) {
        return str_replace("\\\"", "\"", preg_replace("/\[([a-zA-Z0-9_\-\.\x7f-\xff]+)\]/s", "['\\1']", $var));
    }

    /**
     * stripvtags
     * @param  string $expr
     * @param  string $statement
     * @return string chuoi ky tu da strip
     */
    private function stripvtags($expr, $statement = '') {
        $expr      = str_replace("\\\"", "\"", preg_replace("/\<\?\=(\\\$.+?)\?\>/s", "\\1", $expr));
        $statement = str_replace("\\\"", "\"", $statement);

        return $expr . $statement;
    }

    /**
     * looptemp
     * @param  string $parameter
     * @return string $search chuoi ky tu
     */
    private function looptemp($parameter) {
        $this->g['i']++;
        $search                                  = "<!--TEMPWEB_TAG_{$this->g['i']}-->";
        $this->g['block_search'][$this->g['i']]  = $search;
        $this->g['block_replace'][$this->g['i']] = "<?php include \$_B['temp']->load('$parameter') ?>";

        return $search;
    }
    /**
     * @param $mod
     * @param $parameter
     */
    private function looptemphome($mod, $parameter) {
        $this->g['i']++;
        $search                                  = "<!--TEMPWEB_TAG_{$this->g['i']}-->";
        $this->g['block_search'][$this->g['i']]  = $search;
        $this->g['block_replace'][$this->g['i']] = "<?php include \$_B['temp']->load_block('$parameter','$mod') ?>";

        return $search;
    }
    /**
     * @param $mod
     * @param $parameter
     */
    private function looptempblock($mod, $parameter) {
        $this->g['i']++;
        $search                                  = "<!--TEMPWEB_TAG_{$this->g['i']}-->";
        $this->g['block_search'][$this->g['i']]  = $search;
        $this->g['block_replace'][$this->g['i']] = "<?php include \$_B['temp']->load_block('$parameter','$mod') ?>";

        return $search;
    }
    /**
     * evaltags
     * @param  string $php
     * @return string $search
     */
    private function evaltags($php) {
        $this->g['i']++;
        $search                                  = "<!--EVAL_TAG_{$this->g['i']}-->";
        $this->g['block_search'][$this->g['i']]  = $search;
        $this->g['block_replace'][$this->g['i']] = "<?php " . $this->stripvtags($php) . " ?>";

        return $search;
    }

    /**
     * Xuat blocks ra he thong
     * @param  vitri   int;
     * @return array
     */
    private function readBlocks($module) {
        $dir     = DIR_MODULES . $module . "/blocks/";
        $fileArr = array();
        if (is_dir($dir)) {
            $files = scandir($dir);
            $re    = '/^([a-zA-Z0-9]+)\.php$/';
            foreach ($files as $file) {
                if (preg_match($re, $file)) {
                    $fileArr[] = basename($file, '.php');
                }
            }
        }

        return $fileArr;
    }
    /**
     * Load Positon Ad
     */
    private function getAdv($pos, $block = false) {
        global $_B, $mod, $web;
        db_connect('template');
        $adsObj = new Model($this->lang . '_adv_image');
        $adsObj->where('idw', $this->idw);
        $adsObj->where('position', $pos);
        $adsObj->where('status', 1);
        $adsObj->orderBy('sort', 'ASC');
        $images = $adsObj->get();
        if (!empty($images)) {
            foreach ($images as $k => $v) {
                if (($v['start_time'] <= time() && time() <= $v['finish_time']) || $v['finish_time'] == 0) {
                    $v['type'] = 'image';
                    if ($_B['temp']->checkActiveMod($v['active_mod'])) {
                        $adv[] = $v;
                    }

                }
            }
        }
        $adsObjFlash = new Model($this->lang . '_adv_flash');
        $adsObjFlash->where('idw', $this->idw);
        $adsObjFlash->where('position', $pos);
        $adsObjFlash->where('status', 1);
        $adsObjFlash->orderBy('sort', 'ASC');
        $flash = $adsObjFlash->get();
        if (!empty($flash)) {
            foreach ($flash as $k => $v) {
                if (($v['start_time'] <= time() && time() <= $v['finish_time']) || $v['finish_time'] == 0) {
                    $v['type']  = 'flash';
                    $v['flash'] = loadFlash($v['flash'], $v['width'], $v['height']);
                    if ($_B['temp']->checkActiveMod($v['active_mod'])) {
                        $adv[] = $v;
                    }
                }
            }
        }
        $adsObjText = new Model($this->lang . '_adv_text');
        $adsObjText->where('idw', $this->idw);
        $adsObjText->where('position', $pos);
        $adsObjText->where('status', 1);
        $adsObjText->orderBy('sort', 'ASC');
        $texts = $adsObjText->get();
        if (!empty($texts)) {
            foreach ($texts as $k => $v) {
                if (($v['start_time'] <= time() && time() <= $v['finish_time']) || $v['finish_time'] == 0) {
                    $v['type'] = 'text';
                    if ($_B['temp']->checkActiveMod($v['active_mod'])) {
                        $adv[] = $v;
                    }
                }
            }
        }

        $adsObjGG = new Model($this->lang . '_adv_ggadsense');
        $adsObjGG->where('idw', $this->idw);
        $adsObjGG->where('position', $pos);
        $adsObjGG->where('status', 1);
        $adsObjGG->orderBy('sort', 'ASC');
        $gga = $adsObjGG->get();
        if (!empty($gga)) {
            foreach ($gga as $k => $v) {
                if (($v['start_time'] <= time() && time() <= $v['finish_time']) || $v['finish_time'] == 0) {
                    $v['type'] = 'gg';
                    if ($_B['temp']->checkActiveMod($v['active_mod'])) {
                        $adv[] = $v;
                    }
                }
            }
        }

        if (!empty($adv)) {
            return $adv;
        }

    }
    /**
     * @param  $vitri
     * @return mixed
     */
    public function printposAd($vitri) {
        global $_B, $web;
        $adv = $this->getAdv($vitri);

        // foreach ($adv as $row) {
        //     foreach ($row as $key => $value) {
        //         ${$key}[] = $value;
        //     }
        // }
        // array_multisort($sort, SORT_ASC, $adv);
        if (!empty($adv)) {
            foreach ($adv as $key => $row) {
                $sort[$key]   = $row['sort'];
                $status[$key] = $row['status'];
            }
            array_multisort($sort, SORT_ASC, $status, SORT_ASC, $adv);

            $web['adv'][$vitri] = $adv;
        }

        return $_B['temp']->load('common/bnc_position_adv_' . $vitri);
    }
    /**
     * @param $active_mod
     */
    public function checkActiveMod($active_mod) {
        global $mod;
        @$active_mods  = explode(',', $active_mod);
        $active_mods[] = 'tag';
        if (!empty($active_mods) && !in_array($mod, $active_mods) && !in_array('all', $active_mods)) {
            return false;
        }

        return true;
    }
    /**
     * @param  $block
     * @param  $vitri
     * @return null
     */
    public function showAds($block, $vitri) {
        global $web, $_B;
        if (!$this->checkActiveMod($block['active_mod'])) {
            return;
        }
        //$data['content']['adBlock'] = $block;
        $web['adv'][$vitri][0] = $block;
        include $_B['temp']->load('common/bnc_position_adv_adv_' . $vitri);
        // if (file_exists($this->dirThemes.$this->temp.'/common/bnc_position_adv_block_'.$vitri.'.htm')) {

        // }else{
        //     include $_B['temp']->load('common/bnc_position_adv_adv_'.$vitri);

        // }

    }
    /**
     * @param $vitri
     * @param $type
     */
    public function printpos($vitri, $type = 'block') {
        global $mod, $_B, $web;

        $blockObj = new Model($this->lang . '_block', db_connect('template'));
        $blockObj->where('idw', $this->idw);
        $blockObj->where('position', $vitri);
        $blockObj->where('status', 1);
        $blockObj->orderBy('sort', 'ASC');
        $listBlocks = $blockObj->get();
       

        $adv = $this->getAdv($vitri, true);
        if (is_array($adv)) {
            $listBlocks = array_merge($listBlocks, $adv);
            foreach ($listBlocks as $key => $row) {
                $sort[$key]   = $row['sort'];
                $status[$key] = $row['status'];
            }
            array_multisort($sort, SORT_ASC, $status, SORT_ASC, $listBlocks);
        }

        //$listBlocks = $this->readBlocks($mod);

        foreach ($listBlocks as $key => $value) {
            if ((int) $value['type'] == 1 && (!empty($value['data_custome']))) {
                $this->printBlockCus($value, $vitri);
            } elseif (in_array((string) $value['type'], $ads)) {
                $this->showAds($value, $vitri);
            } elseif ((int) $value['type'] == 0 || (int) $value['type'] == 2) {
                $this->loadBlock($value, $vitri);
            } elseif ((int) $value['type'] == 3) {
                $data_custome     = json_decode($value['data_custome'], true);
                $data_custome_new = array();

                foreach ($data_custome as $k => $v) {
                    if ($v['type'] == 1) {
                        $v['image'] = 'https://cdn1.iconfinder.com/data/icons/fs-icons-ubuntu-by-franksouza-/256/skype_contact_online.png'; //skype
                    } elseif ($v['type'] == 2) {
                        $v['image'] = 'http://i272.photobucket.com/albums/jj199/GenesisBoy/Yahoo_Messenger_Own_Win.png'; //Yahoo
                    } elseif ($v['type'] == 3) {
                        $v['image'] = 'http://www.veryicon.com/icon/png/Business/Real%20Vista%20Communications/phone.png'; //Phone
                    }
                    $data_custome_new[$v['name']][] = $v;
                }
                $value['data_custome'] = $data_custome_new;
                $this->loadBlock($value, $vitri);
            }
        }
    }
    /**
     * @param  $block
     * @param  $vitri
     * @return null
     */
    private function printBlockCus($block, $vitri) {
        global $_B;
        require_once DIR_CLASS . 'controller.php';
        $controller = new Controller();

        if (!$this->checkActiveMod($block['active_mod'])) {
            return;
        }
        $data = json_decode($block['data_custome'], 1);

        $htm = '<style>' . $data['css'] . '</style>';
        $htm .= $controller->getForm($data['html']);

        echo $htm;

        return;
        // if (in_array($vitri,array(1,2,3,4))) {
        //     return;
        // }else{
        //     include $_B['temp']->load('common/bnc_position_block_'.$vitri);
        // }
    }
    /**
     * @param  $block
     * @param  $vitri
     * @return null
     */
    private function loadBlock($block, $vitri = null) {
        global $_B, $_L, $web, $mod, $webObj;
        if (!$this->checkActiveMod($block['active_mod'])) {
            return;
        }

        $module = $block['module_str'];
        $file   = $block['file'];
        $temp   = 'blocks/' . $file;

        if (file_exists(DIR_MODULES . $module . "/lang/" . $_B['lang'] . "/block.php")) {
            include_once DIR_MODULES . $module . "/lang/" . $_B['lang'] . "/block.php";
        }

        $info_cache = $_B['info_cache'];
        $cache_key  = md5($info_cache['domain'] . '_block_' . $module . '_' . $info_cache['mod'] . $file . $_B['lang']);
        $cache_tag  = $info_cache['mod'];
        $flag_cache = false;
        //Cache ở chỗ này
        if ($_B['cache_on'] == true && $file != 'blockAnalytics' && $file != 'blockSearch' && $file != 'blockHistory') {
            $flag_cache = true;
            //Set tags cache
            $data = $_B['cache']->get_tags($cache_tag, $cache_key);
            if (empty($data)) {
                $flag_cache = false;
            }
        }

        if (!$flag_cache) {
            if (!empty($file)) {
                include_once DIR_MODULES . $module . "/blocks/" . $file . ".php";
            } else {
                return false;
            }
            $class    = 'module\\' . $module . '\\' . $file . '\\Block';
            $blockObj = new $class;
            //$blockObj->limit = 2;
            $data = $blockObj->getReturnData();
            $_B['cache']->set($cache_key, $data);
            $_B['cache']->set_tags($cache_tag, $cache_key);
        }

        //Kết thúc cache
        if (isset($_COOKIE['sv']) && $block['file'] == 'blockSlideRight') {
            echo "<pre>";
            print_r($data);
            echo "</pre>";

        }
        //$data['content'] = $data;
        $tmp                    = $web['static_temp_mod'];
        $web['static_temp_mod'] = $webObj->get_static_theme_mod($module);
        $block['title']         = $block['title']; //$blockInfo[$this->lang.'_name'];
        $block['position']      = $vitri;

        include $_B['temp']->load_block($temp, $module);
        $web['static_temp_mod'] = $tmp;
    }

    /**
     * @param  $module
     * @return mixed
     */
    private function readHome($module) {
        $dir     = DIR_MODULES . $module . "/homes/";
        $fileArr = array();
        $files   = scandir($dir);
        $re      = '/^([a-zA-Z0-9\_]+)\.php$/';
        foreach ($files as $file) {
            if (preg_match($re, $file)) {
                $fileArr[] = basename($file, '.php');
            }
        }

        return $fileArr;
    }

    /**
     * [printhome description]
     * @Modify  Truong Nguyen
     * @email  truongnx28111994@gmail.com
     * @date   2015-07-29
     * @return [type] [description]
     */
    public function printhome() {
        global $_B, $mod;
        db_connect('template');
        $blockObj = new Model($this->lang . '_home');
        $blockObj->where('idw', $this->idw);
        $blockObj->where('status', 1);
        $blockObj->orderBy('sort', 'ASC');
        $listBlocks = $blockObj->get(null, null, 'module_str,file,title');
        foreach ($listBlocks as $k => $v) {
            $this->loadHome($v);
        }
    }
    /**
     * [loadHome description]
     * @email  truongnx28111994@gmail.com
     * @date   2015-07-29
     * @author Truong Nguyen
     *
     * @param  array  $home           [description]
     * @return [type] [description]
     */
    private function loadHome($home = array()) {
        global $_B, $_L, $web, $webObj;
        $module    = $home['module_str'];
        $file      = $home['file'];
        $temp      = 'homes/' . $file;
        $path_lang = DIR_MODULES . $module . '/lang/' . $_B['lang'] . '/main.php';
        if (is_file($path_lang)) {
            include_once $path_lang;
        }
        //Set cache
        $info_cache = $_B['info_cache'];
        $cache_key  = md5($info_cache['domain'] . '_home_' . $module . '_' . $info_cache['mod'] . $file . $_B['lang']);
        $cache_tag  = $info_cache['mod'];

        $flag_cache = false;
        if ($_B['cache_on'] == true) {
            $flag_cache = true;
            //Set tags cache
            $data = $_B['cache']->get_tags($cache_tag, $cache_key);
            if (empty($data)) {
                $flag_cache = false;
            }
        }
        if (!$flag_cache) {
            include_once DIR_MODULES . $module . '/homes/' . $file . '.php';
            $class           = 'module\\' . $module . '\\' . $file . '\\BlockHome';
            $blockObj        = new $class;
            $data            = $blockObj->returnData;
            $data['content'] = $data;
            $_B['cache']->set($cache_key, $data);
            $_B['cache']->set_tags($cache_tag, $cache_key);
        }

        //Kết thúc set cache
        if ($home['title'] != null) {
            $home['title'] = $home['title'];
        } else {
            $home['title'] = lang($file);
        }

        $tmp                    = $web['static_temp_mod'];
        $web['static_temp_mod'] = $webObj->get_static_theme_mod($module);
        include $_B['temp']->load_home($temp, $module);
        $web['static_temp_mod'] = $tmp;
    }

    /**
     * @param  $id
     * @return mixed
     */
    public function printForm($id) {
        global $web;
        $db      = db_connect('template');
        $formObj = new Model($this->lang . '_formcustom', $db);
        $formObj->where('idw', $web['idw']);
        $formObj->where('id_form', $id);
        $formObj->where('status', 1);
        $forms = $formObj->getOne(null, 'id,id_lang,form_frontend,title,status,id_form');
        $form  = '<div class="form_' . $forms['id_form'] . 'title_">' . $forms['title'] . '</div>';
        $form .= '<form id="formCustom_' . $forms['id_form'] . '" method="POST" action="' . $web['home_url'] . '/template-form-add' . $web['dotExtension'] . '" name="formCustom_' . $forms['id'] . '"  enctype="multipart/form-data">';
        $form .= $forms['form_frontend'];
        $form .= '<input type="hidden" name="lang" value="' . $this->lang . '" />';
        $form .= '<input type="hidden" name="form_id" value="' . $forms['id'] . '" />';
        $form .= '</form>';

        return $form;
    }

    /**
     * @return mixed
     */
    public function genCopyRight() { 
        return '';
    }

    /**
     * [langTheme description]
     * @email  truongnx28111994@gmail.com
     * @date   2015-07-29
     * @author Truong Nguyen
     *
     * @param  [type] $key            [description]
     * @return [type] [description]
     */
    public function langTheme($key) {
        global $web, $_B;
        $path    = DIR_THEME . $web['theme_id'] . '/config.json';
        $content = json_decode(file_get_contents($path), true);

        if (isset($content['config']['lang_theme'][$_B['lang']][$key])) {
            return $content['config']['lang_theme'][$_B['lang']][$key];
        } else {
            return 'No lang in config.json';
        }

    }

    /**
     * [countProductInCat description]
     * @email  truongnx28111994@gmail.com
     * @date   2015-07-29
     * @author Truong Nguyen
     *
     * @param  [type] $cat            [description]
     * @return [type] [description]
     */
    public function countProductInCat($cat) {
        global $_B;
        $db      = db_connect('product');
        $oBj     = new Model($_B['lang'] . '_product_basic', $db);
        $cat     = explode('|', $cat);
        $product = array();
        $count   = 0;
        foreach ($cat as $k => $v) {
            if ($v != '') {
                $oBj->where('idw', $this->idw);
                $oBj->where('status', 1);
                $oBj->where('category', '%|' . $v . '|%', 'LIKE');
                $tmp_product = $oBj->get(null, null, 'id');
                foreach ($tmp_product as $k2 => $v2) {
                    if (!in_array($v2, $product)) {
                        $product[] = $v2;
                        $count += 1;
                    }
                }
            }
        }
        unset($oBj);
        unset($db);
        unset($product);
        unset($cat);

        return $count;
    }

    /**
     * [rmkdir description]
     * @email  truongnx28111994@gmail.com
     * @date   2015-09-09
     * @author Truong Nguyen
     *
     * @param  [type]  $path           [description]
     * @param  integer $mode           [description]
     * @return [type]  [description]
     */
    private function rmkdir($path, $mode = 0777) {
        $path = rtrim(preg_replace(array("/\\\\/", "/\/{2,}/"), "/", $path), "/");
        $e    = explode("/", ltrim($path, "/"));
        if (substr($path, 0, 1) == "/") {
            $e[0] = "/" . $e[0];
        }
        $c  = count($e);
        $cp = $e[0];
        for ($i = 1; $i < $c; $i++) {
            if (!is_dir($cp) && !@mkdir($cp, $mode)) {
                return false;
            }
            $cp .= "/" . $e[$i];
        }

        return @mkdir($path, $mode);
    }
}