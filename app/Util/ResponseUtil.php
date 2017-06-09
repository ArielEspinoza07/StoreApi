<?php
/**
 * Created by PhpStorm.
 * User: Ariel-PC
 * Date: 8/6/2017
 * Time: 9:34 PM
 */

namespace App\Util;


class ResponseUtil
{
    /**
     * @param $data
     * @return array
     */
    public static function makeSuccessResponse($data)
    {
        return array_merge($data,array('success'=>(boolean)true));
    }

    /**
     * @param $code
     * @param $message
     * @return array
     */
    public static function makeErrorResponse($code, $message)
    {
        return array('success'=>(boolean)false,'error_code' => (int)$code,'error_msg' => (string)$message);
    }
}