<?php
namespace module\template\blockAnalytics;
use BlockGlobal;

class Block extends BlockGlobal {
    public $returnData = array();
    public $idw;
    public function __construct() {
        parent::__construct();
        global $web, $_B;
        $this->idw = $web['idw'];
        $this->setData();
    }

    public function setData() {
    	global $web;
        $link_analytics = 'http://analytic.webbnc.vn/index.php?page=analytics&sub=analytics&func=manage_analytics&idw=' . $this->idw;
        $analytics      = file_get_contents($link_analytics);
        $analytics      = str_replace('BNCcallback(', '', $analytics);
        $analytics      = str_replace(');', '', $analytics);
        $analytics      = json_decode($analytics, true);
        unset($analytics['log']);
        $data = $analytics;
        if ($web['idw'] == 2217) {
            $data['count']['user_online'] +=15;
            $data['count']['day'] +=15;
            $data['count']['week'] +=15;
        }elseif ($web['idw'] == 2318 || $web['idw'] == 2412) {
            $data['count']['user_online'] *=5;
            $data['count']['day'] *=5;
            $data['count']['week'] *=5;
        }
        $this->returnData = $data;
    }

}
