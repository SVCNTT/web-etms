<?php 

class Product_model extends MY_Model
{
	public $strikeforce;

	public function __construct()
	{
		$this->strikeforce = $this->load->database(DATABASE_NAME, TRUE);
	} 
	
    /**
     * Product controller
     * @param $params
     * @return mixed
     */
    public function selectProductById($params)
    {
        $this->strikeforce->select(' product_id as productId
                                     , product_type_id as productTypeId
                                      , product_group_id as productGroupId
                                      , product_model as productModel
                                      , product_name as productName
                                      , client_id as clientId
                                      , price as price
                                    ');

        $this->strikeforce->from('product'); 
        $this->strikeforce->where('del_flg != ', 1);

        $clientId = isset($params["clientId"]) ? $params["clientId"] : '';
        if (!empty($clientId)){
        	$this->strikeforce->where('client_id',$clientId);
    	}

        $productModel = isset($params["productModel"]) ? $params["productModel"] : '';
        if (!empty($productModel)){
            $this->strikeforce->where('product_model',$productModel);
        }

        $productId = isset($params["productId"]) ? $params["productId"] : '';
        if (!empty($productId)){
            $this->strikeforce->where('product_id',$productId);
        }
        $productGroupId = isset($params["productGroupId"]) ? $params["productGroupId"] : '';
        if (!empty($productGroupId)){
            $this->strikeforce->where('product_group_id',$productGroupId);
        }

        $query = $this->strikeforce->get();
        return $query->result_array();     
	}

//    public function getProductInfo($params)
//    {
//
//        $this->strikeforce->select('
//            SELECT
//             A.product_id,
//              A.product_type_id ,
//              A.product_model ,
//              A.product_name ,
//              A.client_id ,
//              A.price,
//              B.product_type_name
//            ');
//        $this->strikeforce->from('product as A');
//        $this->strikeforce->where('A.del_flg != ', 1);
//        $this->strikeforce->where('B.del_flg != ', 1);
//        $this->strikeforce->join('product_type_mst B', "A.product_type_id = B.product_type_id", "left");
//        $this->strikeforce->order_by("A.product_name", "asc");
//        $this->strikeforce->order_by("A.product_model", "asc");
//
//        $clientId = isset($params["clientId"]) ? $params["clientId"] : '';
//        if (!empty($clientId)) {
//            $this->strikeforce->where('A.client_id', $clientId);
//        }
//
//        $query = $this->strikeforce->get();
//        return $query->result_array();
//    }

    /**
     * Product controller
     * @param $pa
     * @return mixed
     */
    public function searchAllProductModelAndName($pa)
    {
        $params = isset($pa["searchInput"]) ? $pa["searchInput"] : NULL;
        $paging = isset($pa["pagingInfo"]) ? $pa["pagingInfo"] : NULL;

        $dataResult["productInfoList"] = array();
        $dataResult["pagingInfo"] = $this->setPagingInfo(0, $paging["crtPage"]);;

        $totalRow = $this->countSearchAllProductModelAndName($params); 
        if ($totalRow > 0){

        $this->strikeforce->select('p.product_id as productId
                                    ,d.product_type_name as pproductTypeName
                                    ,"" AS unitName
                                    ,p.product_name as productName
                                    ,p.product_model as productModel
                                    ,g.product_group_name as productGroupName
                                    ,p.price as price
                                    ');

        $this->strikeforce->from('product p');
        $this->strikeforce->join('client c', "p.client_id = c.client_id and c.del_flg != '1'");
        $this->strikeforce->join('product_type_mst d', "p.product_type_id = d.product_type_id");
        $this->strikeforce->join('product_group g', "p.product_group_id = g.product_group_id");

        $this->strikeforce->where('p.del_flg != ', 1);
        $this->strikeforce->where('d.del_flg != ', 1);

        $clientCode = isset($params["clientCode"]) ? $params["clientCode"] : '';
        if (!empty($clientCode)){
            $this->strikeforce->where('c.client_code',$clientCode);
        }

        $productModel = isset($params["productModel"]) ? $params["productModel"] : '';
        if (!empty($productModel)){
            $this->strikeforce->like('UPPER(p.product_model)',strtoupper($productModel));
        }

        $productName = isset($params["productName"]) ? $params["productName"] : '';
        if (!empty($productName)){
            $this->strikeforce->like('UPPER(p.product_name)',strtoupper($productName));
        }

        $productTypeId = isset($params["productTypeId"]) ? $params["productTypeId"] : '';
        if (!empty($productTypeId)){
            $this->strikeforce->where('d.product_type_id',$productTypeId);
        } 

        $productGroupId = isset($params["productGroupId"]) ? $params["productGroupId"] : '';
        if (!empty($productGroupId)){
            $this->strikeforce->where('g.product_group_id',$productGroupId);
        } 

            $curr_user = get_current_profile(PLATFORM);
            $this->load->model('user_product_type_model');
            $pt_list = $this->user_product_type_model->getProductTypeByRole($curr_user);

            if (!empty($pt_list)) {
                $pt_list_id = array();
                foreach($pt_list as $item) {
                    $pt_list_id[] = $item['product_type_id'];
                }

                $this->strikeforce->where_in('d.product_type_id',$pt_list_id);
            }

            $pagingSet = $this->setPagingInfo($totalRow, $paging["crtPage"]);

            $limit = ROW_ON_PAGE;
            $offset = $pagingSet["stRow"]-1;
            $this->strikeforce->limit($limit, $offset);
            $query = $this->strikeforce->get();

            $dataResult["productInfoList"] = $query->result_array();
            $dataResult["pagingInfo"] = $pagingSet;
        }

            return $dataResult;
        }
        
    /**
     * searchAllProductModelAndName
     * @param $params
     * @return int
     */
    private function countSearchAllProductModelAndName($params)
    {
        $this->strikeforce->select('count(*) as totalRow ');
        $this->strikeforce->from('product p');
        $this->strikeforce->join('client c', "p.client_id = c.client_id and c.del_flg != '1'");
        $this->strikeforce->join('product_type_mst d', "p.product_type_id = d.product_type_id");
        $this->strikeforce->join('product_group g', "p.product_group_id = g.product_group_id");

        $this->strikeforce->where('p.del_flg != ', 1);
        $this->strikeforce->where('d.del_flg != ', 1);

        $clientCode = isset($params["clientCode"]) ? $params["clientCode"] : '';
        if (!empty($clientCode)){
            $this->strikeforce->where('c.client_code',$clientCode);
        }

        $productModel = isset($params["productModel"]) ? $params["productModel"] : '';
        if (!empty($productModel)){
            $this->strikeforce->like('UPPER(p.product_model)',strtoupper($productModel));
        }

        $productName = isset($params["productName"]) ? $params["productName"] : '';
        if (!empty($productName)){
            $this->strikeforce->like('UPPER(p.product_name)',strtoupper($productName));
        }

        $productTypeId = isset($params["productTypeId"]) ? $params["productTypeId"] : '';
        if (!empty($productTypeId)){
            $this->strikeforce->where('d.product_type_id',$productTypeId);
        }
        $productGroupId = isset($params["productGroupId"]) ? $params["productGroupId"] : '';
        if (!empty($productGroupId)){
            $this->strikeforce->where('g.product_group_id',$productGroupId);
        } 

        $curr_user = get_current_profile(PLATFORM);
        $this->load->model('user_product_type_model');
        $pt_list = $this->user_product_type_model->getProductTypeByRole($curr_user);

        if (!empty($pt_list)) {
            $pt_list_id = array();
            foreach($pt_list as $item) {
                $pt_list_id[] = $item['product_type_id'];
            }

            $this->strikeforce->where_in('d.product_type_id',$pt_list_id);
        } else {
            return 0;
        }

        $query = $this->strikeforce->get();
        return $query->row()->totalRow;
    }

    /**
     * Product controller
     * @param $params
     * @return string
     */
    public function  regisPro($params)
    {
        if (isset($params)) {
        	$profileId = get_current_profile();
                $data = array(
                            'client_id' => $params["clientId"]
                            ,'price'=>$params["price"]
                            ,'product_group_id'=>$params["productGroupId"]
                            ,'product_name'=>$params["productName"]
                            ,'product_type_id'=>$params["productTypeId"]
                			,'cre_func_id'=>'PRO1120'
		                   	,'mod_func_id'=>'PRO1120'
		                   	,'cre_user_id'=>$profileId["user_id"]
		                   	,'mod_user_id'=>$profileId["user_id"]
		                   	,'version_no'=>DEFAULT_VERSION_NO
		                   	,'mod_ts'=>date('Y-m-d H:i:s')
                            );
                   $query =  $this->strikeforce->insert('product',$data); 
                    return "OK";
            } 
        return "Empty input";
    }

    /**
     * Product controller
     * @param $params
     * @return string
     */
    public function deleteProduct($params)
    {
        if (isset($params)) {
            $clientId = $params["clientId"];
            $productId = $params["productId"];
            $productModel = $params["productModel"];

            $this->strikeforce->where('client_id', $clientId);
            $this->strikeforce->where('product_id', $productId);
            $this->strikeforce->where('product_model', $productModel);
            $query =  $this->strikeforce->update('product',array("del_flg"=>1));
                if (!$query) {
                  return $this->strikeforce->_error_message();
                }
                return "OK";
            }
            return "Empty input";
    }

    /**
     * Product controller
     * @param $params
     * @return string
     */
    public function updateProduct($params)
    {
        if (isset($params)) {
            $clientId = $params["clientId"];
            $productId = $params["productId"];
            $productModel = $params["productModel"];
            $productName = $params["productName"];
            $productTypeId = $params["productTypeId"];
            $productGroupId = $params["productGroupId"];
            $price = $params["price"];
            $profileId = get_current_profile();

            $this->strikeforce->where('client_id', $clientId);
            $this->strikeforce->where('product_id', $productId);
            $this->strikeforce->where('del_flg != ', 1);

            $query =  $this->strikeforce->update('product',array("product_model"=>$productModel
                                                                ,"product_name"=>$productName
                                                                ,"product_type_id"=>$productTypeId
                                                                ,"product_group_id"=>$productGroupId
                                                                ,"price"=>$price
											            		,'mod_func_id'=>'PRO1120'
											            		,'mod_user_id'=>$profileId["user_id"]
											            		, 'mod_ts'=>date('Y-m-d H:i:s')
                                                                ));
                if (!$query) {
                  return $this->strikeforce->_error_message();
                }
                return "OK";
            }
            return "Empty input";
    }

    /**
     * product_import
     * @return array
     */
    private function getAllProducstExist()
    {
        $this->strikeforce->select('product_name');
        $this->strikeforce->from('product'); 
        $this->strikeforce->where('del_flg != ', 1);
        $query = $this->strikeforce->get();
        $arr = array();
        foreach ($query->result() as $value){
            array_push($arr,strtolower($value->product_name));
        }
        return $arr;
    }

    /**
     * Store model
     * @param $params
     * @return array
     */
    public function getMapProductType($params)
    {
        $this->load->model('product_type_mst_model');
        $pro_mst = $this->product_type_mst_model->selectProType($params);
        $data = [];
        foreach ($pro_mst as $val){
            $data[$val["product_type_name"]] = $val["product_type_id"];
        }
        return $data;
    }
 
    /**
     * product_import
     * @param $params
     * @return array
     */
    private function getMapProductGroup($params)
    {
        $this->load->model('product_group_model');
        $pro_mst = $this->product_group_model->selectProGroup($params);
        $data = [];
        foreach ($pro_mst as $val){
            $data[$val["product_group_name"]] = $val["product_group_id"];
        }
        return $data;
    }

    /**
     * Product controller
     * @param $imagePath
     * @param $params
     * @return string
     */
    public function product_import($imagePath, $params)
    {
        try { 
            $this->load->model('product_type_mst_model');
            $this->load->model('product_group_model');

            $this->load->library('importexcel/FileManagerImport');
            $this->filemanagerimport->getSheets($imagePath);
            $Reader =  $this->filemanagerimport->Reader;
            $Sheets = $Reader -> Sheets(); 
            $profileId = get_current_profile();

            $existed = $this->getAllProducstExist();
            $typeProduct = $this->getMapProductType($params);
            $groupProduct = $this->getMapProductGroup($params);
            
            foreach ($Sheets as $Index => $Name) {
                if ($Index == 0 ){
                    $Reader -> ChangeSheet($Index);
                    $dataInsert = [];
                    $batch = 0;
                    foreach ($Reader as $rowIndex=>$Row) {
                        if ($rowIndex > 0 ) { //bo nhung row ko sai
                            $data = array();
                            $address = "";
                            if ( count($Row) != 4) {
                                return "Please contact administrator";
                            }

                            foreach ($Row as $indexColumn=>$value) {

                                if ($indexColumn == 0) {
                                    if (in_array(strtolower($value), $existed)){
                                        goto end; 
                                    }
                                    array_push($existed,strtolower($value));
                                }

                                switch ($indexColumn){
                                    case 0:
                                        $data["product_name"]  = $value;
                                        break;
                                    case 1:
                                        $data["price"]  = $value;                                        
                                        break;
                                    case 2:
                                        if ($typeProduct[$value] != NULL) {
                                            $data["product_type_id"]  = $typeProduct[$value];

                                        }else{
                                            $productTypeId = $this->product_type_mst_model->importProductType(array('clientId' => $params["clientId"],
                                                                                                            "productTypeName"=>$value));
                                            $data["product_type_id"] = $productTypeId;
                                            $typeProduct[$value] = $productTypeId;
                                        }
                                        break; 

                                    case 3:
                                        if ($groupProduct[$value] != NULL) {
                                            $data["product_group_id"]  = $groupProduct[$value];

                                        }else{
                                            $productGroupId = $this->product_group_model->importProductGroup(array('clientId' => $params["clientId"],
                                                                                                            "productGroupName"=>$value, "productTypeId"=>$data["product_type_id"]));
                                            $data["product_group_id"] = $productGroupId;
                                            $groupProduct[$value] = $productGroupId;
                                        }
                                        break;    
                                    
                                }
                             
                            }
                            $data["client_id"]  = $params["clientId"];
                            $data["cre_func_id"]  = 'PRO1120';
                            $data["mod_func_id"]  = 'PRO1120';
                            $data["cre_user_id"]  = $profileId["user_id"];
                            $data["mod_user_id"]  = $profileId["user_id"];
                            $data["version_no"]  = DEFAULT_VERSION_NO;
                            $data["mod_ts"]  =date('Y-m-d H:i:s');
                            $dataInsert[] = $data;
                        }
                        
                        end:
                        if ($batch >= 5){
                            // var_dump($dataInsert);
                            if (!empty($dataInsert)){
                               $this->strikeforce->insert_batch('product', $dataInsert); 
                            } 
                            $dataInsert = [];
                            $batch = 0;
                            usleep(100000);                           
                        }
                        $batch++;
                    }
                    if (!empty($dataInsert)){
                     $this->strikeforce->insert_batch('product', $dataInsert); 
                    }
                }
            }
                
            $curr_user = get_current_profile(PLATFORM);
            $curr_user_id = isset($curr_user['user_id']) ? $curr_user['user_id'] : -1;

            /*Delete cache - Begin*/
            $key = 'product_type_by_role_'.date('YmdH').'_'.$curr_user_id;
            $this->load->library('authentication');
            $this->authentication->unset_data($key, PLATFORM);
            /*Delete cache - End*/

        } catch (Exception $e) {
            // echo 'Caught exception: ',  $e->getMessage(), "\n";
            return  "Please contact administrator";
        }
        return "OK";
    }

//    public function selectAllByClient($client_id = -1)
//    {
//        if ($client_id !== -1) {
//            $this->strikeforce->where(array('client_id' => $client_id));
//        }
//
//        $query = $this->strikeforce->get('product');
//        return $query !== FALSE ? $query->result_array() : FALSE;
//    }
}

?>