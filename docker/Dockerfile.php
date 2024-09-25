FROM php:8.2-fpm

WORKDIR /var/www/html

RUN docker-php-ext-install opcache
RUN docker-php-ext-install mysqli pdo_mysql

COPY php/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# We need to overwrite if Xdebug is enabled
RUN rm /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

RUN apt-get update && apt-get install -y curl git zip unzip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# ENV PHP_MEMORY_LIMIT=1024M

# RUN echo "memory_limit=${PHP_MEMORY_LIMIT}" > /usr/local/etc/php/conf.d/memory-limit.ini

EXPOSE 9000