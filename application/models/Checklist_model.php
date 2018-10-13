<?php 

class Checklist_model extends MY_Model{
	public $strikeforce;
	public $codeDefault = "0000000000";
	public function __construct()
	{
		$this->strikeforce = $this->load->database(DATABASE_NAME, TRUE);
	}

    /**
     * checklist controller
     * @param $params
     * @return null
     */
	public function insertChecklist($params) {
		if (isset($params)){
			if ($params["checklistId"] == 0) {
				$profileId = get_current_profile();
				$sqlGetcode = " SELECT RIGHT(`checklist_code`, LENGTH(`checklist_code`)-3) + 1 as checklistCode FROM `checklist` WHERE `checklist_id` = (SELECT MAX(`checklist_id`) FROM `checklist`) ";
				$query = $this->strikeforce->query($sqlGetcode);
				$checklist_code = $query->result_array();
				$code = $checklist_code[0]["checklistCode"];
				$code = "CHE".substr($this->codeDefault,0,strlen($this->codeDefault) - strlen($code)).$code;

				$this->strikeforce->trans_start();
				$this->strikeforce->set('cre_func_id', "CHE0200");
				$this->strikeforce->set('mod_func_id', "CHE0200");
				$this->strikeforce->set('cre_user_id', $profileId["user_id"]);
				$this->strikeforce->set('mod_user_id', $profileId["user_id"]);
				$this->strikeforce->set('version_no', DEFAULT_VERSION_NO);
				$this->strikeforce->set('mod_ts', 'CURDATE()', false);

				$this->strikeforce->set('checklist_name', $params["checklistName"]);
				$this->strikeforce->set('checklist_code', $code);
				$this->strikeforce->set('start_date', "STR_TO_DATE('".$params["checklistStartday"]."','%d-%m-%Y')", false);
				$this->strikeforce->set('end_date', "STR_TO_DATE('".$params["checklistEndday"]."','%d-%m-%Y')", false);
				$this->strikeforce->insert('checklist');
				$insert_id = $this->strikeforce->insert_id();
				$this->strikeforce->trans_complete();

			}else{
				$sSQL = " UPDATE checklist SET checklist_name = '".$params["checklistName"]."',
										  start_date = STR_TO_DATE('".$params["checklistStartday"]."','%d-%m-%Y'),
										  end_date = STR_TO_DATE('".$params["checklistEndday"]."','%d-%m-%Y'),
  										  mod_ts = NOW()
								WHERE checklist_id = ".$params["checklistId"];
				$res = $this->strikeforce->query($sSQL);
				if (!$res) {
					return $this->strikeforce->_error_message();
				}

				$insert_id = $params["checklistId"];
			}

		return  $insert_id;

		}else{
			return NULL;
		}
	}

    /**
     * Checklist controller
     * @param $params
     * @return array
     */
    public function searchChecklist($params){
        $dataResult = array(
            "cheInfo"   =>  NULL,
            "pagingInfo"=>  NULL
        );

        $totalRow  = $this->countsearchChecklist($params);

        if ( $totalRow> 0 )
        {
            $curr_page = isset($params["pagingInfo"]["crtPage"]) ? $params["pagingInfo"]["crtPage"] : 1;
            $pagingSet = $this->setPagingInfo($totalRow, $curr_page);

            $this->strikeforce->select("che.checklist_id
            							, che.checklist_code
            		            		, che.checklist_name
            							, che.create_date
            							, DATE_FORMAT( che.start_date ,'%d/%m/%Y') as start_date
            							, DATE_FORMAT( che.end_date ,'%d/%m/%Y') as end_date
 										, (SELECT GROUP_CONCAT(CONCAT(sl.salesman_name) SEPARATOR ', ')
 										    FROM checklist_salesman chsl
 										    JOIN salesman sl ON sl.salesman_id = chsl.salesman_id AND sl.del_flg != 1
 										    WHERE chsl.checklist_id = che.checklist_id) as salesmanNames
                                        , (SELECT GROUP_CONCAT(CONCAT(u.first_name, ' ', u.last_name) SEPARATOR ', ')
                                            FROM checklist_user chu
                                            JOIN user_mst u ON chu.user_id = u.user_id AND u.del_flg != 1
                                            WHERE chu.checklist_id = che.checklist_id) as rmNames"
            						   , FALSE);
            $this->strikeforce->from('checklist che');
            $this->strikeforce->where(' che.del_flg != ', 1);

            $checklistName = isset($params["searchInput"]['checklistName']) ? $params["searchInput"]['checklistName'] : '';
            if ($checklistName !== '') {
                $this->strikeforce->where("UPPER(che.checklist_name) like '%".strtoupper($checklistName)."%'");
            }

            $checklistCode = isset($params["searchInput"]['checklistCode']) ? $params["searchInput"]['checklistCode'] : '';
            if ($checklistCode !== '') {
            	$this->strikeforce->where("UPPER(che.checklist_code) like '%".strtoupper($checklistCode)."%'");
            }
            $limit = ROW_ON_PAGE;
            $offset = $pagingSet["stRow"]-1;
            $this->strikeforce->limit($limit, $offset);
            $this->strikeforce->group_by('che.checklist_id');
            $this->strikeforce->order_by('che.create_date DESC ');

            $query = $this->strikeforce->get();

            $dataResult["cheInfo"] = $query->result_array();
            $dataResult["pagingInfo"] = $pagingSet;
        }

        return $dataResult;
    }

    /**
     * searchChecklist
     * @param $params
     * @return int
     */
    private function countsearchChecklist($params){
        $this->strikeforce->select('che.checklist_id');
        $this->strikeforce->from('checklist che');
        $this->strikeforce->join('checklist_salesman uct', "che.checklist_id = uct.checklist_id", 'left');
        $this->strikeforce->join('salesman umst', "uct.salesman_id = umst.salesman_id", 'left');
        $this->strikeforce->where(' che.del_flg != ', 1);

        $checklistName = isset($params["searchInput"]['checklistName']) ? $params["searchInput"]['checklistName'] : '';
        if ($checklistName !== '') {
            $this->strikeforce->where("UPPER(che.checklist_name) like '%".strtoupper($checklistName)."%'");
        }
        $checklistCode = isset($params["searchInput"]['checklistCode']) ? $params["searchInput"]['checklistCode'] : '';
        if ($checklistCode !== '') {
        	$this->strikeforce->where("UPPER(che.checklist_code) like '%".strtoupper($checklistCode)."%'");
        }
        $this->strikeforce->group_by('che.checklist_id');
        $query = $this->strikeforce->get();

        return count($query->result_array());
    }

    /**
     * Checklist controller
     * @param array $param_arr
     * @return array
     */
    public function searchSalesmanNotAssign($param_arr = array()) {
        $dataResult = array(
            "userInfo"      =>  NULL,
            "pagingInfo"    =>  NULL
        );

        $totalRow = $this->countSearchSalesmanNotAssign($param_arr);

    	if ( $totalRow> 0 )
    	{
    		$pagingSet = $this->setPagingInfo($totalRow, $param_arr["pagingInfo"]["crtPage"]);

    		$this->strikeforce->distinct();
    		$this->strikeforce->select("
             u.salesman_id as userId
            ,u.salesman_code as userCode
            ,u.email
            ,u.salesman_sts as userSts
            ,u.mobile as phone
            ,u.salesman_name as salesmanName", FALSE);

    		$this->strikeforce->from('salesman u');
    		$this->strikeforce->where(' u.del_flg != ', 1);

    		$userCode = isset($param_arr['searchInput']['userCode']) ? $param_arr['searchInput']['userCode'] : NULL;
    		if ($userCode !== NULL ) {
    			$this->strikeforce->where('(UPPER(u.salesman_code) like \'%' . strtoupper($userCode)  . '%\') ');
    		}

    		$userName = isset($param_arr['searchInput']['userName']) ? $param_arr['searchInput']['userName'] : NULL;
    		if ($userName !== NULL && !empty($userName)) {
    			$this->strikeforce->where('UPPER(u.salesman_name) like \'%' . strtoupper($userName) . '%\' ');
    		}
    		$checklistId = isset($param_arr['searchInput']['checklistId']) ? $param_arr['searchInput']['checklistId'] : NULL;
    		if ($checklistId !== NULL) {
    			$this->strikeforce->where(' u.salesman_id not in (SELECT uctChild.salesman_id FROM `checklist_salesman` uctChild WHERE uctChild.checklist_id ='.$checklistId.' ) ', NULL,FALSE);
    		}

    		$limit = ROW_ON_PAGE;
    		$offset = $pagingSet["stRow"]-1;
    		$this->strikeforce->limit($limit, $offset);
    		$query = $this->strikeforce->get();

    		$dataResult["userInfo"] = $query->result_array();
    		$dataResult["pagingInfo"] = $pagingSet;
        }

    		return  $dataResult;
    	}

    /**
     * searchSalesmanNotAssign
     * @param array $param_arr
     * @return mixed
     */
    private function countSearchSalesmanNotAssign($param_arr = array())
    {
        $this->strikeforce->distinct();
        $this->strikeforce->select('
    		,u.salesman_id as userId
            ,u.salesman_code as userCode
            ,u.email
        ');

        $this->strikeforce->from('salesman u');
        $this->strikeforce->where(' u.del_flg != ', 1);

        $userCode = isset($param_arr['searchInput']['userCode']) ? $param_arr['searchInput']['userCode'] : NULL;
        if ($userCode !== NULL ) {
            $this->strikeforce->where('(UPPER(u.salesman_code) like \'%' . strtoupper($userCode)  . '%\') ');
    }

        $userName = isset($param_arr['searchInput']['userName']) ? $param_arr['searchInput']['userName'] : NULL;
        if ($userName !== NULL && !empty($userName)) {
            $this->strikeforce->where('UPPER(u.salesman_name) like \'%' . strtoupper($userName) . '%\' ');
        }

        $checklistId = isset($param_arr['searchInput']['checklistId']) ? $param_arr['searchInput']['checklistId'] : NULL;
        if ($checklistId !== NULL) {
            $this->strikeforce->where(' u.salesman_id not in (SELECT uctChild.salesman_id FROM `checklist_salesman` uctChild WHERE uctChild.checklist_id ='.$checklistId.' ) ', NULL,FALSE);
        }

        return $this->strikeforce->count_all_results();
    }

    /**
     * Checklist controller
     * @param array $params
     * @return array
     */
    public function searchRMUserAssign($params = array())
    {
        $dataResult = array(
            "userInfo"      =>  NULL,
            "pagingInfo"    =>  NULL
        );

        $totalRow = $this->countSearchRMUserAssign($params);
        if ( $totalRow> 0 )
        {
            $pagingSet = $this->setPagingInfo($totalRow, $params["pagingInfo"]["crtPage"]);

            $this->strikeforce->distinct();
            $this->strikeforce->select("
             u.user_id as userId
            ,u.user_code as userCode
            ,u.email
            ,u.phone_no as phone
            ,concat(u.first_name, u.last_name) as fullname", FALSE);
            $this->strikeforce->from('checklist_user chk_u');
            $this->strikeforce->join('user_mst u', 'u.user_id = chk_u.user_id AND chk_u.del_flg !=1');
            $this->strikeforce->where('u.del_flg != ', 1);
            $this->strikeforce->where('chk_u.del_flg != ', 1);

            $checklistId = isset($params["searchInput"]['checklistId']) ? $params["searchInput"]['checklistId'] : NULL;
            if ($checklistId !== NULL) {
                $this->strikeforce->where('chk_u.checklist_id = ', $checklistId);
            }

            $userCode = isset($params["searchInput"]['userCode']) ? $params["searchInput"]['userCode'] : NULL;
            if ($userCode !== NULL) {
                $this->strikeforce->where('(UPPER(u.user_code) like \'%' . strtoupper($userCode)  . '%\') ');
            }

            $userName = isset($params['searchInput']['userName']) ? $params['searchInput']['userName'] : NULL;
            if ($userName !== NULL) {
                $this->strikeforce->where('UPPER(concat(u.first_name, u.last_name)) like \'%' . strtoupper($userName) . '%\' ');
            }

            $limit = ROW_ON_PAGE;
            $offset = $pagingSet["stRow"]-1;
            $this->strikeforce->limit($limit, $offset);
            $this->strikeforce->order_by('u.user_code');
            $query = $this->strikeforce->get();

            $dataResult["userInfo"] = $query->result_array();
            $dataResult["pagingInfo"] = $pagingSet;
        }
            return  $dataResult;
        }

    /**
     * searchRMUserAssign
     * @param array $param_arr
     * @return mixed
     */
    private function countSearchRMUserAssign($param_arr = array())
    {
        $this->strikeforce->distinct();
        $this->strikeforce->select("
             u.user_id as userId
            ,u.user_code as userCode
            ,u.email
            ,u.phone_no as phone
            ,concat(u.first_name, u.last_name) as fullname", FALSE);
        $this->strikeforce->from('checklist_user chk_u');
        $this->strikeforce->join('user_mst u', 'u.user_id = chk_u.user_id AND chk_u.del_flg !=1');
        $this->strikeforce->where('u.del_flg != ', 1);
        $this->strikeforce->where('chk_u.del_flg != ', 1);

        $checklistId = isset($params["searchInput"]['checklistId']) ? $params["searchInput"]['checklistId'] : NULL;
        if ($checklistId !== NULL) {
            $this->strikeforce->where('chk_u.checklist_id = ', $checklistId);
        }

        $userCode = isset($params["searchInput"]['userCode']) ? $params["searchInput"]['userCode'] : NULL;
        if ($userCode !== NULL) {
            $this->strikeforce->where('(UPPER(u.user_code) like \'%' . strtoupper($userCode)  . '%\') ');
        }

        $userName = isset($param_arr['searchInput']['userName']) ? $param_arr['searchInput']['userName'] : NULL;
        if ($userName) {
            $this->strikeforce->where('UPPER(concat(u.first_name, u.last_name)) like \'%' . strtoupper($userName) . '%\' ');
        }

        return $this->strikeforce->count_all_results();
    }

    /**
     * Checklist controller
     * @param array $param_arr
     * @return array
     */
    public function searchRMNotAssign($param_arr = array()) {
        $dataResult = array(
            "userInfo"      =>  NULL,
            "pagingInfo"    =>  NULL
        );

        $totalRow = $this->countSearchRMNotAssign($param_arr);

        if ( $totalRow> 0 )
        {
            $pagingSet = $this->setPagingInfo($totalRow, $param_arr["pagingInfo"]["crtPage"]);

            $this->strikeforce->distinct();
            $this->strikeforce->select("
             u.user_id as userId
            ,u.user_code as userCode
            ,u.email
            ,u.user_sts as userSts
            ,u.phone_no as phone
            ,CONCAT(u.first_name, u.last_name) as rmName", FALSE);

            $this->strikeforce->from('user_mst u');
            $this->strikeforce->where(' u.del_flg != ', 1);
            $this->strikeforce->where(' u.user_role_cd =', 5);

            $userCode = isset($param_arr['searchInput']['userCode']) ? $param_arr['searchInput']['userCode'] : NULL;
            if ($userCode !== NULL ) {
                $this->strikeforce->where('(UPPER(u.user_code) like \'%' . strtoupper($userCode)  . '%\') ');
            }

            $userName = isset($param_arr['searchInput']['userName']) ? $param_arr['searchInput']['userName'] : NULL;
            if ($userName !== NULL && !empty($userName)) {
                $this->strikeforce->where('UPPER(CONCAT(u.first_name, u.last_name)) like \'%' . strtoupper($userName) . '%\' ');
            }
            $checklistId = isset($param_arr['searchInput']['checklistId']) ? $param_arr['searchInput']['checklistId'] : NULL;
            if ($checklistId !== NULL) {
                $this->strikeforce->where(' u.user_id not in (SELECT uctChild.user_id FROM `checklist_user` uctChild WHERE uctChild.checklist_id ='.$checklistId.' ) ', NULL,FALSE);
            }

            $limit = ROW_ON_PAGE;
            $offset = $pagingSet["stRow"]-1;
            $this->strikeforce->limit($limit, $offset);
            $query = $this->strikeforce->get();

            $dataResult["userInfo"] = $query->result_array();
            $dataResult["pagingInfo"] = $pagingSet;
        }

            return  $dataResult;
        }

    /**
     * searchRMNotAssign
     * @param $params
     * @return mixed
     */
    private function countSearchRMNotAssign($params)
    {
    	$this->strikeforce->distinct();
        $this->strikeforce->select("
             u.user_id as userId
            ,u.user_code as userCode
            ,u.email
            ,u.user_sts as userSts
            ,u.phone_no as phone
            ,CONCAT(u.first_name, u.last_name) as rmName", FALSE);

        $this->strikeforce->from('user_mst u');
    	$this->strikeforce->where(' u.del_flg != ', 1);
        $this->strikeforce->where(' u.user_role_cd =', 5);

        $userCode = isset($params['searchInput']['userCode']) ? $params['searchInput']['userCode'] : NULL;
    	if ($userCode !== NULL ) {
            $this->strikeforce->where('(UPPER(u.user_code) like \'%' . strtoupper($userCode)  . '%\') ');
    	}

        $userName = isset($params['searchInput']['userName']) ? $params['searchInput']['userName'] : NULL;
    	if ($userName !== NULL && !empty($userName)) {
            $this->strikeforce->where('UPPER(CONCAT(u.first_name, u.last_name)) like \'%' . strtoupper($userName) . '%\' ');
    	}
        $checklistId = isset($params['searchInput']['checklistId']) ? $params['searchInput']['checklistId'] : NULL;
    	if ($checklistId !== NULL) {
            $this->strikeforce->where(' u.user_id not in (SELECT uctChild.user_id FROM `checklist_user` uctChild WHERE uctChild.checklist_id ='.$checklistId.' ) ', NULL,FALSE);
    	}

    	return $this->strikeforce->count_all_results();
    }

//    public function getUserIdsAssigned($param_arr = array())
//    {
//        $this->strikeforce->distinct();
//        $this->strikeforce->select("
//             u.user_id as userId
//    		", FALSE);
//
//        $this->strikeforce->from('user_mst u');
//        $this->strikeforce->join('client c', "u.client_id = c.client_id and c.del_flg != '1'", 'left');
//        $this->strikeforce->where(' u.del_flg != ', 1);
//        $this->strikeforce->where('c.client_id', 1);
//
//        $checklistId = isset($param_arr['checklistId']) ? $param_arr['checklistId'] : NULL;
//        if ($checklistId !== NULL) {
//            $this->strikeforce->where(' u.user_id in (SELECT uctChild.salesman_id FROM `checklist_salesman` uctChild WHERE uctChild.checklist_id ='.$checklistId.' ) ', NULL,FALSE);
//        }
//        $query = $this->strikeforce->get();
//        $data = [];
//        foreach ($query->result() as $row)
//        {
//            $data[] = $row->userId;
//
//        }
//        return  $data;
//    }

    /**
     * Checklist controller
     * @param $params
     * @return null|string
     */
    public function assignUserChecklist($params) {
        if (isset($params)){
            $profileId = get_current_profile();

            $this->strikeforce->trans_start();
            foreach ($params["userIdList"] as $val){
                if ($val != NULL){
                    $this->strikeforce->set('cre_func_id', "COA0330");
                    $this->strikeforce->set('mod_func_id', "COA0330");
                    $this->strikeforce->set('cre_user_id', $profileId["user_id"]);
                    $this->strikeforce->set('mod_user_id', $profileId["user_id"]);
                    $this->strikeforce->set('version_no', DEFAULT_VERSION_NO);
                    $this->strikeforce->set('mod_ts', 'CURDATE()', false);

                    $this->strikeforce->set('checklist_id', $params["checklistId"]);
                    $this->strikeforce->set('salesman_id', $val);
                    $this->strikeforce->insert('checklist_salesman');
                }
            }

            $this->strikeforce->trans_complete();
    			return "OK";

        } else {
            return NULL;
    		}
   }

    /**
     * Checklist controller
     * @param $params
     * @return null|string
     */
    public function assignRMUserChecklist($params) {
   	if (isset($params)){
   		$profileId = get_current_profile();

            $this->strikeforce->trans_start();
   		foreach ($params["userIdList"] as $val){
   			if ($val != NULL){
                    $this->strikeforce->set('cre_func_id', "CHE0340");
                    $this->strikeforce->set('mod_func_id', "CHE0340");
   				$this->strikeforce->set('cre_user_id', $profileId["user_id"]);
   				$this->strikeforce->set('mod_user_id', $profileId["user_id"]);
   				$this->strikeforce->set('version_no', DEFAULT_VERSION_NO);
   				$this->strikeforce->set('mod_ts', 'CURDATE()', false);

   				$this->strikeforce->set('checklist_id', $params["checklistId"]);
                    $this->strikeforce->set('user_id', $val);
                    $this->strikeforce->insert('checklist_user');
   			}
   		}

            $this->strikeforce->trans_complete();
            return "OK";

   	}else{
   		return NULL;
   	}
   }

    /**
     * Checklist controller
     * @param $idCode
     * @return array
     */
    public function getChecklistByCode($idCode) {
        $this->strikeforce->select("checklist_id checklistId, checklist_name checklistName, start_date startDay, end_date endDay");
    		$this->strikeforce->from('checklist che');
    		$this->strikeforce->where(' che.del_flg != ', 1);
    		$this->strikeforce->where(' che.checklist_code', $idCode);
    		$query = $this->strikeforce->get();
    		$data = [];
    		foreach ($query->result() as $row)
    		{
            $data["checklistId"] = $row->checklistId;
            $data["checklistName"] = $row->checklistName;
            $data["startDay"] = $row->startDay;
            $data["endDay"] = $row->endDay;
    		}
    		return  $data;
   }

    /**
     * Checklist controller
     * @param $params
     * @return string
     */
   public function deleteChecklist($params){
   	if (isset($params)) {
   		$checklistId = $params["checklistId"];
   		$this->strikeforce->where('checklist_id', $checklistId);
   		$query =  $this->strikeforce->update('checklist',array("del_flg"=>1));
   		if (!$query) {
   			return $this->strikeforce->_error_message();
   		}
   		return "OK";
   	}
   	return "Empty input";
   }

    /**
     * Checklist controller
     * @param array $param_arr
     * @return array
     */
   public function searchUserAssign($param_arr = array())
   {
        $dataResult = array(
            "userInfo"      =>  NULL,
            "pagingInfo"    =>  NULL
        );

   	$totalRow = $this->countSearchUserAssign($param_arr);
   	if ( $totalRow> 0 )
   	{
   		$pagingSet = $this->setPagingInfo($totalRow, $param_arr["pagingInfo"]["crtPage"]);

   		$this->strikeforce->distinct();
   		$this->strikeforce->select("
             u.salesman_id as userId
            ,u.salesman_code as userCode
            ,u.email
            ,u.salesman_sts as userSts
            ,u.mobile as phone
            ,u.salesman_name as salesmanName", FALSE);

   		$this->strikeforce->from('salesman u');
   		$this->strikeforce->where(' u.del_flg != ', 1);
   		$checklistId = isset($param_arr['searchInput']['checklistId']) ? $param_arr['searchInput']['checklistId'] : NULL;
   		if ($checklistId !== NULL) {
   			$this->strikeforce->where(' u.salesman_id in (SELECT uctChild.salesman_id FROM `checklist_salesman` uctChild WHERE uctChild.checklist_id ='.$checklistId.' ) ', NULL,FALSE);
   		}

   		$userCode = isset($param_arr['searchInput']['userCode']) ? $param_arr['searchInput']['userCode'] : NULL;
   		if ($userCode !== NULL ) {
   			$this->strikeforce->where('(UPPER(u.salesman_code) like \'%' . strtoupper($userCode)  . '%\') ');
   		}

   		$userName = isset($param_arr['searchInput']['userName']) ? $param_arr['searchInput']['userName'] : NULL;
   		if ($userName !== NULL) {
   			$this->strikeforce->where('UPPER(u.salesman_name) like \'%' . strtoupper($userName) . '%\' ');
   		}

   		$limit = ROW_ON_PAGE;
   		$offset = $pagingSet["stRow"]-1;
   		$this->strikeforce->limit($limit, $offset);
   		$this->strikeforce->order_by('u.salesman_code');
   		$query = $this->strikeforce->get();


   		$dataResult["userInfo"] = $query->result_array();
   		$dataResult["pagingInfo"] = $pagingSet;
        }

   		return  $dataResult;
   	}

    /**
     * searchUserAssign
     * @param array $param_arr
     * @return mixed
     */
    private function countSearchUserAssign($param_arr = array())
   {
   	$this->strikeforce->distinct();
   	$this->strikeforce->select('
    		,u.salesman_id as userId
            ,u.salesman_code as userCode
            ,u.email
        ');

   	$this->strikeforce->from('salesman u');
   	$this->strikeforce->where(' u.del_flg != ', 1);
   	$checklistId = isset($param_arr['searchInput']['checklistId']) ? $param_arr['searchInput']['checklistId'] : NULL;
   	if ($checklistId !== NULL) {
   		$this->strikeforce->where(' u.salesman_id in (SELECT uctChild.salesman_id FROM `checklist_salesman` uctChild WHERE uctChild.checklist_id ='.$checklistId.' ) ', NULL,FALSE);
   	}
   	
   	$userCode = isset($param_arr['searchInput']['userCode']) ? $param_arr['searchInput']['userCode'] : NULL;
   	if ($userCode !== NULL ) {
   		$this->strikeforce->where('(UPPER(u.salesman_code) like \'%' . strtoupper($userCode)  . '%\') ');
   	}
   	
   	$userName = isset($param_arr['searchInput']['userName']) ? $param_arr['searchInput']['userName'] : NULL;
   	if ($userName !== NULL && !empty($userName)) {
   		$this->strikeforce->where('UPPER(u.salesman_name) like \'%' . strtoupper($userName) . '%\' ');
   	}

   	return $this->strikeforce->count_all_results();
   }
   
    /**
     * Checklist controller
     * @param array $param_arr
     * @return array
     */
    public function searchUserMark($param_arr = array())
    {
        $dataResult = array(
            "userInfo"      =>  NULL,
            "pagingInfo"    =>  NULL
        );

   	$totalRow = $this->countSearchUserMark($param_arr);
   	if ( $totalRow> 0 )
   	{
   		$pagingSet = $this->setPagingInfo($totalRow, $param_arr["pagingInfo"]["crtPage"]);
   
   		$this->strikeforce->distinct();
   		$this->strikeforce->select("
             sm.salesman_id as salesmanId
            ,sm.salesman_code as salesmanCode
   			,cs.user_id as userId
   			,DATE_FORMAT(cs.create_date,'%d/%m/%Y')  as createDate
            ,sm.salesman_name as salesmanName", FALSE);
   		 
   		$this->strikeforce->from('salesman sm');
   		$this->strikeforce->join('checklist_salesman cs', "sm.salesman_id = cs.salesman_id ", 'left');
   		$this->strikeforce->where(' sm.del_flg != ', 1);

   		$userId = isset($param_arr['searchInput']['userId']) ? $param_arr['searchInput']['userId'] : NULL;
   		if ($userId !== NULL) {
   			$this->strikeforce->where('cs.user_id =',$userId);
   		}
   		
   		$checklistId = isset($param_arr['searchInput']['checklistId']) ? $param_arr['searchInput']['checklistId'] : NULL;
   		if ($checklistId !== NULL) {
   			$this->strikeforce->where('cs.checklist_id =',$checklistId);
   		}
   		 
   		$salesmanCode = isset($param_arr['searchInput']['userCode']) ? $param_arr['searchInput']['userCode'] : NULL;
   		if ($salesmanCode !== NULL ) {
   			$this->strikeforce->where('(UPPER(sm.salesman_code) like \'%' . strtoupper($salesmanCode)  . '%\') ');
   		}
   			
   		$userName = isset($param_arr['searchInput']['userName']) ? $param_arr['searchInput']['userName'] : NULL;
   		if ($userName !== NULL) {
   			$this->strikeforce->where('(UPPER(sm.salesman_name) like \'%' . strtoupper($userName) . '%\' ) ');
   		}
   		 
   		$limit = ROW_ON_PAGE;
   		$offset = $pagingSet["stRow"]-1;
   		$this->strikeforce->limit($limit, $offset);
   		$this->strikeforce->order_by('sm.salesman_name ASC, sm.salesman_code');
   		$query = $this->strikeforce->get();
   
   
   		$dataResult["userInfo"] = $query->result_array();
   		$dataResult["pagingInfo"] = $pagingSet;
        }

   		return  $dataResult;
   	}
    
    /**
     * searchUserMark
     * @param array $param_arr
     * @return mixed
     */
    private function countSearchUserMark($param_arr = array())
   {
   		$this->strikeforce->distinct();
   		$this->strikeforce->select("
             sm.salesman_id as salesmanId
            ,sm.salesman_code as salesManCode
            ,sm.salesman_name as salesmanName", FALSE);
   		 
   		$this->strikeforce->from('salesman sm');
   		$this->strikeforce->join('checklist_salesman cs', "sm.salesman_id = cs.salesman_id ");
   		$this->strikeforce->where(' sm.del_flg != ', 1);
   		$checklistId = isset($param_arr['searchInput']['checklistId']) ? $param_arr['searchInput']['checklistId'] : NULL;
   		if ($checklistId !== NULL) {
   			$this->strikeforce->where('cs.checklist_id =',$checklistId);
   		}
   		 
   		$userCode = isset($param_arr['searchInput']['userCode']) ? $param_arr['searchInput']['userCode'] : NULL;
   		if ($userCode !== NULL ) {
   			$this->strikeforce->where('(UPPER(sm.salesman_code) like \'%' . strtoupper($userCode)  . '%\') ');
   		}
   			
   		$userName = isset($param_arr['searchInput']['userName']) ? $param_arr['searchInput']['userName'] : NULL;
   		if ($userName !== NULL) {
   			$this->strikeforce->where('(UPPER(sm.salesman_name) like \'%' . strtoupper($userName) . '%\' ) ');
   		}
   		
   	return $this->strikeforce->count_all_results();
   }
   
    /**
     * Checklist controller
     * @param array $param_arr
     * @return array|mixed
     */
   public function viewAnswerData($param_arr = array())
   {
   		
	   	$this->strikeforce->select("*");
	   	$this->strikeforce->from('checklist_salesman cos');
	   	$this->strikeforce->where(' cos.del_flg != ', 1);
	   	$this->strikeforce->where(' cos.checklist_id', $param_arr["checklistId"]);
	   	$this->strikeforce->where(' cos.user_id', $param_arr["userId"]);
	   	$query = $this->strikeforce->get();
	   	
	   	$data = [];
	   	foreach ($query->result() as $row)
	   	{
	   		$data = json_decode($row->data);
	   	}
	   	return  $data;
   } 
   
    /**
     * Checklist controller
     * @param $param
     * @return null|string
     */
   public function removeUserFromChecklist($param) {
	   	if (isset($param)){
	   		$this->strikeforce->where('checklist_id', $param["checklistId"]);
	   		$this->strikeforce->where('salesman_id', $param["userId"]);
	   		$this->strikeforce->delete('checklist_salesman');
	   		return "OK";
	   	}
	   	return NULL;
   }
   
    /**
     * Checklist controller
     * @param $param
     * @return null|string
     */
    public function removeRMUserFromChecklist($param) {
        if (isset($param)){
            $this->strikeforce->where('checklist_id', $param["checklistId"]);
            $this->strikeforce->where('user_id', $param["userId"]);
            $this->strikeforce->delete('checklist_user');
            return "OK";
        }
            return NULL;
        }

    /**
     * API checklist
     * @param $salesmanId
     * @return null
     */
    public function getListChecklistBySalesman($salesmanId) {
        $this->strikeforce->select('`checklist_salesman_id` as checklistSalesmanId, salesman_id salesmanId,
                                    `che.checklist_id` as checklistId,
                                    `checklist_name` as checklistName, `create_date` as createdDate,
                                    `start_date` startDate, `end_date` as endDate');
        $this->strikeforce->from('checklist_salesman chesal');
        $this->strikeforce->join('checklist che', "che.checklist_id = chesal.checklist_id AND che.del_flg != 1");
        $this->strikeforce->where('salesman_id', $salesmanId);
        $this->strikeforce->where('chesal.del_flg != 1');

        $query = $this->strikeforce->get();
        return $query !== FALSE ? $query->result_array() : NULL;
    }

    /**
     * API checklist
     * @param $userId
     * @return null
     */
    public function getListChecklistByUser($userId) {
        $this->strikeforce->select('`checklist_user_id` as checklistUserId, `che.checklist_id` as checklistId,
                                    `checklist_name` as checklistName, chu.user_id as userId,
                                    `create_date` as createdDate, `start_date` startDate, `end_date` as endDate');
        $this->strikeforce->from('checklist_user chu');
        $this->strikeforce->join('checklist che', "che.checklist_id = chu.checklist_id AND che.del_flg != 1");
        $this->strikeforce->where('chu.user_id', $userId);
        $this->strikeforce->where('chu.del_flg != 1');

        $query = $this->strikeforce->get();
        return $query !== FALSE ? $query->result_array() : NULL;
    }
}
?>
