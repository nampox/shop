#!/bin/sh
set -e

echo "Starting Laravel application..."

# Install dependencies if needed
echo "Installing dependencies if needed..."
if [ ! -d "vendor" ]; then
    echo "Running composer install..."
    composer install --no-interaction --prefer-dist
    composer dump-autoload
fi

# Wait for MySQL to be ready
echo "Waiting for MySQL..."
host="${DB_HOST:-mysql}"
while ! nc -z "$host" 3306; do
    echo "MySQL is unavailable - sleeping"
    sleep 2
done
echo "MySQL is up!"

# Generate app key if needed
php artisan key:generate --force

# Clear caches
php artisan config:clear
php artisan cache:clear

# Run migrations
echo "Running migrations..."
php artisan migrate --force || true

echo "Starting Laravel development server..."
exec php artisan serve --host=0.0.0.0 --port=8000

