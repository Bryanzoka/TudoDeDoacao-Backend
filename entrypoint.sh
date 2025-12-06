#!/bin/bash
set -e

cd /var/www/html

echo "📄 Setting up environment file..."
if [ ! -f .env ]; then
    cp .env.example .env
fi

echo "🔧 Running Laravel setup..."

if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

if [ -z "$JWT_SECRET" ]; then
    php artisan jwt:secret --force
fi

echo "Attempting to reset verification_codes table..."
php artisan migrate:rollback --path=/database/migrations/2025_01_01_create_verification_codes_table.php || true

php artisan migrate --force

php artisan storage:link || true

echo "🚀 Starting Apache..."
apache2-foreground