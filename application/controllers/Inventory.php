<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventory extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        /*Authentication - Begin*/
        $this->check_auth = $this->check_login();
        /*Authentication - End*/
    }


    public function index() {
        $data = array();
        $profile = $this->profile;
        $data['profile'] = $profile;

        if (!check_ACL($profile, 'store', 'inventory_view')) {
            return $this->load->view('errors/html/error_permission_denied', $data);
        }

        $this->load->view('inventory/list', $data);
    }


    public function init()
    {
        $data = array();
        $data['returnCd'] = NULL;
        $data['returnMsg'] = NULL;
        $data['initData'] = NULL;
        $data['resultSearch'] = NULL;

        $profile = $this->profile;

        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'store', 'inventory_view')) {

            $param = json_decode(trim(file_get_contents('php://input')), true);


            $this->load->model('inventory_history_model');
            $this->load->model('user_mst_model');

            $param['curr_user'] = $profile;
            $data['resultSearch'] = $this->inventory_history_model->searchData($param);

            $sales_manager = $this->user_mst_model->getSalesManagerByRole($profile);
            array_unshift($sales_manager, array('user_id'=>0, 'first_name'=>'', 'last_name' => 'All'));
            $data['salesManager'] = $sales_manager;
            $data['regionalManager'] = array(array('user_id'=>0, 'first_name'=>'', 'last_name' => 'All'));
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

        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'store', 'inventory_view')) {
            $param = json_decode(trim(file_get_contents('php://input')), true);
            $this->load->model('inventory_history_model');
            $param['curr_user'] = $profile;
            $data['resultSearch'] = $this->inventory_history_model->searchData($param);
        }
        $this->return_json($data);
    }


    public function loadRegionalManager() {
        $data = array();
        $data['returnCd'] = NULL;
        $data['returnMsg'] = NULL;

        $param = json_decode(trim(file_get_contents('php://input')), true);

        $sales_manager = array(
            'user_id' => $param['searchInput']['salesManagerId'],
        );

        $this->load->model('user_mst_model');

        $regional_manager = $this->user_mst_model->getRegionalManagerBySalesManager($sales_manager);
        array_unshift($regional_manager, array('user_id'=>0, 'first_name'=>'', 'last_name' => 'All'));
        $data['regionalManager'] = $regional_manager;
        $this->return_json($data);
    }


    public function form_import()
    {
        $profile = $this->profile;
        if (!check_ACL($profile, 'store', 'inventory_import')) {
            $this->load->helper('url');
            redirect('/');
        }
        $this->load->view('inventory/import');
    }


    public function start_import()
    {
//        set_time_limit(0);
        $data['returnCd'] = NULL;
        $data['returnMsg'] = NULL;
        $data['proResult'] = array("proFlg" => RES_NG, "message" => "");
        $profile = $this->profile;
        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'store', 'inventory_import')) {
            if (isset($_FILES['file']['tmp_name'])) {
                $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
                $this->load->library('FileManagement');
                $this->load->model('inventory_store_model');

                $filePath = $this->filemanagement->saveFileImport("inventory", $_FILES['file']['tmp_name'], $ext);

                $import = $this->inventory_store_model->import($filePath, $_FILES['file']['name']);

                if ($import == "OK") {
                    $data['proResult'] = array("proFlg" => $import, "message" => I0000008);
                } else {
                    $data['proResult'] = array("proFlg" => RES_NG, "message" => $import);
                }
            }
        }
        $this->return_json($data);
    }


    public function export($month)
    {
//        set_time_limit(0);
        ini_set('memory_limit','1028M');
        $profile = $this->profile;
        if (!check_ACL($profile, 'store', 'inventory_export')) {
            $this->load->helper('url');
            redirect('/');
        }


        $path = STATIC_REAL_SERVER."/inventory";
        $this->load->library('FileManagement');
        $filePath = $this->filemanagement->createFolderDefault($path);

        $name = "Inventory_monthly_report_". $month .".xlsx";

        $this->load->model('inventory_history_model');

        $month = explode('-', $month);

        if ($month[0] < 10) {
            $month[0] = "0".$month[0];
        }

        $this->inventory_history_model->create_excel_file_rp($month[1].$month[0], $path."/".$name,  $this->profile);

        $this->load->helper('download');
        $data = file_get_contents($path."/".$name); // Read the file's contents
        force_download($name, $data);
    }
}
