PHP_IMAGE	:= wpengine/php
PHP_VERSION := 7.2
COMPOSER_IMAGE := skypress/wp-composer

default: lint

lint: lint-php
clean: file-perms wp-clean
install: composer-install file-perms
update: composer-update
start: local-start
stop: local-stop
restart: stop start
up: local-up
down: local-down
refresh: local-refresh

local-up:
	@echo
	# Starting containers with docker-compose up -d
	docker-compose up -d
	@echo
	# Started

local-down:
	@echo
	# Stopping containers with docker-compose down
	docker-compose down
	@echo
	# Stopped

local-start:
	@echo
	# Start with docker-compose start
	docker-compose start
	@echo
	# Started

local-stop:
	@echo
	# Stop with docker-compose
	docker-compose stop
	@echo
	# Stopped

local-refresh:
	@echo
	# Refresh the site
	docker-compose down
	docker-compose up -d
	@echo
	# Site refreshed

lint-php:
		@echo
		# Running php -l
		@docker run --rm \
			--volume $(PWD):/workspace \
			--workdir /workspace \
			$(PHP_IMAGE):$(PHP_VERSION) \
				/bin/bash -c 'find ./*/plugins ./*/themes \
					-not \( -path "*/vendor" -prune \) \
					-not \( -path "./wp-admin" -prune \) \
					-not \( -path "./wp-includes" -prune \) \
					-not \( -path "*twenty*" -prune \) \
					-name \*.php \
					-print0 | \
					xargs -I {} -0 php -l {}'
		@echo
		# Linted PHP files

file-perms:
	@echo
	# Setting proper file permissions
	sudo find . -type d -exec chmod 775 {} \;
	sudo find . -type f -exec chmod 664 {} \;
	@echo
	# File permissions set

composer-install:
	@echo
	# Installing packages from composer.json
	@docker run --rm \
		--volume $(PWD):/app \
		--workdir /app \
		$(COMPOSER_IMAGE):latest \
			composer install -o
	@echo
	# Finished install packages

composer-update:
	@echo
	# Installing packages from composer.json
	@docker run --rm \
		--volume $(PWD):/app \
		--workdir /app \
		$(COMPOSER_IMAGE):latest \
			composer update -o
	@echo
	# Finished install packages

wp-clean:
	@echo
	# Clean up un-wanted mess from vanilla WP
	rm -rf wp-content/themes/twentyfifteen
	rm -rf wp-content/themes/twentysixteen
	rm -rf wp-content/plugins/akismet
	rm -f wp-content/plugins/hello.php
	@echo
	# All clean
