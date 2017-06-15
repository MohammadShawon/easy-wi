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

// Global API
Route::group(['namespace' => 'Api\V1\GlobalAdmin', 'prefix' => 'v1/global'], function () {

    // Admins
    Route::get('admins', 'AdminController@index');
    Route::post('admins', 'AdminController@store');
    Route::get('admins/{id}', 'AdminController@show')->where('id', '[0-9]+');
    Route::put('admins/{id}', 'AdminController@update')->where('id', '[0-9]+');
    Route::put('admins/{id}/password', 'AdminController@password')->where('id', '[0-9]+');
    Route::delete('admins/{id}', 'AdminController@destroy')->where('id', '[0-9]+');
});
