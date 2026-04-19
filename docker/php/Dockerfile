FROM php:8.1-fpm

ARG UID=1000
ARG GID=1000
ARG USERNAME=laravel

COPY php.ini /usr/local/etc/php/

RUN apt-get update \
  && apt-get install -y \
    default-mysql-client \
    zlib1g-dev \
    libzip-dev \
    unzip \
    curl \
    libpng-dev \
    git \
  && docker-php-ext-install \
    pdo_mysql \
    zip \
    bcmath \
    gd \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN groupadd -g ${GID} ${USERNAME} \
  && useradd -m -u ${UID} -g ${GID} -s /bin/bash ${USERNAME}

WORKDIR /var/www

USER ${USERNAME}