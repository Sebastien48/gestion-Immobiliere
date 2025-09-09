#!/bin/sh
set -e

echo "⏳ Waiting for database..."
sleep 5

echo "🚀 Running migrations..."
php artisan migrate --force || true

echo "⚡ Optimizing Laravel cache..."
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

echo "✅ Starting Supervisor (nginx + php-fpm)..."
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
