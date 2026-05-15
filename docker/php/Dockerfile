FROM php:8.4-fpm-alpine

COPY php.ini /usr/local/etc/php/conf.d/custom.ini
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN apk add --no-cache \
    bash \
    git \
    unzip \
    curl \
    postgresql-dev \
    icu-dev \
    oniguruma-dev \
    libzip-dev \
    zip \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    && docker-php-ext-configure gd --with-jpeg --with-freetype \
    && docker-php-ext-install \
        pdo \
        pdo_pgsql \
        pgsql \
        intl \
        mbstring \
        zip \
        bcmath \
        exif \
        gd \
    && rm -rf /var/cache/apk/*

COPY setup.sh /usr/bin/minicrm/setup.sh
RUN chmod +x /usr/bin/minicrm/setup.sh

WORKDIR /var/www/html

ENTRYPOINT ["/usr/bin/minicrm/setup.sh"]
CMD ["php-fpm"]