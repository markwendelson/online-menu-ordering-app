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


Route::prefix('v1')->name('api.')->namespace('Api')->group(function () {
    Route::resource('menu', 'MenuController');
    Route::resource('orders', 'OrderController');
    Route::get('/order/{order}','OrderController@order')->name('orders');

});


