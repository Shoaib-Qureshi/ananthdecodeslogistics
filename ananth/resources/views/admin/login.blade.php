<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Fira+Code:wght@500;600&family=Fira+Sans:wght@300;400;500;600;700&display=swap');

        :root {
            --admin-blue: #2563eb;
            --admin-navy: #0f172a;
            --admin-slate: #475569;
            --admin-soft: #e2e8f0;
            --admin-bg: #f8fbff;
            --admin-orange: #f97316;
            --admin-white: #ffffff;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Fira Sans', sans-serif;
            color: var(--admin-navy);
            background:
                radial-gradient(circle at top left, rgba(37, 99, 235, 0.18), transparent 32%),
                radial-gradient(circle at bottom right, rgba(249, 115, 22, 0.14), transparent 28%),
                linear-gradient(135deg, #eff6ff 0%, #ffffff 48%, #f8fafc 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px 18px;
        }

        .login-shell {
            width: min(1120px, 100%);
            display: grid;
            grid-template-columns: 1.08fr 0.92fr;
            background: rgba(255, 255, 255, 0.92);
            border: 1px solid rgba(148, 163, 184, 0.18);
            border-radius: 28px;
            overflow: hidden;
            box-shadow: 0 24px 80px rgba(15, 23, 42, 0.12);
            backdrop-filter: blur(12px);
        }

        .login-brand {
            position: relative;
            padding: 56px 48px;
            background:
                linear-gradient(160deg, rgba(15, 23, 42, 0.97), rgba(30, 64, 175, 0.92)),
                url('/img/site/abstract-waves.webp') center/cover no-repeat;
            color: var(--admin-white);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 680px;
        }

        .login-brand::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(255,255,255,0.04), transparent 30%, rgba(15,23,42,0.1));
            pointer-events: none;
        }

        .brand-top,
        .brand-bottom {
            position: relative;
            z-index: 1;
        }

        .brand-kicker {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            border-radius: 999px;
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.18);
            font-size: 0.78rem;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .brand-title {
            margin: 26px 0 16px;
            font-size: clamp(2.4rem, 4vw, 4rem);
            line-height: 0.95;
            letter-spacing: -0.04em;
            max-width: 8ch;
        }

        .brand-copy {
            margin: 0;
            max-width: 500px;
            color: rgba(255,255,255,0.78);
            font-size: 1.02rem;
            line-height: 1.75;
        }

        .brand-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
            margin-top: 32px;
        }

        .brand-stat {
            padding: 18px 16px;
            border-radius: 18px;
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.12);
        }

        .brand-stat strong {
            display: block;
            font-family: 'Fira Code', monospace;
            font-size: 1.25rem;
            margin-bottom: 8px;
        }

        .brand-stat span {
            color: rgba(255,255,255,0.72);
            font-size: 0.88rem;
            line-height: 1.5;
        }

        .brand-bottom {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 18px;
        }

        .brand-note {
            max-width: 320px;
            color: rgba(255,255,255,0.72);
            font-size: 0.9rem;
            line-height: 1.6;
        }

        .brand-badge {
            padding: 12px 14px;
            border-radius: 16px;
            background: rgba(249, 115, 22, 0.16);
            border: 1px solid rgba(249, 115, 22, 0.28);
            color: #fed7aa;
            font-family: 'Fira Code', monospace;
            font-size: 0.83rem;
            white-space: nowrap;
        }

        .login-panel {
            padding: 56px 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255,255,255,0.76);
        }

        .login-card {
            width: min(420px, 100%);
        }

        .panel-kicker {
            color: var(--admin-blue);
            font-family: 'Fira Code', monospace;
            font-size: 0.82rem;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .panel-title {
            margin: 14px 0 10px;
            font-size: 2.25rem;
            line-height: 1;
            letter-spacing: -0.04em;
        }

        .panel-copy {
            margin: 0 0 28px;
            color: var(--admin-slate);
            font-size: 1rem;
            line-height: 1.7;
        }

        .login-alert {
            margin-bottom: 18px;
            padding: 14px 16px;
            border-radius: 16px;
            font-size: 0.92rem;
            line-height: 1.5;
        }

        .login-alert.error {
            background: #fff1f2;
            border: 1px solid #fecdd3;
            color: #be123c;
        }

        .login-form {
            display: grid;
            gap: 18px;
        }

        .field label {
            display: block;
            margin-bottom: 8px;
            font-size: 0.92rem;
            font-weight: 600;
            color: var(--admin-navy);
        }

        .field input {
            width: 100%;
            border: 1px solid #cbd5e1;
            border-radius: 18px;
            background: rgba(255,255,255,0.92);
            padding: 16px 18px;
            font-size: 1rem;
            color: var(--admin-navy);
            transition: border-color .2s ease, box-shadow .2s ease, transform .2s ease;
            outline: none;
        }

        .field input:focus {
            border-color: rgba(37, 99, 235, 0.7);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.12);
            transform: translateY(-1px);
        }

        .login-submit {
            margin-top: 6px;
            border: none;
            border-radius: 18px;
            padding: 16px 20px;
            background: linear-gradient(135deg, var(--admin-blue), #1d4ed8);
            color: var(--admin-white);
            font-size: 1rem;
            font-weight: 700;
            letter-spacing: 0.01em;
            cursor: pointer;
            transition: transform .2s ease, box-shadow .2s ease, opacity .2s ease;
            box-shadow: 0 18px 30px rgba(37, 99, 235, 0.22);
        }

        .login-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 22px 38px rgba(37, 99, 235, 0.26);
        }

        .panel-footer {
            margin-top: 18px;
            color: #64748b;
            font-size: 0.88rem;
            line-height: 1.6;
        }

        @media (max-width: 960px) {
            .login-shell {
                grid-template-columns: 1fr;
            }

            .login-brand {
                min-height: auto;
                padding: 42px 30px;
            }

            .brand-bottom {
                margin-top: 28px;
                flex-direction: column;
                align-items: flex-start;
            }

            .login-panel {
                padding: 42px 30px;
            }
        }

        @media (max-width: 560px) {
            body {
                padding: 14px;
            }

            .login-brand,
            .login-panel {
                padding: 28px 20px;
            }

            .brand-grid {
                grid-template-columns: 1fr;
            }

            .panel-title {
                font-size: 1.9rem;
            }
        }
    </style>
</head>

<body>
    <div class="login-shell">
        <section class="login-brand">
            <div class="brand-top">
                <span class="brand-kicker">Admin Command Center</span>
                <h1 class="brand-title">Publish faster. Review smarter.</h1>
                <p class="brand-copy">
                    Manage articles, contributor submissions, book reviews, and editorial pages from one focused workspace built for speed and clarity.
                </p>
                <div class="brand-grid">
                    <div class="brand-stat">
                        <strong>CMS</strong>
                        <span>Operational control for blogs, insights, members, and milestones.</span>
                    </div>
                    <div class="brand-stat">
                        <strong>Review</strong>
                        <span>Approve contributor registrations and posts without leaving the dashboard.</span>
                    </div>
                    <div class="brand-stat">
                        <strong>Stage</strong>
                        <span>Keep publishing and admin operations clean during staging and rollout.</span>
                    </div>
                </div>
            </div>
            <div class="brand-bottom">
                <p class="brand-note">
                    Ananth Decodes Logistics admin is designed to keep editorial operations structured, fast, and easy to scan across devices.
                </p>
                <span class="brand-badge">/admin/adl-login</span>
            </div>
        </section>

        <section class="login-panel">
            <div class="login-card">
                <div class="panel-kicker">Secure Access</div>
                <h2 class="panel-title">Sign in to the admin dashboard</h2>
                <p class="panel-copy">
                    Use your authorized admin credentials to manage live content, contributor workflows, and site updates.
                </p>

                @if (session()->has('error'))
                    <div class="login-alert error">{{ session('error') }}</div>
                @endif

                @if ($errors->any())
                    <div class="login-alert error">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form class="login-form" method="POST" action="{{ route('adminloginRequest') }}">
                    @csrf
                    <div class="field">
                        <label for="email">Email Address</label>
                        <input id="email" type="email" name="email" placeholder="admin@ananthdecodeslogistics.com" value="{{ old('email') }}" required>
                    </div>

                    <div class="field">
                        <label for="password">Password</label>
                        <input id="password" type="password" name="password" placeholder="Enter your password" required>
                    </div>

                    <button type="submit" class="login-submit">Enter Admin Panel</button>
                </form>

                <p class="panel-footer">
                    Access is restricted to approved administrators. All publishing and moderation actions happen from the dashboard after sign-in.
                </p>
            </div>
        </section>
    </div>
</body>

</html>
