# Makefile for car-pooling-challenge
# vim: set ft=make ts=8 noet
# Copyright Cabify.com
# Licence MIT

# Variables
# UNAME		:= $(shell uname -s)
DOCKER_IMAGE = car_pooling_image_carrillo
DOCKER_CONTAINER = car_pooling_container_carrillo

.EXPORT_ALL_VARIABLES:

# this is godly
# https://news.ycombinator.com/item?id=11939200
.PHONY: help
help:	### this screen. Keep it first target to be default
ifeq ($(UNAME), Linux)
	@grep -P '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | \
		awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-20s\033[0m %s\n", $$1, $$2}'
else
	@# this is not tested, but prepared in advance for you, Mac drivers
	@awk -F ':.*###' '$$0 ~ FS {printf "%15s%s\n", $$1 ":", $$2}' \
		$(MAKEFILE_LIST) | grep -v '@awk' | sort
endif

# Targets
#
.PHONY: debug
debug:	### Debug Makefile itself
	@echo $(UNAME)

.PHONY: dockerize
dockerize: build
	@docker build -t car-pooling-challenge:latest .


# Install Project to make it run in local environment.
install: build up
	@echo -e '\n\e[32mEnvironment created successfully !\n'

purge: down rm
	@echo -e '\n\e[32mProject purged successfully !\n'

build:
	docker build -t $(DOCKER_IMAGE) .
	docker run -itd -p 8000:8000 --name $(DOCKER_CONTAINER) $(DOCKER_IMAGE)

up:
	docker start $(DOCKER_CONTAINER)
	docker exec -it $(DOCKER_CONTAINER) symfony server:start -d

down:
	docker stop $(DOCKER_CONTAINER)

rm:
	docker rm $(DOCKER_CONTAINER)
	docker image rm $(DOCKER_IMAGE)

cache-clear:
	docker exec -it $(DOCKER_CONTAINER) bin/console cache:clear

test-unit:
	docker exec -it $(DOCKER_CONTAINER) php bin/phpunit

