<?php
/**
 * Created by PhpStorm.
 * User: aespinoza
 * Date: 18/07/18
 * Time: 02:29 PM
 */

namespace App\Util;

class TransformUtil
{
    public static function giveFormatDate($date, $format){
        //dd($date,$format);
        return date_format(date_create($date),$format);
    }
}