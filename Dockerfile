FROM php:8.3-apache

# Install dependency sistem
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql

# Enable Apache rewrite (penting untuk Laravel)
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy project
COPY . .

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Install dependency Laravel
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Permission Laravel
RUN chown -R www-data:www-data /var/www/html

# Laravel needs this for Apache
RUN echo "<Directory /var/www/html/public>\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>" > /etc/apache2/conf-available/laravel.conf \
    && a2enconf laravel

EXPOSE 80