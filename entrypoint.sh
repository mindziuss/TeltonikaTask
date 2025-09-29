#!/bin/sh

chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache /var/www/database

exec php-fpm