FROM php:8.4.3-alpine3.21@sha256:bca51c0ca81e240d1adf97d4ad43fb7c85fe5d0a0fb8cebdb84ac4c8ef13b95d

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