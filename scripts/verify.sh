#!/usr/bin/env bash
# Reproduce localmente las mismas verificaciones que el pipeline de GitHub Actions.
set -euo pipefail

[ -f .env ] || cp .env.example .env
composer install --no-interaction --prefer-dist
php artisan key:generate --force
vendor/bin/pint --test
npm install --no-audit --no-fund
npm run build
php artisan test
echo "Verificación local completada correctamente."
