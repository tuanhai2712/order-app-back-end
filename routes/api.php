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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => 'cors'], function () {
    Route::post('signup', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::group(['middleware' => 'jwt.auth'], function () {
      Route::post('get-order-check', 'OrderController@getOrderCheck');
      Route::post('create', 'OrderController@create');
      Route::post('get-image-order', 'OrderController@getImageOrder');
      Route::post('update-order', 'OrderController@updateOrder');
      Route::post('confirm-order', 'OrderController@confirmOrder');
      Route::post('check-barcode', 'OrderController@checkBarcode');
      Route::post('reset-password', 'AuthController@reset');
      Route::post('find-waybill-code', 'OrderController@findWaybillCode');
      Route::get('get-order-being-transported-status', 'OrderController@getOrderBeingTransportedStatus');
      Route::get('overview', 'SettingController@getOverview');
      Route::post('change-setting', 'SettingController@setting');
      Route::post('get-user', 'UserController@getUser');
      Route::post('import', 'OrderController@import');
      Route::post('update-price-list', 'UserController@updatePriceListForUser');
    });
    Route::get('setting', 'SettingController@getSetting');
});
