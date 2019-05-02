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

Route::group(array('middleware' => ['auth', 'web'], 'namespace' => 'BackEnd'), function() {
    Route::get(_ADMIN_PREFIX_URL, function() {
        return redirect(_ADMIN_PREFIX_URL . '/dashboard');
    });
});

Route::group(array('prefix' => _ADMIN_PREFIX_URL, 'as' => _ADMIN_PREFIX_URL,
    'middleware' => ['auth', 'web'], 'namespace' => 'BackEnd'), function() {
    
  
    $ArrMenu = ['dashboard' => 'DashBoardController'];
     foreach ($ArrMenu as $key => $value) {
       Route::resource("{$key}", "{$value}");
       
    }
    
});

Auth::routes(['register' => true]);

Route::get('/home', 'HomeController@index')->name('home');
