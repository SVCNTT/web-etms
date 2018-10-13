<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_survey extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getSurvey()
    {
        $result = array(
            'status' => API_STATUS_FAIL,
            'message' => API_MESSAGE_INVALID_METHOD,
            'data' => NULL
        );

        if ($this->input->method(TRUE) === 'POST') {

            /*Get params - Begin*/
            $post = $this->input->post(NULL, TRUE);
            $salesman_id = isset($post['salesman_id']) ? $post['salesman_id'] : 0;
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

                /*Get product list*/
                $this->load->model('store_survey_model');
                $product_list = $this->store_survey_model->getListProductIdBySalesmanId($salesman_id);
                /*Get product list - END*/

                /*Get survey list*/
                $survey_list = array();
                if (isset($product_list['list_product_id']) && $product_list['list_product_id'] != NULL) {
                    $this->load->model('survey_model');
                    $survey_list = $this->survey_model->getSurveyByListProductId($product_list['list_product_id']);
                }
                /*Get survey list - END*/

                /*Repair data*/
                if (!empty($survey_list)) {
                    foreach ($survey_list as $key => $item) {
                        $temp = array();
                        $temp['id'] = $item['id'];
                        $temp['name'] = $item['name'];
                        $temp['product'] = $item['product'];
                        $temp['questions'] = json_decode($item['questions'], TRUE);
                        $temp['mod_ts'] = $item['mod_ts'];
                        $survey_list[$key] = $temp;
                    }
                }
                /*Repair data - END*/

                $result['status'] = API_STATUS_SUCCESS;
                $result['message'] = API_MESSAGE_SUCCESS;
                $result['data'] = $survey_list;
            } else {
                $result['message'] = API_MESSAGE_INVALID;
                return $this->return_json($result);
            }
        }

        return $this->return_json($result);
    }


    public function getCustomer()
    {
        $result = array(
            'status' => API_STATUS_FAIL,
            'message' => API_MESSAGE_INVALID_METHOD,
            'data' => NULL
        );

        if ($this->input->method(TRUE) === 'POST') {

            /*Get params - Begin*/
            $post = $this->input->post(NULL, TRUE);
            $salesman_id = isset($post['salesman_id']) ? $post['salesman_id'] : 0;
            $survey_id = isset($post['survey_id']) ? $post['survey_id'] : 0;
            $status = isset($post['status']) ? $post['status'] : SURVEY_CUSTOMER_ALL;

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


            if (!empty($salesman_id) && !empty($survey_id)) {

                /*Get customer list*/
                $this->load->model('store_survey_model');
                $store_list = $this->store_survey_model->getCustomverBySurvey($salesman_id, $survey_id, $status);
                /*Get customer list - END*/

                $result['status'] = API_STATUS_SUCCESS;
                $result['message'] = API_MESSAGE_SUCCESS;
                $result['data'] = $store_list;
            } else {
                $result['message'] = API_MESSAGE_INVALID;
                return $this->return_json($result);
            }
        }

        return $this->return_json($result);
    }


    public function saveSurvey()
    {
        $result = array(
            'status' => API_STATUS_FAIL,
            'message' => API_MESSAGE_INVALID_METHOD,
        );

        if ($this->input->method(TRUE) === 'POST') {

            /*Get params - Begin*/
            $post = $this->input->post(NULL, TRUE);
            $salesman_id = isset($post['salesman_id']) ? $post['salesman_id'] : 0;
            $salesman_code = isset($post['salesman_code']) ? $post['salesman_code'] : '';
            $store_id = isset($post['store_id']) ? $post['store_id'] : 0;
            $store_code = isset($post['store_code']) ? $post['store_code'] : '';
            $survey_id = isset($post['survey_id']) ? $post['survey_id'] : 0;
            $data = isset($post['data']) ? $post['data'] : array();
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


            if (!empty($survey_id) && !empty($salesman_id) && !empty($store_id)) {

                /*Save survey*/
                $this->load->model('survey_model');
                $input = array(
                    'salesman_id' => $salesman_id,
                    'salesman_code' => $salesman_code,
                    'store_id' => $store_id,
                    'store_code' => $store_code,
                    'answer' => $data,
                    'cre_func_id' => 'SMF0000',
                    'cre_ts' => date('Y-m-d H:i:s'),
                    'cre_user_id' => $salesman_id,
                    'mod_func_id' => 'SMF0000',
                    'mod_ts' => date('Y-m-d H:i:s'),
                    'mod_user_id' => $salesman_id,
                    'version_no' => 1,
                    'del_flg' => 0,
                );
                $rs = $this->survey_model->saveSurvey($survey_id, $input);
                /*Save survey - END*/

                if ($rs) {
                    $result['status'] = API_STATUS_SUCCESS;
                    $result['message'] = API_MESSAGE_SUCCESS;
                } else {
                    $result['message'] = API_MESSAGE_UNSUCCESS;
                }
            } else {
                $result['message'] = API_MESSAGE_INVALID;
                return $this->return_json($result);
            }
        }

        return $this->return_json($result);
    }


    public function detailSurvey()
    {
        $result = array(
            'status' => API_STATUS_FAIL,
            'message' => API_MESSAGE_INVALID_METHOD,
            'data' => array()
        );

        if ($this->input->method(TRUE) === 'POST') {

            /*Get params - Begin*/
            $post = $this->input->post(NULL, TRUE);
            $salesman_id = isset($post['salesman_id']) ? $post['salesman_id'] : 0;
            $store_id = isset($post['store_id']) ? $post['store_id'] : 0;
            $survey_id = isset($post['survey_id']) ? $post['survey_id'] : 0;

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


            if (!empty($survey_id) && !empty($salesman_id) && !empty($store_id)) {

                $this->load->model('survey_answer_model');
                $rs = $this->survey_answer_model->getDetail($survey_id, $salesman_id, $store_id);
                /*Save survey - END*/

                if ( ! empty($rs) ) {
                    $result['status'] = API_STATUS_SUCCESS;
                    $result['message'] = API_MESSAGE_SUCCESS;
                    $result['data'] = isset($rs['answer']) ? json_decode($rs['answer'], TRUE) : array();
                } else {
                    $result['message'] = API_MESSAGE_UNSUCCESS;
                }
            } else {
                $result['message'] = API_MESSAGE_INVALID;
                return $this->return_json($result);
            }
        }

        return $this->return_json($result);
    }
}
