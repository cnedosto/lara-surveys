FROM php:8.2

RUN apt-get update && apt-get install -y \
    libpq-dev \
    libonig-dev \
    unzip \
    zip \
    git \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install \
    pdo pdo_pgsql mbstring pcntl

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . /var/www/html

RUN composer install --optimize-autoloader --no-dev --no-cache -v

