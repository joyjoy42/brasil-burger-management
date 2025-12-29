# Dockerfile for Brasil Burger Symfony Application
FROM php:8.3-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpq-dev \
    postgresql-client \
    zip \
    unzip \
    nginx \
    supervisor \
    gettext-base \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_pgsql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy composer files first for better caching
COPY composer.json composer.lock symfony.lock ./

# Install dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# Copy application files
COPY . /var/www/html/

# Create var directory and set permissions
RUN mkdir -p /var/www/html/var/cache /var/www/html/var/log \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/var

# Run Symfony setup commands
RUN php bin/console cache:clear --env=prod \
    && php bin/console cache:warmup --env=prod

# Copy nginx template
COPY nginx.conf.template /etc/nginx/nginx.conf.template

# Configure supervisor
RUN echo '[supervisord] \
nodaemon=true \
\
[program:php-fpm] \
command=/usr/local/sbin/php-fpm --nodaemonize \
autostart=true \
autorestart=true \
\
[program:nginx] \
command=/usr/sbin/nginx -g "daemon off;" \
autostart=true \
autorestart=true' > /etc/supervisor/conf.d/supervisord.conf

# Create startup script
RUN echo '#!/bin/bash \
envsubst < /etc/nginx/nginx.conf.template > /etc/nginx/sites-available/default \
ln -sf /etc/nginx/sites-available/default /etc/nginx/sites-enabled/default \
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf' > /start.sh \
    && chmod +x /start.sh

# Expose port
EXPOSE 8080

# Start with our custom script
CMD ["/start.sh"]