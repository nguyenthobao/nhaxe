
<?php
class ModelContact {
    private $idw, $conObj, $addObj, $qa, $id_field, $lang;
    public $url_mod;
    public $i = 0;
    public function __construct() {
        global $web, $_B;
        $this->lang    = $_B['lang'];
        $this->idw     = $web['idw'];
        $this->url_mod = $_B['url_mod'];
        $this->conObj  = new Model('vi_contactinfo');
        $this->addObj  = new Model($this->lang . '_contact');
        $this->qa      = new Model($this->lang . '_contact_answer');
    }
    public function addContat($data) {
        $dataqa                = array();
        $dataqa['create_time'] = time();
        $data['idw']           = $this->idw;
        //su li truoc khi insert
        $this->addObj->where('idw', $this->idw);
        $select = '*';
        $result = $this->addObj->get(null, null, $select);
        foreach ($result as $k => $v) {
            if ($data['email'] == $v['email']) {
                $dataqa['id_mail']   = $v['id'];
                $dataqa['question']  = $data['content'];
                $dataqa['customers'] = $v['customers'];
                $dataqa['email']     = $data['email'];
                $i++;
            }
        }
        $dataqa['idw'] = $this->idw;

        if ($i == 1) {
            $this->addObj->where('idw', $this->idw);
            $this->addObj->where('email', $data['email']);
            $result = $this->addObj->update($data);
            $result = $this->qa->insert($dataqa);
        } else {
            $result = $this->addObj->insert($data);
            $this->addObj->where('idw', $this->idw);
            $this->addObj->where('email', $data['email']);
            $result              = $this->addObj->getOne(null, null, $select);
            $dataqa['id_mail']   = $result['id'];
            $dataqa['question']  = $result['content'];
            $dataqa['customers'] = $result['customers'];
            $dataqa['email']     = $result['email'];
            $result              = $this->qa->insert($dataqa);
        }

        if ($result) {
            $return['status'] = true;
        } else {
            $return['status'] = false;
        }
        return $return;
    }

    public function getContact() { 
        $this->addObj->where('idw', $this->idw);
        $select = '`id`,`email`';
        $result = $this->addObj->get(null, null, $select);

        return $result;
    }

    public function getContactInfo() {

        $this->conObj->where('idw', $this->idw);
        $this->conObj->where('status', 1);
        $select = 'info,maps';
        $result = $this->conObj->getone(null, null, $select);
        return $result;
    }

}