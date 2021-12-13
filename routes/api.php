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

Route::middleware('api')->post('/order/create', 'OrderController@create');
Route::middleware('api')->get('/order/discount/{orderId}', 'OrderController@discount_calcutation');
Route::middleware('api')->get('/orders', 'OrderController@list');
Route::middleware('api')->delete('/order/{orderId}', 'OrderController@delete');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

