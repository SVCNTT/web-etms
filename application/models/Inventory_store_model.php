<?php

class Inventory_store_model extends MY_Model
{
    public $strikeforce;

    public function __construct()
    {

        $this->strikeforce = $this->load->database(DATABASE_NAME, TRUE);
    }


    public function insert($data) {
        $this->strikeforce->insert('inventory_store',$data);
    }


    /**
     * Inventory controller
     * @param $imagePath
     * @param $file_name
     * @return string
     */
    public function import($imagePath, $file_name)
    {
        try {

            $store_miss = '';

            $this->load->library('importexcel/FileManagerImport');
            $this->filemanagerimport->getSheets($imagePath);
            $Reader = $this->filemanagerimport->Reader;
            $Sheets = $Reader->Sheets();

            foreach ($Sheets as $Index => $Name) {
                if ($Index == 0) {
                    $Reader->ChangeSheet($Index);

                    $profileId = get_current_profile();

                    //Get all store
                    $this->load->model('store_model');
                    $all_store = $this->store_model->getAllStoreForImportInventory();


//                    $import_date = strtotime("-1 day");  //Auto import: -1 day

                    $import_date = time();  //Manual import: get current day

                    //Check first time
                    $month = date('Ym', $import_date);
                    $is_exist_month = $this->checkExistMonth($month);
//                    var_dump($is_exist_month);exit;

                    $todate = date('Ymd', $import_date);
                    if ($is_exist_month == 0) {
                        $todate = date('Ym', $import_date);
                    }
//                    var_dump($todate);exit;
//                    $todate = '201710';

                    $index_column_store_code = 0;
                    $index_column_product_code = 0;
                    $index_column_product_name = 0;
                    $index_column_product_hierarchy = 0;
                    $index_column_sale_price = 0;
                    $index_column_sale_in = 0;
                    $index_column_invoice_confirmed = 0;
                    $index_column_customer_local_group_1 = 0;

                    foreach ($Reader as $rowIndex => $Row) {

                        if ($rowIndex == 5) {
                            foreach ($Row as $indexColumn => $value) {
                                switch (trim($value)) {
                                    case 'Customer Code':
                                        $index_column_store_code = $indexColumn;
                                        break;

                                    case 'ZP Item Code':
                                        $index_column_product_code = $indexColumn;
                                        break;

                                    case 'Item Description':
                                        $index_column_product_name = $indexColumn;
                                        break;

                                    case 'Product Hierarchy':
                                        $index_column_product_hierarchy = $indexColumn;
                                        break;

                                    case 'Selling Price':
                                        $index_column_sale_price = $indexColumn;
                                        break;

                                    case 'Commercial Quantity':
                                        $index_column_sale_in = $indexColumn;
                                        break;

                                    case 'Invoice Confirmed Date':
                                        $index_column_invoice_confirmed = $indexColumn;
                                        break;

                                    case 'Customer Local Group 1':
                                        $index_column_customer_local_group_1 = $indexColumn;
                                        break;

                                    default:
                                        break;
                                }
                            }
                        }

                        if ($rowIndex > 5) { //bo nhung row ko sai
                            if (empty($Row[0])) {
                                continue;
                            }

                            $data_inventory_store = array();
                            $data_inventory_store_detail = array();

                            $invoice_confirmed_day = '';
                            $invoice_confirmed_month = '';
                            $invoice_confirmed_year = '';

                            foreach ($Row as $indexColumn => $value) {
								$value = trim($value);
                                switch ($indexColumn) {
                                    case $index_column_store_code:
                                        $data_inventory_store_detail['store_code'] = $value;
                                        break;

                                    case $index_column_product_code:
                                        $data_inventory_store['product_code'] = $value;
                                        break;

                                    case $index_column_product_name:
                                        $data_inventory_store['product_name'] = $value;
                                        break;

                                    case $index_column_product_hierarchy:
                                        $data_inventory_store_detail['product_hierarchy'] = $value;
                                        break;

                                    case $index_column_sale_price:
                                        $data_inventory_store['sale_price'] = $value;
                                        break;

                                    case $index_column_sale_in:
                                        $data_inventory_store['sale_in'] = $value;
                                        break;

                                    case $index_column_invoice_confirmed:
                                        list($invoice_confirmed_day, $invoice_confirmed_month, $invoice_confirmed_year) = explode('/', $value);
                                        break;

                                    case $index_column_customer_local_group_1:
                                        $data_inventory_store_detail['customer_local_group_1'] = $value;
                                        break;

                                    default:
                                        break;
                                }
                            }

                            //Validate data
                            $flag = TRUE;


                            //Check Product Hierarchy
                            $Product_Hierarchy_Allow = array('0000WH', '0000GM');
                            if (!in_array($data_inventory_store_detail['product_hierarchy'], $Product_Hierarchy_Allow)) {
                                $flag = FALSE;
                            }


                            //Check Customer Local Group 1
                            $Custome_Local_Group_1_Allow = array('US', 'YE', 'V7', 'YA');
                            if (!in_array($data_inventory_store_detail['customer_local_group_1'], $Custome_Local_Group_1_Allow)) {
                                $flag = FALSE;
                            }


                            //Check ZP Item Code
                            $ZP_Item_Code_Allow = array(
                                '21085195',
                                '21083861',

                                '21083863',
                                '21083860',

                                '21085209',
                                '21083853',

                                '21083834',
                                '21083854',
                                '21083836',
                                '21083841'
                            );
                            if (!in_array($data_inventory_store['product_code'], $ZP_Item_Code_Allow)) {
                                $flag = FALSE;
                            }


                            //Check Invoice Confirmed Date
                            if ($todate != $invoice_confirmed_year.$invoice_confirmed_month && $todate != $invoice_confirmed_year.$invoice_confirmed_month.$invoice_confirmed_day) {
                                $flag = FALSE;
                            }


                            if ($flag) {
                                if (isset($all_store[$data_inventory_store_detail['store_code']])) {

                                    $store_id = $all_store[$data_inventory_store_detail['store_code']]['store_id'];

                                    $query = $this->strikeforce->get_where('inventory_store', array('store_id' => $store_id, 'product_code' => $data_inventory_store['product_code'], 'month' => date('Ym', $import_date)));
                                    $record_old = $query !== FALSE ? $query->row_array() : NULL;

                                    if (empty($record_old)) {
                                        /* Insert inventory_store */
                                        $data_inventory_store['store_id'] = $store_id;
                                        $data_inventory_store['month'] = date('Ym', $import_date);
                                        $data_inventory_store["cre_func_id"] = 'STO0620';
                                        $data_inventory_store["cre_user_id"] = $profileId["user_id"];
                                        $data_inventory_store['cre_ts'] = date('Y-m-d H:i:s');
                                        $data_inventory_store["mod_func_id"] = 'STO0620';
                                        $data_inventory_store["mod_user_id"] = $profileId["user_id"];
                                        $data_inventory_store['mod_ts'] = date('Y-m-d H:i:s');
                                        $data_inventory_store["version_no"] = DEFAULT_VERSION_NO;
                                        $data_inventory_store["del_flg"] = 0;

                                        $this->strikeforce->insert('inventory_store', $data_inventory_store);
                                        /* Insert inventory_store - END*/

                                        /* Insert/Update inventory_store_detail */
                                        $data_inventory_store_detail["store_id"] = $store_id;
                                        $data_inventory_store_detail["cre_func_id"] = 'STO0620';
                                        $data_inventory_store_detail["cre_user_id"] = $profileId["user_id"];
                                        $data_inventory_store_detail['cre_ts'] = date('Y-m-d H:i:s');
                                        $data_inventory_store_detail["mod_func_id"] = 'STO0620';
                                        $data_inventory_store_detail["mod_user_id"] = $profileId["user_id"];
                                        $data_inventory_store_detail['mod_ts'] = date('Y-m-d H:i:s');
                                        $data_inventory_store_detail["version_no"] = DEFAULT_VERSION_NO;
                                        $data_inventory_store_detail["del_flg"] = 0;

                                        $this->strikeforce->insert_ignore_batch('inventory_store_detail', array($data_inventory_store_detail));


                                        unset($data_inventory_store_detail["cre_func_id"]);
                                        unset($data_inventory_store_detail["cre_user_id"]);
                                        unset($data_inventory_store_detail["cre_ts"]);
                                        unset($data_inventory_store_detail["version_no"]);

                                        $this->strikeforce->update('inventory_store_detail', $data_inventory_store_detail,
                                            array(
                                                'store_id' => $data_inventory_store_detail['store_id']
                                            )
                                        );
                                        /* Insert/Update inventory_store_detail - END */

                                    } else {

                                        $data_inventory_store['sale_in'] += $record_old['sale_in'];
                                        $data_inventory_store["mod_func_id"] = 'STO0620';
                                        $data_inventory_store["mod_user_id"] = $profileId["user_id"];
                                        $data_inventory_store['mod_ts'] = date('Y-m-d H:i:s');
                                        $data_inventory_store["del_flg"] = 0;

                                        $this->strikeforce->update('inventory_store', $data_inventory_store,
                                            array(
                                                'store_id' => $store_id,
                                                'product_code' => $data_inventory_store['product_code'],
                                                'month' => date('Ym', $import_date)
                                            )
                                        );
                                    }

                                } else {

                                    //TODO: write log file...(Ghi lại những store đang không có trong hệ thống)
                                    $store_miss .= $data_inventory_store_detail['store_code'] . PHP_EOL;

                                }
                            }
                        }
                    }
                }
            }

            if (!empty($store_miss)) {

                $file_handle = fopen(APPPATH . "logs/" . date('Ymd') . "_store_miss.txt", "a");
//                var_dump($file_handle);
                fwrite($file_handle, $store_miss);
                fclose($file_handle);
            }

        } catch (Exception $e) {
            return "Please contact administrator. [" . $e->getMessage() . "]";
        }

        return "OK";
    }


    private function checkExistMonth($month) {
        $query = $this->strikeforce->get_where('inventory_store', array('month' => $month));

        return $query != FALSE ? count($query->result_array()) : 0;
    }


    /**
     * API inventory controller
     * @param $store_id
     * @return bool
     */
    public function getAllByStoreId($store_id)
    {
        $this->strikeforce->select(' DISTINCT product_code, product_name', FALSE);
        $arr_condition = array('store_id' => $store_id);

        $query = $this->strikeforce->get_where('inventory_store', $arr_condition);

        return $query !== FALSE ? $query->result_array() : FALSE;
    }


    /**
     * API inventory controller
     * @param $store_id
     * @return bool
     */
    public function getProductInfo($store_id, $product_code, $month)
    {
        $arr_condition = array('store_id' => $store_id, 'product_code' => $product_code, 'month' => $month);
        $this->strikeforce->where($arr_condition);

        $this->strikeforce->order_by('month', 'DESC');

        $query = $this->strikeforce->get('inventory_store');

        return $query !== FALSE ? $query->row_array() : FALSE;
    }


    /**
     * API inventory controller
     * @param $store_id
     * @return bool
     */
    public function getOldProductInfo($store_id, $product_code, $month = '')
    {
        $arr_condition = array('store_id' => $store_id, 'product_code' => $product_code);

        if (!empty($month)) {
            $arr_condition['month <'] = $month;
            $arr_condition['sale_in !='] = 0;
        }

        $this->strikeforce->where($arr_condition);

        $this->strikeforce->order_by('month', 'DESC');

        $query = $this->strikeforce->get('inventory_store');

        return $query !== FALSE ? $query->row_array() : FALSE;
    }


    /**
     * API inventory controller
     * @param $data
     * @param $inventory_store_id
     * @return mixed
     */
    public function update($data, $inventory_store_id)
    {
        return $this->strikeforce->update('inventory_store', $data,
            array(
                'inventory_store_id' => $inventory_store_id,
            )
        );
    }
}

?>
