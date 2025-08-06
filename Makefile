SAIL=./vendor/bin/sail
SAIL_ARTISAN=$(SAIL) artisan

tink:
	$(SAIL_ARTISAN) tinker

down:
	$(SAIL) down

upd:
	$(SAIL) up

up:
	$(SAIL) up -d

build:
	$(SAIL) build --no-cache

reset:
	$(SAIL) restart

shell:
	$(SAIL) root-shell

pint:
	./vendor/bin/pint --parallel

stan:
	./vendor/bin/phpstan analyse --memory-limit 2G $(opt)

test:
	$(SAIL_ARTISAN) test

opt:
	$(SAIL_ARTISAN) optimize

opt-clr:
	$(SAIL_ARTISAN) optimize:clear

r-ls:
	$(SAIL_ARTISAN) route:list -vvv
