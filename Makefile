SAIL := ./vendor/bin/sail

vendor:
	@if [ ! -f .env ]; then cp .env.example .env; fi
	@if [ ! -d vendor ]; then \
		docker run --rm \
			-v "$$(pwd):/app" \
			-w /app \
			laravelsail/php83-composer \
			composer install; \
	fi

up:
	$(SAIL) up -d

setup: vendor up
	$(SAIL) artisan key:generate
	$(SAIL) artisan migrate

down:
	$(SAIL) down

frontend:
	$(SAIL) npm install --legacy-peer-deps
	$(SAIL) npm run dev

logs:
	$(SAIL) logs -f

bash:
	$(SAIL) bash

test:
	$(SAIL) artisan test
