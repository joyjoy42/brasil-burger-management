# Dockerfile for Brasil Burger Symfony Application
FROM php:8.3-fpm

# Install system dependencies and PHP extensions in one step to ensure dependencies are available
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    nginx \
    postgresql-client \
    libpq-dev \
    supervisor \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo \
        pdo_pgsql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip \
        opcache \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

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

# Configure PHP
RUN echo "upload_max_filesize = 20M" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "post_max_size = 20M" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "memory_limit = 256M" >> /usr/local/etc/php/conf.d/uploads.ini

# Configure nginx for Symfony (using port 8080 by default, Render will use PORT env var)
RUN echo 'server { \
    listen 8080; \
    server_name _; \
    root /var/www/html/public; \
    index index.php; \
    client_max_body_size 20M; \
    \
    location / { \
        try_files $uri $uri/ /index.php?$query_string; \
    } \
    \
    location ~ \.php$ { \
        fastcgi_pass 127.0.0.1:9000; \
        fastcgi_index index.php; \
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name; \
        include fastcgi_params; \
        fastcgi_read_timeout 300; \
    } \
    \
    location ~ /\.ht { \
        deny all; \
    } \
}' > /etc/nginx/sites-available/default \
    && ln -sf /etc/nginx/sites-available/default /etc/nginx/sites-enabled/default

# Configure supervisor to run nginx and php-fpm
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

# Expose port
EXPOSE 8080

# Start supervisor to manage nginx and php-fpm
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
