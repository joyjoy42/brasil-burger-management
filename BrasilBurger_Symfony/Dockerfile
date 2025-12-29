FROM dunglas/symfony-docker:php-8.3

WORKDIR /app

COPY composer.json composer.lock symfony.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction

COPY . .

RUN php bin/console cache:clear --env=prod && \
    php bin/console cache:warmup --env=prod

EXPOSE 8000

CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]