ARG PHP_VERSION=7.2

FROM composer:latest as composer
FROM php:${PHP_VERSION}

# replace shell with bash so we can source files
RUN rm /bin/sh && ln -s /bin/bash /bin/sh

RUN apt-get update && apt-get install -y \
    libzip-dev \
    zlib1g-dev \
    unzip \
    git-core \
    && docker-php-ext-install zip

RUN apt-get update && apt-get install -y libzip-dev zlib1g-dev unzip chromium && docker-php-ext-install zip

COPY --from=composer /usr/bin/composer /usr/bin/composer

# https://getcomposer.org/doc/03-cli.md#composer-allow-superuser
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /home/docker/.composer
# contains dev-mode packages
RUN composer global require "sllh/composer-versions-check:^2.0" "pyrech/composer-changelogs:^1.7" --prefer-dist --no-progress --no-suggest --classmap-authoritative

WORKDIR /var/www/html
COPY . /var/www/html

RUN ls -l
