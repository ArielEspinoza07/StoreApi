<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\Article as ArticleResource;
use App\Http\Resources\ArticleCollection as ArticleCollectionResource;
use Symfony\Component\HttpFoundation\Response as HTTP_CODE;

class ArticleController extends Controller
{

    private $token;
    private $fields;


    public function __construct()
    {
        $this->token  = '_token';
        $this->fields = [
            'name',
            'description',
            'price',
            'total_in_shelf',
            'total_in_vault',
            'store_id'
        ];
    }


    public function index(Request $request)
    {
        try {
            $requestParams = collect($request->except($this->token));
            Log::info('Params send to articles ' . $requestParams->toJson());
            $requestParams->forget('page');
            $limit         = $requestParams->pull('limit');
            $articlesQuery = Article::name($requestParams->pull('name'))->where($requestParams->toArray());
            if ($limit) {
                $articles = $articlesQuery->paginate(2);
            } else {
                $articles = $articlesQuery->get();
            }
            $response = new ArticleCollectionResource($articles);

            return $this->sendSuccessResponse($response);
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
            $article  = Article::findOrFail($id);
            $response = [
                'article'        => new ArticleResource($article),
                'total_elements' => count($article)
            ];

            return $this->sendSuccessResponse($response);
        } catch (\Exception $exception) {
            return $this->sendErrorResponse(HTTP_CODE::HTTP_NOT_FOUND, 'RECORD NOT FOUND');
        }
    }


    public function store(Request $request)
    {
        try {
            $requestParams = $request->except($this->token);
            if ( ! $this->verifyFieldsRequest($this->fields, $requestParams)) {
                return $this->sendErrorResponse(HTTP_CODE::HTTP_BAD_REQUEST, 'BAD REQUEST');
            }
            if ($this->verifyFieldsNotEmptyRequest($this->fields, $requestParams)) {
                return $this->sendErrorResponse(HTTP_CODE::HTTP_BAD_REQUEST, 'BAD REQUEST');
            }
            $article  = Article::firstOrCreate($requestParams);
            $response = [
                'article'        => new ArticleResource($article),
                'total_elements' => count($article)
            ];

            return $this->sendSuccessResponse($response);
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
                $article = Article::findOrFail($id);
            } catch (\Exception $exception) {
                return $this->sendErrorResponse(HTTP_CODE::HTTP_NOT_FOUND, 'RECORD NOT FOUND');
            }
            $requestParams = $request->except($this->token);
            if ( ! $this->verifyFieldsRequest($this->fields, $requestParams)) {
                return $this->sendErrorResponse(HTTP_CODE::HTTP_BAD_REQUEST, 'BAD REQUEST');
            }
            if ($this->verifyFieldsNotEmptyRequest($this->fields, $requestParams)) {
                return $this->sendErrorResponse(HTTP_CODE::HTTP_BAD_REQUEST, 'BAD REQUEST');
            }
            $article->fill($requestParams);
            $article->save();
            $response = [
                'article'        => new ArticleResource($article),
                'total_elements' => count($article)
            ];

            return $this->sendSuccessResponse($response);
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
            $article = Article::findOrFail($id);
            $article->delete();
            $response = [
                'article'        => new ArticleResource($article),
                'total_elements' => count($article)
            ];

            return $this->sendSuccessResponse($response);
        } catch (\Exception $exception) {
            return $this->sendErrorResponse(HTTP_CODE::HTTP_NOT_FOUND, 'RECORD NOT FOUND');
        }
    }
}
