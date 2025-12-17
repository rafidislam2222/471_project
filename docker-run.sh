#!/bin/bash

# 1. Clear and Cache Config
echo "Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 2. Run Database Migrations
echo "Running migrations..."
php artisan migrate --force

# 3. Start Apache
echo "Starting Apache..."
apache2-foreground
