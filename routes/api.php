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


Route::group(['prefix' => 'v1', 'namespace' => 'Api'], function() {
    Route::get('banklist', 'FrontEndController@getBank')->name('get.bank.list');
    Route::post('getsetting', 'FrontEndController@getSetting')->name('get.setting.system');
    Route::post('getperiod','FrontEndController@getPeriodMarket')->name('get.period.market');
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
    Route::post('getdepositbank', 'MemberController@getBankOperator')->name('get.bank.operator');
    Route::post('dobetgame','MemberController@betGameAllDigit')->name('do.bet.game');
    Route::post('dobetgame50','MemberController@doBetGame50')->name('do.bet.game.50');
    Route::post('dobetgamebesar','MemberController@doBetGameBesar')->name('do.bet.game.besar');
    Route::post('dobetgamesilang','MemberController@doBetGameSilang')->name('do.bet.game.silang');
    Route::post('dobetgamecolokbebas','MemberController@doBetGameColokBebas')->name('do.bet.game.colok.bebas');
    Route::post('dobetgamecolokjitu','MemberController@doBetGameColokJitu')->name('do.bet.game.colok.jitu');
    Route::post('dobetgametepitangah','MemberController@doBetGameTepiTangah')->name('do.bet.game.tepi.tengah');
    Route::post('dobetgamekembang','MemberController@doBetGameKembang')->name('do.bet.game.kembang');
    Route::post('dobetgamekombinasi','MemberController@doBetGameKombinasi')->name('do.bet.game.kombinasi');
    Route::post('dobetgameshio','MemberController@doBetGameShio')->name('do.bet.game.shoio');
    Route::post('dobetgamequick','MemberController@doBetQuickGame')->name('do.bet.game.quick');
    Route::post('getgameshio','MemberController@getShioString')->name('get.game.shio');
    Route::post('getmarketgamesetting','FrontEndController@getMarketGameSetting')->name('get.market.game.setting');
    Route::post('checklimitnumerberbet','FrontEndController@checkLimitNumberBet');
    Route::post('transperiodlist','MemberController@transactinPeriod')->name('get.period.transaction');
    Route::post('transgamelist','MemberController@transactionGameList')->name('get.transaction.game.list');
});
