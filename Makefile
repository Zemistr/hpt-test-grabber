container = php
docker_compose = docker-compose -f docker-compose.yml
docker_exec = $(docker_compose) exec $(container)

init: up composer-install

up:
	$(docker_compose) up -d

stop:
	$(docker_compose) stop

down:
	$(docker_compose) down

restart: stop up

logs:
	$(docker_compose) logs $(container)

quick-logs:
	$(docker_compose) logs $(container) | tail -n 20

wait:
	sleep 2

bash:
	$(docker_exec) bash

clear-cache:
	$(docker_exec) sh -c "rm -rf var/cache/*"
	$(docker_exec) sh -c "rm -rf var/log/*"

composer-install:
	$(docker_exec) sh -c "composer install"

composer-update:
	$(docker_exec) sh -c "composer update"

run-tests:
	$(docker_exec) sh -c "./vendor/bin/phpunit tests"

run:
	$(docker_exec) sh -c "cat vstup.txt | php run.php"
