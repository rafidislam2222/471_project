#!/bin/bash

# 1. Clear and Cache Config
echo "Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 2. Run Database Migrations
echo "Running migrations..."
php artisan migrate --force

# 3. FIX PERMISSIONS (This fixes the "Permission Denied" crash)
# We run this AFTER the artisan commands to fix any files they created (like laravel.log)
echo "Fixing permissions..."
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 4. Start Apache
echo "Starting Apache..."
apache2-foreground