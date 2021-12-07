FROM php:7.4-fpm

COPY --from=composer /usr/bin/composer /usr/bin/composer
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/bin/

RUN apt update && apt -y install zip unzip \
    && install-php-extensions pdo_pgsql zip xdebug \
    && apt clean \
    && cp /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini

COPY ./99-xdebug.ini /usr/local/etc/php/conf.d/99-xdebug.ini

WORKDIR /app
