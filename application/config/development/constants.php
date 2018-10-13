<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| My Constants
|--------------------------------------------------------------------------
|
*/
define('PLATFORM', 'strikeforce@2015');


/*Define database name*/
define('DATABASE_NAME', 'strikeforce_development');
/*Define database name - END*/

/*Define template version*/
//define('PROJECT_VERSION', '/v2');
define('PROJECT_VERSION', '');
/*Define template version - END*/


/*Define static*/
define('STATIC_SERVER', '/assets'.PROJECT_VERSION);
define('STATIC_VERSION', '20171111');
/*Define static - END*/


/*Define logo*/
define('CLIENT_LOGO_DEFAULT', 'logo_bayer.png');
/*Define logo - END*/


/*Define storage*/
define('STATIC_REAL_SERVER', 'file_manager');
/*Define storage - END*/


/*Define number row per page*/
define('ROW_ON_PAGE', '10');
/*Define number row per page - END*/


/*Define result status*/
define('RES_OK', 'OK');
define('RES_NG', 'NG');
/*Define result status - END*/


/*Define delete flag*/
define('DEL_FLAG_0', '0');
define('DEL_FLAG_1', '1');
/*Define delete flag - END*/


/*Define version default*/
define('DEFAULT_VERSION_NO', 1);
/*Define version default - END*/


/*Define role*/
define('ROLE_ADMIN_CD', 1);
define('ROLE_MOD_CD', 2);
define('ROLE_MANAGER_CD', 3);
define('ROLE_BU_CD', 4);
define('ROLE_SALES_MANAGER_CD', 6);
define('ROLE_REGION_MANAGER_CD', 5);

define('ADMIN_ROLES_FILE', 'admin_roles');
define('MOD_ROLES_FILE', 'sub_admin_roles');
define('MANAGER_ROLES_FILE', 'manager_roles');
define('REGIONAL_MANAGER_ROLES_FILE', 'leader_roles');
define('SALES_MANAGER_ROLES_FILE', 'sales_manager_roles');
define('PUH_ROLES_FILE', 'sub_leader_roles');
/*Define role - END*/


/*Define min password length*/
define('MIN_LEN_PASS', 6);
/*Define min password length - END*/


/*Define prefix code*/
define('USER_CODE_PREFIX', 'USR');
define('CLIENT_CODE_PREFIX', 'CLI');
define('STORE_CODE_PREFIX', 'STO');
define('SALESMAN_CODE_PREFIX', 'SM');
/*Define prefix code - END*/


/*Define secret key*/
define('SECRECT_KEY_SURVEY', 'SURVEY_'.PLATFORM);
define('SECRECT_KEY_STORE_SURVEY', 'STORE_SURVEY_'.PLATFORM);
define('SECRECT_KEY_SURVEY_ANSWER', 'SURVEY_ANSWER_'.PLATFORM);
define('SECRECT_KEY_CALL_RECORD', 'CALL_RECORD_'.PLATFORM);
/*Define secret key - END*/


/*Define for API*/
define('API_SECRET_KEY', 'strikeforce@2015!@#');
define('API_DELAY_TIME', 5 * 60);   //5 minutes

define('API_STATUS_SUCCESS', 1);
define('API_STATUS_FAIL', -1);

define('API_MESSAGE_SUCCESS', 'Success');
define('API_MESSAGE_UNSUCCESS', 'Unsuccess');
define('API_MESSAGE_INVALID', 'Invalid input');
define('API_MESSAGE_ERROR_SIG', 'Check signature fail');
define('API_MESSAGE_EXPIRED', 'Session expired');
define('API_MESSAGE_INVALID_METHOD', 'Invalid method');
/*Define for API - END*/


/*Define for Survey*/
define('SURVEY_STATUS_ENABLE', 1);
define('SURVEY_STATUS_DISABLE', 0);

define('SURVEY_CUSTOMER_DONE', 1);
define('SURVEY_CUSTOMER_NOT_YET', 2);
define('SURVEY_CUSTOMER_ALL', 0);
/*Define for Survey - END*/


/*Define user status*/
define('USER_STS_NOT_ACTIVE', '0');
define('USER_STS_ACTIVE', '1');
define('USER_STS_DISABLE', '2');
/*Define user status - END*/


define('FLAG_ON', '1');
define('FLAG_OFF', '0');


define('FLAG_0', '0');
define('FLAG_1', '1');
define('FLAG_2', '2');
define('FLAG_3', '3');
define('FLAG_4', '4');
define('FLAG_5', '5');
define('FLAG_SCHEDULE_TYPE_WORKING', '2');
define('SALESMAN_MSG_OLD_DAYS', 30);


define('SELECT_AREA_ALL', 0);
define('SELECT_AREA_LEVEL_1', 1);


define('TYPE_MR', 1);
define('TYPE_USER', 2);


define('CHECKIN_TYPE_ORIGINAL',1);
define('CHECKIN_TYPE_ORDER',2);


define('STORE_ID_CHECKIN_TYPE_ORDER',-1);


define('PARAM_HASH_MD5','');


define('KEY_DATE_TAKINGOFF', 1);
define('KEY_DATE_WORKING', 2);
define('KEY_DATE_HOLIDAY', 3);
define('KEY_DATE_TRAINING', 4);
define('KEY_DATE_PROMOTION', 5);
define('KEY_DATE_MEETING', 6);
