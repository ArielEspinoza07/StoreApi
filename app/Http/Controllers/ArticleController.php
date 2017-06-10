<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HTTP_CODE;

class ArticleController extends Controller
{
    private $token;
    private $fields;

    public function __construct()
    {
        $this->token    =   '_token';
        $this->fields   =   array(
            'name',
            'description',
            'price',
            'total_in_shelf',
            'total_in_vault',
            'store_id'
        );
    }

    public function index(Request $request)
    {
        try
        {
            $requestParams  =   $request->except($this->token);
            $articles       =   Article::where($requestParams)->get();
            $response       =   array(
                'articles'          => $articles,
                'total_elements'    => $articles->count()
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
            $article        =   Article::findOrFail($id);
            $response       =   array(
                'article'           => $article,
                'total_elements'    => $article->count()
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
            $article        =   Article::firstOrCreate($requestParams);
            $response       =   array(
                'article'           => $article,
                'total_elements'    => $article->count()
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
                $article    =   Article::findOrFail($id);
            }
            catch (\Exception $exception)
            {
                return $this->sendErrorResponse(HTTP_CODE::HTTP_NOT_FOUND,'RECORD NOT FOUND');
            }
            $requestParams  =   $request->except($this->token);
            if(!$this->verifyFieldsRequest($this->fields,$requestParams)) return $this->sendErrorResponse(HTTP_CODE::HTTP_BAD_REQUEST,'BAD REQUEST');
            if($this->verifyFieldsNotEmptyRequest($this->fields,$requestParams)) return $this->sendErrorResponse(HTTP_CODE::HTTP_BAD_REQUEST,'BAD REQUEST');
            $article->fill($requestParams);
            $article->save();
            $response       =   array(
                'article'           => $article,
                'total_elements'    => $article->count()
            );
            return $this->sendSuccessResponse($response);
        }
        catch (\Exception $exception)
        {
            return $this->sendErrorResponse(HTTP_CODE::HTTP_INTERNAL_SERVER_ERROR,'INTERNAL SERVER ERROR');
        }
    }

    public function delete($id)
    {
        try
        {
            if(!is_numeric($id)) return $this->sendErrorResponse(HTTP_CODE::HTTP_BAD_REQUEST,'BAD REQUEST');
            $article        =   Article::findOrFail($id);
            $article->delete();
            $response       =   array(
                'article'           => $article,
                'total_elements'    => $article->count()
            );
            return $this->sendSuccessResponse($response);
        }
        catch (\Exception $exception)
        {
            return $this->sendErrorResponse(HTTP_CODE::HTTP_NOT_FOUND,'RECORD NOT FOUND');
        }
    }
}
