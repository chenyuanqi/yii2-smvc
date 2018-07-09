<?php

namespace common\helpers;

final class TimeHelper
{
    /**
     * 函数 getTheMsec 获取当前的微秒时间戳
     *
     * @param void
     * @return float
     */
    public static function microtime()
    {
        list($msec, $sec) = explode(' ', microtime());

        return number_format((($msec + $sec) * 1000000), 0, '', '');
    }

    /**
     * 格式化时间格式为 'Y-d-m H:i:s u'
     * 
     * @param string $format
     * @param float  $time
     * @return string
     */
    public static function date($format, $time = null)
    {
        $time = null === $time ? microtime(true) : $time;
        $millisec = round(($time - intval($time)) * 1000);

        if (1000 == $millisec){
            $time++;
            $millisec = 0;
        }

        $millisec = str_pad(strval($millisec), 3, '0', STR_PAD_LEFT);

        return date(strtr($format, ['u' => $millisec]), intval($time));
    }

    /**
     * 函数 getAgeByTimestamp 根据时间戳得到年龄
     *
     * @param timestamp int [必选]    时间戳
     * @return int
     */
    public static function getAge($timestamp, $by = null, $format = 'Y-m-d')
    {
        $b = explode('-', date($format, $timestamp));
        $n = explode('-', date($format, null === $by ? time() : $by));

        $age = $n[0] - $b[0] - 1;
        unset($n[0]);
        unset($b[0]);

        $total = count($b);
        foreach($b as $key => $value){
            if ($n[$key] < $b[$key]){
                break;
            }elseif (($n[$key] > $b[$key]) || ($n[$key] == $b[$key] && $key == $total - 1)){
                $age++;
                break;
            }
        }

        return $age;
    }
}


