
#!/bin/sh

set -e

echo "=== Preparando Laravel ==="

php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "=== Ejecutando migraciones de PostgreSQL ==="

php artisan migrate --force

echo "=== Configurando almacenamiento público ==="

php artisan storage:link || true

echo "=== Iniciando API Laravel ==="

exec php artisan serve --host=0.0.0.0 --port="${PORT:-10000}"

