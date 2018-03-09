<?php
/**
 * @Project BNC v2 -> api
 * @File /includes/class/address.php
 * @author Huong Nguyen Ba (nguyenbahuong156@gmail.com)
 * @Createdate 10/01/2014, 10:06 AM
 */
if (!defined('BNC_CODE')) {
    exit('Access Denied');
}
class Address {
    public $db, $r;

    public function __construct() {
        global $_B;
        $this->r  = $_B['r'];
        $this->db = db_connect_mod('user');

    }

    public function getProvince($sub = null) {
        if ($sub == null) {
            $n = 'address_province';
        } else {
            $n = 'address_province_' . $sub;
        }
        $pro    = new Model($n, $this->db);
        $pro->orderBy('name', 'ASC');
        $result = $pro->get(null, null, '*');
        return $result;
    }
    public function getDistrict($id, $sub = null) {

        if ($sub == null) {
            $n = 'address_district';
        } else {
            $n = 'address_district_' . $sub;
        }
        $dis = new Model($n, $this->db);
        $dis->where('provinceid', $id);
        $dis->orderBy('name', 'ASC');
        $result = $dis->get(null, null, '*');
        return $result;
    }

    public function getWard($iddis, $sub = null) {
        if ($sub == null) {
            $n = 'address_ward';
        } else {
            $n = 'address_ward_' . $sub;
        }
        $ward = new Model($n, $this->db);
        $ward->where('districtid', $iddis);
         $ward->orderBy('name', 'ASC');
        $result = $ward->get(null, null, '*');
        return $result;
    }

    public function getProvinceByID($id, $sub = null) {
        if ($sub == null) {
            $n = 'address_province';
        } else {
            $n = 'address_province_' . $sub;
        }
        $pro = new Model($n, $this->db);
        $pro->where('provinceid', $id);
        $result = $pro->getOne(null, '*');
        return $result;
    }
    public function getDistrictByID($id, $sub = null) {
        if ($sub == null) {
            $n = 'address_district';
        } else {
            $n = 'address_district_' . $sub;
        }
        $dis = new Model($n, $this->db);
        $dis->where('districtid', $id);
        $result = $dis->getOne(null, '*');
        return $result;
    }
     

}