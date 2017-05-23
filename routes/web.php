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
Route::group(['middleware' => 'admin_guest'], function() {

    Route::get('global_login', 'AdminAuth\LoginController@showLoginForm');
    Route::post('global_login', 'AdminAuth\LoginController@login');

    //Password reset routes
    Route::get('global_password/reset', 'AdminAuth\ForgotPasswordController@showLinkRequestForm');
    Route::post('global_password/email', 'AdminAuth\ForgotPasswordController@sendResetLinkEmail');
    Route::get('global_password/reset/{token}', 'AdminAuth\ResetPasswordController@showResetForm');
    Route::post('global_password/reset', 'AdminAuth\ResetPasswordController@reset');
});

// Only logged in admins can access or send requests to these pages
Route::group(['middleware' => 'admin_auth'], function() {

    Route::get('/global', function() {
        return view('global.home');
    });

    Route::post('global_logout', 'AdminAuth\LoginController@logout');
});