FROM composer:latest AS composer

FROM php:8.2-fpm-alpine

ENV CACHE=--no-cache

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

WORKDIR /app

RUN apk $CACHE update && apk $CACHE add \
    postgresql-dev \
    bash \
    libzip-dev \
    zip \
    unzip \
    git \
    wget \
    build-base \
    libpng-dev \
    freetype-dev \
    libjpeg-turbo-dev \
    zlib-dev \
    libpq \
    libpq-dev \
    libffi-dev \
    openssl-dev \
    sqlite-dev \
    tk-dev \
    gdbm-dev \
    ncurses-dev \
    bzip2-dev \
    zlib-dev && \
    # Install symfony cli
    wget https://get.symfony.com/cli/installer -O - | bash && \
    # Docker 
    docker-php-ext-install bcmath gd zip

RUN mv /root/.symfony5/bin/symfony /usr/local/bin/symfony