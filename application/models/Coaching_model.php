<?php 

class Coaching_model extends MY_Model
{
	public $strikeforce;
	public $codeDefault = "0000000000";

	public function __construct()
	{
		$this->strikeforce = $this->load->database(DATABASE_NAME, TRUE);
	}

    /**
     * Coaching controller
     * @param $params
     * @return int|null
     */
    public function insertCoachingTemplate($params)
    {
        $insert_id = 0;
		if (isset($params)){
			if ($params["coachingTemplateId"] == 0) {
				$profileId = get_current_profile();
				$sqlGetcode = " SELECT RIGHT(`coaching_code`, LENGTH(`coaching_code`)-3) + 1 as coachingCode FROM `coaching_template` WHERE `coaching_template_id` = (SELECT MAX(`coaching_template_id`) FROM `coaching_template`) ";
				$query = $this->strikeforce->query($sqlGetcode);
				$coaching_code = $query->result_array();
				$code = $coaching_code[0]["coachingCode"]; 
				$code = "COA".substr($this->codeDefault,0,strlen($this->codeDefault) - strlen($code)).$code;
			
				$this->strikeforce->trans_start();
				$this->strikeforce->set('cre_func_id', "COA0200");
				$this->strikeforce->set('mod_func_id', "COA0200");
				$this->strikeforce->set('cre_user_id', $profileId["user_id"]);
				$this->strikeforce->set('mod_user_id', $profileId["user_id"]);
				$this->strikeforce->set('version_no', DEFAULT_VERSION_NO);
				$this->strikeforce->set('mod_ts', 'CURDATE()', false);
				
				$this->strikeforce->set('coaching_name', $params["coachingName"]);
				$this->strikeforce->set('coaching_code', $code);
				$this->strikeforce->set('start_date', "STR_TO_DATE('".$params["coachingStartday"]."','%d-%m-%Y')", false);
				$this->strikeforce->set('end_date', "STR_TO_DATE('".$params["coachingEndday"]."','%d-%m-%Y')", false);
				$this->strikeforce->insert('coaching_template');
				$insert_id = $this->strikeforce->insert_id();
				$this->strikeforce->trans_complete();
				
			}else{
				$sSQL = " UPDATE coaching_template SET coaching_name = '".$params["coachingName"]."',
										  start_date = STR_TO_DATE('".$params["coachingStartday"]."','%d-%m-%Y'),
										  end_date = STR_TO_DATE('".$params["coachingEndday"]."','%d-%m-%Y'),
  										  mod_ts = NOW()
								WHERE coaching_template_id = ".$params["coachingTemplateId"];
				$res = $this->strikeforce->query($sSQL);
				if (!$res) {
					return $this->strikeforce->_error_message();
				}
				
				$insert_id = $params["coachingTemplateId"];
			}
			
		return  $insert_id; 
			
		}else{
			return NULL;
		}
	}
	
    /**
     * Coaching controller
     * @param $params
     * @return string
     */
    public function insertSection($params)
    {
		$profileId = get_current_profile();
		$params["user_id"] = $profileId["user_id"];
		if ($params["coachingTemplateSectionId"] == ""){
		$coachingTemlateSectionId = $this->insertCoachingTemplateSection($params);
		$this->insertCoachingTemplateSectionItem($coachingTemlateSectionId, $params);
		}else{
				$this->updateCoachingTemplateSection($params);
				$this->updateCoachingTemplateSectionItem($params);
		}
		return "OK";
	}
	
    /**
     * insertSection
     * @param $params
     * @return null
     */
    private function insertCoachingTemplateSection($params)
    {
			if (isset($params)){
				
				$this->strikeforce->trans_start();
				$this->strikeforce->set('cre_func_id', "COA0220");
				$this->strikeforce->set('mod_func_id', "COA0220");
				$this->strikeforce->set('cre_user_id', $params["user_id"]);
				$this->strikeforce->set('mod_user_id', $params["user_id"]);
				$this->strikeforce->set('version_no', DEFAULT_VERSION_NO);
				$this->strikeforce->set('mod_ts', 'CURDATE()', false);
		
				$this->strikeforce->set('coaching_template_id', $params["coachingTemplateId"]);
				$this->strikeforce->set('title', $params["questionTitle"]);
				$this->strikeforce->set('section_type', $params["questionType"]);
				$this->strikeforce->set('need_to_calculate', $params["needToCalculate"]);
				$this->strikeforce->insert('coaching_template_section');
				$insert_id = $this->strikeforce->insert_id();
				$this->strikeforce->trans_complete();
				return  $insert_id;
			}else{
						return NULL;
			}
	}

    /**
     * insertSection
     * @param $params
     * @return null|string
     */
    private function updateCoachingTemplateSection($params)
    {
		if (isset($params)){
			$this->strikeforce->where('coaching_template_section_id', $params["coachingTemplateSectionId"]);
			$query =  $this->strikeforce->update('coaching_template_section',array("section_type"=>$params["questionType"], "title"=>$params["questionTitle"], "need_to_calculate"=>$params["needToCalculate"], "mod_user_id"=>$params["user_id"]));
			
			return  "OK";
		}else{
			return NULL;
		}
	}
	
    /**
     * insertSection
     * @param $params
     * @return null
     */
    private function updateCoachingTemplateSectionItem($params)
    {
		if (isset($params)){
			$arrayId =  array();
			
			foreach ($params["optionValues"] as $val){
				if (!empty($val["sectionItemTitle"])) {
				if ($val["coachingTemplateSectionItemId"] != NULL){
					
					array_push($arrayId,$val["coachingTemplateSectionItemId"]);
					
					$this->strikeforce->where('coaching_template_section_item_id', $val["coachingTemplateSectionItemId"]);
					$query =  $this->strikeforce->update('coaching_template_section_item',array("title"=>$val["sectionItemTitle"],"mod_user_id"=>$params["user_id"]));
				}else{
					
					$this->strikeforce->trans_start();
					$this->strikeforce->set('cre_func_id', "COA0220");
					$this->strikeforce->set('mod_func_id', "COA0220");
					$this->strikeforce->set('cre_user_id', $params["user_id"]);
					$this->strikeforce->set('mod_user_id', $params["user_id"]);
					$this->strikeforce->set('version_no', DEFAULT_VERSION_NO);
					$this->strikeforce->set('mod_ts', 'CURDATE()', false);
					
					$this->strikeforce->set('coaching_template_section_id', $params["coachingTemplateSectionId"]);
					$this->strikeforce->set('coaching_template_id', $params["coachingTemplateId"]);
					$this->strikeforce->set('title', $val["sectionItemTitle"]);
					$this->strikeforce->insert('coaching_template_section_item');
					$insert_id = $this->strikeforce->insert_id();
					$this->strikeforce->trans_complete();
					array_push($arrayId,$insert_id);
				}
			}
			}
			if (!empty($arrayId)){
				$this->strikeforce->where_not_in('coaching_template_section_item_id', $arrayId);
				$this->strikeforce->where('coaching_template_section_id', $params["coachingTemplateSectionId"]);
				$this->strikeforce->delete('coaching_template_section_item');
			}
		}else{
			return NULL;
		}
	}
	
    /**
     * Coaching controller
     * @param $param
     * @return null|string
     */
    public function deleteSection($param)
    {
		if (isset($param)){
			$this->strikeforce->where('coaching_template_section_id', $param["coachingTemplateSectionId"]);
			$this->strikeforce->delete('coaching_template_section_item');
			
			$this->strikeforce->where('coaching_template_section_id', $param["coachingTemplateSectionId"]);
			$this->strikeforce->delete('coaching_template_section');
			return "OK";
		}
		return NULL;
	}
	
    /**
     * insertSection
     * @param $coachingTemlateSectionId
     * @param $params
     * @return null
     */
    private function insertCoachingTemplateSectionItem($coachingTemlateSectionId, $params)
    {
		if (isset($params)){
			
			foreach ($params["optionValues"] as $val){
				if ($val != NULL){
					$this->strikeforce->trans_start();
					$this->strikeforce->set('cre_func_id', "COA0220");
					$this->strikeforce->set('mod_func_id', "COA0220");
					$this->strikeforce->set('cre_user_id', $params["user_id"]);
					$this->strikeforce->set('mod_user_id', $params["user_id"]);
					$this->strikeforce->set('version_no', DEFAULT_VERSION_NO);
					$this->strikeforce->set('mod_ts', 'CURDATE()', false);
						
					$this->strikeforce->set('coaching_template_section_id', $coachingTemlateSectionId);
					$this->strikeforce->set('coaching_template_id', $params["coachingTemplateId"]);
					$this->strikeforce->set('title', $val["sectionItemTitle"]);
					$this->strikeforce->insert('coaching_template_section_item');
					$this->strikeforce->trans_complete();
				}
			}
			 
		}else{
			return NULL;
		}
	}
	
    /**
     * Coaching controller
     * @param $params
     * @return array
     */
    public function searchCoaching($params)
    {
        $dataResult = array(
            "coaInfo"       => NULL,
            "pagingInfo"    => NULL
        );

        $totalRow  = $this->countSearchCoaching($params);

        if ($totalRow > 0) {
            $curr_page = isset($params["pagingInfo"]["crtPage"]) ? $params["pagingInfo"]["crtPage"] : 1;
            $pagingSet = $this->setPagingInfo($totalRow, $curr_page);

            $user = isset($params['profile']) ? $params['profile'] : array();
            $curr_user_id = isset($user['user_id']) ? $user['user_id'] : -1;
            if ($curr_user_id < 0) {
                return 0;
            }
            $curr_rolde_cd = isset($user['user_role_cd']) ? $user['user_role_cd'] : -1;

            $this->strikeforce->select("coa.coaching_template_id
            							, coa.coaching_code 
            		            		, coa.coaching_name 
            							, coa.create_date 
            							, DATE_FORMAT( coa.start_date ,'%d/%m/%Y') as start_date
            							, DATE_FORMAT( coa.end_date ,'%d/%m/%Y') as end_date
 											, GROUP_CONCAT(CONCAT(umst.first_name, ' ', umst.last_name) SEPARATOR ', ') as firstlast"
            						   , FALSE);
            $this->strikeforce->from('coaching_template coa'); 
            $this->strikeforce->join('user_coaching_template uct', "coa.coaching_template_id = uct.coaching_template_id", 'left');
            $this->strikeforce->join('user_mst umst', "uct.user_id = umst.user_id", 'left');
            
            $this->strikeforce->where(' coa.del_flg != ', 1);

            $coachingName = isset($params["searchInput"]['coachingName']) ? $params["searchInput"]['coachingName'] : '';
            if ($coachingName !== '') {
                $this->strikeforce->where("UPPER(coa.coaching_name) like '%".strtoupper($coachingName)."%'");
            }
            
            $coachingCode = isset($params["searchInput"]['coachingCode']) ? $params["searchInput"]['coachingCode'] : '';
            if ($coachingCode !== '') {
            	$this->strikeforce->where("UPPER(coa.coaching_code) like '%".strtoupper($coachingCode)."%'");
            }

            switch($curr_rolde_cd) {
                case ROLE_ADMIN_CD:
                case ROLE_MOD_CD:
                case ROLE_BU_CD:
                case ROLE_SALES_MANAGER_CD:
                    break;

                case ROLE_REGION_MANAGER_CD:
                    $this->strikeforce->where(' umst.user_id = '.$curr_user_id . ' ');
                    break;
            }

            $limit = ROW_ON_PAGE;
            $offset = $pagingSet["stRow"]-1;
            $this->strikeforce->limit($limit, $offset);
            $this->strikeforce->group_by('coa.coaching_template_id');
            $this->strikeforce->order_by('coa.create_date DESC ');
            
            $query = $this->strikeforce->get();


            $dataResult["coaInfo"] = $query->result_array();
            $dataResult["pagingInfo"] = $pagingSet;
        }

        return $dataResult;
    }

    /**
     * searchCoaching
     * @param $params
     * @return int
     */
    private function countSearchCoaching($params)
    {
        $user = isset($params['profile']) ? $params['profile'] : array();
        $curr_user_id = isset($user['user_id']) ? $user['user_id'] : -1;
        if ($curr_user_id < 0) {
            return 0;
        }
        $curr_rolde_cd = isset($user['user_role_cd']) ? $user['user_role_cd'] : -1;

        $this->strikeforce->select('coa.coaching_template_id');

        $this->strikeforce->from('coaching_template coa'); 
        $this->strikeforce->join('user_coaching_template uct', "coa.coaching_template_id = uct.coaching_template_id", 'left');
        $this->strikeforce->join('user_mst umst', "uct.user_id = umst.user_id", 'left');
        $this->strikeforce->where(' coa.del_flg != ', 1);

        $coachingName = isset($params["searchInput"]['coachingName']) ? $params["searchInput"]['coachingName'] : '';
        if ($coachingName !== '') {
            $this->strikeforce->where("UPPER(coa.coaching_name) like '%".strtoupper($coachingName)."%'");
        }
        $coachingCode = isset($params["searchInput"]['coachingCode']) ? $params["searchInput"]['coachingCode'] : '';
        if ($coachingCode !== '') {
        	$this->strikeforce->where("UPPER(coa.coaching_code) like '%".strtoupper($coachingCode)."%'");
        }

        switch($curr_rolde_cd) {
            case ROLE_ADMIN_CD:
            case ROLE_MOD_CD:
            case ROLE_BU_CD:
            case ROLE_SALES_MANAGER_CD:
                break;

            case ROLE_REGION_MANAGER_CD:
                $this->strikeforce->where(' umst.user_id = '.$curr_user_id . ' ');
                break;

            default:
                return 0;
        }

        $this->strikeforce->group_by('coa.coaching_template_id');
        $query = $this->strikeforce->get();

    	return count($query->result_array());
    }
	
    /**
     * Coaching controller
     * @param $params
     * @return array
     */
    public function coachingSection($params)
    {
        $dataResult = array(
            "coaSectionInfo" => NULL
        );

    	if (isset($params)) {
    		$this->strikeforce->select('coas.coaching_template_section_id
    				,coas.coaching_template_id
    				,coas.title
    				,coas.section_type					
    				');
    		$this->strikeforce->from('coaching_template_section coas');
    		$this->strikeforce->where(' coas.del_flg != ', 1);
    		 
    
    		$coachingTemplateId = isset($params["coachingTemplateId"]) ? $params["coachingTemplateId"] : 0;
    		$this->strikeforce->where(" coas.coaching_template_id = ".$coachingTemplateId);
    		$query = $this->strikeforce->get();
    		
    		$dataLoop = [];
            foreach ($query->result() as $row) {
    			
    			$this->strikeforce->select('*');
    			$this->strikeforce->from('coaching_template_section_item item');
    			$this->strikeforce->where(' item.del_flg != ', 1);
    			
    			$this->strikeforce->where(" item.coaching_template_section_id = ".$row->coaching_template_section_id);
    			$queryItem = $this->strikeforce->get();
    			$dataLoopItem = [];
                foreach ($queryItem->result() as $rowItem) {
    				$dataItem["coaching_template_section_item_id"] = $rowItem->coaching_template_section_item_id;
    				$dataItem["section_item_title"] = $rowItem->title;
    				$dataLoopItem[] = $dataItem;
    			}
    			$data["coaching_template_section_id"] = $row->coaching_template_section_id;
    			$data["coaching_template_id"] = $row->coaching_template_id;
    			$data["section_title"] = $row->title;
    			$data["section_type"] = $row->section_type;
    			$data["sectionItems"] = $dataLoopItem;
    			$dataLoop[] = $data;
    		}
    		
    		$dataResult["coaSectionInfo"] = $dataLoop;
        }

    		return  $dataResult;
    
    }

    /**
     * Coaching controller
     * @param $params
     * @return array
     */
    public function coachingSectionById($params)
    {
        $data["coaching_template_section_id"] = NULL;
        $data["coaching_template_id"] = NULL;
        $data["questionTitle"] = NULL;
        $data["questionType"] = NULL;
        $data["needToCalculate"] = NULL;
        $data["optionValues"] = [];

    	if (isset($params) && isset($params["coachingTemplateSectionId"]) ) {
    		$this->strikeforce->select('coas.coaching_template_section_id
    				,coas.coaching_template_id
    				,coas.title
    				,coas.section_type
    				,coas.need_to_calculate
    				');
    		$this->strikeforce->from('coaching_template_section coas');
    		$this->strikeforce->where(' coas.del_flg != ', 1);
    		 
    
    		$coachingTemplateSectionId = isset($params["coachingTemplateSectionId"]) ? $params["coachingTemplateSectionId"] : 0;
    		$this->strikeforce->where(" coas.coaching_template_section_id = ".$coachingTemplateSectionId);
    		$query = $this->strikeforce->get();
    
            foreach ($query->result() as $row) {
    			 
    			$this->strikeforce->select('*');
    			$this->strikeforce->from('coaching_template_section_item item');
    			$this->strikeforce->where(' item.del_flg != ', 1);
    			 
    			$this->strikeforce->where(" item.coaching_template_section_id = ".$row->coaching_template_section_id);
    			$queryItem = $this->strikeforce->get();
    			$dataLoopItem = [];
                foreach ($queryItem->result() as $rowItem) {
    				$dataItem["coachingTemplateSectionItemId"] = $rowItem->coaching_template_section_item_id;
    				$dataItem["sectionItemTitle"] = $rowItem->title;
    				$dataLoopItem[] = $dataItem;
    			}
    			$data["coaching_template_section_id"] = $row->coaching_template_section_id;
    			$data["coaching_template_id"] = $row->coaching_template_id;
    			$data["questionTitle"] = $row->title;
    			$data["questionType"] = $row->section_type;
    			$data["needToCalculate"] = $row->need_to_calculate;
    			$data["optionValues"] = $dataLoopItem;
    		}
        }
    
    		return  $data;
    	}
	 
    /**
     * Coaching controller
     * @param array $param_arr
     * @return array
     */
    public function searchUserNotAssign($param_arr = array())
    {
        $dataResult = array(
            "userInfo"      => NULL,
            "pagingInfo"    => NULL
        );

    	$totalRow = $this->countSearchUserNotAssign($param_arr);
        if ($totalRow > 0) {
    		$pagingSet = $this->setPagingInfo($totalRow, $param_arr["pagingInfo"]["crtPage"]);
    	
    		$this->strikeforce->distinct();
    		$this->strikeforce->select("
             u.user_id as userId
            ,u.user_code as userCode
            ,u.email
            ,u.user_sts as userSts
            ,u.user_role_cd as userRoleCd
            ,u.phone_no as phone
            ,u.first_name as firstName
            ,u.last_name as lastName
            ,concat(u.last_name, ' ', u.first_name) as fullName
            ,u.parent_id as parentId", FALSE);
    		
    		$this->strikeforce->from('user_mst u');
    		$this->strikeforce->join('client c', "u.client_id = c.client_id and c.del_flg != '1'", 'left');
    		$this->strikeforce->where(' u.del_flg != ', 1);
    		$this->strikeforce->where(' u.user_role_cd = ', ROLE_REGION_MANAGER_CD);
    		$this->strikeforce->where('c.client_id', 1);
    		
    		$userCode = isset($param_arr['searchInput']['userCode']) ? $param_arr['searchInput']['userCode'] : NULL;
    		if ($userCode !== NULL ) {
    			$this->strikeforce->where('(UPPER(u.user_code) like \'%' . strtoupper($userCode)  . '%\') ');
    		}
    		
    		$userName = isset($param_arr['searchInput']['userName']) ? $param_arr['searchInput']['userName'] : NULL;
    		if ($userName !== NULL && !empty($userName)) {
    			$this->strikeforce->where('(UPPER(u.first_name) like \'%' . strtoupper($userName) . '%\' OR UPPER(u.last_name) like \'%' . strtoupper($userName) . '%\') ');
    		}
    		$coachingTemplateId = isset($param_arr['searchInput']['coachingTemplateId']) ? $param_arr['searchInput']['coachingTemplateId'] : NULL;
    		if ($coachingTemplateId !== NULL) {
    			$this->strikeforce->where(' u.user_id not in (SELECT uctChild.user_id FROM `user_coaching_template` uctChild WHERE uctChild.coaching_template_id ='.$coachingTemplateId.' ) ', NULL,FALSE);
    		}
    		
    		$limit = ROW_ON_PAGE;
    		$offset = $pagingSet["stRow"]-1;
    		$this->strikeforce->limit($limit, $offset);
    		$this->strikeforce->order_by('c.client_name ASC, u.user_code');
    		$query = $this->strikeforce->get();
    	
    	
    		$dataResult["userInfo"] = $query->result_array();
    		$dataResult["pagingInfo"] = $pagingSet;
        }

    		return  $dataResult;
    	}
    
    /**
     * searchUserNotAssign
     * @param array $param_arr
     * @return mixed
     */
    private function countSearchUserNotAssign($param_arr = array())
    {
    	$this->strikeforce->distinct();
    	$this->strikeforce->select('
            c.client_id as clientId
            ,c.client_code as clientCode
            ,c.client_name as clientName
    		,u.user_id as userId
            ,u.user_code as userCode
            ,u.email
        ');
    
    	$this->strikeforce->from('user_mst u');
    	$this->strikeforce->join('client c', "u.client_id = c.client_id and c.del_flg != '1'", 'left');
    	$this->strikeforce->where(' u.del_flg != ', 1);
    	$this->strikeforce->where(' u.user_role_cd = ', ROLE_REGION_MANAGER_CD);
    	$this->strikeforce->where('c.client_id', 1);
    
    	$userCode = isset($param_arr['searchInput']['userCode']) ? $param_arr['searchInput']['userCode'] : NULL;
    	if ($userCode !== NULL ) {
    		$this->strikeforce->where('(UPPER(u.user_code) like \'%' . strtoupper($userCode)  . '%\') ');
    	}
    	
    	$userName = isset($param_arr['searchInput']['userName']) ? $param_arr['searchInput']['userName'] : NULL;
    	if ($userName !== NULL && !empty($userName)) {
    		$this->strikeforce->where('(UPPER(u.first_name) like \'%' . strtoupper($userName) . '%\' OR UPPER(u.last_name) like \'%' . strtoupper($userName) . '%\') ');
    	}
    	
    	$coachingTemplateId = isset($param_arr['searchInput']['coachingTemplateId']) ? $param_arr['searchInput']['coachingTemplateId'] : NULL;
    	if ($coachingTemplateId !== NULL) {
    		$this->strikeforce->where(' u.user_id not in (SELECT uctChild.user_id FROM `user_coaching_template` uctChild WHERE uctChild.coaching_template_id ='.$coachingTemplateId.' ) ', NULL,FALSE);
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
//        $this->strikeforce->where(' u.user_role_cd = ', ROLE_REGION_MANAGER_CD);
//        $this->strikeforce->where('c.client_id', 1);
//
//        $coachingTemplateId = isset($param_arr['coachingTemplateId']) ? $param_arr['coachingTemplateId'] : NULL;
//        if ($coachingTemplateId !== NULL) {
//            $this->strikeforce->where(' u.user_id in (SELECT uctChild.user_id FROM `user_coaching_template` uctChild WHERE uctChild.coaching_template_id =' . $coachingTemplateId . ' ) ', NULL, FALSE);
//        }
//        $query = $this->strikeforce->get();
//        $data = [];
//        foreach ($query->result() as $row) {
//            $data[] = $row->userId;
//
//        }
//        return $data;
//    }
    
    /**
     * Coaching controller
     * @param $param
     * @return null|string
     */
    public function assignUserCoaching($param)
    {
    		if (isset($param)){
    			//insert again
    			$this->assignUserCoachingChild($param);
    			return "OK";
    			
    		}
    		return NULL;
   }
   
    /**
     * assignUserCoaching
     * @param $params
     * @return null
     */
    private function assignUserCoachingChild($params)
    {
   	if (isset($params)){
   		$profileId = get_current_profile();
   		
   		foreach ($params["userIdList"] as $val){
   			if ($val != NULL){
   				$this->strikeforce->trans_start();
   				$this->strikeforce->set('cre_func_id', "COA0330");
   				$this->strikeforce->set('mod_func_id', "COA0330");
   				$this->strikeforce->set('cre_user_id', $profileId["user_id"]);
   				$this->strikeforce->set('mod_user_id', $profileId["user_id"]);
   				$this->strikeforce->set('version_no', DEFAULT_VERSION_NO);
   				$this->strikeforce->set('mod_ts', 'CURDATE()', false);
   
   				$this->strikeforce->set('coaching_template_id', $params["coachingTemplateId"]);
   				$this->strikeforce->set('user_id', $val);
   				$this->strikeforce->insert('user_coaching_template');
   				$this->strikeforce->trans_complete();
   			}
   		}
   
   	}else{
   		return NULL;
   	}
   }
   
    /**
     * Coaching controller
     * @param $idCode
     * @return array
     */
    public function  getTemplateByCode($idCode)
    {
    		$this->strikeforce->select("*");
    		$this->strikeforce->from('coaching_template coa');
    		$this->strikeforce->where(' coa.del_flg != ', 1);
    		$this->strikeforce->where(' coa.coaching_code', $idCode);
    		$query = $this->strikeforce->get();
    		
    		$data = [];
        $data["coachingTemplateId"] = NULL;
        $data["coachingName"] = NULL;
        $data["startDay"] = NULL;
        $data["endDay"] = NULL;
        foreach ($query->result() as $row) {
    			$data["coachingTemplateId"] = $row->coaching_template_id;
    			$data["coachingName"] = $row->coaching_name;
    			$data["startDay"] = $row->start_date;
    			$data["endDay"] = $row->end_date;
    		}
    		return  $data;
   }
   
    /**
     * Coaching controller
     * @param $params
     * @return string
     */
    public function deleteCoaching($params)
    {
   	if (isset($params)) {
   		$coachingTemplateId = $params["coachingTemplateId"];
   		$this->strikeforce->where('coaching_template_id', $coachingTemplateId);
   		$query =  $this->strikeforce->update('coaching_template',array("del_flg"=>1));
   		if (!$query) {
   			return $this->strikeforce->_error_message();
   		}
   		return "OK";
   	}
   	return "Empty input";
   }
   
    /**
     * Coaching controller
     * @param array $param_arr
     * @return array
     */
   public function searchUserAssign($param_arr = array())
   {
        $dataResult = array(
            "userInfo"      => NULL,
            "pagingInfo"    => NULL
        );

   	$totalRow = $this->countSearchUserAssign($param_arr);
        if ($totalRow > 0) {
   		$pagingSet = $this->setPagingInfo($totalRow, $param_arr["pagingInfo"]["crtPage"]);
   		 
            $user = isset($param_arr['profile']) ? $param_arr['profile'] : array();
            $curr_user_id = isset($user['user_id']) ? $user['user_id'] : -1;
            if ($curr_user_id < 0) {
                return 0;
            }
            $curr_rolde_cd = isset($user['user_role_cd']) ? $user['user_role_cd'] : -1;

   		$this->strikeforce->distinct();
   		$this->strikeforce->select("
             u.user_id as userId
            ,u.user_code as userCode
            ,u.email
            ,u.user_sts as userSts
            ,u.user_role_cd as userRoleCd
            ,u.phone_no as phone
            ,u.first_name as firstName
            ,u.last_name as lastName
            ,concat(u.last_name, ' ', u.first_name) as fullName
            ,u.parent_id as parentId", FALSE);
   
   		$this->strikeforce->from('user_mst u');
   		$this->strikeforce->join('client c', "u.client_id = c.client_id and c.del_flg != '1'", 'left');
   		$this->strikeforce->where(' u.del_flg != ', 1);
   		$this->strikeforce->where('c.client_id', 1);
   		$coachingTemplateId = isset($param_arr['searchInput']['coachingTemplateId']) ? $param_arr['searchInput']['coachingTemplateId'] : NULL;
   		if ($coachingTemplateId !== NULL) {
   			$this->strikeforce->where(' u.user_id in (SELECT uctChild.user_id FROM `user_coaching_template` uctChild WHERE uctChild.coaching_template_id ='.$coachingTemplateId.' ) ', NULL,FALSE);
   		}
   		
   		$userCode = isset($param_arr['searchInput']['userCode']) ? $param_arr['searchInput']['userCode'] : NULL;
   		if ($userCode !== NULL ) {
   			$this->strikeforce->where('(UPPER(u.user_code) like \'%' . strtoupper($userCode)  . '%\') ');
   		}
   		  		
   		$userName = isset($param_arr['searchInput']['userName']) ? $param_arr['searchInput']['userName'] : NULL;
   		if ($userName !== NULL) {
   			$this->strikeforce->where('(UPPER(u.first_name) like \'%' . strtoupper($userName) . '%\' OR UPPER(u.last_name) like \'%' . strtoupper($userName) . '%\') ');
   		}
   
            switch($curr_rolde_cd) {
                case ROLE_ADMIN_CD:
                case ROLE_MOD_CD:
                case ROLE_BU_CD:
                case ROLE_SALES_MANAGER_CD:
                    break;

                case ROLE_REGION_MANAGER_CD:
                    $this->strikeforce->where(' u.user_id = '.$curr_user_id . ' ');
                    break;
            }

   		$limit = ROW_ON_PAGE;
   		$offset = $pagingSet["stRow"]-1;
   		$this->strikeforce->limit($limit, $offset);
   		$this->strikeforce->order_by('c.client_name ASC, u.user_code');
   		$query = $this->strikeforce->get();
   		 
   		 
   		$dataResult["userInfo"] = $query->result_array();
   		$dataResult["pagingInfo"] = $pagingSet;
        }

   		return  $dataResult;
   	}
   
    /**
     * searchUserAssign
     * @param array $param_arr
     * @return int
     */
    private function countSearchUserAssign($param_arr = array())
   {
        $user = isset($param_arr['profile']) ? $param_arr['profile'] : array();
        $curr_user_id = isset($user['user_id']) ? $user['user_id'] : -1;
        if ($curr_user_id < 0) {
            return 0;
        }
        $curr_rolde_cd = isset($user['user_role_cd']) ? $user['user_role_cd'] : -1;

   	$this->strikeforce->distinct();
   	$this->strikeforce->select('
            c.client_id as clientId
            ,c.client_code as clientCode
            ,c.client_name as clientName
    		,u.user_id as userId
            ,u.user_code as userCode
            ,u.email
        ');
   
   	$this->strikeforce->from('user_mst u');
   	$this->strikeforce->join('client c', "u.client_id = c.client_id and c.del_flg != '1'", 'left');
   	$this->strikeforce->where(' u.del_flg != ', 1);
   	$this->strikeforce->where('c.client_id', 1);
   	$coachingTemplateId = isset($param_arr['searchInput']['coachingTemplateId']) ? $param_arr['searchInput']['coachingTemplateId'] : NULL;
   	if ($coachingTemplateId !== NULL) {
   		$this->strikeforce->where(' u.user_id in (SELECT uctChild.user_id FROM `user_coaching_template` uctChild WHERE uctChild.coaching_template_id ='.$coachingTemplateId.' ) ', NULL,FALSE);
   	}
   	
   	$userCode = isset($param_arr['searchInput']['userCode']) ? $param_arr['searchInput']['userCode'] : NULL;
   	if ($userCode !== NULL ) {
   		$this->strikeforce->where('(UPPER(u.user_code) like \'%' . strtoupper($userCode)  . '%\') ');
   	}
   	
   	$userName = isset($param_arr['searchInput']['userName']) ? $param_arr['searchInput']['userName'] : NULL;
   	if ($userName !== NULL && !empty($userName)) {
   		$this->strikeforce->where('(UPPER(u.first_name) like \'%' . strtoupper($userName) . '%\' OR UPPER(u.last_name) like \'%' . strtoupper($userName) . '%\') ');
   	}

        switch($curr_rolde_cd) {
            case ROLE_ADMIN_CD:
            case ROLE_MOD_CD:
            case ROLE_BU_CD:
            case ROLE_SALES_MANAGER_CD:
                break;

            case ROLE_REGION_MANAGER_CD:
                $this->strikeforce->where(' u.user_id = '.$curr_user_id . ' ');
                break;

            default:
                return 0;
        }

   	return $this->strikeforce->count_all_results();
   }
   
    /**
     * Coaching controller
     * @param array $param_arr
     * @return array
     */
   public function searchUserMark($param_arr = array())
   {
        $dataResult = array(
            "userInfo"      => NULL,
            "pagingInfo"    => NULL
        );

   	$totalRow = $this->countSearchUserMark($param_arr);
        if ($totalRow > 0) {
   		$pagingSet = $this->setPagingInfo($totalRow, $param_arr["pagingInfo"]["crtPage"]);
   
   		$this->strikeforce->distinct();
   		$this->strikeforce->select("
             sm.salesman_id as salesmanId,
             sm.salesman_code as salesmanCode,
			 cs.coaching_salesman_id as coachingSalesmanId,
             cs.user_id as userId,
             GROUP_CONCAT(CONCAT(CASE WHEN st.doctor_name = '' THEN st.store_name ELSE st.doctor_name END) SEPARATOR ', ') as stores,
             DATE_FORMAT(cs.create_date,'%d/%m/%Y')  as createDate,
             sm.salesman_name as salesmanName", FALSE);
   		 
   		$this->strikeforce->from('salesman sm');
            $this->strikeforce->join('coaching_salesman cs', "sm.salesman_id = cs.salesman_id ");
   		$this->strikeforce->join('coaching_store cst', "cst.coaching_id = cs.coaching_salesman_id ", 'left');
   		$this->strikeforce->join('store st', "cst.store_id = st.store_id", 'left');
   		$this->strikeforce->where(' sm.del_flg != ', 1);

   		$userId = isset($param_arr['searchInput']['userId']) ? $param_arr['searchInput']['userId'] : NULL;
   		if ($userId !== NULL) {
   			$this->strikeforce->where('cs.user_id =',$userId);
   		}
   		
   		$coachingTemplateId = isset($param_arr['searchInput']['coachingTemplateId']) ? $param_arr['searchInput']['coachingTemplateId'] : NULL;
   		if ($coachingTemplateId !== NULL) {
   			$this->strikeforce->where('cs.coaching_template_id =',$coachingTemplateId);
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
        $this->strikeforce->group_by('cs.coaching_salesman_id');
   		$this->strikeforce->order_by('cs.coaching_salesman_id desc');
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
			,cs.coaching_salesman_id
            ,cs.user_id as userId
            ,GROUP_CONCAT(CONCAT(CASE WHEN st.doctor_name = '' THEN st.store_name ELSE st.doctor_name END) SEPARATOR ', ') as stores
            ,DATE_FORMAT(cs.create_date,'%d/%m/%Y')  as createDate
            ,sm.salesman_name as salesmanName", FALSE);
   		 
   		$this->strikeforce->from('salesman sm');
   		$this->strikeforce->join('coaching_salesman cs', "sm.salesman_id = cs.salesman_id ");
        $this->strikeforce->join('coaching_store cst', "cst.coaching_id = cs.coaching_salesman_id ", 'left');
        $this->strikeforce->join('store st', "cst.store_id = st.store_id", 'left');
   		$this->strikeforce->where(' sm.del_flg != ', 1);

        $userId = isset($param_arr['searchInput']['userId']) ? $param_arr['searchInput']['userId'] : NULL;
        if ($userId !== NULL) {
            $this->strikeforce->where('cs.user_id =', $userId);
        }

   		$coachingTemplateId = isset($param_arr['searchInput']['coachingTemplateId']) ? $param_arr['searchInput']['coachingTemplateId'] : NULL;
   		if ($coachingTemplateId !== NULL) {
   			$this->strikeforce->where('cs.coaching_template_id =',$coachingTemplateId);
   		}
   		 
   		$userCode = isset($param_arr['searchInput']['userCode']) ? $param_arr['searchInput']['userCode'] : NULL;
   		if ($userCode !== NULL ) {
   			$this->strikeforce->where('(UPPER(sm.salesman_code) like \'%' . strtoupper($userCode)  . '%\') ');
   		}
   			
   		$userName = isset($param_arr['searchInput']['userName']) ? $param_arr['searchInput']['userName'] : NULL;
   		if ($userName !== NULL) {
   			$this->strikeforce->where('(UPPER(sm.salesman_name) like \'%' . strtoupper($userName) . '%\' ) ');
   		}
   		
        $this->strikeforce->group_by('cs.coaching_salesman_id');

   	return $this->strikeforce->count_all_results();
   }
   
    /**
     * Coaching controller
     * @param array $param_arr
     * @return array|mixed
     */
   public function viewAnswerData($param_arr = array())
   {
   		
	   	$this->strikeforce->select("*");
	   	$this->strikeforce->from('coaching_salesman cos');
	   	$this->strikeforce->where(' cos.del_flg != ', 1);
        //$this->strikeforce->where(' cos.coaching_template_id', $param_arr["coachingTemplateId"]);
        //$this->strikeforce->where(' cos.user_id', $param_arr["userId"]);
        $this->strikeforce->where(' cos.coaching_salesman_id', $param_arr["coachingSalesmanId"]);
	   	$query = $this->strikeforce->get();
	   	
	   	$data = [];
        foreach ($query->result() as $row) {
	   		$data = json_decode($row->data);
	   	}
	   	return  $data;
   } 
   
    /**
     * Coaching controller
     * @param $param
     * @return null|string
     */
    public function removeUserFromCoaching($param)
    {
	   	if (isset($param)){
	   		$this->strikeforce->where('coaching_template_id', $param["coachingTemplateId"]);
	   		$this->strikeforce->where('user_id', $param["userId"]);
	   		$this->strikeforce->delete('user_coaching_template');
	   		return "OK";
	   	}
	   	return NULL;
   }
}
?>
