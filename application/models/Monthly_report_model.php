<?php

class Monthly_report_model extends MY_Model
{
	public $strikeforce;

    public function __construct()
    {
		$this->strikeforce = $this->load->database ( DATABASE_NAME, TRUE );
	}

    /**
     * Monthly_reports controller
     * @param $export_date
     * @return mixed
     */
    public function buildDatabaseExport($export_date, $bu)
    {
		
        $bu_sql = '';
        if (intval($bu) != 0) {
            $bu_sql = " AND ptmst.product_type_id = ".intval($bu)." ";
        }

		// Days/month
        $daysMonth = $this->buildColumnDaysMonth($export_date);
		
        $weeklyOff = $this->buildColumnWeeklyOff($export_date);
		
		$sSQL = "  SELECT DISTINCT
						sa.salesman_id as salesmanId
						, sa.salesman_name as salesmanName 
						, z.zone_name as zoneName
						, z.zone_id as zoneId ";
		
		$sSQL .= ", " . $daysMonth ["daysMonth_A"] . " as daysMonth_A ";
		$sSQL .= ", " . $daysMonth ["daysMonth_T"] . " as daysMonth_T ";
		
		$sSQL .= ", NULL as dayWorked_A ";
		$sSQL .= ", NULL as dayWorked_T ";
		
		$sSQL .= ", NULL as holidays_A ";
		$sSQL .= ", kpi.holidays as holidays_T ";
		
		$sSQL .= ", " . $weeklyOff ["weeklyOff_A"] . " as weeklyOff_A ";
		$sSQL .= ", " . $weeklyOff ["weeklyOff_T"] . " as weeklyOff_T ";
		
		$sSQL .= ", NULL as trainingDays_A ";
		$sSQL .= ", kpi.training_days as trainingDays_T ";
		
		$sSQL .= ", NULL as promotionDays_A ";
		$sSQL .= ", kpi.promotion_days as promotionDays_T ";
		
		$sSQL .= ", NULL as meetingDays_A ";
		$sSQL .= ", kpi.meeting_days as meetingDays_T ";
		
		$sSQL .= ", NULL as leaveTaken_A ";
		$sSQL .= ", kpi.leave_taken as leaveTaken_T ";
		
		$sSQL .= ", NULL as dif_A ";
		$sSQL .= ", NULL as dif_T ";
		$sSQL .= ", NULL as dif_P ";
		
		$sSQL .= ", NULL as callRate_A ";
		$sSQL .= ", kpi.call_rate as callRate_T ";
		$sSQL .= ", NULL as callRate_P ";
		
		$sSQL .= ", NULL as callReach_A ";
		$sSQL .= ", NULL as callReach_T ";
		$sSQL .= ", NULL as callReach_P ";
		
		// read
		$sSQL .= ", NULL as totalDrsA_A ";
		$sSQL .= ", NULL as totalDrsA_T ";
		$sSQL .= ", NULL as totalDrsA_P ";
		
		$sSQL .= ", NULL as totalDrsB_A ";
		$sSQL .= ", NULL as totalDrsB_T ";
		$sSQL .= ", NULL as totalDrsB_P ";
		
		$sSQL .= ", NULL as callVolumn_A ";
		$sSQL .= ", NULL as callVolumn_T ";
		$sSQL .= ", NULL as callVolumn_P ";
		
		$sSQL .= ", NULL as volumnA_A ";
		$sSQL .= ", NULL as volumnA_T ";
		$sSQL .= ", NULL as volumnA_P ";
		
		$sSQL .= ", NULL as volumnB_A ";
		$sSQL .= ", NULL as volumnB_T ";
		$sSQL .= ", NULL as volumnB_P ";
		
		$sSQL .= ", NULL as volumnC_A ";
		$sSQL .= ", NULL as volumnC_T ";
		$sSQL .= ", NULL as volumnC_P ";
		
		$sSQL .= ", NULL as callFrequency_A ";
		$sSQL .= ", NULL as callFrequency_T ";
		$sSQL .= ", NULL as callFrequency_P ";
		
		$sSQL .= ", NULL as frequencyA_A ";
		$sSQL .= ", kpi.frequency_1 as frequencyA_T ";
		$sSQL .= ", NULL as frequencyA_P ";
		
		$sSQL .= ", NULL as frequencyB_A ";
		$sSQL .= ", kpi.frequency_2 as frequencyB_T ";
		$sSQL .= ", NULL as frequencyB_P ";
		
		$sSQL .= ", NULL as frequencyC_A ";
		$sSQL .= ", kpi.frequency_3 as frequencyC_T ";
		$sSQL .= ", NULL as frequencyC_P ";
		
		$sSQL .= " FROM salesman as sa
    				INNER JOIN user_salesman us ON (sa.salesman_id = us.salesman_id AND us.del_flg != '1')
    				LEFT JOIN salesman_store ss ON (sa.salesman_id = ss.salesman_id AND ss.del_flg != '1')
    				LEFT JOIN store s ON (ss.store_id = s.store_id AND s.del_flg != '1')
					INNER JOIN zone z ON (s.zone_id = z.zone_id AND z.del_flg != '1')
    				LEFT JOIN user_product_type upt ON (us.sub_leader_user_id = upt.user_id AND upt.del_flg != '1')
    				INNER JOIN product_type_mst ptmst ON (upt.product_type_id = ptmst.product_type_id  ".$bu_sql." AND ptmst.del_flg != '1')
    				LEFT JOIN product_type_kpi kpi ON (kpi.product_type_id = ptmst.product_type_id AND STR_TO_DATE(kpi.times,'%Y-%m') = STR_TO_DATE('" . $export_date . "','%Y-%m') AND kpi.del_flg != '1')
    					 WHERE sa.del_flg != '1'
    					ORDER BY z.zone_id
    					";
		$query = $this->strikeforce->query ( $sSQL );
		$data = $query->result_array ();
        $this->calculateData($data, $export_date);
		
		return $data;
	}
	
    /**
     * Monthly report controller
     * @param $export_date
     * @return mixed
     */
    public function buildDatabaseExportTeams($export_date, $bu)
    {

        $bu_sql = '';
        if (intval($bu) != 0) {
            $bu_sql = " AND ptmst.product_type_id = ".intval($bu)." ";
        }

        // Days/month
        $daysMonth = $this->buildColumnDaysMonth($export_date);
        $weeklyOff = $this->buildColumnWeeklyOff($export_date);

        $sSQL = "  SELECT DISTINCT
						sa.salesman_id as salesmanId
						, sa.salesman_name as salesmanName
						, ptmst.product_type_name as productTypeName
						, 0 as zoneId
						, upt.product_type_id as productTypeId";

        $sSQL .= ", " . $daysMonth ["daysMonth_A"] . " as daysMonth_A ";
        $sSQL .= ", " . $daysMonth ["daysMonth_T"] . " as daysMonth_T ";

        $sSQL .= ", NULL as dayWorked_A ";
        $sSQL .= ", NULL as dayWorked_T ";

        $sSQL .= ", NULL as holidays_A ";
        $sSQL .= ", kpi.holidays as holidays_T ";

        $sSQL .= ", " . $weeklyOff ["weeklyOff_A"] . " as weeklyOff_A ";
        $sSQL .= ", " . $weeklyOff ["weeklyOff_T"] . " as weeklyOff_T ";

        $sSQL .= ", NULL as trainingDays_A ";
        $sSQL .= ", kpi.training_days as trainingDays_T ";

        $sSQL .= ", NULL as promotionDays_A ";
        $sSQL .= ", kpi.promotion_days as promotionDays_T ";

        $sSQL .= ", NULL as meetingDays_A ";
        $sSQL .= ", kpi.meeting_days as meetingDays_T ";

        $sSQL .= ", NULL as leaveTaken_A ";
        $sSQL .= ", kpi.leave_taken as leaveTaken_T ";

        $sSQL .= ", NULL as dif_A ";
        $sSQL .= ", NULL as dif_T ";
        $sSQL .= ", NULL as dif_P ";

        $sSQL .= ", NULL as callRate_A ";
        $sSQL .= ", kpi.call_rate as callRate_T ";
        $sSQL .= ", NULL as callRate_P ";

        $sSQL .= ", NULL as callReach_A ";
        $sSQL .= ", NULL as callReach_T ";
        $sSQL .= ", NULL as callReach_P ";

        // read
        $sSQL .= ", NULL as totalDrsA_A ";
        $sSQL .= ", NULL as totalDrsA_T ";
        $sSQL .= ", NULL as totalDrsA_P ";

        $sSQL .= ", NULL as totalDrsB_A ";
        $sSQL .= ", NULL as totalDrsB_T ";
        $sSQL .= ", NULL as totalDrsB_P ";

        $sSQL .= ", NULL as callVolumn_A ";
        $sSQL .= ", NULL as callVolumn_T ";
        $sSQL .= ", NULL as callVolumn_P ";

        $sSQL .= ", NULL as volumnA_A ";
        $sSQL .= ", NULL as volumnA_T ";
        $sSQL .= ", NULL as volumnA_P ";

        $sSQL .= ", NULL as volumnB_A ";
        $sSQL .= ", NULL as volumnB_T ";
        $sSQL .= ", NULL as volumnB_P ";

        $sSQL .= ", NULL as volumnC_A ";
        $sSQL .= ", NULL as volumnC_T ";
        $sSQL .= ", NULL as volumnC_P ";

        $sSQL .= ", NULL as callFrequency_A ";
        $sSQL .= ", NULL as callFrequency_T ";
        $sSQL .= ", NULL as callFrequency_P ";

        $sSQL .= ", NULL as frequencyA_A ";
        $sSQL .= ", kpi.frequency_1 as frequencyA_T ";
        $sSQL .= ", NULL as frequencyA_P ";

        $sSQL .= ", NULL as frequencyB_A ";
        $sSQL .= ", kpi.frequency_2 as frequencyB_T ";
        $sSQL .= ", NULL as frequencyB_P ";

        $sSQL .= ", NULL as frequencyC_A ";
        $sSQL .= ", kpi.frequency_3 as frequencyC_T ";
        $sSQL .= ", NULL as frequencyC_P ";

        $sSQL .= " FROM salesman as sa
    				INNER JOIN user_salesman us ON (sa.salesman_id = us.salesman_id)
    				LEFT JOIN salesman_store ss ON (sa.salesman_id = ss.salesman_id)
    				LEFT JOIN store s ON (ss.store_id = s.store_id)
    				LEFT JOIN user_product_type upt ON (us.sub_leader_user_id = upt.user_id)
    				INNER JOIN product_type_mst ptmst ON (upt.product_type_id = ptmst.product_type_id ".$bu_sql.")
    				LEFT JOIN product_type_kpi kpi ON (kpi.product_type_id = ptmst.product_type_id AND STR_TO_DATE(kpi.times,'%Y-%m') = STR_TO_DATE('" . $export_date . "','%Y-%m'))
    					 WHERE sa.del_flg != '1'
    					ORDER BY upt.product_type_id
    					";
        $query = $this->strikeforce->query($sSQL);
        $data = $query->result_array();
        $this->calculateData($data, $export_date);

        return $data;
    }

    /**
     * Monthly report controller
     * @param $data
     * @param $export_date
     */
    private function calculateData(&$data, $export_date)
    {
        foreach ($data as &$val) {
            $salesmanLeave = $this->buildColumnSalesmanLeave($val ["salesmanId"], $export_date);
            foreach ($salesmanLeave as $valSales) {
                switch ($valSales["type"]) {
                    case 1:
                        $val ["leaveTaken_A"] = $valSales["leave_total"];
                        break;
                    case 3:
                        $val ["holidays_A"] = $valSales["total"];
                        break;
                    case 4:
                        $val ["trainingDays_A"] = $valSales["total"];
                        break;
                    case 5:
                        $val ["promotionDays_A"] = $valSales["total"];
                        break;
                    case 6:
                        $val ["meetingDays_A"] = $valSales["total"];
                        break;
                }
            }

            // (2)-(6)-(8)
//            if (date('Ym', strtotime($export_date)) > date('Ym')) {
//                $val ["dayWorked_A"] = 0;
//            } else {
//                $next_date = 0;
//                if (date('Ym', strtotime($export_date)) === date('Ym')) {
//                    $next_date = $this->buildNextDays($export_date);
//                }
//
//                $val ["dayWorked_A"] = $val ["daysMonth_A"] - $val ["holidays_A"] - $val ["weeklyOff_A"] - $next_date;
//            }

            $val ["dayWorked_T"] = $val ["daysMonth_T"] - $val ["holidays_T"] - $val ["weeklyOff_T"];

            // dif
            // (3)-(9)-(11)-(13)-(15)
            //$val ["dif_A"] = $val ["dayWorked_A"] - $val ["trainingDays_A"] - $val ["promotionDays_A"] - $val ["meetingDays_A"] - $val ["leaveTaken_A"];
            $val["dif_A"] = $this->buildDIF($export_date, $val['salesmanId']);  //Updated 04/12/2015
            // (4)-(10)-(12)-(14)-(16)
            $val ["dif_T"] = $val ["dayWorked_T"] - $val ["trainingDays_T"] - $val ["promotionDays_T"] - $val ["meetingDays_T"] - $val ["leaveTaken_T"];
            $val ["dif_P"] = $val ["dif_T"] == 0 ? '0%' : round($val ["dif_A"] / $val ["dif_T"] * 100, 2) . "%";

            $val ["dayWorked_A"] = $val ["trainingDays_A"] + $val ["promotionDays_A"] + $val ["meetingDays_A"] + $val["dif_A"]; // Updated 31/01/2016

            $val ["daysMonth_A"] = $val ["dayWorked_A"] + $val ["leaveTaken_A"] + $val ["holidays_A"] + $val ["weeklyOff_A"]; // Updated 31/01/2016

            // Reach
            $reach = $this->buildColumnReach($val ["dayWorked_A"], $val ["dayWorked_T"], "A", $val ["salesmanId"], $val ["dif_A"], $val ["dif_T"], $val['zoneId'], $export_date);
            $val ["totalDrsA_A"] = $reach ["totalDrs_A"];
            $val ["totalDrsA_T"] = $reach ["totalDrs_T"];
            $val ["totalDrsA_P"] = $val ["totalDrsA_T"] == 0 ? '0%' : round($val ["totalDrsA_A"] / $val ["totalDrsA_T"] * 100, 2) . "%";

            $reach = $this->buildColumnReach($val ["dayWorked_A"], $val ["dayWorked_T"], "B", $val ["salesmanId"], $val ["dif_A"], $val ["dif_T"], $val['zoneId'], $export_date);
            $val ["totalDrsB_A"] = $reach ["totalDrs_A"];
            $val ["totalDrsB_T"] = $reach ["totalDrs_T"];
            $val ["totalDrsB_P"] = $val ["totalDrsB_T"] == 0 ? '0%' : round($val ["totalDrsB_A"] / $val ["totalDrsB_T"] * 100, 2) . "%";

            $reach = $this->buildColumnReach($val ["dayWorked_A"], $val ["dayWorked_T"], "C", $val ["salesmanId"], $val ["dif_A"], $val ["dif_T"], $val['zoneId'], $export_date);
            $val ["totalDrsC_A"] = $reach ["totalDrs_A"];
            $val ["totalDrsC_T"] = $reach ["totalDrs_T"];
            $val ["totalDrsC_P"] = $val ["totalDrsC_T"] == 0 ? '0%' : round($val ["totalDrsC_A"] / $val ["totalDrsC_T"] * 100, 2) . "%";

            // call read
            $val ["callReach_A"] = $val ["totalDrsA_A"] + $val ["totalDrsB_A"] + $val ["totalDrsC_A"];
            //(28)+(30)+(32)
            $val ["callReach_T"] = $val ["totalDrsA_T"] + $val ["totalDrsB_T"] + $val ["totalDrsC_T"];
            $val ["callReach_P"] = $val ["callReach_T"] == 0 ? '0%' : round($val ["callReach_A"] / $val ["callReach_T"] * 100, 2) . "%";

            // Call Rate
            $val ["callRate_A"] = $val ["dif_A"] == 0 ? '0%' : round($val ["callReach_A"] / $val ["dif_A"], 2);
            $val ["callRate_P"] = $val ["callRate_T"] == 0 ? '0%' : round($val ["callRate_A"] / $val ["callRate_T"] * 100, 2) . "%";

            // volumn
            $val ["volumnA_A"] = $this->buildVolume("A", $val ["salesmanId"], $export_date)["volumes_A"];
            $val ["volumnA_T"] = $val ["totalDrsA_T"] * $val ["frequencyA_T"];
            $val ["volumnA_P"] = $val ["volumnA_T"] == 0 ? '0%' : round($val ["volumnA_A"] / $val ["volumnA_T"] * 100, 2) . "%";

            $val ["volumnB_A"] = $this->buildVolume("B", $val ["salesmanId"], $export_date)["volumes_A"];
            $val ["volumnB_T"] = $val ["totalDrsB_T"] * $val ["frequencyB_T"];
            $val ["volumnB_P"] = $val ["volumnB_T"] == 0 ? '0%' : round($val ["volumnB_A"] / $val ["volumnB_T"] * 100, 2) . "%";

            $val ["volumnC_A"] = $this->buildVolume("C", $val ["salesmanId"], $export_date)["volumes_A"];
            $val ["volumnC_T"] = $val ["totalDrsC_T"] * $val ["frequencyC_T"];
            $val ["volumnC_P"] = $val ["volumnC_T"] == 0 ? '0%' : round($val ["volumnC_A"] / $val ["volumnC_T"] * 100, 2) . "%";

            //

            // Call volumn
            $val ["callVolumn_A"] = $val ["volumnA_A"] + $val ["volumnB_A"] + $val ["volumnC_A"];
            $val ["callVolumn_T"] = $val ["volumnA_T"] + $val ["volumnB_T"] + $val ["volumnC_T"];
            $val ["callVolumn_P"] = $val ["callVolumn_T"] == 0 ? '0%' : round($val ["callVolumn_A"] / $val ["callVolumn_T"] * 100, 2) . "%";

            // Call Frequency
            $val ["callFrequency_A"] = round(($val ["callReach_A"] != 0 ? ($val ["callVolumn_A"] / $val ["callReach_A"]) : 0), 2);
            $val ["callFrequency_T"] = round(($val ["callVolumn_T"] != 0 ? ($val ["callReach_T"] / $val ["callVolumn_T"]) : 0), 2);
            $val ["callFrequency_P"] = $val ["callFrequency_T"] == 0 ? '0%' : round($val ["callFrequency_A"] / $val ["callFrequency_T"] * 100, 2) . "%";

            // Frequency
            $val ["frequencyA_A"] = $val ["totalDrsA_A"] == 0 ? '0' : round(($val ["volumnA_A"] / $val ["totalDrsA_A"]), 2);
            $val ["frequencyA_P"] = $val ["frequencyA_T"] == 0 ? '0%' : round($val ["frequencyA_A"] / $val ["frequencyA_T"] * 100, 2) . "%";

            $val ["frequencyB_A"] = $val ["totalDrsB_A"] == 0 ? '0' : round(($val ["volumnB_A"] / $val ["totalDrsB_A"]), 2);
            $val ["frequencyB_P"] = $val ["frequencyB_T"] == 0 ? '0%' : round($val ["frequencyB_A"] / $val ["frequencyB_T"] * 100, 2) . "%";

            $val ["frequencyC_A"] = $val ["totalDrsC_A"] == 0 ? '0' : round(($val ["volumnC_A"] / $val ["totalDrsC_A"]), 2);
            $val ["frequencyC_P"] = $val ["frequencyC_T"] == 0 ? '0%' : round($val ["frequencyC_A"] / $val ["frequencyC_T"] * 100, 2) . "%";

        }
    }

    /**
     * Monthly report controller
     * @param $data
     * @param $export_date
     * @return mixed
     */
    public function calculateDataDetail($data, $export_date)
    {
        foreach ($data as &$val) {
            if ($val['volumnA_A'] > 0) {
                $val['volumnA_A_detail'] = $this->buildVolumeDetail('A', $val ["salesmanId"], $export_date);
            }

            if ($val['volumnB_A'] > 0) {
                $val['volumnB_A_detail'] = $this->buildVolumeDetail('B', $val ["salesmanId"], $export_date);
            }

            if ($val['volumnC_A'] > 0) {
                $val['volumnC_A_detail'] = $this->buildVolumeDetail('C', $val ["salesmanId"], $export_date);
            }
        }

        return $data;
    }

	// Days/month
    private function buildColumnDaysMonth($export_date)
    {
        $num_days = date('t', strtotime($export_date));
//        $date1 = date('Y-m-d', mktime(0, 0, 0, date('m', strtotime($export_date)), 1, date('Y', strtotime($export_date))));
//        $date2 = date('Y-m-d', mktime(0, 0, 0, date('m', strtotime($export_date)), date('t', strtotime($export_date)), date('Y', strtotime($export_date))));
//        # Time strings
//        $time1 = strtotime($date1);
//        $time2 = strtotime($date2);
//
		$days = 0;
//        while ($time1 <= $time2) {
//            $chk = date('D', $time1); # Actual date conversion
//            if ($chk != 'Sat' && $chk != 'Sun') {
//                $days++;
//            }
//
//            $time1 += 86400; # Add a day
//        }
		
		return [ 
				"daysMonth_A" => $days,
				"daysMonth_T" => $num_days 
		];
	}
	
    // Days/month
//    private function buildNextDays($export_date)
//    {
//        $next_date = 0;
//        if (date('Y-m') === date('Y-m', strtotime($export_date))) {
//            $date1 = date('Y-m-d');
//            $date2 = date('Y-m-d', mktime(0, 0, 0, date('m', strtotime($export_date)), date('t', strtotime($export_date)), date('Y', strtotime($export_date))));
//            # Time strings
//            $time1 = strtotime($date1);
//            $time2 = strtotime($date2);
//
//            do {
//                $time1 += 86400;    # Add a day
//
//                $chk = date('D', $time1); # Actual date conversion
//                if ($chk != 'Sat' && $chk != 'Sun') {
//                    $next_date++;
//                }
//            } while ($time1 < $time2);
//        }
//
//        return $next_date;
//    }

	// Holidays
    private function buildColumnSalesmanLeave($salesmanId, $export_date)
    {
        $sSQL = "  SELECT count(sl.leave_seq) as total, sum(sl.register_in_date) as leave_total, sl.type ";
		$sSQL .= " FROM salesman_leave sl
    				WHERE  STR_TO_DATE(sl.leave_date,'%Y-%m') = STR_TO_DATE('" . $export_date . "','%Y-%m')
                           AND sl.leave_date <= now()
    					   AND sl.del_flg != '1'
    					   AND sl.salesman_id =" . $salesmanId ."
    					   GROUP BY sl.type ";
		$query = $this->strikeforce->query ( $sSQL );
		return $query->result_array ();
	}
	
	// Weeky off
    private function buildColumnWeeklyOff($export_date)
    {
        $date1 = date('Y-m-d', mktime(0, 0, 0, date('m', strtotime($export_date)), 1, date('Y', strtotime($export_date))));
        $date2 = date('Y-m-d', mktime(0, 0, 0, date('m', strtotime($export_date)), date('t', strtotime($export_date)), date('Y', strtotime($export_date))));
		# Time strings
		 $time1 = strtotime($date1);
		 $time2 = strtotime($date2);
		
		$days = 0;
        while ($time1 <= $time2) {
			 $chk = date('D', $time1); # Actual date conversion
            if ($chk == 'Sat' || $chk == 'Sun') {
				$days++; 
            }
				$time1 += 86400; # Add a day
		}
		
		return [ 
				"weeklyOff_A" => "NULL",
				"weeklyOff_T" =>  $days
		];
	}
	
	// Training days
//    public function buildColumnTrainingDays()
//    {
//        return [
//            "trainingDays_A" => "NULL",
//            "trainingDays_T" => "NULL"
//        ];
//    }
	
    // Build DIF
    private function buildDIF($export_date, $salesmanId)
    {
        $sSQL = " SELECT DISTINCT cr.mod_ts as mod_ts
			    	FROM call_record cr
			    	INNER JOIN store s ON (s.store_id = cr.store_id)
    				WHERE
    					 STR_TO_DATE(cr.mod_ts,'%Y-%m') = STR_TO_DATE('" . $export_date . "','%Y-%m')
    					   	AND s.del_flg != '1'
    						AND cr.del_flg != '1'
    					   	AND cr.salesman_id =" . $salesmanId;

        $query = $this->strikeforce->query($sSQL);
        $rs = $query->result_array();

        $total = 0;

        if (!empty($rs)) {
            $temp = array();
            foreach($rs as $item) {
                $str = date('Ymd', strtotime($item['mod_ts']));

                if (!in_array($str, $temp)) {
                    array_push($temp, $str);
                }
            }

            $total = count($temp);
        }

        return $total;
    }

	// Build total DRS
    private function buildColumnReach($dayWorked_A, $dayWorked_T, $classs, $salesmanId, $dif_A, $dif_T, $zoneId, $export_date)
    {
		$sSQL = " SELECT count(DISTINCT s.store_id)  as totalStore
			    	FROM store s
			    		INNER JOIN salesman_store ss ON (s.store_id = ss.store_id)
    				WHERE
    					   	s.del_flg != '1'
    						AND ss.del_flg != '1'
    					   	AND ss.salesman_id =" . $salesmanId;
    				if ($zoneId != 0){
    					$sSQL .= " 	AND s.zone_id =" . $zoneId;
    				}			
    				$sSQL .= " AND s.class = '" . $classs . "'";
		
		$query = $this->strikeforce->query ( $sSQL );
		$totalT = $query->result_array ()[0]["totalStore"];
		
		$sSQL = " SELECT   count(DISTINCT s.store_id) as totalStore
			    	FROM store s
			    		INNER JOIN call_record cr ON (s.store_id = cr.store_id)
    				WHERE
    					 STR_TO_DATE(cr.cre_ts,'%Y-%m') = STR_TO_DATE('" . $export_date . "','%Y-%m')
    					   	AND s.del_flg != '1'
    						AND cr.del_flg != '1'
    					   	AND cr.salesman_id =" . $salesmanId;
    				if ($zoneId != 0){
    					$sSQL .= " 	AND s.zone_id =" . $zoneId;
    				}			
    				$sSQL .= " AND s.class = '" . $classs . "'";
		
		$query = $this->strikeforce->query ( $sSQL );
		$totalA = $query->result_array ()[0]["totalStore"];
		return [ 
				"totalDrs_A" => $totalA,
				"totalDrs_T" => round ( $totalT * $dif_T / $dayWorked_T, 2 ) 
		];
	}
	
	
	// Build total volume
    private function buildVolume($classs, $salesmanId, $export_date)
    {
	
        $sSQL = " SELECT  count(cr.call_record_id) as total
                    FROM call_record cr
                    INNER JOIN store s ON (s.store_id = cr.store_id)
    				WHERE
    					 STR_TO_DATE(cr.cre_ts,'%Y-%m') = STR_TO_DATE('" . $export_date . "','%Y-%m')
    					   	AND s.del_flg != '1'
    						AND cr.del_flg != '1'
    					   	AND cr.salesman_id =" . $salesmanId . "
    					   	AND s.class = '" . $classs . "'";
		$query = $this->strikeforce->query ( $sSQL );
        $totalA = $query->result_array()[0]["total"];

		return [ 
				"volumes_A" => $totalA,
				"volumes_T" => NULL
		];
	}
	
    // Build volume datail
    private function buildVolumeDetail($classs, $salesmanId, $export_date)
    {

        $sSQL = "  SELECT  cr.*
                    FROM call_record cr
                    INNER JOIN store s ON (s.store_id = cr.store_id)
    				WHERE
    					 STR_TO_DATE(cr.cre_ts,'%Y-%m') = STR_TO_DATE('" . $export_date . "','%Y-%m')
    					   	AND s.del_flg != '1'
    						AND cr.del_flg != '1'
    					   	AND cr.salesman_id =" . $salesmanId . "
    					   	AND s.class = '" . $classs . "'";
        $query = $this->strikeforce->query($sSQL);
        $callrecords = $query->result_array();

        $rs = array();
        if (!empty($callrecords)) {
            foreach ($callrecords as $cr) {
                $product_groups = json_decode($cr['product_group_id'], TRUE);
                foreach ($product_groups as $pg) {
                    if (isset($rs[$pg])) {
                        $rs[$pg]++;
                    } else {
                        $rs[$pg] = 1;
                    }
                }
            }
        }

        return $rs;
    }

	/**
	 * 
	 * @param object excel $sheetDetails
	 * @param  $data
	 * @return object excel
	 */
    private function buildDetailTeam($export_date, $sheetDetails, $data, $is_detail = FALSE)
    {
        $product_groups = array();
        if ($is_detail) {

            //Get all product group
            $this->load->model('product_group_model');
            $product_groups = $this->product_group_model->selectAll();

            if (!empty($product_groups)) {
                $temp = array();
                foreach ($product_groups as $pg) {
                    $temp[$pg['product_group_id']] = $pg['product_group_name'];
                }
                $product_groups = $temp;
            }
        }

		//set header
		$sheetDetails->setCellValue('A1', 'MONTHLY SFE REPORT - GM Team');
		$sheetDetails->mergeCells('A1:BH1');
        $sheetDetails->setCellValue('A2', 'Year: ' . date("Y", strtotime($export_date)) . ' Month: ' . date("m", strtotime($export_date)));
		$sheetDetails->mergeCells('A2:BH2');
		//
		
		$sheetDetails->setCellValue('A3', 'No');
		$sheetDetails->mergeCells('A3:A5');
		
		$sheetDetails->setCellValue('B3', "MR's name");
		$sheetDetails->mergeCells('B3:B5');
		
		$sheetDetails->setCellValue('C3', 'Days/month');
		$sheetDetails->mergeCells('C3:D4');
		$sheetDetails->setCellValue('C5', 'A');
		$sheetDetails->setCellValue('D5', 'T');
		
		$sheetDetails->setCellValue('E3', 'Day worked');
		$sheetDetails->mergeCells('E3:F4');
		$sheetDetails->setCellValue('E5', 'A');
		$sheetDetails->setCellValue('F5', 'T');
		
		$sheetDetails->setCellValue('G3', 'Holidays');
		$sheetDetails->mergeCells('G3:H4');
		$sheetDetails->setCellValue('G5', 'A');
		$sheetDetails->setCellValue('H5', 'T');
		
		$sheetDetails->setCellValue('I3', 'Weeky off');
		$sheetDetails->mergeCells('I3:J4');
		$sheetDetails->setCellValue('I5', 'A');
		$sheetDetails->setCellValue('J5', 'T');
		
		$sheetDetails->setCellValue('K3', 'Training days');
		$sheetDetails->mergeCells('K3:L4');
		$sheetDetails->setCellValue('K5', 'A');
		$sheetDetails->setCellValue('L5', 'T');
		
		$sheetDetails->setCellValue('M3', 'Promotion days');
		$sheetDetails->mergeCells('M3:N4');
		$sheetDetails->setCellValue('M5', 'A');
		$sheetDetails->setCellValue('N5', 'T');
		
		$sheetDetails->setCellValue('O3', 'Meeting days');
		$sheetDetails->mergeCells('O3:P4');
		$sheetDetails->setCellValue('O5', 'A');
		$sheetDetails->setCellValue('P5', 'T');
		
		$sheetDetails->setCellValue('Q3', 'Leave taken');
		$sheetDetails->mergeCells('Q3:R4');
		$sheetDetails->setCellValue('Q5', 'A');
		$sheetDetails->setCellValue('R5', 'T');
		
		$sheetDetails->setCellValue('S3', 'DIF');
		$sheetDetails->mergeCells('S3:U4');
		$sheetDetails->setCellValue('S5', 'A');
		$sheetDetails->setCellValue('T5', 'T');
		$sheetDetails->setCellValue('U5', '100%');
		
		$sheetDetails->setCellValue('V3', 'Call Rate');
		$sheetDetails->mergeCells('V3:X4');
		$sheetDetails->setCellValue('V5', 'A');
		$sheetDetails->setCellValue('W5', 'T');
		$sheetDetails->setCellValue('X5', '100%');
		
        $sheetDetails->setCellValue('Y3', 'Total Call Reach');
		$sheetDetails->mergeCells('Y3:AA4');
		$sheetDetails->setCellValue('Y5', 'A');
		$sheetDetails->setCellValue('Z5', 'T');
		$sheetDetails->setCellValue('AA5', '100%');
		
        $sheetDetails->setCellValue('AB3', 'Call Reach');
		$sheetDetails->mergeCells('AB3:AJ3');
		$sheetDetails->setCellValue('AB4', 'Total Drs A');
		$sheetDetails->mergeCells('AB4:AD4');
		$sheetDetails->setCellValue('AB5', 'A');
		$sheetDetails->setCellValue('AC5', 'T');
		$sheetDetails->setCellValue('AD5', '100%');
		
		$sheetDetails->setCellValue('AE4', 'Total Drs B');
		$sheetDetails->mergeCells('AE4:AG4');
		$sheetDetails->setCellValue('AE5', 'A');
		$sheetDetails->setCellValue('AF5', 'T');
		$sheetDetails->setCellValue('AG5', '100%');
			
		$sheetDetails->setCellValue('AH4', 'Total Drs C');
		$sheetDetails->mergeCells('AH4:AJ4');
		$sheetDetails->setCellValue('AH5', 'A');
		$sheetDetails->setCellValue('AI5', 'T');
		$sheetDetails->setCellValue('AJ5', '100%');
		
        $sheetDetails->setCellValue('AK3', 'Total Call Volumn');
		$sheetDetails->mergeCells('AK3:AM4');
		$sheetDetails->setCellValue('AK5', 'A');
		$sheetDetails->setCellValue('AL5', 'T');
		$sheetDetails->setCellValue('AM5', '100%');
		
        $sheetDetails->setCellValue('AN3', 'Call Volumn');
		$sheetDetails->mergeCells('AN3:AV3');
		$sheetDetails->setCellValue('AN4', 'A(x4)');
		$sheetDetails->mergeCells('AN4:AP4');
		$sheetDetails->setCellValue('AN5', 'A');
		$sheetDetails->setCellValue('AO5', 'T');
		$sheetDetails->setCellValue('AP5', '100%');
			
		$sheetDetails->setCellValue('AQ4', 'B(x3)');
		$sheetDetails->mergeCells('AQ4:AS4');
		$sheetDetails->setCellValue('AQ5', 'A');
		$sheetDetails->setCellValue('AR5', 'T');
		$sheetDetails->setCellValue('AS5', '100%');
		
		$sheetDetails->setCellValue('AT4', 'C(x1)');
		$sheetDetails->mergeCells('AT4:AV4');
		$sheetDetails->setCellValue('AT5', 'A');
		$sheetDetails->setCellValue('AU5', 'T');
		$sheetDetails->setCellValue('AV5', '100%');
		
		$sheetDetails->setCellValue('AW3', 'Call Frequency');
		$sheetDetails->mergeCells('AW3:AY4');
		$sheetDetails->setCellValue('AW5', 'A');
		$sheetDetails->setCellValue('AX5', 'T');
		$sheetDetails->setCellValue('AY5', '100%');
		
		$sheetDetails->setCellValue('AZ3', 'Frequency');
		$sheetDetails->mergeCells('AZ3:BH3');
		$sheetDetails->setCellValue('AZ4', 'A');
		$sheetDetails->mergeCells('AZ4:BB4');
		$sheetDetails->setCellValue('AZ5', 'A');
		$sheetDetails->setCellValue('BA5', 'T');
		$sheetDetails->setCellValue('BB5', '100%');
		
		$sheetDetails->setCellValue('BC4', 'B');
		$sheetDetails->mergeCells('BC4:BE4');
		$sheetDetails->setCellValue('BC5', 'A');
		$sheetDetails->setCellValue('BD5', 'T');
		$sheetDetails->setCellValue('BE5', '100%');
			
		$sheetDetails->setCellValue('BF4', 'C');
		$sheetDetails->mergeCells('BF4:BH4');
		$sheetDetails->setCellValue('BF5', 'A');
		$sheetDetails->setCellValue('BG5', 'T');
		$sheetDetails->setCellValue('BH5', '100%');
		
        $is_detail ? $sheetDetails->setTitle('Detail Teams With Product') : $sheetDetails->setTitle('Detail Teams');
		
		$sheetDetails->getStyle('A1:BH5')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER
				)
		);
		$sheetDetails->getStyle('A1:BH5')->getFont()->setBold(true);
		
		//build body data
		$sno = 1;
		$index = 6;
		
		$zoneName = $data[0]["zoneName"];
		$arraySalesmanId = array();
		
		foreach ($data as $val) {
			if ($zoneName != $val["zoneName"]){ //set zone rows
				$sheetDetails->setCellValue('B'.$index, $zoneName);
				$sheetDetails->getStyle('A'.$index.':'.'BH'.$index)->getFill()->applyFromArray(array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'startcolor' => array(
								'rgb' => 'FFD700'
						)
				));
				$sheetDetails->setCellValue('E'.$index, $dayWorked_A_total);
				$dayWorked_A_total = 0;
				$sheetDetails->setCellValue('F'.$index, $dayWorked_T_total);
				$dayWorked_T_total = 0;
				
				$sheetDetails->setCellValue('S'.$index, $dif_A_total);
				 $dif_A_total= 0;
				$sheetDetails->setCellValue('T'.$index, $dif_T_total);
				$dif_T_total = 0;
				
				$sheetDetails->setCellValue('V'.$index, $callRate_A_average);
				$callRate_A_average = 0;
				$sheetDetails->setCellValue('W'.$index, $callRate_T_average);
				$callRate_T_average = 0;
								
				$sheetDetails->setCellValue('Y'.$index, $callReach_A_total);
				$callReach_A_total = 0;
				$sheetDetails->setCellValue('Z'.$index, $callReach_T_total);
				$callReach_T_total = 0;
								
				$sheetDetails->setCellValue('AB'.$index, $totalDrsA_A_total);
				$totalDrsA_A_total = 0;
				$sheetDetails->setCellValue('AC'.$index, $totalDrsA_T_total);
				$totalDrsA_T_total = 0;
				
				$sheetDetails->setCellValue('AE'.$index,$totalDrsB_A_total);
				$totalDrsB_A_total = 0;
				$sheetDetails->setCellValue('AF'.$index, $totalDrsB_T_total);
				$totalDrsB_T_total = 0;
				
				$sheetDetails->setCellValue('AH'.$index, $totalDrsC_A_total);
				$totalDrsC_A_total = 0;
				$sheetDetails->setCellValue('AI'.$index, $totalDrsC_T_total);
				$totalDrsC_T_total = 0;
				
				$sheetDetails->setCellValue('AK'.$index, $callVolumn_A_total);
				$callVolumn_A_total = 0;
				$sheetDetails->setCellValue('AL'.$index, $callVolumn_T_total);
				$callVolumn_T_total = 0;
				
				$sheetDetails->setCellValue('AN'.$index, $volumnA_A_total);
				$volumnA_A_total = 0;
				$sheetDetails->setCellValue('AO'.$index, $volumnA_T_total);
				$volumnA_T_total = 0;
				
				$sheetDetails->setCellValue('AQ'.$index, $volumnB_A_total);
				$volumnB_A_total = 0;
				$sheetDetails->setCellValue('AR'.$index, $volumnB_T_total);
				$volumnB_T_total = 0;

				$sheetDetails->setCellValue('AT'.$index, $volumnC_A_total);
				$volumnC_A_total = 0;
				$sheetDetails->setCellValue('AU'.$index, $volumnC_T_total);
				$volumnC_T_total = 0;

				$sheetDetails->setCellValue('AW'.$index, $callFrequency_A_average);
				$callFrequency_A_average = 0;
				$sheetDetails->setCellValue('AX'.$index, $callFrequency_T_average);
				$callFrequency_T_average = 0;

				$sheetDetails->setCellValue('AZ'.$index, $frequencyA_A_average);
				$frequencyA_A_average = 0;
				$sheetDetails->setCellValue('BA'.$index, $frequencyA_T_average);
				$frequencyA_T_average = 0;

				$sheetDetails->setCellValue('BC'.$index, $frequencyB_A_average);
				$frequencyB_A_average = 0;
				$sheetDetails->setCellValue('BD'.$index, $frequencyB_T_average);
				$frequencyB_T_average = 0;

				$sheetDetails->setCellValue('BF'.$index, $frequencyC_A_average);
				$frequencyC_A_average = 0;
				$sheetDetails->setCellValue('BG'.$index, $frequencyC_T_average);
				$frequencyC_T_average = 0;
				
				$zoneName = $val["zoneName"];
				$sno = 1;
				$index++;
			} 
				//set data  salesman
			$sheetDetails->setCellValue('A'.$index, $sno);
			$sheetDetails->setCellValue('B'.$index, $val["salesmanName"]);
			
			$sheetDetails->setCellValue('C'.$index, $val["daysMonth_A"]);
			$sheetDetails->setCellValue('D'.$index, $val["daysMonth_T"]);
			
			$sheetDetails->setCellValue('E'.$index, $val["dayWorked_A"]);
			$dayWorked_A_total = $dayWorked_A_total + $val["dayWorked_A"];
			if (!in_array($val["salesmanId"], $arraySalesmanId)){
			$dayWorked_A_total_zone = $dayWorked_A_total_zone + $val["dayWorked_A"];
			}
			$sheetDetails->setCellValue('F'.$index, $val["dayWorked_T"]);
			$dayWorked_T_total = $dayWorked_T_total + $val["dayWorked_T"]; 
			if (!in_array($val["salesmanId"], $arraySalesmanId)){
			$dayWorked_T_total_zone = $dayWorked_T_total_zone + $val["dayWorked_T"];
			}
			$sheetDetails->setCellValue('G'.$index, $val["holidays_A"]);
			$sheetDetails->setCellValue('H'.$index, $val["holidays_T"]);

			$sheetDetails->setCellValue('I'.$index, $val["weeklyOff_A"]);
			$sheetDetails->setCellValue('J'.$index, $val["weeklyOff_T"]);
			
			$sheetDetails->setCellValue('K'.$index, $val["trainingDays_A"]);
			$sheetDetails->setCellValue('L'.$index, $val["trainingDays_T"]);	

			$sheetDetails->setCellValue('M'.$index, $val["promotionDays_A"]);
			$sheetDetails->setCellValue('N'.$index, $val["promotionDays_T"]);
			
			$sheetDetails->setCellValue('O'.$index, $val["meetingDays_A"]);
			$sheetDetails->setCellValue('P'.$index, $val["meetingDays_T"]);

			$sheetDetails->setCellValue('Q'.$index, $val["leaveTaken_A"]);
			$sheetDetails->setCellValue('R'.$index, $val["leaveTaken_T"]);
			
			$sheetDetails->setCellValue('S'.$index, $val["dif_A"]);
			$dif_A_total = $dif_A_total + $val["dif_A"]; 
			if (!in_array($val["salesmanId"], $arraySalesmanId)){ 
			$dif_A_total_zone = $dif_A_total_zone + $val["dif_A"];
			}
			$sheetDetails->setCellValue('T'.$index, $val["dif_T"]);
			$dif_T_total = $dif_T_total + $val["dif_T"]; 
			if (!in_array($val["salesmanId"], $arraySalesmanId)){
			$dif_T_total_zone = $dif_T_total_zone + $val["dif_T"];
			}
			$sheetDetails->setCellValue('U'.$index, $val["dif_P"]);
			
			$sheetDetails->setCellValue('V'.$index, $val["callRate_A"]);
			$callRate_A_average = $callRate_A_average + $val["callRate_A"]; 
			$callRate_A_average_zone = $callRate_A_average_zone + $val["callRate_A"];
			$sheetDetails->setCellValue('W'.$index, $val["callRate_T"]);
			$callRate_T_average = $callRate_T_average + $val["callRate_T"]; 
			if (!in_array($val["salesmanId"], $arraySalesmanId)){
			$callRate_T_average_zone = $callRate_T_average_zone + $val["callRate_T"];
			}
			$sheetDetails->setCellValue('X'.$index, $val["callRate_P"]);

			$sheetDetails->setCellValue('Y'.$index, $val["callReach_A"]);
			$callReach_A_total = $callReach_A_total+ $val["callReach_A"]; 
			$callReach_A_total_zone = $callReach_A_total_zone+ $val["callReach_A"];
			$sheetDetails->setCellValue('Z'.$index, $val["callReach_T"]);
			$callReach_T_total = $callReach_T_total + $val["callReach_T"]; 
			$callReach_T_total_zone = $callReach_T_total_zone + $val["callReach_T"];
			$sheetDetails->setCellValue('AA'.$index, $val["callReach_P"]);				

			$sheetDetails->setCellValue('AB'.$index, $val["totalDrsA_A"]);
			$totalDrsA_A_total = $totalDrsA_A_total + $val["totalDrsA_A"]; 
			$totalDrsA_A_total_zone = $totalDrsA_A_total_zone + $val["totalDrsA_A"];
			$sheetDetails->setCellValue('AC'.$index, $val["totalDrsA_T"]);
			$totalDrsA_T_total = $totalDrsA_T_total + $val["totalDrsA_T"]; 
			$totalDrsA_T_total_zone = $totalDrsA_T_total_zone + $val["totalDrsA_T"];
			$sheetDetails->setCellValue('AD'.$index, $val["totalDrsA_P"]);

			$sheetDetails->setCellValue('AE'.$index, $val["totalDrsB_A"]);
			$totalDrsB_A_total = $totalDrsB_A_total + $val["totalDrsB_A"]; 
			$totalDrsB_A_total_zone = $totalDrsB_A_total_zone + $val["totalDrsB_A"];
			$sheetDetails->setCellValue('AF'.$index, $val["totalDrsB_T"]);
		 	$totalDrsB_T_total = $totalDrsB_T_total + $val["totalDrsB_T"]; 
 			$totalDrsB_T_total_zone = $totalDrsB_T_total_zone + $val["totalDrsB_T"];
			$sheetDetails->setCellValue('AG'.$index, $val["totalDrsB_P"]);
			
			$sheetDetails->setCellValue('AH'.$index, $val["totalDrsC_A"]);
			$totalDrsC_A_total = $totalDrsC_A_total + $val["totalDrsC_A"]; 
			$totalDrsC_A_total_zone = $totalDrsC_A_total_zone + $val["totalDrsC_A"];
			$sheetDetails->setCellValue('AI'.$index, $val["totalDrsC_T"]);
			$totalDrsC_T_total = $totalDrsC_T_total + $val["totalDrsC_T"]; 
			$totalDrsC_T_total_zone = $totalDrsC_T_total_zone + $val["totalDrsC_T"];
			$sheetDetails->setCellValue('AJ'.$index, $val["totalDrsC_P"]);	

			$sheetDetails->setCellValue('AK'.$index, $val["callVolumn_A"]);
			$callVolumn_A_total = $callVolumn_A_total + $val["callVolumn_A"]; 
			if (!in_array($val["salesmanId"], $arraySalesmanId)){
			$callVolumn_A_total_zone = $callVolumn_A_total_zone + $val["callVolumn_A"];
			}
			$sheetDetails->setCellValue('AL'.$index, $val["callVolumn_T"]);
			$callVolumn_T_total = $callVolumn_T_total + $val["callVolumn_T"]; 
			$callVolumn_T_total_zone = $callVolumn_T_total_zone + $val["callVolumn_T"];
			$sheetDetails->setCellValue('AM'.$index, $val["callVolumn_P"]);

			$sheetDetails->setCellValue('AN'.$index, $val["volumnA_A"]);

            $stepA = 0;
            if ($is_detail) {
                if (isset($val['volumnA_A_detail'])) {
                    foreach ($val['volumnA_A_detail'] as $key => $detail) {
                        $stepA++;
                        $sheetDetails->setCellValue('AN' . ($index + $stepA), $product_groups[$key] . ': ' . $detail);
                    }
                }
            }

			$volumnA_A_total = $volumnA_A_total + $val["volumnA_A"]; 
			$volumnA_A_total_zone = $volumnA_A_total_zone + $val["volumnA_A"];
			$sheetDetails->setCellValue('AO'.$index, $val["volumnA_T"]);
			$volumnA_T_total = $volumnA_T_total + $val["volumnA_T"]; 
			$volumnA_T_total_zone = $volumnA_T_total_zone + $val["volumnA_T"];
			$sheetDetails->setCellValue('AP'.$index, $val["volumnA_P"]);

			$sheetDetails->setCellValue('AQ'.$index, $val["volumnB_A"]);

            $stepB = 0;
            if ($is_detail) {
                if (isset($val['volumnB_A_detail'])) {
                    foreach ($val['volumnB_A_detail'] as $key => $detail) {
                        $stepB++;
                        $sheetDetails->setCellValue('AQ' . ($index + $stepB), $product_groups[$key] . ': ' . $detail);
                    }
                }
            }

			$volumnB_A_total = $volumnB_A_total + $val["volumnB_A"]; 
			if (!in_array($val["salesmanId"], $arraySalesmanId)){
			$volumnB_A_total_zone = $volumnB_A_total_zone + $val["volumnB_A"];
			}
			$sheetDetails->setCellValue('AR'.$index, $val["volumnB_T"]);
			$volumnB_T_total = $volumnB_T_total + $val["volumnB_T"]; 
			$volumnB_T_total_zone = $volumnB_T_total_zone + $val["volumnB_T"];
			$sheetDetails->setCellValue('AS'.$index, $val["volumnB_P"]);
				
			$sheetDetails->setCellValue('AT'.$index, $val["volumnC_A"]);

            $stepC = 0;
            if ($is_detail) {
                if (isset($val['volumnC_A_detail'])) {
                    foreach ($val['volumnC_A_detail'] as $key => $detail) {
                        $stepC++;
                        $sheetDetails->setCellValue('AT' . ($index + $stepC), $product_groups[$key] . ': ' . $detail);
                    }
                }
            }

			$volumnC_A_total = $volumnC_A_total + $val["volumnC_A"]; 
			if (!in_array($val["salesmanId"], $arraySalesmanId)){
			$volumnC_A_total_zone = $volumnC_A_total_zone + $val["volumnC_A"];
			}
			$sheetDetails->setCellValue('AU'.$index, $val["volumnC_T"]);
			$volumnC_T_total = $volumnC_T_total + $val["volumnC_T"]; 
			$volumnC_T_total_zone = $volumnC_T_total_zone + $val["volumnC_T"];
			$sheetDetails->setCellValue('AV'.$index, $val["volumnC_P"]);

			$sheetDetails->setCellValue('AW'.$index, $val["callFrequency_A"]);
			$callFrequency_A_average = $callFrequency_A_average + $val["callFrequency_A"]; 
			$callFrequency_A_average_zone = $callFrequency_A_average_zone + $val["callFrequency_A"];
			$sheetDetails->setCellValue('AX'.$index, $val["callFrequency_T"]);
			$callFrequency_T_average = $callFrequency_T_average + $val["callFrequency_T"]; 
			$callFrequency_T_average_zone = $callFrequency_T_average_zone + $val["callFrequency_T"];
			$sheetDetails->setCellValue('AY'.$index, $val["callFrequency_P"]);
			
			$sheetDetails->setCellValue('AZ'.$index, $val["frequencyA_A"]);
			$frequencyA_A_average = $frequencyA_A_average + $val["frequencyA_A"]; 
			$frequencyA_A_average_zone = $frequencyA_A_average_zone + $val["frequencyA_A"];
			$sheetDetails->setCellValue('BA'.$index, $val["frequencyA_T"]);
			$frequencyA_T_average = $frequencyA_T_average + $val["frequencyA_T"]; 
			if (!in_array($val["salesmanId"], $arraySalesmanId)){
			$frequencyA_T_average_zone = $frequencyA_T_average_zone + $val["frequencyA_T"];
			}
			$sheetDetails->setCellValue('BB'.$index, $val["frequencyA_P"]);

			$sheetDetails->setCellValue('BC'.$index, $val["frequencyB_A"]);
			$frequencyB_A_average = $frequencyB_A_average + $val["frequencyB_A"]; 
			$frequencyB_A_average_zone = $frequencyB_A_average_zone + $val["frequencyB_A"];
			$sheetDetails->setCellValue('BD'.$index, $val["frequencyB_T"]);
			$frequencyB_T_average = $frequencyB_T_average + $val["frequencyB_T"];  
			if (!in_array($val["salesmanId"], $arraySalesmanId)){ 
			$frequencyB_T_average_zone = $frequencyB_T_average_zone + $val["frequencyB_T"];
			}
			$sheetDetails->setCellValue('BE'.$index, $val["frequencyB_P"]);
			
			$sheetDetails->setCellValue('BF'.$index, $val["frequencyC_A"]);
			$frequencyC_A_average = $frequencyC_A_average + $val["frequencyC_A"]; 
			$frequencyC_A_average_zone = $frequencyC_A_average_zone + $val["frequencyC_A"];
			$sheetDetails->setCellValue('BG'.$index, $val["frequencyC_T"]);
			$frequencyC_T_average = $frequencyC_T_average + $val["frequencyC_T"]; 
			if (!in_array($val["salesmanId"], $arraySalesmanId)){
			$frequencyC_T_average_zone = $frequencyC_T_average_zone + $val["frequencyC_T"];
			}
			$sheetDetails->setCellValue('BH'.$index, $val["frequencyC_P"]);
			
            $step = max($stepA, $stepB, $stepC);
			$sno++; 
//			$index++;
            $index = $index + 1 + $step;
			 
			array_push($arraySalesmanId,$val["salesmanId"]);
		}
		
		//set sone row when finish loop
		$sheetDetails->setCellValue('B'.$index, $zoneName);
		$sheetDetails->setCellValue('E'.$index, $dayWorked_A_total);
		$sheetDetails->setCellValue('F'.$index, $dayWorked_T_total);
		$sheetDetails->setCellValue('S'.$index, $dif_A_total);
		$sheetDetails->setCellValue('T'.$index, $dif_T_total);
		$sheetDetails->setCellValue('V'.$index, $callRate_A_average);
		$sheetDetails->setCellValue('W'.$index, $callRate_T_average);
		$sheetDetails->setCellValue('Y'.$index, $callReach_A_total);
		$sheetDetails->setCellValue('Z'.$index, $callReach_T_total);
		$sheetDetails->setCellValue('AB'.$index, $totalDrsA_A_total);
		$sheetDetails->setCellValue('AC'.$index, $totalDrsA_T_total);
		$sheetDetails->setCellValue('AE'.$index,$totalDrsB_A_total);
		$sheetDetails->setCellValue('AF'.$index, $totalDrsB_T_total);
		$sheetDetails->setCellValue('AH'.$index, $totalDrsC_A_total);
		$sheetDetails->setCellValue('AI'.$index, $totalDrsC_T_total);
		$sheetDetails->setCellValue('AK'.$index, $callVolumn_A_total);
		$sheetDetails->setCellValue('AL'.$index, $callVolumn_T_total);
		$sheetDetails->setCellValue('AN'.$index, $volumnA_A_total);
		$sheetDetails->setCellValue('AO'.$index, $volumnA_T_total);
		$sheetDetails->setCellValue('AQ'.$index, $volumnB_A_total);
		$sheetDetails->setCellValue('AR'.$index, $volumnB_T_total);
		$sheetDetails->setCellValue('AT'.$index, $volumnC_A_total);
		$sheetDetails->setCellValue('AU'.$index, $volumnC_T_total);
		$sheetDetails->setCellValue('AW'.$index, $callFrequency_A_average);
		$sheetDetails->setCellValue('AX'.$index, $callFrequency_T_average);
		$sheetDetails->setCellValue('AZ'.$index, $frequencyA_A_average);
		$sheetDetails->setCellValue('BA'.$index, $frequencyA_T_average);
		$sheetDetails->setCellValue('BC'.$index, $frequencyB_A_average);
		$sheetDetails->setCellValue('BD'.$index, $frequencyB_T_average);
		$sheetDetails->setCellValue('BF'.$index, $frequencyC_A_average);
		$sheetDetails->setCellValue('BG'.$index, $frequencyC_T_average);
		$sheetDetails->getStyle('A'.$index.':'.'BH'.$index)->getFill()->applyFromArray(array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'startcolor' => array(
						'rgb' => 'FFD700'
				)
		));
		
		//count total GM total
		$index++;
		$sheetDetails->setCellValue('B'.$index, "GM total");
		$sheetDetails->setCellValue('E'.$index, $dayWorked_A_total_zone);
		$sheetDetails->setCellValue('F'.$index, $dayWorked_T_total_zone);
		$sheetDetails->setCellValue('S'.$index, $dif_A_total_zone);
		$sheetDetails->setCellValue('T'.$index, $dif_T_total_zone);
		$sheetDetails->setCellValue('V'.$index, $callRate_A_average_zone);
		$sheetDetails->setCellValue('W'.$index, $callRate_T_average_zone);
		$sheetDetails->setCellValue('Y'.$index, $callReach_A_total_zone);
		$sheetDetails->setCellValue('Z'.$index, $callReach_T_total_zone);
		$sheetDetails->setCellValue('AB'.$index, $totalDrsA_A_total_zone);
		$sheetDetails->setCellValue('AC'.$index, $totalDrsA_T_total_zone);
		$sheetDetails->setCellValue('AE'.$index,$totalDrsB_A_total_zone);
		$sheetDetails->setCellValue('AF'.$index, $totalDrsB_T_total_zone);
		$sheetDetails->setCellValue('AH'.$index, $totalDrsC_A_total_zone);
		$sheetDetails->setCellValue('AI'.$index, $totalDrsC_T_total_zone);
		$sheetDetails->setCellValue('AK'.$index, $callVolumn_A_total_zone);
		$sheetDetails->setCellValue('AL'.$index, $callVolumn_T_total_zone);
		$sheetDetails->setCellValue('AN'.$index, $volumnA_A_total_zone);
		$sheetDetails->setCellValue('AO'.$index, $volumnA_T_total_zone);
		$sheetDetails->setCellValue('AQ'.$index, $volumnB_A_total_zone);
		$sheetDetails->setCellValue('AR'.$index, $volumnB_T_total_zone);
		$sheetDetails->setCellValue('AT'.$index, $volumnC_A_total_zone);
		$sheetDetails->setCellValue('AU'.$index, $volumnC_T_total_zone);
		$sheetDetails->setCellValue('AW'.$index, $callFrequency_A_average_zone);
		$sheetDetails->setCellValue('AX'.$index, $callFrequency_T_average_zone);
		$sheetDetails->setCellValue('AZ'.$index, $frequencyA_A_average_zone);
		$sheetDetails->setCellValue('BA'.$index, $frequencyA_T_average_zone);
		$sheetDetails->setCellValue('BC'.$index, $frequencyB_A_average_zone);
		$sheetDetails->setCellValue('BD'.$index, $frequencyB_T_average_zone);
		$sheetDetails->setCellValue('BF'.$index, $frequencyC_A_average_zone);
		$sheetDetails->setCellValue('BG'.$index, $frequencyC_T_average_zone);
		$sheetDetails->getStyle('A'.$index.':'.'BH'.$index)->getFill()->applyFromArray(array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'startcolor' => array(
						'rgb' => '00FF00'
				)
		));
		
		$styleArray = array(
				'borders' => array(
						'allborders' => array(
								'style' => PHPExcel_Style_Border::BORDER_DOTTED
						)
				)
		);
		
		$sheetDetails->getStyle('A1:BH'.$index)->applyFromArray($styleArray);
		$sheetDetails->getStyle('C6:BH'.$index)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		
		return $sheetDetails;
	}
	
	/**
	 * 
	 * @param object excel $sheetTeams
	 * @param $data
	 * @return object excel
	 */
    private function buildSheetTeams($export_date, $sheetTeams, $data)
    {
		//set header
		//
		$sheetTeams->mergeCells('A1:BH1');
		$sheetTeams->mergeCells('A2:BH2');
		//
		$sheetTeams->setCellValue('A3', 'No');
		$sheetTeams->mergeCells('A3:A5');
		
		$sheetTeams->setCellValue('B3', "Team");
		$sheetTeams->mergeCells('B3:B5');
		
		$sheetTeams->setCellValue('C3', 'Days/month');
		$sheetTeams->mergeCells('C3:D4');
		$sheetTeams->setCellValue('C5', 'A');
		$sheetTeams->setCellValue('D5', 'T');
		
		$sheetTeams->setCellValue('E3', 'Day worked');
		$sheetTeams->mergeCells('E3:F4');
		$sheetTeams->setCellValue('E5', 'A');
		$sheetTeams->setCellValue('F5', 'T');
		
		$sheetTeams->setCellValue('G3', 'Holidays');
		$sheetTeams->mergeCells('G3:H4');
		$sheetTeams->setCellValue('G5', 'A');
		$sheetTeams->setCellValue('H5', 'T');
		
		$sheetTeams->setCellValue('I3', 'Weeky off');
		$sheetTeams->mergeCells('I3:J4');
		$sheetTeams->setCellValue('I5', 'A');
		$sheetTeams->setCellValue('J5', 'T');
		
		$sheetTeams->setCellValue('K3', 'Training days');
		$sheetTeams->mergeCells('K3:L4');
		$sheetTeams->setCellValue('K5', 'A');
		$sheetTeams->setCellValue('L5', 'T');
		
		$sheetTeams->setCellValue('M3', 'Promotion days');
		$sheetTeams->mergeCells('M3:N4');
		$sheetTeams->setCellValue('M5', 'A');
		$sheetTeams->setCellValue('N5', 'T');
		
		$sheetTeams->setCellValue('O3', 'Meeting days');
		$sheetTeams->mergeCells('O3:P4');
		$sheetTeams->setCellValue('O5', 'A');
		$sheetTeams->setCellValue('P5', 'T');
		
		$sheetTeams->setCellValue('Q3', 'Leave taken');
		$sheetTeams->mergeCells('Q3:R4');
		$sheetTeams->setCellValue('Q5', 'A');
		$sheetTeams->setCellValue('R5', 'T');
		
		$sheetTeams->setCellValue('S3', 'DIF');
		$sheetTeams->mergeCells('S3:U4');
		$sheetTeams->setCellValue('S5', 'A');
		$sheetTeams->setCellValue('T5', 'T');
		$sheetTeams->setCellValue('U5', '100%');
		$sheetTeams->getColumnDimension('U')->setVisible(false);
		
		$sheetTeams->setCellValue('V3', 'Call Rate');
		$sheetTeams->mergeCells('V3:X4');
		$sheetTeams->setCellValue('V5', 'A');
		$sheetTeams->setCellValue('W5', 'T');
		$sheetTeams->setCellValue('X5', '100%');
		$sheetTeams->getColumnDimension('X')->setVisible(false);
		
		$sheetTeams->setCellValue('Y3', 'Call Reach');
		$sheetTeams->mergeCells('Y3:AA4');
		$sheetTeams->setCellValue('Y5', 'A');
		$sheetTeams->setCellValue('Z5', 'T');
		$sheetTeams->setCellValue('AA5', '100%');
		$sheetTeams->getColumnDimension('AA')->setVisible(false);
		
		$sheetTeams->setCellValue('AB3', 'Reach');
		$sheetTeams->mergeCells('AB3:AJ3');
		$sheetTeams->setCellValue('AB4', 'Total Drs A');
		$sheetTeams->mergeCells('AB4:AD4');
		$sheetTeams->setCellValue('AB5', 'A');
		$sheetTeams->setCellValue('AC5', 'T');
		$sheetTeams->setCellValue('AD5', '100%');
		$sheetTeams->getColumnDimension('AD')->setVisible(false);
		
		$sheetTeams->setCellValue('AE4', 'Total Drs B');
		$sheetTeams->mergeCells('AE4:AG4');
		$sheetTeams->setCellValue('AE5', 'A');
		$sheetTeams->setCellValue('AF5', 'T');
		$sheetTeams->setCellValue('AG5', '100%');
		$sheetTeams->getColumnDimension('AG')->setVisible(false);
		
		
		$sheetTeams->setCellValue('AH4', 'Total Drs C');
		$sheetTeams->mergeCells('AH4:AJ4');
		$sheetTeams->setCellValue('AH5', 'A');
		$sheetTeams->setCellValue('AI5', 'T');
		$sheetTeams->setCellValue('AJ5', '100%');
		$sheetTeams->getColumnDimension('AJ')->setVisible(false);
		
		$sheetTeams->setCellValue('AK3', 'Call Volumn');
		$sheetTeams->mergeCells('AK3:AM4');
		$sheetTeams->setCellValue('AK5', 'A');
		$sheetTeams->setCellValue('AL5', 'T');
		$sheetTeams->setCellValue('AM5', '100%');
		$sheetTeams->getColumnDimension('AM')->setVisible(false);
		
		$sheetTeams->setCellValue('AN3', 'Volumn');
		$sheetTeams->mergeCells('AN3:AV3');
		$sheetTeams->setCellValue('AN4', 'A(x4)');
		$sheetTeams->mergeCells('AN4:AP4');
		$sheetTeams->setCellValue('AN5', 'A');
		$sheetTeams->setCellValue('AO5', 'T');
		$sheetTeams->setCellValue('AP5', '100%');
		$sheetTeams->getColumnDimension('AP')->setVisible(false);
		
		$sheetTeams->setCellValue('AQ4', 'B(x3)');
		$sheetTeams->mergeCells('AQ4:AS4');
		$sheetTeams->setCellValue('AQ5', 'A');
		$sheetTeams->setCellValue('AR5', 'T');
		$sheetTeams->setCellValue('AS5', '100%');
		$sheetTeams->getColumnDimension('AS')->setVisible(false);
		
		
		$sheetTeams->setCellValue('AT4', 'C(x1)');
		$sheetTeams->mergeCells('AT4:AV4');
		$sheetTeams->setCellValue('AT5', 'A');
		$sheetTeams->setCellValue('AU5', 'T');
		$sheetTeams->setCellValue('AV5', '100%');
		$sheetTeams->getColumnDimension('AV')->setVisible(false);
		
		$sheetTeams->setCellValue('AW3', 'Call Frequency');
		$sheetTeams->mergeCells('AW3:AY4');
		$sheetTeams->setCellValue('AW5', 'A');
		$sheetTeams->setCellValue('AX5', 'T');
		$sheetTeams->setCellValue('AY5', '100%');
		$sheetTeams->getColumnDimension('AY')->setVisible(false);
		
		$sheetTeams->setCellValue('AZ3', 'Frequency');
		$sheetTeams->mergeCells('AZ3:BH3');
		$sheetTeams->setCellValue('AZ4', 'A');
		$sheetTeams->mergeCells('AZ4:BB4');
		$sheetTeams->setCellValue('AZ5', 'A');
		$sheetTeams->setCellValue('BA5', 'T');
		$sheetTeams->setCellValue('BB5', '100%');
		$sheetTeams->getColumnDimension('BB')->setVisible(false);
		
		$sheetTeams->setCellValue('BC4', 'B');
		$sheetTeams->mergeCells('BC4:BE4');
		$sheetTeams->setCellValue('BC5', 'A');
		$sheetTeams->setCellValue('BD5', 'T');
		$sheetTeams->setCellValue('BE5', '100%');
		$sheetTeams->getColumnDimension('BE')->setVisible(false);
		
		$sheetTeams->setCellValue('BF4', 'C');
		$sheetTeams->mergeCells('BF4:BH4');
		$sheetTeams->setCellValue('BF5', 'A');
		$sheetTeams->setCellValue('BG5', 'T');
		$sheetTeams->setCellValue('BH5', '100%');
		$sheetTeams->getColumnDimension('BH')->setVisible(false);
		
		$sheetTeams->setTitle('Teams');
		
		$sheetTeams->getStyle('A1:BH5')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER
				)
		);
		$sheetTeams->getStyle('A1:BH5')->getFont()->setBold(true);
		
		//build body data
		$sno = 1;
		$index = 6;
		
		$zoneName = $data[0]["productTypeName"];
		foreach ($data as $val) {
				
			$sheetTeams->setCellValue('C'.$index, $val["daysMonth_A"]);
			$sheetTeams->setCellValue('D'.$index, $val["daysMonth_T"]);
			$sheetTeams->setCellValue('I'.$index, $val["weeklyOff_A"]);
			$sheetTeams->setCellValue('J'.$index, $val["weeklyOff_T"]);
				
			$sheetTeams->setCellValue('G'.$index, $val["holidays_A"]);
				$sheetTeams->setCellValue('H'.$index, $val["holidays_T"]);
			$sheetTeams->setCellValue('K'.$index, $val["trainingDays_A"]);
				$sheetTeams->setCellValue('L'.$index, $val["trainingDays_T"]);
			$sheetTeams->setCellValue('M'.$index, $val["promotionDays_A"]);
				$sheetTeams->setCellValue('N'.$index, $val["promotionDays_T"]);
			$sheetTeams->setCellValue('O'.$index, $val["meetingDays_A"]);
				$sheetTeams->setCellValue('P'.$index, $val["meetingDays_T"]);
            $sheetTeams->setCellValue('Q' . $index, $val["leaveTaken_A"]);
				$sheetTeams->setCellValue('R'.$index, $val["leaveTaken_T"]);
				
			
			if ($zoneName != $val["productTypeName"]){
				$sheetTeams->setCellValue('B'.$index, $zoneName);
				
				$sheetTeams->setCellValue('A'.$index, $sno);
				
				$sheetTeams->setCellValue('E'.$index, $dayWorked_A_total);
				$dayWorked_A_total = 0;
				$sheetTeams->setCellValue('F'.$index, $dayWorked_T_total);
				$dayWorked_T_total = 0;
				
				$sheetTeams->setCellValue('S'.$index, $dif_A_total);
				 $dif_A_total= 0;
				$sheetTeams->setCellValue('T'.$index, $dif_T_total);
				$dif_T_total = 0;
				
				$sheetTeams->setCellValue('V'.$index, $callRate_A_average);
				$callRate_A_average = 0;
				$sheetTeams->setCellValue('W'.$index, $callRate_T_average);
				$callRate_T_average = 0;
								
				$sheetTeams->setCellValue('Y'.$index, $callReach_A_total);
				$callReach_A_total = 0;
				$sheetTeams->setCellValue('Z'.$index, $callReach_T_total);
				$callReach_T_total = 0;
								
				$sheetTeams->setCellValue('AB'.$index, $totalDrsA_A_total);
				$totalDrsA_A_total = 0;
				$sheetTeams->setCellValue('AC'.$index, $totalDrsA_T_total);
				$totalDrsA_T_total = 0;
				
				$sheetTeams->setCellValue('AE'.$index,$totalDrsB_A_total);
				$totalDrsB_A_total = 0;
				$sheetTeams->setCellValue('AF'.$index, $totalDrsB_T_total);
				$totalDrsB_T_total = 0;
				
				$sheetTeams->setCellValue('AH'.$index, $totalDrsC_A_total);
				$totalDrsC_A_total = 0;
				$sheetTeams->setCellValue('AI'.$index, $totalDrsC_T_total);
				$totalDrsC_T_total = 0;
				
				$sheetTeams->setCellValue('AK'.$index, $callVolumn_A_total);
				$callVolumn_A_total = 0;
				$sheetTeams->setCellValue('AL'.$index, $callVolumn_T_total);
				$callVolumn_T_total = 0;
				
				$sheetTeams->setCellValue('AN'.$index, $volumnA_A_total);
				$volumnA_A_total = 0;
				$sheetTeams->setCellValue('AO'.$index, $volumnA_T_total);
				$volumnA_T_total = 0;
				
				$sheetTeams->setCellValue('AQ'.$index, $volumnB_A_total);
				$volumnB_A_total = 0;
				$sheetTeams->setCellValue('AR'.$index, $volumnB_T_total);
				$volumnB_T_total = 0;

				$sheetTeams->setCellValue('AT'.$index, $volumnC_A_total);
				$volumnC_A_total = 0;
				$sheetTeams->setCellValue('AU'.$index, $volumnC_T_total);
				$volumnC_T_total = 0;

				$sheetTeams->setCellValue('AW'.$index, $callFrequency_A_average);
				$callFrequency_A_average = 0;
				$sheetTeams->setCellValue('AX'.$index, $callFrequency_T_average);
				$callFrequency_T_average = 0;

				$sheetTeams->setCellValue('AZ'.$index, $frequencyA_A_average);
				$frequencyA_A_average = 0;
				$sheetTeams->setCellValue('BA'.$index, $frequencyA_T_average);
				$frequencyA_T_average = 0;

				$sheetTeams->setCellValue('BC'.$index, $frequencyB_A_average);
				$frequencyB_A_average = 0;
				$sheetTeams->setCellValue('BD'.$index, $frequencyB_T_average);
				$frequencyB_T_average = 0;

				$sheetTeams->setCellValue('BF'.$index, $frequencyC_A_average);
				$frequencyC_A_average = 0;
				$sheetTeams->setCellValue('BG'.$index, $frequencyC_T_average);
				$frequencyC_T_average = 0;
				
				$zoneName = $val["productTypeName"];
				$sno++;
				$index++;
			} 
				
			$dayWorked_A_total = $dayWorked_A_total + $val["dayWorked_A"];
			$dayWorked_T_total = $dayWorked_T_total + $val["dayWorked_T"]; 

			$dif_A_total = $dif_A_total + $val["dif_A"]; 
			$dif_T_total = $dif_T_total + $val["dif_T"]; 
			
			$callRate_A_average = $callRate_A_average + $val["callRate_A"]; 
			$callRate_T_average = $callRate_T_average + $val["callRate_T"]; 

			$callReach_A_total = $callReach_A_total+ $val["callReach_A"]; 
			$callReach_T_total = $callReach_T_total + $val["callReach_T"]; 

			$totalDrsA_A_total = $totalDrsA_A_total + $val["totalDrsA_A"]; 
			$totalDrsA_T_total = $totalDrsA_T_total + $val["totalDrsA_T"]; 

			$totalDrsB_A_total = $totalDrsB_A_total + $val["totalDrsB_A"]; 
		 	$totalDrsB_T_total = $totalDrsB_T_total + $val["totalDrsB_T"]; 
			
			$totalDrsC_A_total = $totalDrsC_A_total + $val["totalDrsC_A"]; 
			$totalDrsC_T_total = $totalDrsC_T_total + $val["totalDrsC_T"]; 

			$callVolumn_A_total = $callVolumn_A_total + $val["callVolumn_A"]; 
			$callVolumn_T_total = $callVolumn_T_total + $val["callVolumn_T"]; 

			$volumnA_A_total = $volumnA_A_total + $val["volumnA_A"]; 
			$volumnA_T_total = $volumnA_T_total + $val["volumnA_T"]; 

			$volumnB_A_total = $volumnB_A_total + $val["volumnB_A"]; 
			$volumnB_T_total = $volumnB_T_total + $val["volumnB_T"]; 
				
			$volumnC_A_total = $volumnC_A_total + $val["volumnC_A"]; 
			$volumnC_T_total = $volumnC_T_total + $val["volumnC_T"]; 

			$callFrequency_A_average = $callFrequency_A_average + $val["callFrequency_A"]; 
			$callFrequency_T_average = $callFrequency_T_average + $val["callFrequency_T"]; 
			
			$frequencyA_A_average = $frequencyA_A_average + $val["frequencyA_A"]; 
			$frequencyA_T_average = $frequencyA_T_average + $val["frequencyA_T"]; 

			$frequencyB_A_average = $frequencyB_A_average + $val["frequencyB_A"]; 
			$frequencyB_T_average = $frequencyB_T_average + $val["frequencyB_T"];  
			
			$frequencyC_A_average = $frequencyC_A_average + $val["frequencyC_A"]; 
			$frequencyC_T_average = $frequencyC_T_average + $val["frequencyC_T"];
		}
		
		$sheetTeams->setCellValue('A'.$index, $sno);
		$sheetTeams->setCellValue('B'.$index, $zoneName);
		
		$sheetTeams->setCellValue('E'.$index, $dayWorked_A_total);
		$sheetTeams->setCellValue('F'.$index, $dayWorked_T_total);
		
		$sheetTeams->setCellValue('S'.$index, $dif_A_total);
		$sheetTeams->setCellValue('T'.$index, $dif_T_total);
		$sheetTeams->setCellValue('V'.$index, $callRate_A_average);
		$sheetTeams->setCellValue('W'.$index, $callRate_T_average);
		$sheetTeams->setCellValue('Y'.$index, $callReach_A_total);
		$sheetTeams->setCellValue('Z'.$index, $callReach_T_total);
		$sheetTeams->setCellValue('AB'.$index, $totalDrsA_A_total);
		$sheetTeams->setCellValue('AC'.$index, $totalDrsA_T_total);
		$sheetTeams->setCellValue('AE'.$index,$totalDrsB_A_total);
		$sheetTeams->setCellValue('AF'.$index, $totalDrsB_T_total);
		$sheetTeams->setCellValue('AH'.$index, $totalDrsC_A_total);
		$sheetTeams->setCellValue('AI'.$index, $totalDrsC_T_total);
		$sheetTeams->setCellValue('AK'.$index, $callVolumn_A_total);
		$sheetTeams->setCellValue('AL'.$index, $callVolumn_T_total);
		$sheetTeams->setCellValue('AN'.$index, $volumnA_A_total);
		$sheetTeams->setCellValue('AO'.$index, $volumnA_T_total);
		$sheetTeams->setCellValue('AQ'.$index, $volumnB_A_total);
		$sheetTeams->setCellValue('AR'.$index, $volumnB_T_total);
		$sheetTeams->setCellValue('AT'.$index, $volumnC_A_total);
		$sheetTeams->setCellValue('AU'.$index, $volumnC_T_total);
		$sheetTeams->setCellValue('AW'.$index, $callFrequency_A_average);
		$sheetTeams->setCellValue('AX'.$index, $callFrequency_T_average);
		$sheetTeams->setCellValue('AZ'.$index, $frequencyA_A_average);
		$sheetTeams->setCellValue('BA'.$index, $frequencyA_T_average);
		$sheetTeams->setCellValue('BC'.$index, $frequencyB_A_average);
		$sheetTeams->setCellValue('BD'.$index, $frequencyB_T_average);
		$sheetTeams->setCellValue('BF'.$index, $frequencyC_A_average);
		$sheetTeams->setCellValue('BG'.$index, $frequencyC_T_average);
		
		$styleArray = array(
				'borders' => array(
						'allborders' => array(
								'style' => PHPExcel_Style_Border::BORDER_DOTTED
						)
				)
		);
		$sheetTeams->getStyle('A1:BH'.$index)->applyFromArray($styleArray);
		return $sheetTeams;
	}
	
	/**
     * Monthly report controller
     * @param $export_date
     * @param $data
     * @param $salesmansTeams
     * @param $data_detail
     * @param $path
     * @throws PHPExcel_Reader_Exception
	 */
    public function create_excel_file_rp($export_date, $data, $salesmansTeams, $data_detail, $path)
    {
        $this->load->library('importexcel/FileManagerExport');
        $objPHPExcel = new PHPExcel();
		
        $sheetDetails = $objPHPExcel->getActiveSheet(1);
        $sheetDetails = $this->buildDetailTeam($export_date, $sheetDetails, $data);

        $sheetTeams = $objPHPExcel->createsheet();
        $sheetTeams = $this->buildSheetTeams($export_date, $sheetTeams, $salesmansTeams);

        $sheetDataDetail = $objPHPExcel->createsheet();
        $sheetDataDetail = $this->buildDetailTeam($export_date, $sheetDataDetail, $data_detail, TRUE);
		
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save($path);
		
    }
}

?>