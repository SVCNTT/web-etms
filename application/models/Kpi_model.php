<?php 
class Kpi_model extends MY_Model{ 
	public $strikeforce;
	public function __construct()
	{
		$this->strikeforce = $this->load->database(DATABASE_NAME, TRUE);
	} 
	
    /**
     * KPI controller
     * @param $params
     * @return array
     */
	public function getSalesmanByProducTypeId($params){
        $dataResult = array(
            "salesmanInfo"  =>NULL,
            "pagingInfo"    =>NULL
        );

		$totalRow  = $this->countSalesmanByProducTypeId($params);
	
		if ( $totalRow> 0 )
		{
			$pagingSet = $this->setPagingInfo($totalRow, $params["pagingInfo"]["crtPage"]);
	
			$this->strikeforce->select(" s.salesman_code as salesmanCode
										,s.salesman_name as salesmanName");
			
			$this->strikeforce->from('salesman s');
			$this->strikeforce->join('user_salesman us', "s.salesman_id = us.salesman_id");
			$this->strikeforce->join('user_product_type upt', "us.sub_leader_user_id = upt.user_id");
			$this->strikeforce->join('product_type_mst ptmst', "upt.product_type_id = ptmst.product_type_id");
			$this->strikeforce->where('s.del_flg != ', 1);
			if (!empty($params["searchInput"]["productTypeId"])){
				$this->strikeforce->where('ptmst.product_type_id= ', $params["searchInput"]["productTypeId"]);
			}
			
			$limit = ROW_ON_PAGE;
			$offset = $pagingSet["stRow"]-1;
			$this->strikeforce->limit($limit, $offset);
			$query = $this->strikeforce->get();
	
	
			$dataResult["salesmanInfo"] = $query->result_array();
			$dataResult["pagingInfo"] = $pagingSet;
		}

			return  $dataResult;
	
	}
	
    /**
     * getSalesmanByProducTypeId
     * @param $params
     * @return int
     */
	private  function countSalesmanByProducTypeId($params){
		$this->strikeforce->select('s.salesman_id');
		$this->strikeforce->from('salesman s');
			$this->strikeforce->join('user_salesman us', "s.salesman_id = us.salesman_id");
			$this->strikeforce->join('user_product_type upt', "us.sub_leader_user_id = upt.user_id");
			$this->strikeforce->join('product_type_mst ptmst', "upt.product_type_id = ptmst.product_type_id");
			$this->strikeforce->where('s.del_flg != ', 1);
			if (!empty($params["searchInput"]["productTypeId"])){
				$this->strikeforce->where('ptmst.product_type_id= ', $params["searchInput"]["productTypeId"]);
			}
		$query = $this->strikeforce->get();
		return count($query->result_array());
	}
	
    /**
     * KPI controller
     * @param $params
     * @return null
     */
	public function insertKPI($params) {
		
		$date = new DateTime($params["currentMonth"]);
		$params["currentMonth"] = $date->format('Y-m-d H:i:s');
				
		if (isset($params)){
			
			if (empty($params["productTypeKpiId"])){
				$profileId = get_current_profile();
				$this->strikeforce->trans_start();
				$this->strikeforce->set('cre_func_id', "KPI0100");
				$this->strikeforce->set('mod_func_id', "KPI0100");
				$this->strikeforce->set('cre_user_id', $profileId["user_id"]);
				$this->strikeforce->set('mod_user_id', $profileId["user_id"]);
				$this->strikeforce->set('version_no', DEFAULT_VERSION_NO);
				$this->strikeforce->set('mod_ts', 'CURDATE()', false);
		
				$this->strikeforce->set('product_type_id', $params["productTypeId"]);
				$this->strikeforce->set('times', $params["currentMonth"]);
				$this->strikeforce->set('training_days', $params["trainingDays"]);
				$this->strikeforce->set('call_rate', $params["callRate"]);
				$this->strikeforce->set('promotion_days', $params["promotionDays"]);
				$this->strikeforce->set('meeting_days', $params["meetingDays"]);
				$this->strikeforce->set('holidays', $params["holidays"]);
				$this->strikeforce->set('leave_taken', $params["leaveTaken"]);
				$this->strikeforce->set('frequency_1', $params["frequency1"]);
				$this->strikeforce->set('frequency_2', $params["frequency2"]);
				$this->strikeforce->set('frequency_3', $params["frequency3"]);
				$this->strikeforce->insert('product_type_kpi');
				$insert_id = $this->strikeforce->insert_id();
				$this->strikeforce->trans_complete();
				return  $insert_id;
			}else{
				$this->updateKpi($params);
				return $params["productTypeKpiId"];
			}
		}else{
			return NULL;
		}
	}
	
    /**
     * insertKPI
     * @param $params
     */
	private function updateKpi($params){
		 	$data = array('training_days' => $params["trainingDays"]
                            ,'call_rate'=>$params["callRate"]
                            ,'promotion_days'=>$params["promotionDays"]
                            ,'meeting_days'=>$params["meetingDays"]
                            ,'holidays'=>$params["holidays"]
                            ,'leave_taken'=>$params["leaveTaken"]
                            ,'frequency_1'=>$params["frequency1"]
                            ,'frequency_2'=>$params["frequency2"]
                            ,'frequency_3'=>$params["frequency3"]
                            );
	 		$this->strikeforce->where('product_type_kpi_id', $params["productTypeKpiId"]);
			$query =  $this->strikeforce->update('product_type_kpi',$data);
	}
	
    /**
     * KPI controller
     * @param $params
     * @return array
     */
	public function getByProductTypeIdAndTimeKPI($params){
		if (isset($params)){
			
			
			$sSQL = "  SELECT 
							product_type_kpi_id as  productTypeKpiId 
							,".$params["searchInput"]["productTypeId"]." as  productTypeId 
							,times as currentMonth
							,training_days as trainingDays
							,call_rate as callRate
							,promotion_days as promotionDays
							,meeting_days as meetingDays
							,holidays as holidays
							,leave_taken as leaveTaken
							,frequency_1 as frequency1
							,frequency_2 as frequency2
							,frequency_3 as frequency3
					
						FROM product_type_kpi WHERE del_flg != '1' ";
			
			$sSQLWhere = "";
			if (!empty($params["searchInput"]["currentMonth"])){
				$date = new DateTime($params["searchInput"]["currentMonth"]);
				$params["searchInput"]["currentMonth"] = $date->format('Y-m-d H:i:s');
				$sSQLWhere .= " and STR_TO_DATE(times,'%Y-%m') = STR_TO_DATE('".$params["searchInput"]["currentMonth"]."','%Y-%m')";
			}
			if (!empty($params["searchInput"]["productTypeId"])){
				$sSQLWhere .= " and product_type_id =  ".$params["searchInput"]["productTypeId"];
			}
				$query = $this->strikeforce->query($sSQL.$sSQLWhere);
			 
		        return $query->result_array()[0] == null ? [] : $query->result_array()[0];
		}
		return [];
	}

    public function getBySubLeaderId($sub_leader_user_id, $date) {
        $sSQL = "   SELECT kpi.*
                    FROM user_product_type upt
    				INNER JOIN product_type_kpi kpi ON (kpi.product_type_id = upt.product_type_id AND STR_TO_DATE(kpi.times,'%Y-%m') = STR_TO_DATE('" . $date . "','%Y-%m'))
    				WHERE upt.user_id = ".$sub_leader_user_id." AND upt.del_flg != '1'  AND kpi.del_flg != '1'";


        $query = $this->strikeforce->query($sSQL);

        return $query !== FALSE ? $query->row_array() : FALSE;
    }
}
?>