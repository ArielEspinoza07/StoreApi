<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Util\RequestUtil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\Store as StoreResource;
use App\Http\Resources\StoreCollection as StoreCollectionResource;
use Symfony\Component\HttpFoundation\Response as HTTP_CODE;

class StoreController extends Controller
{

    private $token;
    private $fields;


    public function __construct()
    {
        $this->token  = '_token';
        $this->fields = [
            'name',
            'address'
        ];
    }


    public function index(Request $request)
    {
        try {
            $requestParams = collect($request->except($this->token));
            Log::info('Params send to store '.$requestParams->toJson());
            $requestParams->forget('page');
            $limit       = $requestParams->pull('limit');
            $order       = $requestParams->pull('order','created_at');
            $by          = $requestParams->pull('by','desc');
            $storesQuery = Store::name($requestParams->pull('name'))
                                ->where($requestParams->toArray())
                                ->orderBy($order, $by);
            if ($limit) {
                $stores = $storesQuery->paginate($limit);
            } else {
                $stores = $storesQuery->get();
            }
            $response = new StoreCollectionResource($stores);

            return $this->sendSuccessResponse($response,'');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());

            return $this->sendErrorResponse(HTTP_CODE::HTTP_BAD_REQUEST, 'BAD REQUEST');
        }
    }


    public function show($id)
    {
        try {
            if ( ! is_numeric($id)) {
                return $this->sendErrorResponse(HTTP_CODE::HTTP_BAD_REQUEST, 'BAD REQUEST');
            }
            $store    = Store::findOrFail($id);
            $response = [
                'store'          => new StoreResource($store),
                'total_elements' => count($store)
            ];

            return $this->sendSuccessResponse($response,'');
        } catch (\Exception $exception) {
            return $this->sendErrorResponse(HTTP_CODE::HTTP_NOT_FOUND, 'RECORD NOT FOUND');
        }
    }


    public function store(Request $request)
    {
        try {
            $requestParams = $request->except($this->token);
            if ( ! RequestUtil::verifyFieldsRequest($this->fields, $requestParams)) {
                return $this->sendErrorResponse(HTTP_CODE::HTTP_BAD_REQUEST, 'BAD REQUEST');
            }
            if (RequestUtil::verifyFieldsNotEmptyRequest($this->fields, $requestParams)) {
                return $this->sendErrorResponse(HTTP_CODE::HTTP_BAD_REQUEST, 'BAD REQUEST');
            }
            $store    = Store::firstOrCreate($requestParams);
            $response = [
                'store'          => new StoreResource($store),
                'total_elements' => count($store)
            ];

            return $this->sendSuccessResponse($response,'');
        } catch (\Exception $exception) {
            return $this->sendErrorResponse(HTTP_CODE::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL SERVER ERROR');
        }
    }


    public function update(Request $request, $id)
    {
        try {
            if ( ! is_numeric($id)) {
                return $this->sendErrorResponse(HTTP_CODE::HTTP_BAD_REQUEST, 'BAD REQUEST');
            }
            try {
                $store = Store::findOrFail($id);
            } catch (\Exception $exception) {
                return $this->sendErrorResponse(HTTP_CODE::HTTP_NOT_FOUND, 'RECORD NOT FOUND');
            }
            $requestParams = $request->except($this->token);
            if ( ! RequestUtil::verifyFieldsRequest($this->fields, $requestParams)) {
                return $this->sendErrorResponse(HTTP_CODE::HTTP_BAD_REQUEST, 'BAD REQUEST');
            }
            if (RequestUtil::verifyFieldsNotEmptyRequest($this->fields, $requestParams)) {
                return $this->sendErrorResponse(HTTP_CODE::HTTP_BAD_REQUEST, 'BAD REQUEST');
            }
            $store->fill($requestParams);
            $store->save();
            $response = [
                'store'          => new StoreResource($store),
                'total_elements' => count($store)
            ];

            return $this->sendSuccessResponse($response,'');
        } catch (\Exception $exception) {
            return $this->sendErrorResponse(HTTP_CODE::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL SERVER ERROR');
        }
    }


    public function delete($id)
    {
        try {
            if ( ! is_numeric($id)) {
                return $this->sendErrorResponse(HTTP_CODE::HTTP_BAD_REQUEST, 'BAD REQUEST');
            }
            $store = Store::findOrFail($id);
            $store->delete();
            $response = [
                'store'          => new StoreResource($store),
                'total_elements' => count($store)
            ];

            return $this->sendSuccessResponse($response,'');
        } catch (\Exception $exception) {
            return $this->sendErrorResponse(HTTP_CODE::HTTP_NOT_FOUND, 'RECORD NOT FOUND');
        }
    }
}
