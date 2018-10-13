<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Common extends MY_Controller {

    public function __construct() {
        parent::__construct();

    }

    public  function  getMessages(){
        $data['returnCd'] = "OK";
        $data['msgList'] = $this->load_language('common');
        $data['returnMsg'] = '';
        $this->return_json($data);
    }
}
