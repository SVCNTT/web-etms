<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_coaching extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
		
    }


    public function getFormCoachingTemplate(){
        $result = array(
            'returnCd'              =>  NULL,
            'returnMsg'             =>  NULL,
            'proResFlg'             =>  RES_NG,
        );
        if ($this->input->method(TRUE) === 'POST') {
            $this->load->model('coaching_template_model');
            
            $listCoaching = $this->coaching_template_model->selectListCoachingTemplate();

            $result['listCoaching'] = $listCoaching;
            $result['returnMsg'] = null;
            $result['proResFlg'] = RES_OK;
            $result['token'] = "dms";
        }
        return $this->return_json($result);
    }

    public function getDetailListCoaching() {
        $result = array(
            'returnCd'              =>  NULL,
            'returnMsg'             =>  NULL,
            'proResFlg'             =>  RES_NG,
        );
        if ($this->input->method(TRUE) === 'POST') {
            $this->load->model('coaching_salesman_model');

            $post = $this->input->post(NULL, TRUE);
            $post = isset($post['paramJson']) ? json_decode($post['paramJson'], true) : array();

            $detailCoaching = $this->coaching_salesman_model->getDetailListCoaching($post);

            $result['listDetailCoaching'] = $detailCoaching;
            $result['returnMsg'] = null;
            $result['proResFlg'] = RES_OK;
            $result['token'] = "dms";
        }
        return $this->return_json($result);
    }


    public function saveCoachingSalesman()
    {
        $result = array(
            'returnCd'              =>  NULL,
            'returnMsg'             =>  NULL,
            'proResFlg'             =>  RES_NG,
            'coachingSalesmanId'    =>  NULL
        );

        if ($this->input->method(TRUE) === 'POST') {
            $this->load->model('coaching_salesman_model');

            /*Get params - Begin*/
            $post = $this->input->post(NULL, TRUE);
            $post = isset($post['paramJson']) ? json_decode($post['paramJson'], true) : array();
			
            $data['coaching_template_id'] = isset($post['coachingTemplateId']) ? $post['coachingTemplateId'] : NULL;
			$data['user_id'] = isset($post['userId']) ? $post['userId'] : NULL;
			$data['salesman_id'] = isset($post['salesmanId']) ? $post['salesmanId'] : NULL;
			$data['average_mark'] = isset($post['averageMark']) ? $post['averageMark'] : NULL;

            $data['target'] = isset($post['target']) ? $post['target'] : '';
            
			$data['need_approve'] = isset($post['needApprove']) ? $post['needApprove'] : '';
			$data['achievement'] = isset($post['achievement']) ? $post['achievement'] : '';
			$data['next_plan'] = isset($post['nextPlan']) ? $post['nextPlan'] : '';
            $stores = isset($post['stores']) ? $post['stores'] : NULL;
			$data['data'] = json_encode($post, true);
			
            if ( $data['coaching_template_id'] !== NULL && $data['user_id'] !== NULL && $data['salesman_id'] !== NULL && 
                $data['average_mark'] !== NULL) {
					 
                // Get coachings already done today
				$coaching_salesman = $this->coaching_salesman_model->getCoachingSalesman(array('coachingTemplateId'=>$data['coaching_template_id'],
																							   'userId'=>$data['user_id'],
                    'salesmanId' => $data['salesman_id'],
                    'createDate' => date('Y-m-d')
                    ));

                // Check if user has already done the coaching
				if( $coaching_salesman  !== NULL &&  !empty($coaching_salesman)){
					$coaching_salesman_id = $coaching_salesman[0]['coachingSalesmanId'];
					$data['update_date'] = date('Y-m-d H:i:s');
                    $rs = $this->coaching_salesman_model->update($coaching_salesman_id, $data, $stores);

                    if ($rs) {
					$result['proResFlg'] = RES_OK;
                    $result['coachingSalesmanId'] = $coaching_salesman_id;
                    }

				} else{
					//insert					
					$data['create_date'] = date('Y-m-d H:i:s');	
					$data['update_date'] = date('Y-m-d H:i:s');
                    $id = $this->coaching_salesman_model->insert($data, $stores);

					if($id > 0){
						$result['proResFlg'] = RES_OK;
                        $result['coachingSalesmanId'] = $id;
					}
				} 				
            } 
			
        }
        return $this->return_json($result);
    }
	
    public function getListCoaching()
    {
        $result = array(
            'returnCd'              =>  NULL,
            'returnMsg'             =>  NULL,
            'proResFlg'             =>  RES_NG,
        );

        if ($this->input->method(TRUE) === 'POST') {
            $this->load->model('coaching_salesman_model');

            /*Get params - Begin*/
            $post = $this->input->post(NULL, TRUE);
            $post = isset($post['paramJson']) ? json_decode($post['paramJson'], true) : array();
            $salesmanId = isset($post['salesmanId']) ? $post['salesmanId']  : '';

            $listCoaching = $this->coaching_salesman_model->getListCoachingBySalesman(array('salesmanId'=>$salesmanId));
            $result['listCoaching'] = $listCoaching;
            $result['returnMsg'] = null;
            $result['proResFlg'] = RES_OK;
            $result['token'] = "dms";
        }
        return $this->return_json($result);
    }
    public function deleleCoachingSalesman() {
        $result = array(
            'returnCd'              =>  NULL,
            'returnMsg'             =>  NULL,
            'proResFlg'             =>  RES_NG,
        );

        if ($this->input->method(TRUE) === 'POST') {
            $this->load->model('coaching_salesman_model');

            /*Get params - Begin*/
            $post = $this->input->post(NULL, TRUE);
            $post = isset($post['paramJson']) ? json_decode($post['paramJson'], true) : array();
            $coachingSalesmanId = isset($post['coachingSalesmanId']) ? $post['coachingSalesmanId']  : '';
            $status = $this->coaching_salesman_model->deleleCoachingSalesman($coachingSalesmanId);
            $result['status'] = $status;
            $result['returnMsg'] = RES_OK;
            $result['proResFlg'] = RES_OK;
            $result['token'] = "dms";
        }
        return $this->return_json($result);
    }

}
