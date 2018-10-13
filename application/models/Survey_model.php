<?php

class Survey_model extends MY_Model
{
    public $strikeforce;

    public function __construct()
    {
        $this->strikeforce = $this->load->database(DATABASE_NAME, TRUE);
    }


    /**
     * Store_survey controller
     * @param $params
     * @return mixed
     */
    public function searchSurveyByName($params)
    {
        $this->strikeforce->select('surveys.*, MD5(CONCAT(surveys.`id`,\'_'.SECRECT_KEY_SURVEY.'\')) as token, product_survey.product as product');
        $this->strikeforce->from('surveys');
        $this->strikeforce->join('product_survey', 'product_survey.id = surveys.product_id AND product_survey.del_flg != 1', 'LEFT');
        $this->strikeforce->where('surveys.del_flg != ', 1);
        $this->strikeforce->order_by('surveys.cre_ts DESC, surveys.name ASC');

        $surveyName = isset($params["surveyName"]) ? $params["surveyName"] : '';
        if (!empty($surveyName)) {
            $this->strikeforce->like('surveys.name', $surveyName);
        }
        $limit = isset($params['limit']) ? $params['limit'] : NULL;
        $offset = isset($params['offset']) ? $params['offset'] : NULL;
        if ($limit !== NULL && $offset !== NULL) {
            $this->strikeforce->limit($limit, $offset);
        }

        $query = $this->strikeforce->get();
        return $query->result_array();
    }

    /**
     * Call record controller
     * @param $params
     * @return mixed
     */
    public function countSurveyByName($params)
    {
        $this->strikeforce->select('*');
        $this->strikeforce->from('surveys');
        $this->strikeforce->where('del_flg != ', 1);

        $surveyName = isset($params["surveyName"]) ? $params["surveyName"] : '';
        if (!empty($surveyName)) {
            $this->strikeforce->like('name', $surveyName);
        }
        return $this->strikeforce->count_all_results();
    }


    /**
     * Store_survey Controller
     * @param $imagePath
     * @param $file_name
     * @return string
     */
    public function import($imagePath, $file_name)
    {
        try {
            $this->load->library('importexcel/FileManagerImport');
            $this->filemanagerimport->getSheets($imagePath);
            $Reader = $this->filemanagerimport->Reader;
            $Sheets = $Reader->Sheets();

            foreach ($Sheets as $Index => $Name) {
                if ($Index == 0) {
                    $Reader->ChangeSheet($Index);

                    $name = '';
                    $product_id = '';
                    $questions = array();
                    $question_id = 1;

                    $this->load->model('product_survey_model');
                    $profile = get_current_profile();

                    foreach ($Reader as $rowIndex => $Row) {

                        /*Get survey name*/
                        if ($rowIndex === 0) {
                            $name = $Row[0];
                        }
                        /*Get survey name - END*/


                        /*Get product*/
                        if ($rowIndex === 2) {
                            $product = $Row[0];

                            $product_info = $this->product_survey_model->getByName($product);

                            if (!empty($product_info)) {
                                $product_id = $product_info['id'];
                            } else {

                                $product_info = array(
                                    "product" => $product,
                                    "cre_func_id" => 'STO0510',
                                    "mod_func_id" => 'STO0510',
                                    "cre_user_id" => $profile["user_id"],
                                    "mod_user_id" => $profile["user_id"],
                                    "version_no" => DEFAULT_VERSION_NO,
                                    "del_flg" => 0
                                );

                                $product_id = $this->product_survey_model->insert($product_info);
                            }
                        }
                        /*Get product - END*/

                        if ($rowIndex > 1 && !empty($Row[1])) {
                            $questions[] = array(
                                'id'    =>  $question_id++,
                                'content'   =>  $Row[1]
                            );
                        }
                    }

                    $insert_data = array(
                        'name'      =>  $name,
                        'product_id' =>  $product_id,
                        'questions' =>  json_encode($questions),
                        'status'    =>  SURVEY_STATUS_DISABLE,
                        'cre_func_id'   =>  'STO0510',
                        'cre_user_id'   =>  $profile["user_id"],
                        'mod_func_id'   =>  'STO0510',
                        'mod_user_id'   =>  $profile["user_id"],
                        'version_no'    =>  DEFAULT_VERSION_NO,
                        'del_flg'       =>  0,
                    );

                    $this->strikeforce->query("SET NAMES utf8");
                    $this->strikeforce->trans_start();
                    $rs = $this->strikeforce->insert('surveys', $insert_data);
                    $insert_id = $this->strikeforce->insert_id();
                    $this->strikeforce->trans_complete();

                    if ($rs == TRUE) {
                        /*Create table answer*/
                        $sql = '
                            CREATE TABLE `survey_answers_'.$insert_id.'` (
                              `id` bigint(20) NOT NULL AUTO_INCREMENT,
                              `store_id` bigint(20) DEFAULT NULL,
                              `store_code` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
                              `salesman_id` bigint(20) DEFAULT NULL,
                              `salesman_code` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
                              `answer` text COLLATE utf8_unicode_ci,
                              `cre_func_id` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
                              `cre_ts` timestamp NULL DEFAULT NULL,
                              `cre_user_id` bigint(20) DEFAULT NULL,
                              `mod_func_id` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
                              `mod_ts` timestamp NULL DEFAULT NULL,
                              `mod_user_id` bigint(20) DEFAULT NULL,
                              `version_no` bigint(20) DEFAULT NULL,
                              `del_flg` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
                              PRIMARY KEY (`id`),
                              UNIQUE KEY `UNIQUE_GROUP` (`store_id`,`salesman_id`),
                              KEY `STORE_ID` (`store_id`),
                              KEY `SALESMAN_ID` (`salesman_id`),
                              KEY `STORE_CODE` (`store_code`),
                              KEY `SALESMAN_CODE` (`salesman_code`)
                            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
                        ';
                        $this->strikeforce->query($sql);
                        /*Create table answer - END*/
                    }
                }
            }
        } catch (Exception $e) {
//            echo 'Caught exception: ', $e->getMessage(), "\n";
            return "Please contact administrator. [".$e->getMessage()."]";
        }

        return RES_OK;
    }


    public function activeSurvey($survey_id, $status, $profile)
    {

        $this->strikeforce->where(array('id' => $survey_id, 'del_flg != ' => 1));
        $data = array(
            'status' => $status,
            'mod_func_id'   =>  'STO0515',
            'mod_ts'    =>  date('Y-m-d H:i:s'),
            'mod_user_id'   =>  $profile["user_id"],
        );
        $rs = $this->strikeforce->update('surveys', $data);

        return $rs == TRUE ? RES_OK : RES_NG;
    }


    public function deleteSurvey($survey_id, $profile)
    {

        $this->strikeforce->where(array('id' => $survey_id));
        $data = array(
            'del_flg' => 1,
            'mod_func_id'   =>  'STO0516',
            'mod_ts'    =>  date('Y-m-d H:i:s'),
            'mod_user_id'   =>  $profile["user_id"],
        );
        $rs = $this->strikeforce->update('surveys', $data);

        return $rs == TRUE ? RES_OK : RES_NG;
    }


    public function getQuestionBySurveyId($survey_id)
    {
        $query = $this->strikeforce->get_where('surveys', array('id' => $survey_id, 'del_flg != ' => 1));
        return $query !== FALSE ? $query->row_array() : NULL;
    }


    public function getSurveyByListProductId($product_list)
    {
        $sql = 'SELECT s.*, ps.product
                FROM `surveys` s
                INNER JOIN product_survey ps ON ps.id = s.product_id AND ps.del_flg != 1
                WHERE s.`product_id` IN (' . $product_list . ') AND s.`status` = 1 AND s.`del_flg` != 1
                ORDER BY s.`name` ASC';

        $rs = $this->strikeforce->query($sql);

        return $rs != FALSE ? $rs->result_array() : array();
    }


    public function saveSurvey($survey_id, $input)
    {
        return $this->strikeforce->replace('`survey_answers_'.$survey_id.'`', $input);
    }


    public function surveyOverview($param)
    {
        $dataResult = array(
            'salInfo' => NULL,
            'pagingInfo' => NULL
        );

        $curr_user = isset($param['curr_user']) ? $param['curr_user'] : NULL;

        /*Get MR by current user - Begin*/
        $this->load->model('saleman_model');
        $mr_list = $this->saleman_model->selectMRByRole($curr_user);
        $arr_mr_id = " ('-1'";
        if (!empty($mr_list)) {
            foreach ($mr_list as $temp) {
                $arr_mr_id = $arr_mr_id . ',' . strval($temp['salesman_id']);
            }
        }
        $arr_mr_id = $arr_mr_id . " ,'-1')";
        /*Get MR by current user - End*/

        $paramInput = isset($param["searchInput"]) ? $param["searchInput"] : array();
        $sSQLContinute = "";

        $sSQLCount = "  SELECT count(DISTINCT sa.salesman_id) as totalRow
                        FROM  salesman as sa
                        ";
        $sSQL = "  SELECT DISTINCT
									sa.salesman_id as salesmanId
									, sa.salesman_code as salesmanCode
									, sa.salesman_name as salesmanName
                    FROM salesman as sa
                    ";

        $sSQLWhere = " WHERE sa.salesman_id in " . $arr_mr_id . " and sa.del_flg != '1' ";

        if (isset($paramInput["salesmanName"]) && !is_null($paramInput["salesmanName"]) && !empty($paramInput["salesmanName"])) {
            $sSQLWhere .= " and  UPPER(sa.salesman_name) like '%" . strtoupper($paramInput["salesmanName"]) . "%'";
        }
        if (isset($paramInput["salesmanCode"]) && !is_null($paramInput["salesmanCode"]) && !empty($paramInput["salesmanCode"])) {
            $sSQLWhere .= " and  UPPER(sa.salesman_code) like '%" . strtoupper($paramInput["salesmanCode"]) . "%'";
        }

        $query = $this->strikeforce->query($sSQLCount . $sSQLContinute . $sSQLWhere);

        if ($query->row()->totalRow > 0) {
            $curr_page = isset($param["pagingInfo"]["crtPage"]) ? $param["pagingInfo"]["crtPage"] : 1;
            $pagingSet = $this->setPagingInfo($query->row()->totalRow, $curr_page);
            $sSQL .= $sSQLContinute . $sSQLWhere . " order by sa.salesman_name  limit " . ROW_ON_PAGE . " offset " . ($pagingSet["stRow"] - 1);

            $query = $this->strikeforce->query($sSQL);

            $dataResult["salInfo"] = $query != FALSE ? $query->result_array() : array();
            $dataResult["pagingInfo"] = $pagingSet;
        }

        return $dataResult;
    }
}
