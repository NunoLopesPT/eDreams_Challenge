FROM php:8-fpm

# Install developer dependencies
RUN apt-get update -yqq
RUN apt-get install -y libzip-dev
RUN docker-php-ext-install zip

WORKDIR /app

# install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY ./ /app

RUN composer install --no-interaction --prefer-dist
