<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set Password — Ananth Decodes Logistics</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { min-height:100vh;background:linear-gradient(135deg,#0f2137 0%,#1a3c5e 60%,#e07b39 200%);display:flex;align-items:center;justify-content:center;font-family:'Inter',sans-serif; }
        .card { border-radius:18px;padding:2.5rem;width:100%;max-width:440px;box-shadow:0 20px 60px rgba(0,0,0,.25);border:none; }
        .form-control { border-radius:8px;padding:.65rem 1rem;border:1.5px solid #e2e8f0; }
        .form-control:focus { border-color:#e07b39;box-shadow:0 0 0 3px rgba(224,123,57,.15); }
        .btn-primary { background:#e07b39;border:none;border-radius:8px;padding:.7rem;font-weight:600; }
        .btn-primary:hover { background:#c9692a; }
    </style>
</head>
<body>
    <div class="card">
        <div class="text-center mb-4">
            <a href="/" style="font-weight:700;color:#1a3c5e;text-decoration:none;font-size:1.2rem;">Ananth <span style="color:#e07b39;">Decodes</span> Logistics</a>
        </div>

        <h5 class="fw-bold mb-1" style="color:#1a3c5e;">Set your password</h5>
        <p class="text-muted mb-4" style="font-size:.875rem;">Welcome! Set a password to access your contributor dashboard.</p>

        @if($errors->any())
            <div class="alert alert-danger py-2 px-3 rounded-3 mb-3" style="font-size:.875rem;">
                <ul class="mb-0 ps-3">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="mb-3">
                <label class="form-label fw-semibold" style="font-size:.875rem;">Email Address</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email', request('email')) }}" required placeholder="you@example.com">
                @error('email')<div class="invalid-feedback" style="font-size:.8rem;">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold" style="font-size:.875rem;">New Password</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                       required placeholder="Min. 8 characters" autocomplete="new-password">
                @error('password')<div class="invalid-feedback" style="font-size:.8rem;">{{ $message }}</div>@enderror
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold" style="font-size:.875rem;">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control" required placeholder="Repeat password">
            </div>

            <button type="submit" class="btn btn-primary w-100">Set Password & Sign In</button>
        </form>
    </div>
</body>
</html>
