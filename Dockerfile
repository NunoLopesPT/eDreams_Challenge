FROM php:8-fpm

# Install developer dependencies
RUN apt-get update -yqq
RUN apt-get install -y libzip-dev
RUN docker-php-ext-install zip
RUN pecl install xdebug && docker-php-ext-enable xdebug;
RUN export PHP_IDE_CONFIG="serverName=eDreams"
RUN docker-php-ext-install pdo_mysql

WORKDIR /app

# install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
