FROM php:7.4-fpm

COPY --from=composer /usr/bin/composer /usr/bin/composer
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/bin/

RUN apt-get update && apt-get install -y \
    && install-php-extensions pdo_pgsql zip \
    && apt-get clean \
    && cp /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini

WORKDIR /app
