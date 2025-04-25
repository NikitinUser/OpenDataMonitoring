FROM php:8.4.1-fpm AS base

WORKDIR /var/www/html

# php packages
RUN apt-get update && apt-get install -y \
    git \
    curl \
    openssl \
    procps \
    libssl-dev \
    libcurl4-openssl-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libmcrypt-dev \
    libpng-dev \
    libzip-dev \
    libpq-dev \
    libfcgi0ldbl \
    libicu-dev \
    libldap-dev \
    && pecl install redis \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl \
    && docker-php-ext-enable intl \
    && docker-php-ext-enable redis \
    && docker-php-ext-install ldap \
    && docker-php-ext-enable ldap \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install -j$(nproc) gd iconv zip bcmath calendar posix sockets \
    && docker-php-ext-install pdo pdo_pgsql pgsql

ENV LC_ALL C.UTF-8

ARG UID
ENV UID $UID

# app user
RUN addgroup --gid $UID --system app && adduser --uid $UID --system --disabled-login --disabled-password --gid $UID app

# important for unoconv
RUN mkdir /var/www/.config \
    && chown app:app /var/www/.config \
    # unoconv in rabbit is trying to create dir in this folder under user app :(
    && chown app:app /root \
    # for composer cache
    && mkdir /var/www/.composer \
    && chown app:app /var/www/.composer

ARG PHP_INI=php.ini
ENV PHP_INI $PHP_INI

COPY docker/service-php/$PHP_INI /usr/local/etc/php/php.ini
COPY docker/service-php/www.conf /usr/local/etc/php-fpm.d/www.conf

ENV TZ=Europe/Moscow

FROM base AS service-php
COPY --chown=app:app . ./

