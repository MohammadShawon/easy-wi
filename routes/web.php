<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Logged in users/admins cannot access or send requests these pages
Route::group(['middleware' => 'admin_guest', 'prefix' => 'global'], function () {

    Route::get('login', 'AdminAuth\LoginController@showLoginForm');
    Route::post('login', 'AdminAuth\LoginController@login');

    // Password reset routes
    Route::get('password/reset', 'AdminAuth\ForgotPasswordController@showLinkRequestForm');
    Route::post('password/email', 'AdminAuth\ForgotPasswordController@sendResetLinkEmail');
    Route::get('password/reset/{token}', 'AdminAuth\ResetPasswordController@showResetForm');
    Route::post('password/reset', 'AdminAuth\ResetPasswordController@reset');
});

// Only logged in admins can access or send requests to these pages
Route::group(['middleware' => 'admin_auth', 'prefix' => 'global'], function () {

    Route::get('/', function () {
        return view('global.home');
    });

    Route::post('logout', 'AdminAuth\LoginController@logout');
});
