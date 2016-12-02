install:
	composer install --optimize-autoloader --no-interaction --prefer-dist

test:
	./bin/php-cs-fixer fix --diff --dry-run -vvv
	./bin/project-requirements check --foss
	./bin/phpspec run -fpretty
