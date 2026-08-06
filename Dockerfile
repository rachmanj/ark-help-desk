# Stage 1: Build frontend assets
FROM node:22-alpine AS node-build
WORKDIR /app
COPY package.json package-lock.json* ./
RUN npm ci --no-audit 2>/dev/null || npm install --no-audit
COPY vite.config.js ./
COPY resources/ resources/
RUN npm run build

# Stage 2: Install PHP dependencies
FROM php:8.4-fpm-alpine AS php-deps

# System packages
RUN apk add --no-cache \
    nginx \
    supervisor \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    libxml2-dev \
    oniguruma-dev \
    curl \
    mysql-client

# PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo \
        pdo_mysql \
        mbstring \
        xml \
        bcmath \
        gd \
        zip \
        opcache \
        exif \
        pcntl

# Install Redis extension
RUN apk add --no-cache --virtual .build-deps $PHPIZE_DEPS \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apk del .build-deps

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy composer files and minimal Laravel bootstrap
COPY composer.json composer.lock* ./
RUN composer install --no-dev --no-interaction --optimize-autoloader --no-progress --no-scripts

# Copy app code
COPY . .

# Run post-install scripts now that full code is available
RUN composer run-script post-autoload-dump

# Copy built frontend from Stage 1
COPY --from=node-build /app/public/build ./public/build

# Permissions
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Stage 3: Final runtime image
FROM php:8.4-fpm-alpine AS final

# Install build deps, compile extensions, then clean up
RUN apk add --no-cache --virtual .build-deps \
        $PHPIZE_DEPS \
        libpng-dev \
        libjpeg-turbo-dev \
        freetype-dev \
        libzip-dev \
        libxml2-dev \
        oniguruma-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo \
        pdo_mysql \
        mbstring \
        xml \
        bcmath \
        gd \
        zip \
        opcache \
        exif \
        pcntl \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apk del .build-deps \
    && apk add --no-cache \
        nginx \
        supervisor \
        libpng \
        libjpeg-turbo \
        freetype \
        libzip \
        libxml2 \
        oniguruma \
        curl \
        mysql-client

WORKDIR /var/www

# Copy entire app (with vendor + built frontend) from php-deps
COPY --from=php-deps /var/www /var/www

# Nginx config
COPY docker/nginx.conf /etc/nginx/http.d/default.conf

# Supervisor config
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# PHP production config
COPY docker/php.ini /usr/local/etc/php/conf.d/99-arka-helpdesk.ini

EXPOSE 80

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
