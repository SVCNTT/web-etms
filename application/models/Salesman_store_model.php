<?php

class Salesman_store_model extends MY_Model
{
    public $db;

    public function __construct()
    {
        $this->db = $this->load->database(DATABASE_NAME, TRUE);
    }


    /**
     * Get class by salesman
     * @param $salesman_id
     * @return bool
     * @author Ram
     */
    public function getClassBySalesman($salesman_id) {
        $sSQL = " SELECT DISTINCT s.class
                  FROM store s
                  INNER JOIN salesman_store ss ON (s.store_id = ss.store_id)
                  WHERE s.del_flg != '1'
                        AND ss.del_flg != '1'
                        AND ss.salesman_id =" . $salesman_id . "
                  ORDER BY s.class";

        $query = $this->db->query($sSQL);

        return $query !== FALSE ? $query->result_array() : FALSE;
    }


    /**
     * Get total store by salesman, group by class
     * @param $salesman_id
     * @return bool
     * @author Ram
     */
//    public function getTotalStoreBySalesmanGroupByClass($salesman_id) {
//        $sSQL = " SELECT s.class, count(DISTINCT s.store_id)  as totalStore
//                  FROM store s
//                  INNER JOIN salesman_store ss ON (s.store_id = ss.store_id)
//                  WHERE s.del_flg != '1'
//                        AND ss.del_flg != '1'
//                        AND ss.salesman_id =" . $salesman_id ."
//                  GROUP BY s.class
//                  ";
//
//        $query = $this->db->query($sSQL);
//
//        return $query !== FALSE ? $query->result_array() : FALSE;
//    }
}

?>
