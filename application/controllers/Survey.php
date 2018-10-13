<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Survey extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        /*Authentication - Begin*/
        $this->check_auth = $this->check_login();
        /*Authentication - End*/
    }

    /*Manage survey tab - BEGIN*/

    public function survey_manage()
    {
        $profile = $this->profile;
        $data['profile'] = $profile;

        if (!check_ACL($profile, 'store', 'manage_survey')) {
            return $this->load->view('errors/html/error_permission_denied', $data);
        }

        $this->load->view('survey/survey_manage', $data);
    }


    public function survey_search()
    {
        $result = array(
            'resultSearch' => array(
                'surveyList' => array()
            ),
            'returnCd' => NULL,
            'returnMsg' => NULL,
        );

        $profile = $this->profile;

        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'store', 'manage_survey')) {
            /*Get search param*/
            $input_data = json_decode(trim(file_get_contents('php://input')), true);

            /*Get paging param*/
            $paging_input = isset($input_data['pagingInfo']) ? $input_data['pagingInfo'] : array();
            $crtPage = isset($paging_input['crtPage']) ? $paging_input['crtPage'] : 1;
            if ($crtPage < 1) {
                $crtPage = 1;
            }

            $this->load->model('survey_model');

            /*Paging - Begin*/
            $ttlRow = $this->survey_model->countSurveyByName($input_data);
            $pagingInfo = $this->survey_model->setPagingInfo($ttlRow, $crtPage);;
            /*Paging - End*/

            if ($ttlRow > 0) {
                $offset = ($pagingInfo['crtPage'] - 1) * ROW_ON_PAGE;
                $input_data['limit'] = ROW_ON_PAGE;
                $input_data['offset'] = $offset;

                $survey_list = $this->survey_model->searchSurveyByName($input_data);
                $resultSearch['surveyList'] = $survey_list;
            }

            $resultSearch['pagingInfo'] = $pagingInfo;
            $result['resultSearch'] = $resultSearch;
        }

        return $this->return_json($result);
    }


    public function survey_form_import()
    {
        $profile = $this->profile;
        if (!check_ACL($profile, 'store', 'im_survey')) {
            return $this->load->view('errors/html/error_permission_denied');
        }
        $this->load->view('survey/survey_form_import');
    }


    public function survey_start_import()
    {
        set_time_limit(0);
        $data['returnCd'] = NULL;
        $data['returnMsg'] = NULL;
        $data['proResult'] = array("proFlg" => RES_NG, "message" => "");
        $profile = $this->profile;
        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'store', 'im_survey')) {
            if (isset($_FILES['file']['tmp_name'])) {
                $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
                $this->load->library('FileManagement');
                $this->load->model('survey_model');

                $filePath = $this->filemanagement->saveFileImport("store", $_FILES['file']['tmp_name'], $ext);

                $import = $this->survey_model->import($filePath, $_FILES['file']['name']);
                if ($import == RES_OK) {
                    $data['proResult'] = array("proFlg" => $import, "message" => I0000008);
                } else {
                    $data['proResult'] = array("proFlg" => RES_NG, "message" => $import);
                }
            }
        }
        $this->return_json($data);
    }


    public function survey_get_questions()
    {
        $result = array(
            'resultSearch' => array(
                'questions' => array()
            ),
            'returnCd' => NULL,
            'returnMsg' => NULL,
        );

        $profile = $this->profile;

        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'store', 'manage_survey')) {
            /*Get search param*/
            $input_data = json_decode(trim(file_get_contents('php://input')), true);
            $survey_id = isset($input_data['survey_id']) ? $input_data['survey_id'] : 0;
            $token = isset($input_data['token']) ? $input_data['token'] : '';

            $token_right = md5($survey_id.'_'.SECRECT_KEY_SURVEY);
            if ($token == $token_right) {

            $this->load->model('survey_model');
            $rs = $this->survey_model->getQuestionBySurveyId($survey_id);

            $result['resultSearch']['questions'] = isset($rs['questions']) ? json_decode($rs['questions'], true) : array();
        }
        }

        return $this->return_json($result);
    }


    public function survey_active()
    {
        $result['proResult'] = array("proFlg" => RES_NG, "message" => E0000003);

        $profile = $this->profile;

        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'store', 'manage_survey')) {
            /*Get search param*/
            $input_data = json_decode(trim(file_get_contents('php://input')), true);
            $survey_id = isset($input_data['survey_id']) ? $input_data['survey_id'] : 0;
            $status = isset($input_data['status']) ? $input_data['status'] : SURVEY_STATUS_DISABLE;
            $token = isset($input_data['token']) ? $input_data['token'] : '';

            $token_right = md5($survey_id.'_'.SECRECT_KEY_SURVEY);
            if ($token == $token_right) {

            $this->load->model('survey_model');
            $rs = $this->survey_model->activeSurvey($survey_id, $status, $profile);

            if ($rs == RES_OK) {
                $result['proResult'] = array("proFlg" => $rs, "message" => I0000002);
            } else {
                $result['proResult'] = array("proFlg" => RES_NG, "message" => $rs);
            }
            } else {
                $result['proResult'] = array("proFlg" => RES_NG, "message" => E0000007);
            }
        }

        return $this->return_json($result);
    }


    public function survey_delete()
    {
        $result['proResult'] = array("proFlg" => RES_NG, "message" => E0000003);

        $profile = $this->profile;

        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'store', 'manage_survey')) {
            /*Get search param*/
            $input_data = json_decode(trim(file_get_contents('php://input')), true);
            $survey_id = isset($input_data['id']) ? $input_data['id'] : 0;
            $token = isset($input_data['token']) ? $input_data['token'] : '';

            $token_right = md5($survey_id.'_'.SECRECT_KEY_SURVEY);

            if ($token == $token_right) {

                $this->load->model('survey_model');
                $rs = $this->survey_model->deleteSurvey($survey_id, $profile);

                if ($rs == RES_OK) {
                    $result['proResult'] = array("proFlg" => $rs, "message" => I0000002);
                } else {
                    $result['proResult'] = array("proFlg" => RES_NG, "message" => $rs);
                }
            } else {
                $result['proResult'] = array("proFlg" => RES_NG, "message" => E0000007);
            }
        }

        return $this->return_json($result);
    }
    /*Manage survey tab - END*/


    /*Manage answer tab - BEGIN*/
    public function answer_report()
    {
        $profile = $this->profile;
        $data['profile'] = $profile;

        if (!check_ACL($profile, 'store', 'report_answer')) {
            return $this->load->view('errors/html/error_permission_denied', $data);
        }

        $this->load->view('survey/answer_report', $data);
    }


    public function answer_init()
    {
        $result = array(
            'resultInit' => array(
                'surveyList' => array(),
                'store_code' => array(),
                'mr_code' => array(),
            ),
            'returnCd' => NULL,
            'returnMsg' => NULL,
        );

        $profile = $this->profile;

        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'store', 'report_answer')) {

//            $input_data = json_decode(trim(file_get_contents('php://input')), true);

            /*Get list survey*/
            $this->load->model('survey_model');
            $surveyList = $this->survey_model->searchSurveyByName(array());
            /*Get list survey - END*/

            $result['resultInit']['surveyList'] = $surveyList;
        }

        return $this->return_json($result);
    }


    public function answer_search()
    {
        $result = array(
            'resultSearch' => array(
                'answerList' => array()
            ),
            'returnCd' => NULL,
            'returnMsg' => NULL,
        );

        $profile = $this->profile;

        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'store', 'report_answer')) {
            /*Get search param*/
            $input_data = json_decode(trim(file_get_contents('php://input')), true);
            $input_data['curr_user'] = $profile;

            $survey_id = isset($input_data['survey_id']) ? $input_data['survey_id'] : 0;

            /*Get paging param*/
            $paging_input = isset($input_data['pagingInfo']) ? $input_data['pagingInfo'] : array();
            $crtPage = isset($paging_input['crtPage']) ? $paging_input['crtPage'] : 1;
            if ($crtPage < 1) {
                $crtPage = 1;
            }

            $this->load->model('survey_answer_model');

            /*Paging - Begin*/
            $ttlRow = $this->survey_answer_model->countSearchSurveyAnswer($input_data, $survey_id);
            $pagingInfo = $this->survey_answer_model->setPagingInfo($ttlRow, $crtPage);;
            /*Paging - End*/

            $answer_list = array();
            if ($ttlRow > 0) {
                $offset = ($pagingInfo['crtPage'] - 1) * ROW_ON_PAGE;
                $input_data['limit'] = ROW_ON_PAGE;
                $input_data['offset'] = $offset;

                $answer_list = $this->survey_answer_model->searchAnswer($input_data, $survey_id);
            }

            $resultSearch['answerList'] = $answer_list;
            $resultSearch['pagingInfo'] = $pagingInfo;
            $result['resultSearch'] = $resultSearch;
        }

        return $this->return_json($result);
    }


    public function answer_detail($survey_id = 0, $id = 0, $token = '') {
        $profile = $this->profile;
        if (!check_ACL($profile, 'store', 'report_answer')) {
            $this->load->helper('url');
            redirect('/');
        }

        // Layout library loaded site wide
        $this->set_layout();
        $this->layout->title( STO0100_TITLE.' | Strikeforce');

        $data = array();

        //Set data for layout
        $data['index'] = 'store';
        $data['html_module'] = 'sto0500Module';
        $data['body_id'] = '';
        $data['body_module'] = 'STO0523Ctrl';
        $data['body_ngInit'] = 'init()';
        $data['body_cssClass'] = 'STO0523';

        $data['survey_id'] = $survey_id;
        $data['survey_answer_id'] = $id;
        $data['survey_answer_token'] = $token;

        $this->set_data_for_layout($data);
        $this->layout->view('survey/answer_detail', $data);
    }


    public function answer_get_detail() {
        $result = array(
            'resultGet'  =>  array(
                'answer'    =>  array()
            ),
            'returnCd'      =>  NULL,
            'returnMsg'     =>  NULL,
        );

        $profile = $this->profile;

        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'store', 'report_answer')) {
            /*Get search param*/
            $param = json_decode(trim(file_get_contents('php://input')), true);

            $survey_id = isset($param['survey_id']) ? intval($param['survey_id']) : -1;
            $id = isset($param['id']) ? intval($param['id']) : -1;
            $token = isset($param['token']) ? $param['token'] : '';

            /*Check token*/
            $tk_temp = md5($survey_id.$id.SECRECT_KEY_SURVEY_ANSWER);

            if ($tk_temp === $token) {
                $this->load->model('survey_answer_model');
                $answer = $this->survey_answer_model->getById($survey_id, $id);

                if (!empty($answer)) {
                    $answer['answer'] = json_decode($answer['answer'], TRUE);

                    $result['resultGet']['answer'] = $answer;
                }
            }
        }

        return $this->return_json($result);
    }


    public function answer_export($survey_id)
    {
        set_time_limit(0);
        ini_set('memory_limit','1028M');
        $profile = $this->profile;
        if (!check_ACL($profile, 'store', 'report_answer')) {
            $this->load->helper('url');
            redirect('/');
        }


        $path = STATIC_REAL_SERVER."/survey_answer";
        $this->load->library('FileManagement');
        $filePath = $this->filemanagement->createFolderDefault($path);

        $name = "Survey_result_".date("YmdHis").".xlsx";

        $this->load->model('survey_answer_model');
        $this->survey_answer_model->create_excel_file_rp($survey_id, $path."/".$name);

        $this->load->helper('download');
        $data = file_get_contents($path."/".$name); // Read the file's contents
        force_download($name, $data);
    }
    /*Manage answer tab - END*/


    /*Manage customers tab - BEGIN*/
    public function store_list()
    {
        $data = array();
        $profile = $this->profile;
        $data['profile'] = $profile;

        if (!check_ACL($profile, 'store', 'manage_customer_survey')) {
            return $this->load->view('errors/html/error_permission_denied', $data);
        }

        $this->load->view('survey/store_list', $data);
    }

    public function store_init()
    {
        $data['returnCd'] = NULL;
        $data['returnMsg'] = NULL;
        $data['initData'] = NULL;
        $data['resultSearch'] = NULL;

        $profile = $this->profile;

        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'store', 'manage_customer_survey')) {

            $param = json_decode(trim(file_get_contents('php://input')), true);


            $this->load->model('store_survey_model');

            $param['curr_user'] = $profile;
            $data['resultSearch'] = $this->store_survey_model->searchData($param);
        }
        $this->return_json($data);
    }

    public function store_search()
    {
        $data['returnCd'] = NULL;
        $data['returnMsg'] = NULL;
        $data['initData'] = NULL;
        $data['resultSearch'] = NULL;
        $profile = $this->profile;

        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'store', 'manage_customer_survey')) {
            $param = json_decode(trim(file_get_contents('php://input')), true);
            $this->load->model('store_survey_model');
            $param['curr_user'] = $profile;
            $data['resultSearch'] = $this->store_survey_model->searchData($param);
        }
        $this->return_json($data);
    }

    public function store_delete()
    {
        $result['returnCd'] = NULL;
        $result['returnMsg'] = NULL;
        $result['proResult'] = array("proFlg" => RES_NG, "message" => E0000003);
        $profile = $this->profile;

        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'store', 'manage_customer_survey')) {

            $param = json_decode(trim(file_get_contents('php://input')), true);
            $this->load->model('store_model');

            $store_code = isset($param["storeCode"]) ? $param["storeCode"] : '';
            $token = isset($param['token']) ? $param['token'] : '';

            $token_right = md5($store_code.SECRECT_KEY_STORE_SURVEY);

            if ($token == $token_right) {

                $this->load->model('store_survey_model');
                $rs = $this->store_survey_model->deleteStore($store_code, $profile);

                if ($rs == RES_OK) {
                    $result['proResult'] = array("proFlg" => $rs, "message" => I0000002);
                } else {
                    $result['proResult'] = array("proFlg" => RES_NG, "message" => $rs);
                }
            } else {
                $result['proResult'] = array("proFlg" => RES_NG, "message" => E0000007);
            }
        }


        $this->return_json($result);
    }


    public function store_form_import()
    {
        $profile = $this->profile;
        if (!check_ACL($profile, 'store', 'im_customer_survey')) {
            return $this->load->view('errors/html/error_permission_denied');
        }
        $this->load->view('survey/store_form_import');
    }

    public function store_start_import()
    {
        set_time_limit(0);
        $data['returnCd'] = NULL;
        $data['returnMsg'] = NULL;
        $data['proResult'] = array("proFlg" => RES_NG, "message" => "");
        $profile = $this->profile;
        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'store', 'im_customer_survey')) {
            if (isset($_FILES['file']['tmp_name'])) {
                $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
                $this->load->library('FileManagement');
                $this->load->model('store_survey_model');

                $filePath = $this->filemanagement->saveFileImport("store", $_FILES['file']['tmp_name'], $ext);

                $import = $this->store_survey_model->import($filePath, $_FILES['file']['name']);
                if ($import == RES_OK) {
                    $data['proResult'] = array("proFlg" => $import, "message" => I0000008);
                } else {
                    $data['proResult'] = array("proFlg" => RES_NG, "message" => $import);
                }
            }
        }
        $this->return_json($data);
    }

    public function store_view_salesman($store_id = 0, $token = '')
    {
        $data = array();
        $profile = $this->profile;
        $data['profile'] = $profile;

        if (!check_ACL($profile, 'store', 'manage_customer_survey')) {
            return $this->load->view('errors/html/error_permission_denied', $data);
        }

        $data['store_id'] = $store_id;
        $data['token'] = $token;
        $this->load->view('survey/store_view_salesman', $data);
    }

    public function store_get_salesman() {
        $data['returnCd'] = NULL;
        $data['returnMsg'] = NULL;
        $data['data'] = NULL;
        $profile = $this->profile;

        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'store', 'manage_customer_survey')) {
            $input_data = json_decode(trim(file_get_contents('php://input')), true);
            $input_data['curr_user'] = $profile;

            $this->load->model('salesman_store_survey_model');
            $data['data'] = $this->salesman_store_survey_model->getSalesmanByStore($input_data);
        }
        $this->return_json($data);
    }
    /*Manage customers tab - END*/


    /*Overview tab - BEGIN*/
    public function overview()
    {
        $profile = $this->profile;
        if (!check_ACL($profile, 'store', 'overview')) {
            $this->load->helper('url');
            redirect('/');
        }

        $data['profile'] = $profile;
        $this->load->view('survey/overview', $data);
    }

    public function overview_search() {
        $data['returnCd'] = NULL;
        $data['returnMsg'] = NULL;
        $data['resultSearch'] = array();
        $profile = $this->profile;

        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'store', 'overview')) {
            $param = json_decode(trim(file_get_contents('php://input')), true);
            $param['curr_user'] = $profile;

            $this->load->model('survey_model');
            $resultSearch = $this->survey_model->surveyOverview($param);

            if (count($resultSearch['salInfo']) > 0) {
                foreach($resultSearch['salInfo'] as $key=>$value) {



                    $resultSearch['salInfo'][$key]['survey_overview'] = array();
                }

            }

            $data['resultSearch'] = $resultSearch;
        }
        $this->return_json($data);
    }
    /*Overview tab - END*/
}
