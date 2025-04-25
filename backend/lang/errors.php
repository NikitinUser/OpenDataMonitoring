<?php

return [
    'auth' => [
        'bad_credentials' => 'Некорректные учетные данные',
        'bad_route_id' => 'Некорректный идентификатор маршрута',
    ],
    'user' => [
        'email_already_registered' => 'Пользователь с email ":email" уже зарегистрирован в системе',
        'login_already_registered' => 'Пользователь с логином ":login" уже зарегистрирован в системе',
        'id_already_exists' => 'Запись пользователя с id::id уже существует в системе',
    ],
    'common_validation' => [
        'required' => 'Поле обязательно',
        'type' => 'Неправильный тип для поля :field',
        'enum' => 'Значение должно быть одним из: :enum',
    ],
];
