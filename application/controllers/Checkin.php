<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checkin extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        /*Authentication - Begin*/
        $this->check_auth = $this->check_login();
        /*Authentication - End*/
    }

    public function index()
    {
        $data['profile'] = $this->profile;
        $this->load->view('checkin/index', $data);
    }

    public function initData()
    {
        $data['returnCd'] = NULL;
        $data['returnMsg'] = NULL;
        $data['initData'] = [];
        $data['productInfoList'] = [];
        $data['pagingInfo'] = [];
        $profile = $this->profile;

        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'dashboard', 'menu')) {

            $params = json_decode(trim(file_get_contents('php://input')), true);
            $this->load->model('client_model');

            $this->load->model('product_type_mst_model');
            $this->load->model('checkin_model');

            $dataFilter["productTypeList"] =  $this->product_type_mst_model->proTypeResultDto($params);
            $data['initData'] =  $dataFilter;

            $list = $this->checkin_model->searchAllCheckin($params);
            if (!empty($list)) {
                $data['salesmanCheckin'] = $list["salesmanCheckin"];
                $data['pagingInfo'] = $list["pagingInfo"];
            }
        }
        $this->return_json($data);
    }

    public function searchData()
    {
        $data['returnCd'] = NULL;
        $data['returnMsg'] = NULL;
        $data['initData'] = [];
        $data['salesmanCheckin'] = [];
        $data['pagingInfo'] = [];

        $profile = $this->profile;
        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'dashboard', 'menu')) {

            $params = json_decode(trim(file_get_contents('php://input')), true);
            $this->load->model('checkin_model');

            $list = $this->checkin_model->searchAllCheckin($params);
            if (!empty($list)) {
                $data['salesmanCheckin'] = $list["salesmanCheckin"];
                $data['pagingInfo'] = $list["pagingInfo"];
            }

        }
        $this->return_json($data);
    }
}
