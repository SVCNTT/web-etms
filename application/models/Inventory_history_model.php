<?php

class Inventory_history_model extends MY_Model
{
    public $strikeforce;

    public function __construct()
    {
        $this->strikeforce = $this->load->database(DATABASE_NAME, TRUE);
    }


    /**
     * API inventory controller
     * @param $data
     */
    public function insert_ignore($data)
    {
        $this->strikeforce->insert_ignore_batch('inventory_history', array($data));
    }


    /**
     * API inventory controller
     * @param $data
     * @param $inventory_store_id
     * @param $saleman_id
     * @param $day
     * @return mixed
     */
    public function update($data, $inventory_store_id, $saleman_id)
    {
        return $this->strikeforce->update('inventory_history', $data,
            array(
                'inventory_store_id' => $inventory_store_id,
                'salesman_id' => $saleman_id,
            )
        );
    }


    /**
     * API inventory controller
     * @param $inventory_store_id
     * @param $salesman_id
     * @return bool
     */
    public function getByStoreIDAndSalesmanID($inventory_store_id, $salesman_id) {

        $query = $this->strikeforce->get_where('inventory_history', array('inventory_store_id' => $inventory_store_id, 'salesman_id' => $salesman_id));

        return $query !== FALSE ? $query->row_array() : FALSE;
    }


    /*
     * Inventory controller
     */
    public function create_excel_file_rp($month, $path, $curr_user)
    {
        $this->load->library('importexcel/FileManagerExport');

        $cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
        $cacheSettings = array('memoryCacheSize' => '2048MB');
        PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);

        $objPHPExcel = new PHPExcel();

        /*Get data*/

        $this->strikeforce->select('
                                    sm.salesman_code as salesman_code,
                                    sm.salesman_name as salesman_name,
                                    sm.email as email,
                                    CONCAT(u_m_p.last_name, " ", u_m_p.first_name) as sales_manager,
                                    CONCAT(u_m.last_name, " ", u_m.first_name) as regional_manager,
                                    i_s_d.customer_local_group_1 as customer_local_group_1,
                                    zo.zone_name as zone_name,
                                    st.store_code as store_code,
                                    CASE WHEN  st.doctor_name = \'\' THEN st.store_name ELSE st.doctor_name END AS store_name,
                                    st.address as address,
                                    apr.area_name as area_name,
                                    ar.area_name as territory,
                                    i_s_d.product_hierarchy as product_hierarchy,
                                    i_s.product_code as product_code,
                                    i_s.product_name as product_name,
                                    i_s.sale_in as total_net_qty,
                                    i_s.sale_price as sale_price,
                                    i_h.stock as stock,
                                    i_h.data as other_data
                                    ', FALSE
        );

        $this->strikeforce->join('inventory_store i_s', 'i_s.inventory_store_id = i_h.inventory_store_id AND i_s.del_flg = 0 AND i_s.month = "' . $month . '"', 'inner');
        $this->strikeforce->join('store st', 'st.store_id = i_s.store_id AND st.del_flg = 0', 'inner');
        $this->strikeforce->join('inventory_store_detail i_s_d', 'i_s_d.store_id = i_s.store_id AND i_s_d.del_flg = 0', 'left');
        $this->strikeforce->join('salesman sm', 'sm.salesman_id = i_h.salesman_id AND sm.del_flg = 0', 'inner');
        $this->strikeforce->join('user_salesman u_s', 'u_s.salesman_id = sm.salesman_id AND u_s.del_flg = 0', 'left');
        $this->strikeforce->join('user_mst u_m', 'u_m.user_id = u_s.sub_leader_user_id AND u_m.del_flg = 0', 'left');
        $this->strikeforce->join('user_mst u_m_p', 'u_m_p.user_id = u_m.parent_id AND u_m_p.del_flg = 0', 'left');
        $this->strikeforce->join('area ar', 'ar.area_id = st.area_id AND ar.del_flg = 0', 'left');
        $this->strikeforce->join('area apr', 'apr.area_id = st.area_parent_id AND apr.del_flg = 0', 'left');
        $this->strikeforce->join('zone zo', 'zo.zone_id = st.zone_id AND zo.del_flg = 0', 'left');


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
                    $arr_mr_id = array();
                    if (!empty($mr_list)) {
                        foreach ($mr_list as $temp) {
                            $arr_mr_id[] = strval($temp['salesman_id']);
                        }
                    }
                    /*Get MR by current user - End*/

                    $this->strikeforce->where_in('i_h.salesman_id', $arr_mr_id);
                    break;
            }
        }


        $query = $this->strikeforce->get('inventory_history i_h');
        $data = $query !== FALSE ? $query->result_array() : FALSE;

        $sheetDetails = $objPHPExcel->getActiveSheet(1);
        $this->buildExcel($sheetDetails, $data);
        /*Get data - END*/

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save($path);
    }


    /*
     * Inventory controller
     */
    private function buildExcel($sheetDetails, $data, $sheetName = 'Inventory History')
    {
        //set header
        $sheetDetails->setCellValue('A1', 'MR code');
        $sheetDetails->mergeCells('A1:A2');
        $sheetDetails->setCellValue('B1', 'MR Name');
        $sheetDetails->mergeCells('B1:B2');
        $sheetDetails->setCellValue('C1', 'Email');
        $sheetDetails->mergeCells('C1:C2');
        $sheetDetails->setCellValue('D1', 'Sales Manager');
        $sheetDetails->mergeCells('D1:D2');
        $sheetDetails->setCellValue('E1', 'Regional Manager');
        $sheetDetails->mergeCells('E1:E2');
        $sheetDetails->setCellValue('F1', 'Customer Local Group 1');
        $sheetDetails->mergeCells('F1:F2');
        $sheetDetails->setCellValue('G1', 'State');
        $sheetDetails->mergeCells('G1:G2');
        $sheetDetails->setCellValue('H1', 'Customer code');
        $sheetDetails->mergeCells('H1:H2');
        $sheetDetails->setCellValue('I1', 'Customer Name');
        $sheetDetails->mergeCells('I1:I2');
        $sheetDetails->setCellValue('J1', 'Customer Address 1');
        $sheetDetails->mergeCells('J1:J2');
        $sheetDetails->setCellValue('K1', 'Area');
        $sheetDetails->mergeCells('K1:K2');
        $sheetDetails->setCellValue('L1', 'Territory');
        $sheetDetails->mergeCells('L1:L2');
        $sheetDetails->setCellValue('M1', 'Product Hierarchy');
        $sheetDetails->mergeCells('M1:M2');
        $sheetDetails->setCellValue('N1', 'ZP Item Code');
        $sheetDetails->mergeCells('N1:N2');
        $sheetDetails->setCellValue('O1', 'Item Description');
        $sheetDetails->mergeCells('O1:O2');
        $sheetDetails->setCellValue('P1', 'Total Net Qty');
        $sheetDetails->mergeCells('P1:P2');
        $sheetDetails->setCellValue('Q1', 'Total Net Sales Value');
        $sheetDetails->mergeCells('Q1:Q2');
        $sheetDetails->setCellValue('R1', 'Total sales out Qty');
        $sheetDetails->mergeCells('R1:R2');
        $sheetDetails->setCellValue('S1', 'Plan orders');
        $sheetDetails->mergeCells('S1:U1');
        $sheetDetails->setCellValue('S2', 'F1');
        $sheetDetails->setCellValue('T2', 'F2');
        $sheetDetails->setCellValue('U2', 'F3');


        if (!empty($data)) {
            foreach ($data as $k => $c) {
                $index = $k + 3;

                $sheetDetails->setCellValue('A' . $index, $c['salesman_code']);
                $sheetDetails->setCellValue('B' . $index, $c['salesman_name']);
                $sheetDetails->setCellValue('C' . $index, $c['email']);
                $sheetDetails->setCellValue('D' . $index, $c['sales_manager']);
                $sheetDetails->setCellValue('E' . $index, $c['regional_manager']);
                $sheetDetails->setCellValue('F' . $index, $c['customer_local_group_1']);
                $sheetDetails->setCellValue('G' . $index, $c['zone_name']);
                $sheetDetails->setCellValue('H' . $index, $c['store_code']);
                $sheetDetails->setCellValue('I' . $index, $c['store_name']);
                $sheetDetails->setCellValue('J' . $index, $c['address']);
                $sheetDetails->setCellValue('K' . $index, $c['area_name']);
                $sheetDetails->setCellValue('L' . $index, $c['territory']);
                $sheetDetails->setCellValue('M' . $index, $c['product_hierarchy']);
                $sheetDetails->setCellValue('N' . $index, $c['product_code']);
                $sheetDetails->setCellValue('O' . $index, $c['product_name']);
                $sheetDetails->setCellValue('P' . $index, $c['total_net_qty']);
                $sheetDetails->setCellValue('Q' . $index, $c['total_net_qty'] * $c['sale_price']);
                $sheetDetails->setCellValue('R' . $index, $c['total_net_qty'] - $c['stock']);

                $c['other_data'] = json_decode($c['other_data'], TRUE);
                $temp = array();
                foreach ($c['other_data'] as $k => $v) {
                    $temp[] = $v['plan'];
                }

                $sheetDetails->setCellValue('S' . $index, isset($temp[0]) ? $temp[0] : NULL);
                $sheetDetails->setCellValue('T' . $index, isset($temp[1]) ? $temp[1] : NULL);
                $sheetDetails->setCellValue('U' . $index, isset($temp[2]) ? $temp[2] : NULL);
            }
        }


        $sheetDetails->setTitle($sheetName);;
        return $sheetDetails;
    }


    /**
     * Inventory controller
     * @param $param
     */
    public function searchData($param) {

        $p = isset($param["searchInput"]) ? $param["searchInput"] : array();

        $month = isset($p['currentMonth']) ? $p['currentMonth'] : date('m-Y');
        $month = explode('-', $month);

        if ($month[0] < 10) {
            $month[0] = "0".$month[0];
        }
//        var_dump($month);exit;

        /*Get data*/
        $this->strikeforce->select('
                                    zo.zone_id as zone_id,
                                    zo.zone_name as zone_name,
                                    i_s.product_code as product_code,
                                    i_s.product_name as product_name,
                                    SUM(i_s.sale_in) as sales_in,
                                    IFNULL(SUM(IFNULL(i_h.stock, i_s.sale_in)), 0) as stock
                                    ', FALSE
        );


        $this->strikeforce->join('inventory_history i_h', 'i_h.inventory_store_id = i_s.inventory_store_id AND i_h.del_flg = 0', 'left');
        $this->strikeforce->join('store st', 'st.store_id = i_s.store_id AND st.del_flg = 0', 'inner');
        $this->strikeforce->join('zone zo', 'zo.zone_id = st.zone_id AND zo.del_flg = 0', 'inner');



        if (isset($p['regionalManagerId']) && $p['regionalManagerId'] != 0) {
            $this->strikeforce->join('salesman sm', 'sm.salesman_id = i_h.salesman_id AND sm.del_flg = 0', 'inner');
            $this->strikeforce->join('user_salesman u_s', 'u_s.salesman_id = sm.salesman_id AND u_s.del_flg = 0', 'inner');
            $this->strikeforce->join('user_mst u_m', 'u_m.user_id = u_s.sub_leader_user_id AND u_m.user_id = ' . $p['regionalManagerId'] . ' AND u_m.del_flg = 0', 'inner');
        } else if (isset($p['salesManagerId']) & $p['salesManagerId'] != 0) {
            $this->strikeforce->join('salesman sm', 'sm.salesman_id = i_h.salesman_id AND sm.del_flg = 0', 'inner');
            $this->strikeforce->join('user_salesman u_s', 'u_s.salesman_id = sm.salesman_id AND u_s.del_flg = 0', 'left');
            $this->strikeforce->join('user_mst u_m', 'u_m.user_id = u_s.sub_leader_user_id AND u_m.del_flg = 0', 'left');
            $this->strikeforce->join('user_mst u_m_p', 'u_m_p.user_id = u_m.parent_id AND u_m.user_id = ' . $p['salesManagerId'] . ' AND u_m_p.del_flg = 0', 'left');
        } else {
            $this->strikeforce->join('salesman sm', 'sm.salesman_id = i_h.salesman_id AND sm.del_flg = 0', 'left');
        }


        $this->strikeforce->group_by(array("product_code", "zone_id"));

        $query = $this->strikeforce->get_where('inventory_store i_s', array('i_s.month' => $month[1].$month[0], 'i_s.del_flg' => '0'));
        $data = $query !== FALSE ? $query->result_array() : FALSE;
        /*Get data - END*/

        $temp = NULL;
        $product_list = array();
        $zone_list = array();
        $inventory_total = array();
        $zone_default = 0;
        if (!empty($data)) {
            $temp = array();
            foreach ($data as $item) {

                $item['sales_out'] = $item['sales_in'] - $item['stock'];
                $item['zone_id'] = isset($item['zone_id']) ? intval($item['zone_id']) : 0;

                $temp[$item['product_code']][$item['zone_id']] = $item;
                $product_list[$item['product_code']] = $item['product_name'];
                $zone_list[$item['zone_id']] = $item['zone_name'];


                //Calculator total
                $inventory_total[$item['product_code']] = array(
                    'total_in' => isset($inventory_total[$item['product_code']]['total_in']) ? $inventory_total[$item['product_code']]['total_in'] + $item['sales_in'] : $item['sales_in'],
                    'total_out' => isset($inventory_total[$item['product_code']]['total_out']) ? $inventory_total[$item['product_code']]['total_out'] + $item['sales_out'] : $item['sales_out']
                );

                $zone_default = $item['zone_id'] !== 0 ? $item['zone_id'] : $zone_default;
            }

        }

        $result['productList'] = $product_list;
        $result['zoneList'] = $zone_list;
        $result['inventoryInfo'] = $temp;
        $result['inventoryTotal'] = $inventory_total;
        $result['zoneDefault'] = $zone_default;

        return $result;

    }
}