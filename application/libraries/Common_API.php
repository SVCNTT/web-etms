<?php
/**
 * CodeIgnighter layout support library
 *  with Twig like inheritance blocks
 *
 * v 1.0
 *
 *
 * @author Constantin Bosneaga
 * @email  constantin@bosneaga.com
 * @url    http://a32.me/
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Common_API {


    public function checkSignature($params) {
//        return TRUE;

        /*Get sig*/
        $sig = isset($params['sig']) ? $params['sig'] : '';
        unset($params['sig']);  //Remove key 'sig'
        /*Get sig - END*/

        /*Generate sig*/
        ksort($params); //sort alphabetically
            $sig_str = '';
        if (!empty($params)) {
            foreach($params as $v) {
                $sig_str .= $v . '#';
            }
        }

            $sig_str .= API_SECRET_KEY;
            $generate_sig = md5(md5($sig_str).API_SECRET_KEY);
//            var_dump($generate_sig);
        /*Generate sig - END*/

        /*Check sig*/
        if (!empty($sig) && $generate_sig == $sig) {
            return TRUE;
        }
        /*Check sig - END*/

        return FALSE;
    }


    public function checkTimestamp($params) {
        return TRUE;

        /*Get timestamp*/
        $ts = isset($params['ts']) ? $params['ts'] : '';
        /*Get timestamp - END*/

        /*Check timestamp*/
        $time = time();

//        var_dump($time);exit;
        if (($time - $ts) > API_DELAY_TIME) {
            return FALSE;
        }
        /*Check timestamp - END*/

        return TRUE;
    }
}