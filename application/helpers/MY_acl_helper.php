<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('get_current_profile')) {
    function get_current_profile($platform = PLATFORM)
    {
        $CI = get_instance();
        $CI->load->library('Authentication');
        $profile = $CI->authentication->get_user_info($platform);
        return $profile !== FALSE ? $profile : NULL;
    }
}

if ( ! function_exists('check_ACL'))
{
    function check_ACL($profile, $controller = '', $action = '') {
        $CI = get_instance();

        if (!isset($profile['user_role_cd'])) {
            return FALSE;
        }

        /*Load roles - Begin*/
        $CI->load->library('Authentication');
        $roles = $CI->authentication->get_data('roles');

        if ($roles === FALSE) {
            $file_name = '';
            switch($profile['user_role_cd']) {
                case ROLE_ADMIN_CD:
                    $file_name = ADMIN_ROLES_FILE;
                    break;
                case ROLE_MOD_CD:
                    $file_name = MOD_ROLES_FILE;
                    break;
//                case ROLE_MANAGER_CD:
//                    $file_name = MANAGER_ROLES_FILE;
//                    break;
                case ROLE_BU_CD:
                    $file_name = REGIONAL_MANAGER_ROLES_FILE;
                    break;
                case ROLE_SALES_MANAGER_CD:
                    $file_name = SALES_MANAGER_ROLES_FILE;
                    break;
                case ROLE_REGION_MANAGER_CD:
                    $file_name = PUH_ROLES_FILE;
                    break;
            }

            if (!empty($file_name)) {
                $CI->config->load('roles/' . $file_name, FALSE, TRUE);
                $roles = $CI->config->item('roles');

                // Store SESSION
                $CI->authentication->set_data('roles', $roles, PLATFORM);
            }
        }
        /*Load roles - End*/

        /*Check access - Begin*/
        if (!isset($roles[$controller][$action]) || $roles[$controller][$action] === 0) {
            return FALSE;
        }

        return TRUE;
        /*Check access - End*/
    }
}