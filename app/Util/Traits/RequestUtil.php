<?php
/**
 * Created by PhpStorm.
 * User: Ariel-PC
 * Date: 8/6/2017
 * Time: 11:12 PM
 */

namespace App\Util\Traits;


trait RequestUtil
{
    protected function verifyFieldsRequest(array $fields, array $request)
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

    protected function verifyFieldsNotEmptyRequest(array $fields, array $request)
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