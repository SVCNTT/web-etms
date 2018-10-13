<?php

class Salesman_leave_model extends MY_Model
{
    public $strikeforce;

    public function __construct()
    {
        $this->strikeforce = $this->load->database(DATABASE_NAME, TRUE);
    }

    /**
     * API saleman
     * @param $data
     * @return mixed
     */
	public function Insert($data)
	{
		$this->strikeforce->trans_start();
        $this->strikeforce->insert('salesman_leave', $data);
        $insert_id = $this->strikeforce->insert_id();
        $this->strikeforce->trans_complete();
        return  $insert_id;
	}
	
    /**
     * API saleman
     * @param $salesman_leave_id
     * @param $data
     * @return mixed
     */
    public function update($salesman_leave_id, $data)
    {
        return $this->strikeforce->update('salesman_leave', $data, array('salesman_leave_id' => $salesman_leave_id));
    }
	
    /**
     * API saleman
     * @param $saleman_id
     * @return int
     */
	public function selectMaxSeqNo($saleman_id)
	{
		$this->strikeforce->select('max(leave_seq) as seq_no');
		$this->strikeforce->from('salesman_leave');
        $this->strikeforce->where('del_flg != ', 1);
		$this->strikeforce->where('salesman_id', $saleman_id);
        $query = $this->strikeforce->get();
        if ($query->num_rows() > 0) {
            return($query->row()->seq_no);
        } else {
			return 0;
		}
		
	}
	
    /**
     * API saleman
     * @param $arrParam
     * @return null
     */
  public function getSalesmanLeave($arrParam)
  {
    $leaveDate = isset($arrParam['leaveDate']) ? $arrParam['leaveDate'] : NULL;
    $salesmanId = isset($arrParam['salesmanId']) ? $arrParam['salesmanId'] : NULL;
        $leaveType = isset($arrParam['leaveType']) ? $arrParam['leaveType'] : NULL;

    if ( $leaveDate === NULL || $salesmanId === NULL) {
        return NULL;
    }
        $this->strikeforce->select('`salesman_leave_id` as salesmanLeaveId, `salesman_id` as salesmanId, `leave_seq` as leaveSeq, `leave_date` as leaveDate, `register_in_date` as registerInDate');
    $this->strikeforce->from('salesman_leave');
    $this->strikeforce->where('leave_date', $leaveDate);
    $this->strikeforce->where('salesman_id', $salesmanId);
        $this->strikeforce->where('type', $leaveType);
    $this->strikeforce->where('del_flg != 1');
    $salesmanLeave = $this->strikeforce->get();

        if ($salesmanLeave != FALSE) {
      return $salesmanLeave->result_array();
    } else {
      return NULL;
    }
  }

    /**
     * Dashboard controller
     * @param $arrParam
     * @return array
     */
    public function getSchedule($arrParam)
    {
        $dataResult = array(
            "scheduleResult" => array(),
            "pagingInfo" => NULL
        );

        $totalRow = $this->countSchedule($arrParam);
        if ($totalRow > 0) {
            $crtPage = 1;
            if (isset($arrParam["pagingInfo"])) {
                $crtPage = $arrParam["pagingInfo"]["crtPage"];
            }
            $pagingSet = $this->setPagingInfo($totalRow, $crtPage);

            $this->strikeforce->select(' * ');
            $this->strikeforce->from('salesman_leave sl');
            $this->strikeforce->where(' sl.del_flg != ', 1);

            $productTypeId = isset($arrParam['productTypeId']) ? intval($arrParam['productTypeId']) : 0;
            //Get salesman by product type
            $this->load->model('saleman_model');
            $lst_salesman = $this->saleman_model->getSalesmanByProductType($productTypeId, $arrParam['curr_user']);
            if (empty($lst_salesman)) {
                return array("scheduleResult" => array(), "pagingInfo" => $pagingSet);
            }

            $lst_salesman_id = [];
            foreach($lst_salesman as $item) {
                $lst_salesman_id[] = $item['salesman_id'];
            }

            $this->strikeforce->where_in('sl.salesman_id', $lst_salesman_id);

            $startDate = isset($arrParam['startDate']) ? $arrParam['startDate'] : NULL;
            if ($startDate !== NULL) {
                list($d, $m, $y) = explode('-', $startDate);
                $startDate = $y.'-'.$m.'-'.$d.' 00:00:00';
                $this->strikeforce->where('sl.leave_date >=', $startDate);
            }

            $endDate = isset($arrParam['endDate']) ? $arrParam['endDate'] : NULL;
            if ($endDate !== NULL) {
                list($d, $m, $y) = explode('-', $endDate);
                $endDate = $y.'-'.$m.'-'.$d.' 23:59:59';
                $this->strikeforce->where('sl.leave_date <=', $endDate);
            }

            $limit = ROW_ON_PAGE;
            $offset = $pagingSet["stRow"] - 1;
            $this->strikeforce->limit($limit, $offset);
            $this->strikeforce->order_by('sl.leave_date desc');
            $query = $this->strikeforce->get();

            $schedulePatchResult = [];
            $tempDate = NULL;
            $schedulePatch = [];
            $schedule = [];

            /*Maping salesman - Begin*/
            $mr_temp = array();
            foreach($lst_salesman as $item) {
                $mr_temp[$item['salesman_id']] = $item['salesman_name'];
            }
            /*Maping salesman - End*/

            $arr_type = array(
                KEY_DATE_TAKINGOFF  =>  DAS0150_DATE_TAKINGOFF,
                KEY_DATE_WORKING    =>  DAS0150_DATE_WORKING,
                KEY_DATE_HOLIDAY    =>  DAS0150_DATE_HOLIDAY,
                KEY_DATE_TRAINING   =>  DAS0150_DATE_TRAINING,
                KEY_DATE_PROMOTION  =>  DAS0150_DATE_PROMOTION,
                KEY_DATE_MEETING    =>  DAS0150_DATE_MEETING,
            );

            foreach ($query->result() as $row) {
                if ($tempDate == date("d-m-Y", strtotime($row->leave_date))) {
                    $schedule[] = array("cont_text" => $row->cont_text,
                        "type" => $row->type,
                        "type_name" => $arr_type[$row->type],
                        "register_in_date" => $row->register_in_date,
                        "salesman_name" => $mr_temp[$row->salesman_id]);
                } else {
                    if ($schedule == NULL) {
                        $schedule[] = array("cont_text" => $row->cont_text,
                            "type" => $row->type,
                            "type_name" => $arr_type[$row->type],
                            "register_in_date" => $row->register_in_date,
                            "salesman_name" => $mr_temp[$row->salesman_id]);
                    } else {
                        $schedulePatch["scheduleDate"] = $tempDate;
                        $schedulePatch["schedule"] = $schedule;
                        $schedulePatchResult[] = $schedulePatch;
                        $schedule = [];
                        $schedule[] = array("cont_text" => $row->cont_text,
                            "type" => $row->type,
                            "type_name" => $arr_type[$row->type],
                            "register_in_date" => $row->register_in_date,
                            "salesman_name" => $mr_temp[$row->salesman_id]);
                    }
                    $tempDate = date("d-m-Y", strtotime($row->leave_date));
                }
}

            $schedulePatch["scheduleDate"] = $tempDate;
            $schedulePatch["schedule"] = $schedule;
            $schedulePatchResult[] = $schedulePatch;

            $dataResult["scheduleResult"] = $schedulePatchResult;
            $dataResult["pagingInfo"] = $pagingSet;
        }
            return $dataResult;

    }

    /**
     * getSchedule
     * @param $arrParam
     * @return int
     */
    private function countSchedule($arrParam)
    {
        $this->strikeforce->select(' count(*) as  totalRow');

        $this->strikeforce->from('salesman_leave sl');
        $this->strikeforce->where(' sl.del_flg != ', 1);

        $productTypeId = isset($arrParam['productTypeId']) ? intval($arrParam['productTypeId']) : 0;
        //Get salesman by product type
        $this->load->model('saleman_model');
        $lst_salesman = $this->saleman_model->getSalesmanByProductType($productTypeId, $arrParam['curr_user']);
        if (empty($lst_salesman)) {
            return 0;
        }

        $lst_salesman_id = [];
        foreach($lst_salesman as $item) {
            $lst_salesman_id[] = $item['salesman_id'];
        }

        $this->strikeforce->where_in('sl.salesman_id', $lst_salesman_id);

        $startDate = isset($arrParam['startDate']) ? $arrParam['startDate'] : NULL;
        if ($startDate !== NULL) {
            list($d, $m, $y) = explode('-', $startDate);
            $startDate = $y.'-'.$m.'-'.$d.' 00:00:00';
            $this->strikeforce->where('sl.leave_date >=', $startDate);
        }

        $endDate = isset($arrParam['endDate']) ? $arrParam['endDate'] : NULL;
        if ($endDate !== NULL) {
            list($d, $m, $y) = explode('-', $endDate);
            $endDate = $y.'-'.$m.'-'.$d.' 23:59:59';
            $this->strikeforce->where('sl.leave_date <=', $endDate);
        }

        $this->strikeforce->order_by('sl.leave_date desc');
        $queryTotal = $this->strikeforce->get();
        return $queryTotal->row()->totalRow;
    }
}

?>