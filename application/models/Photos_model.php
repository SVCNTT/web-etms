<?php 

class Photos_model extends MY_Model
{
	public $strikeforce;

	public function __construct()
	{
		$this->strikeforce = $this->load->database(DATABASE_NAME, TRUE);
	}

    /**
     * selectPhotoStore
     * @param $param
     * @return null
     */
    private function getAllPhotoByStoreIdOrByClientId($param)
    {
        $this->strikeforce->select(' * ');

        $this->strikeforce->from('photo p'); 
        $this->strikeforce->where(' p.del_flg != ', 1);

        $clientId = isset($param['clientId']) ? $param['clientId'] : NULL;
        if ($clientId !== NULL) {
            $this->strikeforce->where('p.client_id', $clientId);
        }

        $storeId = isset($param['storeId']) ? $param['storeId'] : NULL;
        if ($storeId !== NULL) {
            $this->strikeforce->where('p.store_id', $storeId);
        } 

        $this->strikeforce->order_by('p.post_time desc');
        $query = $this->strikeforce->get();
        return $query != FALSE ? $query->result_array() : NULL;		
	}

    /**
     * Store controller
     * @param $param
     * @return array
     */
    public function selectPhotoStore($param)
    {
		$photos = $this->getAllPhotoByStoreIdOrByClientId($param);
		$photoPatchResult =[];
		if ($photos !== NULL){

			$tempDate = NULL;
			
			$photoPatch = [];			
			$image = [];
			foreach ($photos as $row){

                if ($tempDate == date("d-m-Y", strtotime($row['post_time']))) {
					$image[] = array("notes"=>$row['notes'],"photoPath"=>$row['path']);

				}else {
					if ($image == NULL){
						$image[] = array("notes"=>$row['notes'],"photoPath"=>$row['path']);
					}else{
						$photoPatch["photoDate"] = $tempDate;
						$photoPatch["photoPath"] = $image;
						$photoPatchResult[] = $photoPatch;
						$image = NULL;
						$image[] = array("notes"=>$row['notes'],"photoPath"=>$row['path']);
					}
					$tempDate = date("d-m-Y",strtotime($row['post_time']));
				}
			}
			$photoPatch["photoDate"] = $tempDate;
			$photoPatch["photoPath"] = $image;
			$photoPatchResult[] = $photoPatch;
		}
		return $photoPatchResult;
	}
	 
    /**
     * Client detail controller, Dashboard controller
     * @param $param
     * @return array
     */
    public function getPhotoByClientAndStore($param)
    {
        $dataResult = array(
            "photoCal" => array(),
            "pagingInfo" => NULL);

        $totalRow = $this->countPhotoByClientAndStore($param);

        if ($totalRow > 0) {
        	 $crtPage = 1;
            if (isset($param["pagingInfo"])) {
                $crtPage = $param["pagingInfo"]["crtPage"];
            }
            $pagingSet = $this->setPagingInfo($totalRow, $crtPage);

	        $this->strikeforce->select(' * ');
	        $this->strikeforce->from('photo p'); 
	        $this->strikeforce->where(' p.del_flg != ', 1);

//            $clientId = isset($param['clientId']) ? $param['clientId'] : NULL;
//            if ($clientId !== NULL) {
//                $this->strikeforce->where('p.client_id', $clientId);
//            }

	        $storeId = isset($param['storeId']) ? $param['storeId'] : NULL;
	        if ($storeId !== NULL) {
	            $this->strikeforce->where('p.store_id', $storeId);
	        } 

            $startDate = isset($param['startDate']) ? $param['startDate'] : NULL;
            if ($startDate !== NULL) {
                list($d, $m, $y) = explode('-', $startDate);
                $startDate = $y.'-'.$m.'-'.$d.' 00:00:00';
                $this->strikeforce->where('p.post_time >=', $startDate);
            }

            $endDate = isset($param['endDate']) ? $param['endDate'] : NULL;
            if ($endDate !== NULL) {
                list($d, $m, $y) = explode('-', $endDate);
                $endDate = $y.'-'.$m.'-'.$d.' 23:59:59';
                $this->strikeforce->where('p.post_time <=', $endDate);
            }

            $curr_user = isset($param['curr_user']) ? $param['curr_user'] : NULL;
            if($curr_user) {
                switch($curr_user['user_role_cd']) {
                    case ROLE_ADMIN_CD:
                    case ROLE_MOD_CD:
                        break;

                    case ROLE_BU_CD:
                    case ROLE_SALES_MANAGER_CD:
                    case ROLE_REGION_MANAGER_CD:
                        /*Get MR by current user - Begin*/
                        $this->load->model('store_model');
                        $store_list = $this->store_model->selectStoreByRole($curr_user);
                        $arr_store_id = array();
                        if (!empty($store_list)) {
                            foreach ($store_list as $temp) {
                                $arr_store_id[] = strval($temp['store_id']);
                            }
                        }
                        /*Get MR by current user - End*/

                        $this->strikeforce->where_in('store_id', $arr_store_id);
                        break;
                }
            }

            $limit = ROW_ON_PAGE;
            $offset = $pagingSet["stRow"]-1;
            $this->strikeforce->limit($limit, $offset);
            $this->strikeforce->order_by('p.post_time desc');
	        $query = $this->strikeforce->get();

            /*Get store for mapping - Begin*/
            $this->load->model('store_model');
            $stores = $this->store_model->selectStoreByRoleForMapping($curr_user);
            /*Get store for mapping - End*/

				$photoPatchResult =[]; 
				$tempDate = NULL;
				$photoPatch = [];			
				$image = [];
				foreach ($query->result() as $row){
                $store_name = isset($stores[$row->store_id]['store_name']) ? $stores[$row->store_id]['store_name'] : '';
                if ($tempDate == date("d-m-Y", strtotime($row->post_time))) {
                    $image[] = array("notes" => $row->notes, "photoPath" => $row->path, "storeName" => $store_name);
					}else {
						if ($image == NULL){
                        $image[] = array("notes" => $row->notes, "photoPath" => $row->path, "storeName" => $store_name);
						}else{
							$photoPatch["photoDate"] = $tempDate;
                        $photoPatch["photoPaths"] = $image;
							$photoPatchResult[] = $photoPatch;
							$image = NULL;
                        $image[] = array("notes" => $row->notes, "photoPath" => $row->path, "storeName" => $store_name);
						}
						$tempDate = date("d-m-Y",strtotime($row->post_time));
					}
				}

				$photoPatch["photoDate"] = $tempDate;
            $photoPatch["photoPaths"] = $image;
				$photoPatchResult[] = $photoPatch;

            $dataResult["photoCal"] = $photoPatchResult;
            $dataResult["pagingInfo"] = $pagingSet;
        }

            return  $dataResult;
        }

    /**
     * getPhotoByClientAndStore
     * @param $param
     * @return mixed
     */
    private function countPhotoByClientAndStore($param)
    {
        $this->strikeforce->select(' count(*) as  totalRow');

        $this->strikeforce->from('photo p'); 
        $this->strikeforce->where(' p.del_flg != ', 1);

//        $clientId = isset($param['clientId']) ? $param['clientId'] : NULL;
//        if ($clientId !== NULL) {
//            $this->strikeforce->where('p.client_id', $clientId);
//        }

        $storeId = isset($param['storeId']) ? $param['storeId'] : NULL;
        if ($storeId !== NULL) {
            $this->strikeforce->where('p.store_id', $storeId);
        } 

        $startDate = isset($param['startDate']) ? $param['startDate'] : NULL;
        if ($startDate !== NULL) {
            list($d, $m, $y) = explode('-', $startDate);
            $startDate = $y.'-'.$m.'-'.$d.' 00:00:00';
            $this->strikeforce->where('p.post_time >=', $startDate);
        }

        $endDate = isset($param['endDate']) ? $param['endDate'] : NULL;
        if ($endDate !== NULL) {
            list($d, $m, $y) = explode('-', $endDate);
            $endDate = $y.'-'.$m.'-'.$d.' 23:59:59';
            $this->strikeforce->where('p.post_time <=', $endDate);
        }

        $curr_user = isset($param['curr_user']) ? $param['curr_user'] : NULL;
        if($curr_user) {
            switch($curr_user['user_role_cd']) {
                case ROLE_ADMIN_CD:
                case ROLE_MOD_CD:
                    break;

                case ROLE_BU_CD:
                case ROLE_SALES_MANAGER_CD:
                case ROLE_REGION_MANAGER_CD:
                    /*Get MR by current user - Begin*/
                    $this->load->model('store_model');
                    $store_list = $this->store_model->selectStoreByRole($curr_user);
                    $arr_store_id = array();
                    if (!empty($store_list)) {
                        foreach ($store_list as $temp) {
                            $arr_store_id[] = strval($temp['store_id']);
                        }
                    }
                    /*Get MR by current user - End*/

                    $this->strikeforce->where_in('store_id', $arr_store_id);
                    break;
            }
        }

        $this->strikeforce->order_by('p.post_time desc');
        $queryTotal = $this->strikeforce->get();
        return $queryTotal->row()->totalRow; 
    }
	 
    /**
     * API saleman
     * @param $data
     * @return mixed
     */
		public function Insert($data)
		{
				$this->strikeforce->trans_start();
        $this->strikeforce->insert('photo', $data);
        $insert_id = $this->strikeforce->insert_id();
        $this->strikeforce->trans_complete();
        return  $insert_id;
		}

    public function update($photo_id, $data)
    {
	      return $this->strikeforce->update('photo', $data, array('photo_id' => $photo_id));
	  }

//    public function getPhotoItem($arrParam)
//    {
//
//        $storeId = isset($arrParam['storeId']) ? $arrParam['storeId'] : NULL;
//        $clientId = isset($arrParam['clientId']) ? $arrParam['clientId'] : NULL;
//        $salesmanId = isset($arrParam['salesmanId']) ? $arrParam['salesmanId'] : NULL;
//
//        if ($storeId === NULL || $clientId === NULL || $salesmanId === NULL) {
//            return NULL;
//        }
//        $this->strikeforce->select('`photo_id` as photoId, `client_id` as clientId, `store_id` as storeId, `salesman_id` as salesmanId, `path`, `post_time` as postTime, `sub_leader_user_id` as subLeaderUserId, `notes`');
//        $this->strikeforce->from('photo');
//        $this->strikeforce->where('store_id', $storeId);
//        $this->strikeforce->where('client_id', $clientId);
//        $this->strikeforce->where('salesman_id', $salesmanId);
//        $this->strikeforce->where('del_flg != 1');
//        $photoItem = $this->strikeforce->get();
//
//        if ($photoItem != FALSE) {
//            return $photoItem->result_array();
//        } else {
//            return NULL;
//        }
//    }
}

?>
