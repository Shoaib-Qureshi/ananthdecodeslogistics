<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set Your Password - The Expert Desk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script
  src="https://unpkg.com/@lottiefiles/dotlottie-wc@0.9.10/dist/dotlottie-wc.js"
  type="module"
></script>
  
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
            background: radial-gradient(circle, rgba(34,197,94,0.1) 0%, transparent 70%);
            bottom: -100px; left: -100px;
            pointer-events: none;
        }
        .card-wrapper {
            width: 100%;
            max-width: 440px;
            margin: 0 auto;
            min-height: calc(100vh - 3rem);
            min-height: calc(100dvh - 3rem);
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            z-index: 1;
        }
        .card-box {
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
            background: rgba(34,197,94,0.15);
            border: 1px solid rgba(34,197,94,0.3);
            color: #86efac;
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
        .lottie-wrap {
            display: flex;
            justify-content: center;
            margin: 0 auto 0.5rem;
        }
        lottie-player {
            display: block;
        }
        .page-title {
            color: #fff;
            font-size: 1.35rem;
            font-weight: 700;
            margin-bottom: .35rem;
            text-align: center;
        }
        .page-sub {
            color: rgba(255,255,255,0.62);
            font-size: .83rem;
            text-align: center;
            margin-bottom: 1.75rem;
            line-height: 1.5;
        }
        @media (max-width: 575.98px), (max-height: 760px) {
            body {
                padding: 1rem;
            }
            .card-wrapper {
                min-height: calc(100vh - 2rem);
                min-height: calc(100dvh - 2rem);
                justify-content: flex-start;
            }
        }
        .plan-pill {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            background: rgba(56,130,250,0.12);
            border: 1px solid rgba(56,130,250,0.25);
            color: #93c5fd;
            font-size: .75rem;
            font-weight: 600;
            padding: .3rem .75rem;
            border-radius: 20px;
            margin-bottom: 1.5rem;
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
        .password-field { position: relative; }
        .password-field .form-control { padding-right: 4.75rem; }
        .password-toggle {
            position: absolute;
            top: 50%; right: .7rem;
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
        .hint-text {
            font-size: .75rem;
            color: rgba(255,255,255,0.35);
            margin-top: .3rem;
        }
        .btn-submit {
            background: #3882fa;
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: .75rem;
            font-weight: 600;
            font-size: .95rem;
            width: 100%;
            cursor: pointer;
            transition: background .2s, box-shadow .2s;
            box-shadow: 0 4px 20px rgba(56,130,250,0.35);
        }
        .btn-submit:hover {
            background: #2563d4;
            box-shadow: 0 6px 24px rgba(56,130,250,0.45);
        }
        .alert-custom {
            border-radius: 10px;
            padding: .7rem 1rem;
            font-size: .83rem;
            margin-bottom: 1rem;
            border: 1px solid;
        }
        .alert-custom.danger { background: rgba(239,68,68,.12); border-color: rgba(239,68,68,.25); color: #fca5a5; }
        .footer-links { text-align: center; margin-top: 1.5rem; }
        .footer-links a { color: rgba(255,255,255,0.38); font-size: .8rem; text-decoration: none; transition: color .15s; }
        .footer-links a:hover { color: rgba(255,255,255,0.7); }
        .footer-links span { color: rgba(255,255,255,0.15); margin: 0 .5rem; }
    </style>
</head>
<body>
<div class="card-wrapper">
    <div class="card-box">

        <div class="text-center mb-4">
            <a href="/" class="brand-logo">
                <img src="/img/site/ananth-inverted0logo.svg" alt="Ananth Decodes Logistics"
                     onerror="this.style.display='none';this.nextElementSibling.style.display='block'">
                <span style="display:none;color:#fff;font-weight:700;font-size:1.1rem;">Ananth Decodes Logistics</span>
            </a>
            <span class="brand-badge">Payment Successful</span>
        </div>

        <div class="lottie-wrap">
           <dotlottie-wc
  src="https://lottie.host/89aa1e72-29f7-4565-bd4d-3ed33781d74b/8MIn2XbVia.lottie"
  style="width: 70px;height: 70px"
  autoplay
  loop
></dotlottie-wc>
        </div>

        <div class="page-title">Almost there!</div>
        <div class="page-sub">
            Welcome, <strong style="color:rgba(255,255,255,0.75); text-transform: capitalize">{{ $user->name }}</strong>.<br>
            Create a password to access your Expert Desk dashboard.
        </div>

        @if($errors->any())
            @foreach($errors->all() as $e)
                <div class="alert-custom danger">{{ $e }}</div>
            @endforeach
        @endif

        <form method="POST" action="{{ route('contributor.set-password.submit') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label" for="password">New Password</label>
                <div class="password-field">
                    <input id="password" type="password" name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="At least 8 characters" autocomplete="new-password" required autofocus>
                    <button type="button" class="password-toggle" data-target="password">Show</button>
                </div>
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <div class="hint-text">Minimum 8 characters</div>
            </div>

            <div class="mb-4">
                <label class="form-label" for="password_confirmation">Confirm Password</label>
                <div class="password-field">
                    <input id="password_confirmation" type="password" name="password_confirmation"
                           class="form-control"
                           placeholder="Re-enter your password" autocomplete="new-password" required>
                    <button type="button" class="password-toggle" data-target="password_confirmation">Show</button>
                </div>
            </div>

            <button type="submit" class="btn-submit">Set Password &amp; Go to Dashboard</button>
        </form>

    </div>

    <!-- <div class="footer-links">
        <a href="/">&larr; Back to site</a>
        <span>&middot;</span>
        <a href="{{ route('contributor.login') }}">Already have a password? Log in</a>
    </div> -->
</div>

<script src="https://unpkg.com/@lottiefiles/lottie-player@2.0.8/dist/lottie-player.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.querySelectorAll('[data-target]').forEach(function (button) {
        var input = document.getElementById(button.getAttribute('data-target'));
        if (!input) return;
        button.addEventListener('click', function () {
            var showing = input.type === 'text';
            input.type = showing ? 'password' : 'text';
            button.textContent = showing ? 'Show' : 'Hide';
        });
    });
</script>
</body>
</html>
