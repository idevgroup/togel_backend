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


Route::group(['middleware' => 'guest:api', 'prefix' => 'v1', 'namespace' => 'Api'], function() {
    Route::get('banklist', 'FrontEndController@getBank')->name('get.bank.list');
    Route::post('getsetting', 'FrontEndController@getSetting')->name('get.setting.system');
});
Route::group(['middleware' => 'guest:api', 'prefix' => 'v1/member', 'namespace' => 'Api', 'as' => 'v1.member.'], function () {
    Route::post('login', 'MemberAuthController@login')->name('login');
    Route::post('register', 'MemberRegisterController@register')->name('register');
});

Route::group(['middleware' => 'auth:api', 'prefix' => 'v1/member', 'namespace' => 'Api', 'as' => 'v1.member.'], function() {
    /* Route::get('refresh', function (Request $request) {
      return $request->user();
      }); */
    Route::get('refresh', 'MemberAuthController@refresh')->name('refresh');
    Route::post('dashboard', 'MemberController@dashBoard')->name('dashboard');
    Route::get('getmarket', 'MemberController@getMarket')->name('getmarket');
    Route::post('logout', 'MemberAuthController@logout')->name('logout');
    Route::post('deposit', 'MemberController@doDeposit')->name('deposit');
    Route::post('withdraw', 'MemberController@doWithdraw')->name('withdraw');
    Route::post('getmemberbank', 'MemberController@getBankMember')->name('getmemberbank');
    Route::get('get-bank-operator', 'MemberController@getBankOperator')->name('get.bank.operator');
});
