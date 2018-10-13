<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_inventory extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index($salesman_id, $store_id, $timestamp)
    {
        $result = array(
            'returnCd' => NULL,
            'returnMsg' => NULL,
            'serverTime' => (new DateTime())->getTimestamp() * 1000,
            'proResFlg' => RES_NG,
            'data' => array(),
        );


        switch ($this->input->method(TRUE)) {
            case 'GET':
                $result = $this->index_get($salesman_id, $store_id, $timestamp);
                break;


            case 'POST':
                $result = $this->index_post($salesman_id, $store_id, $timestamp);
                break;
        }


        return $this->return_json($result);
    }


    private function index_get($salesman_id, $store_id, $timestamp) {

        $this->load->model('inventory_store_model');

        $month = intval(date('Ym', $timestamp));

        //Get all products
        $all_products = $this->inventory_store_model->getAllByStoreId($store_id);


        //3 times report inventory per month
        $time_per_month = 3;


        $result_data = array();
        if (!empty($all_products)) {



            $this->load->model('inventory_history_model');

            foreach ($all_products as $item) {

                //Get newest product info
                $data = $this->inventory_store_model->getProductInfo($store_id, $item['product_code'], $month);

                if (empty($data)) {
                    $old_data = $this->inventory_store_model->getOldProductInfo($store_id, $item['product_code']);

                    unset($old_data['inventory_store_id']);
                    $old_data['month'] = $month;
                    $old_data['sale_in'] = 0;
                    $old_data["cre_func_id"] = 'SMF0000';
                    $old_data["cre_user_id"] = $salesman_id;
                    $old_data['cre_ts'] = date('Y-m-d H:i:s');
                    $old_data["mod_func_id"] = 'SMF0000';
                    $old_data["mod_user_id"] = $salesman_id;
                    $old_data['mod_ts'] = date('Y-m-d H:i:s');
                    $old_data["version_no"] = DEFAULT_VERSION_NO;
                    $old_data["del_flg"] = 0;

                    $this->inventory_store_model->insert($old_data);

                    $data = $this->inventory_store_model->getProductInfo($store_id, $item['product_code'], $month);
                }

                $histories = $this->inventory_history_model->getByStoreIDAndSalesmanID($data['inventory_store_id'], $salesman_id);

                $stock = array();
                $plan = array();
                $stock_current = NULL;
                if (!empty($histories)) {

                    $histories['data'] = json_decode($histories['data'], TRUE);

					$timer = 0;
                    foreach($histories['data'] as $key => $history) {
						if ($timer < $time_per_month) {
							$timer++;
                            $stock[$key] = $history['stock'] === NULL ? NULL : intval($history['stock']);
                            $plan[$key] = $history['plan'] === NULL ? NULL : intval($history['plan']);
                        }
                    }
                }

                $stock_obj = array();
                ksort($stock);
                foreach ($stock as $key => $value) {
                    $stock_obj[] = array(
                        'timestamp' => $key,
                        'value' => $value,
                    );

                    //Update sales out
                    $stock_current = $value !== NULL ? $value : $stock_current;
                }

                $plan_obj = array();
                ksort($plan);
                foreach ($plan as $key => $value) {
                    $plan_obj[] = array(
                        'timestamp' => $key,
                        'value' => $value,
                    );
                }

                //Get old stock
                $data_prev = $this->inventory_store_model->getOldProductInfo($store_id, $item['product_code'], $month);
                $old_stock = "0";

                if (!empty($data_prev)) {
                    $histories_old = $this->inventory_history_model->getByStoreIDAndSalesmanID($data_prev['inventory_store_id'], $salesman_id);
                    $old_stock = !empty($histories_old) ? $histories_old['stock'] : "0";
                }


                $result_data[] = array(
                    'inventoryStoreId' => intval($data['inventory_store_id']),
                    'productId' => $data['product_code'],
                    'productionName' => $data['product_name'],
                    'oldStock' => $old_stock,
                    'netSales' => intval($data['sale_in']),
                    'netValues' => $data['sale_in'] * $data['sale_price'],
                    'salesOut' => $stock_current == NULL ? 0 : (intval($old_stock) + intval($data['sale_in']) - intval($stock_current)),
                    'inventory' => $stock_obj,
                    'planOrders' => $plan_obj,
                );
            }
        }


        $result = array(
            'returnCd' => NULL,
            'returnMsg' => NULL,
            'serverTime' => (new DateTime())->getTimestamp() * 1000,
            'proResFlg' => RES_OK,
            'data' => $result_data,
        );

        return $result;
    }


    private function index_post($salesman_id) {

        /*Get params - Begin*/
        $post = $this->input->post(NULL, TRUE);

        $post = isset($post['paramJson']) ? json_decode($post['paramJson'], true) : array();
        $data = isset($post['data']) ? $post['data'] : array();


        if (!empty($data) && !empty($salesman_id)) {

            $this->load->model('inventory_history_model');

            foreach ($data as $item) {

                $data_history = array();
                $stock = NULL;
                foreach ($item['inventory'] as $key => $value) {

                    $data_history[$value['timestamp']] = array(
                        'stock' => $value['value'],
                        'plan' => $item['planOrders'][$key]['value'],
                    );

                    //Update sales out
                    $stock = $value['value'] !== NULL ? $value['value'] : $stock;
                }


                //Insert inventory history
                $data = array(
                    'inventory_store_id' => $item['inventoryStoreId'],
                    'salesman_id' => $salesman_id,
                    'stock' => $stock,
                    'data' => json_encode($data_history),
                    'cre_func_id' => 'SMF0000',
                    'cre_user_id' => $salesman_id,
                    'cre_ts' => date('Y-m-d H:i:s'),
                    'mod_func_id' => 'SMF0000',
                    'mod_user_id' => $salesman_id,
                    'mod_ts' => date('Y-m-d H:i:s'),
                    'version_no' => DEFAULT_VERSION_NO,
                    'del_flg' => 0,
                );

                $this->inventory_history_model->insert_ignore($data);


                //Update invnetory history
                isset($data['cre_func_id']);
                isset($data['cre_user_id']);
                isset($data['cre_ts']);
                isset($data['version_no']);
                isset($data['del_flg']);

                $this->inventory_history_model->update($data, $item['inventoryStoreId'], $salesman_id);

            }
        }


        $result = array(
            'returnCd' => NULL,
            'returnMsg' => NULL,
            'serverTime' => (new DateTime())->getTimestamp() * 1000,
            'proResFlg' => RES_OK,
        );

        return $result;
    }
}
