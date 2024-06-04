build:
	docker-compose up --build

run:
	docker exec -it app php bin/console app:process-file input.txt

tests:
	docker exec app vendor/bin/phpunit tests/