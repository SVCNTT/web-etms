<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Store extends MY_Controller
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
        if (!check_ACL($profile, 'store', 'menu')) {
            $this->load->helper('url');
            redirect('/');
        }

        // Layout library loaded site wide

        $this->set_layout();
        $this->layout->title(STO0100_TITLE.' | Strikeforce');

        $data = array();

        //Set data for layout
        $data['index'] = 'store';
        $data['html_module'] = 'sto0500Module';
        $data['body_id'] = '';
        $data['body_module'] = 'STO0500Ctrl';
        $data['body_ngInit'] = 'init()';
        $data['body_cssClass'] = 'STO0500';

        $this->set_data_for_layout($data);

        $this->layout->view('store/index', $data); 
    }

    public function store_list() {
        $data = array();
        $profile = $this->profile;
        $data['profile'] = $profile;

        if (!check_ACL($profile, 'store', 'list')) {
            return $this->load->view('errors/html/error_permission_denied', $data);
        }

        $this->load->view('store/list', $data);
    }

    public function init()
    {
        $data['returnCd'] = NULL;
        $data['returnMsg'] = NULL;
        $data['initData'] = NULL;
        $data['resultSearch'] = NULL; 
        
        $profile = $this->profile;

        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'store', 'menu')) {

            $param = json_decode(trim(file_get_contents('php://input')), true);
            

            $this->load->model('store_model');  
            $this->load->model('area_model');
            $this->load->model('client_model');

            $dataFilter["clientInfo"] = $this->client_model->getAllClient();

            $dataFilter["areaInfo"] = array("selectedAreaId"=>NULL,"items"=>$this->area_model->selectArea());
            $data['initData'] =  $dataFilter;
            $param['curr_user'] = $profile;
            $data['resultSearch'] = $this->store_model->searchData($param);
        }
        $this->return_json($data);
    }

    public function searchData()
    {
        $data['returnCd'] = NULL;
        $data['returnMsg'] = NULL;
        $data['initData'] = NULL;
        $data['resultSearch'] = NULL; 
        $profile = $this->profile;

        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'store', 'menu')) {
            $param = json_decode(trim(file_get_contents('php://input')), true); 
            $this->load->model('store_model');
            $param['curr_user'] = $profile;
            $data['resultSearch'] = $this->store_model->searchData($param);
        }
        $this->return_json($data);
    }

    public function deleteStore()
    {
        $data['returnCd'] = NULL;
        $data['returnMsg'] = NULL;
        $data['proResult'] = NULL; 
        $profile = $this->profile;

        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'store', 'delete')) {

            $param = json_decode(trim(file_get_contents('php://input')), true);  
            $this->load->model('store_model');
             
            $del = $this->store_model->deleteStore($param);
            if ($del == "OK"){
                $data['proResult'] =   array("proFlg"=>$del,"message"=>I0000003);
            }else{
                $data['proResult'] =   array("proFlg"=>RES_NG,"message"=>$del);
            }
        }
        $this->return_json($data);
    }

    public function form_create_store()
    {
        $profile = $this->profile;
        if (!check_ACL($profile, 'store', 'create')) {
            return $this->load->view('errors/html/error_permission_denied');
        }

        // Layout library loaded site wide

        $this->set_layout();
        $this->layout->title(STO0200_TITLE.' | Strikeforce');

        $data = array();

        //Set data for layout
        $data['index'] = 'store';
        $data['html_module'] = 'sto0200Module';
        $data['body_id'] = 'STO0100';
        $data['body_module'] = 'STO0200Ctrl';
        $data['body_ngInit'] = 'init()';
        $this->set_data_for_layout($data);

        $this->layout->view('store/store_create', $data); 
    }

    public function form_create_doctor()
    {
    	$profile = $this->profile;
    	if (!check_ACL($profile, 'store', 'create_doctor')) {
            return $this->load->view('errors/html/error_permission_denied');
    	}
    
    	// Layout library loaded site wide
    
    	$this->set_layout();
    	$this->layout->title(STO0200_TITLE_DOCTOR.' | Strikeforce');
    
    	$data = array();
    
    	//Set data for layout
    	$data['index'] = 'store';
    	$data['html_module'] = 'doc0200Module';
    	$data['body_id'] = 'DOC0100';
    	$data['body_module'] = 'DOC0200Ctrl';
    	$data['body_ngInit'] = 'init()';
    	$this->set_data_for_layout($data);
    
    	$this->layout->view('store/doctor_create', $data);
    }

    public function doctor_form_product_type(){ 
        $this->load->view('store/doctor_class_product_type', $data);
    }
        
    public function form_create_store_init()
    {
        $data['returnCd'] = NULL;
        $data['returnMsg'] = NULL;
        $data['initData'] = array(
            'clientInfo'    =>  array(),
            'areaInfo'      =>  array(),
            'zoneList'      =>  array(),
            'productTypeList'=> array()
        );
        $profile = $this->profile;

        if ($this->input->method(TRUE) === 'POST' && (check_ACL($profile, 'store', 'edit') || check_ACL($profile, 'store', 'create'))) {

            $param = json_decode(trim(file_get_contents('php://input')), true); 
 
            $this->load->model('area_model');
            $this->load->model('client_model');
            $this->load->model('zone_model');
            $this->load->model('product_type_mst_model');

            $dataFilter["clientInfo"] = $this->client_model->getAllClient();

            $dataFilter["areaInfo"] = array("selectedAreaId"=>NULL
            		,"items"=>$this->area_model->selectArea()
            );
            $dataFilter["zoneList"] =  $this->zone_model->zoneResultDto();
            $dataFilter["productTypeList"] =  $this->product_type_mst_model->proTypeResultDto($param);
            
            $data['initData'] =  $dataFilter;
        }
        $this->return_json($data);
    }    

    public function create_store()
    {
        $data['returnCd'] = NULL;
        $data['returnMsg'] = NULL;
        $data['proResult'] = NULL; 
        $profile = $this->profile;

        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'store', 'create_pharmacy')) {

            $param = json_decode(trim(file_get_contents('php://input')), true);  
            $this->load->model('store_model');
             
            $create = $this->store_model->create_store($param);
            if ($create == "OK"){

                /*Clear cache - Begin*/
                $curr_user_id = isset($profile['user_id']) ? $profile['user_id'] : -1;
                $key = 'store_by_role_'.date('YmdH').'_'.$curr_user_id;
                $this->load->library('authentication');
                $this->authentication->unset_data($key, PLATFORM);
                /*Clear cache - End*/

                $data['proResult'] =   array("proFlg"=>$create,"message"=>"Create success");
            }else{
                $data['proResult'] =   array("proFlg"=>RES_NG,"message"=>$create);
            }
        }
        $this->return_json($data);
    }

    public function form_update_store($id)
    {
        $profile = $this->profile;
        if (!check_ACL($profile, 'store', 'edit')) {
            return $this->load->view('errors/html/error_permission_denied');
        }

        // Layout library loaded site wide

        $this->set_layout();
        $this->layout->title(STO0210_TITLE.' | Strikeforce');

        $data = array();

        //Set data for layout
        $data['index'] = 'store';
        $data['html_module'] = 'sto0210Module';
        $data['body_id'] = '';
        $data['body_module'] = 'STO0210Ctrl';
        $data['body_ngInit'] = 'init()';
        $this->set_data_for_layout($data);

        $this->load->model('store_model');
        $data['storeId'] = $this->store_model->get_store_by_code($id);

        $this->layout->view('store/store_update', $data); 
    }

    public function form_update_doctor($id)
    {
    	$profile = $this->profile;
    	if (!check_ACL($profile, 'store', 'edit')) {
            return $this->load->view('errors/html/error_permission_denied');
    	}
    
    	// Layout library loaded site wide
    
    	$this->set_layout();
    	$this->layout->title(STO0210_TITLE_DOCTOR.' | Strikeforce');
    
    	$data = array();
    
    	//Set data for layout
    	$data['index'] = 'store';
    	$data['html_module'] = 'doc0210Module';
    	$data['body_id'] = '';
    	$data['body_module'] = 'DOC0210Ctrl';
    	$data['body_ngInit'] = 'init()';
    	$this->set_data_for_layout($data);
    
    	$this->load->model('store_model');
    	$data['storeId'] = $this->store_model->get_store_by_code($id);
    
    	$this->layout->view('store/doctor_update', $data);
    }
    
    public function load_store_for_edit()
    {
        $data['returnCd'] = NULL;
        $data['returnMsg'] = NULL;
        $data['selectSore'] = NULL;
        $profile = $this->profile;

        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'store', 'edit')) {

            $param = json_decode(trim(file_get_contents('php://input')), true);  
            $this->load->model('store_model');             
            $this->load->model('zone_model');             
            $this->load->model('product_type_mst_model');             
            $data['selectSore'] = $this->store_model->get_store_by_id($param);  
            $data["zoneList"] =  $this->zone_model->zoneResultDto();
            $data["productTypeList"] =  $this->product_type_mst_model->proTypeResultDto($param);
            
        }
        $this->return_json($data);
    }

    public function update_store()
    {
        $data['returnCd'] = NULL;
        $data['returnMsg'] = NULL;
        $data['proResult'] = NULL; 
        $profile = $this->profile;

        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'store', 'edit')) {

            $param = json_decode(trim(file_get_contents('php://input')), true);  
            $this->load->model('store_model');
            $update = $this->store_model->update_store($param);
            if ($update == "OK"){
                $data['proResult'] =   array("proFlg"=>$update,"message"=>"Update success");
            }else{
                $data['proResult'] =   array("proFlg"=>RES_NG,"message"=>$update);
            }
        }
        $this->return_json($data);
    }

    public function store_detail($id)
    {
        $profile = $this->profile;
        if (!check_ACL($profile, 'store', 'menu')) {
            $this->load->helper('url');
            redirect('/');
        }

        // Layout library loaded site wide

        $this->set_layout();
        $this->layout->title(STO0300_TITLE.' | Strikeforce');

        $data = array();

        //Set data for layout
        $data['index'] = 'store';
        $data['html_module'] = 'sto0300Module';
        $data['body_id'] = '';
        $data['body_module'] = 'STO0300Ctrl';
        $data['body_ngInit'] = 'init()';
        $this->set_data_for_layout($data);

        $this->load->model('store_model');
        $data['storeId'] = $this->store_model->get_store_by_code($id);
        $this->layout->view('store/store_detail', $data); 
    }

    public function init_store_detail()
    {
      $data['returnCd'] = NULL;
        $data['returnMsg'] = NULL;
        $data['initData'] = NULL;
        $profile = $this->profile;

        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'store', 'menu')) {
            $param = json_decode(trim(file_get_contents('php://input')), true);
            $this->load->model('client_model');
            $dataFilter['searchClientStore'] = $this->client_model->searchClientStore($param["storeId"]);
            $dataFilter["clientInfo"]["clientList"] = $this->client_model->searchClientNotStore($param["storeId"]); 
            $data['initData'] =  $dataFilter;
        }
        $this->return_json($data);
    }

    public function store_client_list()
    {
        $profile = $this->profile;
        if (!check_ACL($profile, 'store', 'menu')) {
            $this->load->helper('url');
            redirect('/');
        }
        $this->load->view('store/store_client_list');
    }

    public function regisClientStore()
    {
        $data['returnCd'] = NULL;
        $data['returnMsg'] = NULL;
        $data['regisResult'] = NULL;
        
         
        $profile = $this->profile;
        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'store', 'menu')) {

            $param = json_decode(trim(file_get_contents('php://input')), true);  
            $this->load->model('store_model');
            $this->load->model('client_model');

            $insert = $this->store_model->regisClientStore($param);
            if ($insert == "OK"){
                $dataFilter['proResult'] =   array("proFlg"=>$insert,"message"=>"Update success");
            }else{
                $dataFilter['proResult'] =   array("proFlg"=>RES_NG,"message"=>$insert);
            }
                $dataFilter["clientInfo"]["clientList"] = $this->client_model->searchClientNotStore($param["storeId"]); 
                $dataFilter['searchClientStore'] = $this->client_model->searchClientStore($param["storeId"]);

            $data['regisResult'] = $dataFilter;
        }
        $this->return_json($data);
    }
    
    public function delete_client_in_store()
    {
        $data['returnCd'] = NULL;
        $data['returnMsg'] = NULL;
        $data['deleteResult'] = NULL;
         
        $profile = $this->profile;
        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'store', 'menu')) {

            $param = json_decode(trim(file_get_contents('php://input')), true);  
            $this->load->model('store_model');
            $this->load->model('client_model');

            $dl = $this->store_model->delete_client_in_store($param);
            if ($dl == "OK"){
                $dataFilter['proResult'] =   array("proFlg"=>$dl,"message"=>"delete success");
            }else{
                $dataFilter['proResult'] =   array("proFlg"=>RES_NG,"message"=>$dl);
            }
                $dataFilter["clientInfo"]["clientList"] = $this->client_model->searchClientNotStore($param["storeId"]); 
                $dataFilter['searchClientStore'] = $this->client_model->searchClientStore($param["storeId"]);

            $data['deleteResult'] = $dataFilter;
        }
        $this->return_json($data);
    }

    public function init_staffs()
    {
        $data['returnCd'] = NULL;
        $data['returnMsg'] = NULL;
         
        $data['clientInfo'] = NULL; 
        $data['searchResult'] =array("salesmanNotAssignStore"=>NULL,"pagingInfo"=>NULL); 
        $profile = $this->profile;
        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'store', 'menu')) {

            $param = json_decode(trim(file_get_contents('php://input')), true);  
            $this->load->model('store_model');
            $this->load->model('client_model'); 
            
            $items = $this->client_model->searchClientStore($param["storeId"]);
            if (!empty($items)){
                $data['defaultClientId'] = $items[0]["clientId"];    
            }
            $data['clientInfo'] = $items;
        }
        $this->return_json($data);
    }
    
    public function store_staff_list()
    {
        $profile = $this->profile;
        if (!check_ACL($profile, 'store', 'menu')) {
            $this->load->helper('url');
            redirect('/');
        }
        $data['profile'] = $profile;
        $this->load->view('store/store_staff_list', $data);
    }

    public function selectSalesmanByStoreClient()
    {
        $data['returnCd'] = NULL;
        $data['returnMsg'] = NULL;
        $data['selectSalesmanByStoreClient'] = NULL;

        $profile = $this->profile;
        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'store', 'menu')) {

            $param = json_decode(trim(file_get_contents('php://input')), true);
            /*Hardcode Client - Begin - @author: CanhLD*/
            // $param['clientId'] = 1;
            /*Hardcode Client - End - @author: CanhLD*/
            $this->load->model('saleman_model');

            $data['selectSalesmanByStoreClient'] = $this->saleman_model->selectSalesmanByStoreClient($param);
        }
        $this->return_json($data);        
    }

    public function selectSalesmanNotAssingnStore()
    {
        $data['returnCd'] = NULL;
        $data['returnMsg'] = NULL;
        $data['searchResult'] = array(
            "salesmanNotAssignStore"    =>NULL,
            "pagingInfo"                =>NULL
        );

        $profile = $this->profile;
        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'store', 'add_mr')) {

            $param = json_decode(trim(file_get_contents('php://input')), true);

            /*Hardcode Client - Begin - @author: CanhLD*/
            // $param['clientId'] = 1;
            /*Hardcode Client - End - @author: CanhLD*/
            $this->load->model('saleman_model');

            $data['searchResult'] = $this->saleman_model->selectSalesmanNotAssingnStore($param);
        }
        $this->return_json($data);        
    }

    public function regisSalesmanStore()
    {
        $data['returnCd'] = NULL;
        $data['returnMsg'] = NULL;
        $data['regisResult'] = NULL;
        $profile = $this->profile;
        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'store', 'add_mr')) {
            $this->load->model('saleman_model');

            $param = json_decode(trim(file_get_contents('php://input')), true);  
            $insert_store = $this->saleman_model->regisSalesmanStore($param["selectSalesman"]);
            
                if ($insert_store == "OK"){
                    $data['regisResult'] =   array("proFlg"=>$insert_store,"message"=>I0000001);
                }else{
                    $data['regisResult'] =   array("proFlg"=>RES_NG,"message"=>$insert_store);
                }
            $this->return_json($data);        
        }
    }

    public function deleteSalesmanStore()
    {
        $data['returnCd'] = NULL;
        $data['returnMsg'] = NULL;
        $data['regisResult'] = NULL;
        $profile = $this->profile;
        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'store', 'add_mr')) {
            $this->load->model('saleman_model');

            $param = json_decode(trim(file_get_contents('php://input')), true);  
            $del = $this->saleman_model->delete_saleman_store($param);
            
                if ($del == "OK"){
                    $data['regisResult'] =   array("proFlg"=>$del,"message"=>I0000001);
                }else{
                    $data['regisResult'] =   array("proFlg"=>RES_NG,"message"=>$del);
                }

            $this->return_json($data);        
        }
    } 

    public function store_photos()
    {
        $profile = $this->profile;
        if (!check_ACL($profile, 'store', 'menu')) {
            $this->load->helper('url');
            redirect('/');
        }
        $this->load->view('store/store_photos');
    }

    public function selectPhotoStore()
    {
        $data['returnCd'] = NULL;
        $data['returnMsg'] = NULL;
        $data['photoResult'] = NULL;
        $profile = $this->profile;
        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'store', 'menu')) {
            $this->load->model('photos_model');


            $param = json_decode(trim(file_get_contents('php://input')), true);  
            $data['photoResult'] = $this->photos_model->selectPhotoStore($param);
        }
        
        $this->return_json($data);      
    }

    public function form_import()
    {
        $profile = $this->profile;
        if (!check_ACL($profile, 'store', 'import')) {
            $this->load->helper('url');
            redirect('/');
        }
        $this->load->view('store/store_import');
    }

    public function start_import()
    {
        set_time_limit(0);
        $data['returnCd'] = NULL;
        $data['returnMsg'] = NULL;
        $data['proResult'] = array("proFlg"=>RES_NG,"message"=>"");
        $profile = $this->profile;
        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'store', 'import')) {
            if (isset($_FILES['file']['tmp_name'])){
                $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
                $this->load->library('FileManagement');
                $this->load->model('store_model'); 

                $filePath = $this->filemanagement->saveFileImport("store", $_FILES['file']['tmp_name'], $ext);

                $import = $this->store_model->import($filePath, $_FILES['file']['name']);
                if ($import == "OK"){
                    $data['proResult'] =   array("proFlg"=>$import,"message"=>I0000008);
                }else{
                    $data['proResult'] =   array("proFlg"=>RES_NG,"message"=>$import);
                }
            }
        }
        $this->return_json($data);      
    }

    public function export_customer($is_doctor)
    {
        set_time_limit(0);
        ini_set('memory_limit','1028M');
        $profile = $this->profile;
        if (($is_doctor == 0 && !check_ACL($profile, 'store', 'export_pharmacy'))
            ||($is_doctor == 1 && !check_ACL($profile, 'store', 'export_doctor'))) {
            $this->load->helper('url');
            redirect('/');
        }


        $path = STATIC_REAL_SERVER."/custommer";
        $this->load->library('FileManagement');
        $filePath = $this->filemanagement->createFolderDefault($path);

        $name = "Customer_List_".date("YmdHis").".xlsx";

        $this->load->model('store_model');
        $this->store_model->create_excel_file_rp($is_doctor, $path."/".$name);

        $this->load->helper('download');
        $data = file_get_contents($path."/".$name); // Read the file's contents
        force_download($name, $data);
    }
}
