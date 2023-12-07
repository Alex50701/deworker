init: docker-down-clear docker-down docker-pull docker-build docker-up api-init
up: docker-up
down: docker-down
restart: down up
lint: api-lint

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

build: build-gateway build-frontend build-api

build-gateway:
	docker --log-level=debug build --pull --file=gateway/docker/production/nginx/Dockerfile --tag=${REGISTRY}/loadcrm-gateway:${IMAGE_TAG} gateway/docker

build-frontend:
	docker --log-level=debug build --pull --file=frontend/docker/production/nginx/Dockerfile --tag=${REGISTRY}/loadcrm-frontend:${IMAGE_TAG} frontend

build-api:
	docker --log-level=debug build --pull --file=api/docker/production/nginx/Dockerfile --tag=${REGISTRY}/loadcrm-api:${IMAGE_TAG} api
	docker --log-level=debug build --pull --file=api/docker/production/php-fpm/Dockerfile --tag=${REGISTRY}/loadcrm-api-php-fpm:${IMAGE_TAG} api
	docker --log-level=debug build --pull --file=api/docker/production/php-cli/Dockerfile --tag=${REGISTRY}/loadcrm-api-php-cli:${IMAGE_TAG} api

try-build:
	REGISTRY=localhost IMAGE_TAG=0 make build

api-init: api-composer-install

api-composer-install:
	docker-compose run --rm api-php-cli composer install

api-lint:
	docker-compose run --rm api-php-cli composer lint
	docker-compose run --rm api-php-cli composer cs-check

analyze:
	docker-compose run --rm api-php-cli composer psalm

deploy:
	ssh -o StrictHostKeyChecking=no deploy@${HOST} -p ${PORT} 'rm -rf site_${BUILD_NUMBER}'
	ssh -o StrictHostKeyChecking=no deploy@${HOST} -p ${PORT} 'mkdir site_${BUILD_NUMBER}'
	scp -o StrictHostKeyChecking=no -P ${PORT} docker-compose-production.yml deploy@${HOST}:site_${BUILD_NUMBER}/docker-compose.yml
	ssh -o StrictHostKeyChecking=no deploy@${HOST} -p ${PORT} 'cd site_${BUILD_NUMBER} && echo "COMPOSE_PROJECT_NAME=loadcrm" >> .env'
	ssh -o StrictHostKeyChecking=no deploy@${HOST} -p ${PORT} 'cd site_${BUILD_NUMBER} && echo "REGISTRY=${REGISTRY}" >> .env'
	ssh -o StrictHostKeyChecking=no deploy@${HOST} -p ${PORT} 'cd site_${BUILD_NUMBER} && echo "IMAGE_TAG=${IMAGE_TAG}" >> .env'
	ssh -o StrictHostKeyChecking=no deploy@${HOST} -p ${PORT} 'cd site_${BUILD_NUMBER} && docker-compose pull'
	ssh -o StrictHostKeyChecking=no deploy@${HOST} -p ${PORT} 'cd site_${BUILD_NUMBER} && docker-compose up --build --remove-orphans -d'
	ssh -o StrictHostKeyChecking=no deploy@${HOST} -p ${PORT} 'rm -f site'
	ssh -o StrictHostKeyChecking=no deploy@${HOST} -p ${PORT} 'ln -sr site_${BUILD_NUMBER} site'