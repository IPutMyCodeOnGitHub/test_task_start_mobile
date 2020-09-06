install: init createdb

init:
	docker-compose build
	docker-compose up -d
	docker-compose exec php composer install

stop:
	docker-compose down

createdb:
	docker-compose exec php bin/console doctrine:database:drop --force --if-exists
	docker-compose exec php bin/console doctrine:database:create
	docker-compose exec php bin/console doctrine:migrations:migrate --no-interaction
	docker-compose exec php bin/console doctrine:fixtures:load --no-interaction

createdb_test:
	docker-compose exec php bin/console doctrine:database:drop --force --if-exists --env=test
	docker-compose exec php bin/console doctrine:database:create --env=test
	docker-compose exec php bin/console doctrine:migrations:migrate --no-interaction --env=test
	docker-compose exec php bin/console doctrine:fixtures:load --no-interaction --env=test

dropdb:
	docker-compose exec php bin/console doctrine:database:drop --force --if-exists