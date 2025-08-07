#!/bin/sh
set -e

if [ "$1" = "php-fpm" ]; then

    # Set permissions for Laravel directories
    chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
    chmod -R 775 /var/www/storage /var/www/bootstrap/cache

    # permissions for PHPMyAdmin
    mkdir -p /sessions

    chmod 777 /sessions

    php artisan config:clear
    php artisan key:generate
    php artisan migrate --force
    php artisan config:cache
    php artisan route:cache

fi

exec "$@"