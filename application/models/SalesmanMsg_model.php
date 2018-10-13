<?php 

class SalesmanMsg_model extends MY_Model
{
	public $strikeforce;

		public function __construct()
		{
				$this->strikeforce = $this->load->database(DATABASE_NAME, TRUE);
		}

    /**
     * API saleman
     * @param $param_arr
     * @return null
     */
    public function selectSalesmanMsg($param_arr)
    {
			if (isset($param_arr['distinct']) && $param_arr['distinct']) {
				$this->strikeforce->distinct();
			}
			$salesmanId = isset($param_arr['salesman_id']) ? $param_arr['salesman_id'] : NULL;
			$oldDate = $param_arr['oldDate'];
			
			$this->strikeforce->select('
				A.msg_id as msgId, B.msg_type_name as msgTypeName, B.msg_ts as msgTs, B.msg_context as msgContext
			');
			
			$this->strikeforce->from('salesman_msg A');
			
			$this->strikeforce->join('client_msg B', "A.msg_id = B.msg_id", 'inner');
			
			$this->strikeforce->where('A.salesman_id', $salesmanId);
			
			$this->strikeforce->where('B.msg_ts > ', $oldDate);
			
			$this->strikeforce->order_by('B.msg_ts', 'ASC');
			
			$query = $this->strikeforce->get();

			return $query != FALSE ? $query->result_array() : NULL;
		}
}

?>