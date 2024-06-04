build:
	docker-compose up --build

run:
	docker exec -it app php bin/console app:process-file input.txt

phpstan:
	vendor/bin/phpstan analyse src