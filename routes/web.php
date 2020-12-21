<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'PageController@index');
Route::get('/shop', 'PageController@shop')->name('shop');
Route::get('/shop/{slug}', 'PageController@shop');
Route::get('/cart','PageController@cart')->name('cart');
Route::get('/checkout','PageController@checkout')->name('checkout');
// Route::get('/myOrder', 'OrderController@view_myOrder')->name('myOrder')->middleware('auth');

Route::group(['prefix' => 'cart'], function () {
    Route::get('/getItems','CartController@getItems');
    Route::post('/add/{sku}','CartController@add');
    Route::put('/update','CartController@update');
    Route::delete('/delete/{rowId}','CartController@delete');
    Route::post('/checkout','CartController@checkout')->name('submitCheckout');
    Route::post('/validateCheckout','CartController@validateCheckout')->name('validateCheckout');
    Route::get('/test','CartController@test');
});

Route::group(['prefix' => 'product'], function () {
    Route::get('/{sku}','ProductController@viewProductDetail');
});

Route::group(['prefix' => 'order','middleware'=>['auth']], function () {
    Route::get('/thankyou/{order_numero}','OrderController@view_thankyou')->name('thankyou');
    Route::get('/detail/{order_numero}','OrderController@view_orderDetail');
    Route::get('/myOrder','OrderController@view_myOrder')->middleware('auth');
    Route::get('/myOrderDetail/{id}','OrderController@view_myOrderDetail');
});

Auth::routes();

Route::get('/admin','AuthController@admin_login');


Route::group(['middleware'=>['auth','AdminGroup']],function(){
    Route::view('/admin','admin.home');
    Route::view('/admin/{any}','admin.home');
    Route::view('/admin/{any1}/{any2}','admin.home');
});