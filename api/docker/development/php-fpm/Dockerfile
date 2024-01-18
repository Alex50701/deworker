FROM php:8.1-fpm-alpine3.16

ENV XDEBUG_VERSION 3.1.3

RUN apk add --no-cache postgresql-dev fcgi git
RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql
RUN git clone --branch $XDEBUG_VERSION --depth 1 https://github.com/xdebug/xdebug.git /usr/src/php/ext/xdebug
RUN docker-php-ext-configure xdebug --enable-xdebug-dev
RUN docker-php-ext-install pdo_pgsql xdebug
RUN apk del git

RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

COPY ./common/php/conf.d /usr/local/etc/php/conf.d
COPY ./development/php/conf.d /usr/local/etc/php/conf.d
COPY ./development/php-fpm/conf.d /usr/local/etc/php/conf.d

WORKDIR /app
