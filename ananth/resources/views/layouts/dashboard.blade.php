<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Contributor Dashboard') — ADL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        :root {
            --sidebar-w: 260px;
            --navy: #0f1e2e;
            --navy-mid: #162333;
            --navy-light: #1e3040;
            --brand-blue: #3882fa;
            --brand-orange: #e07b39;
            --sidebar-text: rgba(255,255,255,0.62);
            --sidebar-text-hover: #fff;
            --topbar-h: 60px;
            --radius: 12px;
        }

        *, *::before, *::after { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: 'Inter', 'Helvetica Neue', sans-serif;
            background: #f0f4f8;
            color: #1e293b;
            font-size: .9rem;
        }

        /* ─── Sidebar ─── */
        .sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            width: var(--sidebar-w);
            background: var(--navy);
            z-index: 1040;
            display: flex;
            flex-direction: column;
            transition: transform .25s ease;
            overflow-y: auto;
        }

        .sidebar-brand {
            padding: 1.4rem 1.5rem 1.2rem;
            border-bottom: 1px solid rgba(255,255,255,0.06);
            flex-shrink: 0;
        }
        .sidebar-brand a { text-decoration: none; display: flex; align-items: center; gap: .75rem; }
        .sidebar-brand img {
            height: 28px;
            width: auto;
            filter: brightness(0) invert(1);
        }
        .sidebar-brand .brand-fallback {
            color: #fff;
            font-weight: 700;
            font-size: 1rem;
            line-height: 1.2;
        }
        .sidebar-brand .brand-badge {
            margin-top: .5rem;
            display: inline-block;
            background: rgba(56,130,250,0.18);
            border: 1px solid rgba(56,130,250,0.3);
            color: #7eb8ff;
            font-size: .65rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .08em;
            padding: .2rem .6rem;
            border-radius: 20px;
        }

        .sidebar-nav {
            flex: 1;
            padding: 1rem 0 .5rem;
        }
        .nav-section-label {
            color: rgba(255,255,255,0.28);
            font-size: .65rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .1em;
            padding: .75rem 1.5rem .35rem;
        }
        .nav-item a {
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: .6rem 1.5rem;
            color: var(--sidebar-text);
            text-decoration: none;
            font-size: .855rem;
            font-weight: 500;
            border-radius: 0;
            transition: background .15s, color .15s;
            position: relative;
        }
        .nav-item a i { font-size: 1rem; min-width: 18px; flex-shrink: 0; }
        .nav-item a:hover {
            background: rgba(255,255,255,0.06);
            color: var(--sidebar-text-hover);
        }
        .nav-item a.active {
            background: rgba(56,130,250,0.14);
            color: #7eb8ff;
        }
        .nav-item a.active::before {
            content: '';
            position: absolute;
            left: 0; top: 0; bottom: 0;
            width: 3px;
            background: var(--brand-blue);
            border-radius: 0 3px 3px 0;
        }

        .sidebar-footer {
            padding: 1rem 1.5rem 1.25rem;
            border-top: 1px solid rgba(255,255,255,0.06);
            flex-shrink: 0;
        }
        .sidebar-user {
            display: flex;
            align-items: center;
            gap: .75rem;
            margin-bottom: .85rem;
        }
        .user-avatar {
            width: 34px; height: 34px;
            border-radius: 50%;
            background: var(--brand-blue);
            color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: .85rem;
            flex-shrink: 0;
        }
        .sidebar-user-info .name { color: #fff; font-size: .83rem; font-weight: 600; line-height: 1.2; }
        .sidebar-user-info .role { color: rgba(255,255,255,0.35); font-size: .7rem; }
        .btn-signout {
            background: none; border: none; padding: 0;
            color: rgba(255,255,255,0.35);
            font-size: .8rem; cursor: pointer;
            display: flex; align-items: center; gap: .4rem;
            transition: color .15s;
        }
        .btn-signout:hover { color: rgba(255,255,255,0.7); }

        /* ─── Main ─── */
        .main-wrapper {
            margin-left: var(--sidebar-w);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ─── Topbar ─── */
        .topbar {
            height: var(--topbar-h);
            background: #fff;
            border-bottom: 1px solid #e8edf5;
            padding: 0 1.75rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
            flex-shrink: 0;
        }
        .topbar-left { display: flex; align-items: center; gap: .75rem; }
        .page-title { font-size: 1rem; font-weight: 600; color: #181a3f; margin: 0; }
        .topbar-right { display: flex; align-items: center; gap: 1rem; }
        .btn-new-post {
            background: var(--brand-blue);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: .4rem 1rem;
            font-size: .82rem;
            font-weight: 600;
            text-decoration: none;
            display: flex; align-items: center; gap: .35rem;
            transition: background .2s, box-shadow .2s;
            box-shadow: 0 2px 8px rgba(56,130,250,0.25);
        }
        .btn-new-post:hover {
            background: #2563d4;
            color: #fff;
            box-shadow: 0 4px 12px rgba(56,130,250,0.35);
        }
        .topbar-avatar {
            width: 34px; height: 34px;
            border-radius: 50%;
            background: #e07b39;
            color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: .85rem;
        }

        /* ─── Content ─── */
        .main-content { padding: 1.75rem; flex: 1; }

        /* ─── Stat cards ─── */
        .stat-card {
            background: #fff;
            border-radius: var(--radius);
            border: 1px solid #e8edf5;
            padding: 1.25rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: box-shadow .2s, transform .2s;
            cursor: default;
        }
        .stat-card:hover {
            box-shadow: 0 6px 24px rgba(0,0,0,0.07);
            transform: translateY(-1px);
        }
        .stat-icon {
            width: 46px; height: 46px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.2rem;
            flex-shrink: 0;
        }
        .stat-label { font-size: .72rem; color: #64748b; text-transform: uppercase; letter-spacing: .06em; font-weight: 600; }
        .stat-value { font-size: 1.65rem; font-weight: 700; color: #181a3f; line-height: 1; margin-top: .2rem; }

        /* ─── Card table ─── */
        .card-table { background: #fff; border-radius: var(--radius); border: 1px solid #e8edf5; overflow: hidden; }
        .card-table .card-header {
            background: #fff;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #e8edf5;
            font-weight: 600;
            color: #181a3f;
            font-size: .875rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        /* ─── Status badges ─── */
        .badge-pending   { background: #fef3c7; color: #92400e; }
        .badge-approved  { background: #d1fae5; color: #065f46; }
        .badge-published { background: #dbeafe; color: #1e40af; }
        .badge-rejected  { background: #fee2e2; color: #991b1b; }
        .status-badge {
            padding: .22rem .65rem;
            border-radius: 20px;
            font-size: .7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .05em;
        }

        /* ─── CTA btn ─── */
        .btn-write {
            background: var(--brand-blue);
            color: #fff;
            border: none;
            padding: .45rem 1.1rem;
            border-radius: 8px;
            font-size: .83rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: .35rem;
            transition: background .2s, box-shadow .2s;
        }
        .btn-write:hover { background: #2563d4; color: #fff; }

        /* ─── Flash alerts ─── */
        .alert-flash {
            border-radius: 10px;
            border-left: 4px solid;
            padding: .8rem 1.1rem;
            font-size: .875rem;
            display: flex;
            align-items: center;
            gap: .6rem;
        }

        /* ─── Mobile sidebar overlay ─── */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 1039;
        }

        @media(max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .sidebar-overlay.show { display: block; }
            .main-wrapper { margin-left: 0; }
            .main-content { padding: 1.25rem; }
            .topbar { padding: 0 1rem; }
        }
    </style>
    @yield('styles')
</head>
<body>

{{-- Mobile overlay --}}
<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

{{-- Sidebar --}}
<aside class="sidebar" id="dashSidebar">
    <div class="sidebar-brand">
        <a href="/">
            <img src="/img/site/ananth-inverted0logo.svg" alt="ADL"
                 onerror="this.style.display='none';this.nextElementSibling.style.display='block'">
            <span class="brand-fallback" style="display:none;">Ananth Decodes</span>
        </a>
        <span class="brand-badge">Contributor Portal</span>
    </div>

    <nav class="sidebar-nav">
        <p class="nav-section-label">Navigation</p>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="{{ request()->is('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-house-door"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('dashboard.posts') }}" class="{{ request()->is('dashboard/posts') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-text"></i> My Posts
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('dashboard.posts.create') }}" class="{{ request()->is('dashboard/posts/create') ? 'active' : '' }}">
                    <i class="bi bi-plus-circle"></i> New Post
                </a>
            </li>
        </ul>

        <p class="nav-section-label" style="margin-top:.75rem;">Quick Links</p>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{ route('contributors.index') }}" target="_blank">
                    <i class="bi bi-globe"></i> Contributor Posts
                </a>
            </li>
            <li class="nav-item">
                <a href="/" target="_blank">
                    <i class="bi bi-box-arrow-up-right"></i> Visit Site
                </a>
            </li>
        </ul>
    </nav>

    <div class="sidebar-footer">
        <div class="sidebar-user">
            <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
            <div class="sidebar-user-info">
                <div class="name">{{ Auth::user()->name }}</div>
                <div class="role">Guest Contributor</div>
            </div>
        </div>
        <form method="POST" action="{{ route('contributor.logout') }}">
            @csrf
            <button type="submit" class="btn-signout">
                <i class="bi bi-box-arrow-left"></i> Sign out
            </button>
        </form>
    </div>
</aside>

{{-- Main wrapper --}}
<div class="main-wrapper">

    {{-- Topbar --}}
    <div class="topbar">
        <div class="topbar-left">
            <button class="btn btn-sm d-md-none border-0 p-1" onclick="openSidebar()" aria-label="Open menu">
                <i class="bi bi-list fs-5 text-secondary"></i>
            </button>
            <span class="page-title">@yield('page-title', 'Dashboard')</span>
        </div>
        <div class="topbar-right">
            @if(!request()->is('dashboard/posts/create'))
            <a href="{{ route('dashboard.posts.create') }}" class="btn-new-post d-none d-sm-flex">
                <i class="bi bi-plus-lg"></i> New Post
            </a>
            @endif
            <div class="topbar-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
        </div>
    </div>

    {{-- Page content --}}
    <div class="main-content">

        @if(session('success'))
            <div class="alert-flash mb-4" style="background:#f0fdf4;border-color:#22c55e;color:#166534;">
                <i class="bi bi-check-circle-fill"></i>{{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert-flash mb-4" style="background:#fef2f2;border-color:#ef4444;color:#991b1b;">
                <i class="bi bi-exclamation-circle-fill"></i>{{ session('error') }}
            </div>
        @endif
        @if($errors->any())
            <div class="alert-flash mb-4" style="background:#fef2f2;border-color:#ef4444;color:#991b1b;">
                <i class="bi bi-exclamation-circle-fill"></i>
                <ul class="mb-0 ps-2">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif

        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function openSidebar() {
        document.getElementById('dashSidebar').classList.add('open');
        document.getElementById('sidebarOverlay').classList.add('show');
    }
    function closeSidebar() {
        document.getElementById('dashSidebar').classList.remove('open');
        document.getElementById('sidebarOverlay').classList.remove('show');
    }
</script>
@yield('scripts')
</body>
</html>
