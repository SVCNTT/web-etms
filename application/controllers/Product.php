<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends MY_Controller
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
        $this->load->view('product/index', $data);
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
            $this->load->model('product_group_model');

            $this->load->model('product_model');
            $params["search"] = TRUE;
            // var_dump($params);

            $data["initData"] = array("productTypeLst"=>$this->product_type_mst_model->proTypeResultDto($params),
                                        "productGroupLst"=>$this->product_group_model->proGroupResultDto($params)
                                        );
            $list = $this->product_model->searchAllProductModelAndName( array("searchInput"=>$params));
            if (!empty($list)){
                $data['productInfoList'] = $list["productInfoList"]; 
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
        $data['productInfoList'] = []; 
        $data['pagingInfo'] = array(
            'ttlRow'    =>  0
        );

        $profile = $this->profile;
        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'dashboard', 'menu')) {

            $params = json_decode(trim(file_get_contents('php://input')), true); 
            $this->load->model('product_model');

            $list = $this->product_model->searchAllProductModelAndName($params);
            if (!empty($list)){
                $data['productInfoList'] = $list["productInfoList"]; 
                $data['pagingInfo'] = $list["pagingInfo"]; 
            }

        }
        $this->return_json($data);
    }

    public function create()
    {
        $profile = $this->profile;
        if (!check_ACL($profile, 'dashboard', 'medicine_import')) {
            $this->load->helper('url');
            redirect('/');
        }
        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'dashboard', 'medicine_import')) {
            $params = json_decode($_POST["param"]);
            
            if (isset($_FILES['file']['tmp_name'])){
                $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
                $this->load->library('FileManagement');
                $this->load->model('product_model'); 
                $filePath = $this->filemanagement->saveFileImport("product", $_FILES['file']['tmp_name'], $ext);
               $import = $this->product_model->product_import($filePath, array("clientId"=>$params->clientId));
                if ($import == "OK"){
                    $data['proResult'] =   array("proFlg"=>$import,"message"=>I0000008);
                }else{
                    $data['proResult'] =   array("proFlg"=>RES_NG,"message"=>$import);
                }
            }
              $this->return_json($data);
        }else {
         $this->load->view('product/product_create');
        }
    }


    public function initType()
    {
        $data['returnCd'] = NULL;
        $data['returnMsg'] = NULL;
        $data['proTypeList'] = [];
        $data['proGroupList'] = [];
        $profile = $this->profile;

        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'dashboard', 'menu')) {

            $params = json_decode(trim(file_get_contents('php://input')), true); 
            $this->load->model('product_type_mst_model');
            $this->load->model('product_group_model');
            $data["proTypeList"] = array("productTypeList"=>$this->product_type_mst_model->proTypeResultDto($params));
            $data["proGroupList"] = array("productGroupList"=>$this->product_group_model->proGroupResultDto($params));
    
        }
        $this->return_json($data);
    }

    public function selectGroupByProductType()
    {
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
    
    
    public function regisPro()
    {
            $data['returnCd'] = NULL;
            $data['returnMsg'] = NULL;
        $data['proResult'] = array(
            'proFlg'    =>  RES_NG,
            'message'   =>  ''
        );

            $profile = $this->profile; 
        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'dashboard', 'medicine_add')) {
            $param = json_decode(trim(file_get_contents('php://input')), true);  

            $this->load->model('product_model');
            $insert = $this->product_model->regisPro($param);
            if ($insert == "OK"){
                $data["proFlg"] = $insert;
                $data["message"] = I0000001;
            }else{
                $data["proFlg"] = RES_NG;
                $data["message"] = $insert;
            }
        }
        $this->return_json($data);
    }

    public function deleteProduct()
    {
            $data['returnCd'] = NULL;
            $data['returnMsg'] = NULL;
        $data['proResult'] = array(
            'proFlg'    =>  RES_NG,
            'message'   =>  ''
        );

            $profile = $this->profile; 
        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'dashboard', 'medicine_del')) {
            $params = json_decode(trim(file_get_contents('php://input')), true);  
            $this->load->model('product_model');
            $del = $this->product_model->deleteProduct($params);
            if ($del == "OK"){
                $data["proFlg"] = $del;
                $data["message"] = I0000003;
            }else{
                $data["proFlg"] = RES_NG;
                $data["message"] = $del;
            }
        }
        $this->return_json($data);
    }

    public function selectProduct()
    {
        $data['returnCd'] = NULL;
        $data['returnMsg'] = NULL;
        $data['productInfo'] = [];
        $profile = $this->profile;

        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'dashboard', 'medicine_edit')) {
            $params = json_decode(trim(file_get_contents('php://input')), true);

            $this->load->model('product_model');
            $data["productInfo"] = $this->product_model->selectProductById($params)[0];
        }
        $this->return_json($data);
    }

    public function updateProduct()
    {
            $data['updateProduct'] = NULL;
            $data['returnMsg'] = NULL;
        $data['proResult'] = array(
            'proFlg'    =>  RES_NG,
            'message'   =>  ''
        );

            $profile = $this->profile; 
        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'dashboard', 'medicine_edit')) {
            $params = json_decode(trim(file_get_contents('php://input')), true);  
            $this->load->model('product_model');
            $update = $this->product_model->updateProduct($params);
            if ($update == "OK"){
                $data["proFlg"] = $update;
                $data["message"] = I0000005;
            }else{
                $data["proFlg"] = RES_NG;
                $data["message"] = $update;
            }
        }
        $this->return_json($data);
    }

    public function form_import()
    {
        $profile = $this->profile;
        if (!check_ACL($profile, 'dashboard', 'medicine_import')) {
            $this->load->helper('url');
            redirect('/');
        }

         $this->load->view('product/product_import');
    }


}
