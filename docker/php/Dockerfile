FROM php:7.4.16-fpm-alpine3.13 as php

RUN \
    apk add --no-cache --virtual .build-deps autoconf gcc g++ make \
    && apk add --no-cache bash icu-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl opcache \
    && apk del .build-deps

COPY docker/php/config/php.ini /usr/local/etc/php/conf.d/helper_tool-dev.ini

# ------------------------------------------- SYMFONY -------------------------------------------- #

RUN \
    wget https://get.symfony.com/cli/installer -O - | bash \
    && mv /root/.symfony/bin/symfony /usr/local/bin/symfony

WORKDIR /app

RUN symfony server:ca:install
