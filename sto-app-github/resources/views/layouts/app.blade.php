<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <title>Stock Opname - Manajemen Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" integrity="sha384-ln4jE8fT3z1t8jhzYSuXw2ammrYdikO8ufxHa0X4d3XW3VukuvKln1uYy0Wuqy59" crossorigin="anonymous">
    <style>
            :root {
                --bg-100: #070b16;
                --bg-200: #0d1830;
                --bg-300: #111d3c;
                --surface: rgba(15, 23, 48, 0.94);
                --surface-strong: rgba(8, 12, 24, 0.99);
                --text: #f8fafc;
                --text-muted: #a5b4fc;
                --accent: #f5c443;
                --accent-soft: rgba(245, 196, 67, 0.18);
                --accent-soft-strong: rgba(245, 196, 67, 0.28);
                --border: rgba(255, 255, 255, 0.08);
                --shadow: 0 35px 100px rgba(4, 10, 25, 0.35);
                --shadow-soft: 0 20px 60px rgba(4, 10, 25, 0.22);
                --success: #4ade80;
                --danger: #fb7185;
                --info: #60a5fa;
            }
            body {
                min-height: 100vh;
                margin: 0;
                font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
                color: var(--text);
                background: radial-gradient(circle at top left, rgba(245,196,67,.16), transparent 16%),
                            radial-gradient(circle at bottom right, rgba(99,102,241,.18), transparent 20%),
                            linear-gradient(180deg, #050913 0%, #08122b 50%, #111d3c 100%);
            }
            body.light-theme {
                --bg-100: #f8fafc;
                --bg-200: #eef2ff;
                --bg-300: #e2e8f0;
                --surface: rgba(255, 255, 255, 0.96);
                --surface-strong: rgba(255, 255, 255, 0.98);
                --text: #0f172a;
                --text-muted: #475569;
                --accent: #2563eb;
                --accent-soft: rgba(37, 99, 235, 0.12);
                --accent-soft-strong: rgba(37, 99, 235, 0.18);
                --border: rgba(15, 23, 42, 0.08);
                --shadow: 0 35px 100px rgba(15, 23, 42, 0.12);
                --shadow-soft: 0 20px 60px rgba(15, 23, 42, 0.08);
                --success: #22c55e;
                --danger: #ef4444;
                --info: #3b82f6;
                background: linear-gradient(180deg, #f8fafc 0%, #eef2ff 45%, #e2e8f0 100%);
            }
            body.light-theme .sidebar {
                background: linear-gradient(180deg, #ffffff 0%, #f1f5ff 100%);
                color: var(--text);
                border-color: rgba(15, 23, 42, 0.08);
            }
            body.light-theme .sidebar .nav-link {
                color: var(--text);
                background: rgba(15, 23, 42, 0.04);
                border-color: rgba(15, 23, 42, 0.08);
            }
            body.light-theme .sidebar .nav-link:hover,
            body.light-theme .sidebar .nav-link.active {
                color: #0f172a;
                background: rgba(37, 99, 235, 0.16);
                border-color: rgba(37, 99, 235, 0.24);
            }
            body.light-theme .sidebar .nav-link .bi {
                color: var(--accent);
            }
            body.light-theme .topbar .search-box .form-control {
                border: 1px solid rgba(15, 23, 42, 0.12);
                background: rgba(255, 255, 255, 0.96);
                color: var(--text);
            }
            body.light-theme .topbar .search-box .form-control::placeholder {
                color: rgba(71, 85, 105, 0.65);
            }
            body.light-theme .topbar .profile-card {
                background: rgba(255, 255, 255, 0.92);
                border-color: rgba(15, 23, 42, 0.1);
                box-shadow: var(--shadow-soft);
            }
            body.light-theme .topbar .profile-card .user-meta .name {
                color: var(--text);
            }
            body.light-theme .topbar .profile-card .user-meta .role {
                color: var(--text-muted);
            }
            body.light-theme .card-custom {
                border: 1px solid rgba(15, 23, 42, 0.08);
                background: rgba(255, 255, 255, 0.95);
                box-shadow: var(--shadow-soft);
            }
            body.light-theme .card-highlight {
                background: rgba(255, 255, 255, 0.92);
                border-color: rgba(15, 23, 42, 0.08);
                box-shadow: 0 20px 40px rgba(15, 23, 42, 0.08);
            }
            body.light-theme .metric-card {
                background: rgba(255, 255, 255, 0.95);
                border-color: rgba(15, 23, 42, 0.08);
            }
            body.light-theme .table {
                color: var(--text);
                background: rgba(255, 255, 255, 0.92);
            }
            body.light-theme .table thead th {
                color: var(--text-muted);
                border-bottom-color: rgba(15, 23, 42, 0.12);
            }
            body.light-theme .table tbody tr:hover {
                background: rgba(15, 23, 42, 0.04);
            }
            body.light-theme .form-control,
            body.light-theme .form-select {
                background: rgba(255, 255, 255, 0.96);
                border: 1px solid rgba(15, 23, 42, 0.12);
                color: var(--text);
            }
            body.light-theme .form-control:focus,
            body.light-theme .form-select:focus {
                border-color: rgba(37, 99, 235, 0.4);
                box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.12);
                background: rgba(255, 255, 255, 0.98);
            }
            body.light-theme .btn-outline-light {
                color: var(--text);
                border-color: rgba(15, 23, 42, 0.16);
                background: rgba(15, 23, 42, 0.04);
            }
            body.light-theme .btn-outline-light:hover {
                background: rgba(15, 23, 42, 0.08);
            }
            body.light-theme .btn-outline-secondary {
                color: var(--text);
                border-color: rgba(15, 23, 42, 0.18);
                background: rgba(15, 23, 42, 0.04);
            }
            body.light-theme .btn-outline-secondary:hover,
            body.light-theme .btn-outline-secondary.active {
                background: rgba(37, 99, 235, 0.12);
                color: #0f172a;
                border-color: rgba(37, 99, 235, 0.24);
            }
            body.light-theme .modal-content {
                background: rgba(255, 255, 255, 0.98);
                color: var(--text);
            }
            body.light-theme .hero-panel {
                background: rgba(255, 255, 255, 0.85);
                border-color: rgba(15, 23, 42, 0.08);
                box-shadow: 0 30px 60px rgba(15, 23, 42, 0.08);
            }
            body.light-theme .hero-panel h1,
            body.light-theme .hero-panel p,
            body.light-theme .section-header .subtitle {
                color: var(--text-muted);
            }
            * { box-sizing: border-box; }
            .app-shell { display: flex; min-height: 100vh; }
            .sidebar {
                width: 280px;
                min-height: 100vh;
                background: linear-gradient(180deg, #080f24 0%, #101b3b 100%);
                color: var(--text);
                position: fixed;
                top: 0;
                left: 0;
                z-index: 1000;
                padding: 2rem 1.5rem;
                border-right: 1px solid rgba(255,255,255,.07);
            }
            .sidebar .brand {
                display: flex;
                align-items: center;
                gap: 0.9rem;
                margin-bottom: 2rem;
                font-size: 1.4rem;
                font-weight: 700;
                letter-spacing: 0.08em;
                text-transform: uppercase;
            }
            .sidebar .brand .logo {
                width: 46px;
                height: 46px;
                border-radius: 14px;
                display: grid;
                place-items: center;
                background: linear-gradient(135deg, rgba(59, 130, 246, 0.22), rgba(14, 165, 233, 0.18));
                box-shadow: 0 14px 40px rgba(37, 99, 235, 0.18);
                color: #ffffff;
            }
            .sidebar .brand .logo svg {
                width: 24px;
                height: 24px;
                color: #ffffff;
            }
            .brand-logo {
                width: 68px;
                height: 68px;
                border-radius: 50%;
                display: grid;
                place-items: center;
                background: linear-gradient(135deg, rgba(59, 130, 246, 0.18), rgba(14, 165, 233, 0.14));
                box-shadow: 0 14px 36px rgba(37, 99, 235, 0.16);
                margin: 0 auto 1rem;
            }
            .brand-logo svg {
                width: 32px;
                height: 32px;
                color: #ffffff;
            }
            .spin-cube svg {
                animation: spin-cube 6s linear infinite;
                transform-origin: center center;
            }
            @keyframes spin-cube {
                from { transform: rotateZ(0deg) rotateX(0deg); }
                to { transform: rotateZ(360deg) rotateX(360deg); }
            }
            .card-clickable {
                cursor: pointer;
                transition: transform 0.18s ease, box-shadow 0.18s ease;
            }
            .card-clickable:hover {
                transform: translateY(-3px);
                box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            }
            .sidebar .nav {
                display: grid;
                gap: 0.55rem;
            }
            .sidebar .nav-link {
                display: flex;
                align-items: center;
                gap: 0.75rem;
                padding: 0.95rem 1.15rem;
                border-radius: 1rem;
                color: var(--text);
                background: rgba(255,255,255,0.03);
                transition: transform .18s ease, background .18s ease, color .18s ease, border-color .18s ease;
                border: 1px solid transparent;
                font-weight: 500;
            }
            .sidebar .nav-link:hover,
            .sidebar .nav-link.active {
                color: #ffffff;
                background: rgba(245,196,67,0.18);
                transform: translateX(2px);
                border-color: rgba(245,196,67,0.25);
            }
            .sidebar .nav-link.disabled {
                cursor: not-allowed;
                opacity: 0.55;
            }
            .sidebar .nav-link .bi {
                font-size: 1.1rem;
                color: var(--accent);
            }
            .content-area {
                margin-left: 280px;
                width: calc(100% - 280px);
                padding: 2rem 2rem 2.5rem;
                min-height: 100vh;
            }
            .topbar {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 1rem;
                margin-bottom: 1.75rem;
            }
            .topbar .search-box {
                flex: 1;
                max-width: 540px;
            }
            .topbar .search-box .form-control {
                border-radius: 999px;
                border: 1px solid rgba(255,255,255,0.12);
                background: rgba(255,255,255,0.06);
                color: var(--text);
                padding-left: 1.4rem;
                height: 52px;
            }
            .topbar .search-box .form-control::placeholder {
                color: rgba(229,231,235,.75);
            }
            .topbar .search-box .input-group-text {
                border: none;
                background: transparent;
                color: var(--accent);
            }
            .topbar .profile-card {
                display: flex;
                align-items: center;
                gap: 1rem;
                padding: 0.95rem 1.2rem;
                border-radius: 1.5rem;
                background: rgba(255,255,255,0.05);
                border: 1px solid rgba(255,255,255,0.08);
                box-shadow: var(--shadow-soft);
                backdrop-filter: blur(12px);
            }
            .topbar .profile-card .avatar {
                width: 46px;
                height: 46px;
                border-radius: 50%;
                background: linear-gradient(180deg, rgba(245,196,67,0.96), rgba(241,157,23,0.92));
                display: grid;
                place-items: center;
                font-weight: 800;
                color: #08111e;
                box-shadow: 0 10px 30px rgba(245,196,67,0.18);
            }
            .topbar .profile-card .user-meta {
                line-height: 1.1;
            }
            .topbar .profile-card .user-meta .name {
                font-weight: 700;
                color: #ffffff;
            }
            .topbar .profile-card .user-meta .role {
                color: var(--text-muted);
                font-size: 0.9rem;
            }
            .topbar .profile-card .btn {
                border-color: rgba(255,255,255,0.16);
                color: var(--text);
            }
            .metric-card {
                border: 1px solid rgba(255,255,255,0.08);
                border-radius: 1.5rem;
                background: rgba(8, 12, 24, 0.9);
                box-shadow: var(--shadow-soft);
            }
            .metric-card .card-body {
                padding: 1.6rem;
            }
            .metric-card .value {
                font-size: 2rem;
                font-weight: 800;
                color: #ffffff;
            }
            .metric-card .label {
                color: var(--text-muted);
                font-size: 0.85rem;
                margin-bottom: 0.75rem;
                display: block;
                text-transform: uppercase;
                letter-spacing: 0.14em;
            }
            .metric-card .delta {
                font-size: 0.95rem;
                color: #86efac;
            }
            .btn-primary {
                background: linear-gradient(135deg, #f5c443 0%, #e9a432 100%);
                border: none;
                box-shadow: 0 20px 40px rgba(245,196,67,.3);
                color: #08111e;
            }
            .btn-primary:hover {
                background: linear-gradient(135deg, #f7d066 0%, #d99b2f 100%);
            }
            .btn-outline-primary {
                color: #f5c443;
                border-color: rgba(245,196,67,0.35);
                background: rgba(245,196,67,0.08);
            }
            .btn-outline-primary:hover {
                background: rgba(245,196,67,0.16);
                color: #ffffff;
            }
            .btn-outline-secondary {
                color: #e2e8f0;
                border-color: rgba(255,255,255,0.18);
                background: rgba(255,255,255,0.03);
            }
            .btn-outline-secondary:hover,
            .btn-outline-secondary.active {
                background: rgba(245,196,67,0.18);
                color: #ffffff;
                border-color: rgba(245,196,67,0.35);
            }
            .language-chip {
                min-width: 100px;
                border-radius: 999px;
                padding: 0.5rem 0.9rem;
                font-size: 0.9rem;
                transition: background .18s ease, color .18s ease, border-color .18s ease;
            }
            .language-chip.active {
                background: rgba(245,196,67,0.18);
                color: #ffffff;
                border-color: rgba(245,196,67,0.35);
            }
            .btn-outline-light {
                color: #ffffff;
                border-color: rgba(255,255,255,0.22);
                background: rgba(255,255,255,0.04);
            }
            .btn-outline-light:hover {
                background: rgba(255,255,255,0.12);
            }
            .btn-pill {
                border-radius: 999px;
                padding: 0.7rem 1.2rem;
                min-width: 130px;
                font-weight: 600;
            }
            .section-header {
                display: flex;
                flex-wrap: wrap;
                align-items: center;
                justify-content: space-between;
                gap: 1rem;
                margin-bottom: 1.5rem;
            }
            .section-header h2 {
                margin: 0;
                font-size: 1.8rem;
                font-weight: 600;
                letter-spacing: -0.025em;
            }
            .section-header .subtitle {
                color: var(--text-muted);
                font-size: 0.95rem;
            }
            .page-footer {
                margin-top: 2rem;
                padding: 1rem 1.25rem;
                border-top: 1px solid rgba(255,255,255,0.08);
                color: var(--text-muted);
                font-size: 0.9rem;
                display: flex;
                justify-content: space-between;
                align-items: center;
                gap: 1rem;
            }
            .page-footer em {
                font-style: italic;
                color: var(--text);
            }
            .card-custom {
                border: 1px solid rgba(255,255,255,0.08);
                border-radius: 1.6rem;
                box-shadow: var(--shadow);
                background: rgba(9, 14, 29, 0.95);
                backdrop-filter: blur(18px);
            }
            .card-custom .card-body {
                padding: 1.8rem;
            }
            .card-highlight {
                background: rgba(13, 23, 54, 0.95);
                border: 1px solid rgba(255,255,255,0.07);
                border-radius: 1.4rem;
                padding: 1.6rem;
                box-shadow: 0 20px 40px rgba(4, 10, 25, 0.22);
            }
            .card-highlight .title {
                font-size: 0.95rem;
                color: var(--text-muted);
                text-transform: uppercase;
                letter-spacing: 0.14em;
                margin-bottom: 0.75rem;
            }
            .card-highlight .amount {
                font-size: 2rem;
                font-weight: 800;
            }
            .table {
                color: #e2e8f0;
                background: rgba(255,255,255,0.02);
                border-radius: 1.2rem;
            }
            .table thead th {
                border-bottom: 1px solid rgba(255,255,255,0.08);
                color: var(--text-muted);
                font-size: 0.8rem;
                text-transform: uppercase;
                letter-spacing: 0.12em;
            }
            .table tbody tr {
                border-bottom: 1px solid rgba(255,255,255,0.06);
            }
            .table tbody tr:hover {
                background: rgba(255,255,255,0.04);
            }
            .table td, .table th {
                vertical-align: middle;
                border-top: none;
            }
            .form-control,
            .form-select {
                background: rgba(255,255,255,0.05);
                border: 1px solid rgba(255,255,255,0.12);
                color: var(--text);
            }
            .form-control:focus,
            .form-select:focus {
                border-color: rgba(245,196,67,0.4);
                box-shadow: 0 0 0 0.2rem rgba(245,196,67,0.12);
                background: rgba(255,255,255,0.08);
            }
            .badge.bg-success {
                background-color: #4ade80!important;
                color: #0f172a;
            }
            .badge.bg-danger {
                background-color: #fb7185!important;
            }
            .text-muted {
                color: var(--text-muted) !important;
            }
            .text-success {
                color: #86efac !important;
            }
            .text-danger {
                color: #fb7185 !important;
            }
            .modal-content {
                background: rgba(9, 14, 29, 0.98);
                border: 1px solid rgba(255,255,255,0.08);
                color: var(--text);
            }
            .modal-header, .modal-footer {
                border-color: rgba(255,255,255,0.08);
            }
            .hero-panel {
                padding: 1.8rem;
                border-radius: 1.8rem;
                background: linear-gradient(180deg, rgba(255,255,255,0.06), rgba(255,255,255,0.03));
                border: 1px solid rgba(255,255,255,0.08);
                box-shadow: 0 30px 60px rgba(4, 10, 25, 0.18);
                margin-bottom: 1.75rem;
            }
            .hero-panel h1 {
                font-size: 2.4rem;
                font-weight: 800;
                margin-bottom: 0.4rem;
            }
            .hero-panel p {
                color: var(--text-muted);
                margin-bottom: 1.25rem;
            }
            .hero-pill {
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                padding: 0.75rem 1rem;
                border-radius: 999px;
                background: rgba(255,255,255,0.07);
                color: var(--text);
                border: 1px solid rgba(255,255,255,0.08);
                font-size: 0.9rem;
                font-weight: 600;
            }
            .section-title {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 1rem;
                margin-bottom: 1rem;
            }
            .section-title h5 {
                font-size: 1.05rem;
                font-weight: 700;
                margin: 0;
                letter-spacing: 0.02em;
            }
            .section-title small {
                color: var(--text-muted);
            }
            @media (max-width: 992px) {
                .sidebar { position: relative; width: 100%; min-height: auto; }
                .content-area { margin-left: 0; width: 100%; padding: 1rem; }
                .topbar { flex-direction: column; align-items: stretch; }
            }
        </style>
    </head>
    <body>
        <div class="app-shell">
            <aside class="sidebar">
                <div class="brand">
                    <span class="logo" aria-label="Logo Stock Opname">
                        <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M16 24L32 14L48 24L32 34L16 24Z" fill="currentColor" opacity="0.18"/>
                            <path d="M16 24L32 14L48 24" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M16 24V40L32 50V34" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M32 34V50L48 40V24" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                    <span>Stock Opname</span>
                </div>

                @php
                    $userRole = strtolower($authUser['level'] ?? '');
                    $canUpload = in_array($userRole, ['administrator', 'manager', 'bod']);
                    $canExport = in_array($userRole, ['administrator', 'manager', 'bod', 'foreman', 'supervisior']);
                    $canMaster = in_array($userRole, ['administrator', 'manager', 'bod']);
                    $canManageUsers = $userRole === 'administrator';
                @endphp

                <nav class="nav flex-column">
                    @if($authUser)
                        <a class="nav-link {{ request()->routeIs('barang.dashboard') ? 'active' : '' }}" href="{{ route('barang.dashboard') }}"><i class="bi bi-speedometer2"></i>Dashboard</a>
                        <a class="nav-link {{ request()->is('barang*') ? 'active' : '' }}" href="{{ route('barang.index') }}"><i class="bi bi-box2"></i>Data Barang</a>
                        <a class="nav-link {{ $canUpload ? (request()->routeIs('barang.upload') ? 'active' : '') : 'disabled opacity-50' }}" href="{{ $canUpload ? route('barang.upload') : 'javascript:void(0);' }}"><i class="bi bi-cloud-upload"></i>Upload Data</a>
                        <a class="nav-link {{ $canExport ? (request()->routeIs('barang.export') || request()->routeIs('barang.export.download') ? 'active' : '') : 'disabled opacity-50' }}" href="{{ $canExport ? route('barang.export') : 'javascript:void(0);' }}"><i class="bi bi-file-earmark-arrow-down"></i>Export Data</a>
                        <a class="nav-link {{ $canMaster ? (request()->routeIs('barang.master') ? 'active' : '') : 'disabled opacity-50' }}" href="{{ $canMaster ? route('barang.master') : 'javascript:void(0);' }}"><i class="bi bi-folder2-open"></i>Master Data</a>
                        <a class="nav-link {{ request()->routeIs('settings') ? 'active' : '' }}" href="{{ route('settings') }}"><i class="bi bi-gear"></i>Pengaturan</a>
                        @if($canManageUsers)
                            <a class="nav-link {{ request()->is('users*') ? 'active' : '' }}" href="{{ route('users.index') }}"><i class="bi bi-people"></i>Manajemen User</a>
                        @endif
                    @else
                        <a class="nav-link active" href="{{ route('login') }}"><i class="bi bi-box-arrow-in-right"></i>Login</a>
                    @endif
                </nav>
            </aside>

            <div class="content-area">
                <header class="topbar">
                    <div class="search-box">
                        <form action="{{ route('barang.index') }}" method="GET">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                                <input type="text" name="search" class="form-control border-start-0" placeholder="Cari part number / line..." value="{{ request('search') }}">
                            </div>
                        </form>
                    </div>
                    <div class="profile-card">
                        @if($authUser)
                            <div>
                                <div class="text-muted small">NPK {{ $authUser['npk'] ?? '-' }}</div>
                                <div class="fw-bold">{{ $authUser['name'] ?? 'Pengguna' }}</div>
                                <div class="text-muted small">{{ ucfirst($authUser['jabatan'] ?? '') }}</div>
                            </div>
                            <div class="avatar">{{ strtoupper(substr($authUser['name'] ?? 'G', 0, 1)) }}</div>
                            <a href="{{ route('logout') }}" class="btn btn-sm btn-outline-light ms-2">Logout</a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-sm btn-outline-light">Login</a>
                        @endif
                    </div>
                </header>

                @yield('content')
                <footer class="page-footer">
                    <span>Stock Opname - Aplikasi manajemen stok modern.</span>
                    <em>@Afterproject2026</em>
                </footer>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            const applyTheme = (theme) => {
                document.body.classList.toggle('light-theme', theme === 'light');
                localStorage.setItem('sto_theme', theme);
                document.querySelectorAll('[data-theme]').forEach(button => {
                    button.classList.toggle('active', button.dataset.theme === theme);
                });
            };

            const applyLanguage = (lang) => {
                document.documentElement.lang = lang;
                localStorage.setItem('sto_language', lang);
                document.querySelectorAll('.language-chip').forEach(chip => {
                    chip.classList.toggle('active', chip.dataset.lang === lang);
                });
            };

            document.addEventListener('DOMContentLoaded', () => {
                const savedTheme = localStorage.getItem('sto_theme') || '{{ $authUser['theme'] ?? 'dark' }}';
                applyTheme(savedTheme);

                const savedLang = localStorage.getItem('sto_language') || '{{ $authUser['language'] ?? 'id' }}';
                applyLanguage(savedLang);

                document.querySelectorAll('[data-theme]').forEach(button => {
                    button.addEventListener('click', () => applyTheme(button.dataset.theme));
                });
                document.querySelectorAll('.language-chip').forEach(chip => {
                    chip.addEventListener('click', () => applyLanguage(chip.dataset.lang));
                });
            });
        </script>
        @yield('scripts')
    </body>
</html>
