#!/bin/sh
set -e

if [ ! -f /var/www/html/.mini-crm-setup-done ]; then
    /usr/bin/setup/laravel.sh
    /usr/bin/setup/packages.sh

    touch /var/www/html/.mini-crm-setup-done
fi

exec "$@"