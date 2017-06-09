<?php

namespace App\Http\Controllers;

use Response;
use App\Util\ResponseUtil;
use App\Util\Traits\RequestUtil;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;
    use RequestUtil;

    /**
     * @param $data
     * @return mixed
     */
    protected function sendSuccessResponse($data)
    {
        $this->utf8_encode_deep($data);
        return Response::json(ResponseUtil::makeSuccessResponse($data),200);
    }

    /**
     * @param $code
     * @param $message
     * @return mixed
     */
    protected function sendErrorResponse($code, $message)
    {
        return Response::json(ResponseUtil::makeErrorResponse($code,$message),$code);
    }

    /**
     * @param $input
     */
    protected function utf8_encode_deep(&$input)
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
