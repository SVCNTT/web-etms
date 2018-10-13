<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {

    public function __construct() {
        parent::__construct();

        /*Authentication - Begin*/
        $this->check_auth = $this->check_login();
        /*Authentication - End*/
    }

    public function index() {
        $profile = $this->profile;
        if (!check_ACL($profile, 'user', 'menu')) {
            $this->load->helper('url');
            redirect('/');
        }

        // Layout library loaded site wide
        $this->set_layout();
        $this->layout->title( USR0100_TITLE.' | Strikeforce');

        $data = array();

        //Set data for layout
        $data['index'] = 'user';
        $data['html_module'] = 'usr0100Module';
        $data['body_id'] = '';
        $data['body_module'] = 'USR0100Ctrl';
        $data['body_ngInit'] = 'init()';
        $data['body_cssClass'] = '';
        $this->set_data_for_layout($data);
        $this->layout->view('user/index', $data);
    }

    public function init_data() {
        $result = array(
            'initSearch'    =>  array(),
            'returnCd'      =>  NULL,
            'returnMsg'     =>  NULL,
        );

        $profile = $this->profile;

        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'user', 'menu')) {
            $offset = 0;
            $search_input['limit'] = ROW_ON_PAGE;
            $search_input['offset'] = $offset;

            $this->load->model('client_model');
            $this->load->model('user_mst_model');
            $this->load->model('area_model');
            $this->load->model('saleman_model');
            $this->load->model('user_product_type_model');

            $conditionSearch['defaultClientId'] = NULL;
            $conditionSearch['defaultRoleCd'] = NULL;
//            $conditionSearch['lstClient'] = $this->client_model->searchAllClientName();
            //Hard code cliend
            $conditionSearch['lstClient'] = array(
                array(
                    'clientId'      =>  strval(1),
                    'clientName'    =>  'Bayer'
                )
            );

            $conditionSearch['lstRoleCd'] = $this->get_roles();
            $initSearch['conditionSearch'] = $conditionSearch;

            /*Paging - Begin*/
            $ttlRow = $this->user_mst_model->countTotalUser($search_input);
            $initSearch['pagingInfo'] = $this->user_mst_model->setPagingInfo($ttlRow, 1);
            /*Paging - End*/

            if ($ttlRow > 0) {
                $user_list = $this->user_mst_model->searchUser($search_input);
                $initSearch['userInfo']['lstUser'] = $this->initUserData($user_list);
            }

            $result['initSearch'] = $initSearch;
        }

        return $this->return_json($result);
    }

    public function search_data() {
        $result = array(
            'resultSearch'  =>  array(
                'userInfo'  =>  array(
                    'lstUser'   =>  array()
                )
            ),
            'returnCd'      =>  NULL,
            'returnMsg'     =>  NULL,
        );

        $profile = $this->profile;

        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'user', 'menu')) {
            $input_data = json_decode(trim(file_get_contents('php://input')), true);

            /*Get search param*/
            $search_input = isset($input_data['searchInput']) ? $input_data['searchInput'] : array();

            /*Get paging param*/
            $paging_input = isset($input_data['pagingInfo']) ? $input_data['pagingInfo'] : array();
            $crtPage = isset($paging_input['crtPage']) ? $paging_input['crtPage'] : 1;
            if ($crtPage < 1) {
                $crtPage = 1;
            }

            $this->load->model('client_model');
            $this->load->model('user_mst_model');
            $this->load->model('area_model');
            $this->load->model('saleman_model');
            $this->load->model('user_product_type_model');

            /*Paging - Begin*/
            $ttlRow = $this->user_mst_model->countTotalUser($search_input);
            $pagingInfo = $this->user_mst_model->setPagingInfo($ttlRow, $crtPage);;
            /*Paging - End*/

            $resultSearch['userInfo']['lstUser'] = array();
            if ($ttlRow > 0) {
                $offset = ( $pagingInfo['crtPage'] - 1) * ROW_ON_PAGE;
                $search_input['limit'] = ROW_ON_PAGE;
                $search_input['offset'] = $offset;

                $user_list = $this->user_mst_model->searchUser($search_input);
                $resultSearch['userInfo']['lstUser'] = $this->initUserData($user_list);
            }

            $resultSearch['pagingInfo'] = $pagingInfo;
            $result['resultSearch'] = $resultSearch;
        }

        return $this->return_json($result);
    }

    public function delete_user() {
        $result = array(
            'returnCd'  =>  NULL,
            'returnMsg' =>  NULL,
            'proResult' =>  array(
                'proFlg'    =>  NULL,
                'message'   =>  NULL
            )
        );

        $profile = $this->profile;
        $cur_user_id = $profile['user_id'];

        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'user', 'manage')) {
            $input_data = json_decode(trim(file_get_contents('php://input')), true);

            /*Get params*/
            $user_code = isset($input_data['userCode']) ? $input_data['userCode'] : '';
            $func_id = 'USR0100';

            /*Get user by user_code*/
            $this->load->model('user_mst_model');
            $user_delete = $this->user_mst_model->searchUserCode($user_code);

            if (isset($user_delete['userRoleCd'])) {
                $data = array(
                    'modFuncId' =>  $func_id,
                    'modTs'     =>  date('Y-m-d H:i:s'),
                    'modUserId' =>  $cur_user_id
                );

                $rs = 0;

                switch($user_delete['userRoleCd']) {
                    case ROLE_ADMIN_CD:
                        $rs = $this->user_mst_model->deleteUser($user_code, $data);

                    case ROLE_MOD_CD:
                        /*Delete area by user-deleted*/
                        $this->load->model('user_area_model');
                        $user_delete_id = isset($user_delete['userId']) && $user_delete['userId'] != '' ? $user_delete['userId'] : -1;
                        $rs = $this->user_mst_model->deleteUser($user_code, $data);
                        if ($rs > 0) {
                            $this->user_area_model->deleteUserArea($user_delete_id);
                        }
                        break;

                    case ROLE_MANAGER_CD:
                        $rs = $this->user_mst_model->deleteUser($user_code, $data);
                        break;

                    case ROLE_BU_CD:
                        /*Check regional manager - Begin*/
                        $old_regional = $this->user_mst_model->searchParentUser($user_delete['userCode']);
                        if (!empty($old_regional)) {
                            $str_regional = '';
                            foreach($old_regional as $item) {
                                $str_regional .= $item['user_code'].', ';
                            }
                            $str_regional = trim($str_regional, ', ');

                            $result['proResult']['proFlg'] = RES_NG;
                            $result['proResult']['message'] = E0000025 . $str_regional . '.';

                            return $this->return_json($result);
                        }
                        /*Check regional manager - End*/

                        $rs = $this->user_mst_model->deleteUser($user_code, $data);
                        break;

                    case ROLE_SALES_MANAGER_CD:
                            /*Check regional manager - Begin*/
                            $old_regional = $this->user_mst_model->searchParentUser($user_delete['userCode']);
                            if (!empty($old_regional)) {
                                $str_regional = '';
                                foreach($old_regional as $item) {
                                    $str_regional .= $item['user_code'].', ';
                                }
                                $str_regional = trim($str_regional, ', ');

                                $result['proResult']['proFlg'] = RES_NG;
                                $result['proResult']['message'] = E0000025 . $str_regional . '.';

                                return $this->return_json($result);
                            }
                            /*Check regional manager - End*/

                        $rs = $this->user_mst_model->deleteUser($user_code, $data);
                        break;

                    case ROLE_REGION_MANAGER_CD:
                        $rs = $this->user_mst_model->deleteUser($user_code, $data);

                        if ($rs > 0) {
                            $this->load->model('user_product_type_model');
                            /*Clear product - Begin*/
                            $this->user_product_type_model->deleteUserProduct($user_delete['userId']);
                            /*Clear product - End*/

                            $this->load->model('user_salesman_model');
                            /*Clear MR(s) - Begin*/
                            $this->user_salesman_model->deleteUserSalesman($user_delete['userId']);
                            /*Clear MR(s) - End*/
                        }
                        break;
                }

                if ($rs == 1) {
                    $result['proResult']['proFlg'] = RES_OK;
                    $result['proResult']['message'] = I0000003;
                } else {
                    $result['proResult']['proFlg'] = RES_NG;
                    $result['proResult']['message'] = E0000006;
                }
            }
        }

        return $this->return_json($result);
    }

    public function form_reset_password() {
        $this->load->view('user/form_reset_password');
    }

    public function reset_password() {

        $result = array(
            'returnCd'  =>  NULL,
            'returnMsg' =>  NULL,
            'proResult' =>  array(
                'proFlg'    =>  RES_NG,
                'message'   =>  E0000005
            ),
            'message'   =>  NULL
        );

        $profile = $this->profile;

        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'user', 'manage')) {
            $input_data = json_decode(trim(file_get_contents('php://input')), true);

            /*Get params*/
            $password = isset($input_data['password']) ? $input_data['password'] : '';
            $re_password = isset($input_data['rePassword']) ? $input_data['rePassword'] : '';
            $user_code = isset($input_data['userCode']) ? $input_data['userCode'] : '';

            $password_md5 = $this->create_md5($password);
            $re_password_md5 = $this->create_md5($re_password);
            if ($password_md5 === $re_password_md5 && !empty($user_code)) {
                $this->load->model('user_mst_model');

                //Init data for change password
                $param_arr = array();
                $param_arr['password'] = $password_md5;
                $param_arr['salt'] = '';
                $param_arr['modFuncId'] = 'USR0200';
                $param_arr['modTs'] = date('Y-m-d H:i:s');
                $param_arr['modUserId'] = $profile['user_id'];

                $rs = $this->user_mst_model->resetPassword($user_code, $param_arr);
                if ($rs) {
                    $result['proResult']['proFlg'] = RES_OK;
                    $result['proResult']['message'] = I0000004;
                }
            }
        }

        return $this->return_json($result);
    }

    public function form_create() {
        $profile = $this->profile;
        if (!check_ACL($profile, 'user', 'create')) {
            $this->load->helper('url');
            redirect('/');
        }

        // Layout library loaded site wide
        $this->set_layout();
        $this->layout->title( USR0200_TITLE.' | Strikeforce');

        $data = array();

        //Set data for layout
        $data['index'] = 'user';
        $data['html_module'] = 'usr0200Module';
        $data['body_id'] = '';
        $data['body_module'] = 'USR0200Ctrl';
        $data['body_ngInit'] = 'init()';
        $data['body_cssClass'] = '';
        $this->set_data_for_layout($data);
        $this->layout->view('user/form_create', $data);
    }

    public function form_init_data() {
        $result = array(
            'returnCd'  =>  NULL,
            'returnMsg' =>  NULL,
            'initData'  =>  array(
                'lstRole'   =>  array(),
                'defaultRoleCd'     =>  NULL,
                'lstClient' =>  array(),
                'defaultClientId'   =>  1,
                'lstUserManager'    =>  NULL,
                'lstUserLeader'     =>  NULL,
                'lstAreaGroup'      =>  array(
                    'selectedAreaId'    =>  1,
                    'items'             =>  array()
                )
            )
        );


        $profile = $this->profile;

        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'user', 'create')) {
            /*Get roles list - Begin*/
            $result['initData']['lstRole'] = $this->get_roles(FALSE, 'rolName');
            /*Get roles list - End*/

            /*Get areas - Begin*/
            $this->load->model('area_model');
            $params = array(
                'role_cd'           =>  $profile['user_role_cd'],
                'is_select_all'     =>  FALSE,
                'selected_area_id'  =>  NULL,
                'select_level'      =>  SELECT_AREA_LEVEL_1
            );
            $result['initData']['lstAreaGroup'] = $this->area_model->getAreaDropdown($params);
            /*Get areas - End*/

            /*Get client info - Begin*/
            $this->load->model('client_model');
            $params = array();
//            $result['initData']['lstClient'] = $this->client_model->searchAllClientName($params);
            //Hard code cliend
            $result['initData']['lstClient'] = array(
                array(
                    'clientId'      =>  strval(1),
                    'clientName'    =>  'Bayer'
                )
            );
            /*Get client info - End*/
        }

        $this->return_json($result);
    }

    public function search_user_role() {
        $result = array(
            'selectedRoleCd'        => -1,
            'lstUserLeader'         => array(),
            'selectUserLeader'      => NULL,
            'lstSalesManager'       => array(),
            'selectSalesManager'    => NULL,
            'selectSalesManagers'    => array(),
            'lstUserSubLeader'      => array(),
            'selectUserSubLeader'   => NULL,
            'lstAreaGroup'          => array(),
            'lstProduct'            => array(),
            'selectProduct'         => NULL,
            'lstSalesman'           => array(),
            'selectSalesman'        => NULL,
        );

        $profile = $this->profile;

        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'user', 'create')) {
            $input_data = json_decode(trim(file_get_contents('php://input')), true);

            $client_id = isset($input_data['selectClient']['clientId']) ? intval($input_data['selectClient']['clientId']) : NULL;
            $role_cd = isset($input_data['roleCd']) ? $input_data['roleCd'] : -1;
            $user_code = isset($input_data['userCode']) ? $input_data['userCode'] : NULL;

            /*Get user by code - Begin*/
            $this->load->model('user_mst_model');
            $rs_search_user = $this->user_mst_model->searchUserCode($user_code);
            $user_id = isset($rs_search_user['userId']) ? $rs_search_user['userId'] : -1;
            /*Get user by code - End*/

            $this->load->model('area_model');
            $this->load->model('saleman_model');
            $this->load->model('user_product_type_model');
            $this->load->model('product_type_mst_model');

            $list_user_leader = array();
            $list_sales_manager = array();
            $list_user_sub_leader = array();

            switch($role_cd) {
                case ROLE_ADMIN_CD:
                    break;

                case ROLE_MOD_CD:
                    /*Get area list - Begin*/
                    $areas = $this->area_model->getAreaByUser($user_id);
                    if (!empty($areas)) {
                        foreach($areas as $area) {
                            $result['lstAreaGroup'][] = array(
                                'areaId'    =>  $area['area_id'],
                                'araName'   =>  $area['area_name'],
                            );
                        }
                    }
                    /*Get area list - End*/
                    break;

                case ROLE_BU_CD:
                    /*Get sales manager - Begin*/
                    $list_sales_manager = $this->user_mst_model->selectUserNotAssign(ROLE_SALES_MANAGER_CD, $client_id);
                    $selected_sales_manager = $this->user_mst_model->searchParentUser($user_code);

                    if (!empty($selected_sales_manager)) {
                        foreach($selected_sales_manager as $item) {
                            $result['selectSalesManagers'][] = $item['user_id'];
                            $list_sales_manager[] = $item;
                        }
                    }
                    /*Get sales manager - End*/
                    break;

                case ROLE_SALES_MANAGER_CD:
                    /*Get BU - Begin*/
                    $list_user_leader = $this->user_mst_model->selectUserByClientRole($user_id, ROLE_BU_CD, $client_id);
                    /*Get BU - End*/

                    /*Get regional manager - Begin*/
                    $list_user_sub_leader = $this->user_mst_model->selectUserNotAssign(ROLE_REGION_MANAGER_CD, $client_id);
                    $selected_user_sub_leader = $this->user_mst_model->searchParentUser($user_code);

                    if (!empty($selected_user_sub_leader)) {
                        foreach($selected_user_sub_leader as $item) {
                            $result['selectUserSubLeader'][] = $item['user_id'];
                            $list_user_sub_leader[] = $item;
                        }
                    }
                    /*Get regional manager - End*/

                    break;

                case ROLE_REGION_MANAGER_CD:
                    /*Get BU - Begin*/
                    $list_sales_manager = $this->user_mst_model->selectUserByClientRole($user_id, ROLE_SALES_MANAGER_CD, $client_id);
                    /*Get BU - End*/

                    /*Get product type list - Begin*/
                    $result['lstProduct'] = $this->product_type_mst_model->selectProType(array());

                    $selected_products = $this->user_product_type_model->selectByUserId($user_id);
                    if (!empty($selected_products)) {
                        foreach($selected_products as $item) {
                            $result['selectProduct'][] = $item['product_type_id'];
                        }
                    }
                    /*Get product type list - End*/

                    /*Get salesman list - Begin*/
                    $result['lstSalesman'] = $this->saleman_model->selectSalesmanNotAssignUser();
                    $selected_salesman = $this->saleman_model->selectSalesmanByUser($user_id);
                    if (!empty($selected_salesman)) {
                        foreach($selected_salesman as $item) {
                            $result['selectSalesman'][] = $item['salesman_id'];
                            array_unshift($result['lstSalesman'], $item);
                        }
                    }
                    /*Get salesman list - End*/
                    break;
            }

            $result['selectedRoleCd'] = $role_cd;
            $result['lstUserLeader'] = $this->copyUserMstToResultDto($list_user_leader);
            $result['lstSalesManager'] = $this->copyUserMstToResultDto($list_sales_manager);
            $result['lstUserSubLeader'] = $this->copyUserMstToResultDto($list_user_sub_leader);
        }

        return $this->return_json($result);
    }

    public function create_user() {
        $result = array(
            "returnCd" => null,
            "returnMsg" => null,
            "proResult" => array(
                "proFlg"=> RES_NG,
                "message"=> E0000002
            )
        );
        $profile = $this->profile;

        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'user', 'create')) {
            $input_data = json_decode(trim(file_get_contents('php://input')), true);

            $user_code = isset($input_data['userCode']) ? $input_data['userCode'] : '';
            $data['userRole'] = isset($input_data['userRole']) ? $input_data['userRole'] : -1;
            $data['clientId'] = isset($input_data['clientId']) ? $input_data['clientId'] : -1;
            $data['email'] = isset($input_data['email']) ? $input_data['email'] : '';
            $data['phone'] = isset($input_data['phone']) ? $input_data['phone'] : '';
            $data['firstName'] = isset($input_data['firstName']) ? $input_data['firstName'] : '';
            $data['lastName'] = isset($input_data['lastName']) ? $input_data['lastName'] : '';
            $data['userName'] = isset($input_data['userName']) ? $input_data['userName'] : '';
            $data['password'] = isset($input_data['password']) ? $input_data['password'] : '';
            $re_password = isset($input_data['rePassword']) ? $input_data['rePassword'] : '';
            $selected_user_leaders = isset($input_data['selectedUserLeaders']) ? $input_data['selectedUserLeaders'] : array();
            $selected_sales_manager = isset($input_data['selectedSalesManager']) ? $input_data['selectedSalesManager'] : array();
            $selected_sales_managers = isset($input_data['selectedSalesManagers']) ? $input_data['selectedSalesManagers'] : array();
            $selected_user_sub_leaders = isset($input_data['selectedUserSubLeaders']) ? $input_data['selectedUserSubLeaders'] : array();
            $selected_area_id = isset($input_data['selectedAreaId']) ? $input_data['selectedAreaId'] : array();
            $selected_product = isset($input_data['selectedProduct']) ? $input_data['selectedProduct'] : array();
            $selected_salesman = isset($input_data['selectedSalesman']) ? $input_data['selectedSalesman'] : array();
            $data['userId'] = $profile['user_id'];
            $data['funcId'] = 'USR0200';

            //Load model
            $this->load->model('user_mst_model');
            $this->load->model('user_product_type_model');
            $this->load->model('user_salesman_model');

            /*Check retype password - Begin*/
            if ($data['password'] != $re_password) {
                $result['proResult']['proFlg'] = RES_NG;
                $result['proResult']['message'] = E0000005;

                return $this->return_json($result);
            }
            /*Check retype password - End*/

            $data['selected_user_leaders'] = NULL;
            /*Set BU - Begin*/
            if (!empty($selected_user_leaders)) {
                $lead['user_id'] = $selected_user_leaders['userId'];
                $data['selected_user_leaders'] = $lead;
            }
            /*Set BU - End*/

            $data['selected_sales_manager'] = NULL;
            /*Set sales manager - Begin*/
            if (!empty($selected_sales_manager)) {
                $sales_manager['user_id'] = $selected_sales_manager['userId'];
                $data['selected_sales_manager'] = $sales_manager;
            }
            /*Set sales manager - End*/

            /*Set list sales manager - Begin*/
            $data['selected_sales_managers'] = NULL;
            if (!empty($selected_sales_managers)) {
                $sales_managers = array();
                foreach($selected_sales_managers as $item) {
                    $temp['user_id'] = $item['userId'];
                    $temp['version_no'] = $item['versionNo'];

                    $sales_managers[] = $temp;
                }

                $data['selected_sales_managers'] = $sales_managers;
            }
            /*Set list sales manager - End*/

            /*Set regional manager - Begin*/
            $data['selected_user_sub_leaders'] = NULL;
            if (!empty($selected_user_sub_leaders)) {
                $sublead = array();
                foreach($selected_user_sub_leaders as $item) {
                    $temp['user_id'] = $item['userId'];
                    $temp['version_no'] = $item['versionNo'];

                    $sublead[] = $temp;
                }

                $data['selected_user_sub_leaders'] = $sublead;
            }
            /*Set regional manager - End*/

            /*Set area - Begin*/
            $data['selected_area_id'] = NULL;
            if (!empty($selected_area_id)) {
                $areas = array();
                foreach($selected_area_id as $item) {
                    $temp['area_id'] = $item['areaId'];

                    $areas[] = $temp;
                }

                $data['selected_area_id'] = $areas;
            }
            /*Set area - End*/

            /*Check exist email - Begin*/
            $rs = $this->user_mst_model->selectByEmail($data['email']);
            if (!empty($rs)) {
                //Exist email
                $result['proResult']['proFlg'] = RES_NG;
                $result['proResult']['message'] = E0000008;

                return $this->return_json($result);
            }
            /*Check exist email - End*/

            /*Init data - Begin*/
            $usr['client_id'] = $data['clientId'];
            $usr['parent_id'] = NULL;
            $usr['user_code'] = '';
            $usr['password'] = $this->create_md5($data['password']);
            $usr['salt'] = '';
            $usr['first_name'] = $data['firstName'];
            $usr['last_name'] = $data['lastName'];
            $usr['phone_no'] = $data['phone'];
            $usr['email'] = $data['email'];
            $usr['user_sts'] = USER_STS_ACTIVE;
            $usr['user_role_cd'] = $data['userRole'];
            $usr['login_fail_counter'] = 0;
            $usr['cre_func_id'] = $data['funcId'];
            $usr['mod_func_id'] = $data['funcId'];
            $usr['cre_user_id'] = $data['userId'];
            $usr['mod_user_id'] = $data['userId'];
            $usr['cre_ts'] = date('y-m-d H:i:s');
            $usr['mod_ts'] = date('y-m-d H:i:s');
            $usr['del_flg'] = DEL_FLAG_0;
            /*Init data - End*/

            /* Insert - Begin*/
            $id = $this->user_mst_model->insert($usr);
            if ($id) {
                $data_update['user_code'] = $this->getCode(USER_CODE_PREFIX, 6, $id);
                $this->user_mst_model->update($id, $data_update);

                switch($usr['user_role_cd']) {
                    case ROLE_ADMIN_CD:
                        break;

                    case ROLE_MOD_CD:
                        if (is_array($data['selected_area_id'])) {
                            $this->load->model('user_area_model');
                            foreach($data['selected_area_id'] as $area) {
                                $data_area = array();
                                $data_area['area_id'] = $area['area_id'];
                                $data_area['user_id'] = $id;
                                $data_area['cre_func_id'] = $data['funcId'];
                                $data_area['mod_func_id'] = $data['funcId'];
                                $data_area['cre_user_id'] = $data['userId'];
                                $data_area['mod_user_id'] = $data['userId'];
                                $data_area['cre_ts'] = date('y-m-d H:i:s');
                                $data_area['mod_ts'] = date('y-m-d H:i:s');
                                $data_area['del_flg'] = DEL_FLAG_0;

                                $this->user_area_model->insert($data_area);
                            }
                        }
                        break;

                    case ROLE_MANAGER_CD:
                        break;

                    case ROLE_BU_CD:
                        if (is_array($data['selected_sales_managers'])) {
                            foreach($data['selected_sales_managers'] as $item) {
                                $data_sub = array();
                                $data_sub['user_id'] = $item['user_id'];
                                $data_sub['parent_id'] = $id;
                                $data_sub['mod_func_id'] = $data['funcId'];
                                $data_sub['mod_user_id'] = $data['userId'];
                                $data_sub['mod_ts'] = date('y-m-d H:i:s');
                                $data_sub['version_no'] = $item['version_no'] + 1;

                                $this->user_mst_model->updateUserParent($item['user_id'], $data_sub);
                            }
                        }
                        break;

                    case ROLE_SALES_MANAGER_CD:
                        if (is_array($data['selected_user_leaders'])) {
                            $data_update = array();
                            $data_update['parent_id'] =$data['selected_user_leaders']['user_id'];
                            $this->user_mst_model->update($id, $data_update);
                        }

                        if (is_array($data['selected_user_sub_leaders'])) {
                            foreach($data['selected_user_sub_leaders'] as $sublead) {
                                $data_sub = array();
                                $data_sub['user_id'] = $sublead['user_id'];
                                $data_sub['parent_id'] = $id;
                                $data_sub['mod_func_id'] = $data['funcId'];
                                $data_sub['mod_user_id'] = $data['userId'];
                                $data_sub['mod_ts'] = date('y-m-d H:i:s');
                                $data_sub['version_no'] = $sublead['version_no'] + 1;

                                $this->user_mst_model->updateUserParent($sublead['user_id'], $data_sub);
                            }
                        }
                        break;

                    case ROLE_REGION_MANAGER_CD:
                        if (is_array($data['selected_sales_manager'])) {
                            $data_update = array();
                            $data_update['parent_id'] =$data['selected_sales_manager']['user_id'];
                            $this->user_mst_model->update($id, $data_update);
                        }

                        /*Insert product for user - Begin*/
                        if (!empty($selected_product)) {
                            foreach($selected_product as $item) {
                                $data_prouduct = array();
                                $data_prouduct['user_id'] = $id;
                                $data_prouduct['product_type_id'] = $item['product_type_id'];
                                $data_prouduct['cre_func_id'] = $data['funcId'];
                                $data_prouduct['mod_func_id'] = $data['funcId'];
                                $data_prouduct['cre_user_id'] = $data['userId'];
                                $data_prouduct['mod_user_id'] = $data['userId'];
                                $data_prouduct['cre_ts'] = date('y-m-d H:i:s');
                                $data_prouduct['mod_ts'] = date('y-m-d H:i:s');
                                $data_prouduct['version_no'] = 0;

                                $this->user_product_type_model->insert($data_prouduct);
                            }
                        }
                        /*Insert product for user - End*/

                        /*Insert salesman for user - Begin*/
                        if (!empty($selected_salesman)) {
                            foreach($selected_salesman as $item) {
                                $data_salesman = array();
                                $data_salesman['client_id'] = 1;
                                $data_salesman['sub_leader_user_id'] = $id;
                                $data_salesman['salesman_id'] = $item;
                                $data_salesman['cre_func_id'] = $data['funcId'];
                                $data_salesman['mod_func_id'] = $data['funcId'];
                                $data_salesman['cre_user_id'] = $data['userId'];
                                $data_salesman['mod_user_id'] = $data['userId'];
                                $data_salesman['cre_ts'] = date('y-m-d H:i:s');
                                $data_salesman['mod_ts'] = date('y-m-d H:i:s');

                                $this->user_salesman_model->Insert($data_salesman);
                            }
                        }
                        /*Insert salesman for user - Begin*/
                        break;
                }

                $result['proResult']['proFlg'] = RES_OK;
                $result['proResult']['message'] = I0000001;

                /*Send OK mail*/
                $this->sendSuccessMail();
            }


            return $this->return_json($result);
        }
    }

    public function edit($user_code) {
        $profile = $this->profile;
        if (!check_ACL($profile, 'user', 'create')) {
            $this->load->helper('url');
            redirect('/');
        }

        // Layout library loaded site wide
        $this->set_layout();
        $this->layout->title( USR0210_TITLE.' | Strikeforce');

        $data = array();

        //Set data for layout
        $data['index'] = 'user';
        $data['html_module'] = 'usr0210Module';
        $data['body_id'] = '';
        $data['body_module'] = 'USR0210Ctrl';
        $data['body_ngInit'] = 'init()';
        $data['body_cssClass'] = '';

        $data['user_code'] = $user_code;

        $this->set_data_for_layout($data);
        $this->layout->view('user/edit', $data);
    }

    public function search_user_code() {
        $result = array(
            'returnCd'  =>  NULL,
            'returnMsg' =>  NULL,
            'searchUserCode'    =>  NULL
        );


        $profile = $this->profile;

        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'user', 'manage')) {
            $input_data = json_decode(trim(file_get_contents('php://input')), true);

            $user_code = isset($input_data['userCode']) ? $input_data['userCode'] : '';
            if (!empty($user_code)) {
                $this->load->model('user_mst_model');
                $result['searchUserCode'] = $this->user_mst_model->searchUserCode($user_code);
            }
        }

        $this->return_json($result);
    }

    public function update_user() {
        $result = array(
            "returnCd" => null,
            "returnMsg" => null,
            "proResult" => array(
                "proFlg"=> RES_NG,
                "message"=> E0000002
            )
        );
        $profile = $this->profile;

        $rs = 0;
        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'user', 'create')) {
            $input_data = json_decode(trim(file_get_contents('php://input')), true);

            $userId = $profile['user_id'];
            $funcId = 'USR0210';
            $user_code = isset($input_data['userCode']) ? $input_data['userCode'] : '';
            $user_name = isset($input_data['userName']) ? $input_data['userName'] : '';
            $email = isset($input_data['email']) ? $input_data['email'] : '';
            $firstName = isset($input_data['firstName']) ? $input_data['firstName'] : '';
            $lastName = isset($input_data['lastName']) ? $input_data['lastName'] : '';
            $phone = isset($input_data['phone']) ? $input_data['phone'] : '';
            $password = isset($input_data['password']) ? $input_data['password'] : '';
            $userRole = isset($input_data['userRole']) ? $input_data['userRole'] : -1;
            $clientId = isset($input_data['clientId']) ? $input_data['clientId'] : -1;
            $selectedUserLeaders = isset($input_data['selectedUserLeaders']) ? $input_data['selectedUserLeaders'] : NULL;
            $selectedSalesManager = isset($input_data['selectedSalesManager']) ? $input_data['selectedSalesManager'] : NULL;
            $selectedSalesManagers = isset($input_data['selectedSalesManagers']) ? $input_data['selectedSalesManagers'] : array();
            $selectedUserSubLeaders = isset($input_data['selectedUserSubLeaders']) ? $input_data['selectedUserSubLeaders'] : array();
            $selectedAreaId = isset($input_data['selectedAreaId']) ? $input_data['selectedAreaId'] : array();
            $selectedProduct = isset($input_data['selectedProduct']) ? $input_data['selectedProduct'] : array();
            $selectedSalesman = isset($input_data['selectedSalesman']) ? $input_data['selectedSalesman'] : array();

            $this->load->model('user_mst_model');
            $this->load->model('user_area_model');
            $this->load->model('saleman_model');
            $this->load->model('user_product_type_model');
            $this->load->model('user_salesman_model');

            /*Get updated user*/
            $updated_user = $this->user_mst_model->searchUserCode($user_code);

            /*Init update data - Begin*/
            $data_update['user_code'] = $user_code;
            $data_update['client_id'] = $clientId;
            $data_update['first_name'] = $firstName;
            $data_update['last_name'] = $lastName;
            $data_update['phone_no'] = $phone;
            $data_update['email'] = $email;
            $data_update['user_role_cd'] = $userRole;
            $data_update['mod_func_id'] = $funcId;
            $data_update['mod_user_id'] = $userId;
            $data_update['mod_ts'] = date('y-m-d H:i:s');;
            /*Init update data - End*/

            if (!empty($updated_user)) {
                switch($updated_user['userRoleCd']) {
                    case ROLE_ADMIN_CD:
                        break;

                    case ROLE_MOD_CD:
                        /*Delete old area - Begin*/
                        $this->user_area_model->deleteUserArea($updated_user['userId']);
                        /*Delete old area - End*/
                        break;

                    case ROLE_BU_CD:
                        if ($updated_user['userRoleCd'] != $userRole) {
                            $sales_managers = $this->user_mst_model->searchParentUser($user_code);

                            if (!empty($sales_managers)) {
                                $str_sales = '';
                                foreach($sales_managers as $item) {
                                    $str_sales .= $item['user_code'].', ';
                                }
                                $str_sales = trim($str_sales, ', ');

                                $result['proResult']['proFlg'] = RES_NG;
                                $result['proResult']['message'] = E0000025B . $str_sales . '.';

                                return $this->return_json($result);
                            }
                        }
                        break;

                    case ROLE_SALES_MANAGER_CD:
                        if ($updated_user['userRoleCd'] != $userRole) {
                            $regional_managers = $this->user_mst_model->searchParentUser($user_code);

                            if (!empty($regional_managers)) {
                                $str_regional = '';
                                foreach($regional_managers as $item) {
                                    $str_regional .= $item['user_code'].', ';
                                }
                                $str_regional = trim($str_regional, ', ');

                                $result['proResult']['proFlg'] = RES_NG;
                                $result['proResult']['message'] = E0000025B . $str_regional . '.';

                                return $this->return_json($result);
                            }
                        }
                        break;

                    case ROLE_REGION_MANAGER_CD:
                        if ($updated_user['userRoleCd'] != $userRole) {
                            $salesman_list = $this->saleman_model->selectSalesmanByUser($updated_user['userId']);

                            if (!empty($salesman_list)) {
                                $str_salesman = '';
                                foreach($salesman_list as $item) {
                                    $str_salesman .= $item['salesman_code'].', ';
                                }
                                $str_salesman = trim($str_salesman, ', ');

                                $result['proResult']['proFlg'] = RES_NG;
                                $result['proResult']['message'] = E0000025C . $str_salesman . '.';

                                return $this->return_json($result);
                            }
                        }

                        /*Delete old product - Begin*/
                        $this->user_product_type_model->deleteUserProduct($updated_user['userId']);
                        /*Delete old product - End*/

                        /*Delete old salesman - Begin*/
                        $this->user_salesman_model->deleteUserSalesman($updated_user['userId']);
                        /*Delete old salesman - End*/
                        break;
                }

                switch($userRole) {
                    case ROLE_ADMIN_CD:
                        $data_update['parent_id'] = NULL;
                        $data_update['client_id'] = NULL;

                        $rs = $this->user_mst_model->updateByCode($user_code, $data_update);
                        break;

                    case ROLE_MOD_CD:
                        $data_update['parent_id'] = NULL;
                        $data_update['client_id'] = NULL;
                        $rs = $this->user_mst_model->updateByCode($user_code, $data_update);

                        if ($rs) {
                            /*Insert new area - Begin*/
                            if (!empty($selectedAreaId)) {
                                foreach ($selectedAreaId as $area) {
                                    $data_area = array();
                                    $data_area['area_id'] = $area['areaId'];
                                    $data_area['user_id'] = $updated_user['userId'];
                                    $data_area['cre_func_id'] = $funcId;
                                    $data_area['mod_func_id'] = $funcId;
                                    $data_area['cre_user_id'] = $userId;
                                    $data_area['mod_user_id'] = $userId;
                                    $data_area['cre_ts'] = date('y-m-d H:i:s');
                                    $data_area['mod_ts'] = date('y-m-d H:i:s');
                                    $data_area['del_flg'] = DEL_FLAG_0;

                                    $this->user_area_model->insert($data_area);
                                }
                            }
                            /*Insert new area - End*/
                        }
                        break;

                    case ROLE_BU_CD:
                        $data_update['parent_id'] = NULL;
                        $rs = $this->user_mst_model->updateByCode($user_code, $data_update);

                        if ($rs) {
                            /*Clear parent for old sales manager - Begin*/
                            $old_sales = $this->user_mst_model->searchParentUser($user_code);
                            if (!empty($old_sales)) {
                                foreach($old_sales as $item) {
                                    $data_sub = array();
                                    $data_sub['user_id'] = $item['user_id'];
                                    $data_sub['parent_id'] = NULL;
                                    $data_sub['mod_func_id'] = $funcId;
                                    $data_sub['mod_user_id'] = $userId;
                                    $data_sub['mod_ts'] = date('y-m-d H:i:s');
                                    $data_sub['version_no'] = $item['version_no'] + 1;

                                    $this->user_mst_model->updateUserParent($item['user_id'], $data_sub);
                                }
                            }
                            /*Clear parent for old sales manager - End*/

                            /*Update parent for new sales manager - Begin*/
                            if (!empty($selectedSalesManagers)) {
                                foreach($selectedSalesManagers as $item) {
                                    $data_sub = array();
                                    $data_sub['user_id'] = $item['userId'];
                                    $data_sub['parent_id'] = $updated_user['userId'];
                                    $data_sub['mod_func_id'] = $funcId;
                                    $data_sub['mod_user_id'] = $userId;
                                    $data_sub['mod_ts'] = date('y-m-d H:i:s');

                                    $this->user_mst_model->updateUserParent($item['userId'], $data_sub);
                                }
                            }
                            /*Update parent for new sales manager - End*/
                        }
                        break;

                    case ROLE_SALES_MANAGER_CD:
                        $data_update['parent_id'] = $selectedUserLeaders['userId'];
                        $rs = $this->user_mst_model->updateByCode($user_code, $data_update);
                        if ($rs) {
                            /*Clear parent for old regional manager - Begin*/
                            $old_regional = $this->user_mst_model->searchParentUser($user_code);
                            if (!empty($old_regional)) {
                                foreach($old_regional as $item) {
                                    $data_sub = array();
                                    $data_sub['user_id'] = $item['user_id'];
                                    $data_sub['parent_id'] = NULL;
                                    $data_sub['mod_func_id'] = $funcId;
                                    $data_sub['mod_user_id'] = $userId;
                                    $data_sub['mod_ts'] = date('y-m-d H:i:s');
                                    $data_sub['version_no'] = $item['version_no'] + 1;

                                    $this->user_mst_model->updateUserParent($item['user_id'], $data_sub);
                                }
                            }
                            /*Clear parent for old regional manager - End*/

                            /*Update parent for new regional manager - Begin*/
                            if (!empty($selectedUserSubLeaders)) {
                                foreach($selectedUserSubLeaders as $item) {
                                    $data_sub = array();
                                    $data_sub['user_id'] = $item['userId'];
                                    $data_sub['parent_id'] = $updated_user['userId'];
                                    $data_sub['mod_func_id'] = $funcId;
                                    $data_sub['mod_user_id'] = $userId;
                                    $data_sub['mod_ts'] = date('y-m-d H:i:s');

                                    $this->user_mst_model->updateUserParent($item['userId'], $data_sub);
                                }
                            }
                            /*Update parent for new regional manager - End*/
                        }
                        break;

                    case ROLE_REGION_MANAGER_CD:
                        $data_update['parent_id'] = $selectedSalesManager['userId'];
                        $rs = $this->user_mst_model->updateByCode($user_code, $data_update);

                        if ($rs) {
                            /*Insert new product - Begin*/
                            if (!empty($selectedProduct)) {
                                foreach ($selectedProduct as $item) {
                                    $data_product = array();
                                    $data_product['user_id'] = $updated_user['userId'];
                                    $data_product['product_type_id'] = $item['product_type_id'];
                                    $data_product['cre_func_id'] = $funcId;
                                    $data_product['mod_func_id'] = $funcId;
                                    $data_product['cre_user_id'] = $userId;
                                    $data_product['mod_user_id'] = $userId;
                                    $data_product['cre_ts'] = date('y-m-d H:i:s');
                                    $data_product['mod_ts'] = date('y-m-d H:i:s');
                                    $data_product['version_no'] = 0;

                                    $this->user_product_type_model->insert($data_product);
                                }
                            }
                            /*Insert new product - End*/

                            /*Insert new salesman - Begin*/
                            if (!empty($selectedSalesman)) {
                                foreach ($selectedSalesman as $item) {
                                    $data_salesman = array();
                                    $data_salesman['client_id'] = 1;
                                    $data_salesman['sub_leader_user_id'] = $updated_user['userId'];
                                    $data_salesman['salesman_id'] = $item;
                                    $data_salesman['cre_func_id'] = $funcId;
                                    $data_salesman['mod_func_id'] = $funcId;
                                    $data_salesman['cre_user_id'] = $userId;
                                    $data_salesman['mod_user_id'] = $userId;
                                    $data_salesman['cre_ts'] = date('y-m-d H:i:s');
                                    $data_salesman['mod_ts'] = date('y-m-d H:i:s');
                                    $data_salesman['version_no'] = 0;

                                    $this->user_salesman_model->insert($data_salesman);
                                }
                            }
                            /*Insert new salesman - End*/
                        }
                        break;
                }
            }
        }

        if ($rs) {
            $result['proResult']['proFlg'] = RES_OK;
            $result['proResult']['message'] = I0000002;
        }

        return $this->return_json($result);
    }

    private function copyUserMstToResultDto($list) {
        $rs = array();

        if (!empty($list)) {
            foreach($list as $item) {
                $temp = array();
                $temp['fistName'] = $item['first_name'];
                $temp['lastName'] = $item['last_name'];
                $temp['userName'] = $item['last_name'] . ' ' . $item['first_name'];
                $temp['userId'] = $item['user_id'];
                $temp['versionNo'] = $item['version_no'];

                $rs[] = $temp;
            }
        }
        return $rs;
    }

    private function initUserData($user_list) {
        if (!empty($user_list)) {
            foreach($user_list as $k=>$item) {
                switch($item['userRoleCd']){
                    case ROLE_ADMIN_CD:
                        break;
                    case ROLE_MOD_CD:
                        /*Get area by user Id - Begin*/
                        $rs_list_area = $this->area_model->getAreaByUser($item['userId']);
                        if (!empty($rs_list_area)) {
                            foreach($rs_list_area as $a) {
                                $user_list[$k]['lstArea'][] = $a['area_name'];
                            }
                        }
                        /*Get area by user Id - End*/
                        break;
                    case ROLE_BU_CD:
                        /*Get list sales manager - Begin*/
                        $list_regional_manager = $this->user_mst_model->searchParentUser($item['userCode']);
                        if (!empty($list_regional_manager)) {
                            foreach($list_regional_manager as $r) {
                                $user_list[$k]['lstManagerArea'][] = array(
                                    'firstName' =>  $r['first_name'],
                                    'lastName'  =>  $r['last_name'],
                                    'fullName'  =>  $r['last_name'].' '.$r['first_name'],
                                    'userCode'  =>  $r['user_code'],
                                );
                            }
                        }
                        /*Get list sales manager - End*/
                        break;

                    case ROLE_SALES_MANAGER_CD:
                        /*Get sales manager info - Begin*/
                        $parent = $this->user_mst_model->searchUserId($item['parentId']);

                        if ($parent !== NULL) {
                            $user_list[$k]['lstManagerArea'] [] = array(
                                'firstName' =>  $parent['first_name'],
                                'lastName'  =>  $parent['last_name'],
                                'fullName'  =>  $parent['last_name'].' '.$parent['first_name'],
                                'userCode'  =>  $parent['user_code'],
                            );
                        }
                        /*Get sales manager info - End*/

                        /*Get list regional manager - Begin*/
                        $list_regional_manager = $this->user_mst_model->searchParentUser($item['userCode']);
                        if (!empty($list_regional_manager)) {
                            foreach($list_regional_manager as $r) {
                                $user_list[$k]['lstRegionalManager'][] = array(
                                    'firstName' =>  $r['first_name'],
                                    'lastName'  =>  $r['last_name'],
                                    'fullName'  =>  $r['last_name'].' '.$r['first_name'],
                                    'userCode'  =>  $r['user_code'],
                                );
                            }
                        }
                        /*Get list regional manager - End*/
                        break;

                    case ROLE_REGION_MANAGER_CD:
                        /*Get sales manager info - Begin*/
                        $parent = $this->user_mst_model->searchUserId($item['parentId']);
                        if ($parent !== NULL) {
                            $user_list[$k]['lstManagerArea'] [] = array(
                                'firstName' =>  $parent['first_name'],
                                'lastName'  =>  $parent['last_name'],
                                'fullName'  =>  $parent['last_name'].' '.$parent['first_name'],
                                'userCode'  =>  $parent['user_code'],
                            );
                        }
                        /*Get sales manager info - End*/

                        /*Get product list - Begin*/
                        $product = $this->user_product_type_model->selectByUserId($item['userId']);
                        if (!empty($product)) {
                            foreach($product as $p) {
                                $user_list[$k]['lstProduct'][] = array(
                                    'productName'   =>  $p['product_type_name']
                                );
                            }
                        }
                        /*Get product list - End*/

                        /*Get product list - Begin*/
                        $salesman = $this->saleman_model->selectSalesmanByUser($item['userId']);
                        if (!empty($salesman)) {
                            foreach($salesman as $s) {
                                $user_list[$k]['lstSalesman'][] = array(
                                    'salesmanCode'  =>  $s['salesman_code'],
                                    'salesmanName'  =>  $s['salesman_name']
                                );
                            }
                        }
                        /*Get product list - End*/
                        break;
                }
            }
        }

        return $user_list;
    }
}
?>