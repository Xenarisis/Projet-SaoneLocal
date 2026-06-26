#!/bin/bash
set -e

if [ "$APP_ENV" = "production" ]; then
    echo "Caching configuration and routes..."
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
else
    echo "Clearing cache for local dev..."
    php artisan config:clear
    php artisan route:clear
    php artisan view:clear
fi

echo "Wiping database, migrating and seeding..."
php artisan migrate:fresh --seed --force

echo "Starting PHP-FPM..."
exec "$@"