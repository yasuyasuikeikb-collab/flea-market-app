# laravel-docker-template

## セットアップ

```bash
docker compose up -d --build
docker compose exec php composer create-project laravel/laravel .
cp .env.example .env
php artisan key:generate
php artisan migrate