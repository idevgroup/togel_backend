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

/* Route::get('/', function () {
  return redirect('login');
  }); */
Route::get('/', 'FrontEnd\HomeController@home')->name('home');
Route::get('member/login', 'FrontEnd\MemberAuthController@loginForm')->name('member.login');
Route::post('member/login', 'FrontEnd\MemberAuthController@login')->name('member.login');


Route::group(array('prefix' => 'member', 'namespace' => 'FrontEnd', 'middleware' => ['member']), function() {
    Route::get('/dashdoard', 'HomeController@home')->name('member.dashboard');
    Route::get('/logout', 'MemberAuthController@logout')->name('member.logout');
});
Route::get('locale/{locale}', function ($locale) {
    Session::put('locale', $locale);
    return redirect()->back();
});

Route::group(array('middleware' => ['auth'], 'namespace' => 'BackEnd'), function() {
    Route::get(_ADMIN_PREFIX_URL, function() {
        return redirect(_ADMIN_PREFIX_URL . '/dashboards');
    });
});

Auth::routes(['register' => false]);
Route::group(array('prefix' => _ADMIN_PREFIX_URL, 'as' => _ADMIN_PREFIX_URL,
    'middleware' => ['auth'], 'namespace' => 'BackEnd'), function() {
    Route::post('players/banking', 'PlayersController@playerBank');
    Route::post('players/updatebalance', 'PlayersController@updatebalance');
    $ArrMenu = ['dashboards' => 'DashBoardController',
        'useraccounts' => 'UserController',
        'rolegroups' => 'RoleController',
        'rolepermissions' => 'RolePermissionController',
        'categories' => 'CategoryController',
        'products' => 'ProductController',
        'posts' => 'PostController',
        'dreambooks' => 'DreambooksController',
        'players' => 'PlayersController'];
    foreach ($ArrMenu as $key => $value) {
        Route::resource("{$key}", "{$value}");
        Route::post("{$key}/status", "{$value}@checkStatus")->name($key . ".status");
        Route::post("{$key}/multstatus", "{$value}@checkMultiple")->name($key . ".multstatus");
    }
});

