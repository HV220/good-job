build:
	@docker-compose -f ./docker/docker-compose.yml build

start:
	@docker-compose -f ./docker/docker-compose.yml up -d

stop:
	@docker-compose -f ./docker/docker-compose.yml stop

init:
	@docker exec -it docker-php-fpm-1 composer install
	@docker exec -it docker-php-fpm-1 php init --env=Production --overwrite=n
	@docker exec -it docker-php-fpm-1 php yii migrate/up --interactive 0 --migrationPath=@yii/rbac/migrations
	@docker exec -it docker-php-fpm-1 php yii migrate/up --interactive 0