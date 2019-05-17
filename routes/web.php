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

Route::group(array('middleware' => ['auth', 'web'], 'namespace' => 'BackEnd'), function() {
    Route::get(_ADMIN_PREFIX_URL, function() {
        return redirect(_ADMIN_PREFIX_URL . '/dashboards');
    });
});

Auth::routes(['register' => false]);
Route::group(array('prefix' => _ADMIN_PREFIX_URL, 'as' => _ADMIN_PREFIX_URL,
    'middleware' => ['auth', 'web'], 'namespace' => 'BackEnd'), function() {
      $ArrMenu = ['dashboards' => 'DashBoardController',
                'useraccounts' => 'UserController',
                'rolegroups' => 'RoleController',
                'rolepermissions' => 'RolePermissionController',
                'categories' => 'CategoryController',
                'products' => 'ProductController'];
     foreach ($ArrMenu as $key => $value) {
       Route::resource("{$key}", "{$value}");
       Route::post("{$key}/status","{$value}@checkStatus")->name($key.".status");
       Route::post("{$key}/multstatus","{$value}@checkMultiple")->name($key.".multstatus");
    }

});
Route::get('/home', 'HomeController@index')->name('home');
