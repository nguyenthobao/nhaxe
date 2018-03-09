<?php
/**
 * @Project BNC v2 -> Adminuser
 * @File /config/main.php
 * @Author Quang Chau Tran (quangchauvn@gmail.com)
 * @Createdate 08/14/2014, 02:04 PM
 */
if (!defined('BNC_CODE')) {
    exit('Access Denied');
}
$_B               = $_BC               = $_CFD               = []; 

$_CFD['db_host']  = $_BC['db_host']  = '127.0.0.1'; 
$_CFD['db_user']     = $_BC['db_user']     = 'sql_anvui';
$_CFD['db_password'] = $_BC['db_password'] = 'JPs2gdCcquRV7WpR_4jP';
$_CFD['db_charset']  = $_BC['db_charset']  = 'utf8';
$_CFD['db_name']     = $_BC['db_name']     = 'db_anvui';
$_CFD['db_port']     = $_BC['db_port']     = 3306;
$_B['day_try']       = 45;
$_B['home']          = 'nhaxe.vn';
$_B['theme']         = 'default';
 
$_B['upload_path'] = 'http://cdn.anvui.vn/';
 
$_B['static_default'] = 'http://web.anvui.vn/themes/';
$_CACHE['redis']      = false;
$_CACHE['memcache']   = false;
//if ($_COOKIE['sv']) {
$_B['cache_on'] = false;
 
