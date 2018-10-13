<?php

class Call_record_model extends MY_Model
{
    public $strikeforce;

    public function __construct()
    {
        $this->strikeforce = $this->load->database(DATABASE_NAME, TRUE);
    }

    public function insert($data)
    {
        $this->strikeforce->trans_start();
        $this->strikeforce->insert('call_record', $data);
        $insert_id = $this->strikeforce->insert_id();
        $this->strikeforce->trans_complete();
        return $insert_id;
    }

    public function update($call_record_id, $data)
    {
        return $this->strikeforce->update('call_record', $data, array('call_record_id' => $call_record_id));
    }

    public function insertDetail($table, $detail_data)
    {
        $this->strikeforce->insert($table, $detail_data);
    }

    public function updateDetail($table, $call_record_id, $detail_data)
    {
        return $this->strikeforce->update($table, $detail_data, array('call_record_id' => $call_record_id));
    }

    /**
     * Call record controller
     * @param $params
     * @return bool
     */
    public function searchCallRecord($params)
    {
        $mr_id = isset($params['mr_id']) ? $params['mr_id'] : NULL;
        if ($mr_id !== NULL) {
            $this->strikeforce->where(array('salesman_id'=>intval($mr_id)));
        } else {
            $curr_user = isset($params['curr_user']) ? $params['curr_user'] : NULL;
            if($curr_user) {
                switch($curr_user['user_role_cd']) {
                    case ROLE_ADMIN_CD:
                    case ROLE_MOD_CD:
                        break;

                    case ROLE_BU_CD:
                    case ROLE_SALES_MANAGER_CD:
                    case ROLE_REGION_MANAGER_CD:
                        /*Get MR by current user - Begin*/
                        $this->load->model('saleman_model');
                        $mr_list = $this->saleman_model->selectMRByRole($curr_user);
                        $arr_mr_id = array();
                        if (!empty($mr_list)) {
                            foreach ($mr_list as $temp) {
                                $arr_mr_id[] = strval($temp['salesman_id']);
                            }
                        }
                        /*Get MR by current user - End*/

                        $this->strikeforce->where_in('salesman_id', $arr_mr_id);
                        break;
                }
            }
        }

        $store_id = isset($params['store_id']) ? $params['store_id'] : NULL;
        if ($store_id !== NULL) {
            $this->strikeforce->where(array('store_id'=>intval($store_id)));
        }

        $product_group_id = isset($params['product_group_id']) ? $params['product_group_id'] : NULL;
        if ($product_group_id !== NULL) {
            $this->strikeforce->like('product_group_id', '"'.intval($product_group_id).'"');
        }

        $validate = isset($params['validate']) ? $params['validate'] : NULL;
        if ($validate !== NULL) {
            $this->strikeforce->where(array('validate'=>intval($validate)));
        }

        $limit = isset($params['limit']) ? $params['limit'] : NULL;
        $offset = isset($params['offset']) ? $params['offset'] : NULL;
        if ($limit !== NULL && $offset !== NULL) {
            $this->strikeforce->limit($limit, $offset);
        }

        $this->strikeforce->where(array('del_flg != '=>1));
        $this->strikeforce->order_by('cre_ts desc');
        $query = $this->strikeforce->get('call_record');
        return $query !== FALSE ? $query->result_array() : FALSE;
    }

    /**
     * Call record controller
     * @param $params
     * @return mixed
     */
    public function countSearchCallRecord($params)
    {
        $this->strikeforce->from('call_record');

        $mr_id = isset($params['mr_id']) ? $params['mr_id'] : NULL;
        if ($mr_id !== NULL) {
            $this->strikeforce->where(array('salesman_id'=>intval($mr_id)));
        } else {
            $curr_user = isset($params['curr_user']) ? $params['curr_user'] : NULL;
            if($curr_user) {
                switch($curr_user['user_role_cd']) {
                    case ROLE_ADMIN_CD:
                    case ROLE_MOD_CD:
                        break;

                    case ROLE_BU_CD:
                    case ROLE_SALES_MANAGER_CD:
                    case ROLE_REGION_MANAGER_CD:
                        /*Get MR by current user - Begin*/
                        $this->load->model('saleman_model');
                        $mr_list = $this->saleman_model->selectMRByRole($curr_user);
                        $arr_mr_id = array();
                        if (!empty($mr_list)) {
                            foreach ($mr_list as $temp) {
                                $arr_mr_id[] = strval($temp['salesman_id']);
                            }
                        }
                        /*Get MR by current user - End*/

                        $this->strikeforce->where_in('salesman_id', $arr_mr_id);
                        break;
                }
            }
        }

        $store_id = isset($params['store_id']) ? $params['store_id'] : NULL;
        if ($store_id !== NULL) {
            $this->strikeforce->where(array('store_id'=>intval($store_id)));
        }

        $product_group_id = isset($params['product_group_id']) ? $params['product_group_id'] : NULL;
        if ($product_group_id !== NULL) {
            $this->strikeforce->like('product_group_id', '"'.intval($product_group_id).'"');
        }

        $validate = isset($params['validate']) ? $params['validate'] : NULL;
        if ($validate !== NULL) {
            $this->strikeforce->where(array('validate'=>intval($validate)));
        }

        $this->strikeforce->where(array('del_flg !='=>1));
        return $this->strikeforce->count_all_results();
    }

    /**
     * Call record controller
     * @param $id
     * @return null
     */
    public function getById($id)
    {
        $query = $this->strikeforce->get_where('call_record', array('call_record_id'=>$id, 'del_flg !='=>1), 1);
        return $query !== FALSE ? $query->row_array() : NULL;
    }

    /**
     * API call record controller
     * @param $salesman_id
     * @param $store_id
     * @return null
     */
    public function checkExist($salesman_id, $store_id, $time = 0)
    {
        $query = $this->strikeforce->get_where('call_record'
            , array(
                'salesman_id'=>$salesman_id,
                'store_id'=>$store_id,
                'date_format(cre_ts, "%Y-%m-%d") = date_format("'.date('Y-m-d H:i:s', $time).'", "%Y-%m-%d")' => NULL,
                'del_flg !='=>1)
            , 1);
        return $query !== FALSE ? $query->row_array() : NULL;
    }

    /**
     * Call record controller
     * @param $table
     * @param $id
     * @return null
     */
    public function getDetail($table, $id)
    {
        $query = $this->strikeforce->get_where($table, array('call_record_id'=>$id, 'del_flg !='=>1), 1);
        return $query !== FALSE ? $query->row_array() : NULL;
    }

    /**
     * Call record controller
     * @param $id
     * @param $data
     * @return mixed
     */
    public function deleteRecord($id, $data)
    {
        return $this->strikeforce->update('call_record', $data, array('call_record_id' => $id));
    }

    /**
     * Call record controller
     * @param $params
     * @return mixed
     */
    public function getCallRecordByWeek($params)
    {
        $this->strikeforce->select('count(cr.call_record_id) total,
                DATE(cr.cre_ts) createdDate,
                us_pr_tp.product_type_id productTypeId ');

        $this->strikeforce->from('call_record cr');
        $this->strikeforce->join('user_salesman us_sa', 'us_sa.salesman_id = cr.salesman_id');
        $this->strikeforce->join('user_mst us', 'us.user_id = us_sa.sub_leader_user_id');
        $this->strikeforce->join('user_product_type us_pr_tp', 'us.user_id = us_pr_tp.user_id', 'left');

        $curr_user = isset($params['curr_user']) ? $params['curr_user'] : NULL;
        if($curr_user) {
            switch($curr_user['user_role_cd']) {
                case ROLE_ADMIN_CD:
                case ROLE_MOD_CD:
                    break;

                case ROLE_BU_CD:
                case ROLE_SALES_MANAGER_CD:
                case ROLE_REGION_MANAGER_CD:
                    /*Get MR by current user - Begin*/
                    $this->load->model('saleman_model');
                    $mr_list = $this->saleman_model->selectMRByRole($curr_user);
                    $arr_mr_id = array();
                    if (!empty($mr_list)) {
                        foreach ($mr_list as $temp) {
                            $arr_mr_id[] = strval($temp['salesman_id']);
                        }
                    }
                    /*Get MR by current user - End*/

                    $this->strikeforce->where_in('cr.salesman_id', $arr_mr_id);
                    break;
            }
        }

        $this->strikeforce->where('cr.del_flg != ', 1);
        $this->strikeforce->where('YEARWEEK(cr.cre_ts, 5) = YEARWEEK(CURDATE(), 5)');
        $this->strikeforce->group_by('DATE(cr.cre_ts), us_pr_tp.product_type_id');

        $query = $this->strikeforce->get();

        return $query->result_array();
    }

    /**
     * Call record controller
     * @param $startDate
     * @param $endDate
     * @param $params
     * @return mixed
     */
    public function getCallRecordByDate($startDate, $endDate, $params)
    {
        $this->strikeforce->select('count(cr.call_record_id) total,
                DATE(cr.cre_ts) createdDate,
                us_pr_tp.product_type_id productTypeId ');

        $this->strikeforce->from('call_record cr');
        $this->strikeforce->join('user_salesman us_sa', 'us_sa.salesman_id = cr.salesman_id');
        $this->strikeforce->join('user_mst us', 'us.user_id = us_sa.sub_leader_user_id');
        $this->strikeforce->join('user_product_type us_pr_tp', 'us.user_id = us_pr_tp.user_id', 'left');

        $curr_user = isset($params['curr_user']) ? $params['curr_user'] : NULL;
        if($curr_user) {
            switch($curr_user['user_role_cd']) {
                case ROLE_ADMIN_CD:
                case ROLE_MOD_CD:
                    break;

                case ROLE_BU_CD:
                case ROLE_SALES_MANAGER_CD:
                case ROLE_REGION_MANAGER_CD:
                    /*Get MR by current user - Begin*/
                    $this->load->model('saleman_model');
                    $mr_list = $this->saleman_model->selectMRByRole($curr_user);
                    $arr_mr_id = array();
                    if (!empty($mr_list)) {
                        foreach ($mr_list as $temp) {
                            $arr_mr_id[] = strval($temp['salesman_id']);
                        }
                    }
                    /*Get MR by current user - End*/

                    $this->strikeforce->where_in('cr.salesman_id', $arr_mr_id);
                    break;
            }
        }

        $this->strikeforce->where('cr.del_flg != ', 1);
        $this->strikeforce->where('DATE(cr.cre_ts) >= ', $startDate);
        $this->strikeforce->where('DATE(cr.cre_ts) <= ', $endDate);
        $this->strikeforce->group_by('DATE(cr.cre_ts), us_pr_tp.product_type_id');

        $query = $this->strikeforce->get();

        return $query->result_array();
    }

    /**
     * Get call record by salesman
     * @param $salesman_id
     * @param $date
     * @return bool
     * @author Ram
     */
    public function getMonthlyBySalesman($salesman_id, $date)
    {

        $sSQL = "  SELECT  s.class, case when s.is_doctor = 0 then s.store_name when s.is_doctor = 1 then s.doctor_name end as store_name, cr.call_record_id, cr.store_id, cr.product_group_id, cr.cre_ts
                   FROM call_record cr
                   INNER JOIN store s ON (s.store_id = cr.store_id)
                   WHERE STR_TO_DATE(cr.cre_ts,'%Y-%m') = STR_TO_DATE('" . $date . "','%Y-%m')
    					   	AND s.del_flg != '1'
    						AND cr.del_flg != '1'
    					   	AND cr.salesman_id =" . $salesman_id . "
                   ORDER BY s.class ASC";


        $query = $this->strikeforce->query($sSQL);
        return $query !== FALSE ? $query->result_array() : FALSE;
    }
}