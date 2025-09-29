#!/bin/sh

echo "**Migrations and seeders starting**"

docker-compose exec app php artisan migrate --force
docker-compose exec app php artisan db:seed --force

echo "**Migrations and seeders completed**"
