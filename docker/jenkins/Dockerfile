FROM php:7.1-apache

RUN echo 'memory_limit = 512M' > /usr/local/etc/php/php.ini

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
  && php composer-setup.php \
  && mv composer.phar /usr/local/bin/composer \
  && rm composer-setup.php

RUN apt-get update \
  && apt-get install -y \
     default-mysql-client \
     libfreetype6-dev \
     libjpeg62-turbo-dev \
     libicu-dev \
     apt-transport-https \
     ca-certificates \
     libmemcached-dev \
     memcached \
     git \
     libmcrypt-dev \
     zip \
     unzip

RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
  && docker-php-ext-configure opcache --enable-opcache \
  && pecl install memcached \
  && docker-php-ext-enable memcached \
  && docker-php-ext-install \
    exif \
    gd \
    intl \
    pdo \
    pdo_mysql \
    opcache \
    mcrypt \
    zip \
    bcmath

WORKDIR /var/www
