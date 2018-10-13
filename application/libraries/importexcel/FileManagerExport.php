
<?php
class FileManagerExport {
	private $object_import;
	public $Reader;
    public function __construct()
    {
	
			ini_set("max_execution_time", 0);
			ini_set("error_reporting", E_ALL & ~E_DEPRECATED);
			ini_set('display_errors',0);
			ini_set('display_startup_errors',1);
			error_reporting(-1);
			require_once('Classes/PHPExcel.php');
				
    }

}
?>