ifneq (,$(wildcard ./.env))
    include .env
    export
endif

setup: 
	cp .env.example .env; 
	if [ ! -d "${PROJECT}" ]; then \
		mkdir ${PROJECT}; \
	fi;
	# cp ${PROJECT}/.env.example ${PROJECT}/.env;
	docker network create ${PROJECT}_net

# start deploying
start-dep: composer npm composer-install dockerInstall build up 

git-config:
	@echo "Настройка Git..."
	@read -p "Введите ваше имя: " name; \
	git config user.name "$$name"; \
	read -p "Введите вашу электронную почту: " email; \
	git config user.email "$$email"; \
	echo "Настройка завершена."; \
	git config user.name; \
	git config user.email

# deploying
composer:
	bash deploying/composer.sh
npm:
	apt install nodejs; node -v; apt install npm
composer-dep:
	composer install 
dockerInstall:
	bash deploying/docker-install.sh


# Чистая инициализация
init: docker-down-clear docker-build up

# Полностью обновить образы
update: docker-down-clear docker-pull docker-build-pull up

# Delete images by tag
delete-tag: docker-clear-images-tag
# Delete iages by names
delete-name: docker-clear-images-name


# shortcuts
start: docker-up composer-install key-storage npm-install
stop: docker-down
restart: stop start
rebuild: stop build start 
build: docker-build

docker-build:
	docker compose build
docker-up:
	docker compose up -d
docker-down:
	docker compose down --remove-orphans
docker-down-clear:
	docker compose down -v --remove-orphans
docker-pull:
	docker compose pull
docker-clear-images-tag:
	docker rmi $$(docker images --format '{{.Repository}}:{{.Tag}}' | grep ':${TAG}') -f
docker-clear-images-name:
	docker rmi $$(docker images --format '{{.Repository}}:{{.Tag}}' | grep '${PROJECT}') -f
composer-update:
	${DOCKER_EXEC_APP} composer update
composer-install:
	${DOCKER_EXEC_APP} composer install
key-storage:
	${DOCKER_EXEC_APP} php artisan key:generate
	${DOCKER_EXEC_APP} chmod -R 777 storage
chmod:
	docker exec -it php chmod -R 777 
exec-app:
	${DOCKER_EXEC_APP} bash
npm-install:
	docker exec -it ${PROJECT}_vite npm install 

migrate:
	${DOCKER_EXEC_APP} php artisan migrate:fresh $(s)

run-tests:	
	read -p "Тип теста? - " type; \
	if [ -z "$$type" ]; then\
		type="Feature"; \
	fi; \
	docker exec -it ${PROJECT}_app php artisan test --testsuite=$$type

tinker:
	docker exec -it ${PROJECT}_php php artisan tinker app/Console/tinker.php

migrate-fresh:
	docker exec -it ${PROJECT}_php php artisan migrate:fresh --seed
