<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Ftp_upload {
    private static $_instance;
    private $conn_id = null;
    private $login_result = null;
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
        $CI =& get_instance();
        $configs = $CI->config->item('ftp');
        if ($configs) {
            $config = isset($configs[ENVIRONMENT]) ? $configs[ENVIRONMENT] : null;
            if ($config) {
                $ftp_server = $config['server'];
                $ftp_port = $config['port'];
                $ftp_user_name = $config['username'];
                $ftp_password = $config['password'];
                $this->upload_path = $config['upload_path'];

                // set up a connection or die
                $this->conn_id = ftp_connect($ftp_server, $ftp_port) or die("Couldn't connect to $ftp_server");

                $this->login_result = ftp_login($this->conn_id, $ftp_user_name, $ftp_password) or die("You do not have access to this ftp server!");
            }
        }
    }

    public function upload($name, $file, $root = '', $mode = FTP_BINARY) {
        if ($this->login_result) {
            $rs1 = '/'.date("Y").'/'.date("m").'/'.date('d');
            $rs2 = '/'.date("His").'-'.$name;
            $paths = $this->upload_path.'/'.ENVIRONMENT.$root.$rs1;
            $this->_makeDir($paths);

            $paths .= $rs2;

//            Turns passive mode on
            ftp_pasv($this->conn_id, true);

            // upload the file to the path specified
            $upload = ftp_put($this->conn_id, $paths, $file, $mode);

            // check the upload status
            if (!$upload) {
                return FALSE;
            } else {
                return $rs1.$rs2;
            }

        } else {
            ftp_close($this->conn_id);
            return FALSE;
        }

        return FALSE;
    }

    private function _makeDir ($path) {
        $parts = explode("/",$path);
        $return = true;
        $fullpath = '';
        foreach($parts as $part){
            if(empty($part)){
                $fullpath .= "/";
                continue;
            }
            $fullpath .= $part."/";
            if(@ftp_chdir($this->conn_id, $fullpath)){
                @ftp_chdir($this->conn_id, $fullpath);
            }else{
                if(@ftp_mkdir($this->conn_id, $part)){
                    @ftp_chdir($this->conn_id, $part);
                }else{
                    $return = false;
                }
            }
        }
        return $return;
    }

    public function deleteFile($path){
        if ($this->login_result) {
            return ftp_delete($this->conn_id, $this->upload_path.$path);
        }

        return false;
    }

    public function ftp_close() {
        //Close connection
        ftp_close($this->conn_id);
    }
}

/* End of file FTP_upload.php */