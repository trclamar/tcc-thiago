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

Route::post('/login', 'API\AuthController@login');

Route::middleware('auth:api')->group( function () {
    Route::get('/servers', 'API\ServerController@index');
    Route::get('/vms', 'API\VmController@index');

    Route::get('/acoes/{hash_server}', 'API\AcaoController@index');
    Route::post('/acoes/update/{hash_server}/{hash_vm}/{acao_id}', 'API\AcaoController@update');

    Route::post('/status/create', 'API\StatusController@store');
});