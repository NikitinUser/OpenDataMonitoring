<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/ping', function () {
    return response()->json('pong');
});

Route::group([
    'prefix' => 'auth',
    'controller' => \App\Http\Controllers\AuthController::class,
], function () {
    Route::post('login', 'login');

    Route::group([
        'middleware' => 'jwt.auth',
    ], function () {
        Route::get('logout', 'logout');
        Route::post('refresh', 'refresh');
    });
});

Route::group([
    'prefix' => 'coordinates',
    'middleware' => 'jwt.auth',
    'controller' => \App\Http\Controllers\CoordinatesController::class,
], function () {
    Route::get('','index');
    Route::get('{id}','show');
    Route::post('', 'store');
    Route::put('{id}', 'update');
    Route::delete('{id}', 'delete');
});

Route::group([
    'prefix' => 'coordinates_temperature',
    'middleware' => 'jwt.auth',
    'controller' => \App\Http\Controllers\CoordinateTemperatureController::class,
], function () {
    Route::get('','index');
});
