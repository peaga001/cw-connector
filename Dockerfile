FROM php:8.3.18RC1-alpine@sha256:3b2b6b0efd76364bdc45054d415688138bf1bd88370a9fba49488136b5284d35

RUN apk add --no-cache \
    curl \
    autoconf \
    gcc \
    g++ \
    make \
    && apk add --update linux-headers \
    && pecl install xdebug \
    && docker-php-ext-enable opcache \
    && docker-php-ext-enable xdebug \
    && apk del autoconf gcc g++ make


COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN composer global require phpunit/phpunit:^10 --no-progress --no-scripts --no-interaction

WORKDIR /app

COPY docker/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini