FROM php:8.1-fpm-alpine as backend

# configure php
COPY .docker/php.ini $PHP_INI_DIR/conf.d/opcache.ini

# use the default development configuration
RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

# install bash
RUN apk --no-cache add bash mysql-client mariadb-connector-c-dev

# create user based on provided user id
ARG HOST_UID
RUN adduser --disabled-password --gecos "" --uid $HOST_UID demo

# switch to user
USER demo
