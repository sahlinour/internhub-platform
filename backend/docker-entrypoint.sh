#!/bin/sh

set -e

echo "Initializing Laravel..."

# Create .env if it doesn't exist
if [ ! -f .env ]; then
    echo "Creating .env from .env.example..."
    cp .env.example .env
fi

# Install Composer dependencies if vendor is missing
if [ ! -f vendor/autoload.php ]; then
    echo "Installing Composer dependencies..."
    composer install --no-interaction --prefer-dist --optimize-autoloader
fi

# Create required Laravel directories
mkdir -p storage/framework/cache/data
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/framework/testing
mkdir -p storage/logs
mkdir -p bootstrap/cache

# Generate APP_KEY if missing
if ! grep -q "^APP_KEY=.\+" .env; then
    echo "Generating APP_KEY..."
    php artisan key:generate --force
fi

# Wait for the database to be ready before running migrations/cache cleanup
until pg_isready -h postgres -U laravel_user -d laravel_db >/dev/null 2>&1; do
    echo "Waiting for PostgreSQL to be ready..."
    sleep 2
done

echo "PostgreSQL is ready!"

# Run database migrations before cache cleanup so the cache table exists
php artisan migrate --force

# Clear Laravel cache
php artisan optimize:clear

echo "Laravel initialization completed."

exec php artisan serve --host=0.0.0.0 --port=8000