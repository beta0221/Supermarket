<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::get('/attribute/all','AttributeController@all');
Route::get('/attributeSet/all','AttributeSetController@all');
Route::get('/productGroup/all','ProductGroupController@all');
Route::get('/activeStatus/all','EnumController@active_enum');

Route::get('/attribute/{id}/attributeSets','AttributeController@getAttributeSets');
Route::put('/attribute/{id}/attributeSets','AttributeController@syncAttributeSets');
Route::get('/attributeSet/{id}/attributes','AttributeSetController@getAttributes');
Route::put('/attributeSet/{id}/attributes','AttributeSetController@syncAttributes');
Route::get('/attributeSet/{id}/products','AttributeSetController@getProducts');
Route::get('/productGroup/{id}/products','ProductGroupController@getProducts');


Route::group(['prefix' => 'product'], function () {
    
    Route::get('/images/{sku}','ProductController@getImages');
    Route::post('/{sku}/addImage','ProductController@addImage');
    Route::delete('/{sku}/deleteImage','ProductController@deleteImage');
});


Route::apiResource('category','CategoryController');
Route::apiResource('attribute','AttributeController');
Route::apiResource('attributeSet','AttributeSetController');
Route::apiResource('productGroup','ProductGroupController');
Route::apiResource('product','ProductController');
