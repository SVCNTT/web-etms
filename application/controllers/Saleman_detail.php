<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Saleman_detail extends MY_Controller {

    public function __construct() {
        parent::__construct();

        /*Authentication - Begin*/
        $this->check_auth = $this->check_login();
        /*Authentication - End*/
    }

    public function index($id) {
        // Layout library loaded site wide 
        $profile = $this->profile;
        if (!check_ACL($profile, 'sale', 'menu')) {
            $this->load->helper('url');
            redirect('/');
        }

        $this->load->model('saleman_model');
        /*Check permission - Begin*/
        $mr_list = $this->saleman_model->selectMRByRole($profile);
        $flag = FALSE;
        if (!empty($mr_list)) {
            foreach ($mr_list as $temp) {
                if ($temp['salesman_code'] == $id) {
                    $flag = TRUE;
                    break;
                }
            }
        }

        if (!$flag) {
            $this->load->helper('url');
            redirect('/');
        }
        /*Check permission - End*/

        $this->set_layout();
        $this->layout->title(SAL0300_TITLE." | Strikeforce");

        $data = array();

        //Set data for layout
        $data['index'] = 'sale';
        $data['html_module'] = 'sal0300Module';
        $data['body_id'] = '';
        $data['body_module'] = 'SAL0300Ctrl';
        $data['body_ngInit'] = 'init()'; 

        $this->set_data_for_layout($data);
        $dataInfor = $this->saleman_model->selectSalemainById($id,$data);

        $this->layout->view('saleman/saleman_details', $dataInfor);         
    }
    public function change_pass(){ 
         $this->load->view('saleman/saleman_change_pass'); 
    }
    public function update(){ 
         $this->load->view('saleman/saleman_update'); 
    }
    public function datepicker(){
         $this->load->view('common/datepicker'); 
    }

    
    public function initData() {
            $data['returnCd'] = NULL;
            $data['returnMsg'] = NULL;
            $data['initData'] = NULL;
            $data['resultSearch'] = NULL;

            $profile = $this->profile;
        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'sale', 'menu')) {        
            $param = json_decode(trim(file_get_contents('php://input')), true);


            $this->load->model('saleman_model');  
            $this->load->model('area_model');
            $items = $this->area_model->selectArea();
            
            $data['resultSearch'] = $this->saleman_model->searchStoreAssigned(array("searchInput"=>$param));
            $data['initData'] =  array("areaDropdown"=>array("selectedAreaId"=>-1,"items"=>$items));
        }
        $this->return_json($data);
    }
    public function resetPin() {
            $data['returnCd'] = NULL;
            $data['returnMsg'] = NULL;
            $data['proResult'] = NULL;
            $profile = $this->profile;

        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'sale', 'resetpass')) {
            $param = json_decode(trim(file_get_contents('php://input')), true);   
            $this->load->model('saleman_model'); 
            $param["pinCode"] = $this->create_md5($param["pinCode"]);
            $update = $this->saleman_model->update_password($param);
            if ($update == "OK"){
                $data['proResult'] =   array("proFlg"=>$update,"message"=>I0000004);
            }else{
                $data['proResult'] =   array("proFlg"=>"NG","message"=>$update);
            }        
        }
        $this->return_json($data);
    } 

    public function updateSalesman() {
            $data['returnCd'] = NULL;
            $data['returnMsg'] = NULL;
            $data['proResult'] = NULL;
            $profile = $this->profile;

        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'sale', 'edit')) {

            $param = json_decode(trim(file_get_contents('php://input')), true);  
            $this->load->model('saleman_model');
            $data['returnCd'] = NULL;
            $data['returnMsg'] = NULL;
            
            $update = $this->saleman_model->update_salesman($param);
            if ($update == "OK"){
                $data['proResult'] =   array("proFlg"=>$update,"message"=>I0000004);
            }else{
                $data['proResult'] =   array("proFlg"=>"NG","message"=>$update);
            }
       }
        $this->return_json($data);
    }

    public function searchStoreAssigned() { 
            $data['returnCd'] = NULL;
            $data['returnMsg'] = NULL;
            $data['resultStoreAssigned'] = NULL;
            $data['resultStoreNotAssign'] = NULL;
            $profile = $this->profile;

        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'sale', 'menu')) {

            $param = json_decode(trim(file_get_contents('php://input')), true); 
            $this->load->model('saleman_model');  
            $data['resultStoreAssigned'] = $this->saleman_model->searchStoreAssigned($param);
            $data['resultStoreNotAssign'] =  NULL;
        }
        $this->return_json($data);
    } 

    public function searchStoreNotAssign() { 
            $data['returnCd'] = NULL;
            $data['returnMsg'] = NULL;
            $data['resultStoreAssigned'] = NULL;
            $data['resultStoreNotAssign'] = NULL;
            $profile = $this->profile;

        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'sale', 'add_customer')) {
            $param = json_decode(trim(file_get_contents('php://input')), true); 
            $this->load->model('saleman_model');  
            $data['resultStoreAssigned'] = NULL;
            $data['resultStoreNotAssign'] =  $this->saleman_model->searchStoreNotAssign($param);
        }
        $this->return_json($data);
    }    

    public function  addStore(){
            $data['returnCd'] = NULL;
            $data['returnMsg'] = NULL;
            $data['proResult'] = NULL;
            $profile = $this->profile;

        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'sale', 'add_customer')) {

            $param = json_decode(trim(file_get_contents('php://input')), true);
            $this->load->model('saleman_model');
            $insert_store = $this->saleman_model->addStore($param);
            if ($insert_store == "OK"){
                $data['proResult'] =   array("proFlg"=>$insert_store,"message"=>I0000001);
            }else{
                $data['proResult'] =   array("proFlg"=>"NG","message"=>$insert_store);
            }        
        }
        $this->return_json($data); 
    }

    public function delete_saleman_store() {
            $data['returnCd'] = NULL;
            $data['returnMsg'] = NULL;
            $data['proResult'] = NULL;
            $profile = $this->profile; 
        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'sale', 'add_customer')) {
            $param = json_decode(trim(file_get_contents('php://input')), true);  
            $this->load->model('saleman_model');
            $data['returnCd'] = NULL;
            $data['returnMsg'] = NULL;
            $del = $this->saleman_model->delete_saleman_store($param);
            if ($del == "OK"){
                $data['proResult'] =   array("proFlg"=>$del,"message"=>I0000003);
            }else{
                $data['proResult'] =   array("proFlg"=>"NG","message"=>$del);
            }
        }
        $this->return_json($data);
    }

    public function activatSalman() {
            $data['returnCd'] = NULL;
            $data['returnMsg'] = NULL;
            $data['proResult'] = NULL;
            $profile = $this->profile; 
        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'sale', 'active')) {
            $param = json_decode(trim(file_get_contents('php://input')), true);  
            $this->load->model('saleman_model');
            $active = $this->saleman_model->activatSalesman($param);
            if ($active == "OK"){
                $data['proResult'] =   array("proFlg"=>$active,"message"=>I0000006);
            }else{
                $data['proResult'] =   array("proFlg"=>"NG","message"=>$active);
            }
        }
        $this->return_json($data);
    }

    public function  list_store(){
            $profile = $this->profile; 
        $data['profile'] = $profile;
        if (check_ACL($profile, 'sale', 'menu')) {
            $this->load->view('saleman/list_store', $data);
        }
    }

    public function form_vacation(){ 
        $profile = $this->profile; 
        $data['profile'] = $profile;
        if (check_ACL($profile, 'sale', 'vacation')) {
         $this->load->view('saleman/saleman_vacation', $data);
        }
    }

    public function search_vacation(){ 
            $data['returnCd'] = NULL;
            $data['returnMsg'] = NULL;
            $data['resultSearch'] = NULL;
            $profile = $this->profile; 
        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'sale', 'vacation')) {
            $param = json_decode(trim(file_get_contents('php://input')), true); 
                $this->load->model('saleman_model');  
                $data['resultSearch'] =  $this->saleman_model->search_vacation($param);
        }
        $this->return_json($data); 
    }

    
   
}
