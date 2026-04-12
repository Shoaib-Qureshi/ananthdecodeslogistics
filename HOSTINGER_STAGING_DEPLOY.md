# Hostinger Staging Deploy

This is the SSH deploy flow for the Hostinger staging site when the server folder is **not** a Git repository, but contains these folders:

- `ananth`
- `public_html`

Staging path used here:

```bash
/home/u644731106/domains/wheat-raccoon-723278.hostingersite.com
```

## 1. Connect to Hostinger via SSH

Use the SSH command from Hostinger hPanel.

## 2. Go to your home folder

```bash
cd ~
```

## 3. Optional backup

Back up the current Laravel `.env` before deploying:

```bash
cp /home/u644731106/domains/wheat-raccoon-723278.hostingersite.com/ananth/.env ~/_ananth_env_backup
```

## 4. Clone the latest GitHub code into a temporary folder

```bash
cd ~
rm -rf ananthdecodeslogistics-temp
git clone https://github.com/Shoaib-Qureshi/ananthdecodeslogistics.git ananthdecodeslogistics-temp
```

If GitHub asks for login details:

- Username: your GitHub username
- Password: use a GitHub Personal Access Token

## 5. Copy the updated files to staging

```bash
cp -a ananthdecodeslogistics-temp/ananth/. /home/u644731106/domains/wheat-raccoon-723278.hostingersite.com/ananth/
cp -a ananthdecodeslogistics-temp/public_html/. /home/u644731106/domains/wheat-raccoon-723278.hostingersite.com/public_html/
```

## 6. Run Laravel commands

```bash
cd /home/u644731106/domains/wheat-raccoon-723278.hostingersite.com/ananth
php artisan migrate --force
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 7. Clean up the temporary clone

```bash
cd ~
rm -rf ananthdecodeslogistics-temp
```

## 8. Verify staging

Test these on the staging URL:

- Homepage
- Blog pages
- Contributor flow
- Admin/profile pages

## One-Block Version

```bash
cd ~
cp /home/u644731106/domains/wheat-raccoon-723278.hostingersite.com/ananth/.env ~/_ananth_env_backup
rm -rf ananthdecodeslogistics-temp
git clone https://github.com/Shoaib-Qureshi/ananthdecodeslogistics.git ananthdecodeslogistics-temp
cp -a ananthdecodeslogistics-temp/ananth/. /home/u644731106/domains/wheat-raccoon-723278.hostingersite.com/ananth/
cp -a ananthdecodeslogistics-temp/public_html/. /home/u644731106/domains/wheat-raccoon-723278.hostingersite.com/public_html/
cd /home/u644731106/domains/wheat-raccoon-723278.hostingersite.com/ananth
php artisan migrate --force
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
cd ~
rm -rf ananthdecodeslogistics-temp
```

## Important Notes

- Run this in the staging domain folder, not the live production domain folder.
- This approach keeps the server's existing `.env`, `vendor`, and `storage` in place.
- Use this flow because the staging folder itself is not a Git repository.
