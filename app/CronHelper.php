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
                if(count($cron[$type])>0){
                    $arrTmp = [];
                    foreach($cron[$type] as $itemTmp) {
                        $arrTmp[] = "$type-$itemTmp";
/*
                        if($itemTmp != '*' && substr($itemTmp,0,1)!='v')
                            $arrTmp[] = 'v'.$itemTmp;
                        else
                            $arrTmp[] = $itemTmp;
*/
                    }
                    $cron[$type] = $arrTmp;
                }

                $i++;
                if($i==count($arrCronType))
                {
                    break;
                }
            }
        }

        return $cron;
    }

    public static function normalize($strCron) {

        $arrCron = explode(' ', $strCron);
        if($t=count($arrCron)<5){
            for($i=$t; $i<5; $i++){
                $arrCron[] = '*';
            }
        }
        $arrCron = array_slice($arrCron, 0, 5);
        return implode(' ', $arrCron);
    }

    public static function getMinString($arr)
    {
        return implode(', ', 
                   array_map(function($i){
                       return ($i=='*' ? trans('cron.min.every') : substr($i,4));
                   },
                   $arr)
               );
    }

    public static function getMinSelectItemArray($exclude=''){
        if(!is_array($exclude)){
            $exclude = [$exclude];
        }

        $itemKeys = ['min-*'];
        for($i=0; $i<=59; $i++){ $itemKeys[] = "min-$i"; }

        $items = [];
        foreach($itemKeys as $i){
            if(in_array($i, $exclude)) continue;
            $items["$i"] = ($i=='min-*' ? trans('cron.min.every') : trans('cron.min.title').' '.substr($i,4));
        }
        return $items;
    }

    public static function getHourString($arr)
    {
        return implode(', ', 
                   array_map(function($i){
                       return ($i=='*' ? trans('cron.hour.every') : substr($i,5));
                   },
                   $arr)
               );
    }

    public static function getHourSelectItemArray($exclude=''){
        if(!is_array($exclude)){
            $exclude = [$exclude];
        }

        $itemKeys = ['hour-*'];
        for($i=0; $i<=23; $i++){ $itemKeys[] = "hour-$i"; }

        $items = [];
        foreach($itemKeys as $i){
            if(in_array($i, $exclude)) continue;
            $items["$i"] = ($i=='hour-*' ? trans('cron.hour.every') : trans('cron.hour.title').' '.substr($i,5));
        }
        return $items;
    }

    public static function getDowString($arr)
    {
         return implode(', ', 
                   array_map(function($i){
                       return ($i=='*' ? trans('cron.dow.every') : trans('cron.dow.'.$i));
                   },
                   $arr)
               );
    }

    public static function getDowSelectItemArray($exclude=''){
        if(!is_array($exclude)){
            $exclude = [$exclude];
        }

        $itemKeys = ['dow-*'];
        for($i=1; $i<=7; $i++){ $itemKeys[] = "dow-$i"; }

        $items = [];
        foreach($itemKeys as $i){
            if(in_array($i, $exclude)) continue;
            $items["$i"] = ($i=='dow-*' ? trans('cron.dow.every') : trans('cron.dow.'.$i));
        }
        return $items;
    }

    public static function getMonthString($arr)
    {
         return implode(', ', 
                   array_map(function($i){
                       return ($i=='*' ? trans('cron.month.every') : trans('cron.month.'.$i));
                   },
                   $arr)
               );
    }

    public static function getMonthSelectItemArray($exclude=''){
        if(!is_array($exclude)){
            $exclude = [$exclude];
        }

        $itemKeys = ['month-*'];
        for($i=1; $i<=12; $i++){ $itemKeys[] = "month-$i"; }

        $items = [];
        foreach($itemKeys as $i){
            if(in_array($i, $exclude)) continue;
            $items["$i"] = ($i=='month-*' ? trans('cron.month.every') : trans('cron.month.'.$i));
        }
        return $items;
    }

    public static function getDomString($arr)
    {
         return implode(', ', 
                   array_map(function($i){
                       return ($i=='*' ? trans('cron.dom.every') : $i);
                   },
                   $arr)
               );
    }

    public static function getDomSelectItemArray($exclude=''){
        if(!is_array($exclude)){
            $exclude = [$exclude];
        }

        $itemKeys = ['dom-*'];
        for($i=1; $i<=31; $i++){ $itemKeys[] = "dom-$i"; }

        $items = [];
        foreach($itemKeys as $i){
            if(in_array($i, $exclude)) continue;
            $items["$i"] = ($i=='dom-*' ? trans('cron.dom.every') : trans('cron.dom.title').' '.substr($i,4));
        }
        return $items;
    }

    public static function getAllSelectItemArray($exclude=''){
        return [
            trans('cron.min.title') => self::getMinSelectItemArray($exclude),
            trans('cron.hour.title') => self::getHourSelectItemArray($exclude),
            trans('cron.dom.title') => self::getDomSelectItemArray($exclude),
            trans('cron.month.title') => self::getMonthSelectItemArray($exclude),
            trans('cron.dow.title') => self::getDowSelectItemArray($exclude),
        ];
    }
}
