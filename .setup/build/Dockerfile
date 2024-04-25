FROM php:8.2.1-fpm

RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip

RUN docker-php-ext-install pdo_mysql

RUN usermod -u 1000 www-data

WORKDIR /var/www

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN pecl install -o -f redis \
    &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable redis

RUN pecl install xdebug && docker-php-ext-enable xdebug && \
    echo "xdebug.mode=coverage" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

USER www-data

EXPOSE 9000
