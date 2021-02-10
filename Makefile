bin=vendor/bin
codeSnifferRuleset=codesniffer-ruleset.xml
src=src
dirs:=$(src)

build:
	composer install

phpcs:
	$(bin)/phpcs -sp --standard=$(codeSnifferRuleset) --extensions=php $(dirs)

phpcbf:
	$(bin)/phpcbf -spn --standard=$(codeSnifferRuleset) --extensions=php $(dirs) ; true

phpstan:
	$(bin)/phpstan analyze $(dirs)

qa: phpcbf phpcs phpstan