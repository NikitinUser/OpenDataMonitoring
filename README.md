# DockerLaravel
Репозиторий с настроенным для запуска в докере проектом

# Версии

<table>
    <tr>
        <td>Версия</td>
        <td>Ветка</td>
    </tr>
    <tr>
        <td>Laravel 11, php 8.4.1, rabbit</td>
        <td>laravel-11-php8.4 (current)</td>
    </tr>
</table>

# Настроены
1. nginx
2. pgsql
3. php + laravel 11
4. rabbit mq
5. redis
6. cron

# Предустановлены:
1. Пакет для jwt авторизации tymon/jwt-auth (все настроено)
2. Пакет для свагер аннотаций zircote/swagger-php
3. Пакет vladimir-yuldashev/laravel-queue-rabbitmq
4. Пакет predis/predis

# Для запуска бэка:
1. cd backend
2. cp .env.example .env
3. sudo make up
4. make install
5. make migrate
6. make jwt-init
7. sudo docker exec -ti backend-service-php-1 /bin/bash

# Swagger
    Для генерации Swagger по аннотациям используются библиотеки:
        - zircote/swagger-php
        - doctrine/annotations
    Для запуска генерации выполнить команду:
        - ./vendor/bin/openapi app -o openapi.yaml
