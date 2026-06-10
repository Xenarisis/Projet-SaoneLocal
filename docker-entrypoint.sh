#!/bin/bash
set -e

echo "Init Laravel environement"

if [ ! -d "vendor" ]; then
    echo "composer install: "
    composer install --no-interaction --prefer-dist --optimize-autoloader
fi

if [ ! -f ".env" ]; then
    echo ".env:"
    cp .env.example .env
    php artisan key:generate --no-interaction
fi

echo "migrations:"
php artisan migrate --force

echo "seeder: "
php artisan db:seed

echo "starting:"
exec "$@"
