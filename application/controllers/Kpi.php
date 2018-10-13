<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kpi extends MY_Controller {

    public function __construct() {
        parent::__construct();

        /*Authentication - Begin*/
        $this->check_auth = $this->check_login();
        /*Authentication - End*/
    }

    public function index() {

        $profile = $this->profile;
        if (!check_ACL($profile, 'kpi', 'menu')) {
            $this->load->helper('url');
            redirect('/');
        }

        // Layout library loaded site wide
        $this->set_layout();
        $this->layout->title('KPI | Strikeforce');

        $data = array();

        //Set data for layout
        $data['index'] = 'kpi';
        $data['html_module'] = 'kpi0100Module';
        $data['body_id'] = '';
        $data['body_module'] = 'KPI0100Ctrl';
        $data['body_ngInit'] = 'init()';
        $data['body_cssClass'] = '';
        $this->set_data_for_layout($data);
        
        $this->layout->view('kpi/index', $data);
    }

    public function initData() { 
        $data['returnCd'] = NULL;
        $data['returnMsg'] = NULL;
        $data['resultTeam'] = [];
        $profile = $this->profile;

        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'coa', 'menu')) {
        	$param = json_decode(trim(file_get_contents('php://input')), true);
        	$this->load->model('product_type_mst_model');
        	$data["resultTeam"] = array("teamInfo"=>$this->product_type_mst_model->proTypeResultDto($param));
        }

        $this->return_json($data); 
    }

    public function searchData() {
        $data['returnCd'] = NULL;
        $data['returnMsg'] = NULL;
        $data['resultSearch'] = [];
        $data['timeInfo'] = [];
        $profile = $this->profile;

         if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'coa', 'menu')) {
            $param = json_decode(trim(file_get_contents('php://input')), true);  
            
            $this->load->model('kpi_model'); 
            $data['resultSearch'] = $this->kpi_model->getSalesmanByProducTypeId($param);
            $data['timeInfo'] = $this->kpi_model->getByProductTypeIdAndTimeKPI($param);
            
        }
        $this->return_json($data);
    }
    
    public function saveKpi() {
    	$data['returnCd'] = NULL;
    	$data['returnMsg'] = NULL;
    	$data['proResult'] = [];
    	$data['productTypeKpiId'] = "";
    	$profile = $this->profile;
    	if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'kpi', 'save')) {
    		$params = json_decode(trim(file_get_contents('php://input')), true);
    		$this->load->model('kpi_model');
    		$data['productTypeKpiId'] = $this->kpi_model->insertKPI($params);
    			$data['proResult'] =   array("proFlg"=>$assign,"message"=>I0000009);
    	}
    	$this->return_json($data);
    }
}
