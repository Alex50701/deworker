init: docker-down-clear docker-down docker-pull docker-build docker-up
up: docker-up
down: docker-down
restart: down up

docker-up:
	docker compose up -d

docker-down:
	docker compose down --remove-orphans

docker-build:
	docker compose build --pull

docker-pull:
	docker compose pull

docker-down-clear:
	docker compose down -v --remove-orphans