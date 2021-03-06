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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('jwt')->namespace('JWT')->group(function(){
    Route::post('register','JwtController@doRegister');
    Route::post('login','JwtController@doLogin');
    Route::get('user','JwtController@getUserInfo');
    Route::post('logout','JwtController@doLogout');
});

Route::namespace('WECHAT')->group(function (){
    Route::any('/wechat', 'WechatController@serve');
});

Route::prefix('ding')->namespace('DING')->group(function (){
    Route::get('auth', 'DingController@auth');
});



