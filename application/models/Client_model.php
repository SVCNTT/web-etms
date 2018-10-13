<?php

class Client_model extends MY_Model
{
    public $strikeforce;

    public function __construct()
    {
        $this->strikeforce = $this->load->database(DATABASE_NAME, TRUE);
    }

    /**
     * API saleman
     * @param array $param_arr
     * @return array
     */
    public function searchAllClientName($param_arr = array())
    {
        $clientName = isset($param_arr['clientName']) ? $param_arr['clientName'] : '';
        if ($clientName !== '') {
            $this->strikeforce->where('UPPER(client_name) like "'.strtoupper($clientName).'"');
        }

        $this->strikeforce->where('del_flg != ', 1);
        $this->strikeforce->order_by('client_name', 'ASC');
        $query = $this->strikeforce->get('client');

        $dataLoop["clientId"] = NULL;
        $dataLoop["clientName"] = "All";
        $dataClient[] = $dataLoop;
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $dataLoop["clientId"] = $row->client_id;
                $dataLoop["clientName"] = $row->client_name;
                $dataClient[] = $dataLoop;
            }
        }

        return $dataClient;
    }

    /**
     * Saleman controller, Store controller
     * @return mixed
     */
    public function  getAllClient()
    {

        $sSQL = " SELECT * FROM client ";
        $query = $this->strikeforce->query($sSQL);
        
        $dataLoop["clientId"] = NULL;
        $dataLoop["clientName"] = "All";
        $dataClient[] = $dataLoop;
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                 $dataLoop["clientId"] = $row->client_id;
                 $dataLoop["clientName"] = $row->client_name; 
                 $dataClient[] = $dataLoop;
            }
        }
        $clientList["clientList"] = $dataClient; 
        return $clientList;     

    }

    /**
     * Store controller
     * @param $id
     * @return mixed
     */
    public function searchClientStore($id)
    {
            $sql = " SELECT DISTINCT c.client_id as clientId, 
                                    c.client_name as clientName,
                                    cs.store_id as storeId, 
                                    cs.version_no as versionNoClientStore 
                    FROM client as c 
                                INNER JOIN client_store as cs on (c.client_id = cs.client_id)
                    WHERE c.del_flg != '1'  
                            and cs.del_flg != '1'
                            and cs.store_id = ? ";

            $query = $this->strikeforce->query($sql, array($id)); 
            return $query->result_array();
    }

    /**
     * Store controller
     * @param $id
     * @return array
     */
    public function searchClientNotStore($id)
    {
            $sql = " SELECT DISTINCT c.client_id , 
                                    c.client_name
                    FROM client as c 
                    WHERE c.del_flg != '1' 
                        AND c.client_id not in (SELECT cs.client_id FROM client_store as cs 
                                                    WHERE cs.del_flg != '1' and cs.store_id = ? )
                    ";

            $query = $this->strikeforce->query($sql, array($id));

            $dataLoop["clientId"] = NULL;
            $dataLoop["clientName"] = "All";
            $dataClient[] = $dataLoop;
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                     $dataLoop["clientId"] = $row->client_id;
                     $dataLoop["clientName"] = $row->client_name; 
                     $dataClient[] = $dataLoop;
                }
            }
            return $dataClient;
    }

    /**
     * getListClient
     * @param $params
     * @return array
     */
    private function searchClientName($params)
    {
        $dataResult = array(
            "clientList"    => NULL,
            "pagingInfo"    => NULL);

        $totalRow  = $this->countSearchClientName($params);

        if ($totalRow > 0) {
            $pagingSet = $this->setPagingInfo($totalRow, $params["pagingInfo"]["crtPage"]);

            $this->strikeforce->select('*');
            $this->strikeforce->from('client c'); 
            $this->strikeforce->where(' c.del_flg != ', 1);

            $clientName = isset($params["searchInput"]['clientName']) ? $params["searchInput"]['clientName'] : '';
            if ($clientName !== '') {
                $this->strikeforce->where("UPPER(c.client_name) like '%".strtoupper($clientName)."%'");
            }

            $limit = ROW_ON_PAGE;
            $offset = $pagingSet["stRow"]-1;
            $this->strikeforce->limit($limit, $offset);
            $this->strikeforce->order_by('c.client_name ASC');
            $query = $this->strikeforce->get();


            $dataResult["clientList"] = $query->result_array();
            $dataResult["pagingInfo"] = $pagingSet;
        }

        return $dataResult;
    }

    /**
     * searchClientName
     * @param $params
     * @return mixed
     */
    private function countSearchClientName($params)
    {
        $this->strikeforce->select('count(*) as  totalRow');

        $this->strikeforce->from('client c'); 
        $this->strikeforce->where(' c.del_flg != ', 1);

        $clientName = isset($params["searchInput"]['clientName']) ? $params["searchInput"]['clientName'] : '';
        if ($clientName !== '') {
            $this->strikeforce->where("UPPER(c.client_name) like '%".strtoupper($clientName)."%'");
        }
        
            $queryTotal = $this->strikeforce->get();
        return $queryTotal->row()->totalRow;        
    }

    /**
     * Client controller
     * @param $params
     * @return array
     */
    public function getListClient($params)
    {

            $client_list = $this->searchClientName($params);
            //var_dump($client_list);
            if ($client_list["clientList"] != NULL){
                
            foreach ($client_list["clientList"] as $row) {
                    $numSaleManManager = 0;
                    $numSaleManLeader = 0;
                    $numSaleManSubLeader = 0;

                    $countManagerArray = $this->selectCountClientUser($row["client_id"]);
                foreach ($countManagerArray as $rowNumber) {
                        if($rowNumber["user_role_cd"] == ROLE_MANAGER_CD){
                            $numSaleManManager = $rowNumber["count"];
                        }
                        if($rowNumber["user_role_cd"] == ROLE_LEADER_CD){
                            $numSaleManLeader = $rowNumber["count"];
                        }
                        if($rowNumber["user_role_cd"] == ROLE_SUB_LEADER_CD){
                         $numSaleManSubLeader = $rowNumber["count"];   
                        }

                    }
                    $data[] = array("clientId"=>$row["client_id"]
                                    ,"clientCode"=>$row["client_code"]
                                    ,"clientTypeName"=>$row["client_type"]
                                    ,"clientName"=>$row["client_name"]
                                    ,"ratePoint"=>$row["rate_point"]
                                    ,"logoPath"=>$row["logo_path"]
                                    ,"numSaleManManager"=>$numSaleManManager
                                    ,"numSaleManLeader"=>$numSaleManLeader
                                    ,"numSaleManSubLeader"=>$numSaleManSubLeader
                                    ,"numSaleMan"=>$this->getCountSaleMan($row["client_id"])
                                    
                                );
                }
                // var_dump($data);
                $client_list["clientList"] = $data;
        }

                return $client_list;
    }

    /**
     * getListClient
     * @param $clientId
     * @return mixed
     */
    private function getCountSaleMan($clientId)
    {
        $this->strikeforce->select('count(DISTINCT salesman_id) AS count_salesman_id');
        $this->strikeforce->from('user_salesman'); 
        $this->strikeforce->where('del_flg != ', 1);
        $this->strikeforce->where('client_id',$clientId);
        $queryTotal = $this->strikeforce->get();
        return $queryTotal->row()->count_salesman_id;     
    }

    /**
     * getListClient
     * @param $clientId
     * @return mixed
     */
    private function selectCountClientUser($clientId)
    {
        $this->strikeforce->select('user_role_cd, 
                                    count(user_role_cd) AS count');

        $this->strikeforce->from('user_mst'); 
        $this->strikeforce->where('del_flg != ', 1);
        $this->strikeforce->where('client_id',$clientId);
        $this->strikeforce->group_by('user_role_cd');
        $this->strikeforce->order_by('user_role_cd ASC');

        $query = $this->strikeforce->get();
        return $query->result_array();

    }

    /**
     * Client controller
     * @param $clientName
     * @param $clienType
     * @param $ratePoint
     * @param $imagePath
     * @return array|string
     */
    public function  client_create($clientName, $clienType, $ratePoint, $imagePath)
    {
            if (!empty($clientName) 
                    && !empty($clienType) 
            && !empty($ratePoint)
        ) {
                            
                    $data = array(
                                'client_code' => "CLI".strtotime(date('Y-m-d H:i:s'))
                                ,'client_name'=>$clientName
                                ,'client_type'=>$clienType
                                ,'rate_point'=>$ratePoint
                                ,'logo_path'=>$imagePath
                                
                                );
                       $query =  $this->strikeforce->insert('client',$data);

            $message = array(
                "proFlg"    => "OK",
                                    "message"=> CLI0200_CUSTOMMER_CREATE_SUCCESSFUL
                                );
                        return $message;
                } 
            return "Empty input";
        }

    /**
     * Client controller
     * @param $clientName
     * @return array|null
     */
    public function validate_client($clientName)
    {
                $this->strikeforce->select('count(*) as  totalRow');

                $this->strikeforce->from('client c'); 
                $this->strikeforce->where(' c.del_flg != ', 1);

                $message = NULL;
                if ($clientName !== '') {
                    $this->strikeforce->where("UPPER(c.client_name) like '".strtoupper($clientName)."'");

                $queryTotal = $this->strikeforce->get();
                if ($queryTotal->row()->totalRow > 0){
                $message = array(
                    "proFlg"    => "NG",
                                        "message"=> CLI0200_LABEL_CLIENT_NAME_EXISTED
                                    );
                }
        } else {
            $message = array(
                "proFlg"    => "NG",
                "message"   => CLI0200_LABEL_CLIENT_NAME_ERROR
            );
        }
                return $message;
        }

    /**
     * Client detail controller
     * @param $id
     * @return mixed
     */
    public function getClientByCode($id)
    {
            $sql = " SELECT DISTINCT c.client_id as clientId
                                        ,c.client_name as clientName
                                        ,c.logo_path as logoPath
                                        ,c.client_code as clientCode
                                        ,c.rate_point as ratePoint
                                        ,c.client_type as clientType
                                        ,c.client_type as clientTypeName
                    FROM client as c
                    WHERE c.del_flg != '1' and c.client_code = ? ";

            $query = $this->strikeforce->query($sql, array($id)); 
            $client = $query->result_array()[0];
            
            $this->load->model('cdmst_model');
        $cdmst = $this->cdmst_model->selectByExample(array("groupId" => "client_type", "codeCd" => $client["clientType"]));
        $cdmst = isset($cdmst[0]) ? $cdmst[0] : NULL;
            if (!empty($cdmst)){
                $dispText = "";
                if (empty($cdmst["lang_key"])){
                    $dispText = $cdmst["code_name"];
                }else{
                    if (defined($cdmst["lang_key"])) {
                        $dispText = constant($cdmst["lang_key"]);
                    }else{
                        $dispText = $cdmst["lang_key"];
                    }                
                }
                $client["clientTypeName"] = $dispText;
            }
            return $client;
    }

    /**
     * Client detail controller
     * @param $params
     * @return array
     */
    public function  client_update($params)
    {
            if (!empty($params["clientName"]) 
                    && !empty($params["clientCode"]) 
            && !empty($params["ratePoint"])
        ) {

                     $data = array(
                        'client_name'=>$params["clientName"]
                        ,'rate_point'=>$params["ratePoint"]
                        ,'logo_path'=>$params["imagePath"]
                        );

                        $this->strikeforce->where('client_code', $params["clientCode"]);
                       $query =  $this->strikeforce->update('client',$data);

                        $message = array("proFlg"=>"OK",
                                    "message"=> CLI0200_CUSTOMMER_UPDATE_SUCCESSFUL
                                );
                        return $message;
                } 
           $message = array("proFlg"=>"NG",
                                    "message"=> "Please input data"
                                );
                        return $message;
        }

    /**
     * Client detail controller
     * @param $param
     * @return string
     */
    public function deleteStore($param)
    {
            $clientId = $param["clientId"];
            $storeId = $param["storeId"];
            $this->strikeforce->where('client_id', $clientId);
            $this->strikeforce->where('store_id', $storeId);
            $query =  $this->strikeforce->update('client_store',array("del_flg"=>1));
            if (!$query) {
              return $this->strikeforce->_error_message();
            }
            return "OK";
    }

    /**
     * API saleman
     * @param $arrParam
     * @return null
     */
	public function selectByClientId_api($arrParam)
    {
        $clientId = isset($arrParam['clientId']) ? $arrParam['clientId'] : '';
		
        if (empty($clientId)) {
            return NULL;
        }
		$this->strikeforce->select('client_id as clientId, client_code as clientCode, client_name as clientName, rate_point as ratePoint');
        $this->strikeforce->from('client c');
		
		$this->strikeforce->where('del_flg !=', '1');		
        $this->strikeforce->where('client_id', $clientId);		
        $query = $this->strikeforce->get();

        return $query != FALSE ? $query->result_array() : NULL;
    }
}