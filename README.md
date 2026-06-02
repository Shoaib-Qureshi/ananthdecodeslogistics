# Ananth Decodes Logistics

Laravel-based website and content platform for Ananth Decodes Logistics. The project includes public pages, blogs, board insights, book reviews, contributor publishing workflows, event registration/sponsorship pages, gallery management, and an admin CMS.

Repository: `Shoaib-Qureshi/ananthdecodeslogistics`

## Project Structure

```text
.
+-- ananth/                  # Main Laravel application
|   +-- app/                 # Controllers, models, middleware, application logic
|   +-- config/              # Laravel configuration
|   +-- database/            # Migrations, seeders, factories
|   +-- resources/           # Blade views, CSS, JS source files
|   +-- routes/              # Laravel route definitions
|   +-- storage/             # Runtime logs, cache, uploaded files
|   +-- public/              # Laravel public build output
|   +-- composer.json        # PHP dependencies
|   +-- package.json         # Frontend build dependencies
+-- public_html/             # Hostinger web root / public entry files
+-- HOSTINGER_STAGING_DEPLOY.md
+-- README.md
```

The hosting setup uses `public_html` as the public web root and `ananth` as the Laravel application directory.

## Tech Stack

- **Backend:** PHP `^7.4|^8.0`, Laravel `8.x`
- **Database:** MySQL / MariaDB
- **Frontend:** Blade templates, JavaScript, CSS
- **Asset Build:** Laravel Mix `6.x`, Webpack, PostCSS
- **Styling:** Tailwind CSS configuration
- **Authentication:** Laravel auth/password reset flows, custom admin and contributor auth
- **API/Auth Support:** Laravel Sanctum
- **Image Handling:** Intervention Image
- **HTTP Client:** Guzzle
- **Payments:** Razorpay integration fields and payment verification routes
- **Testing:** PHPUnit
- **Deployment Target:** Hostinger shared hosting / staging and production domains

## Main Features

- Public marketing pages: home, about, contact, privacy policy, terms, disclaimer, gallery
- Blog and article publishing
- Topic and author archive pages
- Board insights management
- Book review management
- Admin dashboard and profile management
- Admin user, member, page content, banner, gallery, and milestone management
- Contributor application, approval, login, dashboard, profile, and post workflow
- Contributor plan and payment management
- Google login/redirect support
- Event module with event pages, agenda/FAQ data, registrations, sponsor packages, and sponsor payments
- Contact form and admin message listing

## Requirements

- PHP 7.4 or newer
- Composer
- Node.js and npm
- MySQL or MariaDB
- A web server such as Apache or Nginx

For Hostinger deployment, PHP, Composer dependencies, storage permissions, and `.env` values must be configured on the server.

## Local Setup

Clone the repository:

```bash
git clone https://github.com/Shoaib-Qureshi/ananthdecodeslogistics.git
cd ananthdecodeslogistics/ananth
```

Install PHP dependencies:

```bash
composer install
```

Install frontend dependencies:

```bash
npm install
```

Create the environment file:

```bash
cp .env.example .env
php artisan key:generate
```

Update `.env` with local values:

```env
APP_NAME="Ananth Decodes Logistics"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

Run migrations:

```bash
php artisan migrate
```

Create the storage symlink:

```bash
php artisan storage:link
```

Build frontend assets:

```bash
npm run dev
```

Start the local Laravel server:

```bash
php artisan serve
```

The app should be available at:

```text
http://localhost:8000
```

## Environment Variables

Important `.env` groups used by the project:

- `APP_*` - Laravel app name, URL, environment, debug mode, and app key
- `DB_*` - MySQL/MariaDB database connection
- `MAIL_*` - SMTP mail configuration
- `ADMIN_NOTIFICATION_EMAIL` - admin notification recipient
- `GOOGLE_CLIENT_ID`, `GOOGLE_CLIENT_SECRET`, `GOOGLE_REDIRECT_URI` - Google auth integration
- `RAZORPAY_KEY_ID`, `RAZORPAY_KEY_SECRET`, `RAZORPAY_WEBHOOK_SECRET`, `RAZORPAY_COMPANY_NAME` - payment integration
- `FILESYSTEM_DRIVER`, `CACHE_DRIVER`, `SESSION_DRIVER`, `QUEUE_CONNECTION` - Laravel runtime drivers

Do not commit real `.env` files, API keys, database credentials, mail passwords, or payment secrets.

## Common Commands

Run tests:

```bash
php artisan test
```

Clear local cache:

```bash
php artisan optimize:clear
```

Build production assets:

```bash
npm run prod
```

Cache config, routes, and views for deployment:

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Important Routes

- `/` - homepage
- `/about-us` - about page
- `/contact-us` - contact page
- `/blog` - public blog listing
- `/blog/{slug}` - blog detail page
- `/expert-desk` - contributor/expert desk posts
- `/expert-desk/apply` - contributor application
- `/expert-desk/login` - contributor login
- `/dashboard` - contributor dashboard
- `/board-insights` - board insights listing
- `/book-review` - book reviews
- `/events/conference` - event conference page
- `/events/register` - event registration
- `/gallery` - gallery page
- `/admin/adl-login` - admin login

## Database Modules

The database includes migrations for:

- Users, password resets, failed jobs, and Sanctum tokens
- Blogs and blog categories
- Board insights
- Book reviews
- Contact messages
- Executive committee/team members
- Home/about page settings
- Milestones, founders, credentials, service cards, expert desk pillars
- Page banners and gallery images
- Contributor users, posts, plans, payments, SEO fields, and FAQ fields
- Events, agenda items, FAQs, registrations, sponsor packages, and sponsor payments

## Deployment

Detailed Hostinger staging deployment instructions are available in:

```text
HOSTINGER_STAGING_DEPLOY.md
```

The documented deployment flow:

1. Clone the GitHub repository into a temporary folder on Hostinger.
2. Copy `ananth/` into the server Laravel app folder.
3. Copy `public_html/` into the server public web root.
4. Run migrations and Laravel cache commands.
5. Remove the temporary clone.

Typical Laravel deployment commands:

```bash
cd /path/to/ananth
php artisan migrate --force
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Security Notes

- Keep `.env` out of Git.
- Keep server-specific files, backups, database dumps, and compressed deployment archives out of Git unless intentionally required.
- Review uploaded files and public assets before deployment.
- Use production Razorpay, Google, SMTP, and database credentials only on secure server environments.
- Ensure `storage/` and `bootstrap/cache/` are writable by the server user.

## License

This is a private/client project. Add a license file before publishing as open source.
