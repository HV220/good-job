FROM php:8.1-fpm-bullseye

WORKDIR /app

ARG DEBIAN_FRONTEND=noninteractive

RUN apt-get autoremove && apt-get autoclean \
    && apt-get update && apt-get install -y \
    zip \
    libavif-dev \
    libicu-dev \
    libpq-dev \
    libpng-dev \
    libmagickwand-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libmemcached-dev \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && pecl upgrade && pecl install -f imagick apcu memcached


RUN docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg \
    && docker-php-ext-install intl mysqli pdo_mysql pgsql pdo_pgsql gd \
    && docker-php-ext-enable imagick apcu memcached opcache

RUN ln -s $PHP_INI_DIR/php.ini-production $PHP_INI_DIR/php.ini \
    && chown -R www-data:www-data /app

CMD ["php-fpm"]
