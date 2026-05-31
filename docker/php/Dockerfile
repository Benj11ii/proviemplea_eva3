FROM php:8.4-fpm

# Instalar extensiones necesarias para Laravel y MySQL
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        git \
        unzip \
        libzip-dev \
        curl \
    && docker-php-ext-install pdo_mysql zip \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Crear un usuario de sistema para evitar problemas de permisos con Windows/Linux
RUN useradd -m -s /bin/bash laravel
USER laravel