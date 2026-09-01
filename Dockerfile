# ==========================================
# Stage 1 — Composer Dependencies
# ==========================================
FROM composer:2 AS vendor

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install \
    --no-interaction \
    --prefer-dist \
    --ignore-platform-reqs \
    --no-dev \
    --no-scripts \
    --no-autoloader

COPY . .
RUN composer dump-autoload --optimize --no-dev


# ==========================================
# Stage 2 — Build Vue/Vite Assets
# ==========================================
FROM node:20-alpine AS frontend

WORKDIR /app

# Copy dependency files terlebih dahulu
COPY package*.json ./

# Install dependency
RUN npm ci

# Copy source project
COPY . .

# Copy vendor dari stage 1 (dibutuhkan oleh ZiggyVue saat npm run build)
COPY --from=vendor /app/vendor /app/vendor

# Build Vue/Vite
RUN npm run build


# ==========================================
# Stage 2 — Laravel + Apache
# ==========================================
FROM php:8.3-apache

WORKDIR /var/www/html

# ==========================================
# System dependencies
# ==========================================
RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    zip \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    && rm -rf /var/lib/apt/lists/*

# ==========================================
# PHP extensions
# ==========================================
RUN docker-php-ext-configure gd \
    --with-freetype \
    --with-jpeg \
    && docker-php-ext-install \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip

# ==========================================
# Apache
# ==========================================
RUN a2enmod rewrite

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri \
    -e "s!/var/www/html!${APACHE_DOCUMENT_ROOT}!g" \
    /etc/apache2/sites-available/*.conf

RUN sed -ri \
    -e "s!/var/www/!${APACHE_DOCUMENT_ROOT}!g" \
    /etc/apache2/apache2.conf \
    /etc/apache2/conf-available/*.conf


# ==========================================
# Composer
# ==========================================
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer


# ==========================================
# Laravel application
# ==========================================
COPY . .


# ==========================================
# Copy Vue/Vite production assets
# ==========================================
COPY --from=frontend /app/public/build /var/www/html/public/build


# ==========================================
# Copy vendor from Composer stage
# ==========================================
COPY --from=vendor /app/vendor /var/www/html/vendor


# ==========================================
# Laravel permissions
# ==========================================
RUN chown -R www-data:www-data \
    /var/www/html/storage \
    /var/www/html/bootstrap/cache


# ==========================================
# Expose Apache
# ==========================================
EXPOSE 80

CMD ["apache2-foreground"]