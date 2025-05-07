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
            'host' => env('METEOMATICS_HOST'),
            'login' => env('METEOMATICS_LOGIN'),
            'pass' => env('METEOMATICS_PASS'),
        ],
        'weatherapi' => [
            'host' => env('WEATHERAPI_HOST'),
            'key' => env('WEATHERAPI_KEY'),
        ],
    ],
];
