#!/usr/bin/env sh
set -eu

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

exec php -S 0.0.0.0:${PORT:-10000} -t public
