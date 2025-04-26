# OpenDataMonitoring
Небольшой петпроект по сбору данных из открытых апи

https://openlibrary.org/developers/api
https://dog.ceo/dog-api/
https://github.com/lukePeavey/quotable
https://ipapi.co/
https://pokeapi.co/
https://restcountries.com/


# Для запуска бэка:
1. cd backend
2. cp .env.example .env
3. composer install --no-scripts --no-interaction --optimize-autoloader  --ignore-platform-reqs
4. sudo make up
5. make migrate
6. make jwt-init
7. sudo docker exec -ti backend-service-php-1 /bin/bash

# Swagger
    Для генерации Swagger по аннотациям используются библиотеки:
        - zircote/swagger-php
        - doctrine/annotations
    Для запуска генерации выполнить команду:
        - ./vendor/bin/openapi app -o openapi.yaml
