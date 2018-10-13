<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Call_record extends MY_Controller {

    public function __construct() {
        parent::__construct();

        /*Authentication - Begin*/
        $this->check_auth = $this->check_login();
        /*Authentication - End*/
    }

    public function index() {
        $profile = $this->profile;
        if (!check_ACL($profile, 'rec', 'menu')) {
            $this->load->helper('url');
            redirect('/');
        }

        // Layout library loaded site wide
        $this->set_layout();
        $this->layout->title( REC0100_TITLE.' | Strikeforce');

        $data = array();

        //Set data for layout
        $data['index'] = 'rec';
        $data['html_module'] = 'rec0100Module';
        $data['body_id'] = '';
        $data['body_module'] = 'REC0100Ctrl';
        $data['body_ngInit'] = 'init()';
        $data['body_cssClass'] = 'REC0100';
        $this->set_data_for_layout($data);
        $this->layout->view('call_record/index', $data);
    }

    public function report() {
        $profile = $this->profile;
        if (!check_ACL($profile, 'rec', 'report')) {
            $this->load->helper('url');
            redirect('/');
        }

        $data['profile'] = $profile;
        $this->load->view('call_record/report', $data);
    }

    public function config() {
        $profile = $this->profile;
        if (!check_ACL($profile, 'rec', 'config')) {
            $this->load->helper('url');
            redirect('/');
        }
        $this->load->view('call_record/config');
    }

    public function get_data_config() {
        $result = array(
            'resultSearch'  =>  array(
                'productGroup'  =>  array()
            ),
            'returnCd'      =>  NULL,
            'returnMsg'     =>  NULL,
        );

        $profile = $this->profile;

        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'rec', 'config')) {
            /*Get search param*/
            $input_data = json_decode(trim(file_get_contents('php://input')), true);

            /*Get paging param*/
            $paging_input = isset($input_data['pagingInfo']) ? $input_data['pagingInfo'] : array();
            $crtPage = isset($paging_input['crtPage']) ? $paging_input['crtPage'] : 1;
            if ($crtPage < 1) {
                $crtPage = 1;
            }

            $this->load->model('product_group_model');

            /*Paging - Begin*/
            $ttlRow = $this->product_group_model->countProductGroupByName($input_data);
            $pagingInfo = $this->product_group_model->setPagingInfo($ttlRow, $crtPage);;
            /*Paging - End*/

            if ($ttlRow > 0) {
                $offset = ( $pagingInfo['crtPage'] - 1) * ROW_ON_PAGE;
                $input_data['limit'] = ROW_ON_PAGE;
                $input_data['offset'] = $offset;

                $product_group_list = $this->product_group_model->searchProductGroupByName($input_data);
                $resultSearch['productGroup'] = $product_group_list;
            }

            $resultSearch['pagingInfo'] = $pagingInfo;
            $result['resultSearch'] = $resultSearch;
        }

        return $this->return_json($result);
    }

    public function getQuestion() {
        $result = array(
            'resultSearch'  =>  array(
                'questions'  =>  array()
            ),
            'returnCd'      =>  NULL,
            'returnMsg'     =>  NULL,
        );

        $profile = $this->profile;

        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'rec', 'config')) {
            /*Get search param*/
            $input_data = json_decode(trim(file_get_contents('php://input')), true);
            $product_group_id = isset($input_data['product_group_id']) ? $input_data['product_group_id'] : 0;

            $this->load->model('product_group_question_model');
            $product_group = $this->product_group_question_model->getQuestionByProductGroup($product_group_id);

            $result['resultSearch']['questions'] = isset($product_group['question']) ? json_decode($product_group['question'], true) : array();
        }

        return $this->return_json($result);
    }

    public function saveQuestion() {
        $result = array(
            'returnCd'  =>  NULL,
            'returnMsg' =>  NULL,
            'proResult' =>  array(
                'proFlg'    =>  RES_NG,
                'message'   =>  E0000002
            ),
            'message'   =>  NULL
        );

        $profile = $this->profile;

        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'rec', 'config')) {
            /*Get search param*/
            $input_data = json_decode(trim(file_get_contents('php://input')), true);

            $product_group_id = isset($input_data['product_group_id']) ? $input_data['product_group_id'] : 0;
            $questions = isset($input_data['questions']) ? $input_data['questions'] : array();

            /*Check empty question - Begin*/
            if (!empty($questions)) {
                foreach($questions as $item) {
                    $qt = trim($item['question']);
                    if (empty($qt)) {
                        $result['proResult']['message'] = E0000029;
                        return $this->return_json($result);
                    }
                }
            }
            /*Check empty question - End*/

            $this->load->model('product_group_question_model');

            /*Delete old record - Begin*/
            $this->product_group_question_model->deleteQuestion($product_group_id);
            /*Delete old record - End*/

            /*Add new record - Begin*/
            $func_id = 'REC0330';
            $curr_user_id = isset($profile['user_id']) ? $profile['user_id'] : 0;
            $ts = date('Y:m:d H:i:s');
            $data_add = array(
                'product_group_id'  =>  $product_group_id,
                'question'          =>  json_encode($questions),
                'cre_func_id'       =>  $func_id,
                'cre_user_id'       =>  $curr_user_id,
                'cre_ts'            =>  $ts,
                'mod_func_id'       =>  $func_id,
                'mod_user_id'       =>  $curr_user_id,
                'mod_ts'            =>  $ts
            );

            $rs = $this->product_group_question_model->addQuestion($data_add);
            /*Add new record - End*/

            if ($rs > 0) {
                $result['proResult']['proFlg'] = RES_OK;
                $result['proResult']['message'] = I0000002;
            }
        }

        return $this->return_json($result);
    }

    public function initData() {
        $result = array(
            'resultInit'  =>  array(
                'mr'        =>  array(),
                'store'     =>  array(),
                'product_group' => array(),
                'validate'  =>  array()
            ),
            'returnCd'      =>  NULL,
            'returnMsg'     =>  NULL,
        );

        $profile = $this->profile;

        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'rec', 'report')) {
            $this->load->model('saleman_model');
            $this->load->model('store_model');
            $this->load->model('product_group_model');

            /*Get MR - Begin*/
            $mr = $this->saleman_model->selectMRByRole($profile);
            $result['resultInit']['mr'] = $mr;
            /*Get MR - End*/

            /*Get store - Begin*/
            if (!empty($mr)) {
                $result['resultInit']['store'] = $this->store_model->selectStoreByRole($profile);
                array_unshift($result['resultInit']['store'], array('store_id'=>NULL, 'store_name'=>'All'));
            }
            /*Get store - End*/

            /*Get product group - Begin*/
            if (!empty($mr)) {
                $result['resultInit']['product_group'] = $this->product_group_model->getProductGroupByRole($profile);
                array_unshift($result['resultInit']['product_group'], array('product_group_id'=>NULL, 'product_group_name'=>'All'));
            }
            /*Get product group - End*/

            /*Get validate - Begin*/
            $result['resultInit']['validate'] = array(
                array('validate_id'=>NULL, 'validate_name'=>'All'),
                array('validate_id'=>0, 'validate_name'=>'No'),
                array('validate_id'=>1, 'validate_name'=>'Yes')
            );
            /*Get validate - End*/

            /*Add all salesman*/
            array_unshift($result['resultInit']['mr'], array('salesman_id'=>NULL, 'salesman_name'=>'All'));
        }

        return $this->return_json($result);
    }

    public function searchData() {
        $result = array(
            'resultSearch'  =>  array(
                'callRecord'    =>  array()
            ),
            'returnCd'      =>  NULL,
            'returnMsg'     =>  NULL,
        );

        $profile = $this->profile;

        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'rec', 'report')) {
            /*Get search param*/
            $input_data = json_decode(trim(file_get_contents('php://input')), true);
            $input_data['curr_user'] = $profile;

            /*Get paging param*/
            $paging_input = isset($input_data['pagingInfo']) ? $input_data['pagingInfo'] : array();
            $crtPage = isset($paging_input['crtPage']) ? $paging_input['crtPage'] : 1;
            if ($crtPage < 1) {
                $crtPage = 1;
            }

            $this->load->model('call_record_model');

            /*Paging - Begin*/
            $ttlRow = $this->call_record_model->countSearchCallRecord($input_data);
            $pagingInfo = $this->call_record_model->setPagingInfo($ttlRow, $crtPage);;
            /*Paging - End*/

            $call_record_list = array();
            if ($ttlRow > 0) {
                $offset = ( $pagingInfo['crtPage'] - 1) * ROW_ON_PAGE;
                $input_data['limit'] = ROW_ON_PAGE;
                $input_data['offset'] = $offset;

                $call_record_list = $this->call_record_model->searchCallRecord($input_data);

                if (!empty($call_record_list)) {
                    /*Get all salesman - Begin*/
                    $this->load->model('saleman_model');
                    $mr = $this->saleman_model->selectMRByRole($profile);
                    $mr_temp = array();
                    foreach($mr as $item) {
                        $mr_temp[$item['salesman_id']] = $item;
                    }
                    $mr = $mr_temp;
                    /*Get all salesman - End*/

                    /*Get all store - Begin*/
                    $this->load->model('store_model');
                    $stores = $this->store_model->selectStoreByRoleForMapping($profile);
                    /*Get all store - End*/

                    /*Get all product group - Begin*/
                    $this->load->model('product_group_model');
                    $product_groups = $this->product_group_model->selectAll();
                    $product_groups_temp = array();
                    foreach($product_groups as $item) {
                        $product_groups_temp[$item['product_group_id']] = $item;
                    }
                    $product_groups = $product_groups_temp;
                    /*Get all product group - End*/

                    foreach($call_record_list as $key=>$item) {
                        /*General token*/
                        $call_record_list[$key]['token'] = $this->create_md5('REC_DETAIL'.$item['call_record_id']);

                        $call_record_list[$key]['mr_name'] = isset($mr[$item['salesman_id']]['salesman_name']) ? $mr[$item['salesman_id']]['salesman_name'] : '';

                        $call_record_list[$key]['store_name'] = isset($stores[$item['store_id']]['store_name']) ? $stores[$item['store_id']]['store_name'] : '';

                        $call_record_list[$key]['product_group_name'] = '';
                        $list_product_group_id = json_decode($item['product_group_id'], true);
                        foreach($list_product_group_id as $pg_item) {
                            if (isset($product_groups[$pg_item]))
                            $call_record_list[$key]['product_group_name'] .= $product_groups[$pg_item]['product_group_name'].', ';
                        }
                        $call_record_list[$key]['product_group_name'] = trim($call_record_list[$key]['product_group_name'], ', ');

                        $call_record_list[$key]['validate_name'] = $item['validate'] == 0 ? REC0230_ANSWER_NO : REC0230_ANSWER_YES;
                    }
                }
            }

            $resultSearch['callRecord'] = $call_record_list;
            $resultSearch['pagingInfo'] = $pagingInfo;
            $result['resultSearch'] = $resultSearch;
        }

        return $this->return_json($result);
    }

    public function detail($id, $token) {
        $profile = $this->profile;
        if (!check_ACL($profile, 'rec', 'report')) {
            $this->load->helper('url');
            redirect('/');
        }

        /*Check token*/
        $tk_temp = $this->create_md5('REC_DETAIL'.$id);

        if ($tk_temp !== $token) {
            $this->load->helper('url');
            redirect('/');
        }

        // Layout library loaded site wide
        $this->set_layout();
        $this->layout->title( REC0230_TITLE.' | Strikeforce');

        $data = array();

        //Set data for layout
        $data['index'] = 'rec';
        $data['html_module'] = 'rec0100Module';
        $data['body_id'] = '';
        $data['body_module'] = 'REC0230Ctrl';
        $data['body_ngInit'] = 'init()';
        $data['body_cssClass'] = 'REC0230';

        $data['call_record_id'] = $id;
        $data['token'] = $token;

        $this->set_data_for_layout($data);
        $this->layout->view('call_record/detail', $data);
    }

    public function get_detail() {
        $result = array(
            'resultGet'  =>  array(
                'callRecord'    =>  array()
            ),
            'returnCd'      =>  NULL,
            'returnMsg'     =>  NULL,
        );

        $profile = $this->profile;

        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'rec', 'report')) {
            /*Get search param*/
            $param = json_decode(trim(file_get_contents('php://input')), true);
            $id = isset($param['call_record_id']) ? intval($param['call_record_id']) : -1;
            $token = isset($param['token']) ? $param['token'] : '';

            /*Check token*/
            $tk_temp = $this->create_md5('REC_DETAIL'.$id);

            if ($tk_temp === $token) {
                $this->load->model('call_record_model');
                $record = $this->call_record_model->getById($id);

                if (!empty($record)) {
                    /*Get all salesman - Begin*/
                    $this->load->model('saleman_model');
                    $mr = $this->saleman_model->selectMRByRole($profile);
                    $mr_temp = array();
                    foreach($mr as $item) {
                        $mr_temp[$item['salesman_id']] = $item;
                    }
                    $mr = $mr_temp;
                    /*Get all salesman - End*/

                    /*Get all store - Begin*/
                    $this->load->model('store_model');
                    $stores = $this->store_model->selectStoreByRoleForMapping($profile);
                    /*Get all store - End*/

                    /*Get all product group - Begin*/
                    $this->load->model('product_group_model');
                    $product_groups = $this->product_group_model->selectAll();
                    $product_groups_temp = array();
                    foreach($product_groups as $item) {
                        $product_groups_temp[$item['product_group_id']] = $item;
                    }
                    $product_groups = $product_groups_temp;
                    /*Get all product group - End*/


                    $record['mr_name'] = isset($mr[$record['salesman_id']]['salesman_name']) ? $mr[$record['salesman_id']]['salesman_name'] : '';

                    $record['store_name'] = isset($stores[$record['store_id']]['store_name']) ? $stores[$record['store_id']]['store_name'] : '';
                    $record['store_class'] = isset($stores[$record['store_id']]['class']) ? $stores[$record['store_id']]['class'] : '';

                    $record['product_group_name'] = '';
                        $list_product_group_id = json_decode($record['product_group_id'], true);
                        foreach($list_product_group_id as $pg_item) {
                            if (isset($product_groups[$pg_item]))
                                $record['product_group_name'] .= $product_groups[$pg_item]['product_group_name'].', ';
                        }
                    $record['product_group_name'] = trim($record['product_group_name'], ', ');

                    $record['validate_name'] = $record['validate'] == 0 ? REC0230_ANSWER_NO : REC0230_ANSWER_YES;

                    /*Get detail - Begin*/
                    $table = 'call_record_detail_'.($record['call_record_id']%16);
                    $record['detail'] = $this->call_record_model->getDetail($table, $record['call_record_id']);
                    $record['detail']['note'] = isset($record['detail']['note']) ? json_decode($record['detail']['note'], true) : array();
                    $record['detail']['answer'] = isset($record['detail']['answer']) ? json_decode($record['detail']['answer'], true) : array();
                    if (!empty($record['detail']['answer'])) {
                        foreach($record['detail']['answer'] as $key=>$item) {
                            if (isset($product_groups[$item['id']])) {
                                $record['detail']['answer'][$key]['name'] = $product_groups[$item['id']]['product_group_name'];
                            }
                        }
                    }
                    /*Get detail - End*/
                }

                $result['resultGet']['callRecord'] = $record;
            }
        }

        return $this->return_json($result);
    }

    public function delete_record() {
        $result = array(
            'returnCd'  =>  NULL,
            'returnMsg' =>  NULL,
            'proResult' =>  array(
                'proFlg'    =>  RES_NG,
                'message'   =>  E0000002
            ),
            'message'   =>  NULL
        );

        $profile = $this->profile;

        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'rec', 'delete')) {
            /*Get search param*/
            $input_data = json_decode(trim(file_get_contents('php://input')), true);

            $id = isset($input_data['id']) ? $input_data['id'] : 0;
            $token = isset($input_data['token']) ? $input_data['token'] : '';

            /*Check token - Begin*/
            $tk_temp = $this->create_md5('REC_DETAIL'.$id);

            if ($tk_temp === $token) {
                /*Check token - End*/

                $this->load->model('call_record_model');

                /*Delete record - Begin*/
                $func_id = 'REC0240';
                $curr_user_id = isset($profile['user_id']) ? $profile['user_id'] : 0;
                $data = array(
                    'del_flg'   =>  1,
                    'mod_func_id'   =>  $func_id,
                    'mod_ts'        =>  date('Y-m-d H:i:s'),
                    'mod_user_id'   =>  $curr_user_id
                );

                $rs = $this->call_record_model->deleteRecord($id, $data);
                /*Delete record - End*/

                if ($rs > 0) {
                    $result['proResult']['proFlg'] = RES_OK;
                    $result['proResult']['message'] = I0000002;
                }
            }
        }

        return $this->return_json($result);
    }

    public function statictis() {

        $data['profile'] = $this->profile;
        $this->load->view('call_record/statictis', $data);
    }

    public function initStatictisData() {

        $data['returnCd'] = NULL;
        $data['returnMsg'] = NULL;
        $data['initData'] = [];
        $profile = $this->profile;

        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'dashboard', 'menu')) {

            $params = json_decode(trim(file_get_contents('php://input')), true);

            $this->load->model('product_type_mst_model');
            $this->load->model('call_record_model');

            $productTypeList = $this->product_type_mst_model->proTypeResultDto($params);
            $dataFilter["productTypeList"] = $productTypeList;
            $data['initData'] =  $dataFilter;

            $startDate = isset($params['startDate']) ? new DateTime(($params['startDate']))
                : new DateTime('Monday this week');
            $endDate = isset($params['endDate']) ? new DateTime(($params['endDate']))
                : new DateTime('Sunday this week');

            $initDate = $this->createDateRangeArray($startDate, $endDate);//1437930000
            $callRecordList = array();

            if(isset($strDateTo) && $strDateTo !== NULL) {
                $endDate = new DateTime($strDateTo);
            }

            $params['curr_user'] = $profile;
            if ($startDate === NULL && $endDate === NULL) {
                $callRecordsData = $this->call_record_model->getCallRecordByWeek($params);
            } else {
                $callRecordsData = $this->call_record_model->getCallRecordByDate($startDate->format('Y-m-d'), $endDate->format('Y-m-d'), $params);
            }

            if($productTypeList !== NULL) {
                foreach($productTypeList as $productType) {
                    $callRecordsInDay = array('id'=>$productType['productTypeId'],
                        'name'=>$productType['productTypeName'],
                        'data'=> $initDate);
                    foreach($callRecordsData as $callRecord) {
                        if($callRecord['productTypeId'] === $callRecordsInDay['id']) {
                            for($i = 0; $i<count($callRecordsInDay['data']); $i++) {
                                if ($callRecordsInDay['data'][$i][0] === (new DateTime($callRecord['createdDate']))->getTimestamp()*1000) {
                                    $callRecordsInDay['data'][$i][1] = (int)$callRecord['total'];
                                }
                            }
                        }
                    }
                    array_push($callRecordList, $callRecordsInDay);
                }
            }
            $data['callRecords'] = $callRecordList;
        }
        $this->return_json($data);
    }

    function createDateRangeArray($startDate, $endDate) {

        $period = new DatePeriod(
            $startDate,
            new DateInterval('P1D'),
            $endDate
        );

        $rangeDates = array();

        foreach($period as $date){
            array_push($rangeDates, array($date->getTimestamp()*1000, 0));
        }
        return $rangeDates;
    }
}
