<?php 

class Product_group_question_model extends MY_Model
{
	public $strikeforce;

	public function __construct()
	{
		$this->strikeforce = $this->load->database(DATABASE_NAME, TRUE);
	}

    /**
     * API saleman, call record controller
     * @param $product_group_id
     * @return null
     */
    public function getQuestionByProductGroup($product_group_id)
    {
        $query = $this->strikeforce->get_where('product_group_question', array('product_group_id'=>$product_group_id,'del_flg != '=>1));
        return $query !== FALSE ? $query->row_array() : NULL;
    }

    /**
     * Call record controller
     * @param $data
     * @return mixed
     */
    public function addQuestion($data)
    {
        $this->strikeforce->trans_start();
        $this->strikeforce->insert('product_group_question', $data);
        $insert_id = $this->strikeforce->insert_id();
        $this->strikeforce->trans_complete();
        return $insert_id;
    }

    /**
     * Call record controller
     * @param $product_group_id
     * @return mixed
     */
    public function deleteQuestion($product_group_id)
    {
        $this->strikeforce->where('product_group_id', $product_group_id);
        return $this->strikeforce->update('product_group_question', array('del_flg'=>1));
    }
}

?>