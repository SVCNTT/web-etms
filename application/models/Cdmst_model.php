<?php 
class Cdmst_model extends MY_Model{ 
	public $strikeforce;
	public function __construct()
	{
		$this->strikeforce = $this->load->database(DATABASE_NAME, TRUE);
	} 

    /**
     * Client controller
     * @param array $params
     * @return mixed
     */
	public function selectByExample($params = array()) {

		 $this->strikeforce->select(' group_id, code_cd, 
		 								code_name, code_val, 
		 								disp_ord, lang_key, 
		 								cre_func_id, cre_ts, 
    									cre_user_id, mod_func_id, 
    									mod_ts, mod_user_id, 
    									version_no, del_flg' );
        $this->strikeforce->from('cd_mst'); 
        $this->strikeforce->where('del_flg != ', 1);
        if (!isset($params)){
        	if (!empty($params["codeCd"])) {
        		$this->strikeforce->where('code_cd = ', $params["codeCd"]);	
        	}

        	if (!empty($params["groupId"])) {
        		$this->strikeforce->where('group_id = ', $params["groupId"]);	
        	}
        }
        $query = $this->strikeforce->get();
        return $query->result_array();
	}

    /**
     * Client controller
     * @return array
     */
	public function buildTypeClient(){
		$cd_mst_list = $this->selectByExample();
		$data = [];
		foreach ($cd_mst_list as $row){
			$dispText = "";
			if (empty($row["lang_key"])){
				$dispText = $row["code_name"];
			}else{
				if (defined($row["lang_key"])) {
				    $dispText = constant($row["lang_key"]);
				}else{
			   		$dispText = $row["lang_key"];
			   	}
				
			}
			$data[] = array(
				"groudId"=>$row["group_id"]
				,"codeCd"=>$row["code_cd"]
				,"codeName"=>$row["code_name"]
				,"codeVal"=>$row["code_val"]
				,"dispOrd"=>$row["disp_ord"]
				,"langKey"=>$row["lang_key"]
				,"dispText"=>$dispText
			);
		}
		return $data;
	}
}
?>
