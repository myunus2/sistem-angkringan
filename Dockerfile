FROM php:8.3-apache

# Install extension PHP
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql

# ❗ HAPUS SEMUA MPM YANG BENTROK (INI KUNCI FIX)
RUN rm -f /etc/apache2/mods-enabled/mpm_*
RUN a2dismod mpm_event || true
RUN a2dismod mpm_worker || true
RUN a2dismod mpm_prefork || true

# ✔ AKTIFKAN HANYA PREFORK (PHP WAJIB INI)
RUN a2enmod mpm_prefork

# Apache rewrite
RUN a2enmod rewrite

WORKDIR /var/www/html

COPY . .

# arahkan ke public Laravel
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

RUN chown -R www-data:www-data /var/www/html

EXPOSE 80