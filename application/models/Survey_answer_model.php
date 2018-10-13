<?php

class Survey_answer_model extends MY_Model
{
    public $strikeforce;

    public function __construct()
    {
        $this->strikeforce = $this->load->database(DATABASE_NAME, TRUE);
    }


    public function countSearchSurveyAnswer($params, $survey_id)
    {
        if ( ! $this->strikeforce->table_exists('survey_answers_'.$survey_id)) {
            return 0;
        }

        $this->strikeforce->from('survey_answers_'.$survey_id);

        $curr_user = isset($params['curr_user']) ? $params['curr_user'] : NULL;
        if ($curr_user) {
            switch ($curr_user['user_role_cd']) {
                case ROLE_ADMIN_CD:
                case ROLE_MOD_CD:
                    break;

                case ROLE_BU_CD:
                case ROLE_SALES_MANAGER_CD:
                case ROLE_REGION_MANAGER_CD:
                    /*Get MR by current user - Begin*/
                    $this->load->model('saleman_model');
                    $mr_list = $this->saleman_model->selectMRByRole($curr_user);
                    $arr_mr_code = array();
                    if (!empty($mr_list)) {
                        foreach ($mr_list as $temp) {
                            $arr_mr_code[] = strval($temp['salesman_code']);
                        }
                    }
                    /*Get MR by current user - End*/

                    $this->strikeforce->where_in('salesman_code', $arr_mr_code);
                    break;
            }
        }

        $mr_code = isset($params['mr_code']) ? $params['mr_code'] : NULL;
        if ( ! empty($mr_code)) {
            $this->strikeforce->like(array('salesman_code' => $mr_code));
        }

        $store_code = isset($params['store_code']) ? $params['store_code'] : NULL;
        if ( ! empty($store_code)) {
            $this->strikeforce->like(array('store_code' => $store_code));
        }

        $this->strikeforce->where(array('del_flg !=' => 1));
        return $this->strikeforce->count_all_results();
    }

    public function searchAnswer($params, $survey_id)
    {
        if ( ! $this->strikeforce->table_exists('survey_answers_'.$survey_id)) {
            return array();
        }

        $this->strikeforce->select('*, MD5(CONCAT(\''.$survey_id.'\',id, \''.SECRECT_KEY_SURVEY_ANSWER.'\')) as token, \''.$survey_id.'\' as survey_id');

        $curr_user = isset($params['curr_user']) ? $params['curr_user'] : NULL;
        if ($curr_user) {
            switch ($curr_user['user_role_cd']) {
                case ROLE_ADMIN_CD:
                case ROLE_MOD_CD:
                    break;

                case ROLE_BU_CD:
                case ROLE_SALES_MANAGER_CD:
                case ROLE_REGION_MANAGER_CD:
                    /*Get MR by current user - Begin*/
                    $this->load->model('saleman_model');
                    $mr_list = $this->saleman_model->selectMRByRole($curr_user);
                    $arr_mr_code = array();
                    if (!empty($mr_list)) {
                        foreach ($mr_list as $temp) {
                            $arr_mr_code[] = strval($temp['salesman_code']);
                        }
                    }
                    /*Get MR by current user - End*/

                    $this->strikeforce->where_in('salesman_code', $arr_mr_code);
                    break;
            }
        }

        $mr_code = isset($params['mr_code']) ? $params['mr_code'] : NULL;
        if ( ! empty($mr_code)) {
            $this->strikeforce->like(array('salesman_code' => $mr_code));
        }

        $store_code = isset($params['store_code']) ? $params['store_code'] : NULL;
        if ( ! empty($store_code)) {
            $this->strikeforce->like(array('store_code' => $store_code));
        }

        $this->strikeforce->where(array('del_flg !=' => 1));
        $this->strikeforce->order_by('cre_ts desc');
        $query = $this->strikeforce->get('survey_answers_'.$survey_id);
        return $query !== FALSE ? $query->result_array() : FALSE;
    }

    public function getById($survey_id, $id) {

        $this->strikeforce->select('sa.*, s.name, CASE
									  	WHEN  st.doctor_name = \'\' THEN st.store_name
									  	ELSE st.doctor_name
									  END AS store_name');
        $this->strikeforce->join('surveys s', 's.id = '.$survey_id);
        $this->strikeforce->join('store st', 'st.store_code = sa.store_code', 'left');
        $query = $this->strikeforce->get_where('survey_answers_'.$survey_id.' sa', array('sa.id' => $id));
        return $query !== FALSE ? $query->row_array() : FALSE;

    }

    public function getDetail($survey_id, $salesman_id, $store_id) {
        $query = $this->strikeforce->get_where('survey_answers_'.$survey_id.' sa', array('sa.salesman_id' => $salesman_id, 'sa.store_id' => $store_id));
        return $query !== FALSE ? $query->row_array() : FALSE;

    }

    public function create_excel_file_rp($survey_id, $path)
    {
        $this->load->library('importexcel/FileManagerExport');

        $cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
        $cacheSettings = array('memoryCacheSize' => '2048MB');
        PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);

        $objPHPExcel = new PHPExcel();

        /*Get data*/

        $this->strikeforce->select('sa.*, s.name, CASE
									  	WHEN  st.doctor_name = \'\' THEN st.store_name
									  	ELSE st.doctor_name
									  END AS store_name, sm.salesman_name as salesman_name');
        $this->strikeforce->join('surveys s', 's.id = '.$survey_id);
        $this->strikeforce->join('store st', 'st.store_code = sa.store_code', 'left');
        $this->strikeforce->join('salesman sm', 'MD5(sm.salesman_code) = MD5(sa.salesman_code)', 'left');
        $query = $this->strikeforce->get('survey_answers_'.$survey_id.' sa');
        $data = $query !== FALSE ? $query->result_array() : FALSE;

        $sheetDetails = $objPHPExcel->getActiveSheet(1);
        $this->buildExcel($sheetDetails, $data);


        /*Get data - END*/

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save($path);
    }

    private function buildExcel($sheetDetails, $data, $sheetName = 'Data')
    {
        //set header
        $sheetDetails->setCellValue('A1', 'SURVEY RESULT');
        $sheetDetails->mergeCells('A1:D1');

        $sheetDetails->setCellValue('A3', 'Customer Code');
        $sheetDetails->setCellValue('B3', 'Customer Name');
        $sheetDetails->setCellValue('C3', 'MR Code');
        $sheetDetails->setCellValue('D3', 'MR NAME');


        if (!empty($data)) {
            $question_list = json_decode($data[0]['answer'], TRUE);

            $column = 'D';
            foreach($question_list as $item) {
                $column++;

                $sheetDetails->setCellValue($column.'3', $item['content']);

            }

            foreach ($data as $k => $c) {
                $index = $k + 4;

                $sheetDetails->setCellValue('A' . $index, $c['store_code']);
                $sheetDetails->setCellValue('B' . $index, $c['store_name']);
                $sheetDetails->setCellValue('C' . $index, $c['salesman_code']);
                $sheetDetails->setCellValue('D' . $index, $c['salesman_name']);

                $question_list = json_decode($c['answer'], TRUE);
                $column = 'D';
                foreach($question_list as $item) {
                    $column++;

                    $sheetDetails->setCellValue($column.$index, $item['answer']);

                }
            }
        }


        $sheetDetails->setTitle($sheetName);;
        return $sheetDetails;
    }
}
?>
