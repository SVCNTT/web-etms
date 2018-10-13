<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Monthly_reports extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        /*Authentication - Begin*/
        $this->check_auth = $this->check_login();
        /*Authentication - End*/
    }

//    public function index()
//    {
//        $profile = $this->profile;
//        if (!check_ACL($profile, 'report', 'menu')) {
//            $this->load->helper('url');
//            redirect('/');
//        }
//
//        $path = STATIC_REAL_SERVER . "/monthlyReport";
//        $this->load->library('FileManagement');
//        $filePath = $this->filemanagement->createFolderDefault($path);
//        $export_date = date('Y-m-d H:i:s', mktime(0, 0, 0, date('m'), 1, date('Y')));
//        $name = "SFE_Report_Bayer_" . date("Y", strtotime($export_date)) . "_" . date("m", strtotime($export_date)) . ".xlsx";
//
//        $this->load->model('monthly_report_model');
//        $salesmans = $this->monthly_report_model->buildDatabaseExport($export_date);
//        $salesmansTeams = $this->monthly_report_model->buildDatabaseExportTeams($export_date);
//        $salesmans_detail = $this->monthly_report_model->calculateDataDetail($salesmans, $export_date);
//        $this->monthly_report_model->create_excel_file_rp($export_date, $salesmans, $salesmansTeams, $salesmans_detail, $path . "/" . $name);
//        $this->load->helper('download');
//        $data = file_get_contents($path . "/" . $name); // Read the file's contents
//        force_download($name, $data);
//    }

    public function change_month()
    {
        $this->load->view('monthlyreport/form_change_monthly_report');
    }

    public function init_data() {
        $result = array(
            'productTypeInfo' =>  array(),
            'returnCd'  =>  NULL,
            'returnMsg' =>  NULL,
        );

        $profile = $this->profile;

        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'report', 'menu')) {
            $this->load->model('user_product_type_model');
            $result['productTypeInfo'] = array_merge(array('0'=>array('product_type_id'=>null, 'product_type_name'=>'--- All ---')), $this->user_product_type_model->getProductTypeByRole($profile));
        }

        return $this->return_json($result);
    }

    public function export()
    {
        $result = array(
            'returnCd'  =>  null,
            'returnMsg' =>  null,
            'proResult' =>  array(
                'proFlg'    =>  RES_NG,
                'message'   =>  '',
                'pathFile'  =>  ''
            )

        );

        $profile = $this->profile;
        if(!check_ACL($profile, 'report', 'menu')) {
            $this->load->helper('url');
            redirect('/');
        }

        if ($this->input->method(TRUE) === 'POST' && $this->check_auth !== FALSE) {
            $input_data = json_decode(trim(file_get_contents('php://input')), true);
            $monthReport = isset($input_data['monthReport']) ? $input_data['monthReport'] : '';
            $yearReport = isset($input_data['yearReport']) ? $input_data['yearReport'] : '';
            $bu = isset($input_data['bu']) ? $input_data['bu'] : '';
            if( $monthReport !== '' &&  $yearReport !== ''){
                ini_set('memory_limit','2048M');
				set_time_limit(60*5); //5 minutes

        $path = STATIC_REAL_SERVER . "/monthlyReport";
        $this->load->library('FileManagement');
        $filePath = $this->filemanagement->createFolderDefault($path);

              $export_date = date('Y-m-d H:i:s', mktime(0, 0, 0, $monthReport, 1, $yearReport));

 		$name = "SFE_Report_Bayer_".date("Y", strtotime($export_date))."_".date("m", strtotime($export_date)).".xlsx";

        $this->load->model('monthly_report_model');

                $salesmans = $this->monthly_report_model->buildDatabaseExport($export_date, $bu);
                $salesmansTeams = $this->monthly_report_model->buildDatabaseExportTeams($export_date, $bu);
        $salesmans_detail = $this->monthly_report_model->calculateDataDetail($salesmans, $export_date);

		$this->monthly_report_model->create_excel_file_rp($export_date, $salesmans, $salesmansTeams, $salesmans_detail, $path."/".$name);

                $result['proResult']['pathFile'] = "/".$path . "/" . $name;
                $result['proResult']['message'] = "Export monthly report success";
                $result['proResult']['proFlg'] = "OK";
            }

            else {
              $result['proResult']['message'] = "Please choose Time";
            }

        }

        return $this->return_json($result);
    }

}
