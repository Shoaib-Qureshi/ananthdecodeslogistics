# Laravel Deployment Guide for Hostinger via SSH

## Files to Upload
1. `laravel-deploy.tar.gz` (18MB) - Your application files
2. `database_backup.sql` (309KB) - Your database backup

---

## Step-by-Step Deployment Instructions

### **STEP 1: Connect to Hostinger via SSH (PuTTY)**

1. Open PuTTY
2. Enter your Hostinger hostname (usually: `your-domain.com` or IP from Hostinger)
3. Port: 22
4. Click "Open"
5. Login with your Hostinger SSH credentials

---

### **STEP 2: Upload Files to Server**

**Option A: Using FileZilla/WinSCP (Recommended)**
1. Open FileZilla or WinSCP
2. Protocol: SFTP
3. Host: Your Hostinger hostname
4. Username: Your SSH username
5. Password: Your SSH password
6. Port: 22
7. Connect and upload:
   - `laravel-deploy.tar.gz` → `/home/u644731106/`
   - `database_backup.sql` → `/home/u644731106/`

**Option B: Using SCP from Linux Terminal**
```bash
scp laravel-deploy.tar.gz your-username@your-domain.com:/home/u644731106/
scp database_backup.sql your-username@your-domain.com:/home/u644731106/
```

---

### **STEP 3: Extract and Deploy via SSH**

Once connected via PuTTY, run these commands:

```bash
# Navigate to home directory
cd /home/u644731106/

# Create backup of current installation (if exists)
if [ -d "public_html_backup" ]; then rm -rf public_html_backup; fi
if [ -d "public_html" ]; then mv public_html public_html_backup; fi

# Create new directories
mkdir -p laravel-app
cd laravel-app

# Extract the deployment archive
tar -xzf ../laravel-deploy.tar.gz

# Install Composer dependencies
composer install --optimize-autoloader --no-dev

# Set up the public directory
cd /home/u644731106/
ln -s laravel-app/public public_html

# Set correct permissions
cd laravel-app
chmod -R 755 storage bootstrap/cache
chmod 644 .env
```

---

### **STEP 4: Configure Environment (.env file)**

Edit the .env file on the server:

```bash
cd /home/u644731106/laravel-app
nano .env
```

Update these values (press `Ctrl+O` to save, `Ctrl+X` to exit):

```env
APP_NAME=AnanthDecodesLogistics
APP_ENV=production
APP_KEY=base64:K6R+hhGgM8D2kuHJf9XxsUcsqtvOLIZpq6Owys6Cmx0=
APP_DEBUG=false
APP_URL=https://www.ananthdecodeslogistics.com

LOG_CHANNEL=stack
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=u644731106_ananth
DB_USERNAME=u644731106_ananthuser
DB_PASSWORD=Q4pR:;>iX/^8j#A&9c8d+O

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DRIVER=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120
```

**Important changes:**
- `APP_ENV=production`
- `APP_DEBUG=false`
- `DB_HOST=localhost` (not 127.0.0.1)
- `APP_URL=https://www.ananthdecodeslogistics.com`

---

### **STEP 5: Import Database**

```bash
# Navigate to home directory
cd /home/u644731106/

# Import the database
mysql -u u644731106_ananthuser -p u644731106_ananth < database_backup.sql

# Enter password when prompted: Q4pR:;>iX/^8j#A&9c8d+O
```

---

### **STEP 6: Clear Caches and Optimize**

```bash
cd /home/u644731106/laravel-app

# Clear all caches
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

### **STEP 7: Fix public_html if needed**

If the symbolic link doesn't work, manually copy files:

```bash
# Remove symbolic link
rm -rf /home/u644731106/public_html

# Create new public_html
mkdir -p /home/u644731106/public_html

# Copy public folder contents
cp -r /home/u644731106/laravel-app/public/* /home/u644731106/public_html/

# Update index.php to point to correct paths
cd /home/u644731106/public_html
nano index.php
```

Update `index.php` to:

```php
<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Update these paths
require __DIR__.'/../laravel-app/vendor/autoload.php';
$app = require_once __DIR__.'/../laravel-app/bootstrap/app.php';

$kernel = $app->make(Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);
```

---

### **STEP 8: Verify Deployment**

1. Visit your website: https://www.ananthdecodeslogistics.com
2. Test these pages:
   - Homepage
   - About page (check academic credentials display)
   - Blog listing page
   - Blog detail pages (should not show 404)
   - Admin panel

---

## **Troubleshooting**

### **500 Internal Server Error**
```bash
# Check Laravel logs
tail -f /home/u644731106/laravel-app/storage/logs/laravel.log

# Reset permissions
chmod -R 755 /home/u644731106/laravel-app/storage
chmod -R 755 /home/u644731106/laravel-app/bootstrap/cache
```

### **Blog 404 Errors**
```bash
# Check .htaccess exists
ls -la /home/u644731106/public_html/.htaccess

# Verify mod_rewrite is enabled (ask Hostinger support if needed)
```

### **Images Not Loading**
```bash
# Create symlink for storage
cd /home/u644731106/laravel-app
php artisan storage:link
```

---

## **Quick Commands Reference**

```bash
# Navigate to app
cd /home/u644731106/laravel-app

# Clear cache
php artisan cache:clear

# View logs
tail -f storage/logs/laravel.log

# Check PHP version
php -v

# Check Composer
composer --version
```

---

## **Important Notes**

1. **Database is already up-to-date** - Your local environment was connected to production DB
2. **All files must be uploaded** - The archive contains all your latest changes
3. **Permissions are critical** - Make sure storage and bootstrap/cache are writable
4. **Use production .env** - Don't use debug mode in production

---

## **Files Modified in This Deployment**

1. `/resources/views/blogs/articlePage.blade.php` - Removed trailing slashes
2. `/resources/views/blogs/authorPage.blade.php` - Removed trailing slashes
3. `/resources/views/blogs/categoryPage.blade.php` - Removed trailing slashes
4. `/resources/views/blogs/allPost.blade.php` - Removed trailing slashes
5. `/public/.htaccess` - Added trailing slash redirect
6. `/app/Http/Controllers/Admin/BlogController.php` - Fixed visibility saving
7. `/app/Http/Controllers/Front/ArticleController.php` - Added visibility checks
8. `/resources/views/admin/editAboutPage.blade.php` - HTML tag highlighting
9. `/resources/views/front/aboutUs.blade.php` - Academic credentials styling

---

## **Support**

If you encounter any issues:
1. Check Laravel logs: `tail -f storage/logs/laravel.log`
2. Contact Hostinger support for server-specific issues
3. Verify .env configuration matches production requirements











cd ~

rm -rf ananthdecodeslogistics-temp
git clone https://github.com/Shoaib-Qureshi/ananthdecodeslogistics.git ananthdecodeslogistics-temp

cp -a ananthdecodeslogistics-temp/ananth/. /home/u644731106/domains/ananthdecodeslogistics.com/ananth/
cp -a ananthdecodeslogistics-temp/public_html/. /home/u644731106/domains/ananthdecodeslogistics.com/public_html/

cd /home/u644731106/domains/ananthdecodeslogistics.com/ananth
php artisan migrate --force
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

cd ~
rm -rf ananthdecodeslogistics-temp
