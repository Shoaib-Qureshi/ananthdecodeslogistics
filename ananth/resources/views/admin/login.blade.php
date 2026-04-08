<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

        :root {
            --page-bg: #f8fbff;
            --card-bg: #ffffff;
            --card-border: #dbeafe;
            --text-main: #0f172a;
            --text-soft: #475569;
            --primary: #3882fa;
            --primary-dark: #2563d4;
            --accent-soft: #f3f7ff;
            --accent-warm: #fff7ed;
            --accent-warm-border: #fed7aa;
            --danger-bg: #fff1f2;
            --danger-border: #fecdd3;
            --danger-text: #be123c;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
            color: var(--text-main);
            background:
                radial-gradient(circle at top left, rgba(56, 130, 250, 0.14), transparent 30%),
                radial-gradient(circle at bottom right, rgba(249, 115, 22, 0.12), transparent 28%),
                linear-gradient(180deg, #eff6ff 0%, var(--page-bg) 38%, #ffffff 100%);
        }

        .page-shell {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 28px 16px;
        }

        .login-card {
            width: min(540px, 100%);
            background: rgba(255, 255, 255, 0.96);
            border: 1px solid var(--card-border);
            border-radius: 24px;
            padding: 36px 32px;
            box-shadow: 0 24px 60px rgba(15, 23, 42, 0.08);
        }

        .brand-row {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 24px;
        }

        .brand-logo {
            width: 48px;
            height: 48px;
            border-radius: 16px;
            background: var(--accent-soft);
            border: 1px solid var(--card-border);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .brand-logo img {
            width: 28px;
            height: 28px;
            object-fit: contain;
        }

        .brand-label {
            margin: 0 0 4px;
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--primary);
        }

        .brand-name {
            margin: 0;
            font-size: 1rem;
            font-weight: 700;
            color: var(--text-main);
        }

        .hero-chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 16px;
            padding: 7px 12px;
            border-radius: 999px;
            background: var(--accent-soft);
            border: 1px solid var(--card-border);
            color: var(--primary);
            font-size: 0.76rem;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
        }

        .hero-title {
            margin: 0;
            font-size: clamp(2rem, 5vw, 2.75rem);
            line-height: 0.98;
            letter-spacing: -0.04em;
        }

        .hero-copy {
            margin: 16px 0 0;
            color: var(--text-soft);
            font-size: 0.98rem;
            line-height: 1.7;
        }

        .login-alert {
            margin-bottom: 16px;
            padding: 13px 15px;
            border-radius: 16px;
            font-size: 0.92rem;
            line-height: 1.55;
        }

        .login-alert.error {
            background: var(--danger-bg);
            border: 1px solid var(--danger-border);
            color: var(--danger-text);
        }

        .login-form {
            display: grid;
            gap: 18px;
        }

        .field label {
            display: block;
            margin-bottom: 8px;
            font-size: 0.82rem;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            color: var(--text-soft);
        }

        .field input {
            width: 100%;
            border: 1px solid #cbd5e1;
            border-radius: 16px;
            background: #ffffff;
            padding: 15px 16px;
            font-size: 0.96rem;
            color: var(--text-main);
            outline: none;
            transition: border-color .2s ease, box-shadow .2s ease, transform .2s ease;
        }

        .field input:focus {
            border-color: rgba(56, 130, 250, 0.8);
            box-shadow: 0 0 0 4px rgba(56, 130, 250, 0.12);
            transform: translateY(-1px);
        }

        .password-field {
            position: relative;
        }

        .password-field input {
            padding-right: 82px;
        }

        .password-toggle {
            position: absolute;
            top: 50%;
            right: 14px;
            transform: translateY(-50%);
            border: none;
            background: transparent;
            color: var(--primary);
            font-size: 0.82rem;
            font-weight: 700;
            cursor: pointer;
            padding: 4px 6px;
            border-radius: 10px;
        }

        .password-toggle:hover {
            color: var(--primary-dark);
        }

        .password-toggle:focus-visible {
            outline: 2px solid rgba(56, 130, 250, 0.3);
            outline-offset: 2px;
        }

        .login-submit {
            margin-top: 4px;
            border: none;
            border-radius: 16px;
            padding: 15px 18px;
            background: var(--primary);
            color: #ffffff;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: background .2s ease, transform .2s ease, box-shadow .2s ease;
            box-shadow: 0 14px 28px rgba(56, 130, 250, 0.2);
        }

        .login-submit:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 18px 32px rgba(56, 130, 250, 0.24);
        }

        .card-footer {
            margin-top: 20px;
            padding: 14px 16px;
            border-radius: 16px;
            background: var(--accent-warm);
            border: 1px solid var(--accent-warm-border);
            color: #9a3412;
            font-size: 0.88rem;
            line-height: 1.6;
        }

        @media (max-width: 560px) {
            .login-card {
                padding: 28px 20px;
                border-radius: 20px;
            }

            .brand-row {
                align-items: flex-start;
            }

            .hero-title {
                font-size: 1.9rem;
            }

        }

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                animation: none !important;
                transition: none !important;
                scroll-behavior: auto !important;
            }
        }
    </style>
</head>

<body>
    <main class="page-shell">
        <section class="login-card" aria-label="Admin login">
            <div class="brand-row">
                <div class="brand-logo">
                    <img src="/img/site/ananth-logo.svg" alt="Ananth Decodes Logistics" onerror="this.style.display='none'">
                </div>
                <div>
                    <p class="brand-label">Admin Portal</p>
                    <p class="brand-name">Ananth Decodes Logistics</p>
                </div>
            </div>

            <span class="hero-chip">/admin/adl-login</span>
            <h1 class="hero-title">Sign in to manage editorial operations.</h1>
            <p class="hero-copy">
                Access the publishing dashboard for articles, contributor workflows, and site updates from one clean workspace.
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
                    <input id="email" type="email" name="email" placeholder="admin@ananthdecodeslogistics.com" value="{{ old('email') }}" autocomplete="email" required autofocus>
                </div>

                <div class="field">
                    <label for="password">Password</label>
                    <div class="password-field">
                        <input id="password" type="password" name="password" placeholder="Enter your password" autocomplete="current-password" required>
                        <button type="button" class="password-toggle" data-password-toggle data-target="password" aria-controls="password" aria-pressed="false">Show</button>
                    </div>
                </div>

                <button type="submit" class="login-submit">Enter Admin Panel</button>
            </form>

            <div class="card-footer">
                Access is limited to approved administrators. Please use your authorized credentials to continue.
            </div>
        </section>
    </main>

    <script>
        document.querySelectorAll('[data-password-toggle]').forEach(function(button) {
            var input = document.getElementById(button.getAttribute('data-target'));

            if (!input) {
                return;
            }

            button.addEventListener('click', function() {
                var showingPassword = input.type === 'text';
                input.type = showingPassword ? 'password' : 'text';
                button.textContent = showingPassword ? 'Show' : 'Hide';
                button.setAttribute('aria-pressed', showingPassword ? 'false' : 'true');
            });
        });
    </script>
</body>

</html>
