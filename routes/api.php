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

Route::group(['namespace' => 'GlobalAdmin', 'prefix' => 'v1'], function () {

    Route::get('admins','AdminController@index');
    Route::get('admins/{id}','AdminController@show')->where('id', '[0-9]+');
    Route::delete('admins/{id}','AdminController@destroy')->where('id', '[0-9]+');
    Route::put('admins','AdminController@store');
    Route::post('admins','AdminController@store');
    Route::put('admins/{id}/password','AdminController@password')->where('id', '[0-9]+');

});
