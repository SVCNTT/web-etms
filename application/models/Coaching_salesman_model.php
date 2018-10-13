<?php

class Coaching_salesman_model extends MY_Model
{
    public $strikeforce;
    public function __construct()
    {
        $this->strikeforce = $this->load->database(DATABASE_NAME, TRUE);
    }
	
    /**
     * API coaching
     * @param $data
     * @param $stores
     * @return mixed
     */
	public function Insert($data, $stores)
	{
		$this->strikeforce->trans_start();
        $this->strikeforce->insert('coaching_salesman', $data);
        $insert_id = $this->strikeforce->insert_id();

        if ($insert_id > 0) {
            // Save store to of coaching

            if (isset($stores) && $stores) {
                foreach ($stores as $val){
                    $array_insert = array(
                        'coaching_id'       =>  $insert_id,
                        'store_id'          =>  $val['storeId']
                    );
                    $this->strikeforce->insert('coaching_store',$array_insert);
                }
            }
        }

        $this->strikeforce->trans_complete();
        return  $insert_id;
	}

    /**
     * API coaching
     * @param $coachingSalesmanId
     * @param $data
     * @param $stores
     * @return mixed
     */
	public function update($coachingSalesmanId, $data, $stores) {
        $this->strikeforce->trans_start();

        $result = $this->strikeforce->update('coaching_salesman', $data, array('coaching_salesman_id' => $coachingSalesmanId));

        // Delete old stores
        $this->strikeforce->delete('coaching_store', array('coaching_id' => $coachingSalesmanId));

        // Insert new stores
        if (isset($stores) && $stores) {
            foreach ($stores as $val){
                $array_insert = array(
                    'coaching_id'       =>  $coachingSalesmanId,
                    'store_id'          =>  $val['storeId']
                );
                $this->strikeforce->insert('coaching_store',$array_insert);
            }
        }

        $this->strikeforce->trans_complete();

        return $result;
    }

    public function deleleCoachingSalesman($coachingSalesmanId) 
    {
        $this->strikeforce->trans_start();
        $updateData=array("del_flg"=>1);
        $this->strikeforce->where("coaching_salesman_id",$coachingSalesmanId);
        $this->strikeforce->update("coaching_salesman",$updateData); 
        $this->strikeforce->trans_complete();
        return 0;
    }
	
    /**
     * API coaching
     * @param $arrParam
     * @return null
     */
	public function getCoachingSalesman($arrParam)
    {
		$coachingTemplateId = isset($arrParam['coachingTemplateId']) ? $arrParam['coachingTemplateId'] : NULL;
		$userId = isset($arrParam['userId']) ? $arrParam['userId'] : NULL;
		$salesmanId = isset($arrParam['salesmanId']) ? $arrParam['salesmanId'] : NULL;
		
        if ( $coachingTemplateId === NULL || $userId === NULL || $salesmanId === NULL) {
            return NULL;
        }
		
		
		$this->strikeforce->select('`coaching_salesman_id` as coachingSalesmanId, `coaching_template_id` as coachingTemplateId, `user_id` as userId, `salesman_id` as salesmanId, `average_mark` as averageMark, `need_approve` as needApprove, `achievement`, `next_plan` as nextPlan, `create_date` as createDate, `update_date` as updateDate, `data`');     
		$this->strikeforce->from('coaching_salesman');	
		$this->strikeforce->where('coaching_template_id', $coachingTemplateId);
		$this->strikeforce->where('user_id', $userId);
		$this->strikeforce->where('salesman_id', $salesmanId);
        if (isset($arrParam['createDate']) && $arrParam['createDate']) {
            $this->strikeforce->where("DATE_FORMAT(create_date,'%Y-%m-%d')" , $arrParam['createDate']);
        }
		$this->strikeforce->where('del_flg != 1');		
        $coachingSalesman = $this->strikeforce->get();
		
		if($coachingSalesman != FALSE)
		{
			return $coachingSalesman->result_array();
		} else {
			return NULL;
		}
    }
	
    /**
     * API coaching
     * @param $arrParam
     * @return array|null
     */
	public function getListCoachingBySalesman($arrParam)
    {
		$salesmanId = isset($arrParam['salesmanId']) ? $arrParam['salesmanId'] : NULL;
		
        if ( $salesmanId === NULL) {
            return NULL;
        }
		$result = array();
		$this->strikeforce->select('`coaching_salesman_id` as coachingSalesmanId, `coaching_template_id` as coachingTemplateId, `user_id` as userId, `salesman_id` as salesmanId, `average_mark` as averageMark, `need_approve` as needApprove, `achievement`, `next_plan` as nextPlan, `data`');     
		$this->strikeforce->from('coaching_salesman');	
		$this->strikeforce->where('salesman_id', $salesmanId);
		$this->strikeforce->where('del_flg != 1');		
        $listCoachingSalesman = $this->strikeforce->get();
		if($listCoachingSalesman != FALSE)
		{
			$listCoachingSalesman =  $listCoachingSalesman->result_array();			
			for($i=0; $i < count($listCoachingSalesman); $i++)
			{
				$result[$i]= json_decode($listCoachingSalesman[$i]['data'], true);
			}
			return $result;
			
		} else {
			return NULL;
		}
    }

    /**
     * API detail coaching
     * @param $arrParam
     * @return array|null
     */
    public function getDetailListCoaching($arrParam)
    {

        $salesmanId  = isset($arrParam['salesmanId']) ? $arrParam['salesmanId'] : NULL;
        $userId      = isset($arrParam['userId']) ? $arrParam['userId'] : NULL;
        $fromDate    = isset($arrParam['fromDate']) ? $arrParam['fromDate'] : NULL;
        $toDate      = isset($arrParam['toDate']) ? $arrParam['toDate'] : NULL;

        if ( $salesmanId === NULL && $userId === NULL) {
            return NULL;
        }
        $result = array();
        $this->strikeforce->select('`coaching_salesman_id` as coachingSalesmanId, `coaching_template_id` as coachingTemplateId, `user_id` as userId, `salesman_id` as salesmanId, `average_mark` as averageMark, `need_approve` as needApprove, `achievement`, `next_plan` as nextPlan, `data`');     
        $this->strikeforce->from('coaching_salesman');  
        if ($salesmanId != NULL) {
            $this->strikeforce->where('salesman_id', $salesmanId);
        }
        if ($userId != NULL) {
            $this->strikeforce->where('user_id', $userId);
        }
        if ($fromDate != NULL) {
            $this->strikeforce->where("create_date >= " , date("Y-m-d H:i:s", strtotime($fromDate)));
        }

        if ($toDate != NULL) {

            $this->strikeforce->where("create_date < " ,date("Y-m-d H:i:s", strtotime($toDate)));
        }
        $this->strikeforce->where('del_flg != 1');      
        $listCoachingSalesman = $this->strikeforce->get();
        // var_dump($this->strikeforce); exit();
        if($listCoachingSalesman != FALSE)
        {
            $listCoachingSalesman =  $listCoachingSalesman->result_array();         
            for($i=0; $i < count($listCoachingSalesman); $i++)
            {
                $result[$i]= json_decode($listCoachingSalesman[$i]['data'], true);
            }
            return $result;
            
        } else {
            return NULL;
        }
    }
	
}
?>