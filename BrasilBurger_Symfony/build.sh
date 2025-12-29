#!/usr/bin/env bash
# exit on error
set -o errexit

# Install dependencies
composer install --no-dev --optimize-autoloader

# Clear and warmup cache for production
php bin/console cache:clear --env=prod
php bin/console cache:warmup --env=prod

# Install assets
php bin/console assets:install public --env=prod

# Run migrations (uncomment if needed)
# php bin/console doctrine:migrations:migrate --no-interaction --env=prod
