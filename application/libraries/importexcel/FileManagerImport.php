
<?php
class FileManagerImport {
	private $object_import;
	public $Reader;
    public function __construct()
    {
	
			ini_set("max_execution_time", 0);
			ini_set("error_reporting", E_ALL & ~E_DEPRECATED);
			ini_set('display_errors',0);
			ini_set('display_startup_errors',1);
			error_reporting(-1);
			require('php-excel-reader/excel_reader2.php'); 
			require('SpreadsheetReader.php');
		         
    }

    public function startGetSheetForStore(){
    		$Reader = new SpreadsheetReader(STATIC_REAL_SERVER.'/'.'GM_Doctor_List_2015.xlsx');
			$Sheets = $Reader -> Sheets();
				// $existed = $object_import->import_select();
			 
				// $this -> ColumnCount = $this -> Handle -> sheets[$this -> CurrentSheet]['numCols'];
				// echo $RowCount = $Reader[$CurrentSheet]['numRows'];

			foreach ($Sheets as $Index => $Name)
			{ 

				if ($Index == 1 ){//|| $Index == 2 || $Index == 3){
					echo ' <div style="font-weight:bold;"> Sheet #'.$Index.': '.$Name. " start importing...</div><br/>";
						$Reader -> ChangeSheet($Index);
						// echo $Reader->rowcount();
							//start build
						$sqlData = "";
						$sqlDataInsert = "";
						$batch = 0;
							foreach ($Reader as $rowIndex=>$Row){
								if ($rowIndex > 3){ //bo nhung row ko sai
									if (count($Row) > 16) {
										echo "Please check again column excel <br/>";
									}

									//get column build data 
									$sqlData ="(";
									foreach ($Row as $indexColumn=>$value){
										if ($indexColumn != 0 && $indexColumn <= 15) // khong can insert No
										{

										    // if ($indexColumn == 1 && in_array(strtolower($value), $existed)){
			    							// 	goto end; 
			    							// }
			    							// array_push($existed,strtolower($value));
											if ($sqlData == "(")
			    				 				$sqlData .="'".addslashes($value)."'";
			    							else 
			    								$sqlData .=",'".addslashes($value)."'";

										}
									}
									$sqlData .=")";
									$sqlDataInsert .= $sqlData;						
								
							}
							end:
							if ($batch >= 200){
								echo "column: ".count($Row)."<br/>";
								echo "start insert  batch <br/>";
								 // print_r($existed);

									//echo str_replace(")(","),(",$sqlDataInsert)."<br/>";
							 	// $reslt = $object_import->import_data_after_build(str_replace(")(","),(",$sqlDataInsert)); 
								echo "end insert batch <br/>";					
								$sqlData = "";
								$sqlDataInsert = "";
								$batch = 0;
								usleep(100000); // debuging purpose
							     ob_flush();
							     flush();
							}
							$batch++;
						}
			  
							//echo str_replace(")(","),(",$sqlDataInsert)."<br/>";
						  // $reslt = $object_import->import_data_after_build(str_replace(")(","),(",$sqlDataInsert)); 
						echo " <div style='font-weight:bold;'> end importing... </div><br/>";
				}
			}

    }

    public function getSheets($filePath){
    		$this->Reader = new SpreadsheetReader($filePath);

    }


}
?>