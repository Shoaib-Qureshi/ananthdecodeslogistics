# Simple Deployment Guide - Update Files Only

## What You Need to Upload

**Only ONE file:** `updates.tar.gz` (15KB) - Contains all 9 modified files

---

## Option 1: Upload via FileZilla/WinSCP (Easiest)

### Step 1: Upload the File
1. Open **FileZilla** or **WinSCP**
2. Connect to Hostinger:
   - Protocol: **SFTP**
   - Host: Your domain or Hostinger hostname
   - Port: **22**
   - Username: Your SSH username
   - Password: Your SSH password

3. Navigate to `/home/u644731106/` on the server
4. Upload `updates.tar.gz` to this location

### Step 2: Extract via SSH (PuTTY)
1. Open **PuTTY** and connect to Hostinger
2. Run these commands:

```bash
# Navigate to your Laravel app directory
cd /home/u644731106/domains/ananthdecodeslogistics.com/public_html

# Or if your setup is different:
# cd /home/u644731106/public_html

# Extract the updates (this will overwrite the old files)
tar -xzf /home/u644731106/updates.tar.gz

# Clear cache
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Remove the archive
rm /home/u644731106/updates.tar.gz
```

---

## Option 2: Direct Upload via SSH (No FileZilla needed)

If you can access your Hostinger via SSH, you can upload directly from your local machine:

### From Your Linux Terminal (Not PuTTY):

```bash
# Upload the update file
scp "/home/shoaib-qureshi/Downloads/My/Freelance /Backup/ananth/updates.tar.gz" username@your-domain.com:/home/u644731106/

# Then connect via PuTTY and extract as shown in Option 1 Step 2
```

---

## Option 3: Create Files Directly on Server (No Upload)

If uploading is difficult, you can create/edit each file directly on the server:

### Via SSH (PuTTY):

```bash
# Navigate to your Laravel root
cd /home/u644731106/domains/ananthdecodeslogistics.com/public_html
# Or: cd /home/u644731106/public_html

# Edit files one by one
nano resources/views/blogs/articlePage.blade.php
nano resources/views/blogs/authorPage.blade.php
nano resources/views/blogs/categoryPage.blade.php
nano resources/views/blogs/allPost.blade.php
nano app/Http/Controllers/Admin/BlogController.php
nano app/Http/Controllers/Front/ArticleController.php
nano resources/views/admin/editAboutPage.blade.php
nano resources/views/front/aboutUs.blade.php
nano public/.htaccess
```

---

## Option 4: Use Hostinger File Manager (Web-based)

1. Log in to **Hostinger hPanel**
2. Go to **Files** → **File Manager**
3. Navigate to your Laravel application directory
4. Click **Upload** → Select `updates.tar.gz`
5. Once uploaded, right-click on `updates.tar.gz` → **Extract**
6. Delete `updates.tar.gz` after extraction
7. Clear cache using **Terminal** in File Manager or via SSH

---

## What Files Are Being Updated?

1. ✅ `/resources/views/blogs/articlePage.blade.php` - Fixed blog URLs (removed trailing slashes)
2. ✅ `/resources/views/blogs/authorPage.blade.php` - Fixed blog URLs
3. ✅ `/resources/views/blogs/categoryPage.blade.php` - Fixed blog URLs
4. ✅ `/resources/views/blogs/allPost.blade.php` - Fixed blog URLs
5. ✅ `/app/Http/Controllers/Admin/BlogController.php` - Fixed visibility saving
6. ✅ `/app/Http/Controllers/Front/ArticleController.php` - Added visibility checks
7. ✅ `/resources/views/admin/editAboutPage.blade.php` - HTML tag highlighting
8. ✅ `/resources/views/front/aboutUs.blade.php` - Academic credentials styling
9. ✅ `/public/.htaccess` - Trailing slash redirect

---

## After Deployment - Test These:

- [ ] Blog detail pages load without 404 errors
- [ ] About page shows academic credentials correctly
- [ ] Blog visibility works (only visible blogs show)
- [ ] Admin can save blogs without errors
- [ ] HTML tags are highlighted in admin panel

---

## Important Notes:

1. **Database is already updated** - You're using the production database locally
2. **No need to import database** - All DB changes are already live
3. **Only files changed** - This deployment only updates modified files
4. **Safe to deploy** - Won't affect other parts of your application

---

## Troubleshooting:

### If you can't find your Laravel directory:

```bash
# Search for Laravel installation
find /home/u644731106 -name "artisan" -type f 2>/dev/null
```

### If cache clear doesn't work:

```bash
# Manual cache clear
rm -rf bootstrap/cache/*.php
rm -rf storage/framework/cache/*
rm -rf storage/framework/views/*
```

### If you get permission errors:

```bash
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

---

## Quick Reference - Commands Only:

```bash
cd /home/u644731106/public_html  # or your Laravel root directory
tar -xzf /home/u644731106/updates.tar.gz
php artisan cache:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Done! 🚀
