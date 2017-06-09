<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\StoreLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response as HTTP_CODE;

class StoreController extends Controller
{
    private $token;
    private $fields;

    public function __construct()
    {
        $this->token    =   '_token';
        $this->fields   =   array('name',
            'address'
        );
    }

    public function index(Request $request)
    {
        try
        {
            $requestParams  =   $request->except($this->token);
            $stores         =   Store::where($requestParams)->get();
            $response       =   array(
                'stores'            => $stores,
                'total_elements'    => $stores->count()
            );
            return $this->sendSuccessResponse($response);
        }
        catch (\Exception $exception)
        {
            return $this->sendErrorResponse(HTTP_CODE::HTTP_BAD_REQUEST,'BAD REQUEST');
        }
    }

    public function show($id)
    {
        try
        {
            if(!is_numeric($id)) return $this->sendErrorResponse(HTTP_CODE::HTTP_BAD_REQUEST,'BAD REQUEST');
            $store          =   Store::findOrFail($id);
            $response       =   array(
                'store'             => $store,
                'total_elements'    => $store->count()
            );
            return $this->sendSuccessResponse($response);
        }
        catch (\Exception $exception)
        {
            return $this->sendErrorResponse(HTTP_CODE::HTTP_NOT_FOUND,'RECORD NOT FOUND');
        }
    }

    public function store(Request $request)
    {
        try
        {
            $requestParams  =   $request->except($this->token);
            if(!$this->verifyFieldsRequest($this->fields,$requestParams)) return $this->sendErrorResponse(HTTP_CODE::HTTP_BAD_REQUEST,'BAD REQUEST');
            if($this->verifyFieldsNotEmptyRequest($this->fields,$requestParams)) return $this->sendErrorResponse(HTTP_CODE::HTTP_BAD_REQUEST,'BAD REQUEST');
            $store          =   Store::firstOrCreate($requestParams);
            $response       =   array(
                'store'             => $store,
                'total_elements'    => $store->count()
            );

            return $this->sendSuccessResponse($response);
        }
        catch (\Exception $exception)
        {
            return $this->sendErrorResponse(HTTP_CODE::HTTP_INTERNAL_SERVER_ERROR,'INTERNAL SERVER ERROR');
        }
    }

    public function update(Request $request,$id)
    {
        try
        {
            if(!is_numeric($id)) return $this->sendErrorResponse(HTTP_CODE::HTTP_BAD_REQUEST,'BAD REQUEST');
            try
            {
                $store      =   Store::findOrFail($id);
            }
            catch (\Exception $exception)
            {
                return $this->sendErrorResponse(HTTP_CODE::HTTP_NOT_FOUND,'RECORD NOT FOUND');
            }
            $requestParams  =   $request->except($this->token);
            if(!$this->verifyFieldsRequest($this->fields,$requestParams)) return $this->sendErrorResponse(HTTP_CODE::HTTP_BAD_REQUEST,'BAD REQUEST');
            if($this->verifyFieldsNotEmptyRequest($this->fields,$requestParams)) return $this->sendErrorResponse(HTTP_CODE::HTTP_BAD_REQUEST,'BAD REQUEST');
            $store->fill($requestParams);
            $store->save();
            $response       =   array(
                'store'             => $store,
                'total_elements'    => $store->count()
            );
            return $this->sendSuccessResponse($response);
        }
        catch (\Exception $exception)
        {
            return $this->sendErrorResponse(HTTP_CODE::HTTP_INTERNAL_SERVER_ERROR,'INTERNAL SERVER ERROR');
        }
    }

    public function articlesStore($id)
    {
        try
        {
            if(!is_numeric($id)) return $this->sendErrorResponse(HTTP_CODE::HTTP_BAD_REQUEST,'BAD REQUEST');
            $store          =   Store::findOrFail($id);
            $store->articles;
            $response       =   array(
                'store'             => $store,
                'total_elements'    => $store->count()
            );
            return $this->sendSuccessResponse($response);
        }
        catch (\Exception $exception)
        {
            return $this->sendErrorResponse(HTTP_CODE::HTTP_NOT_FOUND,'RECORD NOT FOUND');
        }
    }
}
