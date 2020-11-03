<?php

use App\Http\Controllers\CategoryController;
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

//get all
Route::get('/attribute/all','AttributeController@all');
Route::get('/attributeSet/all','AttributeSetController@all');
Route::get('/productGroup/all','ProductGroupController@all');
Route::get('/category/all','CategoryController@all');
Route::get('/activeStatus/all','EnumController@active_enum');
//多對多
Route::get('/attribute/{id}/attributeSets','AttributeController@getAttributeSets');
Route::put('/attribute/{id}/attributeSets','AttributeController@syncAttributeSets');
Route::get('/attributeSet/{id}/attributes','AttributeSetController@getAttributes');
Route::put('/attributeSet/{id}/attributes','AttributeSetController@syncAttributes');
Route::get('/product/{id}/attributes','ProductController@getAttributes');
Route::put('/product/{id}/attributes','ProductController@syncAttributes');
Route::get('/product/{id}/categories','ProductController@getCategories');
Route::put('/product/{id}/categories','ProductController@syncCategories');
//一對多
Route::get('/attributeSet/{id}/products','AttributeSetController@getProducts');
Route::get('/productGroup/{id}/products','ProductGroupController@getProducts');





Route::group(['prefix' => 'product'], function () {
    Route::get('/detail/{sku}','ProductController@viewProductDetail');
    Route::get('/images/{sku}','ProductController@getImages');
    Route::get('/specificPrices/{sku}','ProductController@getSpecificPrices');
    Route::post('/{sku}/addImage','ProductController@addImage');
    Route::delete('/{sku}/deleteImage','ProductController@deleteImage');
    Route::post('/{sku}/addSpecificPrice','ProductController@addSpecificPrice');
});

Route::group(['prefix' => 'category'], function () {
    Route::get('/{slug}/products','CategoryController@viewProductList');
    Route::get('/{slug}/subCategory','CategoryController@getSubCategory');
    Route::post('/{slug}/subCategory','CategoryController@addSubCategory');
    Route::delete('/removeFromParentCategory/{slug}','CategoryController@removeFromParentCategory');
});




Route::apiResource('category','CategoryController');
Route::apiResource('attribute','AttributeController');
Route::apiResource('attributeSet','AttributeSetController');
Route::apiResource('productGroup','ProductGroupController');
Route::apiResource('product','ProductController');
