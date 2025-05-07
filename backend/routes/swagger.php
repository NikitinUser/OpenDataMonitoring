<?php

use Illuminate\Support\Facades\Route;

Route::get('/json', function () {
    $swagger = \OpenApi\Generator::scan([app_path()]);
    return response(
        $swagger->toJson(),
        headers: [
            'Content-Type' => 'application/octet-stream',
            'Content-Disposition' => 'attachment; filename="openapi.json"',
        ]
    );
});
