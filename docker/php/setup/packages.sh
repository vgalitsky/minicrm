#!/bin/sh
set -e

cd /var/www/html

if [ -f /var/www/packages/mtr/mini-crm/composer.json ]; then
    if ! composer show mtr/mini-crm >/dev/null 2>&1; then
        composer config repositories.mtr-mini-crm path /var/www/packages/mtr/mini-crm
        composer require mtr/mini-crm:dev-main --prefer-source
        php artisan migrate
    fi
fi