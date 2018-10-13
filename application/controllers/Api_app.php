<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_app extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function app_version($os)
    {
        $result = array(
            'status' => API_STATUS_FAIL,
            'message' => API_MESSAGE_INVALID,
            'version' => ''
        );

        $app_version = $this->config->item('app_version');

        $os = strtolower($os);
        $version = isset($app_version[$os]) ? $app_version[$os] : '';

        if ( ! empty($version)) {

            $result['version'] = $version;
            $result['status'] = API_STATUS_SUCCESS;
            $result['message'] = API_MESSAGE_SUCCESS;
        }

        return $this->return_json($result);
    }
}
