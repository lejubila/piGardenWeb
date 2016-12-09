<?php
/**
 * Cron Helper
 * User: lejubila
 * Date: 07/12/16
 * Time: 8.50
 */

namespace app;

class CronHelper {

    public static function explode($strCron)
    {
        $cron = [
            'min' => [],
            'hour' => [],
            'dom' => [],
            'month' => [],
            'dow' => []
        ];

        $arrCron = explode(' ', $strCron);
        if(!empty($arrCron))
        {
            $arrCronType = array_keys($cron);
            $i = 0;
            foreach($arrCron as $itemCron)
            {
                $type = $arrCronType[$i];
                $cron[$type] = explode(',', $itemCron);

                $i++;
                if($i==count($arrCronType))
                {
                    break;
                }
            }
        }

        return $cron;
    }

    public static function getStringMin($arr)
    {
        return implode(', ', 
                   array_map(function($i){
                       return ($i=='*' ? trans('cron.min.every') : $i);
                   },
                   $arr)
               );
    }

    public static function getStringHour($arr)
    {
        return implode(', ', 
                   array_map(function($i){
                       return ($i=='*' ? trans('cron.hour.every') : $i);
                   },
                   $arr)
               );
    }

    public static function getStringDow($arr)
    {
         return implode(', ', 
                   array_map(function($i){
                       return ($i=='*' ? trans('cron.dow.every') : trans('cron.dow.'.$i));
                   },
                   $arr)
               );
    }

    public static function getStringMonth($arr)
    {
         return implode(', ', 
                   array_map(function($i){
                       return ($i=='*' ? trans('cron.month.every') : trans('cron.month.'.$i));
                   },
                   $arr)
               );
    }

    public static function getStringDom($arr)
    {
         return implode(', ', 
                   array_map(function($i){
                       return ($i=='*' ? trans('cron.dom.every') : trans('cron.month.'.$i));
                   },
                   $arr)
               );
    }

}
