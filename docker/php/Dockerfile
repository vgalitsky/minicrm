FROM php:8.4-fpm-alpine

RUN mkdir -p /usr/bin/setup

COPY mini-crm-setup.sh /usr/bin/
COPY setup/*.sh /usr/bin/setup/
COPY php.ini /usr/local/etc/php/conf.d/custom.ini
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN chmod +x /usr/bin/mini-crm-setup.sh && chmod +x /usr/bin/setup/*.sh

RUN /usr/bin/setup/server.sh

#    /usr/bin/mini-crm-setup.sh


WORKDIR /var/www/html

ENTRYPOINT ["/usr/bin/mini-crm-setup.sh"]
CMD ["php-fpm"]