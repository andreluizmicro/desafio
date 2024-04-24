CONTAINER_NAME=transfer-api-app
COMPOSEV2 := $(shell docker compose version)

ifdef COMPOSEV2
    COMMAND=docker compose
else
    COMMAND=docker-compose
endif

docker-up:
	$(COMMAND) up -d


docker-down:
	$(COMMAND) down

docker-build:
	$(COMMAND) build

docker-bash: docker-up
	docker exec -it $(CONTAINER_NAME) sh

docker-coverage-html: docker-up
	docker exec -t $(CONTAINER_NAME) composer test-coverage-html

docker-test: docker-up
	docker exec -it $(CONTAINER_NAME) ./vendor/bin/phpunit

docker-format: docker-up
	docker exec -t $(CONTAINER_NAME) composer format
