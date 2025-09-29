#!/bin/sh

if [ ! -f .env ]; then
  echo ".env file is missing — copying .env.example"
  cp .env.example .env
fi

echo "APP_KEY — generating"
php artisan key:generate --force

echo "Setting perms"

sudo chown -R www-data:www-data database app tests
sudo chmod -R 775 database app tests

echo "Perms Set"
