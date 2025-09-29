FROM php:8.2-fpm

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    curl \
    git \
    nano \
    libicu-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install pdo pdo_mysql gd intl zip

RUN docker-php-ext-enable intl zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

RUN chown -R www-data:www-data storage bootstrap/cache database

CMD ["php-fpm"]