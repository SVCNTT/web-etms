<?php

class User_salesman_model extends MY_Model
{
    public $strikeforce;

    public function __construct()
    {
        $this->strikeforce = $this->load->database(DATABASE_NAME, TRUE);
    }

    /**
     * User controller
     * @param $data
     * @return mixed
     */
	public function Insert($data)
	{
		$this->strikeforce->trans_start();
        $this->strikeforce->insert('user_salesman', $data);
        $insert_id = $this->strikeforce->insert_id();
        $this->strikeforce->trans_complete();
        return  $insert_id;
	}
	
    /**
     * User controller
     * @param $user_id
     * @return mixed
     */
    public function deleteUserSalesman($user_id)
    {
        $this->strikeforce->where('sub_leader_user_id', $user_id);
        return $this->strikeforce->delete('user_salesman');
    }
}

?>