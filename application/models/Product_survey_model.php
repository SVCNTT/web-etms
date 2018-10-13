<?php

class Product_survey_model extends MY_Model
{
    public $strikeforce;

    public function __construct()
    {
        $this->strikeforce = $this->load->database(DATABASE_NAME, TRUE);
    }

    public function insert($data) {
        $this->strikeforce->trans_start();
        $this->strikeforce->insert('product_survey', $data);
        $insert_id = $this->strikeforce->insert_id();
        $this->strikeforce->trans_complete();
        return $insert_id;
    }

    public function getByName($name) {

        $query = $this->strikeforce->get_where('product_survey', 'UPPER(product) = \''.strtoupper($name).'\'', 1, 0);
        return $query->row_array();

    }

    public function getByStoreId($store_id) {

        $this->strikeforce->select('DISTINCT product_survey.product', FALSE);
        $this->strikeforce->from('product_survey');
        $this->strikeforce->join('store_product_survey', 'store_product_survey.product_id = product_survey.id AND store_product_survey.del_flg != 1 AND store_product_survey.store_id = '.$store_id, 'INNER');
        $this->strikeforce->where('product_survey.del_flg != 1');
        $query = $this->strikeforce->get();
        return $query->result_array();

    }
}

?>