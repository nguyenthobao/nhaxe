<?php
// phpFastCache Library
// Ngày cập nhật. 26/01/2016 - 5:14 PM

use \phpFastCache;

class Cache {
    function __construct() {
        require_once dirname(__FILE__) . "/phpfastcache/3.0.0/phpfastcache.php";
        // OK, setup your cache

        phpFastCache::$config = array(
            "storage"       => 'memcached', // auto, files, sqlite, apc, cookie, memcache, memcached, predis, redis, wincache, xcache
            "default_chmod" => 0777, // For security, please use 0666 for module and 0644 for cgi.
            /*
             * OTHERS
             */
            // create .htaccess to protect cache folder
            // By default the cache folder will try to create itself outside your public_html.
            // However an htaccess also created in case.
            "htaccess"      => false,
            // path to cache folder, leave it blank for auto detect
            "path"          => DIR_TMP . '/cache',
            //"securityKey"   => "truong@123", // auto will use domain name, set it to 1 string if you use alias domain name
            // MEMCACHE
            "memcache"      => array(array("localhost", 6868, 1)),
            // REDIS
            "redis"         => false,

            //"extensions"    => '.c',
            /*
             * Fall back when old driver is not support
             */
            //"fallback"      => 'files',
        );
        //temporary disabled phpFastCache
        phpFastCache::$disabled = false;
        $this->phpFastCache     = new phpFastCache();

    }

    public function set($key, $value, $time = null) {
        return $this->phpFastCache->set($key, $value, $time);
    }
    public function get($key) {
        return $this->phpFastCache->get($key);
    }
    public function delete($key) {
        return $this->phpFastCache->delete($key);
    }
    public function isExisting($key) {
        return $this->phpFastCache->isExisting($key);
    }
    public function getInfo($key) {
        return $this->phpFastCache->getInfo($key);
    }
}
