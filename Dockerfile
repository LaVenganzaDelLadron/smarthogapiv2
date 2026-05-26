# syntax=docker/dockerfile:1

# Build frontend assets
FROM node:20-alpine AS node-builder
WORKDIR /app
COPY package*.json ./
COPY vite.config.js ./
COPY resources resources
COPY public public
RUN npm ci && npm run build

# Prepare PHP runtime and application
FROM php:8.3-fpm-alpine AS php-runtime
RUN apk add --no-cache bash git openssh libzip-dev oniguruma-dev zlib-dev icu-dev && \
    docker-php-ext-install pdo pdo_mysql zip intl

WORKDIR /var/www/html
COPY composer.json composer.lock ./
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer && \
    rm composer-setup.php && \
    composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

COPY --from=node-builder /app/public/build public/build
COPY . .
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 9000
CMD ["php-fpm"]
