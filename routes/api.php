<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix'  =>  'v1','middleware'   =>  ['auth.basic','cors']],function(){
    Route::group(['prefix'  =>  'services'],function(){
        Route::group(['prefix'  =>  'stores'],function(){
            Route::get('/'                  , ['as'   => 'stores.index'      ,'uses'    =>  'StoreController@index']);
            Route::get('/{id}'              , ['as'   => 'stores.show'       ,'uses'    =>  'StoreController@show']);
            Route::post('/'                 , ['as'   => 'stores.store'      ,'uses'    =>  'StoreController@store']);
            Route::put('/{id}'              , ['as'   => 'stores.update'     ,'uses'    =>  'StoreController@update']);
            Route::delete('/{id}'           , ['as'   => 'stores.delete'     ,'uses'    =>  'StoreController@delete']);
        });
        Route::group(['prefix'  =>  'articles'],function(){
            Route::get('/'                  , ['as'   => 'article.index'      ,'uses'    =>  'ArticleController@index']);
            Route::get('/{id}'              , ['as'   => 'article.show'       ,'uses'    =>  'ArticleController@show']);
            Route::post('/'                 , ['as'   => 'article.store'      ,'uses'    =>  'ArticleController@store']);
            Route::put('/{id}'              , ['as'   => 'article.update'     ,'uses'    =>  'ArticleController@update']);
            Route::delete('/{id}'           , ['as'   => 'article.delete'     ,'uses'    =>  'ArticleController@delete']);
        });
    });
});
