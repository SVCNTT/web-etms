<?php

class Salesman_store_survey_model extends MY_Model
{
    public $db;

    public function __construct()
    {
        $this->db = $this->load->database(DATABASE_NAME, TRUE);
    }


    public function getSalesmanByStore($params = array()) {
        $store_id = isset($params['store_id']) ? $params['store_id'] : 0;

        $this->db->select('DISTINCT salesman.salesman_code, salesman.salesman_name', FALSE);
        $this->db->from('salesman_store_survey');
        $this->db->join('salesman', 'salesman.salesman_id = salesman_store_survey.salesman_id AND salesman.del_flg = 0', 'INNER');
        $this->db->where(array('salesman_store_survey.store_id' => $store_id, 'salesman_store_survey.del_flg' => 0));
        $query = $this->db->get();

        return $query != FALSE ? $query->result_array() : array();
    }
}

?>
