#!/bin/sh
set -eu

# Fix permissions on bind-mounted volumes (host files are often root-owned)
chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || true
chmod -R 775 storage bootstrap/cache 2>/dev/null || true

# Wait for PostgreSQL when the app is configured for pgsql.
# Skipped automatically for sqlite or when DB_HOST is empty/local.
DB_HOST_VALUE="${DB_HOST:-db}"
DB_PORT_VALUE="${DB_PORT:-5432}"
if [ "${DB_CONNECTION:-pgsql}" = "pgsql" ] && [ -n "${DB_HOST_VALUE}" ]; then
  echo "Waiting for Postgres at ${DB_HOST_VALUE}:${DB_PORT_VALUE}..."
  for i in $(seq 1 60); do
    if pg_isready -h "${DB_HOST_VALUE}" -p "${DB_PORT_VALUE}" -U "${DB_USERNAME:-postgres}" >/dev/null 2>&1; then
      echo "Postgres is ready."
      break
    fi
    if [ "$i" = "60" ]; then
      echo "WARNING: Postgres not reachable after 60s, continuing anyway."
    fi
    sleep 1
  done
fi

# APP_KEY is mandatory for Laravel encryption. Fail fast with a clear message.
if [ -z "${APP_KEY:-}" ] && [ ! -f .env ]; then
  echo "ERROR: APP_KEY is not set. Generate one locally with 'php artisan key:generate --show' and set APP_KEY (or mount a .env file)."
  exit 1
fi

# Optional one-time setup steps (disable with RUN_MIGRATIONS=false)
if [ "${RUN_MIGRATIONS:-true}" = "true" ]; then
  echo "Running database migrations..."
  php artisan migrate --force --no-interaction
fi

if [ "${RUN_STORAGE_LINK:-true}" = "true" ]; then
  php artisan storage:link --no-interaction || true
fi

# Cache config/routes/views for production, but never fail the boot on it.
php artisan optimize --no-interaction || php artisan config:cache --no-interaction || true

exec "$@"
