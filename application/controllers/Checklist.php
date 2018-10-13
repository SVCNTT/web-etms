<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checklist extends MY_Controller {

    public function __construct() {
        parent::__construct();

        /*Authentication - Begin*/
        $this->check_auth = $this->check_login();
        /*Authentication - End*/
    }

    public function index() {

        $profile = $this->profile;
        if (!check_ACL($profile, 'che', 'menu')) {
            $this->load->helper('url');
            redirect('/');
        }

        // Layout library loaded site wide
        $this->set_layout();
        $this->layout->title('Checklist');

        $data = array();

        //Set data for layout
        $data['index'] = 'che';
        $data['html_module'] = 'che0100Module';
        $data['body_id'] = '';
        $data['body_module'] = 'CHE0100Ctrl';
        $data['body_ngInit'] = 'init()';
        $data['body_cssClass'] = '';
        $this->set_data_for_layout($data);
        
        $this->layout->view('checklist/index', $data);
    }

    public function initData() {
        $data['returnCd'] = NULL;
        $data['returnMsg'] = NULL;
        $data['resultSearch'] = NULL;
        $profile = $this->profile;

        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'che', 'menu')) {

        	$param = json_decode(trim(file_get_contents('php://input')), true);

            $this->load->model('checklist_model');

            $data['resultSearch'] = $this->checklist_model->searchChecklist($param);

        }

        $this->return_json($data);
    }

    public function searchData() {
        $data['returnCd'] = NULL;
        $data['returnMsg'] = NULL;
        $data['resultSearch'] = [];
        $profile = $this->profile;

         if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'che', 'menu')) {
            $param = json_decode(trim(file_get_contents('php://input')), true);  

            $this->load->model('checklist_model'); 
            $data['resultSearch'] = $this->checklist_model->searchChecklist($param);
        }
        $this->return_json($data);
    }

    public function checklistCreate() {
    	

    	$profile = $this->profile;
    	if (!check_ACL($profile, 'che', 'menu')) {
    		$this->load->helper('url');
    		redirect('/');
    	}
    	
    	// Layout library loaded site wide
        $this->set_layout();
        $this->layout->title('Create Checklist');

        $data = array();

        //Set data for layout
        $data['index'] = 'che';
        $data['html_module'] = 'che0200Module';
        $data['body_id'] = '';
        $data['body_module'] = 'CHE0200Ctrl';
        $data['body_ngInit'] = 'init()';
        $data['body_cssClass'] = '';
        $data['CHE0200_LABEL_FORM'] = CHE0200_LABEL_FORM;
        $data['CHE0200_LABEL_FORM_ICON'] = "icon-plus";
        
        $this->set_data_for_layout($data);
        $this->layout->view('checklist/checklist_create', $data);
    }
    
    public function checklistEdit($id) {
    	 
    
    	$profile = $this->profile;
    	if (!check_ACL($profile, 'che', 'menu')) {
    		$this->load->helper('url');
    		redirect('/');
    	}
    	 
    	// Layout library loaded site wide
    	$this->set_layout();
    	$this->layout->title('Edit checklist');
    
    	$data = array();
    
    	//Set data for layout
    	$data['index'] = 'che';
    	$data['html_module'] = 'che0200Module';
    	$data['body_id'] = '';
    	$data['body_module'] = 'CHE0200Ctrl';
    	$data['body_ngInit'] = 'init()';
    	$data['body_cssClass'] = '';
    	$data['CHE0200_LABEL_FORM'] = CHE0200_LABEL_FORM_EDIT;
    	$data['CHE0200_LABEL_FORM_ICON'] = "icon-pencil";
    	
    	$this->load->model('checklist_model');
    	$val = $this->checklist_model->getChecklistByCode($id);
    	
    	$data["checklistId"] = $val["checklistId"];
    	$data["checklistName"] 		=  $val["checklistName"];
    	$data["startDay"] 			=  date("d-m-Y",strtotime($val["startDay"]));
    	$data["endDay"] 			=  date("d-m-Y",strtotime($val["endDay"]));
    	
    	$this->set_data_for_layout($data);
    	$this->layout->view('checklist/checklist_create', $data);
    }
    
    public function regisChecklist() {
    	$data['returnCd'] = NULL;
    	$data['returnMsg'] = NULL;
    	$data['checklistTemplateId'] = [];
    	$profile = $this->profile;
    
    	if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'che', 'menu')) {
    		$param = json_decode(trim(file_get_contents('php://input')), true);
    		$this->load->model('checklist_model');
    		$data['checklistId'] = $this->checklist_model->insertChecklist($param);
    	}
    	$this->return_json($data);
    }
    
    public function deleteChecklist() {
    	$data['returnCd'] = NULL;
    	$data['returnMsg'] = NULL;
    	$data['proResult'] = [];
    	$profile = $this->profile;
    	if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'che', 'menu')) {
    		$params = json_decode(trim(file_get_contents('php://input')), true);
    		$this->load->model('checklist_model');
    		$del = $this->checklist_model->deleteChecklist($params);
    		if ($del == "OK"){
    			$data['proResult'] =   array("proFlg"=>$del,"message"=>I0000003);
    		}else{
    			$data['proResult'] =   array("proFlg"=>"NG","message"=>$del);
    		}
    	}
    	$this->return_json($data);
    }   
    
    public function searchUserNotAssign() {
    	$data['returnCd'] = NULL;
    	$data['returnMsg'] = NULL;
    	$data['resultUserNotAssign'] = NULL;
    	$profile = $this->profile;

    	if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'sale', 'menu')) {
    		$param = json_decode(trim(file_get_contents('php://input')), true);
    		$this->load->model('checklist_model');
    		$data['resultUserNotAssign'] = $this->checklist_model->searchSalesmanNotAssign($param);
    	}
    	$this->return_json($data);
    }
    
    public function assignUserChecklist() {
    	$data['returnCd'] = NULL;
    	$data['returnMsg'] = NULL;
    	$data['proResult'] = [];
    	$profile = $this->profile;
    	if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'che', 'menu')) {
    		$params = json_decode(trim(file_get_contents('php://input')), true);
    		$this->load->model('checklist_model');
    		$assign = $this->checklist_model->assignUserChecklist($params);
    		if ($assign == "OK"){
    			$data['proResult'] =   array("proFlg"=>$assign,"message"=>I0000001);
    		}else{
    			$data['proResult'] =   array("proFlg"=>"NG","message"=>$assign);
    		}
    	}
    	
    	$this->return_json($data);
    }
    
    public function assignRMUserChecklist() {
        $data['returnCd'] = NULL;
        $data['returnMsg'] = NULL;
        $data['proResult'] = [];
        $profile = $this->profile;
        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'che', 'menu')) {
            $params = json_decode(trim(file_get_contents('php://input')), true);
            $this->load->model('checklist_model');
            $assign = $this->checklist_model->assignRMUserChecklist($params);
            if ($assign == "OK"){
                $data['proResult'] =   array("proFlg"=>$assign,"message"=>I0000001);
            }else{
                $data['proResult'] =   array("proFlg"=>"NG","message"=>$assign);
            }
        }

        $this->return_json($data);
    }
    
	public function checklistView($id) {
    	$profile = $this->profile;
    	if (!check_ACL($profile, 'che', 'menu')) {
    		$this->load->helper('url');
    		redirect('/');
    	}
    	 
    	// Layout library loaded site wide
    	$this->set_layout();
    	$this->layout->title('View checklist online');
    
    	$data = array();
    
    	//Set data for layout
    	$data['index'] = 'che';
    	$data['html_module'] = 'che0400Module';
    	$data['body_id'] = '';
    	$data['body_module'] = 'CHE0400Ctrl';
    	$data['body_ngInit'] = 'init()';
    	$data['body_cssClass'] = '';
    	$data['CHE0200_LABEL_FORM'] = CHE0200_LABEL_FORM_VIEW;
    	
    	$this->load->model('checklist_model');
    	$val = $this->checklist_model->getChecklistByCode($id);
    	
    	$data["checklistId"]        = $val["checklistId"];
    	$data["checklistName"] 		=  $val["checklistName"];
    	$data["startDay"] 			=  date("d-m-Y",strtotime($val["startDay"]));
    	$data["endDay"] 			=  date("d-m-Y",strtotime($val["endDay"]));
    	
    	$this->set_data_for_layout($data);
    	$this->layout->view('checklist/checklist_view', $data);
    } 
    
    public function checklistViewInitData() {
        $data['returnCd'] = NULL;
        $data['returnMsg'] = NULL;
        $data['resultSearch'] = NULL;
        $data['listSelectChecklist'] = NULL;
        $profile = $this->profile;

        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'che', 'menu')) {

            $param = json_decode(trim(file_get_contents('php://input')), true);
            $checklistId = $param["checklistId"];
            if ($checklistId) {
                $this->load->model('event_model');

                $data['resultSearch'] = $this->event_model->searchChecklist($param, $checklistId);
                $data['listSelectChecklist'] = $this->event_model->getChecklistIsAttendanced($param, $checklistId);
                
            }
        }

        $this->return_json($data);
    }
    
    public function searchUserAssign() {
    	$data['returnCd'] = NULL;
    	$data['returnMsg'] = NULL;
    	$data['resultUserAssign'] = NULL;
    	$profile = $this->profile;
    
    	if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'sale', 'menu')) {
    
    		$param = json_decode(trim(file_get_contents('php://input')), true);
    		$this->load->model('checklist_model');
    		$data['resultUserAssign'] = $this->checklist_model->searchUserAssign($param);
    	}
    	$this->return_json($data);
    }
    
    public function searchUserMark() {
    	$data['returnCd'] = NULL;
    	$data['returnMsg'] = NULL;
    	$data['resultUserMark'] = NULL;
    	$profile = $this->profile;
    
    	if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'sale', 'menu')) {
    
    		$param = json_decode(trim(file_get_contents('php://input')), true);
    		$this->load->model('checklist_model');
    		$data['resultUserMark'] = $this->checklist_model->searchUserMark($param);
    	}
    	$this->return_json($data);
    }
    
    public function viewAnswerData() {
    	$data['returnCd'] = NULL;
    	$data['returnMsg'] = NULL;
    	$data['initData'] = NULL;
    	$profile = $this->profile;
    
    	if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'sale', 'menu')) {
    
    		$param = json_decode(trim(file_get_contents('php://input')), true);
    		$this->load->model('checklist_model');
    		$data['initData'] = $this->checklist_model->viewAnswerData($param);
    	}
    	$this->return_json($data);
    }  

    public function removeUserFromChecklist() {
    	$data['returnCd'] = NULL;
    	$data['returnMsg'] = NULL;
    	$data['proResult'] = [];
    	$profile = $this->profile;
    	if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'che', 'menu')) {
    		$params = json_decode(trim(file_get_contents('php://input')), true);
    		$this->load->model('checklist_model');
    		$del = $this->checklist_model->removeUserFromChecklist($params);
    		if ($del == "OK"){
    			$data['proResult'] =   array("proFlg"=>$del,"message"=>I0000003);
    		}else{
    			$data['proResult'] =   array("proFlg"=>"NG","message"=>$del);
    		}
    	}
    	$this->return_json($data);
    }
    
    public function removeRMUserFromChecklist() {
        $data['returnCd'] = NULL;
        $data['returnMsg'] = NULL;
        $data['proResult'] = [];
        $profile = $this->profile;
        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'che', 'menu')) {
            $params = json_decode(trim(file_get_contents('php://input')), true);
            $this->load->model('checklist_model');
            $del = $this->checklist_model->removeRMUserFromChecklist($params);
            if ($del == "OK"){
                $data['proResult'] =   array("proFlg"=>$del,"message"=>I0000003);
            }else{
                $data['proResult'] =   array("proFlg"=>"NG","message"=>$del);
            }
        }
        $this->return_json($data);
    }

    public function regisAttendance() {
    	$data['returnCd'] = NULL;
    	$data['returnMsg'] = NULL;
    	$data['proResult'] = [];
    	$profile = $this->profile;
    	if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'che', 'menu')) {
    		$params = json_decode(trim(file_get_contents('php://input')), true);
    		$this->load->model('event_model');
    		$add = $this->event_model->regisAttendance($params);
    		if ($add == "OK"){
    			$data['proResult'] =   array("proFlg"=>"OK","message"=>I0000003);
    		}else{
    			$data['proResult'] =   array("proFlg"=>"NG","message"=>$add);
    		}
    	}
    	$this->return_json($data);
    }
    
    public function searchRMUserNotAssign() {
        $data['returnCd'] = NULL;
        $data['returnMsg'] = NULL;
        $data['resultUserNotAssign'] = NULL;
        $profile = $this->profile;

        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'che', 'menu')) {
            $param = json_decode(trim(file_get_contents('php://input')), true);
            $this->load->model('checklist_model');
            $data['resultUserNotAssign'] = $this->checklist_model->searchRMNotAssign($param);
        }
        $this->return_json($data);
    }

    public function searchRMUserAssign() {
        $data['returnCd'] = NULL;
        $data['returnMsg'] = NULL;
        $data['resultUserNotAssign'] = NULL;
        $profile = $this->profile;

        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'che', 'menu')) {
            $param = json_decode(trim(file_get_contents('php://input')), true);
            $this->load->model('checklist_model');
            $data['resultUserAssign'] = $this->checklist_model->searchRMUserAssign($param);
        }
        $this->return_json($data);
    }
    
}
