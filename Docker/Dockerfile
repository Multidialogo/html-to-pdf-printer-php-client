FROM php:7.4-cli

RUN apt-get update && \
    apt-get install -y libzip-dev unzip git && \
    docker-php-ext-install zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app
RUN git config --global --add safe.directory /app
