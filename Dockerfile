# ---------- Stage 1: frontend assets (Vite + Tailwind v4) ----------
FROM node:20-alpine AS frontend
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci --no-audit --no-fund
COPY resources ./resources
COPY public ./public
COPY vite.config.js ./
RUN npm run build


# ---------- Stage 2: runtime (PHP 8.4 + Apache) ----------
FROM php:8.4-apache

ENV COMPOSER_ALLOW_SUPERUSER=1 \
    COMPOSER_HOME=/tmp/composer \
    APACHE_DOCUMENT_ROOT=/var/www/html/public

# System deps + PHP extensions required by README
# (pdo_pgsql, pgsql, mbstring, bcmath, curl, dom, tokenizer, xml) + zip/intl/opcache/pcntl
RUN apt-get update && apt-get install -y --no-install-recommends \
        git curl zip unzip \
        libpq-dev libzip-dev libicu-dev libpng-dev libonig-dev libxml2-dev \
        postgresql-client \
    && docker-php-ext-install -j"$(nproc)" \
        pdo_pgsql pgsql bcmath intl zip opcache pcntl \
    && a2enmod rewrite headers \
    && rm -rf /var/lib/apt/lists/*

# Composer binary from official image
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Install PHP deps first (better layer caching)
COPY composer.json composer.lock ./
RUN composer install \
        --no-dev \
        --no-interaction \
        --prefer-dist \
        --optimize-autoloader \
        --no-scripts

# Application source
COPY . .

# Built frontend assets from Stage 1
COPY --from=frontend /app/public/build ./public/build

# Apache vhost + PHP production tweaks
COPY docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY docker/php/production.ini /usr/local/etc/php/conf.d/production.ini

# Entrypoint (waits for Postgres, runs migrations, fixes perms)
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh \
    && mkdir -p storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache \
    && composer dump-autoload --optimize --no-dev \
    && php artisan storage:link --no-interaction || true

EXPOSE 80

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["apache2-foreground"]
