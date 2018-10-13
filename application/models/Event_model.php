<?php 
class Event_model extends MY_Model{
	public $strikeforce;
	public $codeDefault = "0000000000";
	public function __construct()
	{
		$this->strikeforce = $this->load->database(DATABASE_NAME, TRUE);
	}

    /**
     * API checklist
     * @param $checklistId
     * @param $salesmanId
     * @param $userId
     * @param $params
     * @return bool
     */
	public function insertEvent($checklistId, $salesmanId, $userId, $params) {
		if (isset($params)){
            foreach ($params as $val){
                if (!$this->getCustomerEvent($checklistId, $salesmanId, $userId, $val)) {
                $array_insert = array(
                    'checklist_id'      =>  $checklistId,
                    'salesman_id'       =>  $salesmanId,
                        'user_id'           =>  $userId,
                    'doctor_name'       =>  $val['doctorName'],
                    'title'             =>  $val['title'],
                    'position'          =>  $val['position'],
                    'specialty'         =>  $val['specialty'],
                    'department'        =>  $val['department'],
                    'hospital'          =>  $val['hospital'],
                    'attendance'        =>  0
                );

                $this->strikeforce->insert('customer_event',$array_insert);
            }
		}
		}

        return TRUE;
	}

    /**
     * insertEvent
     * @param $checklistId
     * @param $salesmanId
     * @param $userId
     * @param $params
     * @return mixed
     */
    private function getCustomerEvent($checklistId, $salesmanId, $userId, $params) {

        $this->strikeforce->select("
            							ce.doctor_name doctorName
            							, ce.customer_event_id as customerEventId
            							, ce.title
            		            		, ce.position
            		            		, ce.specialty
            		            		, ce.department
            		            		, ce.hospital
            		            		, ce.attendance
            							, sa.salesman_id salesmanId
            							, sa.salesman_name salesmanName"
            , FALSE);
        $this->strikeforce->from('customer_event ce');
        $this->strikeforce->join('salesman sa', "ce.salesman_id = sa.salesman_id", 'left');

        $this->strikeforce->where('checklist_id = ', $checklistId);
        $this->strikeforce->where('sa.salesman_id = ', $salesmanId);
        $this->strikeforce->where('ce.doctor_name = ', $params['doctorName']);
        $this->strikeforce->where('ce.title = ', $params['title']);
        $this->strikeforce->where('ce.position = ', $params['position']);
        $this->strikeforce->where('ce.specialty = ', $params['specialty']);
        $this->strikeforce->where('ce.department = ', $params['department']);
        $this->strikeforce->where('ce.hospital = ', $params['hospital']);
        $query = $this->strikeforce->get();
        return $query->result_array();
    }

    /**
     * Checklist controller
     * @param $params
     * @param $checklistId
     * @return array
     */
    public function searchChecklist($params, $checklistId){
        $dataResult = array(
            "cheInfo"       =>  NULL,
            "pagingInfo"    =>  NULL
        );

        $totalRow  = $this->countsearchChecklist($params, $checklistId);

        if ( $totalRow> 0 )
        {
            $pagingSet = $this->setPagingInfo($totalRow, $params["pagingInfo"]["crtPage"]);

            $this->strikeforce->select("
            							ce.doctor_name doctorName
            							, ce.customer_event_id as customerEventId
            							, ce.title
            		            		, ce.position
            		            		, ce.specialty
            		            		, ce.department
            		            		, ce.hospital
            		            		, ce.attendance
            							, CASE WHEN sa.salesman_name != '' THEN sa.salesman_name ELSE CONCAT(u.first_name, ' ', u.last_name) END invitedBy"
                , FALSE);
            $this->strikeforce->from('customer_event ce');
            $this->strikeforce->join('salesman sa', "ce.salesman_id = sa.salesman_id", 'left');
            $this->strikeforce->join('user_mst u', "ce.user_id = u.user_id", 'left');

            $this->strikeforce->where('checklist_id = ', $checklistId);

            $doctorName = isset($params["searchInput"]['doctorName']) ? $params["searchInput"]['doctorName'] : '';
            if ($doctorName !== '') {
                $this->strikeforce->where("UPPER(doctor_name) like '%".strtoupper($doctorName)."%'");
            }

            $hospital = isset($params["searchInput"]['hospital']) ? $params["searchInput"]['hospital'] : '';
            if ($hospital !== '') {
                $this->strikeforce->where("UPPER(hospital) like '%".strtoupper($hospital)."%'");
            }

            $limit = ROW_ON_PAGE;
            $offset = $pagingSet["stRow"]-1;
            $this->strikeforce->limit($limit, $offset);

            $query = $this->strikeforce->get();

            $dataResult["cheInfo"] = $query->result_array();
            $dataResult["pagingInfo"] = $pagingSet;
        }

            return  $dataResult;

    }

    /**
     * searchChecklist
     * @param $params
     * @param $checklistId
     * @return int
     */
    private function countsearchChecklist($params, $checklistId){
        $this->strikeforce->select("ce.customer_event_id");
        $this->strikeforce->from('customer_event ce');
        $this->strikeforce->where('checklist_id = ', $checklistId);

        $doctorName = isset($params["searchInput"]['doctorName']) ? $params["searchInput"]['doctorName'] : '';
        if ($doctorName !== '') {
            $this->strikeforce->where("UPPER(doctor_name) like '%".strtoupper($doctorName)."%'");
        }

        $hospital = isset($params["searchInput"]['hospital']) ? $params["searchInput"]['hospital'] : '';
        if ($hospital !== '') {
            $this->strikeforce->where("UPPER(hospital) like '%".strtoupper($hospital)."%'");
        }
        $query = $this->strikeforce->get();

        return count($query->result_array());
	}
    
    /**
     * Checklist controller
     * @param $params
     * @param $checklistId
     * @return array
     */
    public function getChecklistIsAttendanced($params, $checklistId){
    	$this->strikeforce->select("ce.customer_event_id");
    	$this->strikeforce->from('customer_event ce');
    	$this->strikeforce->where('checklist_id = ', $checklistId);
    	$this->strikeforce->where('attendance = ', 1);
    	$query = $this->strikeforce->get();
    	$data = [];
    	if ($query->num_rows() > 0)
    	{
    		foreach ($query->result() as $row)
    		{
    			$data[] = $row->customer_event_id;
    		}
    	}
    	return $data;
    }
    
    /**
     * Checklist controller
     * @param $params
     * @return bool
     */
    public function regisAttendance($params) {
    	if (isset($params)){
    			$this->unRegisAttendance($params["listSelectChecklist"], $params["checklistId"]);
		 		
    			$this->strikeforce->where_in('customer_event_id', $params["listSelectChecklist"]);
		 		$this->strikeforce->where('checklist_id', $params["checklistId"]);
				$query =  $this->strikeforce->update('customer_event',array("attendance"=>1));
    	}
    	return TRUE;
    }
    
    /**
     * regisAttendance
     * @param $arraycustomerIds
     * @param $checklistId
     */
    private function unRegisAttendance($arraycustomerIds, $checklistId) {
    	$this->strikeforce->where_not_in('customer_event_id', $arraycustomerIds);
    	$this->strikeforce->where('checklist_id', $checklistId);
    	$query =  $this->strikeforce->update('customer_event',array("attendance"=>0));
    }
    
    
}
?>
