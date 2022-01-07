install:
	composer install

test:
	./vendor/bin/phpunit -c ./phpunit.xml

test-mutation:
	./vendor/bin/infection --configuration=./infection.json

build-docs:
	docker run --rm -v $(pwd):/data phpdoc/phpdoc:3 -d /data/src -t ./docs
