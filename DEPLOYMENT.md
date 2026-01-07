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

3. **Clear Laravel caches:**
   ```bash
   php artisan config:clear
   php artisan cache:clear
   php artisan route:clear
   php artisan view:clear
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

### Alternative: If you can't run composer on server

1. **On your local machine**, run:
   ```bash
   composer install --no-dev --optimize-autoloader
   ```

2. **Upload the vendor directory** to your server (but this is not recommended as vendor should be excluded from version control)

### Important Notes:

- The `vendor` directory should be in `.gitignore` and NOT committed to git
- Always run `composer install` on the server after deployment
- Use `--no-dev` flag in production to exclude development dependencies
- Use `--optimize-autoloader` for better performance

