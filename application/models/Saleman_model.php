<?php

class Saleman_model extends MY_Model
{
    public $strikeforce;

    public function __construct()
    {
        $this->strikeforce = $this->load->database(DATABASE_NAME, TRUE);
    }

    /**
     * API saleman
     * @param $data
     * @return mixed
     */
    public function insert($data)
    {
        $this->strikeforce->trans_start();
        $this->strikeforce->insert('salesman', $data);
        $insert_id = $this->strikeforce->insert_id();
        $this->strikeforce->trans_complete();
        return $insert_id;
    }

    /**
     * API saleman
     * @param $saleman_id
     * @param $data
     * @return mixed
     */
    public function update($saleman_id, $data)
    {
        return $this->strikeforce->update('salesman', $data, array('salesman_id' => $saleman_id));
    }

    /**
     * Saleman controller
     * @param $param
     * @return array
     */
    public function selectSalesmanClient($param)
    {
        $dataResult = array(
            'salInfo' => NULL,
            'pagingInfo' => NULL
        );

        $curr_user = isset($param['curr_user']) ? $param['curr_user'] : NULL;

        /*Get MR by current user - Begin*/
        $mr_list = $this->selectMRByRole($curr_user);
        $arr_mr_id = " ('-1'";
        if (!empty($mr_list)) {
            foreach ($mr_list as $temp) {
                $arr_mr_id = $arr_mr_id . ',' . strval($temp['salesman_id']);
            }
        }
        $arr_mr_id = $arr_mr_id . " ,'-1')";
        /*Get MR by current user - End*/

        $paramInput = isset($param["searchInput"]) ? $param["searchInput"] : array();
        $sSQLContinute = "";

        $sSQLCount = "  SELECT count(DISTINCT sa.salesman_id) as totalRow
                        FROM  salesman as sa
                        ";
        $sSQL = "  SELECT DISTINCT
									sa.salesman_id as salesmanId
									, sa.salesman_code as salesmanCode
									, sa.salesman_name as salesmanName
									,sa.mobile as mobile
									,sa.email as email
									,sa.salesman_sts as salesmanSts
									,sa.location as location
									,sa.gender as gender
									,sa.job_title as jobTitle
									,sa.active_date as activeDate
									,sa.image_path as imagePath
                    FROM salesman as sa
                    ";

        $sSQLWhere = " WHERE sa.salesman_id in " . $arr_mr_id . " and sa.del_flg != '1' ";

        if (isset($paramInput["clientId"]) && !is_null($paramInput["clientId"]) && !empty($paramInput["clientId"])) {
            $sSQLWhere .= " and  usa.client_id = " . $paramInput["clientId"];
        }
        if (isset($paramInput["salesmanName"]) && !is_null($paramInput["salesmanName"]) && !empty($paramInput["salesmanName"])) {
            $sSQLWhere .= " and  UPPER(sa.salesman_name) like '%" . strtoupper($paramInput["salesmanName"]) . "%'";
        }
        if (isset($paramInput["salesmanCode"]) && !is_null($paramInput["salesmanCode"]) && !empty($paramInput["salesmanCode"])) {
            $sSQLWhere .= " and  UPPER(sa.salesman_code) like '%" . strtoupper($paramInput["salesmanCode"]) . "%'";
        }
        if (isset($paramInput["salesmanSts"]) && !is_null($paramInput["salesmanSts"])) {
            $sSQLWhere .= " and  sa.salesman_sts = '" . $paramInput["salesmanSts"] . "'";
        }

        $query = $this->strikeforce->query($sSQLCount . $sSQLContinute . $sSQLWhere);

        if ($query->row()->totalRow > 0) {
            $curr_page = isset($param["pagingInfo"]["crtPage"]) ? $param["pagingInfo"]["crtPage"] : 1;
            $pagingSet = $this->setPagingInfo($query->row()->totalRow, $curr_page);
            $sSQL .= $sSQLContinute . $sSQLWhere . " order by sa.salesman_name  limit " . ROW_ON_PAGE . " offset " . ($pagingSet["stRow"] - 1);

            $query = $this->strikeforce->query($sSQL);

            $dataResult["salInfo"] = $query != FALSE ? $query->result_array() : array();
            $dataResult["pagingInfo"] = $pagingSet;
        }

            return $dataResult;
    }

    /**
     * Saleman controller
     * @return array
     */
    public function  buildFilterSearch()
    {
        $usrStsLst["groudId"] = NULL;
        $usrStsLst["codeCd"] = NULL;
        $usrStsLst["codeName"] = NULL;
        $usrStsLst["codeVal"] = NULL;
        $usrStsLst["dispOrd"] = NULL;
        $usrStsLst["langKey"] = NULL;
        $usrStsLst["dispText"] = "All";
        $resultUsrStsLst[] = $usrStsLst;

        $usrStsLst["groudId"] = "salesman#sts";
        $usrStsLst["codeCd"] = 0;
        $usrStsLst["codeName"] = "Not Activate";
        $usrStsLst["codeVal"] = NULL;
        $usrStsLst["dispOrd"] = NULL;
        $usrStsLst["langKey"] = "salesman#sts#0";
        $usrStsLst["dispText"] = "Not Activate";

        $resultUsrStsLst[] = $usrStsLst;
        $usrStsLst["groudId"] = "salesman#sts";
        $usrStsLst["codeCd"] = 1;
        $usrStsLst["codeName"] = "Activated";
        $usrStsLst["codeVal"] = NULL;
        $usrStsLst["dispOrd"] = NULL;
        $usrStsLst["langKey"] = "salesman#sts#1";
        $usrStsLst["dispText"] = "Activated";
        $resultUsrStsLst[] = $usrStsLst;
        return $resultUsrStsLst;
    }

    /**
     * Saleman controller
     * @param $salesman_id
     */
    public function deleteSalman($salesman_id)
    {
        $sSQL = " UPDATE salesman SET del_flg = 1 WHERE salesman_id = " . $salesman_id;
        $query = $this->strikeforce->query($sSQL);
    }

    /**
     * Saleman detail controller
     * @param $salesman_code
     * @param $data
     * @return mixed
     */
    public function  selectSalemainById($salesman_code, $data)
    {
        $sSQL = " SELECT * FROM salesman WHERE salesman_code = '" . $salesman_code . "'";
        $query = $this->strikeforce->query($sSQL);

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data["salesmanId"] = $row->salesman_id;
                $data["salesmanCode"] = $row->salesman_code;
                $data["salesmanName"] = $row->salesman_name;
                $data["mobile"] = $row->mobile;
                $data["email"] = $row->email;
                $data["imagePath"] = $row->image_path;

                $data["location"] = $row->location;
                $data["jobTitle"] = $row->job_title;
                $data["gender"] = $row->gender;

                $data["activeDate"] = $row->active_date;
                $data["salesman_sts"] = $row->salesman_sts;
                $data["imei"] = $row->imei;
            }
        }
        return $data;
    }

    /**
     * Saleman detail controller
     * @param $param
     * @return string
     */
    public function  update_password($param)
    {
        $sSQL = " UPDATE salesman SET pin_code = '" . $param["pinCode"] . "' WHERE salesman_id = " . $param["salesmanId"] . " AND salesman_code = '" . $param["salesmanCode"] . "'";
        $res = $this->strikeforce->query($sSQL);
        if (!$res) {
            // if query returns null
            return $this->strikeforce->_error_message();
        }
        return "OK";
    }

    /**
     * Saleman detail controller
     * @param $param
     * @return string
     */
    public function  update_salesman($param)
    {
        $profileId = get_current_profile();
        $sSQL = " UPDATE salesman SET email = '" . $param["email"] . "',
										  imei = '" . $param["imei"] . "',
										  mobile = '" . $param["mobile"] . "',
										  salesman_name = '" . $param["salesmanName"] . "',
											location = '" . $param["location"] . "',
											gender = '" . $param["gender"] . "',
											job_title = '" . $param["jobTitle"] . "',
											mod_func_id = 'SAL0320',
	                    mod_ts = NOW(),
	                    mod_user_id = " . $profileId["user_id"] . "
								WHERE salesman_id = " . $param["salesmanId"] . "
										AND salesman_code = '" . $param["salesmanCode"] . "'";
        $res = $this->strikeforce->query($sSQL);
        if (!$res) {
            return $this->strikeforce->_error_message();
        }
        return "OK";
    }

    /**
     * Client detail, Saleman detail controllers
     * @param $param
     * @return array
     */
    public function searchStoreAssigned($param)
    {
        $dataResult = array(
            "storeInfo" => NULL,
            "pagingInfo" => NULL
        );

        $p = $param["searchInput"];
        $sSQLCount = " SELECT count(DISTINCT s.store_id) as totalRow
				FROM store as s LEFT JOIN client_store as cs on(cs.store_id = s.store_id and cs.del_flg != '1')
				LEFT JOIN salesman_store as ss on (ss.store_id = s.store_id  and ss.del_flg != '1')
				LEFT JOIN area as a on (a.area_id = s.area_id)
				LEFT JOIN area AS pa ON (a.parent_area = pa.area_id)
				WHERE s.del_flg != '1'	";

        $sSQL = " SELECT
					DISTINCT
					s.store_id
					,s.store_code
					,CASE
                      WHEN  s.doctor_name = '' THEN s.store_name
                      ELSE s.doctor_name
                    END AS storeName
					, CASE
                      WHEN  s.address = '' THEN s.department
                      ELSE s.address
                    END AS address
					,a.area_name
					,pa.area_name as parent_Area
					,s.hospital
					,s.mod_ts
				FROM store as s LEFT JOIN client_store as cs on(cs.store_id = s.store_id and cs.del_flg != '1')
				LEFT JOIN salesman_store as ss on (ss.store_id = s.store_id  and ss.del_flg != '1')
				LEFT JOIN area as a on (a.area_id = s.area_id)
				LEFT JOIN area AS pa ON (a.parent_area = pa.area_id)
				WHERE s.del_flg != '1'	";

        $sSQLWhere = "";
        if (isset($p["storeCode"]) && !empty($p["storeCode"])) {
            $sSQLWhere .= " and UPPER(s.store_code) like '%" . strtoupper($p["storeCode"]) . "%'";
        }
        if (isset($p["storeName"]) && !empty($p["storeName"])) {
            $sSQLWhere .= " and UPPER(CASE WHEN s.doctor_name = '' THEN s.store_name ELSE s.doctor_name END) like '%" . strtoupper($p["storeName"]) . "%'";
        }
        if (isset($p["clientId"]) && !empty($p["clientId"])) {
            $sSQLWhere .= " and cs.client_Id = " . $p["clientId"];
        }
        if (isset($p["salesmanId"]) && !empty($p["salesmanId"])) {
            $sSQLWhere .= " and ss.salesman_id = " . $p["salesmanId"];
        }

        if (isset($p["areaId"]) && !empty($p["areaId"])) {
            $sSQLWhere .= " and ( s.area_id = " . $p["areaId"] . " or s.area_id in (SELECT  area_id FROM area WHERE parent_area = " . $p["areaId"] . " ) )";
        }

        $query = $this->strikeforce->query($sSQLCount . $sSQLWhere);

        if ($query->row()->totalRow > 0) {

            $curr_page = isset($param["pagingInfo"]["crtPage"]) ? $param["pagingInfo"]["crtPage"] : 1;
            $pagingSet = $this->setPagingInfo($query->row()->totalRow, $curr_page);

            $sSQL .= $sSQLWhere . "  order by s.store_code  limit " . ROW_ON_PAGE . " offset " . ($pagingSet["stRow"] - 1);
            $query = $this->strikeforce->query($sSQL);

            $data = [];
            if ($query->num_rows() > 0) {
                foreach ($query->result() as $row) {
                    if($row->area_name == '' && $row->parent_Area = '') {
                        $address = $row->address . " " . $row->area_name . ", " . $row->parent_Area;
                        $areaName = $row->hospital;
                    } else {
                        $address = $row->address;
                        if($row->area_name == '') {
                            $areaName = $row->hospital;
                        } else {
                            $areaName = $row->area_name;
                        }
                    }

                    $data[] = array("storeId" => $row->store_id,
                        "storeCode" => $row->store_code,
                        "storeName" => $row->storeName,
                        "areaName" => $areaName,
                        "adddress" => $address);
                }

                $dataResult["storeInfo"] = $data;
                $dataResult["pagingInfo"] = $pagingSet;
            }
        }

        return $dataResult;
    }

    /**
     * Saleman detail controller
     * @param $param
     * @return array
     */
    public function searchStoreNotAssign($param)
    {
        $dataResult = array(
            "storeInfo" => NULL,
            "pagingInfo" => NULL
        );

        $p = $param["searchInput"];
        if (isset($param["salesmanId"]) && !empty($param["salesmanId"])) {
            $p = $param;
        }
        $sSQLCount = " SELECT count(DISTINCT s.store_id) as totalRow
				FROM store as s
				LEFT JOIN area as a on (a.area_id = s.area_id)
				LEFT JOIN area AS pa ON (a.parent_area = pa.area_id)
				WHERE s.del_flg != '1'	";


        $sSQL = " SELECT
					DISTINCT
					s.store_id
					,s.store_code
					,CASE
                      WHEN  s.doctor_name = '' THEN s.store_name
                      ELSE s.doctor_name
                    END AS storeName
					,s.address
					,a.area_name
					,pa.area_name as parent_Area
					,s.hospital
				FROM store as s
				LEFT JOIN area as a on (a.area_id = s.area_id)
				LEFT JOIN area AS pa ON (a.parent_area = pa.area_id)
				WHERE s.del_flg != '1'	";

        $sSQLWhere = "";
        if (isset($p["storeCode"]) && !empty($p["storeCode"])) {
            $sSQLWhere .= " and UPPER(s.store_code) like '%" . strtoupper($p["storeCode"]) . "%'";
        }
        if (isset($p["storeName"]) && !empty($p["storeName"])) {
            $sSQLWhere .= " and UPPER(CASE WHEN s.doctor_name = '' THEN s.store_name ELSE s.doctor_name END) like '%" . strtoupper($p["storeName"]) . "%'";
        }
        if (isset($p["clientId"]) && !empty($p["clientId"])) {
            $sSQLWhere .= " and s.store_id not in(select store_id from client_store where client_id = " . $p["clientId"] . ")";
        }
        if (isset($p["salesmanId"]) && !empty($p["salesmanId"])) {
            $sSQLWhere .= " and s.store_id not in(select store_id from salesman_store where salesman_id = " . $p["salesmanId"] . " and del_flg != '1') ";
        }
        if (isset($p["areaId"]) && !empty($p["areaId"])) {
            $sSQLWhere .= " and ( s.area_id = " . $p["areaId"] . " or s.area_id in (SELECT  area_id FROM area WHERE parent_area = " . $p["areaId"] . " ) )";
        }

        $query = $this->strikeforce->query($sSQLCount . $sSQLWhere);

        if ($query->row()->totalRow > 0) {

            $pagingSet = $this->setPagingInfo($query->row()->totalRow, $param["pagingInfo"]["crtPage"]);

            $sSQL .= $sSQLWhere . "  order by s.store_code  limit " . ROW_ON_PAGE . " offset " . ($pagingSet["stRow"] - 1);
            $query = $this->strikeforce->query($sSQL);

            $data = [];
            if ($query->num_rows() > 0) {
                foreach ($query->result() as $row) {
                    if($row->area_name == '' && $row->parent_Area = '') {
                        $address = $row->address . " " . $row->area_name . ", " . $row->parent_Area;
                        $areaName = $row->hospital;
                    } else {
                        $address = $row->address;
                        if($row->area_name == '') {
                            $areaName = $row->hospital;
                        } else {
                            $areaName = $row->area_name;
                        }
                    }
                    $data[] = array("storeId" => $row->store_id,
                        "storeCode" => $row->store_code,
                        "storeName" => $row->storeName,
                        "areaName" => $areaName,
                        "adddress" => $address);
                }

                $dataResult["storeInfo"] = $data;
                $dataResult["pagingInfo"] = $pagingSet;
            }
        }

        return $dataResult;
    }

    /**
     * Saleman detail controller
     * @param $param
     * @return string
     */
    public function  addStore($param)
    {
        if (isset($param)) {
            $salesmanId = $param["salesmanId"];
            $storeIdList = $param["storeIdList"];

            foreach ($storeIdList as $val) {

                $sSQLCount = " SELECT count(store_id) as count
								FROM salesman_store  WHERE salesman_id = " . $salesmanId . " AND store_id = " . $val;
                $query = $this->strikeforce->query($sSQLCount);

                if ($query->row()->count > 0) //update
                {
                    $this->strikeforce->where('salesman_id', $salesmanId);
                    $this->strikeforce->where('store_id', $val);
                    $query = $this->strikeforce->update('salesman_store', array("del_flg" => 0));


                } else { //insert
                    $query = $this->strikeforce->insert('salesman_store', array("salesman_id" => $salesmanId, "store_id" => $val));
                }
            }
            return "OK";
        } else {
            return "Empty input";
        }
    }

    /**
     * Saleman detail controller
     * @param $param
     * @return string
     */
    public function delete_saleman_store($param)
    {
        $salesmanId = $param["salesmanId"];
        $storeId = $param["storeId"];
        $this->strikeforce->where('salesman_id', $salesmanId);
        $this->strikeforce->where('store_id', $storeId);
        $query = $this->strikeforce->update('salesman_store', array("del_flg" => 1));
		
        if (!$query) {
			return "ERROR";
            //return $this->strikeforce->_error_message();
        }
        return "OK";
    }

    /**
     * Store controller
     * @param $param
     * @return string
     */
    public function  regisSalesmanStore($param)
    {
        if (!is_null($param)) {
            foreach ($param as $val) {

                $sSQLCount = " SELECT count(store_id) as count
							FROM salesman_store  WHERE salesman_id = " . $val["salesmanId"] . " AND store_id = " . $val["storeId"];
                $query = $this->strikeforce->query($sSQLCount);

                if ($query->row()->count > 0) //update
                {
                    $this->strikeforce->where('salesman_id', $val["salesmanId"]);
                    $this->strikeforce->where('store_id', $val["storeId"]);
                    $query = $this->strikeforce->update('salesman_store', array("del_flg" => 0));

                } else { //insert
                    //@author: CanhLD - hardcode: "seq_no"=>1...
                    $array_insert = array(
                        'salesman_id' => $val["salesmanId"],
                        'store_id' => $val["storeId"],
                        'seq_no' => 1,
                        'cre_func_id' => 'STO0320',
                        'mod_func_id' => 'STO0320',
                        'cre_ts' => date('Y-m-d H:i:s'),
                        'mod_ts' => date('Y-m-d H:i:s'),
                        'cre_user_id' => -1,
                        'mod_user_id' => -1,
                        'version_no' => 0
                    );
                    $query = $this->strikeforce->insert('salesman_store', $array_insert);
                }
            }
            return "OK";
        } else {
            return "Empty input";
        }
    }

    /**
     * Store model
     * @param $email
     * @return mixed
     */
    public function getSalesmanIdByEmail($email)
    {
        $this->strikeforce->select('salesman_id');
        $this->strikeforce->from('salesman');
        $this->strikeforce->where('email', $email);
        $this->strikeforce->where('del_flg', 0);
        $query = $this->strikeforce->get();
        return $query->result_array()[0]['salesman_id'];
    }

    /**
     * Saleman detail controller
     * @param $param
     * @return array
     */
    public function search_vacation($param)
    {
        $dataResult = array(
            "salLeave" => NULL,
            "pagingInfo" => NULL
        );

        $p = $param["searchInput"];

        $sSQLCount = "  SELECT count(*) as totalRow FROM salesman_leave WHERE del_flg != '1' ";

        $sSQL = "  SELECT * FROM salesman_leave WHERE del_flg != '1' ";

        $sSQLWhere = '';
        if (!is_null($p["salesmanId"]) && !empty($p["salesmanId"])) {
            $sSQLWhere .= " and salesman_id = " . $p["salesmanId"];
        }
        if (!is_null($p["startDate"]) && !empty($p["startDate"])) {
            $sSQLWhere .= " and leave_date >= STR_TO_DATE('" . $p["startDate"] . "','%d-%m-%Y')";
        }
        if (!is_null($p["endDate"]) && !empty($p["endDate"])) {
            $sSQLWhere .= " and leave_date <= STR_TO_DATE('" . $p["endDate"] . "','%d-%m-%Y')";
        }

        $query = $this->strikeforce->query($sSQLCount . $sSQLWhere);
        if ($query->row()->totalRow > 0) {
            $pagingSet = $this->setPagingInfo($query->row()->totalRow, $param["pagingInfo"]["crtPage"]);

            $sSQL .= $sSQLWhere . "  order by leave_date desc  limit " . ROW_ON_PAGE . " offset " . ($pagingSet["stRow"] - 1);
            $query = $this->strikeforce->query($sSQL);

            $data = [];
            if ($query->num_rows() > 0) {
                foreach ($query->result() as $row) {
                    $data["leaveDate"] = $row->leave_date;
                    $data["contText"] = $row->cont_text;
                    switch ($row->type) {
                        case 1:
                            $data["type"] = "Take a day off";
                            break;
                        case 2:
                            $data["type"] = "Working day";
                            break;
                        case 3:
                            $data["type"] = "Holiday";
                            break;
                        case 4:
                            $data["type"] = "Training day";
                            break;
                        case 5:
                            $data["type"] = "Promotion day";
                            break;
                        case 6:
                            $data["type"] = "Meeting day";
                            break;
                    }
                    $dataLoop[] = $data;
                }
                $dataResult["salLeave"] = $dataLoop;
                $dataResult["pagingInfo"] = $pagingSet;
            }
        }

        return $dataResult;
    }

    /**
     * Saleman detail controller
     * @param $param
     * @return string
     */
    public function activatSalesman($param)
    {
        if (isset($param) && !empty($param["salesmanCode"]) && !empty($param["salesmanId"])) {

            $this->strikeforce->where('salesman_code', $param["salesmanCode"]);
            $this->strikeforce->where('salesman_id', $param["salesmanId"]);
            $query = $this->strikeforce->update('salesman', array('salesman_sts' => 1, "active_date" => date("Y-m-d H:i:s")));
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
    public function selectByExample($param_arr)
    {
        if (isset($param_arr['distinct']) && $param_arr['distinct']) {
            $this->strikeforce->distinct();
        }

        $this->strikeforce->select('
            sa.salesman_id, salesman_code, salesman_name, pin_code, mobile, email, gcm_regis_id,
            image_path,  salesman_sts, location, gender,job_title, active_date, imei, sa.cre_func_id, sa.cre_ts,
            sa.cre_user_id, sa.mod_func_id, sa.mod_ts, sa.mod_user_id, sa.version_no, sa.del_flg,
			usa.client_id, usa.sub_leader_user_id,
			c.client_code, c.client_name,c.rate_point
        ');

        $this->strikeforce->from('salesman sa');

        $this->strikeforce->join('user_salesman usa', "sa.salesman_id = usa.salesman_id and usa.del_flg != '1'", 'left');

        $this->strikeforce->join('client c', "c.client_id = usa.client_id and c.del_flg != '1'", 'left');

        $email = isset($param_arr['email']) ? $param_arr['email'] : NULL;

        $imei = isset($param_arr['imei']) ? $param_arr['imei'] : NULL;

        $pinCode = isset($param_arr['pinCode']) ? $param_arr['pinCode'] : NULL;

        if ($email !== NULL) {
            $this->strikeforce->where('email', $email);
        }

        if ($imei !== NULL) {
            $this->strikeforce->where('imei', $imei);
        }
        if ($pinCode !== NULL) {
            $this->strikeforce->where('pin_code', $pinCode);
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
     * Store controller
     * @param $param
     * @return array
     */
    public function selectSalesmanByStoreClient($param)
    {

        $sSQL = " SELECT DISTINCT
								  cl.client_id as clientId
								  ,cl.client_name as clientName
								  , sa.salesman_id as salesmanId
								  , sa.salesman_code as salesmanCode
								  , sa.salesman_name as salesmanName
								FROM
									  salesman as sa
									  inner join salesman_store as saSt
									    on (sa.salesman_id = saSt.salesman_id and saSt.del_flg != '1')
									   inner join user_salesman as usa
									    on (
									      sa.salesman_id = usa.salesman_id
									      and usa.client_id = ?
									      and usa.del_flg != '1'
									    )
									  INNER JOIN store as st
									    on (st.store_id = saSt.store_id and st.del_flg != '1' )
									  INNER JOIN client_store as clSt
									    on (clSt.store_id = st.store_id  and clSt.del_flg != '1' and clSt.client_id = ? )
									  LEFT JOIN client as cl
									    on (cl.client_id = clSt.client_id and cl.del_flg != '1'   and cl.client_id = ? )
							WHERE
							  sa.del_flg != '1'
						     and st.store_id = ? order by sa.salesman_name ";

        if (!is_null($param["storeId"])
            && !empty($param["storeId"])
            && !is_null($param["clientId"])
            && !empty($param["clientId"])
        ) {

            $query = $this->strikeforce->query($sSQL, array($param["clientId"], $param["clientId"], $param["clientId"], $param["storeId"]));
            return $query->result_array();
        }
        return array();
    }

    /**
     * Store controller
     * @param $param
     * @return array
     */
    public function selectSalesmanNotAssingnStore($param)
    {
        $dataResult = array(
            "salesmanNotAssignStore" => NULL,
            "pagingInfo" => NULL
        );

        $sSQLCount = " SELECT count(DISTINCT sa.salesman_id) as totalRow
								FROM
									  salesman as sa inner join user_salesman as usa on(sa.salesman_id = usa.salesman_id   and usa.del_flg != '1')
							where sa.del_flg != '1'
					  			and sa.salesman_id not in (select salesman_id from salesman_store where store_id = ? and del_flg != '1')
					      		and usa.client_id = ? ";

        $sSQL = " SELECT DISTINCT
								  usa.client_id as clientId
								  , sa.salesman_id as salesmanId
								  , sa.salesman_code as salesmanCode
								  , sa.salesman_name as salesmanName
								FROM
									  salesman as sa inner join user_salesman as usa on(sa.salesman_id = usa.salesman_id   and usa.del_flg != '1')
							where sa.del_flg != '1'
					  		and sa.salesman_id not in (select salesman_id from salesman_store where store_id = ? and del_flg != '1')
					      	and usa.client_id = ? ";

        $sSQLWhere = "";
        if (!is_null($param["salesmanCode"])
            && !empty($param["salesmanCode"])
        ) {
            $sSQLWhere .= " and sa.salesman_code like '%" . $param["salesmanCode"] . "%'";
        }
        if (!is_null($param["salesmanName"])
            && !empty($param["salesmanName"])
        ) {
            $sSQLWhere .= " and sa.salesman_name like '%" . $param["salesmanName"] . "%'";
        }
        $query = $this->strikeforce->query($sSQLCount . $sSQLWhere, array($param["storeId"], $param["clientId"]));

        if ($query->row()->totalRow > 0) {
            $pagingSet = $this->setPagingInfo($query->row()->totalRow, $param["pagingInfo"]["crtPage"]);
            $sSQL .= $sSQLWhere . " limit " . ROW_ON_PAGE . " offset " . ($pagingSet["stRow"] - 1);
            $query = $this->strikeforce->query($sSQL, array($param["storeId"], $param["clientId"]));

            $dataResult["salesmanNotAssignStore"] = $query->result_array();
            $dataResult["pagingInfo"] = $pagingSet;
        }
            return $dataResult;
        }

    /**
     * API saleman
     * @param array $param_arr
     * @return array
     */
    public function selectSalemaById($param_arr = array())
    {
        $saleman_id = isset($param_arr['salesman_id']) ? $param_arr['salesman_id'] : '';

        if ($saleman_id !== '') {
            $this->strikeforce->where('salesman_id', $saleman_id);
        }
        $this->strikeforce->from('salesman');
        $this->strikeforce->where('del_flg != ', 1);

        $query = $this->strikeforce->get();

        $dataLoop["saleman_id"] = NULL;
        $dataClient[] = $dataLoop;
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $dataLoop["saleman_id"] = $row->salesman_id;
                $dataClient[] = $dataLoop;
            }
        }

        return $dataClient;
    }

    /**
     * User controller
     * @return null
     */
    public function selectSalesmanNotAssignUser()
    {
        $sSQL = '
            select s.*
            from salesman s
            where salesman_id not in (
              select salesman_id
              from user_salesman
              where del_flg != 1
            ) and s.del_flg != 1
            order by salesman_name
        ';

        $query = $this->strikeforce->query($sSQL);
        return $query !== FALSE ? $query->result_array() : NULL;
    }

    /**
     * User controller
     * @param $user_id
     * @return null
     */
    public function selectSalesmanByUser($user_id)
    {
        $sSQL = '
            select s.*
            from salesman s
            where s.salesman_id in (
              select salesman_id
              from user_salesman
              where sub_leader_user_id = ? and del_flg != 1
            ) and s.del_flg != 1
            order by s.salesman_name
        ';

        $query = $this->strikeforce->query($sSQL, array($user_id));
        return $query !== FALSE ? $query->result_array() : NULL;
    }

    /**
     * API saleman
     * @param $param_arr
     * @return null
     */
    public function selectByLoginSalesman($param_arr)
    {
        if (isset($param_arr['distinct']) && $param_arr['distinct']) {
            $this->strikeforce->distinct();
        }

        $this->strikeforce->select('
            sa.salesman_id, salesman_code, salesman_name, pin_code, mobile, email, gcm_regis_id,
            image_path, salesman_sts, location, gender,job_title,  active_date, imei, sa.cre_func_id, sa.cre_ts,
            sa.cre_user_id, sa.mod_func_id, sa.mod_ts, sa.mod_user_id, sa.version_no, sa.del_flg,
			usa.client_id, usa.sub_leader_user_id,
			c.client_code, c.client_name,c.rate_point
        ');

        $this->strikeforce->from('salesman sa');

        $this->strikeforce->join('user_salesman usa', "sa.salesman_id = usa.salesman_id and usa.del_flg != '1' and sa.del_flg != '1'");

        $this->strikeforce->join('client c', "c.client_id = usa.client_id and c.del_flg != '1'");

        $email = isset($param_arr['email']) ? $param_arr['email'] : '';

        $pinCode = isset($param_arr['pinCode']) ? $param_arr['pinCode'] : '';

        if (empty($email) || empty($pinCode)) {

            return NULL;
        }
        $this->strikeforce->where('email', $email);
        //$this->strikeforce->where('imei', $imei);
        $this->strikeforce->where('pin_code', $pinCode);

        $query = $this->strikeforce->get();

        return $query != FALSE ? $query->result_array() : NULL;
    }

    /**
     * API saleman
     * @param $param_arr
     * @return null
     */
    public function selectListSalesmanByUserId($param_arr)
    {

        $this->strikeforce->distinct();


        $this->strikeforce->select('
            sa.salesman_id as salesmanId, salesman_code as salesmanCd, salesman_name as salesmanName,
			mobile, email, gcm_regis_id as gcmRegisId,usa.client_id as clientId,
			usa.sub_leader_user_id as subLeaderUserId');

        $this->strikeforce->from('salesman sa');

        $this->strikeforce->join('user_salesman usa', "sa.salesman_id = usa.salesman_id and usa.del_flg != '1' and sa.del_flg != '1'", 'left');

        $this->strikeforce->join('client c', "c.client_id = usa.client_id and c.del_flg != '1'", 'left');

        $userId = isset($param_arr['userId']) ? $param_arr['userId'] : '';

        if (empty($userId)) {

            return NULL;
        }
        $this->strikeforce->where('usa.sub_leader_user_id', $userId);


        $query = $this->strikeforce->get();

        return $query != FALSE ? $query->result_array() : NULL;
    }

    /**
     * Call record, saleman detail controllers
     * @param $user
     * @return array
     */
    public function selectMRByRole($user)
    {
        $result = array();

        $curr_rolde_cd = isset($user['user_role_cd']) ? $user['user_role_cd'] : -1;
        $curr_user_id = isset($user['user_id']) ? $user['user_id'] : -1;

        /*Get cache - Begin*/
        $key = 'MR_by_role_' . date('YmdH') . '_' . $curr_user_id;
        $this->load->library('authentication');
        $result = $this->authentication->get_data($key, PLATFORM);
        if ($result !== FALSE) {
            return $result;
        }
        /*Get cache - End*/

        switch ($curr_rolde_cd) {
            case ROLE_ADMIN_CD:
            case ROLE_MOD_CD:
                //Get all
                $this->strikeforce->where(array('del_flg !=' => 1));
                $this->strikeforce->order_by('salesman_name asc');
                $query = $this->strikeforce->get('salesman');
                $result = $query !== FALSE ? $query->result_array() : array();
                break;

            case ROLE_BU_CD:
                $parent_id = isset($user['user_id']) ? $user['user_id'] : -1;

                $sql = '
                    select *
                    from salesman
                    where del_flg != 1 and salesman_id in (
                      select salesman_id
                      from user_salesman
                      where del_flg != 1 and sub_leader_user_id in (
                        select user_id
                        from user_mst
                        where del_flg != 1 and parent_id in (
                            select user_id
                            from user_mst
                            where del_flg != 1 and parent_id = ?
                        )
                      )
                    )
                    order by salesman_name asc;
                ';

                $query = $this->strikeforce->query($sql, array($parent_id));
                $result = $query !== FALSE ? $query->result_array() : array();
                break;

            case ROLE_SALES_MANAGER_CD:
                $parent_id = isset($user['user_id']) ? $user['user_id'] : -1;

                $sql = '
                    select *
                    from salesman
                    where del_flg != 1 and salesman_id in (
                      select salesman_id
                      from user_salesman
                      where del_flg != 1 and sub_leader_user_id in (
                        select user_id
                        from user_mst
                        where del_flg != 1 and parent_id = ?
                      )
                    )
                    order by salesman_name asc;
                ';

                $query = $this->strikeforce->query($sql, array($parent_id));
                $result = $query !== FALSE ? $query->result_array() : array();
                break;

            case ROLE_REGION_MANAGER_CD:
                $user_id = isset($user['user_id']) ? $user['user_id'] : -1;

                $sql = '
                    select *
                    from salesman
                    where del_flg != 1 and salesman_id in (
                      select salesman_id
                      from user_salesman
                      where del_flg != 1 and sub_leader_user_id = ?
                    )
                    order by salesman_name asc
                ';

                $query = $this->strikeforce->query($sql, array($user_id));
                $result = $query !== FALSE ? $query->result_array() : array();
                break;
        }

        /*Store SESSION - Begin*/
        $this->authentication->set_data($key, $result, PLATFORM);
        /*Store SESSION - End*/

        return $result;
    }

//    public function selectAllMR()
//    {
//        $query = $this->strikeforce->get_where('salesman', array('del_flg !=' => 1));
//        return $query != FALSE ? $query->result_array() : NULL;
//    }


    /**
     * salesman_import
     * @return array
     */
    private function getAllSalesmanExist()
    {
        $this->strikeforce->select('email');
        $this->strikeforce->from('salesman');
        $this->strikeforce->where('del_flg != ', 1);
        $query = $this->strikeforce->get();
        $arr = array();
        foreach ($query->result() as $value) {
            array_push($arr, strtolower($value->email));
        }
        return $arr;
    }

    /**
     * salesman_import
     * @return mixed
     */
    private function getMaxId()
    {
        $this->strikeforce->select('MAX(`salesman_id`) as salesmanId');
        $this->strikeforce->from('salesman');
        $this->strikeforce->where('del_flg != ', 1);
        $query = $this->strikeforce->get();
        return $query->result_array()[0]["salesmanId"];
    }

    /**
     * Saleman controller
     * @param $imagePath
     * @return string
     */
    public function salesman_import($imagePath)
    {
        try {

            $this->load->library('importexcel/FileManagerImport');
            $this->filemanagerimport->getSheets($imagePath);
            $Reader = $this->filemanagerimport->Reader;
            $Sheets = $Reader->Sheets();
            $profileId = get_current_profile();
            $existed = $this->getAllSalesmanExist();
            $maxId = $this->getMaxId();
            foreach ($Sheets as $Index => $Name) {
                if ($Index == 0) {
                    $Reader->ChangeSheet($Index);
                    $dataInsert = [];
                    $batch = 0;
                    foreach ($Reader as $rowIndex => $Row) {

                        if ($rowIndex > 0) { //bo nhung row ko sai
                            $data = array();
                            if (count($Row) != 7) {
                                return "Please contact administrator";
                            }
                            foreach ($Row as $indexColumn => $value) {

                                if ($indexColumn == 5) {
                                    if (in_array(strtolower($value), $existed)) {
                                        goto end;
                                    }
                                    array_push($existed, strtolower($value));
                                }

                                switch ($indexColumn) {
                                    case 0:
                                        $data["job_title"] = $value;
                                        break;
                                    case 1:
                                        $data["salesman_name"] = $value;
                                        break;
                                    case 2:
                                        $data["pin_code"] = $this->create_md5($value);
                                        break;

                                    case 3:
                                        $data["gender"] = ($value == "F" ? 0 : 1);
                                        break;
                                    case 4:
                                        $data["mobile"] = ($value[0] == "0" ? "" . $value : "0" . $value);
                                        break;
                                    case 5:
                                        $data["email"] = $value;
                                        break;
                                    case 6:
                                        $data["location"] = $value;
                                        break;

                                }


                            }
                            $data["salesman_code"] = $this->getCode(SALESMAN_CODE_PREFIX, 6, ++$maxId);
                            $data["salesman_sts"] = 1;
                            $data["active_date"] = date('Y-m-d H:i:s');
                            $data["cre_func_id"] = 'SAL0120';
                            $data["mod_func_id"] = 'SAL0120';
                            $data["cre_user_id"] = $profileId["user_id"];
                            $data["mod_user_id"] = $profileId["user_id"];
                            $data["version_no"] = DEFAULT_VERSION_NO;
                            $data["mod_ts"] = date('Y-m-d H:i:s');
                            $dataInsert[] = $data;
                        }

                        end:
                        if ($batch >= 20) {
                            if (!empty($dataInsert)) {
                                $this->strikeforce->insert_batch('salesman', $dataInsert);
                            }
                            $dataInsert = [];
                            $batch = 0;
                            usleep(100000);
                        }
                        $batch++;
                    }
                    if (!empty($dataInsert)) {
                        $this->strikeforce->insert_batch('salesman', $dataInsert);
                    }
                }
            }

        } catch (Exception $e) {
            // echo 'Caught exception: ',  $e->getMessage(), "\n";
            return "Please contact administrator";
        }
        return "OK";
    }

    public function getCode($prefix = 'SALESMAN_CODE_PREFIX', $len = 6, $id = 0)
    {
        return $prefix . date('Ymd') . str_pad($id, $len, '0', STR_PAD_LEFT);
    }

    public function create_md5($str = '')
    {
        return md5(md5($str . PLATFORM));
    }

    /**
     * Salesman leave model
     * @param $productTypeId
     * @param $role
     * @return array|bool
     */
    public function getSalesmanByProductType($productTypeId, $role)
    {
        $result = array();

        $curr_rolde_cd = isset($role['user_role_cd']) ? $role['user_role_cd'] : -1;
        $curr_user_id = isset($role['user_id']) ? $role['user_id'] : -1;

        /*Get cache - Begin*/
        $key = 'MR_by_product_type_' . date('YmdH') . '_' . $curr_user_id;
        $this->load->library('authentication');
        $mr_by_product_type = $this->authentication->get_data($key, PLATFORM);
        $result = isset($mr_by_product_type[$productTypeId]) ? $mr_by_product_type[$productTypeId] : FALSE;
        if ($result !== FALSE) {
            return $result;
        }
        /*Get cache - End*/

        $this->strikeforce->distinct();
        $this->strikeforce->select('us.salesman_id, sm.salesman_name');
        $this->strikeforce->from('user_product_type upt');
        $this->strikeforce->join('user_salesman us', 'upt.user_id = us.sub_leader_user_id AND us.del_flg != 1', 'inner');
        $this->strikeforce->join('salesman sm', 'us.salesman_id = sm.salesman_id AND sm.del_flg != 1', 'inner');
        $this->strikeforce->where(array('upt.del_flg !=' => 1));
        if ($productTypeId != 0) {
            $this->strikeforce->where(array('upt.product_type_id' => $productTypeId));
        }

        switch ($curr_rolde_cd) {
            case ROLE_ADMIN_CD:
            case ROLE_MOD_CD:
                //nothing...
                break;

            case ROLE_BU_CD:
            case ROLE_SALES_MANAGER_CD:
            case ROLE_REGION_MANAGER_CD:
                $this->load->model('user_mst_model');
                $lst_rm = $this->user_mst_model->getRegionalManagerByRole($role);
                if (!empty($lst_rm)) {
                    $lst_rm_id = [];
                    foreach($lst_rm as $item) {
                        $lst_rm_id[] = $item['user_id'];
                    }

                    $this->strikeforce->where_in('upt.user_id', $lst_rm_id);
                }
                break;
        }

        $query = $this->strikeforce->get();
        $result = $query !== FALSE ? $query->result_array() : array();

        /*Store SESSION - Begin*/
        if ($mr_by_product_type === FALSE) {
            $mr_by_product_type = array();
        }

        $mr_by_product_type[$productTypeId] = $result;
        $this->authentication->set_data($key, $mr_by_product_type, PLATFORM);
        /*Store SESSION - End*/

        return $result;
    }
}

?>
