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

Auth::routes();

Route::get('/', function() {
    return redirect()->route('user.index');
});

Route::group(['prefix' => 'admin',  'middleware' => ['check.ip', 'auth:admin']], function() {
    Route::get('/', 'Admin\IndexController@index')->name('admin.index');
    Route::resource('locais', 'Admin\LocalController');
    Route::resource('servidores', 'Admin\ServidorController');
    Route::resource('vms', 'Admin\VmController');
    Route::resource('users', 'Admin\UserController');
    Route::post('/logout', 'Admin\Auth\LoginController@logout')->name('admin.logout');
});

#Rotas de atutenticação admin
Route::group(['prefix' => 'admin', 'middleware' => 'check.ip'], function() {
    Route::get('/login', 'Admin\Auth\LoginController@index')->name('admin.login');
    Route::post('/login', 'Admin\Auth\LoginController@login')->name('admin.login.submit');
});

########################################################################################
########################################################################################
########################################################################################
########################################################################################

Route::group(['prefix' => 'painel',  'middleware' => 'auth:web'], function() {
    Route::middleware(['check_status'])->group(function () {
        Route::get('/', 'User\IndexController@index')->name('user.index');
        Route::get('/vm/{id}', 'User\IndexController@show')->name('vm.show.index');
        Route::post('/acao/store/{id}', 'User\AcaoController@store')->name('vm.acao.store');
        Route::post('/ajax_status', 'User\IndexController@ajaxStatus')->name('vm.ajax_status');
    });

    Route::get('/inativo', 'User\IndexController@inativo')->name('user.inativo');
    Route::post('/logout', 'User\Auth\LoginController@logout')->name('user.logout');
});

#Rotas de atutenticação do usuário
Route::group(['prefix' => 'painel'], function() {
    Route::get('/login', 'User\Auth\LoginController@index')->name('user.login');
    Route::post('/login', 'User\Auth\LoginController@login')->name('user.login.submit');
});