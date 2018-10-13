<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->load->helper('url');
        /*Check login - Begin*/
        if ($this->check_login() !== FALSE) {
            redirect('DAS0100');
        }
        /*Check login - End*/

        /*Get login error - Begin*/
        $this->load->library('Authentication');
        $message = $this->authentication->get_data('bayer-login-error', PLATFORM);
        $this->authentication->unset_data('bayer-login-error', PLATFORM);
        /*Get login error - End*/

        $data = array();
        $data['message'] = $message;
        $this->load->view(PROJECT_VERSION.'/admin/form_login', $data);
    }

    public function change_password() {
        $this->load->view('admin/form_change_password');
    }

    public function do_change_password() {
        $result = array(
            'returnCd'  =>  null,
            'returnMsg' =>  null,
            'proResult' =>  array(
                'proFlg'    =>  RES_NG,
                'message'   =>  ''
            )
        );

        /*Authentication - Begin*/
        $this->check_auth = $this->check_login();
        /*Authentication - End*/

        $profile = $this->profile;
        if ($this->input->method(TRUE) === 'POST' && $this->check_auth !== FALSE) {
            $input_data = json_decode(trim(file_get_contents('php://input')), true);
            $old_password = isset($input_data['oldPassword']) ? $input_data['oldPassword'] : '';
            $new_password = isset($input_data['newPassword']) ? $input_data['newPassword'] : '';
            $confirm_password = isset($input_data['reNewPassword']) ? $input_data['reNewPassword'] : '';

            $user_id = isset($profile['user_id']) ? $profile['user_id'] : -1;
            $user_code = isset($profile['user_code']) ? $profile['user_code'] : '';

            if ($new_password !== $confirm_password) {
                // Passwords do not match
                $result['proResult']['message'] = E0000016;
            } else if (strlen($new_password) < MIN_LEN_PASS){
                // Password too short
                $result['proResult']['message'] = E0000017;
            } else {
                $old_password_md5 = $this->create_md5($old_password);
                $current_pass = isset($profile['password']) ? $profile['password'] : '';

                if ($old_password_md5 !== $current_pass) {
                    // Current password does not match
                    $result['proResult']['message'] = E0000018;
                } else {
                    // Ok
                    $this->load->model('user_mst_model');
                    $new_password_md5 = $this->create_md5($new_password);

                    //Init data for change password
                    $param_arr = array();
                    $param_arr['password'] = $new_password_md5;
                    $param_arr['salt'] = '';
                    $param_arr['modFuncId'] = 'AUT0200';
                    $param_arr['modTs'] = date('Y-m-d H:i:s');
                    $param_arr['modUserId'] = $user_id;

                    $rs = $this->user_mst_model->resetPassword($user_code, $param_arr);
                    if ($rs) {
                        $result['proResult']['proFlg'] = RES_OK;
                        $result['proResult']['message'] = I0000004;

                        /*Update SESSION - Begin*/
                        $profile['password'] = $new_password_md5;
                        $this->load->library('Authentication');
                        $this->authentication->set_authentication($profile, PLATFORM);
                        /*Update SESSION - End*/
                    }
                }
            }
        }

        return $this->return_json($result);
    }

    public function doLogin() {
        $this->load->helper('url');
        $this->load->library('Authentication');

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $post = $this->input->post(NULL, TRUE);

            $username = isset($post['username']) ? $post['username'] : '';
            $password = isset($post['password']) ? $post['password'] : '';
            $pwMD5 = $this->create_md5($password);
            /*Get user info - Begin*/
            $this->load->model('user_mst_model');
            $para_arr = array(
                'email'     =>  $username,
                'user_sts'  =>  USER_STS_ACTIVE
            );

            $user = $this->user_mst_model->selectByExample($para_arr);
            /*Get user info - End*/

            if (!empty($user) && isset($user['user_id']) && isset($user['password'])) {
                if ($pwMD5 === $user['password']) {
                //Login successful
                    $this->authentication->set_authentication($user, PLATFORM);

                //Redirect backend
                redirect('DAS0100');
                } else {
                    //Login fail
                    $data['login_fail_counter'] = isset($user['login_fail_counter']) ? $user['login_fail_counter'] + 1 : 1;
                    $this->user_mst_model->update($user['user_id'], $data);
            }
        }
        }

        /*Store error - Begin*/
        $this->authentication->set_data('bayer-login-error', E0000001, PLATFORM);
        /*Store error - End*/

        redirect('admin');
    }

    public function logout() {
        $this->load->helper('url');

        if ($this->check_login() !== FALSE) {
            $this->load->library('Authentication');
            $this->authentication->unset_authentication(PLATFORM);

            //Destroy SESSION
            session_destroy();
        }

        redirect('admin');
    }
}
