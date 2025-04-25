<?php

/**
 * Конфигурация для App\Http\Middleware\ApiResponseFormatter
 */
return [
    'request' => [
        'routes_exclude_json_headers' => [],
        'json_headers' => [
            'accept' => 'application/json',
            'content-type' => 'application/json'
        ],
    ],

    'response' => [
        'routes_exclude_response_formatter' => [],
        /**
         * Настройки блока params возвращающем параметры запроса
         */
        'params' => [
            /**
             * Разрешает добавления блока params в тело ответа
             */
            'enable' => true,

            /**
             * Список скрываемых параметров
             */
            'hidden' => [
                'username',
                'login',
                'password',
                'confirm_password',
                'password_confirmation',
            ],
        ],

        /**
         * Карта замены возвращаемых статус кодов
         */
        'status_code' => [
            'map' => [
                201 => 200,
                202 => 200,
            ]
        ]
    ],
];
