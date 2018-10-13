<?php

class Salesman_sync_model extends MY_Model
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
	public function Insert($data)
	{
		$this->strikeforce->trans_start();
        $this->strikeforce->insert('salesman_sync', $data);
        $insert_id = $this->strikeforce->insert_id();
        $this->strikeforce->trans_complete();
        return  $insert_id;
	}

    /**
     * API saleman
     * @param $salesmanId
     * @param $syncSeq
     * @return null
     */
	public function selectByPrimaryKey($salesmanId, $syncSeq )
	{
		$this->strikeforce->select('*');
		$this->strikeforce->from('salesman_sync');
	
        $this->strikeforce->where('del_flg != ', 1);
		$this->strikeforce->where('salesman_id', $salesmanId);
		$this->strikeforce->where('sync_seq', $syncSeq);
        $result = $this->strikeforce->get();
        return $result != false ? $result->row_array() : NULL;
	
	}
	
}

?>