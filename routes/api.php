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
Route::group(['middleware' => 'guest:api', 'prefix' => 'v1/member', 'namespace' => 'Api', 'as' => 'v1.member.'], function () {
    Route::post('login', 'MemberAuthController@login')->name('login');
    Route::post('register', 'MemberRegisterController@register')->name('register');
});

Route::group(['middleware' => 'auth:api','prefix' => 'v1/member', 'namespace' => 'Api', 'as' => 'v1.member.'],function(){
     Route::get('refresh', function (Request $request) {
            return $request->user();
        });
        Route::get('dashboard', 'MemberController@dashBoard')->name('dashboard');
        Route::post('logout', 'MemberAuthController@logout')->name('logout');
});
