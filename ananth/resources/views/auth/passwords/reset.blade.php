<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set Password - Ananth Decodes Logistics</title>
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

        body::before {
            content: '';
            position: fixed;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(56, 130, 250, 0.18) 0%, transparent 70%);
            top: -150px;
            right: -150px;
            pointer-events: none;
        }

        body::after {
            content: '';
            position: fixed;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(224, 123, 57, 0.12) 0%, transparent 70%);
            bottom: -100px;
            left: -100px;
            pointer-events: none;
        }

        .auth-wrapper {
            width: 100%;
            max-width: 440px;
            position: relative;
            z-index: 1;
        }

        .auth-card {
            background: rgba(255, 255, 255, 0.04);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: 0 24px 64px rgba(0, 0, 0, 0.4);
        }

        .brand-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.75rem;
            text-decoration: none;
            gap: 0.75rem;
        }

        .brand-logo img {
            height: 32px;
            width: auto;
            filter: brightness(0) invert(1);
        }

        .brand-badge {
            background: rgba(56, 130, 250, 0.2);
            border: 1px solid rgba(56, 130, 250, 0.35);
            color: #7eb8ff;
            font-size: 0.7rem;
            font-weight: 600;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            padding: 0.25rem 0.65rem;
            border-radius: 20px;
            display: block;
            text-align: center;
            margin-top: 0.5rem;
        }

        .auth-title {
            color: #fff;
            font-size: 1.35rem;
            font-weight: 700;
            margin-bottom: 0.35rem;
            text-align: center;
        }

        .auth-sub {
            color: rgba(255, 255, 255, 0.45);
            font-size: 0.83rem;
            text-align: center;
            margin-bottom: 1.75rem;
        }

        .form-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.65);
            margin-bottom: 0.4rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.06);
            border: 1.5px solid rgba(255, 255, 255, 0.12);
            border-radius: 10px;
            color: #fff;
            padding: 0.65rem 1rem;
            font-size: 0.9rem;
            transition: border-color 0.15s, background 0.15s, box-shadow 0.15s;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.28);
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.09);
            border-color: rgba(56, 130, 250, 0.6);
            box-shadow: 0 0 0 3px rgba(56, 130, 250, 0.15);
            color: #fff;
            outline: none;
        }

        .form-control[readonly] {
            background: rgba(255, 255, 255, 0.08);
            color: rgba(255, 255, 255, 0.86);
        }

        .form-control.is-invalid {
            border-color: rgba(239, 68, 68, 0.6);
        }

        .invalid-feedback {
            font-size: 0.78rem;
            color: #fca5a5;
        }

        .auth-btn {
            background: #3882fa;
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 0.75rem;
            font-weight: 600;
            font-size: 0.95rem;
            width: 100%;
            cursor: pointer;
            transition: background 0.2s, transform 0.1s, box-shadow 0.2s;
            box-shadow: 0 4px 20px rgba(56, 130, 250, 0.35);
        }

        .auth-btn:hover {
            background: #2563d4;
            box-shadow: 0 6px 24px rgba(56, 130, 250, 0.45);
            color: #fff;
        }

        .auth-btn:active {
            transform: scale(0.99);
        }

        .alert-custom {
            border-radius: 10px;
            padding: 0.75rem 1rem;
            font-size: 0.83rem;
            margin-bottom: 1rem;
            border: 1px solid;
        }

        .alert-custom.danger {
            background: rgba(239, 68, 68, 0.12);
            border-color: rgba(239, 68, 68, 0.25);
            color: #fca5a5;
        }

        .footer-links {
            text-align: center;
            margin-top: 1.5rem;
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.38);
            font-size: 0.8rem;
            text-decoration: none;
            transition: color 0.15s;
        }

        .footer-links a:hover {
            color: rgba(255, 255, 255, 0.7);
        }

        .footer-links span {
            color: rgba(255, 255, 255, 0.15);
            margin: 0 0.5rem;
        }
    </style>
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-card">
            <div class="text-center mb-4">
                <a href="/" class="brand-logo">
                    <img src="/img/site/ananth-inverted0logo.svg" alt="Ananth Decodes Logistics" onerror="this.style.display='none';this.nextElementSibling.style.display='block'">
                    <span style="display:none;color:#fff;font-weight:700;font-size:1.1rem;">Ananth Decodes Logistics</span>
                </a>
                <span class="brand-badge">Contributor Portal</span>
            </div>

            <div class="auth-title">Set your password</div>
            <div class="auth-sub">Create your password to access your contributor dashboard and start posting.</div>

            @if($errors->any())
                <div class="alert-custom danger">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email', request('email')) }}" required placeholder="you@example.com" readonly>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">New Password</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                           required placeholder="Create a secure password" autocomplete="new-password">
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-4">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control"
                           required placeholder="Repeat your password" autocomplete="new-password">
                </div>

                <button type="submit" class="auth-btn">Set Password & Sign In</button>
            </form>
        </div>

        <div class="footer-links">
            <a href="{{ route('contributor.login') }}">Back to login</a>
            <span>.</span>
            <a href="/">Back to site</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
