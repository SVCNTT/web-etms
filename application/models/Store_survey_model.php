<?php

class Store_survey_model extends MY_Model
{
    public $strikeforce;

    public function __construct()
    {

        $this->strikeforce = $this->load->database(DATABASE_NAME, TRUE);
    }


    /**
     * import
     * @return array
     */
    private function getAllStoreExisted()
    {
        $this->strikeforce->select('store_code');
        $this->strikeforce->from('store_survey');
        $query = $this->strikeforce->get();

        $arr = array();
        foreach ($query->result() as $value) {
            array_push($arr, strtolower($value->store_code));
        }
        return $arr;
    }


    /**
     * import
     */
    public function clearData()
    {
        $data = array(
            'del_flg' => 1
        );

        $this->strikeforce->update('store_survey', $data);
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

                    $this->load->model('saleman_model');

                    if (strtolower($file_name) == strtolower('Customer_survey_list.xlsx')) {   //Reset data - else add more
                        //Delete all store
                        $this->clearData();

                        //Truncate salesman_store
                        $this->strikeforce->query('TRUNCATE `salesman_store_survey`;');

                        //Truncate store_product_survey
                        $this->strikeforce->query('TRUNCATE `store_product_survey`;');
                    }

                    $data_batch_sales = array();
                    $data_batch_product = array();
                    $batch_sales_index = 0;
                    $batch_product_index = 0;

                    $this->load->model('product_survey_model');

                    foreach ($Reader as $rowIndex => $Row) {

                        if ($rowIndex > 0) { //bo nhung row ko sai
                            if (empty($Row[0])) {
                                continue;
                            }

//                            if (count($Row) != 4) {
//                                return "File format invalid";
//                            }

                            $data = array();
                            $mr = '';
                            $product_id = 0;
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
                                        $data["sub_group"] = $value;
                                        break;
                                    case 2:
                                        $product_name = $value;
                                        if (!empty($product_name)) {
                                            $product_info = $this->product_survey_model->getByName($product_name);

                                            if (!empty($product_info)) {
                                                $product_id = $product_info['id'];
                                            } else {

                                                $product_info = array(
                                                    "product" => $product_name,
                                                    "cre_func_id" => 'STO0530',
                                                    "mod_func_id" => 'STO0530',
                                                    "cre_user_id" => $profileId["user_id"],
                                                    "mod_user_id" => $profileId["user_id"],
                                                    "version_no" => DEFAULT_VERSION_NO,
                                                    "mod_ts" => date('Y-m-d H:i:s'),
                                                    "cre_ts" => date('Y-m-d H:i:s'),
                                                    "del_flg" => 0
                                                );

                                                $product_id = $this->product_survey_model->insert($product_info);
                                            }
                                        }

                                        break;
                                    case 3:
                                        $mr = $value;

                                        if (!empty($mr)) {
                                            //Select salesman_id
                                            $mr = $this->saleman_model->getSalesmanIdByEmail($mr);
                                        }
                                        break;
                                }

                            }

                            $data["mod_func_id"] = 'STO0530';
                            $data["mod_user_id"] = $profileId["user_id"];
                            $data["version_no"] = DEFAULT_VERSION_NO;
                            $data["mod_ts"] = date('Y-m-d H:i:s');
                            $data["del_flg"] = 0;

                            /*Update or Insert - Begin*/
                            if ($curr_store_code !== NULL) {
                                //TODO: Update
                                $this->strikeforce->where('store_code', strval($curr_store_code));
                                $this->strikeforce->update('store_survey', $data);
                            } else {
                                //TODO: Insert

                                $data["cre_func_id"] = 'STO0530';
                                $data["cre_user_id"] = $profileId["user_id"];
                                $data["cre_ts"] = date('Y-m-d H:i:s');

                                $this->strikeforce->insert('store_survey', $data);
                            }
                            /*Update or Insert - End*/

                            /*Update salesman_store_survey - Begin*/
                            $curr_store_id = 0;
                            if (!empty($mr)) {
                                $this->strikeforce->select("store_id");
                                $query = $this->strikeforce->get_where('store_survey', array('store_code' => $data["store_code"]), 1);
                                $curr_store_id = $query->row_array();

                                if (isset($curr_store_id['store_id'])) {
                                    $data_salesman = array(
                                        'cre_func_id' => 'STO0530',
                                        'mod_func_id' => 'STO0530',
                                        'cre_user_id' => $profileId["user_id"],
                                        'mod_user_id' => $profileId["user_id"],
                                        'version_no' => DEFAULT_VERSION_NO,
                                        'del_flg' => 0,
                                        'store_id' => $curr_store_id['store_id'],
                                        'salesman_id' => $mr
                                    );

                                    $batch_sales_index++;
                                    $data_batch_sales[] = $data_salesman;
                                    if ($batch_sales_index > 20) {
                                        $this->strikeforce->insert_ignore_batch('salesman_store_survey', $data_batch_sales);
                                        $data_batch_sales = array();
                                        $batch_sales_index = 0;

                                        sleep(1);
                                    }
                                }
                            }
                            /*Update salesman_store_survey - End*/


                            /*Update store_product_survey - Begin*/
                            if (!empty($product_id)) {

                                if ($curr_store_id == 0) {
                                    $this->strikeforce->select("store_id");
                                    $query = $this->strikeforce->get_where('store_survey', array('store_code' => $data["store_code"]), 1);
                                    $curr_store_id = $query->row_array();
                                }

                                if (isset($curr_store_id['store_id'])) {
                                    $data_product = array(
                                        'cre_func_id' => 'STO0530',
                                        'mod_func_id' => 'STO0530',
                                        'cre_user_id' => $profileId["user_id"],
                                        'mod_user_id' => $profileId["user_id"],
                                        'version_no' => DEFAULT_VERSION_NO,
                                        'del_flg' => 0,
                                        'store_id' => $curr_store_id['store_id'],
                                        'product_id' => $product_id
                                    );

                                    $batch_product_index++;
                                    $data_batch_product[] = $data_product;
                                    if ($batch_product_index > 20) {
                                        $this->strikeforce->insert_ignore_batch('store_product_survey', $data_batch_product);
                                        $data_batch_product = array();
                                        $batch_product_index = 0;

                                        sleep(1);
                                    }
                                }
                            }
                            /*Update store_product_survey - End*/
                        }
                    }

                    if (!empty($data_batch_sales)) {
                        $this->strikeforce->insert_ignore_batch('salesman_store_survey', $data_batch_sales);
                    }

                    if (!empty($data_batch_product)) {
                        $this->strikeforce->insert_ignore_batch('store_product_survey', $data_batch_product);
                    }
                }
            }
        } catch (Exception $e) {
            return "Please contact administrator. [".$e->getMessage()."]";
        }

        return RES_OK;
    }


    /**
     * Survey controller
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

        $curr_rolde_cd = isset($user['user_role_cd']) ? $user['user_role_cd'] : -1;
        $sSQLCount = " SELECT count(DISTINCT s.store_id) as totalRow
						FROM store_survey as s ";

        $sSQL = "   SELECT
                        DISTINCT
                        s.store_id as storeId
                        ,s.store_code as storeCode
                        ,s.sub_group as subGroup
                        ,MD5(CONCAT(s.store_code, '" . SECRECT_KEY_STORE_SURVEY . "')) as token
                    FROM store_survey as s ";

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

                $sSQLCount .= " INNER JOIN salesman_store_survey ss ON (s.store_id  = ss.store_id AND ss.salesman_id IN ( " . $arr_mr_id . ")) ";
                $sSQL .= " INNER JOIN salesman_store_survey ss ON (s.store_id  = ss.store_id AND ss.salesman_id IN ( " . $arr_mr_id . ")) ";
                break;
        }

        switch ($curr_rolde_cd) {
            case ROLE_ADMIN_CD:
            case ROLE_MOD_CD:
            case ROLE_BU_CD:
            case ROLE_SALES_MANAGER_CD:
            case ROLE_REGION_MANAGER_CD:

                $sSQLWhere = " WHERE s.del_flg != '1' ";

                if (isset($p["storeCode"]) && !is_null($p["storeCode"]) && !empty($p["storeCode"])) {
                    $sSQLWhere .= " and UPPER(s.store_code) like '%" . strtoupper($p["storeCode"]) . "%'";
                }

                if (isset($p["salesmanId"]) && !is_null($p["salesmanId"]) && !empty($p["salesmanId"])) {
                    $sSQLWhere .= " and s.store_id not in(select store_id from salesman_store_survey where salesman_id = " . $p["salesmanId"] . ") ";
                }


                $query = $this->strikeforce->query($sSQLCount . $sSQLWhere);

                if ($query->row()->totalRow > 0) {
                    $curr_page = isset($param["pagingInfo"]["crtPage"]) ? $param["pagingInfo"]["crtPage"] : 1;
                    $pagingSet = $this->setPagingInfo($query->row()->totalRow, $curr_page);

                    $sSQL .= $sSQLWhere . "  order by s.`store_id` ASC limit " . ROW_ON_PAGE . " offset " . ($pagingSet["stRow"] - 1);
                    $query = $this->strikeforce->query($sSQL);
                    $storeInfo = $query->result_array();

                    if (!empty($storeInfo)) {

                        $this->load->model('product_survey_model');

                        foreach($storeInfo as $key=>$item) {
                            $storeInfo[$key]['product_list'] = $this->product_survey_model->getByStoreId($item['storeId']);
                        }
                    }

                    $dataResult["storeInfo"] = $storeInfo;
                    $dataResult["pagingInfo"] = $pagingSet;
                }

                break;
        }

        return $dataResult;
    }


    public function getListProductIdBySalesmanId($salesman_id)
    {
        $sSQL = '
            SELECT GROUP_CONCAT(DISTINCT sps.product_id SEPARATOR \', \') as list_product_id
            FROM store_survey ss
            INNER JOIN store_product_survey sps ON sps.store_id = ss.store_id AND sps.del_flg != 1
            INNER JOIN salesman_store_survey sss ON sss.store_id = ss.store_id AND sss.del_flg != 1
            WHERE sss.salesman_id = ' . $salesman_id . ' AND ss.del_flg != 1
        ';

        $query = $this->strikeforce->query($sSQL);

        return $query !== FALSE ? $query->row_array() : array();
    }


    public function getCustomverBySurvey($salesman_id, $survey_id, $status)
    {

        $sSQL = '
            SELECT DISTINCT ss.store_id as storeId, ss.store_code as storeCode, CASE
									  	WHEN  st.doctor_name = \'\' THEN st.store_name
									  	ELSE st.doctor_name
									  END AS storeName,
									  st.title as title, st.position as `position`, st.specialty as specialty,
									  st.department as department, st.class as class, st.hospital as hospital,
									  st.address as address
            FROM store_survey ss
            INNER JOIN store st ON st.store_code = ss.store_code AND st.del_flg != 1
            INNER JOIN salesman_store_survey sss ON sss.store_id = ss.store_id AND sss.del_flg != 1
            INNER JOIN salesman sm ON sm.salesman_id = sss.salesman_id AND sm.del_flg != 1
        ';

        $sSQL .= '
            WHERE sm.salesman_id = ' . $salesman_id . ' AND ss.del_flg != 1
        ';
        switch ($status) {
            case SURVEY_CUSTOMER_DONE:
                $sSQL .= '
                    AND ss.store_id IN (
                        SELECT sa.store_id
                        FROM survey_answers_' . $survey_id . ' sa
                        WHERE sa.salesman_id = ' . $salesman_id . ' AND sa.del_flg != 1
                    )
                ';
                break;

            case SURVEY_CUSTOMER_NOT_YET:
                $sSQL .= '
                    AND ss.store_id NOT IN (
                        SELECT sa.store_id
                        FROM survey_answers_' . $survey_id . ' sa
                        WHERE sa.salesman_id = ' . $salesman_id . ' AND sa.del_flg != 1
                    )
                ';
                break;
        }

        $sSQL .= ' AND ss.store_id IN (
                SELECT sps.store_id
                FROM store_product_survey sps
                INNER JOIN surveys s ON s.product_id = sps.product_id AND s.del_flg != 1
                WHERE sps.del_flg != 1 AND s.id = ' . $survey_id . '
            )
        ';

        $query = $this->strikeforce->query($sSQL);

        return $query !== FALSE ? $query->result_array() : array();
    }


    public function deleteStore($store_code, $profile)
    {

        $this->strikeforce->where(array('store_code' => $store_code));
        $data = array(
            'del_flg' => 1,
            'mod_func_id' => 'STO0533',
            'mod_ts' => date('Y-m-d H:i:s'),
            'mod_user_id' => $profile["user_id"],
        );
        $rs = $this->strikeforce->update('store_survey', $data);

        return $rs == TRUE ? RES_OK : RES_NG;
    }
}
