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
     * @param $message
     *
     * @return array
     */
    public static function makeSuccessResponse($data, $message)
    {
        self::utf8_encode_deep($data);

        return [
            'success' => (boolean)true,
            'data'    => $data,
            'message' => $message
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


    public static function utf8_encode_deep(&$input)
    {
        if (is_string($input)) {
            $input = utf8_encode($input);
        } else {
            if (is_array($input)) {
                foreach ($input as &$value) {
                    self::utf8_encode_deep($value);
                }

                unset($value);
            } else {
                if (is_object($input)) {
                    $vars = array_keys(get_object_vars($input));

                    foreach ($vars as $var) {
                        self::utf8_encode_deep($input->$var);
                    }
                }
            }
        }
    }
}