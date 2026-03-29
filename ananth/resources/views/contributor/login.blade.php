<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contributor Login — Ananth Decodes Logistics</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; }
        body {
            min-height: 100vh;
            margin: 0;
            font-family: "Inter", "Helvetica Neue", sans-serif;
            background: #0f1e2e;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
        }
        /* Subtle background orbs */
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
            position: relative;
            z-index: 1;
        }
        .login-card {
            background: rgba(255,255,255,0.04);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 20px;
            padding: 2.5rem;
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
        }
        .login-title {
            color: #fff;
            font-size: 1.35rem;
            font-weight: 700;
            margin-bottom: .35rem;
            text-align: center;
        }
        .login-sub {
            color: rgba(255,255,255,0.45);
            font-size: .83rem;
            text-align: center;
            margin-bottom: 1.75rem;
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
        }
        .alert-custom.danger { background: rgba(239,68,68,.12); border-color: rgba(239,68,68,.25); color: #fca5a5; }
        .alert-custom.success { background: rgba(34,197,94,.1); border-color: rgba(34,197,94,.25); color: #86efac; }
        .alert-custom.info { background: rgba(56,130,250,.1); border-color: rgba(56,130,250,.25); color: #93c5fd; }
        .footer-links { text-align: center; margin-top: 1.5rem; }
        .footer-links a { color: rgba(255,255,255,0.38); font-size: .8rem; text-decoration: none; transition: color .15s; }
        .footer-links a:hover { color: rgba(255,255,255,0.7); }
        .footer-links span { color: rgba(255,255,255,0.15); margin: 0 .5rem; }
    </style>
</head>
<body>
<div class="login-wrapper">
    <div class="login-card">

        {{-- Brand --}}
        <div class="text-center mb-4">
            <a href="/" class="brand-logo">
                <img src="/img/site/ananth-inverted0logo.svg" alt="Ananth Decodes Logistics" onerror="this.style.display='none';this.nextElementSibling.style.display='block'">
                <span style="display:none;color:#fff;font-weight:700;font-size:1.1rem;">Ananth Decodes Logistics</span>
            </a>
            <span class="brand-badge">Contributor Portal</span>
        </div>

        <div class="login-title">Welcome back</div>
        <div class="login-sub">Sign in to access your contributor dashboard</div>

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
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email') }}" placeholder="you@example.com" required autofocus>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <label class="form-label mb-0">Password</label>
                    <a href="{{ route('password.request') }}" class="forgot-link">Forgot password?</a>
                </div>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>

            <div class="mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label" for="remember">Keep me signed in</label>
                </div>
            </div>

            <button type="submit" class="btn-login">Sign In</button>
        </form>

        <div class="divider"><span>New here?</span></div>

        <a href="{{ route('contributor.register') }}"
           style="display:block;text-align:center;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.12);border-radius:10px;padding:.7rem;color:rgba(255,255,255,0.75);text-decoration:none;font-size:.88rem;font-weight:500;transition:background .15s;"
           onmouseover="this.style.background='rgba(255,255,255,0.1)'"
           onmouseout="this.style.background='rgba(255,255,255,0.06)'">
            Apply to become a contributor →
        </a>

    </div>

    <div class="footer-links">
        <a href="/">← Back to site</a>
        <span>·</span>
        <a href="/privacy-policy/">Privacy Policy</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
