FROM php:8.3-cli

RUN apt-get update && apt-get install -y libpq-dev git unzip && \
    docker-php-ext-install pdo pdo_pgsql && \
    apt-get clean

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

RUN composer install --no-dev --optimize-autoloader

EXPOSE 8000

CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
