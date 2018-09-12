PHP_IMAGE	:= wpengine/php
PHP_COMPOSER := skypressbmo/wpe-php-composer

default: lint

lint: lint-php

lint-php:
		@echo
		# Running php -l
		@docker run --rm \
			--volume $(PWD):/workspace \
			--workdir /workspace \
			$(PHP_IMAGE):7.2 \
				/bin/bash -c "find /workspace -path '*vendor' -prune -o -name '*.php' -print0 | xargs -I {} -0 php -l {}"
		@echo
		# Linted PHP files
