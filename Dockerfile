# 1. Use PHP 8.4 with Apache
FROM php:8.4-apache

# 2. Install Linux Libraries and PHP Extensions
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nodejs \
    npm

# 3. Install specific PHP extensions needed for Laravel
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# 4. Enable Apache Mod Rewrite
RUN a2enmod rewrite

# 5. Set the Document Root to /public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 6. Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 7. Set Working Directory
WORKDIR /var/www/html

# 8. Copy Project Files
COPY . .

# 9. Install PHP Dependencies
RUN composer install --no-interaction --optimize-autoloader --no-dev

# 10. Install Node Dependencies & Build Assets
RUN npm install
RUN npm run build

# 11. Fix Permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 12. Expose Port 80
EXPOSE 80

# 13. Start Apache using our custom script
COPY docker-run.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-run.sh
CMD ["docker-run.sh"]
