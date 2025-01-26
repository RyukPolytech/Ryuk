start:
	docker compose up -d --build

stop:
	docker compose down

update_db:
	docker compose exec apache bin/console doctrine:migrations:migrate

nuke_db:
	docker volume rm ryuk_sqldata

download_death_data:
	pip install -r requirements.txt
	python data_fetch