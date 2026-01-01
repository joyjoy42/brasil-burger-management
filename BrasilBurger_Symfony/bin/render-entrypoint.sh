#!/usr/bin/env sh
set -eu

DATABASE_URL_VALUE="${DATABASE_URL:-}"

if echo "$DATABASE_URL_VALUE" | grep -qi "^postgres"; then
  php bin/console doctrine:schema:update --force --env=prod --no-interaction || true
elif echo "$DATABASE_URL_VALUE" | grep -qi "^sqlite"; then
  DB_PATH="/var/www/html/var/BrasilBurger.db"
  SQL_PATH="/var/www/html/database.sql"

  mkdir -p /var/www/html/var

  if [ ! -f "$DB_PATH" ] || [ ! -s "$DB_PATH" ]; then
    if [ -f "$SQL_PATH" ]; then
      sqlite3 "$DB_PATH" < "$SQL_PATH"
    else
      sqlite3 "$DB_PATH" "VACUUM;"
    fi
  fi
fi

exec php -S 0.0.0.0:${PORT:-10000} -t public
