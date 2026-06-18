#!/bin/bash
set -e

echo "Init Laravel production environment..."

echo "Caching configuration and routes..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Running migrations and Seeder..."
php artisan migrate:fresh --seed --force

echo "Starting PHP-FPM..."
exec "$@"
