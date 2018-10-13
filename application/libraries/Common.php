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

class Common {


    public function getDayWeeklyOff($date) {
        $time1 = mktime(0, 0, 0, date('m', strtotime($date)), 1, date('Y', strtotime($date)));
        $time2 = mktime(0, 0, 0, date('m', strtotime($date)), date('t', strtotime($date)), date('Y', strtotime($date)));

        $days = 0;
        while ($time1 <= $time2) {
            $chk = date('D', $time1); # Actual date conversion
            if ($chk == 'Sat' || $chk == 'Sun') {
                $days++;
            }
            $time1 += 86400; # Add a day
        }

        return [
            "weeklyOff_A" => 0,
            "weeklyOff_T" => $days
        ];
    }

}