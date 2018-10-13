<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Saleman extends MY_Controller {

    public function __construct() {
        parent::__construct();

        /*Authentication - Begin*/
        $this->check_auth = $this->check_login();
        /*Authentication - End*/
    }

    public function index() {

        $profile = $this->profile;
        if (!check_ACL($profile, 'sale', 'menu')) {
            $this->load->helper('url');
            redirect('/');
        }

        // Layout library loaded site wide
        $this->set_layout();
        $this->layout->title('Saleman | Strikeforce');

        $data = array();

        //Set data for layout
        $data['index'] = 'sale';
        $data['html_module'] = 'sal0100Module';
        $data['body_id'] = '';
        $data['body_module'] = 'SAL0100Ctrl';
        $data['body_ngInit'] = 'init()';
        $data['body_cssClass'] = 'DAS0100';
        $this->set_data_for_layout($data);
        
        $this->layout->view('saleman/index', $data);
    }

    public function initData() { 
        $data['returnCd'] = NULL;
        $data['returnMsg'] = NULL;
        $data['clientInfo'] = NULL;
        $data['resultSearch'] = NULL;
        $data['usrStsLst'] = NULL; 
        $data['initData'] = NULL;
        $profile = $this->profile;

        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'sale', 'menu')) {
            $this->load->model('saleman_model');  
            $this->load->model('client_model'); 
            $param = array(
                'curr_user'  =>  $profile
            );
            $data['resultSearch'] = $this->saleman_model->selectSalesmanClient($param); 

            $clientInfo["clientInfo"] = $this->client_model->getAllClient(); 
            $clientInfo["usrStsLst"]  =  $this->saleman_model->buildFilterSearch();
            $clientInfo["areaInfo"] = NULL;
            $data['initData'] =   $clientInfo;
        }

        $this->return_json($data); 
    }

    public function searchData() {
        $data['returnCd'] = NULL;
        $data['returnMsg'] = NULL;
        $data['resultSearch'] = [];
        $profile = $this->profile;

         if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'sale', 'menu')) {
            $param = json_decode(trim(file_get_contents('php://input')), true);  
            $this->load->model('saleman_model');  
             $param['curr_user'] = $profile;
            $data['resultSearch'] = $this->saleman_model->selectSalesmanClient($param);
        }
        $this->return_json($data);
    }

    public function deleteSalman() {
        $data['returnCd'] = NULL;
        $data['returnMsg'] = NULL;
        $profile = $this->profile;

         if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'sale', 'delete')) {
            $salesmanId = json_decode(trim(file_get_contents('php://input')), true);  
            $data['returnCd'] = '';
            $data['returnMsg'] = 'OK';
            $this->load->model('saleman_model');  
            $this->saleman_model->deleteSalman($salesmanId["salesmanId"]); 
            $data['proResult'] =   array("proFlg"=>"OK","message"=>I0000003);
        }
        $this->return_json($data);
    }


    public function form_import() {
    
        $profile = $this->profile;
        if (!check_ACL($profile, 'sale', 'import')) {
            $this->load->helper('url');
            redirect('/');
        }
       
        $this->load->view('saleman/saleman_import');
    }

 
    public  function start_import(){
        $data['returnCd'] = NULL;
        $data['returnMsg'] = NULL;
        $data['proResult'] = array(
            'proFlg'    =>  RES_NG,
            'message'   =>  ''
        );
        $profile = $this->profile;
        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'sale', 'import')) {
            if (isset($_FILES['file']['tmp_name'])){
                $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
                $this->load->library('FileManagement');
                $this->load->model('saleman_model');
                $filePath = $this->filemanagement->saveFileImport("salesman", $_FILES['file']['tmp_name'], $ext);

               $import = $this->saleman_model->salesman_import($filePath);

                if ($import == "OK"){

                    /*Clear cache - Begin*/
                    $curr_user_id = isset($profile['user_id']) ? $profile['user_id'] : -1;
                    $this->load->library('authentication');
                    
                    $key_1 = 'MR_by_role_' . date('YmdH') . '_' . $curr_user_id;
                    $this->authentication->unset_data($key_1, PLATFORM);

                    $key_2 = 'MR_by_product_type_' . date('YmdH') . '_' . $curr_user_id;
                    $this->authentication->unset_data($key_2, PLATFORM);
                    /*Clear cache - End*/

                    $data['proResult'] =   array("proFlg"=>$import,"message"=>I0000008);
                }else{
                    $data['proResult'] =   array("proFlg"=>RES_NG,"message"=>$import);
                }
            }
        }
        $this->return_json($data);
    } 
    
}
