# Deployment Instructions

## Fix PayPal Service Provider Error

If you encounter the error:
```
include(/home/unisane/propilor.com/vendor/composer/../srmklive/paypal/src/Providers/PayPalServiceProvider.php): 
Failed to open stream: No such file or directory
```

This means the vendor directory is missing or incomplete on the server.

### Solution:

1. **SSH into your server** and navigate to your project directory:
   ```bash
   cd /home/unisane/propilor.com
   ```

2. **Install/Update Composer dependencies:**
   ```bash
   composer install --no-dev --optimize-autoloader
   ```
   
   Or if composer is not installed globally:
   ```bash
   php composer.phar install --no-dev --optimize-autoloader
   ```

3. **Clear ALL Laravel caches (IMPORTANT - Do this FIRST if vendor is missing):**
   ```bash
   # Clear bootstrap cache files (this removes cached service providers)
   rm -f bootstrap/cache/packages.php
   rm -f bootstrap/cache/services.php
   
   # Clear all other caches
   php artisan config:clear
   php artisan cache:clear
   php artisan route:clear
   php artisan view:clear
   php artisan optimize:clear
   ```

4. **Regenerate optimized files:**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

5. **Set proper permissions:**
   ```bash
   chmod -R 755 storage bootstrap/cache
   chown -R www-data:www-data storage bootstrap/cache
   ```

### CRITICAL: If you get PayPal error BEFORE running composer

If you see the PayPal error before you can run `composer install`, you MUST clear the bootstrap cache first:

```bash
cd /home/unisane/propilor.com

# Remove cached service provider files
rm -f bootstrap/cache/packages.php
rm -f bootstrap/cache/services.php

# Then run composer install
composer install --no-dev --optimize-autoloader

# Clear all caches
php artisan optimize:clear
```

### Alternative: If you can't run composer on server

1. **On your local machine**, run:
   ```bash
   composer install --no-dev --optimize-autoloader
   ```

2. **Upload the vendor directory** to your server (but this is not recommended as vendor should be excluded from version control)

3. **On the server, clear bootstrap cache:**
   ```bash
   rm -f bootstrap/cache/packages.php
   rm -f bootstrap/cache/services.php
   php artisan optimize:clear
   ```

### Important Notes:

- The `vendor` directory should be in `.gitignore` and NOT committed to git
- Always run `composer install` on the server after deployment
- Use `--no-dev` flag in production to exclude development dependencies
- Use `--optimize-autoloader` for better performance

