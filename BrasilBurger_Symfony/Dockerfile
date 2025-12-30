FROM php:8.3-cli

RUN apt-get update && apt-get install -y libpq-dev git unzip && \
    docker-php-ext-install pdo pdo_pgsql && \
    apt-get clean

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY composer.json composer.lock symfony.lock ./

RUN composer install --no-dev --optimize-autoloader --no-interaction

COPY . .

RUN php bin/console cache:clear --env=prod && \
    php bin/console cache:warmup --env=prod

EXPOSE ${PORT:-10000}

CMD php -S 0.0.0.0:${PORT:-10000} -t public
