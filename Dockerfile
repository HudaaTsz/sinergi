FROM php:8.3-fpm-alpine

# Install ekstensi sistem & driver PostgreSQL
RUN apk add --no-cache \
    nginx \
    supervisor \
    curl \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Copy konfigurasi dari folder .docker ke dalam sistem internal server
COPY .docker/nginx.conf /etc/nginx/nginx.conf
COPY .docker/supervisord.conf /etc/supervisord.conf

WORKDIR /var/www/html
COPY . .

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# Atur hak akses folder storage Laravel agar tidak error 500
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
