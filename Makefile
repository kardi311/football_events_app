.PHONY: all
default: all;

analysis:
	vendor/bin/phpstan analyse -c phpstan.neon -l 7 \
	    src/

standards:
	vendor/bin/phpcs --colors --standard=cs-ruleset.xml src//

all: analysis
