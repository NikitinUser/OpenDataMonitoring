SHELL=/bin/bash

UID := 1000

get-env:
	cp .env.example .env

up:
	[ ! -f .env ] && cp .env.example .env \
	composer install --no-scripts --no-interaction --optimize-autoloader  --ignore-platform-reqs \
	env UID=${UID} docker compose up --build --remove-orphans --force-recreate \
	make migrate \
	make jwt-init

migrate:
	env UID=${UID} docker compose exec -u app service-php php artisan migrate

test:
	env UID=${UID} docker compose exec -u app service-php php artisan test

jwt-init:
	env UID=${UID} docker compose exec -u app service-php php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
	env UID=${UID} docker compose exec -u app service-php php artisan jwt:secret

swg-json:
	docker run --rm -it -v ${PWD}:/var/www/html $(shell source .env; echo $${COMPOSE_PROJECT_NAME}_php-service) ./vendor/bin/openapi app -o ./resources/swagger/v1/openapi.json
