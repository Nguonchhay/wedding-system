<?php
namespace App\Utility;

class DateFormat {



    /**
     * @param $date
     * @param $format
     * @return bool|string
     */
    public static function getFormatDate($date, $format = 'Y-m-d') {
        $date = trim($date);
        if ($date == '') {
            return $date;
        }

        $dateObject = date_create($date);
        return date_format($dateObject, $format);
    }
}