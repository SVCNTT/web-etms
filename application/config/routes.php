<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'admin';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

/*===================================*/
/*Begin: Admin*/
/*===================================*/
$route['admin'] = 'admin/index';
$route['login'] = 'admin/dologin';
$route['Logout'] = 'admin/logout';
$route['AUT0200'] = 'admin/change_password';
$route['AUT0200/chgPass'] = 'admin/do_change_password';
/*===================================*/
/*End: Admin*/
/*===================================*/

/*===================================*/
/*Begin: Message*/
/*===================================*/
$route['SET0100'] = 'admin/index';
/*===================================*/
/*End: Message*/
/*===================================*/

/*===================================*/
/*Begin: Admin*/
/*===================================*/
$route['DAS0100'] = 'dashboard/index';
$route['DAS0100/getMessages'] = 'common/getMessages';

$route['DAS0110'] = 'call_record/statictis';
$route['DAS0110/initData'] = 'call_record/initStatictisData';
$route['DAS0110/searchData'] = 'checkin/searchData';

$route['DAS0140'] = 'checkin/index';
$route['DAS0140/initData'] = 'checkin/initData';
$route['DAS0140/searchData'] = 'checkin/searchData';

$route['DAS0150'] = 'dashboard/schedule';
$route['DAS0150/initData'] = 'dashboard/schedule_init_data';
$route['DAS0150/searchData'] = 'dashboard/schedule_select';
/*===================================*/
/*End: Admin*/
/*===================================*/

/*===================================*/
/*Begin: User*/
/*===================================*/
$route['USR0100'] = 'user/index';
$route['USR0100/initData'] = 'user/init_data';
$route['USR0100/searchData'] = 'user/search_data';
$route['USR0100/deleteUser'] = 'user/delete_user';
$route['USR0110'] = 'user/form_reset_password';
$route['USR0110/resetPassword'] = 'user/reset_password';
$route['USR0200'] = 'user/form_create';
$route['USR0200/initData'] = 'user/form_init_data';
$route['USR0200/searchUserRole'] = 'user/search_user_role';
$route['USR0200/createUser'] = 'user/create_user';
$route['USR0210/(:any)'] = 'user/edit/$1';
$route['USR0210/initData'] = 'user/form_init_data';
$route['USR0210/searchUserCode'] = 'user/search_user_code';
$route['USR0210/searchUserRole'] = 'user/search_user_role';
$route['USR0210/updateUser'] = 'user/update_user';
/*===================================*/
/*End: User*/
/*===================================*/

/*===================================*/
/*Begin: sale man*/
/*===================================*/
$route['SAL0100'] = 'saleman/index';
$route['SAL0100/searchData'] = 'saleman/searchData';
$route['SAL0100/initData'] = 'saleman/initData';
$route['SAL0100/deleteSalman'] = 'saleman/deleteSalman';

$route['SAL0110'] = 'saleman/form_import';
$route['SAL0120'] = 'saleman/start_import';


$route['SAL0300/(:any)'] = 'saleman_detail/index/$1';
$route['SAL0330/(:any)'] = 'saleman_detail/$1';
$route['SAL0330'] = 'saleman_detail/list_store';
$route['SAL0330/initData'] = 'saleman_detail/initData';

$route['SAL0330/searchStoreAssigned'] = 'saleman_detail/searchStoreAssigned';
$route['SAL0330/searchStoreNotAssign'] = 'saleman_detail/searchStoreNotAssign';
$route['SAL0330/addStore'] = 'saleman_detail/addStore';
$route['SAL0330/deleteStore'] = 'saleman_detail/delete_saleman_store';
$route['SAL0310'] = 'saleman_detail/change_pass';
$route['SAL0310/resetPin'] = 'saleman_detail/resetPin';
$route['SAL0320'] = 'saleman_detail/update';
$route['SAL0320/updateSalesman'] = 'saleman_detail/updateSalesman';
$route['common/datepicker'] = 'saleman_detail/datepicker';

$route['SAL0340'] = 'saleman_detail/form_vacation';
$route['SAL0340/searchData'] = 'saleman_detail/search_vacation';
$route['SAL0100/activatSalman'] = 'saleman_detail/activatSalman';

/*===================================*/
/*End: sale man*/
/*===================================*/

/*===================================*/
/*Begin: Store*/
/*===================================*/
$route['STO0100'] = 'store/index';
$route['STO0100/initData'] = 'store/init';
$route['STO0100/searchData'] = 'store/searchData';
$route['STO0100/deleteStore'] = 'store/deleteStore';
$route['STO0110'] = 'store/form_import';
$route['STO0120'] = 'store/start_import';
$route['STO0200'] = 'store/form_create_store';
$route['DOC0200'] = 'store/form_create_doctor';

$route['STO0200/initData'] = 'store/form_create_store_init';
$route['STO0200/regisStore'] = 'store/create_store';
$route['STO0210/(:any)'] = 'store/form_update_store/$1';
$route['DOC0210/(:any)'] = 'store/form_update_doctor/$1';
$route['STO0210/initData'] = 'store/form_create_store_init';
$route['STO0210/selectStore'] = 'store/load_store_for_edit';
$route['STO0210/updateStore'] = 'store/update_store';

$route['STO0300/(:any)'] = 'store/store_detail/$1';
$route['STO0300/selectStore'] = 'store/load_store_for_edit';
$route['STO0310/initData'] = 'store/init_store_detail';
$route['STO0310'] = 'store/store_client_list';
$route['STO0310/regisClientStore'] = 'store/regisClientStore';
$route['STO0310/deleteClientStore'] = 'store/delete_client_in_store';
$route['STO0320/initData'] = 'store/init_staffs';
$route['STO0320'] = 'store/store_staff_list';
$route['STO0320/selectSalesmanByStoreClient'] = 'store/selectSalesmanByStoreClient';
$route['STO0320/selectSalesmanNotAssingnStore'] = 'store/selectSalesmanNotAssingnStore';
$route['STO0320/regisSalesmanStore'] = 'store/regisSalesmanStore';
$route['STO0320/deleteSalesmanStore'] = 'store/deleteSalesmanStore';
$route['STO0330'] = 'store/store_photos';
$route['STO0330/selectPhotoStore'] = 'store/selectPhotoStore';

$route['STO0410/(:num)'] = 'store/export_customer/$1';

$route['STO0500'] = 'store/store_list';

$route['STO0510'] = 'survey/survey_manage';
$route['STO0511/getSurvey'] = 'survey/survey_search';
$route['STO0512/formImport'] = 'survey/survey_form_import';
$route['STO0513/import'] = 'survey/survey_start_import';
$route['STO0514/getQuestion'] = 'survey/survey_get_questions';
$route['STO0515/activeSurvey'] = 'survey/survey_active';
$route['STO0516/deleteSurvey'] = 'survey/survey_delete';

$route['STO0530'] = 'survey/store_list';
$route['STO0531/initData'] = 'survey/store_init';
$route['STO0532/searchData'] = 'survey/store_search';
$route['STO0533/deleteStore'] = 'survey/store_delete';
$route['STO0534/formImport'] = 'survey/store_form_import';
$route['STO0535/import'] = 'survey/store_start_import';
$route['STO0536/viewSalesman'] = 'survey/store_view_salesman';
$route['STO0537/getSalesman'] = 'survey/store_get_salesman';

$route['STO0520'] = 'survey/answer_report';
$route['STO0521/initData'] = 'survey/answer_init';
$route['STO0522/searchData'] = 'survey/answer_search';
$route['STO0523/detail/(:any)/(:any)/(:any)'] = 'survey/answer_detail/$1/$2/$3';
$route['STO0524/getDetail'] = 'survey/answer_get_detail';
$route['STO0525/exportData/(:any)'] = 'survey/answer_export/$1';

$route['STO0540'] = 'survey/overview';
$route['STO0541/search'] = 'survey/overview_search';

$route['STO0600'] = 'inventory/index';
$route['STO0600/initData'] = 'inventory/init';
$route['STO0600/searchData'] = 'inventory/searchData';
$route['STO0600/loadRegionalManager'] = 'inventory/loadRegionalManager';
$route['STO0610'] = 'inventory/form_import';
$route['STO0620'] = 'inventory/start_import';
$route['STO0630/exportData/(:any)'] = 'inventory/export/$1';

/*===================================*/
/*End: Store*/
/*===================================*/

/*===================================*/
/*Start: Client*/
/*===================================*/
$route['CLI0100'] = 'client/index';
$route['CLI0100/initData'] = 'client/initData';
$route['CLI0100/searchData'] = 'client/searchData';
$route['CLI0200'] = 'client/create';
$route['CLI0200/initData'] = 'client/initType';
$route['CLI0300/(:any)'] = 'client_detail/view/$1';
$route['CLI0380/initData'] = 'client_detail/initData';
$route['CLI0380'] = 'client_detail/details';
$route['CLI0310'] = 'client_detail/form_edit';
$route['CLI0310/initData'] = 'client_detail/initEdit';
$route['CLI0380/searchStoreNotAssign'] = 'saleman_detail/searchStoreNotAssign';
$route['CLI0380/searchStoreAssigned'] = 'saleman_detail/searchStoreAssigned';
$route['CLI0380/addStore'] = 'client_detail/addStore';
$route['CLI0380/deleteStore'] = 'client_detail/deleteStore';
$route['CLI0360'] = 'client_detail/client_form_product_type';
$route['CLI0360/selectProType'] = 'client_detail/selectProType';
$route['CLI0360/selectGroupType'] = 'client_detail/selectGroupType';
$route['CLI0360/regisProductTye'] = 'client_detail/regisProductTye';
$route['CLI0360/deleteProductTye'] = 'client_detail/deleteProductTye';
$route['CLI0361'] = 'client_detail/client_form_product_type_edit';
$route['CLI0362'] = 'client_detail/client_form_product_group_edit';
$route['CLI0360/updateProductTye'] = 'client_detail/updateProductTye';

$route['CLI0360/selectProGroup'] = 'client_detail/selectProGroup';
$route['CLI0360/regisProductGroup'] = 'client_detail/regisProductGroup';
$route['CLI0360/deleteProductGroup'] = 'client_detail/deleteProductGroup';
$route['CLI0360/updateProductGroup'] = 'client_detail/updateProductGroup';
$route['CLI0363'] = 'store/doctor_form_product_type';



$route['PRO1100/initData'] = 'product/initData';
$route['PRO1100'] = 'product/index';
$route['PRO1100/searchData'] = 'product/searchData';
$route['PRO1120'] = 'product/create';
$route['PRO1120/selectGroupByProductType'] = 'product/selectGroupByProductType';
$route['PRO1120/initData'] = 'product/initType';
$route['PRO1120/regisPro'] = 'product/regisPro';
$route['PRO1100/deleteProduct'] = 'product/deleteProduct';
$route['PRO1120/selectProduct'] = 'product/selectProduct';
$route['PRO1120/updatePro'] = 'product/updateProduct';
$route['PRO1130'] = 'product/form_import';

$route['CLI0350'] = 'dashboard/photo';
$route['CLI0350/initData'] = 'dashboard/photo_init_data';
$route['CLI0350/selectPhoto'] = 'dashboard/photo_select_photo';
/*===================================*/
/*End: Client*/
/*===================================*/


/*===================================*/
/*Start: Monthly reports*/
/*===================================*/
$route['RPT0200'] = 'monthly_reports/index';
$route['MRPT0200'] = 'monthly_reports/change_month';
$route['MRPT0200/initData'] = 'monthly_reports/init_data';
$route['MRPT0200/export'] = 'monthly_reports/export';
/*===================================*/
/*End: Monthly reports*/
/*===================================*/



/*===================================*/
/*Start: Coaching online*/
/*===================================*/
$route['COA0100'] = 'coaching/index';
$route['COA0100/initData'] = 'coaching/initData';
$route['COA0100/searchData'] = 'coaching/searchData';
$route['COA0100/deleteCoaching'] = 'coaching/deleteCoaching';
$route['COA0200'] = 'coaching/coachingCreate';
$route['COA0200/initData'] = 'coaching/initData';
$route['COA0200/regisCoaching'] = 'coaching/regisCoaching';
$route['COA0200/coachingSection'] = 'coaching/coachingSection';
$route['COA0220'] = 'coaching/add_question';
$route['COA0220/initData'] = 'coaching/initDataQuestion';
$route['COA0220/saveQuestion'] = 'coaching/saveQuestion';
$route['COA0200/deleteSection'] = 'coaching/deleteSection';
$route['COA0330/searchUserNotAssign'] = 'coaching/searchUserNotAssign';
$route['COA0330/assignUserCoaching'] = 'coaching/assignUserCoaching';
$route['COA0240/(:any)'] = 'coaching/coachingEdit/$1';
$route['COA0400/(:any)'] = 'coaching/coachingView/$1';
$route['COA0430/searchUserAssign'] = 'coaching/searchUserAssign';
$route['COA0440/viewAnswerData'] = 'coaching/viewAnswerData';
$route['COA0430/searchUserMark'] = 'coaching/searchUserMark';

$route['COA0430/removeUserFromCoaching'] = 'coaching/removeUserFromCoaching';

//Checklist
$route['CHE0100'] = 'checklist/index';
$route['CHE0100/initData'] = 'checklist/initData';
$route['CHE0100/searchData'] = 'checklist/searchData';
$route['CHE0100/deleteChecklist'] = 'checklist/deleteChecklist';
$route['CHE0200'] = 'checklist/checklistCreate';
$route['CHE0200/regisChecklist'] = 'checklist/regisChecklist';
$route['CHE0330/searchUserNotAssign'] = 'checklist/searchUserNotAssign';
$route['CHE0340/searchRMUserNotAssign'] = 'checklist/searchRMUserNotAssign';
$route['CHE0340/searchRMUserAssign'] = 'checklist/searchRMUserAssign';
$route['CHE0340/assignRMUserChecklist'] = 'checklist/assignRMUserChecklist';
$route['CHE0340/removeUserFromChecklist'] = 'checklist/removeRMUserFromChecklist';

$route['CHE0430/searchUserAssign'] = 'checklist/searchUserAssign';
$route['CHE0430/removeUserFromChecklist'] = 'checklist/removeUserFromChecklist';
$route['CHE0240/(:any)'] = 'checklist/checklistEdit/$1';
$route['CHE0330/assignUserChecklist'] = 'checklist/assignUserChecklist';
$route['CHE0400/(:any)'] = 'checklist/checklistView/$1';
$route['CHE0400/initData'] = 'checklist/checklistViewInitData';
$route['CHE0400/regisAttendance'] = 'checklist/regisAttendance';



/*===================================*/
/*End: Coaching online*/
/*===================================*/

/*===================================*/
/*Star: KPI*/
/*===================================*/
$route['KPI0100'] = 'kpi/index';
$route['KPI0100/initData'] = 'kpi/initData';
$route['KPI0100/searchData'] = 'kpi/searchData';
$route['KPI0100/saveKpi'] = 'kpi/saveKpi';

/*===================================*/
/*End: KPI*/
/*===================================*/


/*Begin: Call record*/
/*===================================*/
$route['REC0100'] = 'call_record/index';

$route['REC0200'] = 'call_record/report';
$route['REC0210/initData'] = 'call_record/initData';
$route['REC0220/searchData'] = 'call_record/searchData';
$route['REC0230/(:any)/(:any)'] = 'call_record/detail/$1/$2';
$route['REC0230/getDetail'] = 'call_record/get_detail';
$route['REC0240/deleteRecord'] = 'call_record/delete_record';

$route['REC0300'] = 'call_record/config';
$route['REC0310/getData'] = 'call_record/get_data_config';
$route['REC0320/getQuestion'] = 'call_record/getQuestion';
$route['REC0330/saveQuestion'] = 'call_record/saveQuestion';

/*===================================*/
/*End: Call record*/
/*===================================*/


/*===================================*/
/*Begin: API*/
/*===================================*/
$route['api/SMF0000/salesmanRegis'] = 'api_saleman/register';

$route['api/SMF0000/doLogin'] = 'api_saleman/login';

$route['api/SMF0000/getNews'] = 'api_saleman/getNews';

$route['api/SMF0000/checkin'] = 'api_saleman/checkin';

$route['api/SMF0000/attendanceRegis'] = 'api_saleman/checkout';

$route['api/SMF0000/slmnUpdAvatar'] = 'api_saleman/slmnUpdAvatar';

$route['api/SMF0000/getSyncSeq'] = 'api_saleman/getSyncSeq';

$route['api/SMF0000/syncData'] = 'api_saleman/syncData';

$route['api/SMF0000/checkSyncSeq'] = 'api_saleman/checkSyncSeq';

$route['api/SMF0000/saveCallRecord'] = 'api_call_record/saveCallRecord';

//Coaching api
$route['api/SMF0000/saveCoachingSalesman'] = 'api_coaching/saveCoachingSalesman';
$route['api/SMF0000/getListCoaching'] = 'api_coaching/getListCoaching';
$route['api/SMF0000/getFormCoachingTemplate'] = 'api_coaching/getFormCoachingTemplate';
$route['api/SMF0000/getDetailListCoaching'] = 'api_coaching/getDetailListCoaching';
$route['api/SMF0000/deleleCoachingSalesman'] = 'api_coaching/deleleCoachingSalesman';


$route['api/SMF0000/changePwd'] = 'api_saleman/changePwd';

//Checklist api - start
$route['api/SMF0000/getListChecklist'] = 'api_checklist/getListChecklist';
$route['api/SMF0000/saveChecklist'] = 'api_checklist/saveChecklist';
//Checklist api - end


/* API v2*/
$route['api/SMF0000/summaryCallRecord'] = 'api_call_record/summaryCallRecord';

$route['api/SMF0000/getSurvey'] = 'api_survey/getSurvey';
$route['api/SMF0000/getCustomer'] = 'api_survey/getCustomer';
$route['api/SMF0000/saveSurvey'] = 'api_survey/saveSurvey';
$route['api/SMF0000/detailSurvey'] = 'api_survey/detailSurvey';

$route['api/SMF0000/appVersion/(:any)'] = 'api_app/app_version/$1';
/* API v2 - END*/


//Inventory - 11/11/2017
$route['api/SMF0000/inventory/(:any)/(:any)/(:any)'] = 'api_inventory/index/$1/$2/$3';


/*===================================*/
/*End: API*/
/*===================================*/
