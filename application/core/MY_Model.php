<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Model extends CI_Model {
	
	// Your_model constructor
	function __construct (){
		parent::__construct();
    }

    public function beforeSave($params, &$data, $isInserted) {
        $data['modified_time'] = date('Y-m-d H:i:s');
        $by = isset($params['user_id']) ? $params['user_id'] : 0;
        if ($isInserted) {
            $data['created_time'] = date('Y-m-d H:i:s');
            $data['created_by'] = $by;
        }
        else
        {
            $data['modified_by'] = $by;
        }
    }
    public function  setPagingInfo($total, $page, $rowNumber = ROW_ON_PAGE){
             $edRow = 0;
             $stRow = 0;
             $ttlPages = 0;
             $ttlRow = 0;
             $crtPage = 1;
             if (intval($page) >= 1){
                $crtPage = $page;
             } 
     
            $ttlRow = $total ;
            $totalRow =  $total;

            $ttlPages = ceil($ttlRow/$rowNumber);
            $crtPage = intval($crtPage > $ttlPages ? $ttlPages : $crtPage); 
            if ($crtPage >= 1) {
                    $stRow = ($crtPage - 1) * $rowNumber + 1;
                    $edRow = ($crtPage - 1) * $rowNumber + $rowNumber;
            }
            if ($edRow > $ttlRow) {
                    $edRow = $ttlRow;
            }

            $pagingSet["ttlRow"] = $totalRow;
            $pagingSet["crtPage"] = $crtPage == 0 ? 1:$crtPage;
            $pagingSet["rowNumber"] = $rowNumber;
            $pagingSet["stRow"] =$stRow  == 0 ? 1:$stRow;
            $pagingSet["edRow"] =$edRow;
            $pagingSet["ttlPages"] =$ttlPages == 0 ? 1:$ttlPages;
            return  $pagingSet;         
    }
}
// END Controller class

/* End of file MY_Model.php */
/* Location: ./system/core/MY_Model.php */