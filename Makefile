install: composer-install yarn-install clear-cache
start: server-start docker-start yarn-encore
stop: server-stop docker-stop

ENV ?=prod
COVERAGE ?=0

composer-install:
	SYMFONY_ENV=$(ENV) php composer.phar install --profile --prefer-dist --no-progress --no-interaction --optimize-autoloader

clear-cache:
	php -d memory_limit=-1 bin/console cache:clear --env=$(ENV) -vvv

install-symfony-cli:
	curl -sS https://get.symfony.com/cli/installer | bash
	mv $$HOME/.symfony/bin/symfony /usr/local/bin/symfony

server-start:
	APP_ENV=test symfony server:start -d

server-stop:
	APP_ENV=test symfony server:stop

docker-start:
	docker-compose up -d --build

docker-stop:
	docker-compose stop

yarn-install:
	yarn install

yarn-encore:
	yarn encore $(ENV)

check:
	symfony check:requirements
