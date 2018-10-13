<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Client extends MY_Controller
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
        if (!check_ACL($profile, 'client', 'menu')) {
            $this->load->helper('url');
            redirect('/');
        }

        // Layout library loaded site wide

        $this->set_layout();
        $this->layout->title(CLI0100_TITLE . ' | Strikeforce');

        $data = array();

        //Set data for layout
        $data['index'] = 'client';
        $data['html_module'] = 'cli0100Module';
        $data['body_id'] = '';
        $data['body_module'] = 'CLI0100Ctrl';
        $data['body_ngInit'] = 'init()';
        $this->set_data_for_layout($data);
        $this->layout->view('client/index', $data); 
    }

    public function initData()
    {
        $data['returnCd'] = NULL;
        $data['returnMsg'] = NULL;
        $data['cliInfo'] = [];
        $data['pagingInfo'] = NULL; 
        $data['searchInput'] = NULL; 
        $profile = $this->profile;

        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'client', 'menu')) {

            $params = json_decode(trim(file_get_contents('php://input')), true); 
            $this->load->model('client_model');

            $clients = $this->client_model->getListClient($params);
           // var_dump($clients);
             $data['cliInfo']["clientList"] = $clients["clientList"];
             $data['pagingInfo']= $clients["pagingInfo"];
    
        }
        $this->return_json($data);
    }

    public function searchData()
    {
        $data['returnCd'] = NULL;
        $data['returnMsg'] = NULL;
        $data['clientInfo'] = [];
        $data['pagingInfo'] = NULL; 
        $data['searchInput'] = NULL; 
        $profile = $this->profile;

        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'client', 'menu')) {

            $params = json_decode(trim(file_get_contents('php://input')), true); 
            $this->load->model('client_model');
                $clients = $this->client_model->getListClient($params);
             $data['clientInfo']["clientList"] = $clients["clientList"];
             $data['pagingInfo']= $clients["pagingInfo"];
        }
        $this->return_json($data);
    }

    public function create()
    {

        $profile = $this->profile;
        if (!check_ACL($profile, 'client', 'menu')) {
            $this->load->helper('url');
            redirect('/');
        }
        // Layout library loaded site wide

        $this->set_layout();
        $this->layout->title(CLI0200_TITLE . ' | Strikeforce');

        $data = array();

        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'client', 'menu')) {
            
             
                $this->load->model('client_model');
                $this->load->model('cdmst_model');

                $message = $this->client_model->validate_client($_POST['clientName']);
            if ($message != NULL){ //have error
                $data['message'] = $message;
                $data['clientName'] = $_POST['clientName'];
                $data['ratePoint'] = $_POST['ratePoint'];

            }else{
                    $clienType = "";                    
                    $clientT = $this->cdmst_model->selectByExample(array("codeCd"=>$_POST['clienType']))[0];

                    if (empty($clientT["lang_key"])){
                        $clienType = $clientT["code_name"];
                    }else{
                        if (defined($clientT["lang_key"])) {
                            $clienType = constant($clientT["lang_key"]);
                        }else{
                            $clienType = $clientT["lang_key"];
                        }
                    }

                    $imagePath = "";
                    if (isset($_FILES['file']['tmp_name'])){
                        $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
                        $this->load->library('FileManagement');

                        $imagePath = $this->filemanagement->saveImageWeb("client", $_FILES['file']['tmp_name'], $ext);
                    }   

                $message = $this->client_model->client_create($_POST['clientName'], $clienType, $_POST['ratePoint'], $imagePath);
                $data['message'] = $message;
            }
            
            if ($_POST['save'] == 'save'){
                  redirect('CLI0100');
            }

         }

        //Set data for layout
        $data['index'] = 'client';
        $data['html_module'] = 'cli0200Module';
        $data['body_id'] = '';
        $data['body_module'] = 'CLI0200Ctrl';
        $data['body_ngInit'] = 'init()';
        $this->set_data_for_layout($data);
        $this->layout->view('client/client_create', $data); 
    }

    
    public function initType()
    {
        $data['returnCd'] = NULL;
        $data['returnMsg'] = NULL;
        $data['clientType'] = [];
        
        $profile = $this->profile;

        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'client', 'menu')) {

            $params = json_decode(trim(file_get_contents('php://input')), true); 
            $this->load->model('cdmst_model');
            $data['clientType'] = $this->cdmst_model->buildTypeClient();
    
        }
        $this->return_json($data);
    }
}
