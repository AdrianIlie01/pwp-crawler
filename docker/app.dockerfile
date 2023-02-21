FROM php:8.1.1-fpm

RUN apt-get update && apt-get install -y  \
    libmagickwand-dev \
    --no-install-recommends \
    && pecl install imagick \
    && docker-php-ext-enable imagick \
    && docker-php-ext-install pdo_mysql \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

RUN mkdir -p /home/xdebug
COPY ./docker/xdebug-debug.ini /home/xdebug/xdebug-debug.ini
COPY ./docker/xdebug-default.ini /home/xdebug/xdebug-default.ini
COPY ./docker/xdebug-off.ini /home/xdebug/xdebug-off.ini
COPY ./docker/xdebug-profile.ini /home/xdebug/xdebug-profile.ini
COPY ./docker/xdebug-trace.ini /home/xdebug/xdebug-trace.ini
ARG XDEBUG_MODES
ARG REMOTE_HOST="host.docker.internal"
ARG REMOTE_PORT=9003
ARG IDE_KEY="docker"

ENV MODES=$XDEBUG_MODES
ENV CLIENT_HOST=$REMOTE_HOST
ENV CLIENT_PORT=$REMOTE_PORT
ENV IDEKEY=$IDE_KEY

RUN docker-php-ext-enable xdebug
