#!/bin/sh
set -e

cd /var/www/html

if [ ! -f artisan ]; then

    composer create-project laravel/laravel . "^12.0"

    mkdir -p storage/framework/{cache,sessions,views} bootstrap/cache && chmod -R 0777 storage bootstrap/cache

    if [ -f /var/env/laravel.env ]; then
        cp /var/env/laravel.env .env
    elif [ ! -f .env ]; then
        cp .env.example .env
    fi

    php artisan key:generate
    php artisan migrate
fi

#exec "$@"