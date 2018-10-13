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
        'message'   =>  0
    ),

    'dashboard' =>  array(
        'menu'      =>  1,
        'medicine_type_add' =>  0,
        'medicine_type_edit'=>  0,
        'medicine_type_del' =>  0,
        'medicine_type_add' =>  0,
        'medicine_import'   =>  0,
        'medicine_add'      =>  0,
        'medicine_edit'     =>  0,
        'medicine_del'      =>  0,
        'location_bu'       =>  0,
    ),

    'client' =>  array(
        'menu'      =>  1
    ),

    'store' =>  array(
        'menu'      =>  1,
        'create'    =>  0,
        'edit'      =>  0,
        'delete'    =>  0,
        'create_pharmacy'   =>  0,
        'create_doctor'     =>  0,
        'import'    =>  0,
        'add_mr'    =>  0,
        'export_pharmacy'   =>  0,
        'export_doctor'     =>  0,
        'list'  =>  1,
        'manage_survey'   =>  1,
        'im_survey' =>  1,
        'manage_customer_survey'    => 1,
        'im_customer_survey' =>  1,
        'report_answer' =>  1,
        'overview'  =>  1,

        'inventory_view' => 0,
        'inventory_import' => 0,
        'inventory_export' => 0,
    ),

    'sale' =>  array(
        'menu'      =>  1,
        'import'    =>  0,
        'delete'    =>  0,
        'active'    =>  0,
        'edit'      =>  0,
        'resetpass' =>  0,
        'add_customer'  =>  0,
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
        'config'    =>  0,
        'delete'    =>  0
    ),

    'kpi' =>  array(
        'menu'      =>  1,
        'save'      =>  0
    ),

    'user'      =>  array(
        'menu'      =>  0,
        'create'    =>  0,
        'manage'    =>  0,
    ),

    'report' =>  array(
        'menu'      =>  1
    ),
);