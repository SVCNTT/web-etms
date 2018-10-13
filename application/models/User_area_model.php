<?php

class User_area_model extends MY_Model
{
    public $strikeforce;

    public function __construct()
    {
        $this->strikeforce = $this->load->database(DATABASE_NAME, TRUE);
    }

    /**
     * User controller
     * @param $data
     */
    public function insert($data)
    {
        $this->strikeforce->insert('user_area', $data);
    }

    /**
     * User controller
     * @param $user_id
     * @return mixed
     */
    public function deleteUserArea($user_id)
    {
        $this->strikeforce->where('user_id', $user_id);
        return $this->strikeforce->delete('user_area');
    }
}