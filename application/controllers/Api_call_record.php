<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_call_record extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function saveCallRecord()
    {
        $result = array(
            'returnCd'      =>  NULL,
            'returnMsg'     =>  NULL,
            'serverTime'	=>  (new DateTime())->getTimestamp()* 1000,
            'proResFlg'     =>  RES_NG,
        );

        if ($this->input->method(TRUE) === 'POST') {

            /*Get params - Begin*/
            $post = $this->input->post(NULL, TRUE);
            $post = isset($post['paramJson']) ? json_decode($post['paramJson'], true) : array();

            $this->load->model('call_record_model');

            $func_id = 'SMF0000';
            $time = isset($post['time']) ? $post['time'] : time();
            $salesman_id = isset($post['salesmanId']) ? $post['salesmanId'] : -1;
            $mr_feedback = isset($post['mrFeedback']) ? $post['mrFeedback'] : '';
            $customer_feedback = isset($post['customerFeedback']) ? $post['customerFeedback'] : '';
            $competitor = isset($post['competitor']) ? $post['competitor'] : '';
            $competitor_activity = isset($post['competitorActivity']) ? $post['competitorActivity'] : array();
            $list_product_group = isset($post['listProductGroup']) ? $post['listProductGroup'] : array();
            $list_product_group_id = array();
            foreach($list_product_group as $item) {
                $list_product_group_id[] = $item['id'];
            }

            $cr_data = array();
            $cr_data['salesman_id'] = $salesman_id;
            $cr_data['store_id'] = isset($post['storeId']) ? $post['storeId'] : -1;
            $cr_data['validate'] = isset($post['validate']) ? $post['validate'] : -1;
            $cr_data['product_group_id'] = json_encode($list_product_group_id);
            $cr_data['mod_func_id'] = $func_id;
            $cr_data['mod_ts'] = date('Y-m-d H:i:s');
            $cr_data['mod_user_id'] = $salesman_id;
            $cr_data['del_flg'] = DEL_FLAG_0;
            $cr_data['version_no'] = DEFAULT_VERSION_NO;

            /*Check exist - Begin*/
            $cr = $this->call_record_model->checkExist($cr_data['salesman_id'], $cr_data['store_id'], $time);
            /*Check exist - End*/

            if ($cr == NULL) {
                /*Insert call record - Begin*/
                $cr_data['cre_func_id'] = $func_id;
                $cr_data['cre_ts'] = date('Y-m-d H:i:s', $time);
                $cr_data['cre_user_id'] = $salesman_id;
                $rs = $this->call_record_model->insert($cr_data);

                if ($rs) {  //Insert call record successful
                    $table_index = $rs % 16;
                    $table = 'call_record_detail_'.$table_index;

                    $note = array(
                        'mr_feedback'       =>  $mr_feedback,
                        'customer_feedback' =>  $customer_feedback,
                        'competitor'        =>  $competitor,
                        'competitor_activity'   =>  $competitor_activity
                    );

                    $detail_data = array();
                    $detail_data['call_record_id'] = $rs;
                    $detail_data['note'] = json_encode($note);
                    $detail_data['answer'] = json_encode($list_product_group);
                    $detail_data['cre_func_id'] = $func_id;
                        $detail_data['cre_ts'] = date('Y-m-d H:i:s', $time);
                    $detail_data['cre_user_id'] = $salesman_id;
                    $detail_data['mod_func_id'] = $func_id;
                        $detail_data['mod_ts'] = date('Y-m-d H:i:s');
                    $detail_data['mod_user_id'] = $salesman_id;
                    $detail_data['del_flg'] = DEL_FLAG_0;
                    $detail_data['version_no'] = DEFAULT_VERSION_NO;

                    $this->call_record_model->insertDetail($table, $detail_data);

                    $result['proResFlg'] = RES_OK;
                }
                /*Insert call record - End*/
            } else {
                /*Update call record - Begin*/
                $cr_data['version_no'] = $cr['version_no'] + 1;
                $rs = $this->call_record_model->update($cr['call_record_id'], $cr_data);

                if ($rs) {  //Update call record successful
                    $table_index = $cr['call_record_id'] % 16;
                    $table = 'call_record_detail_' . $table_index;

                    $note = array(
                        'mr_feedback' => $mr_feedback,
                        'customer_feedback' => $customer_feedback,
                        'competitor' => $competitor,
                        'competitor_activity' => $competitor_activity
                    );

                    $detail_data = array();
                    $detail_data['call_record_id'] = $cr['call_record_id'];
                    $detail_data['note'] = json_encode($note);
                    $detail_data['answer'] = json_encode($list_product_group);
                    $detail_data['mod_func_id'] = $func_id;
                    $detail_data['mod_ts'] = date('Y-m-d H:i:s');
                    $detail_data['mod_user_id'] = $salesman_id;
                    $detail_data['del_flg'] = DEL_FLAG_0;
                    $detail_data['version_no'] = $cr['version_no'] + 1;

                    $this->call_record_model->updateDetail($table, $cr['call_record_id'], $detail_data);

                    $result['proResFlg'] = RES_OK;
                }

                /*Update call record - End*/
            }
        }
        return $this->return_json($result);
    }

    public function summaryCallRecord()
    {

        $result = array(
            'status' => API_STATUS_FAIL,
            'message' => API_MESSAGE_UNSUCCESS,
            'data' => NULL
        );

        if ($this->input->method(TRUE) === 'POST') {

            /*Get params - Begin*/
            $post = $this->input->post(NULL, TRUE);
            $salesman_id = isset($post['salesman_id']) ? $post['salesman_id'] : 0;
            $sub_leader_user_id = isset($post['sub_leader_user_id']) ? $post['sub_leader_user_id'] : 0;
//            var_dump($salesman_id);

            $this->load->library('common_api');

            /*Check sig*/
            if (!$this->common_api->checkSignature($post)) {
                $result['message'] = API_MESSAGE_ERROR_SIG;
                return $this->return_json($result);
            }
            /*Check sig - END*/

            /*Check timestamp*/
            if (!$this->common_api->checkTimestamp($post)) {
                $result['message'] = API_MESSAGE_EXPIRED;
                return $this->return_json($result);
            }
            /*Check timestamp - END*/


            if (!empty($salesman_id)) {
                $current_date = date('Y-m-d H:i:s');

                /*Get class by salesman*/
                $this->load->model('salesman_store_model');
                $classes = $this->salesman_store_model->getClassBySalesman($salesman_id);
//                var_dump($classes);exit;
                /*Get class by salesman - END*/


                /*Get call record by salesman*/
                $this->load->model('call_record_model');
                $call_records = $this->call_record_model->getMonthlyBySalesman($salesman_id, $current_date);
//                var_dump($call_records);exit;
                /*Get call record by salesman - END*/


                /*Get KPI*/
                $this->load->model('kpi_model');
                $kpi = $this->kpi_model->getBySubLeaderId($sub_leader_user_id, $current_date);
//                var_dump($kpi);exit;
                $kpi['A'] = isset($kpi['frequency_1']) ? $kpi['frequency_1'] : 0;
                $kpi['B'] = isset($kpi['frequency_2']) ? $kpi['frequency_2'] : 0;
                $kpi['C'] = isset($kpi['frequency_3']) ? $kpi['frequency_3'] : 0;
                /*Get KPI - END*/


                $data_group_by_class = array();
                if (!empty($call_records)) {
                    foreach ($call_records as $item) {
                        $class = isset($item['class']) ? $item['class'] : '';

                        if (!empty($class)) {
                            $data_group_by_class[$class][] = $item;
                        }
                    }
                }
//                var_dump($data);exit;


                $summary = array();
                $sum = 0;
                if (!empty($classes)) {
                    foreach ($classes as $v) {
                        $sum += isset($data_group_by_class[$v['class']]) ? count($data_group_by_class[$v['class']]) : 0;

                        $summary[] = array(
                            'class' => $v['class'],
                            'detail' => isset($data_group_by_class[$v['class']]) ? $data_group_by_class[$v['class']] : NULL,
                            'actual' => isset($data_group_by_class[$v['class']]) ? count($data_group_by_class[$v['class']]) : 0,
                            'target' => $kpi[$v['class']]
                        );
                    }
                }


                $result['status'] = API_STATUS_SUCCESS;
                $result['message'] = API_MESSAGE_SUCCESS;
                $result['data'] = array(
                    'sum' => $sum,
                    'data' => $summary
                );
            } else {
                $result['message'] = API_MESSAGE_INVALID;
                return $this->return_json($result);
            }
        }

        return $this->return_json($result);
    }
}
