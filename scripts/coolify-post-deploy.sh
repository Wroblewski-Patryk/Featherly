#!/usr/bin/env sh
set -eu

cd "$(dirname "$0")/.."

echo "[deploy] Clearing stale Laravel caches..."
php artisan optimize:clear --no-interaction

echo "[deploy] Ensuring public storage link exists..."
php artisan storage:link --force --no-interaction

if [ "${FEATHERLY_DEPLOY_RUN_MIGRATIONS:-true}" = "true" ]; then
    echo "[deploy] Running database migrations..."
    php artisan migrate --force --no-interaction
else
    echo "[deploy] Skipping database migrations because FEATHERLY_DEPLOY_RUN_MIGRATIONS is not true."
fi

if [ "${FEATHERLY_DEPLOY_REFRESH_CACHE:-true}" = "true" ]; then
    echo "[deploy] Rebuilding Laravel production caches..."
    php artisan optimize --no-interaction
else
    echo "[deploy] Skipping cache rebuild because FEATHERLY_DEPLOY_REFRESH_CACHE is not true."
fi

echo "[deploy] Coolify post-deploy maintenance complete."
