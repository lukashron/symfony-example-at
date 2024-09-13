app-build:
	@echo "Installing app..."
	docker compose up -d --build
	docker compose exec web composer install
	docker compose exec web php bin/console doctrine:schema:update --force
	@echo "Installing app... Done"

app-import-data:
	@echo "Importing data..."
	docker compose exec web php bin/console app:import:users
	docker compose exec web php bin/console app:import:posts
	docker compose exec web php bin/console app:import:comments
	@echo "Importing data... Done"

open-test:
	@echo "Opening test..."
	docker compose exec web php bin/phpunit
	@echo "Opening test... Done"