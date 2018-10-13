<?php 

class Product_group_model extends MY_Model
{
	public $strikeforce;

	public function __construct()
	{
		$this->strikeforce = $this->load->database(DATABASE_NAME, TRUE);
	} 

    /**
     * Product model
     * @param $params
     * @return mixed
     */
    public function importProductGroup($params)
    {
    	$profileId = get_current_profile();
        $data = array(
                'client_id' => $params["clientId"]
                ,'product_group_name'=>$params["productGroupName"]
                ,'product_type_id'=>$params["productTypeId"]
        		,'cre_func_id'=>'PRO1120',
                   	'mod_func_id'=>'PRO1120',
                   	'cre_user_id'=>$profileId["user_id"],
                   	'mod_user_id'=>$profileId["user_id"],
                   	'version_no'=>DEFAULT_VERSION_NO,
                   	'mod_ts'=>date('Y-m-d H:i:s')
                );
        $this->strikeforce->trans_start();
        $this->strikeforce->insert('product_group', $data);
        $insert_id = $this->strikeforce->insert_id();
        $this->strikeforce->trans_complete();
        return  $insert_id;
    }

    /**
     * Product model
     * @param $params
     * @return array
     */
    public function selectProGroup($params)
    {
        $this->strikeforce->select('*');
        $this->strikeforce->from('product_group'); 
        $this->strikeforce->where('del_flg != ', 1);
        $clientId = isset($params["clientId"]) ? $params["clientId"] : '';
        if (!empty($clientId)){
            $this->strikeforce->where('client_id',$clientId);
        }

        $productTypeId = isset($params["productTypeId"]) ? intval($params["productTypeId"]) : '';
        if ($productTypeId !== ''){
        	$this->strikeforce->where('product_type_id',$productTypeId);
        } else {
            $curr_user = get_current_profile(PLATFORM);
            $this->load->model('user_product_type_model');
            $pt_list = $this->user_product_type_model->getProductTypeByRole($curr_user);

            if (!empty($pt_list)) {
                $pt_list_id = array();
                foreach($pt_list as $item) {
                    $pt_list_id[] = $item['product_type_id'];
                }

                $this->strikeforce->where_in('product_type_id',$pt_list_id);
            } else {
                return array();
            }
        }
        
        $query = $this->strikeforce->get();
        return $query->result_array();     
    }

    /**
     * Client detail controller, Product controller
     * @param $params
     * @return array
     */
    public function proGroupResultDto($params)
    {
        $pro_group = $this->selectProGroup($params);
            $data = [];
            if (isset($params["search"])){
                $data[] = array("clientId"=>NULL
                                ,"productGroupId"=>NULL
                                ,"productGroupName"=>"All");
            }
        foreach ($pro_group as $val){
            $data[] = array("clientId"=>$val["client_id"]
                            ,"productGroupId"=>$val["product_group_id"]
                            ,"productGroupName"=>$val["product_group_name"]);
        }
        return  $data;
    }

    /**
     * Call record controller
     * @param $params
     * @return mixed
     */
    public function searchProductGroupByName($params)
    {
        $this->strikeforce->select('*');
        $this->strikeforce->from('product_group');
        $this->strikeforce->where('del_flg != ', 1);
        $this->strikeforce->order_by('product_group_name asc');

        $productGroupName = isset($params["productGroupName"]) ? $params["productGroupName"] : '';
        if (!empty($productGroupName)){
            $this->strikeforce->like('product_group_name', $productGroupName);
        }
        $limit = isset($params['limit']) ? $params['limit'] : NULL;
        $offset = isset($params['offset']) ? $params['offset'] : NULL;
        if ($limit !== NULL && $offset !== NULL) {
            $this->strikeforce->limit($limit, $offset);
        }

        $query = $this->strikeforce->get();
        return $query->result_array();
    }

    /**
     * Call record controller
     * @param $params
     * @return mixed
     */
    public function countProductGroupByName($params)
    {
        $this->strikeforce->select('*');
        $this->strikeforce->from('product_group');
        $this->strikeforce->where('del_flg != ', 1);

        $productGroupName = isset($params["productGroupName"]) ? $params["productGroupName"] : '';
        if (!empty($productGroupName)){
            $this->strikeforce->like('product_group_name', $productGroupName);
        }
        return $this->strikeforce->count_all_results();
    }

    /**
     * API saleman
     * @param $user_id
     * @return array
     */
    public function selectByUserId($user_id)
    {
        $this->strikeforce->distinct();
        $this->strikeforce->select('a.*, a.product_group_id as id, a.product_group_name as name', FALSE);
        $this->strikeforce->from('product_group a');
        $this->strikeforce->join('user_product_type c', 'a.product_type_id = c.product_type_id', 'inner');
        $this->strikeforce->where(array('c.user_id'=>$user_id, 'a.del_flg !='=>1));
        $query = $this->strikeforce->get();
        return $query !== FALSE ? $query->result_array() : [];
    }

    /**
     * Call record controller
     * @return null
     */
    public function selectAll()
    {
        $query = $this->strikeforce->get_where('product_group', array('del_flg !=' => 1));
        return $query != FALSE ? $query->result_array() : NULL;
    }

    /**
     * Call record controller
     * @param $user
     * @return array
     */
    public function getProductGroupByRole($user)
    {
        $result = array();

        $curr_user_id = isset($user['user_id']) ? $user['user_id'] : -1;
        if ($curr_user_id < 0) {
            return $result;
        }

        /*Get cache - Begin*/
        $key = 'product_group_by_role_'.date('YmdH').'_'.$curr_user_id;
        $this->load->library('authentication');
        $result = $this->authentication->get_data($key, PLATFORM);
        if ($result !== FALSE) {
            return $result;
        }
        /*Bet cache - End*/


        $curr_rolde_cd = isset($user['user_role_cd']) ? $user['user_role_cd'] : -1;

        $result = array();
        switch($curr_rolde_cd) {
            case ROLE_ADMIN_CD:
            case ROLE_MOD_CD:
                //Get all
                $this->strikeforce->distinct();
                $this->strikeforce->where(array('del_flg !=' => 1));
                $this->strikeforce->order_by('product_group_name asc');
                $query = $this->strikeforce->get('product_group');
                $result = $query !== FALSE ? $query->result_array() : array();
                break;

            case ROLE_BU_CD:
            case ROLE_SALES_MANAGER_CD:
            case ROLE_REGION_MANAGER_CD:
                $this->load->model('user_product_type_model');
                $arr_product_type = $this->user_product_type_model->getProductTypeByRole($user);

                if (!empty($arr_product_type)) {
                    $arr_product_type_id = array();
                    foreach($arr_product_type as $temp) {
                        $arr_product_type_id[] = $temp['product_type_id'];
                    }

                    $this->strikeforce->distinct();
                    $this->strikeforce->where(array('del_flg !=' => 1));
                    $this->strikeforce->where_in('product_type_id', $arr_product_type_id);
                    $this->strikeforce->order_by('product_group_name asc');
                    $query = $this->strikeforce->get('product_group');
                    $result = $query !== FALSE ? $query->result_array() : array();
                }
                break;
        }

        /*Store SESSION - Begin*/
        $this->authentication->set_data($key, $result, PLATFORM);
        /*Store SESSION - End*/

        return $result;
    }

    /**
     * Client detail controller
     * @param $params
     * @return string
     */
    public function  regisProductGroup($params)
    {
        if (isset($params)) {
        	$profileId = get_current_profile();
                $data = array(
                            'client_id' => $params["clientId"]
														,'product_type_id'=>$params["productTypeId"]
                            ,'product_group_name'=>$params["productGroupName"]
			                			,'cre_func_id'=>'CLI0360'
				                   	,'mod_func_id'=>'CLI0360'
				                   	,'cre_user_id'=>$profileId["user_id"]
				                   	,'mod_user_id'=>$profileId["user_id"]
				                   	,'version_no'=>DEFAULT_VERSION_NO
				                   	,'mod_ts'=>date('Y-m-d H:i:s')
                            );
                   $query =  $this->strikeforce->insert('product_group',$data);

                    $message = array("proFlg"=>"OK",
                                "message"=> I0000001
                            );
                    return "OK";
            }
        return "Empty input";
    }

    /**
     * Client detail controller
     * @param $params
     * @return string
     */
    public function updateProductGroup($params)
    {
    		$profileId = get_current_profile();

            $clientId = $params["clientId"];
            $productGroupId = $params["productGroupId"];
            $productGroupName = $params["productGroupName"];

            $this->strikeforce->where('client_id', $clientId);
            $this->strikeforce->where('product_group_id', $productGroupId);
            $query =  $this->strikeforce->update('product_group',array(
            		"product_group_name"=>$productGroupName
            		,'mod_func_id'=>'CLI0360'
            		,'mod_user_id'=>$profileId["user_id"]
            		,'mod_ts'=>date('Y-m-d H:i:s')
            ));
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
    public function deleteProductGroup($params)
    {
            $clientId = $params["clientId"];
            $productGroupId = $params["productGroupId"];

            $this->strikeforce->where('client_id', $clientId);
            $this->strikeforce->where('product_group_id', $productGroupId);
            $query =  $this->strikeforce->update('product_group',array("del_flg"=>1));

            if (!$query) {
              return $this->strikeforce->_error_message();
            }
            return "OK";
    }
}
?>