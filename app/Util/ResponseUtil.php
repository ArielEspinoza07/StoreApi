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
     *
     * @return array
     */
    public static function makeSuccessResponse($data)
    {
        return [
            'success' => (boolean)true,
            'data'    => $data
        ];
    }


    /**
     * @param $code
     * @param $message
     *
     * @return array
     */
    public static function makeErrorResponse($code, $message)
    {
        return [
            'success'    => (boolean)false,
            'error_code' => (int)$code,
            'error_msg'  => (string)$message
        ];
    }
}