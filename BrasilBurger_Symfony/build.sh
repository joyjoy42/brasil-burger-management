#!/usr/bin/env bash
# exit on error
set -o errexit

# Install dependencies
composer install --no-dev --optimize-autoloader

# Clear and warmup cache
php bin/console cache:clear
php bin/console cache:warmup

# Run migrations (if any)
# php bin/console doctrine:migrations:migrate --no-interaction
