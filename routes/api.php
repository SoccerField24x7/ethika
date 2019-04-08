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

/* version 1.0 routes - allows for backward compatibility */
Route::middleware('web')->prefix('1.0')->group(function() {
    Route::post('/order-save', 'ApiController@saveOrder');
    Route::patch('/order-update', 'ApiController@updateOrder');
    Route::put('/order-update', 'ApiController@updateOrder');
    Route::get('/order/{id}', 'ApiController@getOrder');
    Route::delete('/order-delete/{id}', 'ApiController@deleteOrder');
    Route::get('get-csrf', 'ApiController@getCSRF');
});
