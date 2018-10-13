<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User_mst_model extends MY_Model
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
     * @author can
     */
    public function insert($data)
    {
        $this->strikeforce->trans_start();
        $this->strikeforce->insert('user_mst', $data);
        $insert_id = $this->strikeforce->insert_id();
        $this->strikeforce->trans_complete();
        return $insert_id;
    }

    /**
     * Admin controller, API saleman, User controller
     * @param $user_id
     * @param $data
     * @return mixed
     */
    public function update($user_id, $data)
    {
        return $this->strikeforce->update('user_mst', $data, array('user_id' => $user_id));
    }

    /**
     * User controller
     * @param $user_code
     * @param $data
     * @return mixed
     */
    public function updateByCode($user_code, $data)
    {
        return $this->strikeforce->update('user_mst', $data, array('user_code' => $user_code));
    }

    /**
     * Admin controller
     * @param $arrParam
     * @return null
     */
    public function selectByExample($arrParam)
    {
        $email = isset($arrParam['email']) ? $arrParam['email'] : '';
        $user_sts = isset($arrParam['user_sts']) ? $arrParam['user_sts'] : USER_STS_NOT_ACTIVE;

        if (empty($email) || $user_sts !== USER_STS_ACTIVE) {
            return NULL;
        }

        $sSQL = "
            SELECT  user_id, user_code, password, salt, login_fail_counter, email, user_sts, last_login_ts,
                    user_role_cd, client_id, parent_id, phone_no, first_name, last_name, cre_func_id,
                    cre_ts, cre_user_id, mod_func_id, mod_ts, mod_user_id, version_no, del_flg
            FROM user_mst
            WHERE UPPER(email) like UPPER('" . $email . "')";

        $result = $this->strikeforce->query($sSQL);
        return $result != false ? $result->row_array() : NULL;;
    }

    /**
     * User controller
     * @param array $param_arr
     * @return null
     */
    public function searchUser($param_arr = array())
    {
        $this->strikeforce->distinct();
        $this->strikeforce->select("
            c.client_id as clientId
            ,c.client_code as clientCode
            ,c.client_name as clientName
            ,u.user_id as userId
            ,u.user_code as userCode
            ,u.email
            ,u.user_sts as userSts
            ,u.user_role_cd as userRoleCd
            ,u.phone_no as phone
            ,u.first_name as firstName
            ,u.last_name as lastName
            ,concat(u.last_name, ' ', u.first_name) as fullName
            ,u.parent_id as parentId
            ,u.version_no as versionNo
            ,CASE user_role_cd WHEN " . ROLE_ADMIN_CD . " THEN '" . ROLE_ADMIN . "'
                                WHEN " . ROLE_MOD_CD . " THEN '" . ROLE_SUB_ADMIN . "'
                                WHEN " . ROLE_MANAGER_CD . " THEN '" . ROLE_MANAGER . "'
                                WHEN " . ROLE_BU_CD . " THEN '" . ROLE_LEADER . "'
                                WHEN " . ROLE_SALES_MANAGER_CD . " THEN '" . ROLE_SALES_MANAGER . "'
                                WHEN " . ROLE_REGION_MANAGER_CD . " THEN '" . ROLE_SUB_LEADER . "' END as roleName
        ", FALSE);

        $this->strikeforce->from('user_mst u');
        $this->strikeforce->join('client c', "u.client_id = c.client_id and c.del_flg != '1'", 'left');
        $this->strikeforce->join('user_area d', "d.user_id = u.user_id", 'left');

        $this->strikeforce->where(' u.del_flg != ', 1);

        $clientId = isset($param_arr['clientId']) ? $param_arr['clientId'] : NULL;
        if ($clientId !== NULL) {
            $this->strikeforce->where('c.client_id', $clientId);
        }

        $roleCd = isset($param_arr['roleCd']) ? $param_arr['roleCd'] : NULL;
        if ($roleCd !== NULL) {
            $this->strikeforce->where('u.user_role_cd', $roleCd);
        }

        $userCode = isset($param_arr['userCode']) ? $param_arr['userCode'] : NULL;
        if ($userCode !== NULL && !empty($userCode)) {
            $this->strikeforce->where('(UPPER(u.user_code) like \'%' . strtoupper($userCode) . '%\') ');
        }

        $userName = isset($param_arr['userName']) ? $param_arr['userName'] : NULL;
        if ($userName !== NULL && !empty($userName)) {
            $this->strikeforce->where('(UPPER(u.first_name) like \'%' . strtoupper($userName) . '%\' OR UPPER(u.last_name) like \'%' . strtoupper($userName) . '%\') ');
        }

        $listAreaId = isset($param_arr['listAreaId']) ? $param_arr['listAreaId'] : NULL;
        if (is_array($listAreaId)) {
            $this->strikeforce->where_in('d.area_id', $listAreaId);
        }

        $limit = isset($param_arr['limit']) ? $param_arr['limit'] : NULL;
        $offset = isset($param_arr['offset']) ? $param_arr['offset'] : NULL;
        if ($limit !== NULL && $offset !== NULL) {
            $this->strikeforce->limit($limit, $offset);
        }

        $this->strikeforce->order_by('c.client_name ASC, u.user_code');
        $query = $this->strikeforce->get();

        return $query != FALSE ? $query->result_array() : NULL;
    }

    /**
     * User controller
     * @param array $param_arr
     * @return mixed
     */
    public function countTotalUser($param_arr = array())
    {
        $this->strikeforce->distinct();
        $this->strikeforce->select('
            c.client_id as clientId
            ,c.client_code as clientCode
            ,c.client_name as clientName
            ,u.user_id as userId
            ,u.user_code as userCode
            ,u.email
            ,u.user_sts as userSts
            ,u.user_role_cd as userRoleCd
            ,u.phone_no as phoneNo
            ,u.first_name as firstName
            ,u.last_name as lastName
            ,u.parent_id as parentId
            ,u.version_no as versionNo
        ');

        $this->strikeforce->from('user_mst u');
        $this->strikeforce->join('client c', "u.client_id = c.client_id and c.del_flg != '1'", 'left');
        $this->strikeforce->join('user_area d', "d.user_id = u.user_id", 'left');

        $this->strikeforce->where(' u.del_flg != ', 1);

        $clientId = isset($param_arr['clientId']) ? $param_arr['clientId'] : NULL;
        if ($clientId !== NULL) {
            $this->strikeforce->where('c.client_id', $clientId);
        }

        $roleCd = isset($param_arr['roleCd']) ? $param_arr['roleCd'] : NULL;
        if ($roleCd !== NULL) {
            $this->strikeforce->where('u.user_role_cd', $roleCd);
        }

        $userCode = isset($param_arr['userCode']) ? $param_arr['userCode'] : NULL;
        if ($userCode !== NULL && !empty($userCode)) {
            $this->strikeforce->where('(UPPER(u.user_code) like \'%' . strtoupper($userCode) . '%\') ');
        }

        $userName = isset($param_arr['userName']) ? $param_arr['userName'] : NULL;
        if ($userName !== NULL && !empty($userName)) {
            $this->strikeforce->where('(UPPER(u.first_name) like \'%' . strtoupper($userName) . '%\' OR UPPER(u.last_name) like \'%' . strtoupper($userName) . '%\') ');
        }

        $listAreaId = isset($param_arr['listAreaId']) ? $param_arr['listAreaId'] : NULL;
        if (is_array($listAreaId)) {
            $this->strikeforce->where_in('d.area_id', $listAreaId);
        }

        return $this->strikeforce->count_all_results();
    }

    /**
     * User controller
     * @param $user_code
     * @return null
     */
    public function searchUserCode($user_code)
    {
        $this->strikeforce->select("client_id as clientId, first_name as fistName, last_name as lastName, concat(last_name, ' ', first_name) as userName,
            email as email, phone_no as phoneNo, user_code as userCode, user_id as userId, user_role_cd as userRoleCd,
            version_no as versionNo, parent_id as parentId", FALSE);
        $this->strikeforce->where(array('del_flg !=' => '1', 'user_code' => $user_code));
        $query = $this->strikeforce->get('user_mst');

        $rs = $query !== FALSE ? $query->row_array() : NULL;
        return $rs;
    }

    /**
     * User controller
     * @param $user_code
     * @param $data
     * @return mixed
     */
    public function deleteUser($user_code, $data)
    {
        $modFuncId = isset($data['modFuncId']) ? $data['modFuncId'] : '';
        $modTs = isset($data['modTs']) ? $data['modTs'] : date('Y-m-d H:i:s');
        $modUserId = isset($data['modUserId']) ? $data['modUserId'] : 0;

        $str_sql = "
        update  user_mst
        set
            del_flg = '1'
            ,mod_func_id = ?
            ,mod_ts = ?
            ,mod_user_id = ?
            ,version_no = version_no + 1
        where
             user_code = ?";

        return $this->strikeforce->query($str_sql, array($modFuncId, $modTs, $modUserId, $user_code));
    }

    /**
     * Admin controller, User controller
     * @param $user_code
     * @param $param_arr
     * @return mixed
     */
    public function resetPassword($user_code, $param_arr)
    {
        $data = array(
            'password' => isset($param_arr['password']) ? $param_arr['password'] : '',
            'salt' => isset($param_arr['salt']) ? $param_arr['salt'] : '',
            'mod_func_id' => isset($param_arr['modFuncId']) ? $param_arr['modFuncId'] : '',
            'mod_ts' => isset($param_arr['modTs']) ? $param_arr['modTs'] : '',
            'mod_user_id' => isset($param_arr['modUserId']) ? $param_arr['modUserId'] : '',
        );

        $this->strikeforce->set('version_no', 'version_no + 1', FALSE);
        $this->strikeforce->where(array('user_code' => $user_code, 'del_flg !=' => 1));
        return $this->strikeforce->update('user_mst', $data);
    }

    /**
     * User controller
     * @param $email
     * @return null
     */
    public function selectByEmail($email)
    {
        $query = $this->strikeforce->get_where('user_mst', array('email' => $email, 'del_flg' => 0), 1);
        return $query !== FALSE ? $query->row_array() : NULL;
    }

    /**
     * User controller
     * @param $userId
     * @param $data
     */
    public function updateUserParent($userId, $data)
    {
        $this->strikeforce->where(array('user_id' => $userId, 'del_flg' => 0));
        $this->strikeforce->update('user_mst', $data);
    }

    /**
     * User controller
     * @param $user_id
     * @param $role_cd
     * @param $client_id
     * @param null $parent_id
     * @param null $parent_flg
     * @return null
     */
    public function selectUserByClientRole($user_id, $role_cd, $client_id, $parent_id = null, $parent_flg = null)
    {
        $sql = "SELECT *
                FROM user_mst
                WHERE del_flg != '1' and user_id != ? and user_role_cd = ? and client_id = ?";
        $query = $this->strikeforce->query($sql, array($user_id, $role_cd, $client_id));

        return $query !== FALSE ? $query->result_array() : NULL;
    }

    /**
     * User controller
     * @param $user_role_cd
     * @param $client_id
     * @return null
     */
    public function selectUserNotAssign($user_role_cd, $client_id)
    {
        $sql = "SELECT *
                FROM user_mst
                WHERE del_flg != '1'and user_role_cd = ? and client_id = ? and parent_id is null
                ORDER BY user_code";
        $query = $this->strikeforce->query($sql, array($user_role_cd, $client_id));

        return $query !== FALSE ? $query->result_array() : NULL;
    }

    /**
     * User controller
     * @param $user_code
     * @return null
     */
    public function searchParentUser($user_code)
    {
        $sql = "SELECT *
                FROM  user_mst
                WHERE del_flg != '1' and parent_id  = (SELECT user_id FROM  user_mst WHERE user_code  = ? )";
        $query = $this->strikeforce->query($sql, array($user_code));

        return $query !== FALSE ? $query->result_array() : NULL;
    }

    /**
     * User controller
     * @param $user_id
     * @return null
     */
    public function searchUserId($user_id)
    {
        $query = $this->strikeforce->get_where('user_mst', array('del_flg !=' => 1, 'user_id' => $user_id));

        return $query !== FALSE ? $query->row_array() : NULL;
    }

    /**
     * API saleman
     * @param $arrParam
     * @return null
     */
    public function selectByLoginUser($arrParam)
    {
        $email = isset($arrParam['email']) ? $arrParam['email'] : '';
        $pass = isset($arrParam['pass']) ? $arrParam['pass'] : '';

        if (empty($email) || empty($pass)) {
            return NULL;
        }

        $this->strikeforce->select(' user_id as userId,user_code as userCode, email, user_sts as userSts, user_role_cd as userRoleCd, client_id as clientId,
									phone_no as phoneNo, first_name as firstName, last_name as lastName');
        $this->strikeforce->from('user_mst us');

        $this->strikeforce->where('del_flg !=', '1');
        $this->strikeforce->where('email', $email);
        $this->strikeforce->where('password', $pass);

        $query = $this->strikeforce->get();

        return $query != FALSE ? $query->result_array() : NULL;

    }

    /**
     * Saleman model, User product type model
     * @param $user
     * @return array
     */
    public function getRegionalManagerByRole($user)
    {
        $result = array();

        $curr_user_id = isset($user['user_id']) ? $user['user_id'] : -1;
        if ($curr_user_id < 0) {
            return $result;
        }

        /*Get cache - Begin*/
        $key = 'user_by_role_' . date('YmdH') . '_' . $curr_user_id;
        $this->load->library('authentication');
        $result = $this->authentication->get_data($key, PLATFORM);
        if ($result !== FALSE) {
            return $result;
        }
        /*Bet cache - End*/


        $curr_rolde_cd = isset($user['user_role_cd']) ? $user['user_role_cd'] : -1;

        $result = array();
        switch ($curr_rolde_cd) {
            case ROLE_ADMIN_CD:
            case ROLE_MOD_CD:
                //Get all
                $this->strikeforce->distinct();
                $this->strikeforce->select('user_id');
                $this->strikeforce->where(array('del_flg !=' => 1));
                $query = $this->strikeforce->get('user_mst');
                $result = $query !== FALSE ? $query->result_array() : array();
                break;

            case ROLE_BU_CD:
                $this->strikeforce->distinct();
                $this->strikeforce->select('user_id');
                $this->strikeforce->where(array('parent_id' => $curr_user_id, 'del_flg !=' => 1));
                $query = $this->strikeforce->get('user_mst');
                $sales_manager_arr = $query !== FALSE ? $query->result_array() : array();

                if (!empty($sales_manager_arr)) {
                    $sales_manager_id_arr = array();
                    foreach ($sales_manager_arr as $item) {
                        $sales_manager_id_arr[] = $item['user_id'];
                    }

                    $this->strikeforce->distinct();
                    $this->strikeforce->select('user_id');
                    $this->strikeforce->where(array('del_flg !=' => 1));
                    $this->strikeforce->where_in('parent_id', $sales_manager_id_arr);
                    $query = $this->strikeforce->get('user_mst');
                    $result = $query !== FALSE ? $query->result_array() : array();
                }
                break;

            case ROLE_SALES_MANAGER_CD:
                $this->strikeforce->distinct();
                $this->strikeforce->select('user_id');
                $this->strikeforce->where(array('parent_id' => $curr_user_id, 'del_flg !=' => 1));
                $query = $this->strikeforce->get('user_mst');
                $result = $query !== FALSE ? $query->result_array() : array();
                break;

            case ROLE_REGION_MANAGER_CD:
                $result[] = array(
                    'user_id' => $curr_user_id);
                break;
        }

        /*Store SESSION - Begin*/
        $this->authentication->set_data($key, $result, PLATFORM);
        /*Store SESSION - End*/

        return $result;
    }


    /**
     * Inventory controller
     * @param $user
     * @return array
     */
    public function getSalesManagerByRole($user)
    {
        $result = array();

        $curr_user_id = isset($user['user_id']) ? $user['user_id'] : -1;
        if ($curr_user_id < 0) {
            return $result;
        }

        /*Get cache - Begin*/
        $key = 'sales_manager_by_role_' . date('YmdH') . '_' . $curr_user_id;
        $this->load->library('authentication');
        $result = $this->authentication->get_data($key, PLATFORM);
        if ($result !== FALSE) {
            return $result;
        }
        /*Bet cache - End*/


        $curr_rolde_cd = isset($user['user_role_cd']) ? $user['user_role_cd'] : -1;

        $result = array();
        switch ($curr_rolde_cd) {
            case ROLE_ADMIN_CD:
            case ROLE_MOD_CD:
            case ROLE_MANAGER_CD:
            case ROLE_BU_CD:
            case ROLE_SALES_MANAGER_CD:
                $this->strikeforce->select('user_id, first_name, last_name', FALSE);

                $query = $this->strikeforce->get_where('user_mst', array('user_role_cd' => ROLE_SALES_MANAGER_CD, 'del_flg' => '0'));
                $result = $query !== FALSE ? $query->result_array() : FALSE;
                break;

            default:
                $result = array();
        }

        /*Store SESSION - Begin*/
        $this->authentication->set_data($key, $result, PLATFORM);
        /*Store SESSION - End*/

        return $result;
    }

    /**
     * Inventory controller
     * @param $user
     * @return array
     */
    public function getRegionalManagerBySalesManager($sales_manager)
    {
        $result = array();

        $sales_manager_id = isset($sales_manager['user_id']) ? $sales_manager['user_id'] : 0;

        /*Get cache - Begin*/
        $key = 'regional_manager_by_sales_manager_' . date('YmdH') . '_' . $sales_manager_id;
        $this->load->library('authentication');
        $result = $this->authentication->get_data($key, PLATFORM);
        if ($result !== FALSE) {
            return $result;
        }
        /*Bet cache - End*/


        $this->strikeforce->select('user_id, first_name, last_name', FALSE);

        $condition_arr = array(
            'user_role_cd' => ROLE_REGION_MANAGER_CD,
            'del_flg' => '0'
        );


        if ($sales_manager_id != 0) {
            $condition_arr['parent_id'] = $sales_manager_id;
        }


        $query = $this->strikeforce->get_where('user_mst', $condition_arr);
        $result = $query !== FALSE ? $query->result_array() : FALSE;

        /*Store SESSION - Begin*/
        $this->authentication->set_data($key, $result, PLATFORM);
        /*Store SESSION - End*/

        return $result;
    }
}

?>