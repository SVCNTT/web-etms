<?php 

class Product_type_mst_model extends MY_Model
{
	public $strikeforce;

	public function __construct()
	{
		$this->strikeforce = $this->load->database(DATABASE_NAME, TRUE);
	} 
	
    /**
     * User controller
     * @param $params
     * @return mixed
     */
    public function selectProType($params, $flag_cache = TRUE)
    {
        $curr_user = get_current_profile(PLATFORM);
        $this->load->model('user_product_type_model');
        return $this->user_product_type_model->getProductTypeByRole($curr_user, $flag_cache);

//        $this->strikeforce->select('*');
//        $this->strikeforce->from('product_type_mst');
//        $this->strikeforce->where('del_flg != ', 1);
//        $clientId = isset($params["clientId"]) ? $params["clientId"] : '';
//        if (!empty($clientId)) {
//            $this->strikeforce->where('client_id', $clientId);
//        }
//        $query = $this->strikeforce->get();
//        return $query->result_array();
	}

    /**
     * Call record, checking, client detail, kpi, product, store controllers
     * @param $params
     * @return array
     */
    public function proTypeResultDto($params, $flag_cache = TRUE)
    {
        $pro_mst = $this->selectProType($params, $flag_cache);
			$data = [];
            if (isset($params["search"])){
                $data[] = array("clientId"=>NULL
                                ,"productTypeId"=>NULL
                                ,"productTypeName"=>"All");
            }
		foreach ($pro_mst as $val){
			$data[] = array("clientId"=>$val["client_id"]
							,"productTypeId"=>$val["product_type_id"]
							,"productTypeName"=>$val["product_type_name"]);
		}
		return  $data;
	}

    /**
     * Client detail
     * @param $params
     * @return string
     */
    public function  regisProductTye($params)
    {
        if (isset($params)) {
        	$profileId = get_current_profile();
                $data = array(
                            'client_id' => $params["clientId"]
                            ,'product_type_name'=>$params["productTypeName"]
                			,'cre_func_id'=>'CLI0360'
		                   	,'mod_func_id'=>'CLI0360'
		                   	,'cre_user_id'=>$profileId["user_id"]
		                   	,'mod_user_id'=>$profileId["user_id"]
		                   	,'version_no'=>DEFAULT_VERSION_NO
		                   	,'mod_ts'=>date('Y-m-d H:i:s')
                            );
                   $query =  $this->strikeforce->insert('product_type_mst',$data);

                    $message = array("proFlg"=>"OK",
                                "message"=> I0000001
                            );
                    return "OK";
            } 
        return "Empty input";
    }

    /**
     * Product model
     * @param $params
     * @return mixed
     */
    public function importProductType($params)
    {
    	$profileId = get_current_profile();
        $data = array(
                'client_id' => $params["clientId"]
                ,'product_type_name'=>$params["productTypeName"]
        		,'cre_func_id'=>'PRO1120',
                   	'mod_func_id'=>'PRO1120',
                   	'cre_user_id'=>$profileId["user_id"],
                   	'mod_user_id'=>$profileId["user_id"],
                   	'version_no'=>DEFAULT_VERSION_NO,
                   	'mod_ts'=>date('Y-m-d H:i:s')
                );
        
        $this->strikeforce->trans_start();
        $this->strikeforce->insert('product_type_mst', $data);
        $insert_id = $this->strikeforce->insert_id();
        $this->strikeforce->trans_complete();
        return  $insert_id;
    }
    
//    public function  getProductypeId($name)
//    {
//        $productTypeId = 0;
//        if ($name != '') {
//            $productTypeId = $this->getProductTypeIdByName($name);
//            if ($productTypeId == NULL) {
//                $productTypeId = $this->importProductType(array('clientId' => 1,
//                    "productTypeName" => $name));
//            }
//        }
//        return $productTypeId;
//    }
    
//    public function getProductTypeIdByName($name)
//    {
//        $this->strikeforce->select('product_type_id');
//        $this->strikeforce->from('product_type_mst');
//        $this->strikeforce->like('product_type_name', $name);
//        $query = $this->strikeforce->get();
//        return $query->result_array()[0]['product_type_id'];
//    }
    
    /**
     * Client detail controller
     * @param $params
     * @return string
     */
    public function deleteProductTye($params)
    {
            $clientId = $params["clientId"];
            $productTypeId = $params["productTypeId"];

            $this->strikeforce->where('client_id', $clientId);
            $this->strikeforce->where('product_type_id', $productTypeId);
            $query =  $this->strikeforce->update('product_type_mst',array("del_flg"=>1));

            if (!$query) {
              return $this->strikeforce->_error_message();
            }
            return "OK";
    }

    /**
     * Client detail controller
     * @param $params
     * @return string
     */
    public function updateProductTye($params)
    {
    	
    		$profileId = get_current_profile();
    	 
    	
            $clientId = $params["clientId"];
            $productTypeId = $params["productTypeId"];
            $productTypeName = $params["productTypeName"];

            $this->strikeforce->where('client_id', $clientId);
            $this->strikeforce->where('product_type_id', $productTypeId);
            $query =  $this->strikeforce->update('product_type_mst',array(
            		"product_type_name"=>$productTypeName
            		,'mod_func_id'=>'CLI0360'
            		,'mod_user_id'=>$profileId["user_id"]
            		,'mod_ts'=>date('Y-m-d H:i:s')
            ));
            if (!$query) {
              return $this->strikeforce->_error_message();
            }
            return "OK";
    }
}

?>