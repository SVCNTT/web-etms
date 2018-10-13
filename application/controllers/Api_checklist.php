<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_checklist extends MY_Controller {

    public function __construct() {
        parent::__construct();

    }

    public function saveChecklist() {
        $result = array(
            'returnCd'              =>  NULL,
            'returnMsg'             =>  NULL,
            'proResFlg'             =>  RES_NG
        );

        if ($this->input->method(TRUE) === 'POST') {
            $this->load->model('event_model');

            /*Get params - Begin*/
            $post = $this->input->post(NULL, TRUE);
            $post = isset($post['paramJson']) ? json_decode($post['paramJson'], true) : array();

            $checklistId = isset($post['checklistId']) ? $post['checklistId'] : NULL;
            $salesmanId = isset($post['salesmanId']) ? $post['salesmanId'] : NULL;
            $userId = isset($post['userId']) ? $post['userId'] : NULL;
            $listDoctors = isset($post['listDoctors']) ? $post['listDoctors'] : NULL;

            if ($checklistId !== NULL && ($salesmanId !== NULL || $userId !== NULL) && $listDoctors !== NULL) {
                if($this->event_model->insertEvent($checklistId, $salesmanId, $userId, $listDoctors)) {
                    $result['proResFlg'] = RES_OK;
                }
            }
			
        }
        return $this->return_json($result);
    }

    public function getListChecklist() {
        $result = array(
            'returnCd'              =>  NULL,
            'returnMsg'             =>  NULL,
            'proResFlg'             =>  RES_NG,
        );

        if ($this->input->method(TRUE) === 'POST') {
            $this->load->model('checklist_model');

            /*Get params - Begin*/
            $post = $this->input->post(NULL, TRUE);
            $post = isset($post['paramJson']) ? json_decode($post['paramJson'], true) : array();
            $salesmanId = isset($post['salesmanId']) ? $post['salesmanId']  : NULL;
            if ($salesmanId !== NULL) {
                $listCoaching = $this->checklist_model->getListChecklistBySalesman($salesmanId);
            } else {
                $userId = isset($post['userId']) ? $post['userId']  : NULL;
                if ($userId !== NULL) {
                    $listCoaching = $this->checklist_model->getListChecklistByUser($userId);
                }
            }

            $result['listChecklist'] = $listCoaching;
            $result['returnMsg'] = null;
            $result['proResFlg'] = RES_OK;
            $result['token'] = "dms";
        }
        return $this->return_json($result);
    }
}
