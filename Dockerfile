# Serve everything with Apache
FROM php:7.4-apache

WORKDIR /srv/app

COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf
COPY . .

RUN apt-get -y update \
    && apt-get install -y libicu-dev libpng-dev zlib1g-dev libzip-dev \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip

RUN docker-php-ext-install pdo pdo_mysql intl gd \
    && pecl install redis xdebug-2.8.1 \
    && docker-php-ext-enable redis xdebug \
    && chown -R www-data:www-data /srv/app \
    && a2enmod rewrite

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install
