#!/bin/bash

set -e

echo "🔧 Running Laravel setup tasks..."

if [ -z "$APP_KEY" ]; then
    echo "➡️ Generating APP_KEY..."
    php artisan key:generate --force
fi

if [ -z "$JWT_SECRET" ]; then
    echo "➡️ Generating JWT_SECRET..."
    php artisan jwt:secret --force
fi

echo "➡️ Running migrations..."
php artisan migrate --force || true

echo "➡️ Creating storage link..."
php artisan storage:link || true

echo "✅ Laravel setup completed."
echo "🚀 Starting Apache..."

apache2-foreground
