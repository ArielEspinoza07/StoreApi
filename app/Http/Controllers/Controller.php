<?php

namespace App\Http\Controllers;

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

    /**
     * @param $data
     * @return mixed
     */
    protected function sendSuccessResponse($data,$message)
    {
        return response()->json(ResponseUtil::makeSuccessResponse($data,$message),200);
    }

    /**
     * @param $code
     * @param $message
     * @return mixed
     */
    protected function sendErrorResponse($code, $message)
    {
        return response()->json(ResponseUtil::makeErrorResponse($code,$message),$code);
    }

}
