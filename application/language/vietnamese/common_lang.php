<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*Common - Begin*/
$lang['COMMON_HEADER_ACTION'] = 'Action';
$lang['COMMON_HEADER_VIEW'] = 'View';
$lang['COMMON_BUTTON_CANCEL'] = 'Cancel';
$lang['COMMON_BUTTON_OK'] = 'OK';
$lang['COMMON_BUTTON_UPDATE'] = 'Update';
$lang['COMMON_BUTTON_SEARCH'] = 'Search';
$lang['COMMON_BUTTON_DELETE'] = 'Delete';
$lang['COMMON_BUTTON_BACK'] = 'Back';
$lang['COMMON_BUTTON_CLOSE'] = 'Close';
$lang['COMMON_BUTTON_IMPORT'] = 'Import';
$lang['COMMON_BUTTON_EXPORT'] = 'Export';
$lang['COMMON_REQUIRED'] = '(*)';

$lang['C0000001'] = 'Are you sure you want to delete?';
$lang['COM0000_COPYRIGHT'] = 'Copyright StrikeForce Co., Ltd';
$lang['COM0000_VERSION'] = 'v0.1.0';
$lang['COM0000_EMPTY_RESULT'] = 'Sorry, no results were found.';
$lang['COM0000_EMPTY_RESULT_PHOTOS'] = 'There is no photo(s).';

$lang['E0000001'] = 'Username or password is incorrect';
$lang['E0000002'] = 'Unsuccessful';
$lang['E0000003'] = 'Invalid method';
$lang['E0000004'] = 'Please enter {0}.';
$lang['E0000005'] = 'Passwords do not match';
$lang['E0000006'] = 'Delete unsuccessful';
$lang['E0000007'] = 'Invalid signature';
$lang['E0000008'] = 'Someone already has that email';
$lang['E0000010'] = 'Please enter a valid phone number';
$lang['E0000011'] = 'Please enter {0} withd format dd-mm-yyyy.';
$lang['E0000016'] = 'Confirm password does not match.';
$lang['E0000017'] = 'Password must be at least '.MIN_LEN_PASS.' characters in length.';
$lang['E0000018'] = 'Current password does not match.';
$lang['E0000020'] = 'The format of the Email Address is not recognised.';
$lang['E0000025'] = 'Cannot delete this user. Because he is managing some other regional managers: ';
$lang['E0000025B'] = 'Cannot change this user’s position. Because he is managing some other managers: ';
$lang['E0000025C'] = 'Cannot change this user’s position. Because he is managing some other MR(s): ';
$lang['E0000029'] = "You can't leave question(s) empty.";

$lang['E0000030'] = "Start day must greater or equal current day.";
$lang['E0000031'] = "End day must greater than start day.";

$lang['F0000001'] = 'System error. Please contact your admin for more information.';

$lang['I0000001'] = 'Add successful';
$lang['I0000002'] = 'Update successful';
$lang['I0000003'] = 'Delete successful';
$lang['I0000004'] = 'Change password successful';
$lang['I0000005'] = 'Update successful';
$lang['I0000006'] = 'Active successful';
$lang['I0000008'] = 'Import successful';
$lang['I0000009'] = 'Save successful';

/*Common - End*/


/*Layout - Begin*/
$lang['MENU_DAS'] = 'Statistic';
$lang['MENU_CLI'] = 'Dashboard';
$lang['MENU_STO'] = 'Customers';
$lang['MENU_USR'] = 'Users';
$lang['MENU_SAL'] = 'MR(s)';
$lang['MENU_RPT'] = 'Reports';
$lang['MENU_RPT_MONTHLY_REPORT'] = 'Monthly Reports';
$lang['MENU_COA'] = 'Coaching Online';
$lang['MENU_CHE'] = 'Checklist';
$lang['MENU_REC'] = 'Call Record';
$lang['MENU_KPI'] = 'KPI';

$lang['MRPT0200_BUTTON_EXPORT'] = 'Export';
$lang['MRPT0200_MONTHLY_REPORT'] = 'Monthly Reports';
$lang['MRPT0200_MONTHLY_LABEL'] = 'Month';
$lang['MRPT0200_BU_LABEL'] = 'BU';


$lang['HEADER_LINK_CHANGE_PASSWORD'] = 'Change password';
$lang['HEADER_LINK_MESSAGE'] = 'Message';
$lang['HEADER_LINK_LOGOUT'] = 'Logout';
/*Layout - End*/

/*Admin - Begin*/
$lang['AUT0100_TITLE'] = 'Login | Bayer';
$lang['AUT0100_FORM_TITLE'] = 'Login';
$lang['AUT0100_LABEL_USERNAME'] = 'Your email';
$lang['AUT0100_LABEL_PASSWORD'] = 'Password';
$lang['AUT0100_BUTTON_LOGIN'] = 'Login';

$lang['SEARCH_ALL'] = 'All';
$lang['ROLE_ADMIN'] = 'Admin';
$lang['ROLE_SUB_ADMIN'] = 'MOD';
$lang['ROLE_MANAGER'] = 'Manager';
$lang['ROLE_LEADER'] = 'BU';
$lang['ROLE_SALES_MANAGER'] = 'Sales manager';
$lang['ROLE_SUB_LEADER'] = 'Regional manager';

$lang['AUT0200_CHANGE_PASSWORD'] = 'Change password';
$lang['AUT0200_LABEL_OLD_PASSWORD_1'] = 'Current password';
$lang['AUT0200_LABEL_NEW_PASSWORD_1'] = 'New password';
$lang['AUT0200_LABEL_CONFIRM_PASSWORD_1'] = 'Confirm password';
$lang['AUT0200_BUTTON_UPDATE'] = 'Save';
$lang['AUT0200_LABEL_OLD_PASSWORD'] = 'current password';
$lang['AUT0200_LABEL_NEW_PASSWORD'] = 'new password';
$lang['AUT0200_LABEL_CONFIRM_PASSWORD'] = 'confirm password';
/*Admin - End*/

/*Dashboard - Begin*/
$lang['DAS0100_TAB_GENERATE'] = 'Overview';
$lang['DAS0100_TAB_BILL'] = 'Invoices';
$lang['DAS0100_TAB_LOCATION'] = 'Locations';
$lang['DAS0100_TAB_VACATION'] = 'Vacations';
$lang['DAS0100_TAB_WORKING_SCHEDULE'] = 'Working Schedule';

$lang['DAS0110_LABEL_CALL_RECORD_LIST'] = 'List Call Records';
$lang['DAS0110_LABEL_BU'] = 'BU';
$lang['DAS0110_LABEL_DATE'] = 'Date';
$lang['DAS0110_BUTTON_SEARCH'] = 'Search';

$lang['DAS0140_LABEL_CLIENT_SALE_LIST'] = 'List MR(s)';
$lang['DAS0140_LABEL_BU'] = 'BU';
$lang['DAS0140_LABEL_BU_CHOOSE_ALL'] = 'Choose All';

$lang['DAS0140_LABEL_SALECODE'] = 'MR\'s code';
$lang['DAS0140_LABEL_STORE_CHOOSE'] = 'Choose store';
$lang['DAS0140_LABEL_SALENAME'] = 'MR\'s name';
$lang['DAS0140_LABEL_IMAGE'] = 'Image';
$lang['DAS0140_LABEL_CHECKIN'] = 'Check-in';
$lang['DAS0140_LABEL_CHECKOUT'] = 'Check-out';
$lang['DAS0140_BUTTON_SEARCH'] = 'Search';
$lang['DAS0140_LABEL_ALL_SALE'] = 'Display all';
$lang['DAS0140_SAL_LEAVE'] = 'Leave';
$lang['DAS0140_LABEL_STORENAME'] = 'Customer';
$lang['DAS0140_LABEL_SALE'] = 'Mr(s)';

$lang['DAS0150_LABEL_WORKING_SCHEDULE'] = 'Working Schedule';
$lang['DAS0150_LABEL_BU'] = 'BU';
$lang['DAS0150_LABEL_DATE'] = 'Date';
$lang['DAS0150_BUTTON_SEARCH'] = 'Search';
$lang['DAS0150_LABEL_TYPE'] = 'Type';
$lang['DAS0150_LABEL_MR'] = 'MR(s)';
$lang['DAS0150_LABEL_REGISTER_IN_DATE'] = '';
$lang['DAS0150_LABEL_NOTE'] = 'Notes';

$lang['DAS0150_DATE_TAKINGOFF'] = 'Taking off';
$lang['DAS0150_DATE_WORKING'] = 'Working';
$lang['DAS0150_DATE_HOLIDAY'] = 'Holiday';
$lang['DAS0150_DATE_TRAINING'] = 'Training';
$lang['DAS0150_DATE_PROMOTION'] = 'Promotion';
$lang['DAS0150_DATE_MEETING'] = 'Meeting';
/*Dashboard - End*/


/*Store - Begin*/
$lang['STO0100_TITLE'] = 'Customer';
$lang['STO0100_TAB_LIST'] = 'Customer list';
$lang['STO0100_TAB_MANAGE_SURVEY_QUESTION'] = 'Manage survey question';
$lang['STO0100_TAB_REPORT_SURVEY_ANSWER'] = 'Report survey result';
$lang['STO0100_TAB_STORE_SURVEY'] = 'Customer survey';
$lang['STO0100_TAB_OVERVIEW'] = 'Survey Overview';
$lang['STO0100_TAB_Inventory'] = 'Inventory';
$lang['STO0100_BUTTON_CREAT'] = 'Create pharmacy';
$lang['STO0100_LABEL_FORM'] = 'Customers';
$lang['STO0100_LABEL_CODE'] = 'Code';
$lang['STO0100_LABEL_NAME'] = 'Name';
$lang['STO0100_LABEL_CLIENT'] = 'Dashboard';
$lang['STO0100_LABEL_CHOOSE_CLIENT'] = 'Choose client';
$lang['STO0100_LABEL_ADDRESS'] = 'Address';
$lang['STO0100_LABEL_REGION'] = 'Areas';
$lang['STO0100_LABEL_DOCTORS'] = 'Doctor';

$lang['STO0100_BUTTON_SEARCH'] = 'Search';
$lang['STO0100_LABEL_REGION_CHOOSE'] = 'Select';

$lang['STO0200_TITLE'] = 'Create pharmacy';
$lang['STO0200_BUTTON_BACK'] = 'Back';
$lang['STO0200_LABEL_FORM'] = 'Create pharmacy';
$lang['STO0200_LABEL_FORM_DOCTOR'] = 'Create doctor';
$lang['STO0100_BUTTON_CREAT_DOCTOR'] = 'Create doctor';
$lang['STO0100_BUTTON_EXPORT'] = 'Export';
$lang['STO0100_BUTTON_EXPORT_PhARMACY'] = 'Export pharmacy';
$lang['STO0100_BUTTON_EXPORT_DOCTOR'] = 'Export doctor';

$lang['STO0200_LABEL_DOCTOR_TITLE'] = 'Title';
$lang['STO0200_LABEL_DOCTOR_POSITION'] = 'Position';
$lang['STO0200_LABEL_DOCTOR_SPECIALTY'] = 'Specialty';
$lang['STO0200_LABEL_DOCTOR_DEPARTMENT'] = 'Department';
$lang['STO0200_LABEL_DOCTOR_HOSPITAL'] = 'Hospital';
$lang['STO0200_LABEL_DOCTOR_ZONE'] = 'Zone';
$lang['STO0200_LABEL_DOCTOR_MR'] = 'MR';
$lang['STO0200_LABEL_DOCTOR_BU'] = 'BU';
$lang['STO0200_LABEL_DOCTOR_CLASS'] = 'Class';
$lang['STO0200_TITLE_DOCTOR'] = 'Create doctor';

$lang['STO0200_LABEL_STORE_NAME'] = 'Name';
$lang['STO0200_LABEL_REGION'] = 'Area';
$lang['STO0200_LABEL_ADDRESS'] = 'Address';
$lang['STO0200_BUTTON_FIND_LOCATION'] = 'Find location';
$lang['STO0200_LABEL_POSITION'] = 'Location';
$lang['STO0200_BUTTON_FIND_MAP'] = 'Find Map';
$lang['STO0200_BUTTON_CREAT'] = 'Create';
$lang['STO0200_BUTTON_CREAT_CONTINUE'] = 'Create and continue';

$lang['STO0210_TITLE'] = 'Update pharmacy';
$lang['STO0210_TITLE_DOCTOR'] = 'Update doctor';

$lang['STO0210_BUTTON_BACK'] = 'Back';
$lang['STO0210_LABEL_FORM'] = 'Update pharmacy';
$lang['STO0210_LABEL_FORM_DOCTOR'] = 'Update doctor';
$lang['STO0210_LABEL_STORE_CODE'] = 'Code';
$lang['STO0210_LABEL_STORE_NAME'] = 'Name';
$lang['STO0210_LABEL_REGION'] = 'Area';
$lang['STO0210_LABEL_ADDRESS'] = 'Address';
$lang['STO0210_LABEL_POSITION'] = 'Location';
$lang['STO0210_BUTTON_FIND_MAP'] = 'Find map';
$lang['STO0210_BUTTON_CREAT_CONTINUE'] = 'Update';

$lang['STO0300_TITLE'] = 'Pharmacy detail';
$lang['STO0300_LABEL_FORM'] = 'Pharmacy information';
$lang['STO0300_LABEL_FORM_DOCTOR'] = 'Doctor information';
$lang['STO0300_LABEL_CLIENT_TAB'] = 'Dashboard';
$lang['STO0300_LABEL_STAFF_TAB'] = 'MR(s)';
$lang['STO0300_LABEL_IMAGE_TAB'] = 'Photos';
$lang['STO0300_LABEL_CLIENT_LIST'] = 'Dashboard';
$lang['STO0300_LABEL_CHOOSE_CLIENT'] = 'Select';
$lang['STO0300_BUTTON_ADD'] = 'Add';
$lang['STO0300_LABEL_SALE_LIST'] = 'MR list';
$lang['STO0300_LABEL_STAFF_CODE'] = 'Code';
$lang['STO0300_LABEL_NAME'] = 'Name';
$lang['STO0300_LABEL_ADD_SALE'] = 'Add MR';
$lang['STO0300_BUTTON_SEARCH'] = 'Search';
$lang['STO0110_LABEL_TITLE'] = 'Import customers';
$lang['STO0110_LABEL_CHOOSE_FILE'] = 'Choose file';
$lang['STO0110_BUTTON_UPLOAD_PRICE'] = 'Import';

$lang['STO0510_LABEL_SURVEY_LIST'] = 'Survey List';
$lang['STO0510_LABEL_SURVEY_NAME'] = 'Name';
$lang['STO0510_BUTTON_SEARCH'] = 'Search';
$lang['STO0510_BUTTON_IMPORT_SURVEY'] = 'Import survey';
$lang['STO0510_LABEL_CREATED_DATE'] = 'Created date';
$lang['STO0510_LABEL_PRODUCT_GROUP_NAME'] = 'Name';
$lang['STO0510_LABEL_PRODUCT_GROUP_PRODUCT'] = 'Product';
$lang['STO0510_LABEL_PRODUCT_GROUP_STATUS'] = 'Status';
$lang['STO0510_LABEL_ACTION'] = 'Action';
$lang['STO0510_LABEL_QUESTIONS_LIST'] = 'Questions List';
$lang['STO0510_HINT_VIEW_QUESTIONS'] = 'Choose survey name to view questions list';
$lang['STO0510_LOADING'] = 'Loading...';
$lang['STO0510_LABEL_SURVEY_NAME'] = 'Survey name';
$lang['STO0510_STATUS_ACTIVE'] = 'Active';
$lang['STO0510_STATUS_INACTIVE'] = 'Inactive';
$lang['STO0510_BUTTON_VIEW'] = 'View';

$lang['STO0521_TAB_REPORT_ANSWER'] = 'Report survey result';
$lang['STO0521_LABEL_SURVEY'] = 'Survey name';
$lang['STO0521_LABEL_CHOOSE_SURVEY'] = 'Choose survey';
$lang['STO0521_LABEL_STORE_CODE'] = 'Customer code';
$lang['STO0521_LABEL_SALESMAN_CODE'] = 'MR code';
$lang['STO0521_BUTTON_SEARCH'] = 'Search';
$lang['STO0521_LABEL_ID'] = 'ID';
$lang['STO0521_LABEL_STORE_NAME'] = 'Customer name';
$lang['STO0521_LABEL_SALESMAN_NAME'] = 'MR name';
$lang['STO0521_LABEL_CREATED_DATE'] = 'Created date';

$lang['STO0523_LABEL_FORM'] = 'Survey Result Detail';
$lang['STO0523_LABEL_QUESTION'] = 'Question';
$lang['STO0523_LABEL_ANSWER'] = 'Answer';
$lang['STO0523_LABEL_SURVEY'] = 'Survey ';

$lang['STO0530_LABEL_TITLE'] = 'Customers survey';
$lang['STO0530_BUTTON_IMPORT_CUSTOMER'] = 'Import customers';
$lang['STO0530_LABEL_STORE_CODE'] = 'Customer code';
$lang['STO0530_LABEL_STORE_NAME'] = 'Customer name';
$lang['STO0530_LABEL_PRODUCT'] = 'Product';
$lang['STO0530_LABEL_SUB_GROUP'] = 'Sub group';
$lang['STO0530_TITLE_VIEW_SALESMAN'] = 'View salesman';
$lang['STO0536_LABEL_TITLE'] = 'Salesmans List';

$lang['STO0540_LABEL_TITLE'] = 'MR List';
$lang['STO0540_LABEL_SALESMAN_CODE'] = 'MR code';
$lang['STO0540_LABEL_SALESMAN_NAME'] = 'MR name';
$lang['STO0540_LABEL_SURVEY_OVERVIEW'] = 'Survey overview';


$lang['STO0600_TITLE'] = 'Inventory';
$lang['STO0600_LABEL_FORM'] = 'List';
$lang['STO0600_LABEL_PRODUCT_CODE'] = 'Product code';
$lang['STO0600_LABEL_PRODUCT_NAME'] = 'Product name';
$lang['STO0600_LABEL_PRODUCT_PRICE'] = 'Sale price';
$lang['STO0600_LABEL_SALE_IN'] = 'Sale in';
$lang['STO0600_LABEL_SALE_OUT'] = 'Sale out';
/*Store - End*/

/*Call record - Begin*/
$lang['REC0100_TITLE'] = 'Call Record';
$lang['REC0100_TAB_REPORT'] = 'Report';
$lang['REC0100_TAB_CONFIGURE'] = 'Config';

$lang['REC0200_LABEL_MR'] = 'MR(s)';
$lang['REC0200_LABEL_STORE'] = 'Customer';
$lang['REC0200_LABEL_PRODUCT_GROUP'] = 'Product group';
$lang['REC0200_LABEL_VALIDATE'] = 'Validate';
$lang['REC0200_LABEL_CHOOSE_MR'] = 'Choose MR(s)';
$lang['REC0200_LABEL_CHOOSE_STORE'] = 'Choose Customer';
$lang['REC0200_LABEL_CHOOSE_PRODUCT_GROUP'] = 'Choose product group';
$lang['REC0200_LABEL_CHOOSE_VALIDATE'] = 'Choose validate';
$lang['REC0200_BUTTON_SEARCH'] = 'Search';
$lang['REC0200_LABEL_CREATE_DATE'] = 'Created date';
$lang['REC0200_TIP_DELETE_RECORD'] = 'Delete record';

$lang['REC0230_TITLE'] = 'Call Record Detail';
$lang['REC0230_BUTTON_BACK'] = 'Back';
$lang['REC0230_LABEL_FORM'] = 'Call record Detail';
$lang['REC0230_LABEL_MR'] = 'MR';
$lang['REC0230_LABEL_STORE'] = 'Customer';
$lang['REC0230_LABEL_VALIDATE'] = 'Validate';
$lang['REC0230_LABEL_CREATED_DATE'] = 'Created date';
$lang['REC0230_LABEL_MR_FEEDBACK'] = 'MR feedback';
$lang['REC0230_LABEL_CUSTOMER_FEEDBACK'] = 'Customer feedback';
$lang['REC0230_LABEL_COMPETITOR'] = 'Competitor';
$lang['REC0230_LABEL_COMPETITOR_ACTIVITY'] = 'Competitor activity';
$lang['REC0230_LABEL_COMMENT'] = 'Comment';
$lang['REC0230_LABEL_QUESTION'] = 'Question';
$lang['REC0230_LABEL_ANSWER'] = 'Answer';
$lang['REC0230_ANSWER_NO'] = 'NO';
$lang['REC0230_ANSWER_YES'] = 'YES';
$lang['REC0230_LABEL_EMPTY'] = '(empty)';

$lang['REC0300_LABEL_PRODUCT_GROUP_LIST'] = 'Product group';
$lang['REC0300_LABEL_QUESTIONS'] = 'Questions';
$lang['REC0300_LABEL_PRODUCT_GROUP_NAME'] = 'Name';
$lang['REC0300_BUTTON_SEARCH'] = 'Search';
$lang['REC0300_BUTTON_ADD_QUESTION'] = 'Add';
$lang['REC0300_LABEL_REMOVE_QUESTIONS'] = 'Remove question';
$lang['REC0300_BUTTON_SAVE_QUESTION'] = 'Save';
$lang['REC0300_CONFIRM_REMOVE_QUESTION'] = 'Are you sure you want to remove question?';
$lang['REC0300_LABEL_PREFIX_QUESTION_LIST'] = 'List question for';
$lang['REC0300_HINT_QUESTION'] = 'Choose product group to edit question';
$lang['REC0300_LOADING'] = 'Loading...';
/*Call record - End*/


/*User - Begin*/
$lang['USR0100_TITLE'] = 'User';
$lang['USR0100_BUTTON_CREAT'] = 'Create';
$lang['USR0100_LABEL_FORM'] = 'User List';
$lang['USR0100_LABEL_CLIENT'] = 'Client';
$lang['USR0100_LABEL_CHOOSE_CLIENT'] = 'Choose client';
$lang['USR0100_LABEL_USER_CODE'] = 'User code';
$lang['USR0100_LABEL_USER_NAME'] = 'Name';
$lang['USR0100_LABEL_POSITION'] = 'Position';
$lang['USR0100_LABEL_CHOOSE_POSITION'] = 'Choose position';
$lang['USR0100_BUTTON_SEARCH'] = 'Search';
$lang['USR0100_LABEL_CODE'] = 'Code';
$lang['USR0100_LABEL_NAME'] = 'Full name';
$lang['USR0100_LABEL_EMAIL'] = 'Email';
$lang['USR0100_LABEL_PHONE'] = 'Phone';
$lang['USR0100_LABEL_MANAGER_INFORMATION'] = 'Managed info';
$lang['USR0100_TIP_CHANGE_PASSWORD'] = 'Change password';
$lang['USR0100_TIP_EDIT_USER'] = 'Edit profile user';
$lang['USR0100_TIP_DELETE_USER'] = 'Delete user';
$lang['USR0100_LABEL_PASSWORD'] = 'password';
$lang['USR0100_LABEL_CONFIRM_PASSWORD'] = 'confirm password';
$lang['USR0100_PRODUCT_LIST'] = '----- Product Type List -----';
$lang['USR0100_SALESMAN_LIST'] = '---- MR(s) List ----';
$lang['USR0100_REGIONAL_MANAGER_LIST'] = '---- Regional Manager List ----';

$lang['USR0200_TITLE'] = 'Add user';
$lang['USR0200_LABEL_REQUIRED'] = '(*)';
$lang['USR0200_BUTTON_BACK'] = 'Back';
$lang['USR0200_LABEL_FORM'] = 'Add user';
$lang['USR0200_LABEL_FIRSTNAME'] = 'First name';
$lang['USR0200_LABEL_LASTNAME'] = 'Last name';
$lang['USR0200_LABEL_POSITION'] = 'Position';
$lang['USR0200_LABEL_CHOOSE_POSITION'] = 'Choose position';
$lang['USR0200_LABEL_CLIENT'] = 'Client';
$lang['USR0200_LABEL_CHOOSE_CLIENT'] = 'Choose client';
$lang['USR0200_LABEL_EMAIL'] = 'Email';
$lang['USR0200_LABEL_PHONE'] = 'Phone';
$lang['USR0200_LABEL_PASSWORD'] = 'Password';
$lang['USR0200_LABEL_REPASSWORD'] = 'Confirm password';
$lang['USR0200_LABEL_REGION'] = 'Areas';
$lang['USR0200_LABEL_REGION_MANAGER'] = 'BU';
$lang['USR0200_LABEL_CHOOSE_REGION_MANAGER'] = 'Choose BU';
$lang['USR0200_LABEL_SALE_MANAGER'] = 'Sales manager';
$lang['USR0200_LABEL_MANAGER'] = 'Regional manager';
$lang['USR0200_BUTTON_CREAT'] = 'Add';
$lang['USR0200_BUTTON_CREAT_CONTINUE'] = 'Add and continue';
$lang['USR0200_LABEL_PRODUCT'] = 'Product type';
$lang['USR0200_LABEL_SALESMAN'] = 'MR(s)';
$lang['USR0200_LABEL_CHOOSE_SALESMAN'] = 'Choose MR(s)';
$lang['USR0200_LABEL_SALES_MANAGER'] = 'Sales manager';
$lang['USR0200_LABEL_CHOOSE_SALES_MANAGER'] = 'Choose sales manager';
$lang['USR0200_LABEL_BU'] = 'BU';

$lang['USR0210_TITLE'] = 'Update User Info';
$lang['USR0210_BUTTON_BACK'] = 'Back';
$lang['USR0210_LABEL_FORM'] = 'Update user info';
$lang['USR0210_LABEL_REQUIRED'] = '(*)';
$lang['USR0210_LABEL_FIRSTNAME'] = 'First name';
$lang['USR0210_LABEL_LASTNAME'] = 'Last name';
$lang['USR0210_LABEL_USERCODE'] = 'User code';
$lang['USR0210_LABEL_POSITION'] = 'Position';
$lang['USR0210_LABEL_CHOOSE_POSITION'] = 'Choose position';
$lang['USR0210_LABEL_CLIENT'] = 'Client';
$lang['USR0210_LABEL_CHOOSE_CLIENT'] = 'Choose client';
$lang['USR0210_LABEL_EMAIL'] = 'Email';
$lang['USR0210_LABEL_PHONE'] = 'Phone';
$lang['USR0210_LABEL_REGION_MANAGER'] = 'Manage region';
$lang['USR0210_LABEL_CHOOSE_REGION_MANAGER'] = 'Choose region';
$lang['USR0210_LABEL_MANAGER'] = 'Sales Manager';
$lang['USR0210_BUTTON_UPDATE_CONTINUE'] = 'Update';

/*User - End*/

/*Coaching online - Begin*/
$lang['COA0100_LABEL_FORM'] = 'Coaching online';
$lang['COA0100_LABEL_NAME'] = 'Name';
$lang['COA0100_LABEL_CODE'] = 'Code';
$lang['COA0100_BUTTON_SEARCH'] = 'Search';
$lang['COA0100_BUTTON_CREAT'] = 'Create';
$lang['COA0100_LABEL_STARTDAY'] = 'Start day';
$lang['COA0100_LABEL_ENDDAY'] = 'End day';
$lang['COA0200_LABEL_FORM'] = 'Create coaching online';
$lang['COA0200_LABEL_FORM_EDIT'] = 'Edit coaching online';
$lang['COA0200_LABEL_FORM_VIEW'] = 'View coaching online';


$lang['COA0200_LABEL_COACHING_NAME'] = 'Name';
$lang['COA0200_LABEL_COACHING_STARTDAY'] = 'Start day';
$lang['COA0200_LABEL_COACHING_ENDDAY'] = 'End day';
$lang['COA0100_BUTTON_BACK'] = 'Previous';
$lang['COA0400_BUTTON_BACK'] = 'Back to user mark';
$lang['COA0400_BUTTON_BACK_MANAGER'] = 'Back to manager list';

$lang['COA0100_BUTTON_NEXT'] = 'Next';
$lang['COA0100_BUTTON_ADD_QUESTION'] = 'Add questions';
$lang['COA0100_BUTTON_VIEW_QUESTION'] = 'View questions';

$lang['COA0100_BUTTON_ADD_ASSIGN_USER'] = 'Assign users';
$lang['COA0100_BUTTON_VIEW_ASSIGN_USER'] = 'View Assign users';


$lang['COA0100_BUTTON_FINISH'] = 'Finish';
$lang['COA0200_LABEL_QUESTION_ADD'] = 'Add questions';
$lang['COA0200_LABEL_QUESTION_LIST'] = 'Questions';
$lang['COA0200_LABEL_QUESTION_ANSWER'] = 'Questions answer';


$lang['COA0200_BUTTON_BACK'] = 'Back';

$lang['COA0200_BUTTON_ADD_ITEM'] = 'Add question';
$lang['COA0200_LABEL_QUESTION_TITLE'] = 'Question title';
$lang['COA0200_LABEL_QUESTION_NOTE'] = 'Question';
$lang['COA0200_LABEL_QUESTION_NEED_CALCULATE'] = 'Need calculate average';
$lang['COA0200_LABEL_QUESTION_TYPE'] = 'Question type';
$lang['COA0220_BUTTON_DONE'] = 'Done';
$lang['COA0200_LABEL_QUESTION_STATUS'] = 'Select';
$lang['COA0220_LABEL_FORM'] = 'Add question';
$lang['COA0230_LABEL_ASSIGN_ADD'] = 'Assign regional manager';
$lang['COA0230_LABEL_ASSIGN_USER_LIST'] = 'MR(s)';
$lang['COA0230_LABEL_ASSIGN_USER_STORES'] = 'Customers';
$lang['COA0230_LABEL_ASSIGN_USER_NAME'] = 'MR(s)';
$lang['COA0230_LABEL_ASSIGN_USER_DAY_SENT'] = 'Send day';

$lang['CHE0400_LABEL_INVITED_LIST'] = 'List Invited Customer';
$lang['CHE0400_LABEL_INVITED_LIST_NAME'] = 'Full name';
$lang['CHE0400_LABEL_INVITED_LIST_TITLE'] = 'Title';
$lang['CHE0400_LABEL_INVITED_LIST_POSITION'] = 'Position';
$lang['CHE0400_LABEL_INVITED_LIST_SPECIALTY'] = 'Speciality';
$lang['CHE0400_LABEL_INVITED_LIST_DEPARTMENT'] = 'Department';
$lang['CHE0400_LABEL_INVITED_LIST_HOSPITAL'] = 'Hospital';
$lang['CHE0400_LABEL_INVITED_LIST_INVITED_BY'] = 'Invited By';
$lang['CHE0400_LABEL_INVITED_LIST_ATTENDANCE'] = 'Attendance';


$lang['COA0230_LABEL_ASSIGN_LIST'] = 'Regional managers';
$lang['COA0230_LABEL_ASSIGN_VIEW_ANSWER'] = 'Action';

$lang['COA0230_LABEL_ASSIGN_NAME'] = 'Regional manager';
$lang['COA0230_LABEL_ASSIGN_CODE'] = 'Code';
$lang['COA0200_LABEL_FORM_ASSIGN'] = 'Name coaching online';
$lang['COA0230_LABEL_LIST_NAME'] = 'Regional Managers';


/*Coaching online - End*/


/*Checklist online - Begin*/
$lang['CHE0100_LABEL_FORM'] = 'Checklist';
$lang['CHE0100_LABEL_NAME'] = 'Name';
$lang['CHE0100_LABEL_CODE'] = 'Code';
$lang['CHE0100_BUTTON_SEARCH'] = 'Search';
$lang['CHE0100_BUTTON_CREAT'] = 'Create';
$lang['CHE0100_LABEL_STARTDAY'] = 'Start day';
$lang['CHE0100_LABEL_ENDDAY'] = 'End day';

$lang['CHE0200_LABEL_FORM'] = 'Create checklist';
$lang['CHE0200_LABEL_FORM_EDIT'] = 'Edit Checklist';
$lang['CHE0200_LABEL_FORM_VIEW'] = 'View Checklist';
$lang['CHE0230_LABEL_LIST_NAME'] = 'MR(s)';
$lang['CHE0230_LABEL_LIST_RM_NAME'] = 'Regional Managers';
$lang['CHE0200_LABEL_CHECKLIST_NAME'] = 'Name';
$lang['CHE0200_LABEL_CHECKLIST_STARTDAY'] = 'Start day';
$lang['CHE0200_LABEL_CHECKLIST_ENDDAY'] = 'End day';
$lang['CHE0200_BUTTON_BACK'] = 'Back';
$lang['CHE0100_BUTTON_ADD_ASSIGN'] = 'Assign';
$lang['CHE0100_BUTTON_BACK'] = 'Previous';
$lang['CHE0100_BUTTON_FINISH'] = 'Finish';

$lang['CHE0230_LABEL_ASSIGN_LIST'] = 'Assigned list';
$lang['CHE0230_LABEL_ASSIGN_MR_LIST'] = 'Assigned MRs List';
$lang['CHE0230_LABEL_ASSIGN_RM_LIST'] = 'Assigned Regional Manager List';
$lang['CHE0230_LABEL_ASSIGN_NAME'] = 'Name';
$lang['CHE0230_LABEL_ASSIGN_CODE'] = 'Code';
$lang['CHE0230_LABEL_LIST_NAME'] = 'MR(s)';
$lang['CHE0230_LABEL_MR_NAME'] = 'MR(s)';
$lang['CHE0230_LABEL_RM_NAME'] = 'Regional Manager(s)';
$lang['CHE0230_LABEL_ASSIGN_ADD'] = 'MR(s) + RM(s)';
/*Checklist online - End*/

/*KPI - Start*/
$lang['KPI0100_LABEL_TEAM_LIST'] = 'Teams';
$lang['KPI0100_LABEL_TEAM_ID'] = 'ID';
$lang['KPI0100_LABEL_TEAM_NAME'] = 'Name';
$lang['KPI0100_LABEL_TIME_ADD'] = 'Times';
$lang['KPI0100_LABEL_ADD_NAME'] = 'Name';
$lang['KPI0100_LABEL_ADD_CODE'] = 'Code';
$lang['KPI0100_LABEL_TRAINING_DAYS'] = 'Training days';
$lang['KPI0100_LABEL_CALL_RATE'] = 'Call rate';
$lang['KPI0100_LABEL_PROMOTION_DAYS'] = 'Promotion days';
$lang['KPI0100_LABEL_MEETING_DAYS'] = 'Meeting days';
$lang['KPI0100_LABEL_HOLIDAYS'] = 'Holidays';
$lang['KPI0100_LABEL_LEAVE_TAKEN'] = 'Leave taken';
$lang['KPI0100_LABEL_FREQUENCY'] = 'Frequency';
$lang['KPI0100_BUTTON_SAVE'] = 'Save';
/*KPI - End*/

/*Saleman - Begin*/
$lang['SAL0100_LABEL_FORM'] = 'MR list';
$lang['SAL0100_LABEL_CLIENT'] = 'Dashboard';
$lang['SAL0100_LABEL_CODE'] = 'MR code';
$lang['SAL0100_LABEL_NAME'] = 'MR name';
$lang['SAL0100_LABEL_STATUS'] = 'Status';
$lang['SAL0100_LABEL_CHOOSE_STATUS'] = 'Select';
$lang['SAL0100_BUTTON_SEARCH'] = 'Search';
$lang['SAL0100_LABEL_AVARTAR'] = 'Photo';
$lang['SAL0100_LABEL_EMAIL'] = 'Email';
$lang['SAL0100_LABEL_PHONE'] = 'Mobile';
$lang['SAL0100_LABEL_BIRTHDAY'] = 'Birthday';
$lang['SAL0100_LABEL_STARTDAY'] = 'Start day';
$lang['SAL0100_LABEL_CHOOSE_CLIENT'] = 'Select';
$lang['SAL0100_BUTTON_CHOOSE_FILE'] = 'Import';
$lang['SAL0100_TIP_DELETE'] = 'Delete MR';
$lang['SAL0110_LABEL_TITLE'] = 'Import Mr(s)';
$lang['SAL0110_LABEL_CHOOSE_FILE'] = 'Choose file';
$lang['SAL0110_BUTTON_UPLOAD_PRICE'] = 'Import';

$lang['SAL0300_TITLE'] = 'Information officer';
$lang['SAL0300_LABEL_FORM'] = 'Details';
$lang['SAL0300_LABEL_INFO_TAB'] = 'Information';
$lang['SAL0300_LABEL_VACATION_TAB'] = 'Working Schedule';

$lang['SAL0310_BUTTON_CHANGE'] = 'Change';
$lang['SAL0310_LABEL_FORM'] = 'New Password';
$lang['SAL0310_PASSWORD'] = 'Password';
$lang['SAL0310_CONFIRM_PASSWORD'] = 'Confirm password';

$lang['SAL0320_LABEL_FORM'] = 'Update MR';
$lang['SAL0320_LABEL_SALE_CODE'] = 'Code';
$lang['SAL0320_LABEL_SALE_NAME'] = 'Name';
$lang['SAL0320_LABEL_SALE_EMAIL'] = 'Email';
$lang['SAL0320_LABEL_SALE_PHONE'] = 'Phone';
$lang['SAL0320_LABEL_IMEI'] = 'IMEI';
$lang['SAL0320_LABEL_SALE_LOCATION'] = 'Location';
$lang['SAL0320_LABEL_SALE_GENDER'] = 'Gender';
$lang['SAL0320_LABEL_SALE_JOBTITLE'] = 'Job title';
$lang['SAL0320_BUTTON_CHANGE'] = 'Update';

$lang['SAL0330_LABEL_STORE_LIST'] = 'Customer list';
$lang['SAL0330_LABEL_REGION'] = 'Areas';
$lang['SAL0330_LABEL_STORE_CODE'] = 'Customer code';
$lang['SAL0330_LABEL_STORE'] = 'Customer';
$lang['SAL0330_BUTTON_SEARCH'] = 'Search';
$lang['SAL0330_LABEL_STORE_NAME'] = 'Customer name';
$lang['SAL0330_LABEL_STORE_ADD'] = 'Customer add';
$lang['SAL0330_BUTTON_ADD'] = 'Add';
$lang['SAL0330_LABEL_REGION_CHOOSE'] = 'Select';

$lang['SAL0340_LABEL_VACATION'] = 'Detail';
$lang['SAL0340_LABEL_TIME'] = 'Times';
$lang['SAL0340_BUTTON_SEARCH'] = 'Search';
$lang['SAL0340_LABEL_VACATION_DATE'] = 'Date';
$lang['SAL0340_LABEL_REASON'] = 'Reason';
$lang['SAL0340_LABEL_TYPE'] = 'Type';
$lang['STO0200_LABEL_CHOOSE_REGION'] = 'Select';
$lang['STO0200_LABEL_STORE_NAME'] = 'Name';
$lang['STO0200_LABEL_REGION'] = 'Area';
/*Saleman - End*/

/*Client - Begin*/
$lang['CLI0100_TITLE'] = 'Dashboard';
$lang['CLI0100_BUTTON_CREAT'] = 'Create';
$lang['CLI0100_LABEL_FORM'] = 'Dashboard';
$lang['CLI0100_LABEL_CLIENT_NAME'] = 'Name';
$lang['CLI0100_BUTTON_SEARCH'] = 'Search';
$lang['CLI0100_LABEL_AVATAR'] = 'Avatars';
$lang['CLI0100_LABEL_NAME'] = 'Names';
$lang['CLI0100_LABEL_NAME_TYPE'] = 'Types';
$lang['CLI0100_LABEL_RATE_POINT'] = 'Rate points';
$lang['CLI0100_LABEL_MANAGER_REGION'] = 'Manager Areas';
$lang['CLI0100_LABEL_MANAGER_SALE'] = 'Managers';
$lang['CLI0100_LABEL_SUB_LEADER'] = 'Manager MR(s)';
$lang['CLI0100_LABEL_SALE'] = 'MR(s)';
$lang['CLI0200_TITLE'] = 'Create custommer';
$lang['CLI0200_BUTTON_BACK'] = 'Back';
$lang['CLI0200_LABEL_FORM'] = 'Create custommer';
$lang['CLI0200_LABEL_CLIENT_NAME'] = 'Name';
$lang['CLI0200_LABEL_CLIENT_NAME_ERROR'] = 'Please enter name';
$lang['CLI0200_LABEL_CLIENT_NAME_EXISTED'] = 'The name is existed';
$lang['CLI0200_CUSTOMMER_CREATE_SUCCESSFUL'] = 'Add custommer successful';
$lang['CLI0200_CUSTOMMER_UPDATE_SUCCESSFUL'] = 'Update custommer successful';

$lang['CLI0200_LABEL_REQUIRED'] = '(*)';
$lang['CLI0200_LABEL_AVATAR'] = 'Avatar';
$lang['CLI0200_BUTTON_UPFILE'] = 'Choose file';
$lang['CLI0200_LABEL_RATE_POINT'] = 'Rate point';
$lang['CLI0200_LABEL_RATE_UNIT'] = 'VND';
$lang['CLI0200_CLIENT_TYPE'] = 'Type';
$lang['CLI0200_LABEL_CHOOSE_CLIENT_TYPE'] = 'Select';
$lang['CLI0200_BUTTON_CREAT'] = 'Create';
$lang['CLI0200_BUTTON_CREAT_CONTINUE'] = 'Create continue';
$lang['CLI0380_LABEL_STORE_LIST'] = 'Customers';
$lang['CLI0300_BUTTON_CHOOSE_FILE'] = 'Import';
$lang['CLI0380_LABEL_REGION_CHOOSE'] = 'Select';
$lang['CLI0380_LABEL_REGION'] = 'Areas';
$lang['CLI0380_LABEL_STORE_CODE'] = 'Code';
$lang['CLI0380_BUTTON_SEARCH'] = 'Search';
$lang['CLI0380_LABEL_STORE'] = 'Customers';
$lang['CLI0380_LABEL_STORE_ADD'] = 'Add';
$lang['CLI0380_LABEL_STORE_NAME'] = 'Name';
$lang['CLI0380_BUTTON_SEARCH'] = 'Search';
$lang['CLI0300_TITLE'] = 'Dashboard';
$lang['CLI0300_LABEL_FORM'] = 'Dashboard details';
$lang['CLI0300_LABEL_FORM_2'] = 'Details';
$lang['CLI0300_LABEL_RATE_POINT'] = 'Rate point';
$lang['CLI0300_LABEL_UNIT'] = 'Unit';
$lang['CLI0300_LABEL_STORE_TAB'] = 'Customers';
$lang['CLI0300_LABEL_PRODUCT_TYPE'] = 'Medicine Type';
$lang['CLI0300_LABEL_PRODUCT_TAB'] = 'Medicines';
$lang['CLI300_LABEL_COMPETITOR'] = 'Competitors';
$lang['CLI0300_LABEL_STAFF_TAB'] = 'MR(s)';
$lang['CLI0300_LABEL_SALE_MAN'] = 'MR(s)';
$lang['CLI0300_LABEL_BILL_INFOR_TAB'] = 'Bills';
$lang['CLI0300_LABEL_BILL_INFOR_TAB_CIGAR'] = 'Bill cigars';
$lang['CLI0300_LABEL_IMAGE_TAB'] = 'Photos';
$lang['CLI0300_LABEL_COMMON_REPORT'] = 'Common reports';
$lang['CLI0300_LABEL_COMMON_REPORT_CIGAR'] = 'Common report cigars';
$lang['CLI0300_LABEL_PRICE_REPORT'] = 'Price reports';
$lang['CLI0300_LABEL_PRODUCT_AVAI'] = 'Inventories';
$lang['CLI0300_BUTTON_CREAT'] = 'Create';
$lang['CLI0310_LABEL_FORM'] = 'Update custommer';
$lang['CLI0310_LABEL_CLIENT_NAME'] = 'Name';
$lang['CLI0310_LABEL_REQUIRED'] = '(*)';
$lang['CLI0310_LABEL_AVATAR'] = 'Avatar';
$lang['CLI0310_BUTTON_UPFILE'] = 'Choose file';
$lang['CLI0310_LABEL_RATE_POINT'] = 'Rate point';
$lang['CLI0310_LABEL_RATE_UNIT'] = 'Unit';
$lang['CLI0310_BUTTON_UPDATE'] = 'Update';
$lang['CLI0380_BUTTON_ADD'] = 'Add';
$lang['CLI0300_BUTTON_CHOOSE_FILE'] = 'Import';




#CLI0360- PRODUCT TYPE
$lang['CLI0360_LABEL_PRODUCT_TYPE'] = 'Medicine types';
$lang['CLI0360_LABEL_PRODUCT_TYPE_NAME'] = 'Name';
$lang['CLI0360_BUTTON_ADD'] = 'Add';


$lang['CLI0360_LABEL_PRODUCT_GROUP'] = 'Product Group';
$lang['CLI0360_LABEL_PRODUCT_GROUP_NAME'] = 'Name';
$lang['CLI0360_BUTTON_ADD'] = 'Add';
$lang['CLI0362_LABEL_TITLE_UPDATE'] = 'Update Product Group';

#CLI0361- update product type
$lang['CLI0361_LABEL_TITLE_UPDATE'] = 'Update medicine types';
$lang['CLI0361_BUTTON_EDIT'] = 'Update';
$lang['CLI0370_LABEL_NAME'] = 'Name';


#PRO1100- list product
$lang['PRO1100_LABEL_TITLE'] = 'Products';
$lang['PRO1100_LABEL_PRODUCT_TYPE'] = 'Types';
$lang['PRO1100_LABEL_PRODUCT_CODE'] = 'Codes';
$lang['PRO1100_LABEL_PRODUCT_NAME'] = 'Names';
$lang['PRO1100_LABEL_PRODUCT_GROUP_NAME'] = 'Groups';
$lang['PRO1100_LABEL_PRODUCT_GROUP'] = 'Group';
$lang['PRO1100_LABEL_PRODUCT_NAME_FILTER'] = 'Name';

$lang['PRO1100_LABEL_PRODUCT_PRICE'] = 'Prices';
$lang['PRO1100__BUTTON_SEARCH'] = 'Search';

#PRO1120- add product
$lang['PRO1120_LABEL_TITLE'] = 'Add';
$lang['PRO1120_LABEL_TITLE_UPDATE'] = 'Update medicine';
$lang['PRO1120_LABEL_TITLE_EDIT'] = 'Edit';
$lang['PRO1120_LABEL_PRODUCT_CODE'] = 'Code';
$lang['PRO1120_LABEL_PRODUCT_NAME'] = 'Name';
$lang['PRO1120_LABEL_PRODUCT_PRICE'] = 'Price';
$lang['PRO1120_BUTTON_CREAT'] = 'Create';
$lang['PRO1120_BUTTON_EDIT'] = 'Save';
$lang['PRO1120_LABEL_PRODUCT_TYPE'] = 'Type';
$lang['PRO1120_LABEL_CHOOSE_PRODUCT_TYPE'] = 'Choose';

$lang['PRO1120_LABEL_PRODUCT_GROUP'] = 'Group';
$lang['PRO1120_LABEL_CHOOSE_PRODUCT_GROUP'] = 'Choose';

#PRO1130- import rival product
$lang['PRO1130_LABEL_TITLE'] = 'Import products';
$lang['PRO1130_LABEL_CHOOSE_FILE'] = 'File';
$lang['PRO1130_BUTTON_CHOOSE_FILE'] = 'Choose';
$lang['PRO1130_BUTTON_UPLOAD_PRICE'] = 'Import';
$lang['PRO1130__BUTTON_SEARCH'] = 'Search';

#CLI0330- staff tab
$lang['CLI0330_LABEL_STAFF_LIST'] = 'MR(s)';
$lang['CLI0330_LABEL_STAFF_MANAGER'] = 'MR manager';
$lang['CLI0330_LABEL_STAFF_MANAGER_CHOOSE'] = 'Choose';
$lang['CLI0330_LABEL_SALE_CODE'] = 'MR code';
$lang['CLI0330_LABEL_CODE'] = 'Code';
$lang['CLI0330_LABEL_NAME'] = 'Name';
$lang['CLI0330_LABEL_PHONE'] = 'Phone';
$lang['CLI0330_LABEL_SALE_MANAGER'] = 'MR managers';
$lang['CLI0330_LABEL_ADD_STAFF'] = 'Add';
$lang['CLI0330_LABEL_STAFF_SALE'] = 'MR';
$lang['CLI0330_LABEL_STAFF_SALE_CHOOSE'] = 'MR choose';
$lang['CLI0330_LABEL_CONTACT'] = 'Contact';
$lang['CLI0330_BUTTON_SEARCH'] = 'Search';
$lang['CLI0330_BUTTON_ADD'] = 'Add';

#CLI0350- image
$lang['CLI0350_LABEL_IMAGE_LIST'] = 'Photos';
$lang['CLI0350_LABEL_STORE'] = 'Customer';
$lang['CLI0350_LABEL_STORE_CHOOSE'] = 'Choose';
$lang['CLI0350_LABEL_DATE'] = 'Date';
$lang['CLI0350_BUTTON_SEARCH'] = 'Search';

/*Client - End*/

/*  CD MST Start */
$lang['CLIENT_TYPE__01'] = "Electric";
$lang['CLIENT_TYPE__02']="Other";
$lang['user_sts__0']="Ch\u01b0a k\u00edch ho\u1ea1t";
$lang['user_sts__1']="\u0110\u00e3 k\u00edch ho\u1ea1t";
$lang['user_sts__2'] ="B\u1ecb kh\u00f3a";
$lang['user_sts__3']="V\u00f4 hi\u1ec7u";
$lang['cus_meta_info__field_type__1']="Ch\u1ecdn 1";
$lang['cus_meta_info__field_type__2']="Ch\u1ecdn nhi\u1ec1u";
$lang['cus_meta_info__field_type__3']="Nh\u1eadp t\u1ef1 do (1 d\u00f2ng)";
$lang['salesman__sts__0']="Ch\u01b0a k\u00edch ho\u1ea1t";
$lang['salesman__sts__1']="\u0110\u00e3 k\u00edch ho\u1ea1t";
/*  CD MST End */
