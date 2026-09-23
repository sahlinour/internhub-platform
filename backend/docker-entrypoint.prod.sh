#!/bin/sh

set -eu

: "${APP_KEY:?APP_KEY must be set in the production environment}"

mkdir -p \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache

db_host="${DB_HOST:-postgres}"
db_port="${DB_PORT:-5432}"
db_name="${DB_DATABASE:-laravel_db}"
db_user="${DB_USERNAME:-laravel_user}"

until pg_isready -h "$db_host" -p "$db_port" -U "$db_user" -d "$db_name" >/dev/null 2>&1; do
    echo "Waiting for PostgreSQL at ${db_host}:${db_port}..."
    sleep 2
done

php artisan migrate --force
php artisan optimize

exec php artisan serve --host=0.0.0.0 --port=8000
