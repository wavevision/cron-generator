bin=vendor/bin
codeSnifferRuleset=codesniffer-ruleset.xml
src=src
tests=tests
coverage=$(temp)/coverage/php
dirs:=$(src) $(tests)

build:
	composer install

reset:
	rm -rf temp/cache

phpcs:
	$(bin)/phpcs -sp --standard=$(codeSnifferRuleset) --extensions=php $(dirs)

phpcbf:
	$(bin)/phpcbf -spn --standard=$(codeSnifferRuleset) --extensions=php $(dirs) ; true

phpstan:
	$(bin)/phpstan analyze $(dirs)

qa: phpcbf phpcs phpstan test

test: reset
	${bin}/phpunit

test-coverage: reset
	$(bin)/phpunit --coverage-html=$(coverage)
