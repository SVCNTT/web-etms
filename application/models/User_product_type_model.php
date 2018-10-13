<?php

class User_product_type_model extends MY_Model
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
        $this->strikeforce->insert('user_product_type', $data);
    }

    /**
     * User controller
     * @param $user_id
     * @return mixed
     */
    public function deleteUserProduct($user_id)
    {
        $this->strikeforce->where('user_id', $user_id);
        return $this->strikeforce->delete('user_product_type');
    }

    /**
     * User controller
     * @param $user_id
     * @return bool
     */
    public function selectByUserId($user_id)
    {
        $this->strikeforce->select('p.*', FALSE);
        $this->strikeforce->from('user_product_type up');
        $this->strikeforce->join('product_type_mst p', 'up.product_type_id = p.product_type_id', 'inner');
        $this->strikeforce->where(array('up.user_id'=>$user_id, 'up.del_flg !='=>1));
        $query = $this->strikeforce->get();
        return $query !== FALSE ? $query->result_array() : FALSE;
    }

    /**
     * Dashboard controller
     * @param $user
     * @return array
     */
    public function getProductTypeByRole($user, $flag_cache = TRUE)
    {
        $result = array();

        $curr_user_id = isset($user['user_id']) ? $user['user_id'] : -1;
        if ($curr_user_id < 0) {
            return $result;
        }

        /*Get cache - Begin*/
        $key = 'product_type_by_role_'.date('YmdH').'_'.$curr_user_id;
        $this->load->library('authentication');
        $result = $this->authentication->get_data($key, PLATFORM);
        if ($result !== FALSE && $flag_cache) {
            return $result;
        }
        /*Get cache - End*/

        $curr_rolde_cd = isset($user['user_role_cd']) ? $user['user_role_cd'] : -1;

        $result = array();
        switch($curr_rolde_cd) {
            case ROLE_ADMIN_CD:
            case ROLE_MOD_CD:
                //Get all
                $this->strikeforce->distinct();
                $this->strikeforce->select('p.product_type_id, p.product_type_name, p.client_id');
                $this->strikeforce->from('product_type_mst p');
                $this->strikeforce->where(array('p.del_flg !=' => 1));
                $this->strikeforce->order_by('p.product_type_name asc');
                $query = $this->strikeforce->get();
                $result = $query !== FALSE ? $query->result_array() : array();
                break;

            case ROLE_BU_CD:
            case ROLE_SALES_MANAGER_CD:
            case ROLE_REGION_MANAGER_CD:
                /*Get MR by current user - Begin*/
                $this->load->model('user_mst_model');
                $rm_array = $this->user_mst_model->getRegionalManagerByRole($user);
                $rm_id_array = array();
                foreach($rm_array as $temp) {
                    $rm_id_array[] = $temp['user_id'];
                }

                $this->strikeforce->distinct();
                $this->strikeforce->select('up.product_type_id, p.product_type_name, p.client_id');
                $this->strikeforce->from('user_product_type up');
                $this->strikeforce->join('product_type_mst p', 'up.product_type_id = p.product_type_id', 'inner');
                $this->strikeforce->where(array('p.del_flg !=' => 1));
                $this->strikeforce->where_in('up.user_id', $rm_id_array);
                $this->strikeforce->order_by('p.product_type_name asc');
                $query = $this->strikeforce->get();
                $result = $query !== FALSE ? $query->result_array() : array();
                break;
        }

        /*Store SESSION - Begin*/
        $this->authentication->set_data($key, $result, PLATFORM);
        /*Store SESSION - End*/

        return $result;
    }
}