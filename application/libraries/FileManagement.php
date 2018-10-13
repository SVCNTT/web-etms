<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class FileManagement {
    private static $_instance;
    private $upload_path = '';

    public function getInstance()
    {
        if (self::$_instance == null)
        {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function __construct()
    {
        //TODO: constructor
        //Get config
        //$CI =& get_instance();
		//$this->upload_path = $config['upload_path'];
    }
	public function saveImage ($base64,$moduleName,$typeImage )
	{
		$data = base64_decode($base64);
		$dateNow = new DateTime();
		$path = STATIC_REAL_SERVER."/".$moduleName."/".$dateNow->format('Y')."/".$dateNow->format('m')."/".$dateNow->format('d');
		switch ($typeImage) {
			case 'png':
				$fileName= $moduleName.'_'.strtotime(date('Y-m-d H:i:s')).'.png';
				break;
			case 'jpg':
				$fileName= $moduleName.'_'.strtotime(date('Y-m-d H:i:s')).'.jpg';
				break;
			case 'gif':
				$fileName= $moduleName.'_'.strtotime(date('Y-m-d H:i:s')).'.gif';
				break;
			default:
				$fileName= $moduleName.'_'.strtotime(date('Y-m-d H:i:s')).'.png';
			break;
		}
		
		if (!file_exists($path)) {
			mkdir($path, 0777, true);
			$path .= "/".$fileName;
			
			if(!file_exists($path))
			{
				file_put_contents($path, $data);
				return $path;
			}
		} else {
			$path .= "/".$fileName;
			
			if(!file_exists($path))
			{
				file_put_contents($path, $data);
				return $path;
			}
		}
		return '';
	}
    

    public function saveImageWeb ($moduleName, $file_upload, $typeImage)
	{
		 
		$dateNow = new DateTime();
		$path = STATIC_REAL_SERVER."/".$moduleName."/".$dateNow->format('Y')."/".$dateNow->format('m')."/".$dateNow->format('d');
		switch ($typeImage) {
			case 'png':
				$fileName= $moduleName.'_'.strtotime(date('Y-m-d H:i:s')).'.png';
				break;
			case 'jpg':
				$fileName= $moduleName.'_'.strtotime(date('Y-m-d H:i:s')).'.jpg';
				break;
			case 'gif':
				$fileName= $moduleName.'_'.strtotime(date('Y-m-d H:i:s')).'.gif';
				break;
			default:
				$fileName= $moduleName.'_'.strtotime(date('Y-m-d H:i:s')).'.png';
			break;
		}

		if (!file_exists($path)) {
			mkdir($path, 0777, true);
			$path .= "/".$fileName;
			
			if(!file_exists($path))
			{
				
				move_uploaded_file($file_upload, $path);
				return "/".$path;
			}
		} else {
			$path .= "/".$fileName;
			
			if(!file_exists($path))
			{
				 
				move_uploaded_file($file_upload, $path);
				return "/".$path;
			}
		}
		return '';
	}

	

    public function saveFileImport ($moduleName, $file_upload, $typeImage)
	{
		 
		$dateNow = new DateTime();
		$path = STATIC_REAL_SERVER."/".$moduleName."/".$dateNow->format('Y')."/".$dateNow->format('m')."/".$dateNow->format('d');
 
			$fileName= $moduleName.'_'.strtotime(date('Y-m-d H:i:s')).'.'.$typeImage;
	 
		if (!file_exists($path)) {
			mkdir($path, 0777, true);
			$path .= "/".$fileName;
			
			if(!file_exists($path))
			{
				
				move_uploaded_file($file_upload, $path);
				return $path;
			}
		} else {
			$path .= "/".$fileName;
			
			if(!file_exists($path))
			{
				 
				move_uploaded_file($file_upload, $path);
				return $path;
			}
		}
		return '';
	}	

	public  function createFolderDefault($path) {
		if (!file_exists($path)) {
			mkdir($path, 0777, true);
		}
	}

	
}
?>