<?php 

class Zone_model extends MY_Model
{
	public $strikeforce;

	public function __construct()
	{
		$this->strikeforce = $this->load->database(DATABASE_NAME, TRUE);
	} 
	
    /**
     * Store model
     * @param $zoneName
     * @param $userId
     * @return mixed
     */
    public function insertZone($zoneName, $userId)
    {
		$this->strikeforce->trans_start();
		$this->strikeforce->set('cre_func_id', "STO0120");
		$this->strikeforce->set('mod_func_id', "STO0120");
		$this->strikeforce->set('cre_user_id', $userId);
		$this->strikeforce->set('mod_user_id', $userId);
		$this->strikeforce->set('version_no', DEFAULT_VERSION_NO);
		$this->strikeforce->set('mod_ts', 'CURDATE()', false);
		$this->strikeforce->set('zone_name', $zoneName);
		$this->strikeforce->insert('zone');
		$insert_id = $this->strikeforce->insert_id();
		$this->strikeforce->trans_complete();
		return $insert_id;
	}
	
//	public function insertZoneArea($zoneId, $areaId, $userId){
//		if($this->isHaveInsert($zoneId, $areaId) <= 0){
//			// the  not exists, so you can insert it.
//			 $this->startInsertZoneArea($zoneId, $areaId, $userId);
//		}
//	}

//	public function isHaveInsert($zoneId, $areaId){
//		$this->strikeforce->select('id');
//		$this->strikeforce->where(array('zone_id'=>$zoneId, 'area_id'=>$areaId));
//		$query = $this->strikeforce->get('zone_area');
//		return $query->num_rows();
//	}
		
//	public function startInsertZoneArea($zoneId, $areaId, $userId){
//		$this->strikeforce->trans_start();
//		$this->strikeforce->set('cre_func_id', "STO0120");
//		$this->strikeforce->set('mod_func_id', "STO0120");
//		$this->strikeforce->set('cre_user_id', $userId);
//		$this->strikeforce->set('mod_user_id', $userId);
//		$this->strikeforce->set('version_no', DEFAULT_VERSION_NO);
//		$this->strikeforce->set('mod_ts', 'CURDATE()', false);
//		$this->strikeforce->set('zone_id', $zoneId);
//		$this->strikeforce->set('area_id', $areaId);
//		$this->strikeforce->insert('zone_area');
//		$insert_id = $this->strikeforce->insert_id();
//		$this->strikeforce->trans_complete();
//		return $insert_id;
//	}
	
//	public function insertZoneAreaByCreateCustommer($zoneId, $areaId, $userId, $creFunc){
//
//		if($this->isHaveInsert($zoneId, $areaId) <= 0){
//			$this->strikeforce->trans_start();
//			$this->strikeforce->set('cre_func_id', $creFunc);
//			$this->strikeforce->set('mod_func_id', $creFunc);
//			$this->strikeforce->set('cre_user_id', $userId);
//			$this->strikeforce->set('mod_user_id', $userId);
//			$this->strikeforce->set('version_no', DEFAULT_VERSION_NO);
//			$this->strikeforce->set('mod_ts', 'CURDATE()', false);
//			$this->strikeforce->set('zone_id', $zoneId);
//			$this->strikeforce->set('area_id', $areaId);
//			$this->strikeforce->insert('zone_area');
//			$insert_id = $this->strikeforce->insert_id();
//			$this->strikeforce->trans_complete();
//			return $insert_id;
//		}
//	}
		
    /**
     * zoneResultDto, getMapZoneExited
     * @return mixed
     */
    private function selectAllZone()
    {
	
		$this->strikeforce->select('*');
		$this->strikeforce->from('zone');
		$this->strikeforce->where('del_flg != ', 1);
		$query = $this->strikeforce->get();
		return $query->result_array();
	}	
	
    /**
     * Store controller
     * @return array
     */
    public function zoneResultDto()
    {
		$zone = $this->selectAllZone();
		$data = [];
		foreach ($zone as $val){
			$data[] = array("zoneId"=>$val["zone_id"]
					,"zoneName"=>$val["zone_name"]);
		}
		return  $data;
	}
		
    /**
     * Store model
     * @return array
     */
    public function getMapZoneExited()
    {
        $zone = $this->selectAllZone();
        $data = [];
        foreach ($zone as $val){
            $data[$val["zone_name"]] = $val["zone_id"];
        }
        return $data;
    }
     
//    public function getZoneId($name,$userId){
//    	$zone_id = 0;
//    	if ($name != ''){
//    		$zone_id = $this->getZoneIdByName($name);
//    		if ($zone_id == NULL) $zone_id = $this->insertZone($name, $userId);
//    	}
//    	return  $zone_id;
//    }

//    public function getZoneIdByName($name){
//    	$this->strikeforce->select('zone_id');
//    	$this->strikeforce->from('zone');
//    	$this->strikeforce->like('zone_name',$name);
//    	$query = $this->strikeforce->get();
//    	return $query->result_array()[0]['zone_id'];
//    }
    }
    
?>