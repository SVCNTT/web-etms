<?php

class Coaching_template_model extends MY_Model
{
    public $strikeforce;
    public function __construct()
    {
        $this->strikeforce = $this->load->database(DATABASE_NAME, TRUE);
    }
	/*
	public function Insert($data)
	{
		$this->strikeforce->trans_start();
        $this->strikeforce->insert('user_salesman', $data);
        $insert_id = $this->strikeforce->insert_id();
        $this->strikeforce->trans_complete();
        return  $insert_id;
	}
	*/

    /**
     * API salemain
     * @param $arrParam
     * @return array|null
     */
    public function selectListCoachingTemplateByUserId($arrParam)
    {
        $userId = isset($arrParam['userId']) ? $arrParam['userId'] : '';
		
        if (empty($userId)) {
            return NULL;
        }
		$result = array();
		
		$this->strikeforce->select('ct.coaching_template_id as id, ct.coaching_name as name, ct.cre_ts as createdDate, uct.user_id as userId');
        
		$this->strikeforce->from('coaching_template ct');		
		
		$this->strikeforce->join('user_coaching_template uct', "uct.coaching_template_id = ct.coaching_template_id and ct.del_flg != '1' and uct.del_flg != '1'");
        
		$this->strikeforce->where('uct.user_id', $userId);
		
        $list_Coaching_Template = $this->strikeforce->get();
		
		if($list_Coaching_Template != FALSE)
		{
			
			$list_Coaching_Template = $list_Coaching_Template->result_array();
			if(!empty($list_Coaching_Template)){
				$i=0;
				
				for ($i=0; $i<count($list_Coaching_Template); $i = $i + 1){
					$coaching_template = array();
					$coaching_template['id'] = $list_Coaching_Template[$i]['id'];
					$coaching_template['name'] = $list_Coaching_Template[$i]['name'];
					$coaching_template['createdDate'] = $list_Coaching_Template[$i]['createdDate'];
					$coaching_template['userId'] = $list_Coaching_Template[$i]['userId'];
					$listSections = $this->selectListCoachingTemplateSectionByCTId(array('ctId'=>$list_Coaching_Template[$i]['id']));
					$coaching_template['listSections'] = $listSections;
					$result[$i] = $coaching_template;
				}
			}
			return $result;
		} else {
			return NULL;
		}
    }

    /**
     * selectListCoachingTemplateByUserId
     * @param $arrParam
     * @return array|null
     */
	private function selectListCoachingTemplateSectionByCTId($arrParam)
    {
        $ctId = isset($arrParam['ctId']) ? $arrParam['ctId'] : '';
					// var_dump($ctId); exit();
        if (empty($ctId)) {
            return NULL;
        }
		$result = array();
		
		$this->strikeforce->select('cts.coaching_template_section_id as id, cts.title as title, cts.need_to_calculate as needToCalculate, cts.cre_ts as createdDate');
        
		$this->strikeforce->from('coaching_template_section cts');		
		
		$this->strikeforce->join('bayer_coaching_template ct', "cts.coaching_template_id = ct.temp_id and ct.visible = '1' and cts.del_flg != '1'");
        
		$this->strikeforce->where('ct.temp_id', $ctId);
		
        $list_template_section = $this->strikeforce->get();
		if($list_template_section != FALSE)
		{
			
			$list_template_section = $list_template_section->result_array();
			// var_dump($list_template_section); exit();
			if(!empty($list_template_section)){
				for ($j=0; $j<count($list_template_section); $j = $j + 1){
					$template_section = array();
					$template_section['id'] = $list_template_section[$j]['id'];
					$template_section['title'] = $list_template_section[$j]['title'];
          			$template_section['needToCalculate'] = $list_template_section[$j]['needToCalculate'];
					$template_section['createdDate'] = $list_template_section[$j]['createdDate'];
					$listItem = $this->selectListCoachingTemplateItemByCTSId(array('ctsId'=>$template_section['id']));
					$template_section['listItems'] = $listItem;
					$result[$j] = $template_section;
				}
			}
			return $result;
		} else {
			return NULL;
		}
    }

    /**
     * selectListCoachingTemplateSectionByCTId
     * @param $arrParam
     * @return array|null
     */
	private function selectListCoachingTemplateItemByCTSId($arrParam)
    {
        $ctsId = isset($arrParam['ctsId']) ? $arrParam['ctsId'] : '';
		
        if (empty($ctsId)) {
            return NULL;
        }
		$result = array();
		
		$this->strikeforce->select('cti.coaching_template_section_item_id as id, cti.title as title, cti.cre_ts as createdDate');
        
		$this->strikeforce->from('coaching_template_section_item cti');		
		
		$this->strikeforce->join('coaching_template_section cts', "cti.coaching_template_section_id = cts.coaching_template_section_id and cti.del_flg != '1' and cts.del_flg != '1'");
        
		$this->strikeforce->where('cts.coaching_template_section_id', $ctsId);
		
        $list_section_item = $this->strikeforce->get();
		
		if($list_section_item != FALSE)
		{
			$list_section_item = $list_section_item->result_array();			
			if(!empty($list_section_item)){
				$result = $list_section_item;
			}
			return $result;
		} else {
			return NULL;
			
		}
    }



    /**
     * selectListCoachingTemplateByUserId
     * @param $arrParam
     * @return array|null
     */
	private function selectListCoachingTemplateSectionByCTId_ver2($arrParam)
    {
        $ctId = isset($arrParam['ctId']) ? $arrParam['ctId'] : '';
					// var_dump($ctId); exit();
        if (empty($ctId)) {
            return NULL;
        }
		$result = array();
		
		$this->strikeforce->select('cts.coaching_template_section_id as id, cts.title as title, cts.need_to_calculate as needToCalculate, cts.cre_ts as createdDate');
        
		$this->strikeforce->from('coaching_template_section cts');		
		
		$this->strikeforce->join('bayer_coaching_template ct', "cts.coaching_template_id = ct.temp_id and ct.visible = '1' and cts.del_flg != '1'");
        
		$this->strikeforce->where('ct.temp_id', $ctId);
		
        $list_template_section = $this->strikeforce->get();
		if($list_template_section != FALSE)
		{
			
			$list_template_section = $list_template_section->result_array();
			// var_dump($list_template_section); exit();
			if(!empty($list_template_section)){
				for ($j=0; $j<count($list_template_section); $j = $j + 1){
					$template_section = array();
					$template_section['id'] = $list_template_section[$j]['id'];
					$template_section['title'] = $list_template_section[$j]['title'];
          			$template_section['needToCalculate'] = $list_template_section[$j]['needToCalculate'];
					$template_section['createdDate'] = $list_template_section[$j]['createdDate'];
					$listItem = $this->selectListCoachingTemplateItemByCTSId(array('ctsId'=>$template_section['id']));
					$template_section['listItems'] = $listItem;
					$result[$j] = $template_section;
				}
			}
			return $result;
		} else {
			return NULL;
		}
    }


    public function selectListCoachingTemplate() {
    	$result = array();
		
		$this->strikeforce->select('bct.temp_id as ctId, bct.temp_name as title, bct.temp_type as type, bct.temp_customer_type as customer_type');
        
		$this->strikeforce->from('bayer_coaching_template bct');	

		$this->strikeforce->where('bct.visible', 1);

		$list_section_item = $this->strikeforce->get();
		
		if($list_section_item != FALSE)
		{
			$list_section_item = $list_section_item->result_array();			
			if(!empty($list_section_item)){
				foreach ($list_section_item as $key => $value) {
					// var_dump($value['ctId']);exit();
					# code...
					$listSection = $this->selectListCoachingTemplateSectionByCTId(array('ctId'=>$value['ctId']));
					$value['listSection'] = $listSection;
					array_push($result, $value);

				}
			}
			return $result;
		} else {
			return NULL;
			
		}
    }
}
?>