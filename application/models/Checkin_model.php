<?php

class Checkin_model extends MY_Model
{
    public $strikeforce;

    public function __construct()
    {
        $this->strikeforce = $this->load->database(DATABASE_NAME, TRUE);
    }

    /**
     * API saleman
     * @param $data
     * @return mixed
     */
    public function checkinRegis($data)
    {
        $this->strikeforce->trans_start();
        $this->strikeforce->insert('checkin', $data);
        $insert_id = $this->strikeforce->insert_id();
        $this->strikeforce->trans_complete();
        return $insert_id;
    }

    /**
     * API saleman
     * @param $data
     * @param $checkinId
     * @return mixed
     */
    public function checkoutRegis($data, $checkinId)
    {
        return $this->strikeforce->update('checkin', $data, array('checkin_id' => $checkinId));
    }

    /**
     * selectPhotoStore
     * @param $param
     * @return null
     */
//    private function getAllPhotoByStoreIdOrByStoreId($param) {
//        $this->strikeforce->select(' * ');
//
//        $this->strikeforce->from('checkin chk');
//        $this->strikeforce->where(' chk.del_flg != ', 1);
//        $this->strikeforce->where('chk.client_id', 1);
//
//        $storeId = isset($param['storeId']) ? $param['storeId'] : NULL;
//        if ($storeId !== NULL) {
//            $this->strikeforce->where('chk.store_id', $storeId);
//        }
//
//        $this->strikeforce->order_by('chk.cre_ts desc');
//        $query = $this->strikeforce->get();
//        return $query != FALSE ? $query->result_array() : NULL;
//    }

    /**
     * API saleman
     * @param $params
     * @return null
     */
    public function searchCheckin($params) {
        $this->strikeforce->select('
                        chk.checkin_id checkinId,
                        chk.checkin_time checkinTime,
                        chk.checkout_time checkoutTime,
                        chk.image_path imagePath,
                        chk.long_val longVal,
                        chk.lat_val latVal
                        ');

        $this->strikeforce->from('checkin chk');
        $this->strikeforce->where('chk.del_flg != ', 1);
        $this->strikeforce->where('chk.salesman_id = ', $params['salesman_id']);

        if ((int)$params['type'] === CHECKIN_TYPE_ORDER) {
            $this->strikeforce->where('chk.type = ', CHECKIN_TYPE_ORDER);
            $this->strikeforce->where('chk.store_id = ', STORE_ID_CHECKIN_TYPE_ORDER);
            $this->strikeforce->where('chk.store_name = ', $params['store_name']);

        } else {
            $this->strikeforce->where('chk.type = ', CHECKIN_TYPE_ORIGINAL);
            $this->strikeforce->where('chk.store_id = ', $params['store_id']);
        }
        $this->strikeforce->order_by('chk.checkin_time desc');
        $query = $this->strikeforce->get();

        if ($query->num_rows() > 0){
            return $query->result_array()[0];
        }

        return NULL;
    }

//    public function selectPhotoStore($param) {
//        $photos = $this->getAllPhotoByStoreIdOrByStoreId($param);
//        $photoPatchResult = [];
//        if ($photos !== NULL) {
//
//            $tempDate = NULL;
//
//            $photoPatch = [];
//            $image = [];
//            foreach ($photos as $row) {
//
//                if ($tempDate == date("d-m-Y", strtotime($row['cre_ts']))) {
//                    $image[] = array("notes" => "", "photoPath" => $row['image_path']);
//
//                } else {
//                    if ($image == NULL) {
//                        $image[] = array("notes" => "", "photoPath" => $row['image_path']);
//                    } else {
//                        $photoPatch["photoDate"] = $tempDate;
//                        $photoPatch["photoPath"] = $image;
//                        $photoPatchResult[] = $photoPatch;
//                        $image = NULL;
//                        $image[] = array("notes" => "", "photoPath" => $row['image_path']);
//                    }
//                    $tempDate = date("d-m-Y", strtotime($row['cre_ts']));
//                }
//            }
//            $photoPatch["photoDate"] = $tempDate;
//            $photoPatch["photoPath"] = $image;
//            $photoPatchResult[] = $photoPatch;
//        }
//        return $photoPatchResult;
//    }

    /**
     * Checkin controller
     * @param $params
     * @return array
     */
    public function searchAllCheckin($params) {
        $paging = isset($params["pagingInfo"]) ? $params["pagingInfo"] : array();
        $searchParam = isset($params["searchInput"]) ? $params["searchInput"] : array();
        $totalRow = $this->countSearchAllCheckin($searchParam);
        if ($totalRow > 0) {
            /*Get MR by current user - Begin*/
            $curr_user = get_current_profile(PLATFORM);
            $this->load->model('saleman_model');
            $mr_list = $this->saleman_model->selectMRByRole($curr_user);
            $arr_mr_id = array();
            if (!empty($mr_list)) {
                foreach ($mr_list as $temp) {
                    $arr_mr_id[] = strval($temp['salesman_id']);
                }
            }
            /*Get MR by current user - End*/

            $this->strikeforce->select('
                        distinct chk.checkin_id,
                        st.store_id storeId,
                        st.store_code storeCode,
                        st.store_name storeName,
                        st.title doctorTitle,
                        st.doctor_name doctorName,
                        st.is_doctor isDoctor,
                        chk.checkin_time checkinTime,
                        chk.checkout_time checkoutTime,
                        chk.image_path imagePath,
                        chk.long_val longVal,
                        chk.lat_val latVal,
                        sa.salesman_id salesmanId,
                        sa.salesman_code salesmanCode,
                        sa.salesman_name salesmanName
                                    ', false);

            $this->strikeforce->from('checkin chk');
            $this->strikeforce->join('salesman sa', 'chk.salesman_id = sa.salesman_id');
            $this->strikeforce->join('user_salesman us_sa', 'us_sa.salesman_id = sa.salesman_id');
            $this->strikeforce->join('user_mst us', 'us.user_id = us_sa.sub_leader_user_id');
            $this->strikeforce->join('user_product_type us_pr_tp', 'us.user_id = us_pr_tp.user_id');
            $this->strikeforce->join('store st', 'chk.store_id = st.store_id');

            if (sizeof($arr_mr_id) > 0) {
            $this->strikeforce->where_in('chk.salesman_id', $arr_mr_id);
            }
            $this->strikeforce->where('chk.del_flg != ', 1);
            $this->strikeforce->where('sa.del_flg != ', 1);
            $this->strikeforce->where('us_sa.del_flg != ', 1);
            $this->strikeforce->where('us.del_flg != ', 1);
            $this->strikeforce->where('us_pr_tp.del_flg != ', 1);
            $this->strikeforce->where('st.del_flg != ', 1);

            /*Get date current - Begin*/
            $this->strikeforce->where('DATEDIFF(now(), chk.checkin_time) = ', 0);
            /*Get date current - End*/

            $salesmanName = isset($searchParam["salesmanName"]) ? $searchParam["salesmanName"] : '';
            if (!empty($salesmanName)){
                $this->strikeforce->like('UPPER(sa.salesman_name)',strtoupper($salesmanName));
            }

            $salesmanCode = isset($searchParam["salesmanCode"]) ? $searchParam["salesmanCode"] : '';
            if (!empty($salesmanCode)){
                $this->strikeforce->like('UPPER(sa.salesman_code)',strtoupper($salesmanCode));
            }

            $productTypeId = isset($searchParam["productTypeId"]) ? $searchParam["productTypeId"] : '';
            if (!empty($productTypeId)){
                $this->strikeforce->where('us_pr_tp.product_type_id =', $productTypeId);
            }

            $this->strikeforce->order_by('chk.checkin_id desc');
            $curr_page = isset($paging["crtPage"]) ? $paging["crtPage"] : 1;
            $pagingSet = $this->setPagingInfo($totalRow, $curr_page);

            $limit = ROW_ON_PAGE;
            $offset = $pagingSet["stRow"] - 1;
            $this->strikeforce->limit($limit, $offset);
            $query = $this->strikeforce->get();

            $dataResult["salesmanCheckin"] = $query->result_array();

            /*Check image - Begin*/
            if (!empty($dataResult['salesmanCheckin'])) {
                foreach($dataResult['salesmanCheckin'] as $k=>$v) {
                    if (empty($v['imagePath'])) {
                        $dataResult['salesmanCheckin'][$k]['imagePath'] = 'assets/img/no_img.png';
                    } else {
                        $imgSize = getimagesize(site_url($v['imagePath']));
                        if (is_array($imgSize)) {
                            if (!isset($imgSize[0]) || $imgSize[0] == 0 || !isset($imgSize[1]) || $imgSize[1] == 0) {
                                $dataResult['salesmanCheckin'][$k]['imagePath'] = 'assets/img/no_img.png';
                            }
                        } else {
                            $dataResult['salesmanCheckin'][$k]['imagePath'] = 'assets/img/no_img.png';
                        }
                    }
                }
            }
            /*Check image - End*/

            $dataResult["pagingInfo"] = $pagingSet;

            return $dataResult;
        } else {
            return [];
        }
    }

    /**
     * searchAllCheckin
     * @param $searchParam
     * @return mixed
     */
    private function countSearchAllCheckin($searchParam) {
        /*Get MR by current user - Begin*/
        $curr_user = get_current_profile(PLATFORM);
        $this->load->model('saleman_model');
        $mr_list = $this->saleman_model->selectMRByRole($curr_user);
        $arr_mr_id = array();
        if (!empty($mr_list)) {
            foreach ($mr_list as $temp) {
                $arr_mr_id[] = strval($temp['salesman_id']);
            }
        }
        /*Get MR by current user - End*/

        $this->strikeforce->select('count(distinct chk.checkin_id) as totalRow ', false);
        $this->strikeforce->from('checkin chk');
        $this->strikeforce->join('salesman sa', 'chk.salesman_id = sa.salesman_id');
        $this->strikeforce->join('user_salesman us_sa', 'us_sa.salesman_id = sa.salesman_id');
        $this->strikeforce->join('user_mst us', 'us.user_id = us_sa.sub_leader_user_id');
        $this->strikeforce->join('user_product_type us_pr_tp', 'us.user_id = us_pr_tp.user_id');
        $this->strikeforce->join('store st', 'chk.store_id = st.store_id');
        if (sizeof($arr_mr_id) > 0) {
        $this->strikeforce->where_in('chk.salesman_id', $arr_mr_id);
        }
        $this->strikeforce->where('chk.del_flg != ', 1);
        $this->strikeforce->where('sa.del_flg != ', 1);
        $this->strikeforce->where('us_sa.del_flg != ', 1);
        $this->strikeforce->where('us.del_flg != ', 1);
        $this->strikeforce->where('us_pr_tp.del_flg != ', 1);
        $this->strikeforce->where('st.del_flg != ', 1);

        /*Get date current - Begin*/
        $this->strikeforce->where('DATEDIFF(now(), chk.checkin_time) = ', 0);
        /*Get date current - End*/

        $salesmanName = isset($searchParam["salesmanName"]) ? $searchParam["salesmanName"] : '';
        if (!empty($salesmanName)){
            $this->strikeforce->like('UPPER(sa.salesman_name)',strtoupper($salesmanName));
        }

        $salesmanCode = isset($searchParam["salesmanCode"]) ? $searchParam["salesmanCode"] : '';
        if (!empty($salesmanCode)){
            $this->strikeforce->like('UPPER(sa.salesman_code)',strtoupper($salesmanCode));
        }

        $productTypeId = isset($searchParam["productTypeId"]) ? $searchParam["productTypeId"] : '';
        if (!empty($productTypeId)){
            $this->strikeforce->where('us_pr_tp.product_type_id = ', $productTypeId);
        }

        $queryTotal = $this->strikeforce->get();
        return $queryTotal->row()->totalRow;
    }
}

?>