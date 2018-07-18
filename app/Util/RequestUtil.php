<?php
/**
 * Created by PhpStorm.
 * User: aespinoza
 * Date: 18/07/18
 * Time: 02:19 PM
 */

namespace App\Util;

class RequestUtil
{

    /**
     * @param array $fields
     * @param array $request
     *
     * @return bool
     */
    public static function verifyFieldsRequest(array $fields, array $request)
    {
        $exists =   true;
        foreach ($fields as $field)
        {
            if(!array_key_exists($field,$request))
            {
                return false;
                break;
            }
        }

        return $exists;
    }


    /**
     * @param array $fields
     * @param array $request
     *
     * @return bool
     */
    public static function verifyFieldsNotEmptyRequest(array $fields, array $request)
    {
        $empty  =   false;
        foreach ($fields as $field)
        {
            if(is_null($request[$field]))
            {
                return true;
                break;
            }
        }

        return $empty;
    }
}