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


Route::group(['middleware' => 'guest:api','prefix' => 'v1', 'namespace' => 'Api'],function(){
    Route::get('banklist','FrontEndController@getBank')->name('get.bank.list');
});
Route::group(['middleware' => 'guest:api', 'prefix' => 'v1/member', 'namespace' => 'Api', 'as' => 'v1.member.'], function () {
    Route::post('login', 'MemberAuthController@login')->name('login');
    Route::post('register', 'MemberRegisterController@register')->name('register');
});

Route::group(['prefix' => 'v1/member', 'namespace' => 'Api', 'as' => 'v1.member.'],function(){
       /*Route::get('refresh', function (Request $request) {
            return $request->user();
        });*/
        Route::get('refresh','MemberAuthController@refresh')->name('refresh');
        Route::get('dashboard', 'MemberController@dashBoard')->name('dashboard');
        Route::get('getmarket','MemberController@getMarket')->name('getmarket');
        Route::post('logout', 'MemberAuthController@logout')->name('logout');
        Route::post('deposit','MemberController@doDeposit')->name('deposit');
});
