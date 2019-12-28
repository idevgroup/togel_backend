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
    return redirect('login');
});
//Route::get('/', 'FrontEnd\HomeController@homePage')->name('home.page');
/*Route::group(array('namespace' => 'FrontEnd'), function () {
    Route::get('/', 'HomeController@home')->name('frontend.home');
});*/
Route::get('locale/{locale}', function ($locale) {
    Session::put('locale', $locale);
    return redirect()->back();
});

Route::group(array('middleware' => ['auth'], 'namespace' => 'BackEnd'), function () {
    Route::get(_ADMIN_PREFIX_URL, function () {
        return redirect(_ADMIN_PREFIX_URL . '/dashboards');
    });
});

Route::get('/laravel-filemanager', '\UniSharp\LaravelFilemanager\Controllers\LfmController@show');
Route::post('/laravel-filemanager/upload', '\UniSharp\LaravelFilemanager\Controllers\UploadController@upload');
Auth::routes(['register' => false]);
Route::get('laravel-logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->middleware('auth');
Route::group(array('prefix' => _ADMIN_PREFIX_URL, 'as' => _ADMIN_PREFIX_URL,
    'middleware' => ['auth'], 'namespace' => 'BackEnd'), function () {

    Route::post('players/banking', 'PlayersController@playerBank');
    Route::post('players/updatebalance', 'PlayersController@updatebalance');
    Route::post('gameSettingVal', 'GameSettingController@getvalue');
    Route::post('gameSettingVal', 'BonusRefController@getvalue');
    Route::post('menustting/create/getsubparent', 'MenuSettingController@getsubparent');
    Route::get('menusettings/catIdCon','MenuSettingController@showSingleCon');
    Route::post('result4ds/getperiod','SetResultController@getPeriodMarket');
    Route::post('result4ds/calculateresult','SetResultController@CalculateResult');
    Route::post('calculateresults/approveresult','CalculateResultController@approveResult');
//    Route::post('getValidate','BonusRefController@getValidate');
    $ArrMenu = ['dashboards' => 'DashBoardController',
        'useraccounts' => 'UserController',
        'rolegroups' => 'RoleController',
        'rolepermissions' => 'RolePermissionController',
        'categories' => 'CategoryController',
        'products' => 'ProductController',
        'posts' => 'PostController',
        'dreambooks' => 'DreambooksController',
        'software' => 'SoftwareController',
        'slides' => 'SlidesController',
        'banks' => 'BanksController',
        'bankholders' => 'BankHolderController',
        'bankaccountgroups' => 'BankAccountGroupController',
        'gamemarkets' => 'GameMarketController',
        'games' => 'GamesController',
        'gamesettings' => 'GameSettingController',
        'sitelocks' => 'SiteLockController',
        'bonusrefs' => 'BonusRefController',
        'blacklists' => 'BlackListController',
        'ipfilters' => 'IPFilterController',
        'messagetemplates' => 'MessageTemplateController',
        'transactionlimits' => 'TransactionLimitController',
        'homesettings' => 'HomeSettingController',
        'generalsettings' => 'GeneralSettingController',
        'players' => 'PlayersController',
        'deposittransactions' => 'DepositTransactionController',
        'withdrawtransactions' => 'WithdrawTransactionController',
        'notifications' => 'NotificationsController',
        'menusettings' => 'MenuSettingController',
        'result4ds' => 'SetResultController',
        'calculateresults' => 'CalculateResultController',
        'betlists' => 'BetListController',
        'languages' => 'LanguageController',
        'bankgroupps' => 'BankGroupController'
    ];
    foreach ($ArrMenu as $key => $value) {
        Route::resource("{$key}", "{$value}");

        Route::post("{$key}/status", "{$value}@checkStatus")->name($key . ".status");
        Route::post("{$key}/multstatus", "{$value}@checkMultiple")->name($key . ".multstatus");
    }
});

