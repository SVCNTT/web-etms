<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

    public function __construct() {
        parent::__construct();

        /*Authentication - Begin*/
        $this->check_auth = $this->check_login();
        /*Authentication - End*/
    }

    public function index() {
        // Layout library loaded site wide
        $this->set_layout(PROJECT_VERSION.'/layout/default');
        $this->layout->title('Dashboard | Strikeforce');

        $data = array();

        //Set data for layout
        $data['index'] = 'dashboard';
        $data['html_module'] = 'das0100Module';
        $data['body_id'] = '';
        $data['body_module'] = 'DAS0100Ctrl';
        $data['body_ngInit'] = 'init()';
        $data['body_cssClass'] = 'DAS0100';
        $this->set_data_for_layout($data);
        $this->layout->view('dashboard/index', $data);
//        $this->layout->view(PROJECT_VERSION.'/call_record/statictis', $data);
    }

    public function get_messages() {
        $result = array();

        $this->return_json($result);
    }

    public function photo()
    {
        $data['profile'] = $this->profile;
        $this->load->view('dashboard/photo', $data);
    }

    public function photo_init_data() {
        $result = array(
            'storeInfo' =>  array(),
            'returnCd'  =>  NULL,
            'returnMsg' =>  NULL,
        );

        $profile = $this->profile;

        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'dashboard', 'menu')) {
            $this->load->model('store_model');
            $this->load->model('photos_model');
            $result['storeInfo'] = array_merge(array('0'=>array('store_id'=>null, 'store_name'=>'--- All ---')), $this->store_model->selectStoreByRole($profile));
            $result['photoInfo'] = $this->photos_model->getPhotoByClientAndStore(array('curr_user'=>$profile));
        }

        return $this->return_json($result);
    }

    public function photo_select_photo() {
        $result = array(
            'selectPhoto' =>  array(
                'photoCal'  =>  array()
            ),
            'returnCd'  =>  NULL,
            'returnMsg' =>  NULL,
        );

        $profile = $this->profile;

        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'dashboard', 'menu')) {
            $input_data = json_decode(trim(file_get_contents('php://input')), true);
            $input_data['curr_user'] = $profile;

            $this->load->model('store_model');
            $this->load->model('photos_model');
            $result['selectPhoto'] = $this->photos_model->getPhotoByClientAndStore($input_data);
        }

        return $this->return_json($result);
    }

    public function schedule()
    {
        $data['profile'] = $this->profile;
        $this->load->view('dashboard/schedule', $data);
    }

    public function schedule_init_data() {
        $result = array(
            'productTypeInfo' =>  array(),
            'returnCd'  =>  NULL,
            'returnMsg' =>  NULL,
        );

        $profile = $this->profile;

        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'dashboard', 'menu')) {
            $this->load->model('user_product_type_model');
            $this->load->model('salesman_leave_model');
            $result['productTypeInfo'] = array_merge(array('0'=>array('product_type_id'=>null, 'product_type_name'=>'--- All ---')), $this->user_product_type_model->getProductTypeByRole($profile));

            $arrParam['curr_user'] = $profile;
            $result['scheduleInfo'] = $this->salesman_leave_model->getSchedule($arrParam);
        }

        return $this->return_json($result);
    }

    public function schedule_select() {
        $result = array(
            'scheduleInfo' =>  array(
                'scheduleResult'  =>  array()
            ),
            'returnCd'  =>  NULL,
            'returnMsg' =>  NULL,
        );

        $profile = $this->profile;

        if ($this->input->method(TRUE) === 'POST' && check_ACL($profile, 'dashboard', 'menu')) {
            $input_data = json_decode(trim(file_get_contents('php://input')), true);
            $input_data['curr_user'] = $profile;

            $this->load->model('salesman_leave_model');
            $result['scheduleInfo'] = $this->salesman_leave_model->getSchedule($input_data);
        }

        return $this->return_json($result);
    }
}
