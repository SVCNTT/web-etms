<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Client_detail extends MY_Controller {

    public function __construct() {
        parent::__construct();

        /*Authentication - Begin*/
        $this->check_auth = $this->check_login();
        /*Authentication - End*/
    }

    public function view($id) {

        $profile = $this->profile;
        if (!check_ACL($profile, 'dashboard', 'menu')) {
            $this->load->helper('url');
            redirect('/');
        }

        // Layout library loaded site wide

        $this->set_layout();
        $this->layout->title(CLI0100_TITLE.' | Strikeforce');

        $data = array();

        $this->load->model('client_model');
        $data["clientInfo"] = $this->client_model->getClientByCode($id);

        //Set data for layout
        $data['index'] = 'client';
        $data['html_module'] = 'cli0300Module';
        $data['body_id'] = '';
        $data['body_module'] = 'CLI0300Ctrl';
        $data['body_ngInit'] = 'init()';
        $this->set_data_for_layout($data);
        $this->layout->view('client/client_view', $data); 
    }

    public function details(){ 
        $profile = $this->profile;
        if (!check_ACL($profile, 'dashboard', 'menu')) {
            $this->load->helper('url');
            redirect('/');
        }        
         $this->load->view('client/client_detail'); 
    }

    public function initData() {
        $data['returnCd'] = NULL;
        $data['returnMsg'] = NULL;
        $data['initData'] = NULL;
        $data['resultSearch'] = []; 
        $profile = $this->profile;

        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'dashboard', 'menu')) {

            $param = json_decode(trim(file_get_contents('php://input')), true);

            $this->load->model('area_model');
            $this->load->model('store_model'); 
            $this->load->model('saleman_model'); 

            $dataFilter["areaDropdown"] = array("selectedAreaId"=>NULL,"items"=>$this->area_model->selectArea());
            $data['initData'] =  $dataFilter;
            $data['resultSearch'] =$this->saleman_model->searchStoreAssigned(array("searchInput"=>$param));
        }
        $this->return_json($data);
    }

    public function  addStore(){
            $data['returnCd'] = NULL;
            $data['returnMsg'] = NULL;
            $data['proResult'] = NULL;
            $profile = $this->profile;

        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'dashboard', 'menu')) {

            $params = json_decode(trim(file_get_contents('php://input')), true);
            $this->load->model('store_model');

            $insert_store = "";
            foreach ($params["storeIdList"] as $storeId){
                $insert_store = $this->store_model->regisClientStore(array("clientId"=>$params["clientId"]
                                                                            ,"storeId"=>$storeId));
            }
            if ($insert_store == "OK"){
                $data['proResult'] =   array("proFlg"=>$insert_store,"message"=>I0000001);
            }else{
                $data['proResult'] =   array("proFlg"=>"NG","message"=>$insert_store);
            }        
        }
        $this->return_json($data); 
    }

    public function deleteStore() {
            $data['returnCd'] = NULL;
            $data['returnMsg'] = NULL;
            $data['proResult'] = NULL;
            $profile = $this->profile; 
        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'dashboard', 'menu')) {
            $param = json_decode(trim(file_get_contents('php://input')), true);  
            $this->load->model('client_model');
            $del = $this->client_model->deleteStore($param);
            if ($del == "OK"){
                $data['proResult'] =   array("proFlg"=>$del,"message"=>I0000003);
            }else{
                $data['proResult'] =   array("proFlg"=>"NG","message"=>$del);
            }
        }
        $this->return_json($data);
    }


    public function form_edit(){

        $profile = $this->profile;
        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'dashboard', 'menu')) {
            $param = json_decode(trim($_POST['param']), true);
            
            $param["imagePath"] = "";
            if (isset($_FILES['file']['tmp_name'])){
                $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
                $this->load->library('FileManagement');

                $path = $this->filemanagement->saveImageWeb("client", $_FILES['file']['tmp_name'], $ext);
                $param["imagePath"] = $path;
            }           

            $data['returnCd'] = NULL;
            $data['returnMsg'] = NULL;
            $this->load->model('client_model');
            $data["proResult"] = $this->client_model->client_update($param);
            $this->return_json($data);
        }else{  
         $this->load->view('client/client_form_edit');  
        }
         
    }
    
    public function initEdit() {
        $data['returnCd'] = NULL;
        $data['returnMsg'] = NULL;
        $data['clientInfo'] = NULL;
        $data['clientType'] = []; 
        $profile = $this->profile;

        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'dashboard', 'menu')) {

            $param = json_decode(trim(file_get_contents('php://input')), true);
             $this->load->model('client_model');
            $data["clientInfo"] = array("clientInfo"=>$this->client_model->getClientByCode($param["clientCode"]));
        }
        $this->return_json($data);
    }    

    public function client_form_product_type(){ 
        $profile = $this->profile;
        if (!check_ACL($profile, 'client', 'menu')) {
            $this->load->helper('url');
            redirect('/');
        }        

        $data['profile'] = $profile;
        $this->load->view('client/client_form_product_type', $data);
    }

    public function selectProType() {
        $data['returnCd'] = NULL;
        $data['returnMsg'] = NULL;
        $data['proTypeList'] = [];
        $profile = $this->profile;

        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'dashboard', 'menu')) {
            $params = json_decode(trim(file_get_contents('php://input')), true);

            $flag_cache = isset($params['no_cache']) ? $params['no_cache'] : TRUE;

        $this->load->model('product_type_mst_model');
            $data["proTypeList"] = array("productTypeList"=>$this->product_type_mst_model->proTypeResultDto($params, $flag_cache));
        }
        $this->return_json($data);
    } 

    public function selectProGroup() {
        $data['returnCd'] = NULL;
        $data['returnMsg'] = NULL;
        $data['proGroupList'] = [];
        $profile = $this->profile;

        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'dashboard', 'menu')) {
            $params = json_decode(trim(file_get_contents('php://input')), true);
        $this->load->model('product_group_model');
        $data["proGroupList"] = array("productGroupList"=>$this->product_group_model->proGroupResultDto($params));
        }
        $this->return_json($data);
    }
    
    public function regisProductTye() {
            $data['returnCd'] = NULL;
            $data['returnMsg'] = NULL;
        $data['proResult'] = array(
            'proFlg'    =>  RES_NG,
            'message'   =>  ''
        );

            $profile = $this->profile; 
        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'dashboard', 'medicine_type_add')) {
            $param = json_decode(trim(file_get_contents('php://input')), true);  

            $this->load->model('product_type_mst_model');
            $insert = $this->product_type_mst_model->regisProductTye($param);
            if ($insert == "OK"){
                $data['proResult'] =   array("proFlg"=>$insert,"message"=>I0000001);
            }else{
                $data['proResult'] =   array("proFlg"=>RES_NG,"message"=>$insert);
            }
        }
        $this->return_json($data);
    }

    public function deleteProductTye() {
            $data['returnCd'] = NULL;
            $data['returnMsg'] = NULL;
        $data['proResult'] = array(
            'proFlg'    =>  RES_NG,
            'message'   =>  ''
        );

            $profile = $this->profile; 
        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'dashboard', 'medicine_type_del')) {
            $params = json_decode(trim(file_get_contents('php://input')), true);  
            $this->load->model('product_type_mst_model');
            $del = $this->product_type_mst_model->deleteProductTye($params);
            if ($del == "OK"){
                $data['proResult'] =   array("proFlg"=>$del,"message"=>I0000003);
            }else{
                $data['proResult'] =   array("proFlg"=>RES_NG,"message"=>$del);
            }
        }
        $this->return_json($data);
    }

    public function deleteProductGroup() {
        $data['returnCd'] = NULL;
        $data['returnMsg'] = NULL;
        $data['proResult'] = array(
            'proFlg'    =>  RES_NG,
            'message'   =>  ''
        );

        $profile = $this->profile;
        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'dashboard', 'medicine_type_del')) {
            $params = json_decode(trim(file_get_contents('php://input')), true);
            $this->load->model('product_group_model');
            $del = $this->product_group_model->deleteProductGroup($params);
            if ($del == "OK"){
                $data['proResult'] =   array("proFlg"=>$del,"message"=>I0000003);
            }else{
                $data['proResult'] =   array("proFlg"=>RES_NG,"message"=>$del);
            }
        }
        $this->return_json($data);
    }


    public function client_form_product_type_edit(){ 
        $profile = $this->profile;
        if (!check_ACL($profile, 'dashboard', 'medicine_type_edit')) {
            $this->load->helper('url');
            redirect('/');
        }        

        $data['profile'] = $profile;
        $this->load->view('client/client_form_product_type_edit', $data);
    }

    public function client_form_product_group_edit(){
        $profile = $this->profile;
        if (!check_ACL($profile, 'dashboard', 'medicine_type_edit')) {
            $this->load->helper('url');
            redirect('/');
        }

        $data['profile'] = $profile;
        $this->load->view('client/client_form_product_group_edit', $data);
    }

    public function updateProductTye() {
            $data['returnCd'] = NULL;
            $data['returnMsg'] = NULL;
        $data['proResult'] = array(
            'proFlg'    =>  RES_NG,
            'message'   =>  ''
        );

            $profile = $this->profile; 
        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'dashboard', 'medicine_type_edit')) {
            $params = json_decode(trim(file_get_contents('php://input')), true);  
            $this->load->model('product_type_mst_model');
            $del = $this->product_type_mst_model->updateProductTye($params);
            if ($del == "OK"){
                $data['proResult'] =   array("proFlg"=>$del,"message"=>I0000005);
            }else{
                $data['proResult'] =   array("proFlg"=>RES_NG,"message"=>$del);
            }
        }
        $this->return_json($data);
    }    

    public function client_form_photo(){
        $profile = $this->profile;
        if (!check_ACL($profile, 'client', 'menu')) {
            $this->load->helper('url');
            redirect('/');
        }        
        $this->load->view('client/client_form_photo'); 
    }

    public function initDataPhoto() {
        $data['returnCd'] = NULL;
        $data['returnMsg'] = NULL;
        $data['storeInfo'] = []; 
        $data['photoInfo'] = array("photoCal"=>[],"pagingInfo"=>NULL);

        $profile = $this->profile;
        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'client', 'menu')) {

            $param = json_decode(trim(file_get_contents('php://input')), true);
            $param['curr_user'] = $profile;

            $this->load->model('store_model'); 
            $this->load->model('photos_model'); 
            $data['storeInfo'] =$this->store_model->getAllStore();
            $data['photoInfo'] = $this->photos_model->getPhotoByClientAndStore($param);
        }
        $this->return_json($data);
    }

    public function regisProductGroup() {
        $data['returnCd'] = NULL;
        $data['returnMsg'] = NULL;
        $data['proResult'] = array(
            'proFlg'    =>  RES_NG,
            'message'   =>  ''
        );

        $profile = $this->profile;
        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'dashboard', 'medicine_type_add')) {
            $param = json_decode(trim(file_get_contents('php://input')), true);
            $this->load->model('product_group_model');
            $insert = $this->product_group_model->regisProductGroup($param);
            if ($insert == "OK"){
                $data['proResult'] =   array("proFlg"=>$insert,"message"=>I0000001);
            }else{
                $data['proResult'] =   array("proFlg"=>RES_NG,"message"=>$insert);
            }
        }
        $this->return_json($data);
    }
    public function updateProductGroup() {
        $data['returnCd'] = NULL;
        $data['returnMsg'] = NULL;
        $data['proResult'] = array(
            'proFlg'    =>  RES_NG,
            'message'   =>  ''
        );

        $profile = $this->profile;
        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'dashboard', 'medicine_type_edit')) {
            $params = json_decode(trim(file_get_contents('php://input')), true);
            $this->load->model('product_group_model');
            $del = $this->product_group_model->updateProductGroup($params);
            if ($del == "OK"){
                $data['proResult'] =   array("proFlg"=>$del,"message"=>I0000005);
            }else{
                $data['proResult'] =   array("proFlg"=>RES_NG,"message"=>$del);
            }
        }
        $this->return_json($data);
    }


}
