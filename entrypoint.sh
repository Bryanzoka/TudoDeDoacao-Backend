#!/bin/bash
set -e

cd /var/www/html

echo "🔧 Running Laravel setup..."

if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

if [ -z "$JWT_SECRET" ]; then
    php artisan jwt:secret --force
fi

php artisan migrate --force || true

php artisan storage:link || true

echo "🚀 Starting Apache..."
apache2-foreground
