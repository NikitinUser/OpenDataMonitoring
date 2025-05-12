SHELL=/bin/bash

UID := 1000

get-env:
	[ ! -f .env ] && cp .env.example .env || true

up:
	composer install --no-scripts --no-interaction --optimize-autoloader --ignore-platform-reqs && \
	env UID=${UID} docker compose up --build --remove-orphans --force-recreate

first-run:
	make jwt-init
	make migrate
	make create-default-user

migrate:
	env UID=${UID} docker compose exec -u app service-php php artisan migrate

create-default-user:
	env UID=${UID} docker compose exec -u app service-php php artisan auth:create-user admin 12345

test:
	env UID=${UID} docker compose exec -u app service-php php artisan test

jwt-init:
	env UID=${UID} docker compose exec -u app service-php php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
	env UID=${UID} docker compose exec -u app service-php php artisan jwt:secret

swg-json:
	docker run --rm -it -v ${PWD}:/var/www/html $(shell source .env; echo $${COMPOSE_PROJECT_NAME}_php-service) ./vendor/bin/openapi app -o ./resources/swagger/v1/openapi.json
