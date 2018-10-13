<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_saleman extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

    }

    public function register()
    {
        $result = array(
            'returnCd' => NULL,
            'returnMsg' => NULL,
            'proResFlg' => NULL,
            'salesmanId' => RES_NG,
            'returnMsg' => 'Empty'
        );

        if ($this->input->method(TRUE) === 'POST') {
            $this->load->model('saleman_model');
            $this->load->model('user_salesman_model');
            $this->load->model('client_model');

            /*Get params - Begin*/
            $post = $this->input->post(NULL, TRUE);
            $post = isset($post['paramJson']) ? json_decode($post['paramJson'], true) : array();

            $data['email'] = isset($post['email']) ? $post['email'] : '';
            if (!empty($data['email'])) {
                $func_id = isset($post['funcId']) ? $post['funcId'] : '';
                $data['mobile'] = isset($post['mobile']) ? $post['mobile'] : '';
                $data['pin_code'] = isset($post['pinCode']) ? $post['pinCode'] : '';
                $data['salesman_name'] = isset($post['salesmanName']) ? $post['salesmanName'] : '';
                //$data['birthday'] = isset($post['birthday']) ? $post['birthday'] : '';
                //$data['card_id'] = isset($post['cardId']) ? $post['cardId'] : '';
                $data['location'] = isset($post['location']) ? $post['location'] : '';
                $data['gender'] = isset($post['gender']) ? $post['gender'] : '';
                $data['job_title'] = isset($post['jobTitle']) ? $post['jobTitle'] : '';

                $data['imei'] = isset($post['imei']) ? $post['imei'] : '';
                $data['salesman_sts'] = FLAG_0;
                /*Get params - End*/

                $list_saleman = $this->saleman_model->selectByExample(array('email' => $data['email']));

                if ($list_saleman === NULL || !empty($list_saleman)) {
                    //Fail or Exist
                    $result['proResFlg'] = RES_NG;
                    $result['returnMsg'] = E0000008;
                } else {
                    //Ready
                    /*
                    if (!empty($data['birthday'])) {
                        list($d, $m, $y) = explode('-', $data['birthday'], 3);
                        $data['birthday'] = date('Y-m-d', mktime(0, 0, 0, $m, $d, $y));
                    } else {
                        $data['birthday'] = date('Y-m-d H:i:s');
                    }*/

                    $data['cre_func_id'] = $func_id;
                    $data['cre_ts'] = date('Y-m-d H:i:s');
                    $data['cre_user_id'] = 0;
                    $data['mod_func_id'] = $func_id;
                    $data['mod_ts'] = date('Y-m-d H:i:s');
                    $data['mod_user_id'] = 0;
                    $data['del_flg'] = DEL_FLAG_0;
                    $data['version_no'] = DEFAULT_VERSION_NO;
                    $data['pin_code'] = $this->create_md5($data['pin_code']);
                    //Insert DB
                    $id = $this->saleman_model->insert($data);
                    if ($id) {
                        $data_update['salesman_code'] = $this->getCode(SALESMAN_CODE_PREFIX, 6, $id);
                        $this->saleman_model->update($id, $data_update);

                        $temp['clientName'] = 'Bayer';
                        //get clientId
                        $client = $this->client_model->searchAllClientName($temp);

                        //var_dump()
                        $data2['client_id'] = $client[1]['clientId'];
                        $data2['salesman_id'] = $id;
                        $data2['cre_func_id'] = $func_id;
                        $data2['cre_ts'] = date('Y-m-d H:i:s');
                        $data2['cre_user_id'] = 0;
                        $data2['mod_func_id'] = $func_id;
                        $data2['mod_ts'] = date('Y-m-d H:i:s');
                        $data2['mod_user_id'] = 0;
                        $data2['del_flg'] = DEL_FLAG_0;
                        $data2['version_no'] = DEFAULT_VERSION_NO;
                        //Insert user_sale
//						$this->user_salesman_model->insert($data2);

                        $result['proResFlg'] = RES_OK;
                        $result['salesmanId'] = $id;
                    }
                }
            }
        }
        return $this->return_json($result);
    }

    public function login()
    {
        $result = array(
            'returnCd' => NULL,
            'returnMsg' => NULL,
            'token' => NULL,
            'proResFlg' => NULL,
            'salesman' => NULL,
            'client' => NULL,
            'storeList' => NULL,
            'serverTime' => (new DateTime())->getTimestamp() * 1000,
        );


        if ($this->input->method(TRUE) === 'POST') {

            /*get list saleman*/
            $this->load->model('saleman_model');
            $this->load->model('client_model');
            $this->load->model('user_mst_model');
            /*get list store*/
            $this->load->model('Store_model');
            $this->load->model('product_group_question_model');
            $this->load->model('Product_group_model');
            $this->load->model('coaching_template_model');

            /*Get params - Begin*/
            $post = $this->input->post(NULL, TRUE);
            $post = isset($post['paramJson']) ? json_decode($post['paramJson'], true) : array();

            $email = isset($post['mobile']) ? $post['mobile'] : '';

            $imei = isset($post['imei']) ? $post['imei'] : '';

            $pinCode = isset($post['pinCode']) ? $post['pinCode'] : '';

            $pinCode_md5 = $this->create_md5($pinCode);


            $timeLogin = new DateTime();
            $timeStartLogin = new DateTime($timeLogin->format('Y-m-d') . " 06:00:00");
            $timeEndLogin = new DateTime($timeLogin->format('Y-m-d') . " 23:00:00");

            $saleman = $this->saleman_model->selectByLoginSalesman(array('email' => $email, 'pinCode' => $pinCode_md5));

            if ($saleman !== NULL && !empty($saleman)) {

                if ($saleman[0]['active_date'] === NULL || $saleman[0]['active_date'] === '') {
                    $result['returnMsg'] = "Please contact Admin to active this account";
                    $result['proResFlg'] = RES_NG;
                    $result['serverTime'] = (new DateTime())->getTimestamp() * 1000;
                    return $this->return_json($result);
                }

                if ($saleman[0]['imei'] === NULL || $saleman[0]['imei'] === '') {
                    $data['imei'] = $imei;
                    $this->saleman_model->update($saleman[0]['salesman_id'], $data);
                } else {
                    if ($saleman[0]['imei'] !== $imei) {
                        $result['returnMsg'] = "Error! not match imei";
                        $result['proResFlg'] = RES_NG;
                        $result['serverTime'] = (new DateTime())->getTimestamp() * 1000;
                        return $this->return_json($result);
                    }
                }
                $result['returnMsg'] = null;
                $result['proResFlg'] = RES_OK;
                $result['token'] = "dms";
                $result['salesman'] = array('mobile' => $saleman[0]['mobile']
                , 'email' => $saleman[0]['email']
                , 'salesmanName' => $saleman[0]['salesman_name']
                , 'salesmanCd' => $saleman[0]['salesman_code']
                , 'salesmanId' => $saleman[0]['salesman_id']
                , 'clientId' => $saleman[0]['client_id']
                , 'subLeaderUserId' => $saleman[0]['sub_leader_user_id']
                , 'gcmRegisId' => $saleman[0]['gcm_regis_id']
                );
                $result['client'] = array('clientId' => $saleman[0]['client_id']
                , 'clientCode' => $saleman[0]['client_code']
                , 'clientName' => $saleman[0]['client_name']
                , 'ratePoint' => $saleman[0]['rate_point']
                );
                $list_store = $this->Store_model->selectStoreBySaleman(array('salesman_id' => $saleman[0]['salesman_id']));
                $list_product_group = $this->Product_group_model->selectByUserId($saleman[0]['sub_leader_user_id']);

                if ($list_product_group) {
                    foreach ($list_product_group as $key => $item) {
                        $product_group = $this->product_group_question_model->getQuestionByProductGroup($item['product_group_id']);

                        $list_product_group[$key]['listQuestions'] = json_decode($product_group['question'], true);
                    }
                }

                $result['listProductGroup'] = $list_product_group;
                if ($list_store !== NULL && !empty($list_store)) {
                    $result['storeList'] = $list_store;
                } else {
                    $result['storeList'] = null;
                }
            } else {
                //kiem tra user
                $user = $this->user_mst_model->selectByLoginUser(array('email' => $email, 'pass' => $pinCode_md5));

                if ($user !== NULL && !empty($user)) {
                    $result['user'] = $user[0];
                    $result['returnMsg'] = null;
                    $result['proResFlg'] = RES_OK;
                    $result['token'] = "dms";
                    if ($user[0]['clientId'] !== "-1") {
                        $client = $this->client_model->selectByClientId_api(array('clientId' => $user[0]['clientId']));
                        $result['client'] = $client[0];
                    } else {
                        $result['client'] = NULL;
                    }

                    // Get list salesmans
                    $lisSalesman = $this->saleman_model->selectListSalesmanByUserId(array('userId' => $user[0]['userId']));
                    $result['listSalesman'] = $lisSalesman;

                    // Get list coaching templates
                    $listCoachingTemplate = $this->coaching_template_model->selectListCoachingTemplateByUserId(array('userId' => $user[0]['userId']));
                    $result['listCoachingTemplate'] = $listCoachingTemplate;

                    // Get list stores
                    $list_store = $this->Store_model->selectStoreByRm(array('userId' => $user[0]['userId']));
                    $result['storeList'] = $list_store;

                } else {
                    $result['returnMsg'] = "Invalid email or password";
                    $result['proResFlg'] = RES_NG;
                }

            }

            $result['serverTime'] = (new DateTime())->getTimestamp() * 1000;
        }
        return $this->return_json($result);
    }

    public function getNews()
    {
        $result = array(
            'returnCd' => NULL,
            'returnMsg' => NULL,
            'newsList' => [],
            'proResFlg' => NULL,
        );

        if ($this->input->method(TRUE) === 'POST') {

            $this->load->model('salesmanmsg_model');
            /*Get params - Begin*/
            $post = $this->input->post(NULL, TRUE);
            $post = isset($post['paramJson']) ? json_decode($post['paramJson'], true) : array();

            $msgTs = isset($post['msgTs']) ? $post['msgTs'] : NULL;
            $salesmanId = isset($post['salesmanId']) ? $post['salesmanId'] : NULL;
            $oldDate = new DateTime();
            $oldDate->sub(new DateInterval('P30D'));
            if (!empty($msgTs)) {
                $oldDate = new DateTime();
                $oldDate->setTimestamp($msgTs);
            }
            $newList = $this->salesmanmsg_model->selectSalesmanMsg(array('salesman_id' => $salesmanId, 'oldDate' => $oldDate->getTimestamp()));
            if ($newList === NULL || !empty($newList)) {
                $result['newsList'] = $newList;
            }
            $result['proResFlg'] = RES_OK;

        }
        return $this->return_json($result);
    }

    public function checkin()
    {
        $this->load->library('FileManagement');

        $result = array(
            'returnCd' => NULL,
            'returnMsg' => NULL,
            'serverTime' => (new DateTime())->getTimestamp() * 1000,
            'proResFlg' => RES_NG
        );
        if ($this->input->method(TRUE) === 'POST') {
            $this->load->model('checkin_model');
            /*Get params - Begin*/
            $post = $this->input->post(NULL, TRUE);

            //$param = json_decode(trim(file_get_contents('php://input')), true);

            $post = isset($post['paramJson']) ? json_decode($post['paramJson'], true) : array();
            $data['checkin_time'] = date('Y-m-d H:i:s');
            $data['salesman_id'] = isset($post['salesmanId']) ? $post['salesmanId'] : '';
            $data['client_id'] = isset($post['clientId']) ? $post['clientId'] : '';
            $data['type'] = isset($post['type']) ? $post['type'] : '';
            $data['long_val'] = isset($post['longVal']) ? $post['longVal'] : '0.0';
            $data['lat_val'] = isset($post['latVal']) ? $post['latVal'] : '0.0';

            if ((int)$data['type'] === CHECKIN_TYPE_ORDER) {
                $data['store_id'] = STORE_ID_CHECKIN_TYPE_ORDER;
                $data['store_name'] = isset($post['storeName']) ? $post['storeName'] : '';

            } else {
                $data['type'] = CHECKIN_TYPE_ORIGINAL;
                $data['store_name'] = '';
                $data['store_id'] = isset($post['storeId']) ? $post['storeId'] : '';
            }

            $base64Image = isset($post['base64Image']) ? $post['base64Image'] : '';
            if($base64Image !== ''){
                $path = $this->filemanagement->saveImage($base64Image, "checkin", "png");
            } else {
                $path = '';
            }

            $data['image_path'] = $path;


            $data['sub_leader_user_id'] = isset($post['subLeaderUserId']) ? $post['subLeaderUserId'] : NULL;
            $data['cre_func_id'] = isset($post['funcId']) ? $post['funcId'] : '';

            $data['cre_ts'] = date('Y-m-d H:i:s');
            $data['cre_user_id'] = 0;
            $data['mod_func_id'] = isset($post['funcId']) ? $post['funcId'] : '';
            $data['mod_ts'] = date('Y-m-d H:i:s');
            $data['mod_user_id'] = 0;
            $data['del_flg'] = DEL_FLAG_0;
            $data['version_no'] = DEFAULT_VERSION_NO;

            $id = $this->checkin_model->checkinRegis($data);

            $result['checkinId'] = $id;
            $result['proResFlg'] = RES_OK;
            $result['serverTime'] = (new DateTime())->getTimestamp() * 1000;
        }

        return $this->return_json($result);
    }

    public function checkout()
    {
        $result = array(
            'returnCd' => NULL,
            'returnMsg' => NULL,
            'proResFlg' => RES_NG
        );
        if ($this->input->method(TRUE) === 'POST') {
            $this->load->model('checkin_model');
            /*Get params - Begin*/
            $post = $this->input->post(NULL, TRUE);

            $post = isset($post['paramJson']) ? json_decode($post['paramJson'], true) : array();
            $data['checkout_time'] = date('Y-m-d H:i:s');
            if (isset($post['longVal'])) {
                $data['long_val'] = $post['longVal'];
            }
            if (isset($post['latVal'])) {
                $data['lat_val'] = $post['latVal'];
            }

            if (isset($post['checkinId'])) {
                $checkinId = $post['checkin_id'];
                if ($this->checkin_model->checkoutRegis($data, $checkinId)) {
                    $result['proResFlg'] = RES_OK;
                }
            } else {
                $params['salesman_id'] = isset($post['salesmanId']) ? $post['salesmanId'] : '';
                $params['type'] = isset($post['type']) ? $post['type'] : '';

                if ((int)$params['type'] === CHECKIN_TYPE_ORDER) {
                    $params['store_name'] = isset($post['storeName']) ? $post['storeName'] : '';

            } else {
                    $params['type'] = CHECKIN_TYPE_ORIGINAL;
                    $params['store_name'] = '';
                    $params['store_id'] = isset($post['storeId']) ? $post['storeId'] : '';
            }

                $checkinData = $this->checkin_model->searchCheckin($params);
                if ($checkinData !== NULL) {
                    $checkinId = $checkinData["checkinId"];
                    if ($this->checkin_model->checkoutRegis($data, $checkinId)) {
            $result['proResFlg'] = RES_OK;
        }
                }
            }
        }

        return $this->return_json($result);
    }

    public function slmnUpdAvatar()
    {

        $result = array(
            'returnCd' => NULL,
            'returnMsg' => NULL,
            'proResFlg' => RES_NG
        );
        if ($this->input->method(TRUE) === 'POST') {

            $this->load->library('FileManagement');
            $this->load->model('saleman_model');

            $post = $this->input->post(NULL, TRUE);
            $post = isset($post['paramJson']) ? json_decode($post['paramJson'], true) : array();

            $data['salesman_id'] = isset($post['salesmanId']) ? $post['salesmanId'] : '';
            $data['mod_func_id'] = isset($post['funcId']) ? $post['funcId'] : '';
            $base64Image = isset($post['base64Image']) ? $post['base64Image'] : '';
            if($base64Image !== ''){
            $path = $this->filemanagement->saveImage($base64Image, "saleman_avatar", "png");
            } else {
                $path='';
            }

            $data['image_path'] = $path;

            $saleman = $this->saleman_model->selectSalemaById($data);
            if ($saleman !== NULL && !empty($saleman)) {
                $this->saleman_model->update($data['salesman_id'], $data);
                $result['proResFlg'] = RES_OK;
            }
        }
        return $this->return_json($result);
    }

    public function checkSyncSeq()
    {
        $result = array();
        if ($this->input->method(TRUE) === 'POST') {
            $this->load->model('salesman_sync_model');
            $post = $this->input->post(NULL, TRUE);
            $post = isset($post['paramJson']) ? json_decode($post['paramJson'], true) : array();

            $salesmanId = isset($post['salesmanId']) ? $post['salesmanId'] : '';
            $syncSeq = isset($post['syncSeq']) ? $post['syncSeq'] : '';
            $syncType = isset($post['syncType']) ? $post['syncType'] : '';

            $salesman_sync = $this->salesman_sync_model->selectByPrimaryKey($salesmanId, $syncSeq);
            if ($salesman_sync !== NULL) {
                return $this->output->set_content_type('application/json')->set_output($salesman_sync['sync_info']);
            } else {
                $result['proResFlg'] = RES_OK;
                $result['salesmanId'] = $salesmanId;
                $result['syncStsFlg'] = FLAG_0;
                $result['syncType'] = $syncType;
                return $this->return_json($result);
            }

        }
        return $this->return_json($result);
    }

    public function getSyncSeq()
    {

        $result = array(
            'returnCd' => NULL,
            'returnMsg' => NULL,
            'proResFlg' => RES_NG
        );
        if ($this->input->method(TRUE) === 'POST') {
            $post = $this->input->post(NULL, TRUE);
            $post = isset($post['paramJson']) ? json_decode($post['paramJson'], true) : array();
            $t = explode(" ", microtime());
            $result['syncSeq'] = date("YmdHis", $t[1]) . substr((string)$t[0], 2, 3);
            $result['syncTs'] = (new DateTime())->getTimestamp() * 1000;
            $result['proResFlg'] = RES_OK;
        }
        return $this->return_json($result);
    }

    public function syncData()
    {
        $result = array(
            'returnCd' => NULL,
            'returnMsg' => NULL,
            'syncSeq' => NULL,
            'salesmanId' => NULL,
            'syncStsFlg' => NULL,
            'syncType' => NULL,
            'proResFlg' => RES_NG,
            'salesmanLeaveList' => array(),
            'photoList' => NULL,
            'billList' => NULL,
            'marketPriceList' => NULL,
            'storeInventoryList' => NULL
        );
        if ($this->input->method(TRUE) === 'POST') {
            $post = $this->input->post(NULL, TRUE);
            $post = isset($post['paramJson']) ? json_decode($post['paramJson'], true) : array();
            $funcId = isset($post['funcId']) ? $post['funcId'] : '';
            $data['salesman_id'] = isset($post['salesmanId']) ? $post['salesmanId'] : '';
            $result['salesmanId'] = $data['salesman_id'];
            $data['sync_seq'] = isset($post['syncSeq']) ? $post['syncSeq'] : '';
            $data['sync_time'] = date('Y-m-d H:i:s');
            $result['syncSeq'] = $data['sync_seq'];
            $syncType = isset($post['syncType']) ? $post['syncType'] : '';
            $result['syncType'] = $syncType;
            if ($syncType === FLAG_1) {
                //syncDataBill => coaching_template
            } else if ($syncType === FLAG_2) {
                //syncDataStoreInventory => call record
            } else if ($syncType === FLAG_3) {
                //syncDataMarketPrice => coaching_template
            } else if ($syncType === FLAG_4) {

                $this->load->model('salesman_leave_model');
                $this->load->model('salesman_sync_model');
                $salesmanLeaveList = isset($post['salesmanLeaveList']) ? $post['salesmanLeaveList'] : '';
                $count = count($salesmanLeaveList);
                if ($count > 0) {
                    for ($i = 0; $i < $count; $i++) {
                        $data2 = array();
                        $data2['salesman_id'] = $data['salesman_id'];
                        $data2['leave_seq'] = isset($salesmanLeaveList[$i]['leave_seq']) ? $salesmanLeaveList[$i]['leave_seq'] : NULL;
                        $data2['leave_date'] = isset($salesmanLeaveList[$i]['leaveDate']) ? $salesmanLeaveList[$i]['leaveDate'] / 1000 : NULL;
                        $data2['leave_date'] = date("Y-m-d H:i:s", $data2['leave_date']);
                        $data2['register_in_date'] = isset($salesmanLeaveList[$i]['registerInDate']) ? $salesmanLeaveList[$i]['registerInDate'] : 1;
                        $data2['send_date'] = isset($salesmanLeaveList[$i]['sendDate']) ? $salesmanLeaveList[$i]['sendDate'] / 1000 : NULL;
                        $data2['send_date'] = date("Y-m-d H:i:s", $data2['send_date']);
                        $data2['type'] = isset($salesmanLeaveList[$i]['type']) ? $salesmanLeaveList[$i]['type'] : 1;
                        $data2['store_id'] = isset($salesmanLeaveList[$i]['storeId']) ? $salesmanLeaveList[$i]['storeId'] : NULL;
                        $data2['cont_text'] = isset($salesmanLeaveList[$i]['contText']) ? $salesmanLeaveList[$i]['contText'] : NULL;
                        $data2['del_flg'] = isset($salesmanLeaveList[$i]['delFlg']) ? $salesmanLeaveList[$i]['delFlg'] : NULL;

                        $data2['cre_ts'] = date('Y-m-d H:i:s');
                        $data2['cre_user_id'] = 0;
                        $data2['mod_func_id'] = $funcId;
                        $data2['mod_ts'] = date('Y-m-d H:i:s');
                        $data2['mod_user_id'] = 0;
                        $data2['version_no'] = DEFAULT_VERSION_NO;

                        $day = new DateTime($data2['leave_date']);
                        $salesmanLeave = $this->salesman_leave_model->getSalesmanLeave(
                                array(
                                    'leaveDate' => $day->format('Y-m-d'),
                                    'leaveType' => $data2['type'],
                            'salesmanId' => $data['salesman_id']));

                        if ($salesmanLeave !== NULL && !empty($salesmanLeave) && $data2['type'] != FLAG_SCHEDULE_TYPE_WORKING) {
                            $data2['salesman_leave_id'] = $salesmanLeave[0]['salesmanLeaveId'];
                            $data2['leave_seq'] = $salesmanLeave[0]['leaveSeq'];
                            $this->salesman_leave_model->update($data2['salesman_leave_id'], $data2);
                        } else {
                            $max_leave_seq = $this->salesman_leave_model->selectMaxSeqNo($data2['salesman_id']);
                            $data2['leave_seq'] = $max_leave_seq + 1;
                            $data2['salesman_leave_id'] = $this->salesman_leave_model->insert($data2);
                        }

                        $result['salesmanLeaveList'][$i] = array('salesmanLeaveId' => $data2['salesman_leave_id'],
                            'salesmanId' => $data2['salesman_id'],
                            'leaveSeq' => $data2['leave_seq']);
                    }

                    $data['sync_sts_flg'] = FLAG_1;
                    $result['syncStsFlg'] = FLAG_1;


                    $data['sync_info'] = json_encode($result);
                    $data['cre_ts'] = date('Y-m-d H:i:s');
                    $data['cre_user_id'] = 0;
                    $data['mod_func_id'] = $funcId;
                    $data['mod_ts'] = date('Y-m-d H:i:s');
                    $data['mod_user_id'] = 0;
                    $data['version_no'] = DEFAULT_VERSION_NO;

                    $this->salesman_sync_model->insert($data);

                }

                //syncDataSalesmanLeave
            } else if ($syncType === FLAG_5) {
                $this->load->library('FileManagement');
                $this->load->model('photos_model');
                //syncDataPhoto
                $photoList = isset($post['photoList']) ? $post['photoList'] : '';
                $count = count($photoList);
                if ($count > 0) {

                    for ($i = 0; $i < $count; $i++) {
                        $data2 = array();
                        $data2['salesman_id'] = $data['salesman_id'];
                        $data2['client_id'] = isset($photoList[$i]['clientId']) ? $photoList[$i]['clientId'] : NULL;
                        $data2['store_id'] = isset($photoList[$i]['storeId']) ? $photoList[$i]['storeId'] : NULL;


                        $data2['post_time'] = isset($photoList[$i]['postTime']) ? $photoList[$i]['postTime'] : NULL;
                        if ($data2['post_time'] !== NULL && $data2['post_time'] > 0) {
                            $data2['post_time'] = date("Y-m-d H:i:s", $data2['post_time']/1000);
                        } else {
                            $data2['post_time'] = date('Y-m-d H:i:s');
                        }
                        $base64Image = isset($photoList[$i]['base64Image']) ? $photoList[$i]['base64Image'] : '';
                        if($base64Image !== ''){
                        $path = $this->filemanagement->saveImage($base64Image, "photo", "png");
                        } else{
                            $path = '';
                        }


                        $data2['path'] = $path;
                        $data2['notes'] = isset($photoList[$i]['notes']) ? $photoList[$i]['notes'] : '';
                        $data2['sub_leader_user_id'] = isset($photoList[$i]['subLeaderUserId']) ? $photoList[$i]['subLeaderUserId'] : NULL;
                        $data2['cre_ts'] = date('Y-m-d H:i:s');
                        $data2['cre_func_id'] = $funcId;
                        $data2['cre_user_id'] = 0;
                        $data2['mod_func_id'] = $funcId;
                        $data2['mod_ts'] = date('Y-m-d H:i:s');
                        $data2['mod_user_id'] = 0;
                        $data2['version_no'] = DEFAULT_VERSION_NO;
						
						
						
                        $data2['photo_id'] = $this->photos_model->insert($data2);
                        $result['syncStsFlg'] = FLAG_1;
                        $result['photoList'][$i] = array('photoId' => $data2['photo_id'],
                            'storeId' => $data2['store_id'],
                            'clientId' => $data2['client_id'],
                            'salesmanId' => $data2['salesman_id']);
                    }
                }


            }

            $result['proResFlg'] = RES_OK;
        }
        return $this->return_json($result);
    }

    public function changePwd()
    {

        $result = array(
            'returnCd' => NULL,
            'returnMsg' => NULL,
            'proResFlg' => RES_NG
        );
        if ($this->input->method(TRUE) === 'POST') {
            $post = $this->input->post(NULL, TRUE);
            $post = isset($post['paramJson']) ? json_decode($post['paramJson'], true) : array();
            /*
                  $paramHash = isset($post['paramHash']) ? $post['paramHash'] : '';

                  if( !empty($paramHash)){
                    $paramHash_MD5 = $this->create_md5($paramHash);
                    if($paramHash_MD5 !== PARAM_HASH_MD5 ){
                      $result['returnMsg'] = "Invalid paramHash";
                      $result['proResFlg'] = RES_NG;
                      return $result;
                    }
                  } else {
                    $result['returnMsg'] = "Invalid paramHash";
                    $result['proResFlg'] = RES_NG;
                    return $result;
                  }
            */
            $id = isset($post['id']) ? $post['id'] : NULL;
            $type = isset($post['type']) ? $post['type'] : NULL;
            $pass = isset($post['password']) ? $post['password'] : NULL;
            if ($id === NULL || $type === NULL || $pass === NULL) {
                $result['returnMsg'] = "Invalid param";
                $result['proResFlg'] = RES_NG;
                return $result;
            } else {
                $this->load->model('saleman_model');
                $this->load->model('user_mst_model');
                $pass = $this->create_md5($pass);

                if ((int)$type === TYPE_MR) {
                    $this->saleman_model->update($id, array('pin_code' => $pass));
                } else {
                    $this->user_mst_model->update($id, array('password' => $pass));
                }
                $result['returnMsg'] = "Change password successful";
                $result['proResFlg'] = RES_OK;
            }
        }
        return $this->return_json($result);
    }


}
