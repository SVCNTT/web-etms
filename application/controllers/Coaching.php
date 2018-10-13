<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coaching extends MY_Controller
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

        $profile = $this->profile;
        if (!check_ACL($profile, 'coa', 'menu')) {
            $this->load->helper('url');
            redirect('/');
        }

        // Layout library loaded site wide
        $this->set_layout();
        $this->layout->title('Coaching Online | Strikeforce');

        $data = array();

        //Set data for layout
        $data['index'] = 'coa';
        $data['html_module'] = 'coa0100Module';
        $data['body_id'] = '';
        $data['body_module'] = 'COA0100Ctrl';
        $data['body_ngInit'] = 'init()';
        $data['body_cssClass'] = '';
        $this->set_data_for_layout($data);
        
        $this->layout->view('coachingonline/index', $data);
    }

    public function initData()
    {
        $data['returnCd'] = NULL;
        $data['returnMsg'] = NULL;
        $data['resultSearch'] = NULL;
        $profile = $this->profile;

        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'coa', 'menu')) {
        	$param = json_decode(trim(file_get_contents('php://input')), true);
            $param['profile'] = $profile;
            $this->load->model('coaching_model'); 
            $data['resultSearch'] = $this->coaching_model->searchCoaching($param); 
        }

        $this->return_json($data); 
    }

    public function searchData()
    {
        $data['returnCd'] = NULL;
        $data['returnMsg'] = NULL;
        $data['resultSearch'] = [];
        $profile = $this->profile;

         if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'coa', 'menu')) {
            $param = json_decode(trim(file_get_contents('php://input')), true);  
            $param['profile'] = $profile;
            $this->load->model('coaching_model'); 
            $data['resultSearch'] = $this->coaching_model->searchCoaching($param); 
        }
        $this->return_json($data);
    }

    public function coachingCreate()
    {
    	

    	$profile = $this->profile;
    	if (!check_ACL($profile, 'coa', 'menu')) {
    		$this->load->helper('url');
    		redirect('/');
    	}
    	
    	// Layout library loaded site wide
        $this->set_layout();
        $this->layout->title('Create coaching online | Strikeforce');

        $data = array();

        //Set data for layout
        $data['index'] = 'coa';
        $data['html_module'] = 'coa0200Module';
        $data['body_id'] = '';
        $data['body_module'] = 'COA0200Ctrl';
        $data['body_ngInit'] = 'init()';
        $data['body_cssClass'] = '';
        $data['COA0200_LABEL_FORM'] = COA0200_LABEL_FORM;
        $data['COA0200_LABEL_FORM_ICON'] = "icon-plus";
        $data["isEdit"] 			=  0;
        $this->set_data_for_layout($data);
        $this->layout->view('coachingonline/coaching_create', $data);
    }
    
    public function coachingEdit($id)
    {
    	 
    
    	$profile = $this->profile;
    	if (!check_ACL($profile, 'coa', 'menu')) {
    		$this->load->helper('url');
    		redirect('/');
    	}
    	 
    	// Layout library loaded site wide
    	$this->set_layout();
    	$this->layout->title('Edit coaching online | Strikeforce');
    
    	$data = array();
    
    	//Set data for layout
    	$data['index'] = 'coa';
    	$data['html_module'] = 'coa0200Module';
    	$data['body_id'] = '';
    	$data['body_module'] = 'COA0200Ctrl';
    	$data['body_ngInit'] = 'init()';
    	$data['body_cssClass'] = '';
    	$data['COA0200_LABEL_FORM'] = COA0200_LABEL_FORM_EDIT;
    	$data['COA0200_LABEL_FORM_ICON'] = "icon-pencil";
    	
//     	
    	$this->load->model('coaching_model');
    	$val = $this->coaching_model->getTemplateByCode($id);
    	
    	$data["coachingTemplateId"] = $val["coachingTemplateId"];
    	$data["coachingName"] 		=  $val["coachingName"];
    	$data["startDay"] 			=  date("d-m-Y",strtotime($val["startDay"]));
    	$data["endDay"] 			=  date("d-m-Y",strtotime($val["endDay"]));
    	$data["isEdit"] 			=  1;
    	
    	$this->set_data_for_layout($data);
    	$this->layout->view('coachingonline/coaching_create', $data);
    }
    
    public function regisCoaching()
    {
    	$data['returnCd'] = NULL;
    	$data['returnMsg'] = NULL;
    	$data['coachingTemplateId'] = [];
    	$profile = $this->profile;
    
    	if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'coa', 'menu')) {
    		$param = json_decode(trim(file_get_contents('php://input')), true);
    		$this->load->model('coaching_model');
    		$data['coachingTemplateId'] = $this->coaching_model->insertCoachingTemplate($param);
    	}
    	$this->return_json($data);
    }

    public function coachingSection()
    {
        $data['returnCd'] = NULL;
        $data['returnMsg'] = NULL;
    	$data['resultSearch'] = [];
    	$data["listSelectUser"] = [];
    	$profile = $this->profile;
    
    	if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'coa', 'menu')) {
    		$param = json_decode(trim(file_get_contents('php://input')), true);
    		$this->load->model('coaching_model');
    		$data['resultSearch'] = $this->coaching_model->coachingSection($param);
    		
    	}
    	$this->return_json($data);
    }

    public function add_question()
    {
    	$profile = $this->profile;
    	if (!check_ACL($profile, 'coa', 'menu')) {
    		$this->load->helper('url');
    		redirect('/');
    	}
    	$this->load->view('coachingonline/question_add');
    }

    public function initDataQuestion()
    {
    	$data['returnCd'] = NULL;
    	$data['returnMsg'] = NULL;
    	$data['initData'] = [];
        $profile = $this->profile;

    	if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'coa', 'menu')) {
    		$param = json_decode(trim(file_get_contents('php://input')), true);
    		$this->load->model('coaching_model');
    		$section = $this->coaching_model->coachingSectionById($param);
    		if (count($section["optionValues"]) <= 0){
    			$section["questionType"] = "checkboxes";
    			$section["needToCalculate"] = "1";
    			 
    		}
            $data['initData'] = array(
                "typeList" => array(
                    array(
                        "codeCd"        => "checkboxes",
                        "displayText"   => "Checkboxes"
                    )
                ),
                "inforSection" => $section
            );
        }

        $this->return_json($data);
    }

    public function saveQuestion()
    {
    	$data['returnCd'] = NULL;
    	$data['returnMsg'] = NULL;
    	$data['proResult'] = [];
    	$profile = $this->profile;
    
    	if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'coa', 'menu')) {
    		$param = json_decode(trim(file_get_contents('php://input')), true);
    		$this->load->model('coaching_model');
    		$insert_store = $this->coaching_model->insertSection($param);
    		if ($insert_store == "OK"){
    			$data['proResult'] =   array("proFlg"=>$insert_store,"message"=>I0000001);
    		}else{
    			$data['proResult'] =   array("proFlg"=>"NG","message"=>$insert_store);
    		}
    		
    	}
    	$this->return_json($data);
    }

    public function deleteSection()
    {
    	$data['returnCd'] = NULL;
    	$data['returnMsg'] = NULL;
    	$data['proResult'] = [];
    	$profile = $this->profile;
    	if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'coa', 'menu')) {
    		$params = json_decode(trim(file_get_contents('php://input')), true);
    		$this->load->model('coaching_model');
    		$del = $this->coaching_model->deleteSection($params);
    		if ($del == "OK"){
    			$data['proResult'] =   array("proFlg"=>$del,"message"=>I0000003);
    		}else{
    			$data['proResult'] =   array("proFlg"=>"NG","message"=>$del);
    		}
    	}
    	$this->return_json($data);
    }

    public function deleteCoaching()
    {
    	$data['returnCd'] = NULL;
    	$data['returnMsg'] = NULL;
    	$data['proResult'] = [];
    	$profile = $this->profile;
    	if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'coa', 'menu')) {
    		$params = json_decode(trim(file_get_contents('php://input')), true);
    		$this->load->model('coaching_model');
    		$del = $this->coaching_model->deleteCoaching($params);
    		if ($del == "OK"){
    			$data['proResult'] =   array("proFlg"=>$del,"message"=>I0000003);
    		}else{
    			$data['proResult'] =   array("proFlg"=>"NG","message"=>$del);
    		}
    	}
    	$this->return_json($data);
    }   
    
    public function searchUserNotAssign()
    {
    	$data['returnCd'] = NULL;
    	$data['returnMsg'] = NULL;
    	$data['resultUserNotAssign'] = NULL;
    	$profile = $this->profile;
    
    	if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'sale', 'menu')) {
    
    		$param = json_decode(trim(file_get_contents('php://input')), true);
    		$this->load->model('coaching_model');
    		$data['resultUserNotAssign'] = $this->coaching_model->searchUserNotAssign($param);
    	}
    	$this->return_json($data);
    }
       
    public function assignUserCoaching()
    {
    	$data['returnCd'] = NULL;
    	$data['returnMsg'] = NULL;
    	$data['proResult'] = [];
    	$profile = $this->profile;
    	if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'coa', 'menu')) {
    		$params = json_decode(trim(file_get_contents('php://input')), true);
    		$this->load->model('coaching_model');
    		$assign = $this->coaching_model->assignUserCoaching($params);
    		if ($assign == "OK"){
    			$data['proResult'] =   array("proFlg"=>$assign,"message"=>I0000001);
    		}else{
    			$data['proResult'] =   array("proFlg"=>"NG","message"=>$assign);
    		}
    	}
    	
    	$this->return_json($data);
    }
    
    public function coachingView($id)
    {
    	 
    
    	$profile = $this->profile;
    	if (!check_ACL($profile, 'coa', 'menu')) {
    		$this->load->helper('url');
    		redirect('/');
    	}
    	 
    	// Layout library loaded site wide
    	$this->set_layout();
    	$this->layout->title('View coaching online | Strikeforce');
    
    	$data = array();
    
    	//Set data for layout
    	$data['index'] = 'coa';
    	$data['html_module'] = 'coa0400Module';
    	$data['body_id'] = '';
    	$data['body_module'] = 'COA0400Ctrl';
    	$data['body_ngInit'] = 'init()';
    	$data['body_cssClass'] = '';
    	$data['COA0200_LABEL_FORM'] = COA0200_LABEL_FORM_VIEW;
        $data['COA0200_LABEL_FORM_ICON'] = "icon-pencil";
    	
//     	
    	$this->load->model('coaching_model');
    	$val = $this->coaching_model->getTemplateByCode($id);
    	
    	$data["coachingTemplateId"] = $val["coachingTemplateId"];
    	$data["coachingName"] 		=  $val["coachingName"];
    	$data["startDay"] 			=  date("d-m-Y",strtotime($val["startDay"]));
    	$data["endDay"] 			=  date("d-m-Y",strtotime($val["endDay"]));
    	
    	$this->set_data_for_layout($data);
    	$this->layout->view('coachingonline/coaching_view', $data);
    } 
    
    public function searchUserAssign()
    {
    	$data['returnCd'] = NULL;
    	$data['returnMsg'] = NULL;
    	$data['resultUserAssign'] = NULL;
    	$profile = $this->profile;
    
    	if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'sale', 'menu')) {
    
    		$param = json_decode(trim(file_get_contents('php://input')), true);
            $param['profile'] = $profile;
    		$this->load->model('coaching_model');
    		$data['resultUserAssign'] = $this->coaching_model->searchUserAssign($param);
    	}
    	$this->return_json($data);
    }
    
    public function searchUserMark()
    {
    	$data['returnCd'] = NULL;
    	$data['returnMsg'] = NULL;
    	$data['resultUserMark'] = NULL;
    	$profile = $this->profile;
    
    	if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'sale', 'menu')) {
    
    		$param = json_decode(trim(file_get_contents('php://input')), true);
    		$this->load->model('coaching_model');
    		$data['resultUserMark'] = $this->coaching_model->searchUserMark($param);
    	}
    	$this->return_json($data);
    }
    
    public function viewAnswerData()
    {
    	$data['returnCd'] = NULL;
    	$data['returnMsg'] = NULL;
    	$data['initData'] = NULL;
    	$profile = $this->profile;
    
    	if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'sale', 'menu')) {
    
    		$param = json_decode(trim(file_get_contents('php://input')), true);
    		$this->load->model('coaching_model');
    		$data['initData'] = $this->coaching_model->viewAnswerData($param);
    	}
    	$this->return_json($data);
    }    
    
    public function removeUserFromCoaching()
    {
    	$data['returnCd'] = NULL;
    	$data['returnMsg'] = NULL;
    	$data['proResult'] = [];
    	$profile = $this->profile;
    	if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'coa', 'menu')) {
    		$params = json_decode(trim(file_get_contents('php://input')), true);
    		$this->load->model('coaching_model');
    		$del = $this->coaching_model->removeUserFromCoaching($params);
    		if ($del == "OK"){
    			$data['proResult'] =   array("proFlg"=>$del,"message"=>I0000003);
    		}else{
    			$data['proResult'] =   array("proFlg"=>"NG","message"=>$del);
    		}
    	}
    	$this->return_json($data);
    }
    
}
