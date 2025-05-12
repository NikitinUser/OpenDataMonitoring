<?php

return [
    'request' => [
        'route_names_exclude_json_headers' => [],
        'json_headers' => [
            'accept' => 'application/json',
            'content-type' => 'application/json'
        ],
    ],
    'endpoints' => [
        'meteomatics' => [
            'name' => 'meteomatics',
            'host' => env('METEOMATICS_HOST'),
            'login' => env('METEOMATICS_LOGIN'),
            'pass' => env('METEOMATICS_PASS'),
            'features' => [
                'current_temp' => \App\Services\Features\MeteomaticsCurrentTemp::class,
            ],
        ],
        'weatherapi' => [
            'name' => 'weatherapi',
            'host' => env('WEATHERAPI_HOST'),
            'key' => env('WEATHERAPI_KEY'),
            'features' => [
                'current_temp' => \App\Services\Features\WeatherapiCurrentTemp::class,
            ],
        ],
    ],
];
