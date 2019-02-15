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

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// check master
Route::get('master', function (){
   return view('layout.backend.master');
});


// password reset
Route::get('password-reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password-reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password-reset', 'Auth\ResetPasswordController@reset')->name('password.update');


// public access
Route::get('custom-login', 'Backend\AuthController@showLoginForm')->name('backend.login_form');
Route::post('custom-login', 'Backend\AuthController@login')->name('backend.login');


// authenticated access
Route::group(['as' => 'backend.', 'namespace' => 'Backend', 'middleware' => 'auth' ], function (){

    Route::get('dashboard', 'DashboardController@index')->name('dashboard');

    Route::get('custom-register', 'AuthController@showRegisterForm')->name('register_form')->middleware('admin');
    Route::post('custom-register', 'AuthController@register')->name('register')->middleware('admin');

    Route::post('custom-logout', 'AuthController@logout')->name('logout');

});



