PATH := $(shell pwd)/bin:$(PATH)
$(shell cp --update=none dev.env .env)
include .env

install: build
	composer install
	cp -n phpunit.xml.dist phpunit.xml

build:
	docker build -t $(PHP_DEV_IMAGE):$(REVISION) .

test:
	php vendor/bin/phpunit
