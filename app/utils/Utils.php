<?php
/**
 * Created by PhpStorm.
 * User: owenl
 * Date: 2018-11-10
 * Time: 13:10
 */

namespace Utils;


use DateTime;

class Utils
{

    static function validateDate($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }

    static function getTimeFromParams($params)
    {
        if(!isset($params)) {
            return self::formatBeginAndEndTime(null,null);
        }
        return self::formatBeginAndEndTime($params['beginTime'] ? $params['beginTime'] : null, $params['endTime'] ? $params['endTime'] : null);
    }

    static function formatBeginAndEndTime($beginTime, $endTime)
    {
        if (!$beginTime && !$endTime) {
            $beginTime = date('Y-m-d');
            $endTime = date('Y-m-d H:i:s', mktime(23, 59, 59));
        } else if (!$endTime) {
            $endTime = date('Y-m-d H:i:s', mktime(23, 59, 59));
        } else if (!$beginTime) {
            $beginTime = strtotime(date('Y-m-d', $endTime) . ' 00:00:00');
        }
        if (self::validateDate($beginTime)) {
            $beginTime = strtotime($beginTime . ' 00:00:00');
        }
        if (self::validateDate($endTime)) {
            $endTime = strtotime($endTime . ' 23:59:59');
        }
        return [':beginTime' => date('Y-m-d H:i:s',$beginTime), ':endTime' => date('Y-m-d H:i:s',$endTime)];
    }

    static function genToken($length = 12) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

}