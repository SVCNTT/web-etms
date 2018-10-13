<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Roles
|--------------------------------------------------------------------------
*/
$config['roles'] = array(
    'admin'     =>  array(
        'menu'      =>  1,
        'message'   =>  1
    ),

    'dashboard' =>  array(
        'menu'      =>  1,
        'medicine_type_add' =>  1,
        'medicine_type_edit'=>  1,
        'medicine_type_del' =>  1,
        'medicine_type_add' =>  1,
        'medicine_import'   =>  1,
        'medicine_add'      =>  1,
        'medicine_edit'     =>  1,
        'medicine_del'      =>  1,
        'location_bu'       =>  1,
    ),

    'client' =>  array(
        'menu'      =>  1
    ),

    'store' =>  array(
        'menu'      =>  1,
        'create'    =>  1,
        'edit'      =>  1,
        'delete'    =>  1,
        'create_pharmacy'   =>  1,
        'create_doctor'     =>  1,
        'import'    =>  1,
        'add_mr'    =>  1,
        'export_pharmacy'   =>  1,
        'export_doctor'     =>  1,
        'list'  =>  1,
        'manage_survey'   =>  1,
        'im_survey' =>  1,
        'manage_customer_survey'    => 1,
        'im_customer_survey' =>  1,
        'report_answer' =>  1,
        'overview'  =>  1,

        'inventory_view' => 1,
        'inventory_import' => 1,
        'inventory_export' => 1,
    ),

    'sale' =>  array(
        'menu'      =>  1,
        'import'    =>  1,
        'delete'    =>  1,
        'active'    =>  1,
        'edit'      =>  1,
        'resetpass' =>  1,
        'add_customer'  =>  1,
        'vacation'  =>  1
    ),

    'coa' =>  array(
        'menu'      =>  1
    ),

    'che' =>  array(
        'menu'      =>  1
    ),

    'rec' =>  array(
        'menu'      =>  1,
        'report'    =>  1,
        'config'    =>  1,
        'delete'    =>  1
    ),

    'kpi' =>  array(
        'menu'      =>  1,
        'save'      =>  1
    ),

    'user'      =>  array(
        'menu'      =>  1,
        'create'    =>  1,
        'manage'   =>  1,
    ),

    'report' =>  array(
        'menu'      =>  1
    ),
);