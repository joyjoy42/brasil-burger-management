# Use the official PHP image
FROM php:8.4-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    sqlite3 \
    libsqlite3-dev \
    && docker-php-ext-install pdo_sqlite \
    && docker-php-ext-install gd \
    && docker-php-ext-install zip \
    && docker-php-ext-install opcache \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy composer files first for better caching
COPY composer.json composer.lock ./

# Install dependencies (avoid Symfony auto-scripts during image build)
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-progress --prefer-dist --no-scripts

# Copy application files
COPY . .

# Create necessary directories
RUN mkdir -p var/cache var/log public/uploads

# Ensure Render entrypoint is executable
RUN chmod +x bin/render-entrypoint.sh

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 777 /var/www/html/var \
    && chmod -R 777 /var/www/html/public/uploads

# Clear cache (best-effort)
RUN rm -rf var/cache/* || true

# Expose port
EXPOSE 10000

# Render entrypoint: initialize SQLite DB on /var/data then start server
CMD ["bin/render-entrypoint.sh"]
