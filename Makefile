up-first:
	docker-compose up -d
	docker-compose exec phpfpm composer install
	docker-compose exec phpfpm bin/console --no-interaction doctrine:migrations:migrate
	docker-compose exec phpfpm bin/console --no-interaction doctrine:fixtures:load

down-clear:
	docker-compose exec phpfpm bin/console --no-interaction doctrine:migrations:migrate first
	docker-compose down

up:
	docker-compose up -d --build

down:
	docker-compose down

migrate:
	docker-compose exec phpfpm bin/console --no-interaction doctrine:migrations:migrate

migrate-down:
	docker-compose exec phpfpm bin/console --no-interaction doctrine:migrations:migrate first

fixture:
	docker-compose exec phpfpm bin/console --no-interaction doctrine:fixtures:load
