#!/bin/sh
set -e

apk add --no-cache \
    bash \
    git \
    unzip \
    curl \
    postgresql-dev \
    icu-dev \
    oniguruma-dev \
    libzip-dev \
    zip

docker-php-ext-install \
    pdo \
    pdo_pgsql \
    pgsql \
    intl \
    mbstring \
    zip \
    bcmath

rm -rf /var/cache/apk/*