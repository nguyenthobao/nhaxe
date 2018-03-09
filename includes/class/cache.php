<?php
/**
 * @Project BNC v2 -> Frontend
 * @File /includes/class/cache.php
 * @Author Quang Chau Tran (quangchauvn@gmail.com)
 * @Createdate 10/24/5014, 01:18 AM
 */
if (!defined('BNC_CODE')) {
    exit('Access Denied');
}
class CacheBNC {
    /*
     * config memcache
     */
    // private $memcache_port = 11211;
    //private $memcache_port   = 6868;
    private $memcache_port   = 11211;
    private $memcache_server = array('localhost');
    /*
     * config redis
     */
    private $redis_port   = 6379;
    private $redis_server = array('192.168.1.11');
    /*
     * other
     */
    private $drive;
    public $cache;
    public $cached;
    public function __construct($drive = 'memcache') {
        global $_CACHE;
        $this->current = $_SERVER['HTTP_HOST'];
        $this->cached  = $_CACHE[$drive];
        $this->drive   = $drive;
        return $this->$drive();
    }
    /*
     * drives memcache
     */
    private function memcache() {
        $this->cache = new Memcache;
        foreach ($this->memcache_server as $key => $value) {
            $this->cache->addServer($value, $this->memcache_port);
        }
        //return $this->cache;
    }
    private function memcache_get($key, $compressed) {
        return $this->cache->get($key, $compressed);
    }
    private function memcache_set($key, $value, $compressed, $expire) {
        return $this->cache->set($key, $value, $compressed, $expire);
    }
    private function memcache_del($key) {
        return $this->cache->delete($key);
    }
    private function memcache_flush() {
        return $this->cache->flush();
    }
    private function memcache_getAllKeys() {
        return $this->cache->getAllKeys();
    }
    /*
     * drives redis
     */
    private function redis() {
        $this->cache = new Redis();
        foreach ($this->redis_server as $key => $value) {
            $this->cache->connect($value, $this->redis_port);
        }
        //return $this->cache;
    }
    private function redis_get($key, $compressed) {
        return $this->cache->get($key);
    }
    private function redis_set($key, $value, $compressed, $expire) {
        return $this->cache->set($key, $value);
    }
    private function redis_del($key) {
        return $this->cache->delete($key);
    }
    /*
     * public functions
     */
    public function get($key, $compressed = false) {
        if ($this->cached == false) {
            return false;
        }
        $function = $this->drive . '_get';
        return $this->$function($key, $compressed);
    }
    public function set($key, $value, $compressed = false, $expire = 0) {
        if ($this->cached == false) {
            return false;
        }
        $function = $this->drive . '_set';
        return $this->$function($key, $value, $compressed, $expire);
    }
    public function del($key) {
        if ($this->cached == false) {
            return false;
        }
        $function = $this->drive . '_del';
        return $this->$function($key);
    }
    public function flush() {
        if ($this->cached == false) {
            return false;
        }
        $function = $this->drive . '_flush';
        return $this->$function();
    }

    public function get_tags($tags_name, $key) {
        $tags_name .= '_' . $this->current;
        $tag = $this->get($tags_name);
        if (is_array($tag) && in_array($key, $tag)) {
            $cache = $this->get($key);
            return $cache;
        } else {
            return false;
        }
    }

    public function set_tags($tags_name, $key) {
        $tags_name .= '_' . $this->current;
        $tag = $this->get($tags_name);
        if (is_array($tag) && in_array($key, $tag)) {
            return true;
        } else {
            $tags = $this->get($tags_name);
            if (is_array($tags)) {
                $tags[] = $key;
            } else {
                $tags = array($key);
            }
            return $this->set($tags_name, $tags);
        }
    }

    public function del_tags($tags_name) {
        $tags_name .= '_' . $this->current;
        $tags = $this->get($tags_name);
        if (is_array($tags)) {
            foreach ($tags as $k => $v) {
                $this->del($v);
            }
        }
        return true;
    }

    private function curPageURL() {
        $pageURL = 'http';
        if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
        $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        }
        return $pageURL;
    }

}

?>