#!/bin/bash
set -e

cd /var/www/html

echo "📄 Setting up environment file..."
if [ ! -f .env ]; then
    cp .env.example .env
fi

echo "🔧 Running Laravel setup..."

if [ -z "$APP_KEY" ]; then
echo "⚠️ APP_KEY not found in environment. Generating a new one..."

    NEW_KEY=$(php artisan key:generate --show --no-ansi)

    if echo "$NEW_KEY" | grep -q "base64"; then
        
        sed -i "/^APP_KEY=/c\APP_KEY=$NEW_KEY" .env
        echo "✅ APP_KEY generated and set in .env."
    else
        echo "❌ Failed to generate APP_KEY. Check artisan command."
    fi
else
    echo "✅ APP_KEY found in environment (Render). Using existing key."
fi

if [ -z "$JWT_SECRET" ]; then
 echo "⚠️ JWT_SECRET not found in environment. Generating a new one..."

    JWT_OUTPUT=$(php artisan jwt:secret --force --no-ansi)

    JWT_SECRET_VALUE=$(echo "$JWT_OUTPUT" | grep 'JWT_SECRET' | awk -F '=' '{print $2}')
    
    sed -i "/^JWT_SECRET=/c\JWT_SECRET=$JWT_SECRET_VALUE" .env
    echo "✅ JWT_SECRET generated and set in .env."
else
    echo "✅ JWT_SECRET found in environment (Render). Using existing secret."
fi


echo "Running migrations..."

php artisan migrate --force || true

echo "Linking storage..."
php artisan storage:link || true

echo "🚀 Starting Apache..."
exec apache2-foreground