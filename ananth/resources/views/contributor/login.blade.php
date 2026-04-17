<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Expert Desk Login - Ananth Decodes Logistics</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; }
        body {
            min-height: 100vh;
            min-height: 100dvh;
            margin: 0;
            font-family: "Inter", "Helvetica Neue", sans-serif;
            background: #0f1e2e;
            padding: clamp(1rem, 3vw, 1.5rem);
            position: relative;
            overflow-x: hidden;
            overflow-y: auto;
        }
        body::before {
            content: '';
            position: fixed;
            width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(56,130,250,0.18) 0%, transparent 70%);
            top: -150px; right: -150px;
            pointer-events: none;
        }
        body::after {
            content: '';
            position: fixed;
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(224,123,57,0.12) 0%, transparent 70%);
            bottom: -100px; left: -100px;
            pointer-events: none;
        }
        .login-wrapper {
            width: 100%;
            max-width: 420px;
            margin: 0 auto;
            min-height: calc(100vh - 3rem);
            min-height: calc(100dvh - 3rem);
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            z-index: 1;
        }
        .login-card {
            background: rgba(255,255,255,0.04);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 20px;
            padding: clamp(1.5rem, 4vw, 2.5rem);
            box-shadow: 0 24px 64px rgba(0,0,0,0.4);
        }
        .brand-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.75rem;
            text-decoration: none;
            gap: .75rem;
        }
        .brand-logo img {
            height: 32px;
            width: auto;
            filter: brightness(0) invert(1);
        }
        .brand-badge {
            background: rgba(56,130,250,0.2);
            border: 1px solid rgba(56,130,250,0.35);
            color: #7eb8ff;
            font-size: .7rem;
            font-weight: 600;
            letter-spacing: .07em;
            text-transform: uppercase;
            padding: .25rem .65rem;
            border-radius: 20px;
            display: block;
            text-align: center;
            margin-top: .5rem;
            width: fit-content;
            margin: 0 auto;
        }
        .login-title {
            color: #fff;
            font-size: 1.35rem;
            font-weight: 700;
            margin-bottom: .35rem;
            text-align: center;
        }
        .login-sub {
            color: rgba(255,255,255,0.62);
            font-size: .83rem;
            text-align: center;
            margin-bottom: 1.75rem;
            line-height: 1.6;
        }
        .form-label {
            font-size: .8rem;
            font-weight: 600;
            color: rgba(255,255,255,0.65);
            margin-bottom: .4rem;
            text-transform: uppercase;
            letter-spacing: .05em;
        }
        .form-control {
            background: rgba(255,255,255,0.06);
            border: 1.5px solid rgba(255,255,255,0.12);
            border-radius: 10px;
            color: #fff;
            padding: .65rem 1rem;
            font-size: .9rem;
            transition: border-color .15s, background .15s;
        }
        .form-control::placeholder { color: rgba(255,255,255,0.28); }
        .form-control:focus {
            background: rgba(255,255,255,0.09);
            border-color: rgba(56,130,250,0.6);
            box-shadow: 0 0 0 3px rgba(56,130,250,0.15);
            color: #fff;
            outline: none;
        }
        .form-control.is-invalid { border-color: rgba(239,68,68,0.6); }
        .invalid-feedback { font-size: .78rem; color: #fca5a5; }
        .password-field {
            position: relative;
        }
        .password-field .form-control {
            padding-right: 4.75rem;
        }
        .password-toggle {
            position: absolute;
            top: 50%;
            right: .7rem;
            transform: translateY(-50%);
            border: none;
            background: transparent;
            color: #7eb8ff;
            font-size: .78rem;
            font-weight: 700;
            letter-spacing: .02em;
            padding: .2rem .3rem;
            border-radius: 8px;
            cursor: pointer;
        }
        .password-toggle:hover { color: #aaccff; }
        .password-toggle:focus-visible {
            outline: 2px solid rgba(126, 184, 255, 0.4);
            outline-offset: 2px;
        }
        .form-check-input {
            background-color: rgba(255,255,255,0.08);
            border-color: rgba(255,255,255,0.2);
        }
        .form-check-label { color: rgba(255,255,255,0.55); font-size: .83rem; }
        .forgot-link {
            color: #7eb8ff;
            font-size: .78rem;
            text-decoration: none;
        }
        .forgot-link:hover { color: #aaccff; }
        .btn-login {
            background: #3882fa;
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: .75rem;
            font-weight: 600;
            font-size: .95rem;
            width: 100%;
            cursor: pointer;
            transition: background .2s, transform .1s, box-shadow .2s;
            box-shadow: 0 4px 20px rgba(56,130,250,0.35);
        }
        .btn-login:hover {
            background: #2563d4;
            box-shadow: 0 6px 24px rgba(56,130,250,0.45);
        }
        .btn-login:active { transform: scale(.99); }
        .divider {
            display: flex; align-items: center; gap: .75rem;
            margin: 1.5rem 0 1.25rem;
        }
        .divider span { color: rgba(255,255,255,0.18); font-size: .75rem; white-space: nowrap; }
        .divider::before, .divider::after {
            content: ''; flex: 1; height: 1px;
            background: rgba(255,255,255,0.1);
        }
        .alert-custom {
            border-radius: 10px;
            padding: .7rem 1rem;
            font-size: .83rem;
            margin-bottom: 1rem;
            border: 1px solid;
            line-height: 1.55;
        }
        .alert-custom.danger { background: rgba(239,68,68,.12); border-color: rgba(239,68,68,.25); color: #fca5a5; }
        .alert-custom.success { background: rgba(34,197,94,.1); border-color: rgba(34,197,94,.25); color: #86efac; }
        .alert-custom.info { background: rgba(56,130,250,.1); border-color: rgba(56,130,250,.25); color: #93c5fd; }
        .footer-links { text-align: center; margin-top: 1.5rem; }
        .footer-links a { color: rgba(255,255,255,0.58); font-size: .8rem; text-decoration: none; transition: color .15s; }
        .footer-links a:hover { color: rgba(255,255,255,0.7); }
        .footer-links span { color: rgba(255,255,255,0.15); margin: 0 .5rem; }
        .btn-google {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .6rem;
            width: 100%;
            background: rgba(255,255,255,0.06);
            border: 1.5px solid rgba(255,255,255,0.14);
            border-radius: 10px;
            padding: .65rem 1rem;
            color: rgba(255,255,255,0.8);
            font-size: .9rem;
            font-weight: 500;
            text-decoration: none;
            transition: background .15s, border-color .15s, color .15s;
            cursor: pointer;
        }
        .btn-google:hover {
            background: rgba(255,255,255,0.1);
            border-color: rgba(255,255,255,0.22);
            color: #fff;
        }
        .btn-google svg { flex-shrink: 0; }
        .secondary-link-card {
            display: block;
            text-align: center;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 10px;
            padding: .7rem;
            color: rgba(255,255,255,0.82);
            text-decoration: none;
            font-size: .88rem;
            font-weight: 500;
            transition: background .15s, border-color .15s, color .15s;
        }
        .secondary-link-card:hover {
            background: rgba(255,255,255,0.1);
            border-color: rgba(255,255,255,0.2);
            color: #fff;
        }
        a:focus-visible,
        button:focus-visible {
            outline: 2px solid rgba(126,184,255,0.55);
            outline-offset: 3px;
        }
        @media (max-width: 575.98px), (max-height: 760px) {
            body {
                padding: 1rem;
            }
            .login-wrapper {
                min-height: calc(100vh - 2rem);
                min-height: calc(100dvh - 2rem);
                justify-content: flex-start;
            }
            .footer-links {
                margin-top: 1rem;
            }
        }
    </style>
</head>
<body>
<div class="login-wrapper">
    <div class="login-card">

        <div class="text-center mb-4">
            <a href="/" class="brand-logo">
                <img src="/img/site/ananth-inverted0logo.svg" alt="Ananth Decodes Logistics" onerror="this.style.display='none';this.nextElementSibling.style.display='block'">
                <span style="display:none;color:#fff;font-weight:700;font-size:1.1rem;">Ananth Decodes Logistics</span>
            </a>
            <span class="brand-badge">The Expert Desk</span>
        </div>

        <div class="login-title">Welcome back</div>
        <div class="login-sub">Sign in to access your Expert Desk dashboard</div>

        @if(session('success'))
            <div class="alert-custom success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert-custom danger">{{ session('error') }}</div>
        @endif
        @if(session('status'))
            <div class="alert-custom info">{{ session('status') }}</div>
        @endif
        @if($errors->any())
            @foreach($errors->all() as $e)
                <div class="alert-custom danger">{{ $e }}</div>
            @endforeach
        @endif

        <form method="POST" action="{{ route('contributor.login.submit') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label" for="email">Email</label>
                <input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email') }}" placeholder="you@example.com" autocomplete="email" required autofocus>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <label class="form-label mb-0" for="password">Password</label>
                    <a href="{{ route('password.request') }}" class="forgot-link">Forgot password?</a>
                </div>
                <div class="password-field">
                    <input id="password" type="password" name="password" class="form-control" placeholder="Enter your password" autocomplete="current-password" required>
                    <button type="button" class="password-toggle" data-password-toggle data-target="password" aria-controls="password" aria-pressed="false">Show</button>
                </div>
            </div>

            <div class="mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label" for="remember">Keep me signed in</label>
                </div>
            </div>

            <button type="submit" class="btn-login">Sign In</button>
        </form>

        <div class="divider"><span>or</span></div>

        <a href="{{ route('contributor.google.redirect') }}" class="btn-google">
            <svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                <path d="M17.64 9.2c0-.637-.057-1.251-.164-1.84H9v3.481h4.844a4.14 4.14 0 0 1-1.796 2.716v2.259h2.908c1.702-1.567 2.684-3.875 2.684-6.615z" fill="#4285F4"/>
                <path d="M9 18c2.43 0 4.467-.806 5.956-2.184l-2.908-2.259c-.806.54-1.837.86-3.048.86-2.344 0-4.328-1.584-5.036-3.711H.957v2.332A8.997 8.997 0 0 0 9 18z" fill="#34A853"/>
                <path d="M3.964 10.706A5.41 5.41 0 0 1 3.682 9c0-.593.102-1.17.282-1.706V4.962H.957A8.996 8.996 0 0 0 0 9c0 1.452.348 2.827.957 4.038l3.007-2.332z" fill="#FBBC05"/>
                <path d="M9 3.58c1.321 0 2.508.454 3.44 1.345l2.582-2.58C13.463.891 11.426 0 9 0A8.997 8.997 0 0 0 .957 4.962L3.964 7.294C4.672 5.163 6.656 3.58 9 3.58z" fill="#EA4335"/>
            </svg>
            Sign in with Google
        </a>

        <div class="divider"><span>New here?</span></div>

        <a href="{{ route('contributor.register') }}" class="secondary-link-card">
            Apply to The Expert Desk 

            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"/>
</svg>
        </a>

    </div>

    <div class="footer-links">
        <a href="/">
            
<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
</svg>

        Back to site</a>
        <span>&middot;</span>
        <a href="/privacy-policy/">Privacy Policy</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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
