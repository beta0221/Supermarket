<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
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
Route::get('/carrier/all','CarrierController@all');
Route::get('/payment/all','PaymentController@all');
Route::get('/category/allParents','CategoryController@allParents');
Route::get('/activeStatus/all','EnumController@active_enum');
Route::get('/cartRule/all','CartRuleController@all');
Route::get('/cartRuleStatus/all','EnumController@cartRule_status_enum');
Route::get('/cartRuleHeightlight/all','EnumController@cartRule_heightlight_enum');
Route::get('/cartRuleFreeDelivery/all','EnumController@cartRule_freeDelivery_enum');
Route::get('/discountType/all','EnumController@discountType_enum');

//多對多
Route::get('/attribute/{id}/attributeSets','AttributeController@getAttributeSets');
Route::put('/attribute/{id}/attributeSets','AttributeController@syncAttributeSets');
Route::get('/attributeSet/{id}/attributes','AttributeSetController@getAttributes');
Route::put('/attributeSet/{id}/attributes','AttributeSetController@syncAttributes');
Route::get('/product/{id}/attributes','ProductController@getAttributes');
Route::put('/product/{id}/attributes','ProductController@syncAttributes');
Route::get('/product/{id}/categories','ProductController@getCategories');
Route::put('/product/{id}/categories','ProductController@syncCategories');
Route::get('/carrier/{id}/payments','CarrierController@getPayments');
Route::put('/carrier/{id}/payments','CarrierController@syncPayments');
Route::get('/category/{slug}/cartRules','CategoryController@getCartRules');
Route::put('/category/{slug}/cartRules','CategoryController@syncCartRules');
Route::get('/product/{id}/cartRules','ProductController@getCartRules');
Route::put('/product/{id}/cartRules','ProductController@syncCartRules');

//一對多
Route::get('/attributeSet/{id}/products','AttributeSetController@getProducts');
Route::get('/productGroup/{id}/products','ProductGroupController@getProducts');
Route::get('/order/{id}/orderProducts','OrderController@getOrderProducts');





Route::group(['prefix' => 'product'], function () {
    Route::get('/images/{sku}','ProductController@getImages');
    Route::get('/specificPrices/{sku}','ProductController@getSpecificPrices');
    Route::post('/{sku}/addImage','ProductController@addImage');
    Route::post('/addImageInDescription/{sku}','ProductController@addImageInDescription');
    Route::delete('/{sku}/deleteImage','ProductController@deleteImage');
    Route::post('/{sku}/addSpecificPrice','ProductController@addSpecificPrice');
});

Route::group(['prefix' => 'category'], function () {
    Route::get('/{slug}/products','CategoryController@viewProductList');
    Route::get('/{slug}/subCategory','CategoryController@getSubCategory');
    Route::post('/{slug}/subCategory','CategoryController@addSubCategory');
    Route::delete('/removeFromParentCategory/{slug}','CategoryController@removeFromParentCategory');
    Route::get('/images/{slug}','CategoryController@getImages');
    Route::post('/{slug}/addImage','CategoryController@addImage');
    Route::delete('/{slug}/deleteImage','CategoryController@deleteImage');
});

//後台
Route::group(['prefix'=>'order'],function(){
    Route::get('/getOrderList','OrderController@getOrderList');
    Route::get('getOrderDetail/{order_numero}','OrderController@getOrderDetail');
    Route::post('nextStatus','OrderController@nextStatus');
    Route::post('groupNextStatus','OrderController@groupNextStatus');
    Route::post('lastStatus','OrderController@lastStatus');
    Route::post('groupLastStatus','OrderController@groupLastStatus');
});
Route::get('member','MemberController@getMembers');
Route::get('userOrder/{id}','MemberController@userOrderList');



Route::apiResource('category','CategoryController');
Route::apiResource('attribute','AttributeController');
Route::apiResource('attributeSet','AttributeSetController');
Route::apiResource('productGroup','ProductGroupController');
Route::apiResource('product','ProductController');
Route::apiResource('order','OrderController');
Route::apiResource('country','CountryController');
Route::apiResource('carrier','CarrierController');
Route::apiResource('payment','PaymentController');
Route::apiResource('cartRule','CartRuleController');
