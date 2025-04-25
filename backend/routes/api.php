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
