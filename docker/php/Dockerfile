FROM php:7.4-fpm-alpine3.13

RUN apk update && apk add \
mariadb-client \
php7-pdo_mysql \
vim

RUN docker-php-ext-install pdo_mysql

WORKDIR /var/www/framework