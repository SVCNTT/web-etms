<?php

class Store_model extends MY_Model
{
    public $strikeforce;

    public function __construct()
    {

        $this->strikeforce = $this->load->database(DATABASE_NAME, TRUE);
    }

    /**
     * Store controller
     * @param $param
     * @return array
     */
    public function searchData($param)
    {
        $dataResult = array(
            "storeInfo" => NULL,
            "pagingInfo" => NULL
        );

        $p = isset($param["searchInput"]) ? $param["searchInput"] : array();

        if (isset($param["salesmanId"]) && !is_null($param["salesmanId"]) && !empty($param["salesmanId"])) {
            $p = $param;
        }

        $user = isset($param['curr_user']) ? $param['curr_user'] : NULL;
        /*Get MR by current user - Begin*/
//         $store_list = $this->selectStoreByRole($curr_user);
//         $arr_store_id = " '-1'";
//         if (!empty($store_list)) {
//             foreach ($store_list as $temp) {
//                 $arr_store_id = $arr_store_id.','.strval($temp['store_id']);
//             }
//         }
//         $arr_store_id = $arr_store_id. " ,'-1'";
        /*Get MR by current user - End*/
        $curr_rolde_cd = isset($user['user_role_cd']) ? $user['user_role_cd'] : -1;
        $sSQLCount = "";
        $sSQL = "";
        $sSQLCount = " SELECT count(DISTINCT s.store_id) as totalRow
						FROM store as s ";

        $sSQL = " SELECT
									DISTINCT
									s.store_id as storeId
									,s.store_code as storeCode
									, CASE
									  	WHEN  s.doctor_name = '' THEN s.store_name
									  	ELSE s.doctor_name
									  END AS storeName
									,s.address as adddress
									, CASE
									  	WHEN  s.is_doctor = '0' THEN 'No'
									  	ELSE 'Yes'
									  END AS isDoctor
									,concat(a.area_name,', ', pa.area_name) as areaName
									,pa.area_name as parent_Area
								FROM store as s ";

        switch ($curr_rolde_cd) {
            case ROLE_BU_CD:
            case ROLE_SALES_MANAGER_CD:
            case ROLE_REGION_MANAGER_CD:
                /*Get MR by current user - Begin*/
                $this->load->model('saleman_model');
                $mr_list = $this->saleman_model->selectMRByRole($user);
                $arr_mr_id = " '-1'";
                if (!empty($mr_list)) {
                    foreach ($mr_list as $temp) {
                        $arr_mr_id = $arr_mr_id . ',' . strval($temp['salesman_id']);
                    }
                }
                $arr_mr_id = $arr_mr_id . " ,'-1'";

                $sSQLCount .= " INNER JOIN salesman_store ss ON (s.store_id  = ss.store_id AND ss.salesman_id IN ( " . $arr_mr_id . ")) ";
                $sSQL .= " INNER JOIN salesman_store ss ON (s.store_id  = ss.store_id AND ss.salesman_id IN ( " . $arr_mr_id . ")) ";
                break;
        }

        switch ($curr_rolde_cd) {
            case ROLE_ADMIN_CD:
            case ROLE_MOD_CD:
            case ROLE_BU_CD:
            case ROLE_SALES_MANAGER_CD:
            case ROLE_REGION_MANAGER_CD:
                $sSQL .= "
								LEFT JOIN area as a on (a.area_id = s.area_id)
								LEFT JOIN area as pa ON (a.parent_area = pa.area_id)
							";
                $sSQLWhere = "WHERE s.del_flg != '1' ";

                if (isset($p["storeCode"]) && !is_null($p["storeCode"]) && !empty($p["storeCode"])) {
                    $sSQLWhere .= " and UPPER(s.store_code) like '%" . strtoupper($p["storeCode"]) . "%'";
                }
                if (isset($p["storeName"]) && !is_null($p["storeName"]) && !empty($p["storeName"])) {
                    $sSQLWhere .= " and ( UPPER(s.store_name) like '%" . mb_strtoupper($p["storeName"]) . "%' OR UPPER(s.doctor_name) like '%" . mb_strtoupper($p["storeName"]) . "%' ) ";
                }
                if (isset($p["clientId"]) && !is_null($p["clientId"]) && !empty($p["clientId"])) {
                    $sSQLWhere .= " and s.store_id not in(select store_id from client_store where client_id = " . $p["clientId"] . ")";
                }
                if (isset($p["salesmanId"]) && !is_null($p["salesmanId"]) && !empty($p["salesmanId"])) {
                    $sSQLWhere .= " and s.store_id not in(select store_id from salesman_store where salesman_id = " . $p["salesmanId"] . ") ";
                }
                if (isset($p["areaId"]) && !is_null($p["areaId"]) && !empty($p["areaId"])) {
                    $sSQLWhere .= " and ( s.area_id = " . $p["areaId"] . " or s.area_id in (SELECT  area_id FROM area WHERE parent_area = " . $p["areaId"] . " ) )";
                }

                $query = $this->strikeforce->query($sSQLCount . $sSQLWhere);

                if ($query->row()->totalRow > 0) {
                    $curr_page = isset($param["pagingInfo"]["crtPage"]) ? $param["pagingInfo"]["crtPage"] : 1;
                    $pagingSet = $this->setPagingInfo($query->row()->totalRow, $curr_page);

                    $sSQL .= $sSQLWhere . "  order by s.`store_id` ASC limit " . ROW_ON_PAGE . " offset " . ($pagingSet["stRow"] - 1);
                    $query = $this->strikeforce->query($sSQL);
                    $dataResult["storeInfo"] = $query->result_array();
                    $dataResult["pagingInfo"] = $pagingSet;
                }

                break;
        }

        return $dataResult;
    }

    /**
     * Client detail model
     * @return array
     */
    public function getAllStore()
    {
        $this->strikeforce->select(' store_id, store_name, class ');

        $this->strikeforce->from('store');
        $this->strikeforce->where('del_flg != ', 1);

        $query = $this->strikeforce->get();
        $data["storeId"] = NULL;
        $data["storeName"] = "All";
        $dataLoop[] = $data;
        foreach ($query->result() as $row) {
            $data["storeId"] = $row->store_id;
            $data["storeName"] = $row->store_name;
            $data["storeClass"] = $row->class;
            $dataLoop[] = $data;
        }
        return $dataLoop;
    }

    /**
     * Store controller
     * @param $param
     * @return string
     */
    public function deleteStore($param)
    {
        $storeCode = isset($param["storeCode"]) ? $param["storeCode"] : '0';
        $sSQL = "UPDATE store SET del_flg = 1 WHERE store_code = '" . $storeCode . "'";
        $query = $this->strikeforce->query($sSQL);
        if (!$query) {
            return $this->strikeforce->_error_message();
        }
        return RES_OK;
    }

    /**
     * Store controller
     * @param $code
     * @return null
     */
    public function get_store_by_code($code)
    {
        if (isset($code)) {
            $sSQL = " SELECT * FROM store WHERE  del_flg  != '1' AND store_code = '" . $code . "'";
            $query = $this->strikeforce->query($sSQL);
            if ($query->num_rows() > 0) {
                $store_code = $query->result_array();
                return $store_code[0]['store_id'];
            }
        }
        return NULL;
    }

    /**
     * Store controller
     * @param $param
     * @return array
     */
    public function get_store_by_id($param)
    {
        if (isset($param)) {

            $sql = " SELECT store_id as storeId,
						NULL as clientId,
						s.store_code as storeCode,
						s.store_name as storeName,
						s.doctor_name as docName,
						s.title as title,
						s.position as position,
						s.specialty as specialty,
						s.department as department,
						s.`class` as `classs`,
						s.hospital as hospital,
						z.zone_name as zone,
						s.zone_id as zoneId,
						ptm.product_type_name as bu,
						s.product_type_id as productTypeId,
						s.address,
						s.lat_val as latVal,
						s.long_val as longVal,
						s.area_id as areaId,
						s.is_doctor as isDoctor,
						NULL as versionNoStore,
						NULL as versionNoClientStore
					FROM store s
						LEFT JOIN product_type_mst ptm ON (s.product_type_id = ptm.product_type_id)
						LEFT JOIN zone z ON (s.zone_id = z.zone_id)
					WHERE store_id = ? ";

            $query = $this->strikeforce->query($sql, array($param["storeId"]));
            if ($query->num_rows() > 0) {

                return $query->result_array()[0];
            }
        }
        return [];
    }

    /**
     * Store controller
     * @param $param
     * @return string
     */
    public function  create_store($param)
    {
        if (isset($param)) {
            $this->load->model('product_type_mst_model');
            $this->load->model('zone_model');
            $this->load->model('area_model');

            $profileId = get_current_profile();
            $isDoctor = isset($param["isDoctor"]) ? $param["isDoctor"] : 0;
            $storeName = isset($param["storeName"]) ? $param["storeName"] : '';
            $docName = isset($param["docName"]) ? $param["docName"] : '';
            $title = isset($param["title"]) ? $param["title"] : '';
            $position = isset($param["position"]) ? $param["position"] : '';
            $specialty = isset($param["specialty"]) ? $param["specialty"] : '';
            $department = isset($param["department"]) ? $param["department"] : '';
            $classs = isset($param["classs"]) ? $param["classs"] : '';
            $hospital = isset($param["hospital"]) ? $param["hospital"] : '';
            $zoneId = isset($param["zoneId"]) ? $param["zoneId"] : 0;
            $productTypeId = isset($param["productTypeId"]) ? $param["productTypeId"] : 0;


            $adress = isset($param["adress"]) ? $param["adress"] : '';
            $latVal = isset($param["latVal"]) ? $param["latVal"] : 0;
            $longVal = isset($param["longVal"]) ? $param["longVal"] : 0;
            $areaId = isset($param["areaId"]) ? $param["areaId"] : 0;
            $parentAreaId = $this->area_model->selectAreaParentByChildId($areaId);

            $sqlGetcode = " SELECT MAX(CAST(SUBSTRING(store_code, 2, length(store_code)-1) AS UNSIGNED)) + 1 as storeCode FROM `store` ";
            $query = $this->strikeforce->query($sqlGetcode);
            $store_code = $query->result_array();

            $functionId = "DOC0200";
            if ($isDoctor == 0) {
                $code = "S" . $store_code[0]['storeCode'];
                $functionId = "STO0200";
            } else {
                $code = "D" . $store_code[0]['storeCode'];
            }

            $data = array(
                'cre_func_id' => $functionId,
                'mod_func_id' => $functionId,
                'cre_user_id' => $profileId["user_id"],
                'mod_user_id' => $profileId["user_id"],
                'version_no' => DEFAULT_VERSION_NO,
                'mod_ts' => date('Y-m-d H:i:s'),
                'store_code' => $code,
                'store_name' => $storeName,
                'doctor_name' => $docName,
                'title' => $title,
                'position' => $position,
                'specialty' => $specialty,
                'department' => $department,
                'class' => $classs,
                'hospital' => $hospital,
                'zone_id' => $zoneId,
                'is_doctor' => $isDoctor,
                'product_type_id' => $productTypeId,
                'address' => $adress,
                'area_id' => $areaId,
                'area_parent_id' => $parentAreaId,
                'lat_val' => $latVal,
                'long_val' => $longVal
            );
            $query = $this->strikeforce->insert('store', $data);
            $insert_id = $this->strikeforce->insert_id();
            $this->strikeforce->trans_complete();

            //insert store to client defautl
            $data = array(
                'client_id' => 1,
                'store_id' => $insert_id
            );
            $query = $this->strikeforce->insert('client_store', $data);


            if (!$query) {
                return $this->strikeforce->_error_message();
            }
            return "OK";
        }
        return "Empty input";
    }

    /**
     * Store controller
     * @param $param
     * @return string
     */
    public function  update_store($param)
    {
        if (isset($param)) {
            $this->load->model('product_type_mst_model');
            $this->load->model('zone_model');
            $this->load->model('area_model');

            $profileId = get_current_profile();
            $isDoctor = isset($param["isDoctor"]) ? $param["isDoctor"] : 0;
            $storeName = isset($param["storeName"]) ? $param["storeName"] : '';
            $docName = isset($param["docName"]) ? $param["docName"] : '';
            $title = isset($param["title"]) ? $param["title"] : '';
            $position = isset($param["position"]) ? $param["position"] : '';
            $specialty = isset($param["specialty"]) ? $param["specialty"] : '';
            $department = isset($param["department"]) ? $param["department"] : '';
            $classs = isset($param["classs"]) ? $param["classs"] : '';
            $hospital = isset($param["hospital"]) ? $param["hospital"] : '';
            $zoneId = isset($param["zoneId"]) ? $param["zoneId"] : 0;
            $productTypeId = isset($param["productTypeId"]) ? $param["productTypeId"] : 0;
            $mr = isset($param["mr"]) ? $param["mr"] : '';


            $adress = isset($param["adress"]) ? $param["adress"] : '';
            $latVal = isset($param["latVal"]) ? $param["latVal"] : 0;
            $longVal = isset($param["longVal"]) ? $param["longVal"] : 0;
            $areaId = isset($param["areaId"]) ? $param["areaId"] : 0;
            $parentAreaId = $this->area_model->selectAreaParentByChildId($areaId);

            $functionId = "DOC0210";
            if ($isDoctor == 0) {
                $functionId = "STO0210";
            }

            $data = array(
                'mod_user_id' => $profileId["user_id"],
                'mod_ts' => date('Y-m-d H:i:s'),
                'mod_func_id' => $functionId,
                'store_name' => $storeName,
                'doctor_name' => $docName,
                'title' => $title,
                'position' => $position,
                'specialty' => $specialty,
                'department' => $department,
                'class' => $classs,
                'hospital' => $hospital,
                'zone_id' => $zoneId,
                'is_doctor' => $isDoctor,
                'product_type_id' => $productTypeId,
                'address' => $adress,
                'area_id' => $areaId,
                'area_parent_id' => $parentAreaId,
                'lat_val' => $latVal,
                'long_val' => $longVal
            );

            $this->strikeforce->where('store_id', $param["storeId"]);
            $query = $this->strikeforce->update('store', $data);

            if (!$query) {
                return $this->strikeforce->_error_message();
            }
            return "OK";

        }
        return "Empty input";
    }

    /**
     * Client detail, Store controller
     * @param $param
     * @return string
     */
    public function  regisClientStore($param)
    {
        if (isset($param)) {
            if (!empty($param["clientId"])
                && !empty($param["storeId"])
            ) {
                $query = NULL;

                if ($this->isClientInStore($param)) {//update

                    $this->strikeforce->where('store_id', $param["storeId"]);
                    $this->strikeforce->where('client_id', $param["clientId"]);
                    $query = $this->strikeforce->update('client_store', array('del_flg' => 0));
                } else {
                    $data = array(
                        'client_id' => $param["clientId"],
                        'store_id' => $param["storeId"]
                    );
                    $query = $this->strikeforce->insert('client_store', $data);

                }
                if (!$query) {
                    return $this->strikeforce->_error_message();
                }
                return "OK";
            }

        }
        return "Empty input";
    }

    /**
     * regisClientStore
     * @param $param
     * @return bool
     */
    private function isClientInStore($param)
    {

        $sql = " SELECT count(store_id) as total
					FROM client_store
					WHERE client_id = ? AND store_id = ? ";

        $query = $this->strikeforce->query($sql, array($param["clientId"], $param["storeId"]));
        if ($query->row()->total > 0) {
            return TRUE;
        }
        return FALSE;
    }

    /**
     * Store controller
     * @param $param
     * @return string
     */
    public function delete_client_in_store($param)
    {
        if (isset($param) && !empty($param["clientId"]) && !empty($param["storeId"])) {

            $this->strikeforce->where('store_id', $param["storeId"]);
            $this->strikeforce->where('client_id', $param["clientId"]);
            $query = $this->strikeforce->update('client_store', array('del_flg' => 1));
            if (!$query) {
                return $this->strikeforce->_error_message();
            }
            return "OK";
        }
        return "Empty input";
    }

    /**
     * API saleman
     * @param $param_arr
     * @return null
     */
    public function selectStoreBySaleman($param_arr)
    {
        $this->strikeforce->distinct();
        $this->strikeforce->select('
            sat.salesman_id as salesmanId, uSa.client_id as clientId, sat.store_id as storeId, s.store_code as storeCode,
						s.store_name as storeName,s.lat_val as latVal,s.long_val as longVal,s.doctor_name as doctorName,
						s.title as title, s.position as position, s.specialty as specialty, s.department as department,
						s.class as class, s.hospital as hospital, s.zone_id as zone,  s.address as address, s.is_doctor as isDoctor,
						s.product_type_id as productTypeId
        ');

        $this->strikeforce->from('salesman_store sat');

        $this->strikeforce->join('store s', "sat.store_id = s.store_id and sat.del_flg != '1' and s.del_flg != '1'");

        $this->strikeforce->join('user_salesman uSa', "sat.salesman_id = uSa.salesman_id and uSa.del_flg != '1'");

        $salesmanId = isset($param_arr['salesman_id']) ? $param_arr['salesman_id'] : NULL;
        if ($salesmanId !== NULL) {
            $this->strikeforce->where('sat.salesman_id', $salesmanId);
        }

        $limit = isset($param_arr['limit']) ? $param_arr['limit'] : NULL;
        $offset = isset($param_arr['offset']) ? $param_arr['offset'] : NULL;
        if ($limit !== NULL && $offset !== NULL) {
            $this->strikeforce->limit($limit, $offset);
        }

        $order_clause = isset($param_arr['order_clause']) ? $param_arr['emaorder_clauseil'] : NULL;
        if ($order_clause) {
            $this->strikeforce->order_by($order_clause);
        }
        $query = $this->strikeforce->get();

        return $query != FALSE ? $query->result_array() : NULL;
    }

    /**
     * API saleman
     * Get list stores by rm id
     * @param $params
     * @return null
     */
    public function selectStoreByRm($params)
    {
        $this->strikeforce->distinct();
        $this->strikeforce->select('
                        sat.salesman_id as salesmanId,
                        s.store_id as storeId, s.store_code as storeCode,
						s.store_name as storeName,s.lat_val as latVal,s.long_val as longVal,s.doctor_name as doctorName,
						s.title as title, s.position as position, s.specialty as specialty, s.department as department,
						s.class as class, s.hospital as hospital, s.zone_id as zone,  s.address as address, s.is_doctor as isDoctor,
						s.product_type_id as productTypeId
        ');

        $this->strikeforce->from('store s');
        $this->strikeforce->join('salesman_store sat', "sat.store_id = s.store_id and sat.del_flg != '1' and s.del_flg != '1'");
        $this->strikeforce->join('user_salesman uSa', "sat.salesman_id = uSa.salesman_id and uSa.del_flg != '1'");

        $this->strikeforce->where("s.del_flg != '1'");
        if (isset($params['userId']) && $params['userId']) {
            $this->strikeforce->where('uSa.sub_leader_user_id', $params['userId']);
        }

        $limit = isset($params['limit']) ? $params['limit'] : NULL;
        $offset = isset($params['offset']) ? $params['offset'] : NULL;
        if ($limit !== NULL && $offset !== NULL) {
            $this->strikeforce->limit($limit, $offset);
        }

        $order_clause = isset($params['order_clause']) ? $params['emaorder_clauseil'] : NULL;
        if ($order_clause) {
            $this->strikeforce->order_by($order_clause);
        }
        $query = $this->strikeforce->get();

        return $query != FALSE ? $query->result_array() : NULL;
    }

    /**
     * import
     * @return array
     */
    private function getAllStoreExisted()
    {
        $this->strikeforce->select('store_code');
        $this->strikeforce->from('store');
        $query = $this->strikeforce->get();

        $arr = array();
        foreach ($query->result() as $value) {
            array_push($arr, strtolower($value->store_code));
        }
        return $arr;
    }

    /**
     * Store controller
     * @param $imagePath
     * @param $file_name
     * @return string
     */
    public function import($imagePath, $file_name)
    {
        try {
            $this->load->library('importexcel/FileManagerImport');
            $this->filemanagerimport->getSheets($imagePath);
            $Reader = $this->filemanagerimport->Reader;
            $Sheets = $Reader->Sheets();

            foreach ($Sheets as $Index => $Name) {
                if ($Index == 0) {
                    $Reader->ChangeSheet($Index);

                    $existed = $this->getAllStoreExisted();
                    $profileId = get_current_profile();

                    $this->load->model('zone_model');
                    $this->load->model('product_model');
                    $this->load->model('saleman_model');
                    $this->load->model('area_model');

                    $zone_exited = $this->zone_model->getMapZoneExited();
                    $productTypeExisted = $this->product_model->getMapProductType(array("clientId" => 1));

                    $areas = $this->area_model->selectAreaParent();
                    $keyParent = [];
                    foreach ($areas as $row_parent) {
                        $keyParent[$row_parent->area_name] = $row_parent->area_id;
                    }

                    /*Clear data before insert - Begin*/

                    if (strtolower($file_name) == strtolower('Pharmacy list.xlsx')) {   //Reset data - else add more
                        //Delete all store
                        $this->clearData();

                        //Truncate salesman_store
                        $this->strikeforce->query('TRUNCATE `salesman_store`;');
                    }

                    //Truncate client_store
                    $this->strikeforce->query('TRUNCATE `client_store`;');

                    //Truncate zone_area
                    $this->strikeforce->query('TRUNCATE `zone_area`;');

                    /*Clear data before insert - End*/

                    $data_batch_sales = array();
                    $batch_sales_index = 0;
                    foreach ($Reader as $rowIndex => $Row) {

                        if ($rowIndex > 1) { //bo nhung row ko sai
                            if (empty($Row[0])) {
                                continue;
                            }

//                            if (count($Row) != 15) {
//                                return "File format invalid";
//                            }

                            $data = array();
                            $mr = '';
                            $areaIds = [];
                            $curr_store_code = NULL;
                            foreach ($Row as $indexColumn => $value) {
                                switch ($indexColumn) {
                                    case 0:
                                        if (in_array(strtolower($value), $existed)) {
                                            /*Enable flag update*/
                                            $curr_store_code = $value;
                                            $data["store_code"] = $value;
                                        } else {
                                            array_push($existed, strtolower($value));
                                            $data["store_code"] = $value;
                                        }
                                        break;

                                    case 1:
                                        $data["store_name"] = $value;
                                        if ($value == "") {
                                            $data["is_doctor"] = "1";
                                        } else {
                                            $data["is_doctor"] = "0";
                                        }
                                        break;
                                    case 2:
                                        $data["doctor_name"] = $value;

                                        break;
                                    case 3:
                                        $data["title"] = $value;

                                        break;
                                    case 4:
                                        $data["position"] = $value;

                                        break;
                                    case 5:
                                        $data["specialty"] = $value;

                                        break;
                                    case 6:
                                        $data["department"] = $value;

                                        break;
                                    case 7:
                                        $data["class"] = $value;

                                        break;
                                    case 8:
                                        $data["hospital"] = $value;

                                        break;
                                    case 9:
                                        $data["address"] = $value;

                                        break;
                                    case 10:
                                        if ($Row[$indexColumn + 1] != "") {
                                            $areaIds = $this->importArea($value, $Row[$indexColumn + 1], $keyParent);
                                            $data["area_id"] = $areaIds["childId"];
                                        } else {
                                            $data["area_id"] = 0;
                                        }

                                        break;

                                    case 12:

                                        $zone_id = isset($zone_exited[$value]) ? $zone_exited[$value] : 0;
                                        if ($zone_id == 0 && $value != '') {
                                            $zone_id = $this->zone_model->insertZone($value, $profileId["user_id"]);
                                            $zone_exited[$value] = $zone_id;
                                        }
                                        $data["zone_id"] = $zone_id;
                                        $data["area_parent_id"] = $areaIds["parentId"];
//                                        $data["zone"] = $value;
                                        break;

                                    case 13:
                                        $mr = $value;

                                        if (!empty($mr)) {
                                            //Select salesman_id
                                            $mr = $this->saleman_model->getSalesmanIdByEmail($mr);
                                        }
                                        break;

                                    case 14:
                                        $data["product_type_id"] = $productTypeExisted[$value];
                                        break;

                                    default:
                                        ;
                                        break;
                                }

                            }


                            $data["mod_func_id"] = 'STO0120';
                            $data["mod_user_id"] = $profileId["user_id"];
                            $data["version_no"] = DEFAULT_VERSION_NO;
                            $data["mod_ts"] = date('Y-m-d H:i:s');
                            $data["del_flg"] = 0;

                            /*Update or Insert - Begin*/
                            if ($curr_store_code !== NULL) {
                                //TODO: Update

                                $this->strikeforce->where('store_code', strval($curr_store_code));
                                $this->strikeforce->update('store', $data);
                            } else {
                                //TODO: Insert

                                $data["cre_func_id"] = 'STO0120';
                                $data["cre_user_id"] = $profileId["user_id"];

                                $this->strikeforce->insert('store', $data);
                            }
                            /*Update or Insert - End*/

                            /*Update salesman_store - Begin*/
                            if (!empty($mr)) {
                                $this->strikeforce->select("store_id");
                                $query = $this->strikeforce->get_where('store', array('store_code' => $data["store_code"]), 1);
                                $curr_store_id = $query->row_array();

                                if (isset($curr_store_id['store_id'])) {
                                    $data_salesman = array(
                                        'cre_func_id' => 'STO0120',
                                        'mod_func_id' => 'STO0120',
                                        'cre_user_id' => $profileId["user_id"],
                                        'mod_user_id' => $profileId["user_id"],
                                        'version_no' => DEFAULT_VERSION_NO,
                                        'store_id' => $curr_store_id['store_id'],
                                        'salesman_id' => $mr
                                    );

                                    $batch_sales_index++;
                                    $data_batch_sales[] = $data_salesman;
                                    if ($batch_sales_index > 20) {
                                        $this->strikeforce->insert_ignore_batch('salesman_store', $data_batch_sales);
                                        $data_batch_sales = array();
                                        $batch_sales_index = 0;

                                        usleep(1000000);
                                    }
                                }
                            }
                            /*Update salesman_store - End*/
                        }
                    }

                    if (!empty($data_batch_sales)) {
                        $this->strikeforce->insert_ignore_batch('salesman_store', $data_batch_sales);
                    }

                    //Insert client_store
                    $this->strikeforce->query("
                        INSERT client_store (cre_func_id, mod_func_id, cre_user_id, mod_user_id, version_no, mod_ts, client_id, store_id)
                        SELECT 'STO0120', 'STO0120', " . $profileId["user_id"] . ", " . $profileId["user_id"] . ", " . DEFAULT_VERSION_NO . ", NOW(), 1, store_id
                        FROM store
                        WHERE store_id NOT IN (select cs.store_id from client_store cs where cs.client_id = 1)
                        ");

                    //Insert zone_area
                    $this->strikeforce->query("
                        INSERT zone_area (cre_func_id, mod_func_id, cre_user_id, mod_user_id, version_no, mod_ts, zone_id, area_id)
                        SELECT distinct 'STO0120', 'STO0120', " . $profileId["user_id"] . ", " . $profileId["user_id"] . ", " . DEFAULT_VERSION_NO . ", NOW(), zone_id, area_parent_id
                        FROM store
                        WHERE (zone_id, area_parent_id ) NOT IN (SELECT zone_id, area_id FROM zone_area);
                        ");
                }
            }
        } catch (Exception $e) {
            return "Please contact administrator. [".$e->getMessage()."]";
        }

        return "OK";
    }

    /**
     * import
     * @param $child
     * @param $parent
     * @param $keyParent
     * @return array|string
     */
    private function importArea($child, $parent, &$keyParent)
    {
        $insert_id = 0;
        $parent_id = 0;
        try {
            $this->load->model('area_model');
            $data = [];
            if ($keyParent[$parent] != NULL) {
                $data["parent_area"] = $keyParent[$parent];
                $data["area_name"] = $child;
                $parent_id = $keyParent[$parent];
                $insert_id = NULL;

                $insert_id = $this->isChildExisted($data);
                if ($insert_id === NULL) {
                    $this->strikeforce->insert('area', $data);
                    $insert_id = $this->strikeforce->insert_id();
                    $this->strikeforce->trans_complete();
                }
            } else {
                $data["area_name"] = $parent;
                $this->strikeforce->insert('area', $data);
                $insert_id = $this->strikeforce->insert_id();
                $this->strikeforce->trans_complete();
                $keyParent[$parent] = $insert_id;

                $data["parent_area"] = $insert_id;
                $parent_id = $insert_id;
                $data["area_name"] = $child;
                $this->strikeforce->insert('area', $data);
                $insert_id = $this->strikeforce->insert_id();
                $this->strikeforce->trans_complete();

            }

        } catch (Exception $e) {
//            echo 'Caught exception: ', $e->getMessage(), "\n";
            return "Please contact administrator. [".$e->getMessage()."]";
        }
        return array("childId" => $insert_id, "parentId" => $parent_id);
    }

    /**
     * importArea
     * @param $params
     * @return mixed
     */
    private function isChildExisted($params)
    {
        $this->strikeforce->select('area_id');
        $this->strikeforce->from('area ');
        $this->strikeforce->like('parent_area', $params["parent_area"]);
        $this->strikeforce->like('area_name', $params["area_name"]);
        $query = $this->strikeforce->get();
        return $query->result_array()[0]['area_id'];
    }

    /**
     * Call record, Dashboard controller
     * @param $user
     * @return array
     */
    public function selectStoreByRole($user)
    {
        $CI =& get_instance();
        $result = array();

        $curr_user_id = isset($user['user_id']) ? $user['user_id'] : -1;
        if ($curr_user_id < 0) {
            return $result;
        }

        /*Get cache - Begin*/
        $key = 'store_by_role_' . date('YmdH') . '_' . $curr_user_id;
        $CI->load->library('authentication');
        $result = $CI->authentication->get_data($key, PLATFORM);
        if ($result !== FALSE) {
            return $result;
        }
        /*Bet cache - End*/


        $curr_rolde_cd = isset($user['user_role_cd']) ? $user['user_role_cd'] : -1;

        switch ($curr_rolde_cd) {
            case ROLE_ADMIN_CD:
            case ROLE_MOD_CD:
                //Get all
                $this->strikeforce->select('store_id, case when is_doctor = 0 then store_name when is_doctor = 1 then doctor_name end as store_name, `class`', FALSE);
                $this->strikeforce->where(array('del_flg !=' => 1));
                $this->strikeforce->order_by('store_name asc');
                $query = $this->strikeforce->get('store');
                $result = $query !== FALSE ? $query->result_array() : array();
                break;

            case ROLE_BU_CD:
            case ROLE_SALES_MANAGER_CD:
            case ROLE_REGION_MANAGER_CD:
                /*Get MR by current user - Begin*/
                $CI->load->model('saleman_model');
                $mr_list = $CI->saleman_model->selectMRByRole($user);
                $arr_mr_id = " '-1'";
                if (!empty($mr_list)) {
                    foreach ($mr_list as $temp) {
                        $arr_mr_id = $arr_mr_id . ',' . strval($temp['salesman_id']);
                    }
                }
                $arr_mr_id = $arr_mr_id . " ,'-1'";
                /*Get MR by current user - End*/

                $sql = '
                        select store_id, case when is_doctor = 0 then store_name when is_doctor = 1 then doctor_name end as store_name, `class`
                        from store
                        where del_flg != 1 and store_id in (
                          select store_id
                          from salesman_store
                          where del_flg != 1 and salesman_id in (' . $arr_mr_id . ')
                        )
                        order by store_name asc;
                    ';

                $query = $this->strikeforce->query($sql);
                $result = $query !== FALSE ? $query->result_array() : array();
                break;
        }

        /*Store SESSION - Begin*/
        $CI->authentication->set_data($key, $result, PLATFORM);
        /*Store SESSION - End*/

        return $result;
    }

    /**
     * Call record controller
     * @param $user
     * @return array
     */
    public function selectStoreByRoleForMapping($user)
    {
        $list = $this->selectStoreByRole($user);

        if (!empty($list)) {
            $temp_arr = array();
            foreach ($list as $item) {
                $temp_arr[$item['store_id']] = $item;
            }
            $list = $temp_arr;
        }

        return $list;
    }

    /**
     * Store controller
     * @param $is_doctor
     * @return mixed
     */
    public function buildDatabaseExport($is_doctor, $product_type_id = 0)
    {
        $this->strikeforce->select('st.store_code, st.store_name, st.doctor_name, st.title, st.position, st.specialty
        , st.department, st.class, st.hospital, st.address
        , ar.area_name as territory, arp.area_name as area, zo.zone_name as zone, ptm.product_type_name as BU
        , sm.email as mr_email', FALSE);

        $this->strikeforce->from('store st');
        $this->strikeforce->join('salesman_store ss', 'ss.store_id = st.store_id AND ss.del_flg = 0', 'left');
        $this->strikeforce->join('salesman sm', 'sm.salesman_id = ss.salesman_id AND sm.del_flg = 0', 'left');
        $this->strikeforce->join('area ar', 'ar.area_id = st.area_id AND ar.del_flg = 0', 'left');
        $this->strikeforce->join('area arp', 'arp.area_id = st.area_parent_id AND arp.del_flg = 0', 'left');
        $this->strikeforce->join('zone zo', 'zo.zone_id = st.zone_id AND zo.del_flg = 0', 'left');
        $this->strikeforce->join('product_type_mst ptm', 'ptm.product_type_id = st.product_type_id AND ptm.del_flg = 0', 'left');
        $this->strikeforce->where(array('st.is_doctor' => $is_doctor, 'st.del_flg = ' => 0));

        if ($product_type_id == 0) {
            $this->strikeforce->where('st.product_type_id IS NULL', NULL , FALSE);

        } else {
            $this->strikeforce->where(array('st.product_type_id' => $product_type_id));
        }

        $query = $this->strikeforce->get();
        return $query->result_array();
    }

    /**
     * Store controller
     * @param $data
     * @param $path
     * @throws PHPExcel_Reader_Exception
     */
    public function create_excel_file_rp($is_doctor, $path)
    {
        $this->load->library('importexcel/FileManagerExport');

        $cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
        $cacheSettings = array('memoryCacheSize' => '2048MB');
        PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);

        $objPHPExcel = new PHPExcel();

        /*Get data*/
        $this->load->model('product_type_mst_model');
        $params  = array();
        $bu = $this->product_type_mst_model->proTypeResultDto($params);

        if (!empty($bu)) {
            $flag = 0;
            foreach($bu as $item) {
                $data = $this->buildDatabaseExport($is_doctor, $item['productTypeId']);

                if (!empty($data)) {
                    if ($flag == 0) {
                        $sheetDetails = $objPHPExcel->getActiveSheet(1);
                        $flag++;
                    } else {
                        $sheetDetails = $objPHPExcel->createsheet();
                    }

                    $sheetDetails = $this->buildDetailTeam($sheetDetails, $data, $item['productTypeName']);
                }
            }

            $data = $this->buildDatabaseExport($is_doctor, 0);
            if (!empty($data)) {
                $sheetDetails = $objPHPExcel->createsheet();
                $sheetDetails = $this->buildDetailTeam($sheetDetails, $data);
            }
        } else {
            $data = $this->buildDatabaseExport($is_doctor, 0);
            $sheetDetails = $objPHPExcel->getActiveSheet(1);
            $sheetDetails = $this->buildDetailTeam($sheetDetails, $data);
        }


        /*Get data - END*/

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save($path);
    }

    /**
     * create_excel_file_rp
     * @param $sheetDetails
     * @param $data
     * @return mixed
     */
    private function buildDetailTeam($sheetDetails, $data, $sheetName = 'Others')
    {
        //set header
        $sheetDetails->setCellValue('A1', 'CUSTOMERS LIST');
        $sheetDetails->mergeCells('A1:O1');

        $sheetDetails->setCellValue('A3', 'Code');
        $sheetDetails->setCellValue('B3', 'Pharmacy');
        $sheetDetails->setCellValue('C3', 'Doctor');
        $sheetDetails->setCellValue('D3', 'Title');
        $sheetDetails->setCellValue('E3', 'Position');
        $sheetDetails->setCellValue('F3', 'Specialty');
        $sheetDetails->setCellValue('G3', 'Department');
        $sheetDetails->setCellValue('H3', 'Class');
        $sheetDetails->setCellValue('I3', 'Hospital');
        $sheetDetails->setCellValue('J3', 'CustAddress');
        $sheetDetails->setCellValue('K3', 'Territory');
        $sheetDetails->setCellValue('L3', 'Area');
        $sheetDetails->setCellValue('M3', 'Zone');
        $sheetDetails->setCellValue('N3', 'MR');
        $sheetDetails->setCellValue('O3', 'BU');

        $index = 0;
        foreach ($data as $k => $c) {
            $index = $k + 4;

            $sheetDetails->setCellValue('A' . $index, $c['store_code']);
            $sheetDetails->setCellValue('B' . $index, $c['store_name']);
            $sheetDetails->setCellValue('C' . $index, $c['doctor_name']);
            $sheetDetails->setCellValue('D' . $index, $c['title']);
            $sheetDetails->setCellValue('E' . $index, $c['position']);
            $sheetDetails->setCellValue('F' . $index, $c['specialty']);
            $sheetDetails->setCellValue('G' . $index, $c['department']);
            $sheetDetails->setCellValue('H' . $index, $c['class']);
            $sheetDetails->setCellValue('I' . $index, $c['hospital']);
            $sheetDetails->setCellValue('J' . $index, $c['address']);
            $sheetDetails->setCellValue('K' . $index, $c['territory']);
            $sheetDetails->setCellValue('L' . $index, $c['area']);
            $sheetDetails->setCellValue('M' . $index, $c['zone']);
            $sheetDetails->setCellValue('N' . $index, $c['mr_email']);
            $sheetDetails->setCellValue('O' . $index, $c['BU']);
        }

        $sheetDetails->getStyle('A' . $index . ':' . 'O' . $index)->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => '00FF00'
            )
        ));

        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_DOTTED
                )
            )
        );

        $sheetDetails->setTitle($sheetName);;
        $sheetDetails->getStyle('A1:O' . $index)->applyFromArray($styleArray);
//        $sheetDetails->getStyle('A1:O'.$index)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

        return $sheetDetails;
    }

    /**
     * import
     */
    public function clearData()
    {
        $data = array(
            'del_flg' => 1
        );

        $this->strikeforce->update('store', $data);
    }


    /**
     * Client inventory_store_model
     * @return array
     */
    public function getAllStoreForImportInventory()
    {
        $this->strikeforce->select('store_id, store_code');

        $this->strikeforce->from('store');
        $this->strikeforce->where('del_flg != ', 1);
        $query = $this->strikeforce->get();

        $dataLoop = array();
        foreach ($query->result() as $row) {
            $dataLoop[$row->store_code] = (array) $row;
        }
        return $dataLoop;
    }
}

?>
