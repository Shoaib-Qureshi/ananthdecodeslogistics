@extends('layouts.dashboard')
@section('title', 'My Profile')
@section('page-title', 'My Profile')

@section('styles')
<style>
    .profile-card,
    .profile-sidebar-card {
        background: #fff;
        border-radius: 12px;
        border: 1px solid #e8edf5;
        padding: 1.75rem;
    }

    .profile-card {
        margin-bottom: 1.25rem;
    }

    .profile-label {
        font-weight: 600;
        font-size: .855rem;
        color: #334155;
        margin-bottom: .4rem;
    }

    .profile-input,
    .profile-textarea {
        border-radius: 8px;
        border: 1.5px solid #e2e8f0;
        padding: .7rem .9rem;
        font-size: .9rem;
        width: 100%;
        transition: border-color .15s, box-shadow .15s;
    }

    .profile-textarea {
        min-height: 150px;
        resize: vertical;
    }

    .profile-input:focus,
    .profile-textarea:focus {
        border-color: #3882fa;
        box-shadow: 0 0 0 3px rgba(56,130,250,.1);
        outline: none;
    }

    .profile-avatar {
        width: 88px;
        height: 88px;
        border-radius: 50%;
        object-fit: cover;
        border: 1px solid #dbe4ef;
    }

    .profile-badge {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        padding: .35rem .7rem;
        border-radius: 999px;
        font-size: .75rem;
        font-weight: 700;
        letter-spacing: .03em;
    }
</style>
@endsection

@section('content')
<div class="row g-4">
    <div class="col-lg-8">
        <div class="profile-card">
            <div class="d-flex align-items-center gap-3 flex-wrap mb-4">
                <img
                    src="{{ $user->profile_pic ? asset('img/site/' . $user->profile_pic) : asset('img/blank-picture.webp') }}"
                    alt="{{ $user->name }}"
                    class="profile-avatar"
                >
                <div>
                    <h4 style="margin-bottom:.35rem;font-weight:700;color:#0f172a;">{{ $user->name }}</h4>
                    <p style="margin-bottom:.45rem;color:#64748b;">{{ $user->email }}</p>
                    <div class="d-flex flex-wrap gap-2">
                        <span class="profile-badge" style="background:#eff6ff;color:#1d4ed8;">{{ $user->contributorPlanLabel() }}</span>
                        <span class="profile-badge" style="background:#f0fdf4;color:#166534;">{{ ucfirst($user->status ?? 'approved') }}</span>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('dashboard.profile.update') }}" enctype="multipart/form-data">
                @csrf

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="profile-label" for="name">Name</label>
                        <input id="name" name="name" type="text" class="profile-input" value="{{ old('name', $user->name) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="profile-label" for="email">Email</label>
                        <input id="email" name="email" type="email" class="profile-input" value="{{ old('email', $user->email) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="profile-label" for="designation">Designation</label>
                        <input id="designation" name="designation" type="text" class="profile-input" value="{{ old('designation', $user->designation) }}" placeholder="Your role or title">
                    </div>

                    <div class="col-md-6">
                        <label class="profile-label" for="profile_pic">Profile Picture</label>
                        <input id="profile_pic" name="profile_pic" type="file" class="profile-input" accept="image/jpeg,image/png,image/webp">
                        <div class="form-text" style="font-size:.77rem;">JPEG, PNG, or WEBP. Max 3MB.</div>
                    </div>

                    <div class="col-md-6">
                        <label class="profile-label" for="linkedin">LinkedIn URL</label>
                        <input id="linkedin" name="linkedin" type="url" class="profile-input" value="{{ old('linkedin', $user->linkedin) }}" placeholder="https://www.linkedin.com/in/...">
                    </div>

                    <div class="col-md-6">
                        <label class="profile-label" for="insta">Instagram URL</label>
                        <input id="insta" name="insta" type="url" class="profile-input" value="{{ old('insta', $user->insta) }}" placeholder="https://www.instagram.com/...">
                    </div>

                    <div class="col-md-6">
                        <label class="profile-label" for="twitter">Twitter URL</label>
                        <input id="twitter" name="twitter" type="url" class="profile-input" value="{{ old('twitter', $user->twitter) }}" placeholder="https://x.com/...">
                    </div>

                    <div class="col-12">
                        <label class="profile-label" for="intro">Short Bio</label>
                        <textarea id="intro" name="intro" class="profile-textarea" placeholder="Introduce yourself to readers...">{{ old('intro', $user->intro) }}</textarea>
                    </div>

                    <div class="col-md-4">
                        <label class="profile-label" for="current_password">Current Password</label>
                        <input id="current_password" name="current_password" type="password" class="profile-input" placeholder="Required to change password">
                    </div>

                    <div class="col-md-4">
                        <label class="profile-label" for="password">New Password</label>
                        <input id="password" name="password" type="password" class="profile-input" placeholder="Leave blank to keep it">
                    </div>

                    <div class="col-md-4">
                        <label class="profile-label" for="password_confirmation">Confirm Password</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" class="profile-input" placeholder="Confirm new password">
                    </div>
                </div>

                <div class="d-flex gap-3 mt-4">
                    <button type="submit" class="btn-write px-4 py-2" style="font-size:.9rem;">
                        <i class="bi bi-check2-circle"></i> Save Profile
                    </button>
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary" style="border-radius:8px;font-size:.9rem;">Back to Dashboard</a>
                </div>
            </form>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="profile-sidebar-card">
            <p style="font-weight:700;color:#334155;margin-bottom:.65rem;">
                <i class="bi bi-info-circle me-1" style="color:#3882fa;"></i> Profile Tips
            </p>
            <ul style="padding-left:1.1rem;margin:0;color:#475569;font-size:.84rem;line-height:1.7;">
                <li>Keep your name and designation up to date so your published posts look professional.</li>
                <li>Add a short bio to help readers understand your logistics background and perspective.</li>
                <li>If you change your password, enter your current password first for confirmation.</li>
            </ul>
        </div>
    </div>
</div>
@endsection
