DOCKER_REPOSITORY=yovanggaanandhika
DOCKER_IMAGE=laravelpine
DOCKER_TAG=8.3-fpm
DOCKER_NAME=$(DOCKER_REPOSITORY)/$(DOCKER_IMAGE):$(DOCKER_TAG)

default:
	docker compose up -d

shell:
	docker exec -it $(shell docker ps --filter ancestor=$(DOCKER_NAME) --format '{{.Names}}' | head -n 1) bash

migrate:
	docker exec -it $(shell docker ps --filter ancestor=$(DOCKER_NAME) --format '{{.Names}}' | head -n 1) php artisan migrate

backup:
	docker exec -it $(shell docker ps --filter ancestor=$(DOCKER_NAME) --format '{{.Names}}' | head -n 1) backup

restore:
	docker exec -it $(shell docker ps --filter ancestor=$(DOCKER_NAME) --format '{{.Names}}' | head -n 1) restore

backup-truncate:
	docker exec -it $(shell docker ps --filter ancestor=$(DOCKER_NAME) --format '{{.Names}}' | head -n 1) rm -rf database/backups/**.sql.gz

run:
	docker compose up -d
