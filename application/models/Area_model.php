<?php 
class Area_model extends MY_Model
{
	public $strikeforce;

	public function __construct()
	{
		$this->strikeforce = $this->load->database(DATABASE_NAME, TRUE);
	} 

    /**
     * Client detail controller
     * @return array
     */
    public function  selectArea()
    {

        $sSQL = " SELECT * FROM `area` WHERE parent_area IS NULL ORDER BY `display_order` ";
		
		$query = $this->strikeforce->query($sSQL);
		$items[] = array( "areaId"=>NULL,"areaName"=>"All","items"=> null);

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row_parent) {

				$sSQL = " SELECT * FROM `area` WHERE parent_area = ".$row_parent->area_id." ORDER BY `area_id` "; 
				$query = $this->strikeforce->query($sSQL);
                if ($query->num_rows() > 0) {
					$item_child = [];
                    foreach ($query->result() as $row_child) {
						$item_child[] = array( "areaId"=>$row_child->area_id,"areaName"=>$row_child->area_name,"items"=> null);

					}

					$items[] = array( "areaId"=>$row_parent->area_id,"areaName"=>$row_parent->area_name,"items"=> $item_child);	
				}else{
					$items[] = array( "areaId"=>$row_parent->area_id,"areaName"=>$row_parent->area_name,"items"=> null);	
				} 
			}

		}
		return  $items;
	}

    /**
     * User controller
     * @param $param
     * @return array
     */
    public function getAreaDropdown($param)
    {
        $rs = array(
            'selectedAreaId' => -1,
            'items' => array()
        );

        $role_cd = isset($param['role_cd']) ? $param['role_cd'] : -1;
        $is_select_all = isset($param['is_select_all']) ? $param['is_select_all'] : SELECT_AREA_LEVEL_1;
        $selected_area_id = isset($param['selected_area_id']) ? $param['selected_area_id'] : NULL;
        $select_level = isset($param['select_level']) ? $param['select_level'] : SELECT_AREA_LEVEL_1;

        // Get top level
        $list_area = NULL;
        switch ($role_cd) {
            case ROLE_ADMIN_CD:
                $list_area = $this->selectAreaParentList();
                break;

            case ROLE_MOD_CD:
                $list_area = $this->selectAreaOfSubAdmin($param);
                break;

//            case ROLE_MANAGER_CD:
//                $list_area = $this->selectAreaByClient($param);
//                break;
        }

        // Get child Level
        if ($list_area !== NULL) {
            $list_temp = $this->getAreaResultItem($list_area);

            if ($select_level == SELECT_AREA_ALL) {
                $list_temp = $this->setChildArea($list_temp);
            }

            $rs['items'] = $list_temp;
        }

        // Add search all
        if ($is_select_all === SELECT_AREA_ALL) {
            $item_search_all = array(
                'area_id' => -1,
                'area_name' => SEARCH_ALL
            );

            if ($list_area != NULL && !empty($list_area)) {
                array_unshift($list_area, $item_search_all);
            } else {
                $list_area[] = $item_search_all;
            }

            $rs['items'] = $list_area;
        }


        // Select default
        if ($list_area != NULL && !empty($list_area)) {
            if ($selected_area_id == NULL) {
                $rs['selectedAreaId'] = $list_area[0]['area_id'];
            } else {
                foreach ($list_area as $item) {
                    if ($item['areaId'] == $selected_area_id) {
                        $rs['selectedAreaId'] = $item['area_id'];
                        break;
                    }

                    $rs['selectedAreaId'] = $list_area[0]['area_id'];
                }
            }
        }

        return $rs;
    }

    /**
     * getAreaDropdown
     * @return null
     */
    private function selectAreaParentList()
    {
        $this->strikeforce->select('area_id, area_name, display_order');
        $this->strikeforce->where("parent_area IS NULL AND del_flg = '0'");
        $this->strikeforce->order_by('display_order');
        $query = $this->strikeforce->get('area');

        return $query !== FALSE ? $query->result_array() : NULL;
    }

    /**
     * getAreaDropdown
     * @param $param
     * @return null
     */
    private function selectAreaOfSubAdmin($param)
    {
        $user_id = isset($param['user_id']) ? intval($param['user_id']) : 0;
        if ($user_id === 0) {
            return NULL;
        }

        $sql = "SELECT a.*
                FROM user_area ua
                INNER JOIN area a ON ua.area_id = a.area_id AND a.del_flg = '0'
                WHERE ua.del_flg = '0' AND ua.user_id = " . $user_id . "
                ORDER BY a.display_order";

        $query = $this->strikeforce->query($sql);

        return $query !== FALSE ? $query->result_array() : NULL;
    }

    /**
     * getAreaDropdown, setChildArea
     * @param $list
     * @return array|null
     */
    private function getAreaResultItem($list)
    {
        $rs = NULL;
        if (is_array($list) && !empty($list)) {
            foreach ($list as $item) {
                $temp = array();
                $temp['areaId'] = $item['area_id'];
                $temp['areaName'] = $item['area_name'];

                $rs[] = $temp;
            }
        }

        return $rs;
    }

    /**
     * getAreaDropdown
     * @param $list
     */
    private function setChildArea($list)
    {
        $arr_id = array();
        $list_child = NULL;
        if (is_array($list) && !empty($list)) {
            foreach ($list as $item) {
                $arr_id[] = $item['areaId'];
            }

            $list_child = $this->selectAreaChildList($arr_id);

            if (is_array($list_child)) {
                $temp = array();
                foreach($list_child as $child) {
                    $temp[$child['parent_area']][] = $child;
                }

                foreach($list as $k=>$parent) {
                    $list[$k]['items'] = $this->getAreaResultItem($temp['area_id']);
                }
            }
        }
    }

    /**
     * setChildArea
     * @param $list
     * @return null
     */
    private function selectAreaChildList($list){
        $sql_where = '0,';

        if (is_array($list)) {
            foreach ($list as $item) {
                $sql_where .= $item . ',';
            }
            $sql_where .= '0';
        }

        $sql = "
                SELECT area_id, area_name, parent_area, display_order
                FROM area
                WHERE parent_area IN (" . $sql_where . ") AND del_flg = '0'
                ORDER BY parent_area, display_order
            ";

        $query = $this->strikeforce->query($sql);

        return $query !== FALSE ? $query->result_array() : NULL;
    }

    /**
     * User controller
     * @param $user_id
     * @return null
     */
    public function getAreaByUser($user_id) {
        $sql = "SELECT a.*
                FROM area as a
                INNER JOIN user_area as au on(a.area_id = au.area_id )
		        WHERE a.del_flg != '1' and au.user_id = ?";
        $query = $this->strikeforce->query($sql, array($user_id));

        return $query !== FALSE ? $query->result_array() : NULL;
    }

    /**
     * Store model
     * @return mixed
     */
    public function  selectAreaParent() {
        $sSQL = " SELECT * FROM `area` WHERE parent_area IS NULL ORDER BY `display_order` ";
        $query = $this->strikeforce->query($sSQL); 
        return $query->result();
    }

    /**
     * Store model
     * @param $childId
     * @return mixed
     */
    public function selectAreaParentByChildId($childId){
    	$sSQL = " SELECT parent_area FROM `area` WHERE area_id = " .$childId;
    	$query = $this->strikeforce->query($sSQL);
    	return $query->result()[0]->parent_area;
    }
    
//    public function  selectAreaChild() {
//        $sSQL = " SELECT * FROM `area` WHERE parent_area IS NOT NULL ORDER BY `display_order` ";
//        $query = $this->strikeforce->query($sSQL);
//        $keyParent = [];
//            foreach ($query->result() as $row_parent) {
//                 $keyParent[strtolower($row_parent->area_name)] = $row_parent->area_id;
//            }
//            return $keyParent;
//    }

//    public function  selectAreaForCompare() {
//    	$sSQL = " SELECT area_id, area_name, parent_area FROM `area` WHERE parent_area IS NOT NULL ORDER BY `display_order` ";
//    	$query = $this->strikeforce->query($sSQL);
//    	 return $query !== FALSE ? $query->result_array() : NULL;
//    }

}
?>
