# ReviewProjct
Небольшой обзорный петпроект

проект раз в час запрашивает текущую погоду по координатам из таблицы coordinates через сервисы
    https://www.meteomatics.com/en/api/getting-started/
    https://www.weatherapi.com

# Для запуска бэка:
1. cd backend
2. sudo make up

# Для запуска тестов
1. sudo make test

# Для действий в php контейнере
1. sudo docker exec -ti backend-service-php-1 /bin/bash

# Swagger
    Для генерации Swagger по аннотациям используются библиотеки:
        - zircote/swagger-php
        - doctrine/annotations
    Для запуска генерации выполнить команду:
        - ./vendor/bin/openapi app -o ./resources/swagger/v1/openapi.json
    Для получения json файла по апи:
        http://localhost:52877/swagger/json
    Для просмотра свагера:
        https://editor.swagger.io/
