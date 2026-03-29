# Guest Contributor Workflow — Build Checklist

Phase 1 implementation complete. All tasks below are marked as done.

---

## Build Order

- [x] **1. Migrations**
  - `2026_03_29_000001_add_contributor_fields_to_users_table` — adds `status`, `reason_for_joining`, `rejection_reason` to users
  - `2026_03_29_000002_create_contributor_posts_table` — new `contributor_posts` table (separate from existing `blogs`)

- [x] **2. Models**
  - `User.php` — updated with `contributorPosts()`, `isAdmin()`, `isGuest()`, `isApproved()` helpers, updated `$fillable`
  - `ContributorPost.php` — new model with `author()`, `category()`, `generateUniqueSlug()`, `getStatusBadgeClass()`, scopes
  - `Blogs.php` — added `user()` and `category()` relationships

- [x] **3. Seeders**
  - `ContributorSeeder` — seeds admin user (`admin@ananthdecodeslogistics.com`) and default category `Logistics Insights`
  - Run: `php artisan db:seed --class=ContributorSeeder`
  - **Important:** Admin password is `ChangeMe@2026!` — change immediately after seeding

- [x] **4. Middleware**
  - `GuestContributor` — checks `auth + role=guest + status=approved`; registered as `guest.contributor`
  - `Admin` — updated from `id == 1` to `user_role === 'admin'`; already registered as `admin`

- [x] **5. Controllers**
  - `Contributor/ContributorRegistrationController` — `showForm`, `submit`, `approve`, `reject`
  - `Contributor/GuestAuthController` — `showLogin`, `login`, `logout`
  - `Contributor/GuestPostController` — `index`, `create`, `store`, `edit`, `update`
  - `Admin/AdminContributorController` — `registrations`, `approveRegistration`, `rejectRegistration`, `posts`, `approvePost`, `rejectPost`
  - `Front/ContributorBlogController` — `blog` (admin posts), `showBlog`, `contributors` (guest posts), `showContributor`

- [x] **6. Routes**
  - `GET  /write-for-us` — contributor registration form
  - `POST /write-for-us` — submit registration
  - `GET  /contributor-login` — guest login
  - `POST /contributor-login` — guest login submit
  - `POST /contributor-logout` — guest logout
  - `GET  /blog` — Ananthakrishnan editorial posts (replaces old allPost route)
  - `GET  /blog/{slug}` — single admin post
  - `GET  /contributors` — guest contributor posts listing
  - `GET  /contributors/{slug}` — single contributor post
  - `GET  /dashboard` — guest dashboard (middleware: guest.contributor)
  - `GET  /dashboard/posts` — guest post list
  - `GET  /dashboard/posts/create` — create post form
  - `POST /dashboard/posts` — submit post
  - `GET  /dashboard/posts/{id}/edit` — edit rejected post
  - `POST /dashboard/posts/{id}` — update/resubmit post
  - `GET  /admin/registrations` — pending registrations (middleware: admin)
  - `POST /admin/registrations/{id}/approve` — approve registration
  - `POST /admin/registrations/{id}/reject` — reject registration
  - `GET  /admin/contributor-posts` — contributor posts list
  - `POST /admin/contributor-posts/{id}/approve` — approve + publish post
  - `POST /admin/contributor-posts/{id}/reject` — reject post with reason
  - `GET  /password/reset` — request reset link
  - `POST /password/email` — send reset link
  - `GET  /password/reset/{token}` — password set form
  - `POST /password/reset` — set password

- [x] **7. Blade Views**
  - `layouts/dashboard.blade.php` — Bootstrap 5 SaaS-style dashboard layout with sidebar
  - `contributor/register.blade.php` — public registration form (inline success message)
  - `contributor/login.blade.php` — standalone contributor login page
  - `blog/index.blade.php` — editorial posts (admin only), uses front layout
  - `blog/show.blade.php` — single admin post with author bio
  - `contributors/index.blade.php` — guest contributor posts listing
  - `contributors/show.blade.php` — single contributor post with author bio
  - `dashboard/index.blade.php` — dashboard home with 4 stat cards + posts table
  - `dashboard/posts/create.blade.php` — post creation form with Quill rich-text editor
  - `dashboard/posts/edit.blade.php` — edit rejected post (shows rejection reason at top)
  - `admin/contributor/registrations.blade.php` — tabbed registrations table (pending/approved/rejected)
  - `admin/contributor/posts.blade.php` — tabbed contributor posts table with preview modal
  - `auth/passwords/email.blade.php` — request password reset
  - `auth/passwords/reset.blade.php` — set new password

- [x] **8. Mail Classes + Email Templates**
  - `NewRegistrationAdminNotification` → `emails/contributor/new-registration.blade.php`
  - `ContributorApproved` → `emails/contributor/approved.blade.php`
  - `ContributorRejected` → `emails/contributor/rejected.blade.php`
  - `NewPostAdminNotification` → `emails/contributor/new-post.blade.php`
  - `PostApproved` → `emails/contributor/post-approved.blade.php`
  - `PostRejected` → `emails/contributor/post-rejected.blade.php`
  - All 6 triggers: registration submitted, guest approved, guest rejected, post submitted, post approved, post rejected
  - Local dev uses `MAIL_MAILER=log` — emails appear in `storage/logs/laravel.log`

---

## Key URLs

| URL | Description |
|-----|-------------|
| `/write-for-us` | Public contributor registration form |
| `/contributor-login` | Guest login |
| `/blog` | Ananthakrishnan editorial posts only |
| `/blog/{slug}` | Single editorial post |
| `/contributors` | Guest contributor posts only |
| `/contributors/{slug}` | Single contributor post |
| `/dashboard` | Guest contributor dashboard |
| `/admin/registrations` | Admin: manage registrations |
| `/admin/contributor-posts` | Admin: manage contributor posts |
| `/password/reset` | Password reset (for approved contributors) |

---

## Admin Sidebar Updated
New links added to existing admin sidebar:
- **Contributor Registrations** → `/admin/registrations`
- **Contributor Posts** → `/admin/contributor-posts`

---

## Architecture Notes

- `contributor_posts` table is **separate from `blogs`** — existing admin blog system untouched
- `user_role` field extended: `admin | user | guest` (was `admin | user`)
- `status` field added to users: `pending | approved | rejected` (existing users default to `approved`)
- Guest auth uses the same Laravel `Auth` system as admin but validated by role+status in middleware
- Emails fail silently in `try/catch` — workflow always completes even if mail is down
- `MAIL_MAILER=log` set locally — configure SMTP in `.env` for production

---

## Production Deployment Notes

1. Update `.env`:
   - Set `MAIL_MAILER=smtp` with proper SMTP credentials
   - Set `ADMIN_NOTIFICATION_EMAIL` to the email that receives new registration/post alerts
   - Set `APP_URL` to the production domain
2. Run `php artisan migrate` on the server
3. Run `php artisan db:seed --class=ContributorSeeder`
4. Run `php artisan storage:link`
5. Change admin password after seeding
