@extends('layouts.app')

@section('content')
<div class="hero-panel">
    <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3">
        <div>
            <h1>Pengaturan</h1>
            <p class="text-muted mb-0">Kelola profil pengguna, tampilan, dan bahasa aplikasi.</p>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('barang.dashboard') }}" class="btn btn-outline-light">Kembali Dashboard</a>
            @if(strtolower($authUser['level'] ?? '') === 'administrator')
                <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">Manajemen User</a>
            @endif
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card-custom">
    <div class="card-body">
        <div class="d-flex flex-wrap gap-2 mb-4">
            <button id="tab-profile" type="button" class="btn btn-outline-secondary active btn-pill">Akun</button>
            <button id="tab-preferences" type="button" class="btn btn-outline-secondary btn-pill">Preferensi</button>
        </div>

        <div id="panel-profile" class="settings-panel active">
            <h4 class="mb-3">Profil Akun</h4>
            <form action="{{ route('settings.update.profile') }}" method="POST">
                @csrf

                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <label class="form-label text-muted">Nama</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $authUser['name'] ?? '') }}" required>
                        @error('name')<div class="text-danger small">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label text-muted">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $authUser['email'] ?? '') }}" required>
                        @error('email')<div class="text-danger small">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label text-muted">Jabatan</label>
                        <input type="text" class="form-control" value="{{ ucfirst($authUser['jabatan'] ?? '') }}" disabled>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label text-muted">Level</label>
                        <input type="text" class="form-control" value="{{ ucfirst($authUser['level'] ?? '') }}" disabled>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label text-muted">Password Saat Ini</label>
                        <input type="password" name="current_password" class="form-control" placeholder="Kosongkan jika tidak ingin ubah password">
                        @error('current_password')<div class="text-danger small">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label text-muted">Password Baru</label>
                        <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin ubah password">
                        @error('password')<div class="text-danger small">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label text-muted">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi password baru">
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Simpan Profil</button>
                </div>
            </form>
        </div>

        <div id="panel-preferences" class="settings-panel" style="display:none;">
            <h4 class="mb-3">Preferensi Tampilan</h4>
            <form action="{{ route('settings.update.preferences') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="form-label text-muted">Tema Aplikasi</label>
                    <div class="d-flex gap-2 flex-wrap">
                        <button type="button" data-theme="dark" class="btn btn-outline-secondary">Gelap</button>
                        <button type="button" data-theme="light" class="btn btn-outline-secondary">Terang</button>
                    </div>
                    <input type="hidden" name="theme" id="settings-theme" value="{{ old('theme', $authUser['theme'] ?? 'dark') }}">
                    @error('theme')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>

                <div class="mb-4">
                    <label class="form-label text-muted">Bahasa</label>
                    <div class="d-flex flex-wrap gap-2">
                        <button type="button" class="language-chip btn btn-sm btn-outline-secondary" data-lang="id">Indonesia</button>
                        <button type="button" class="language-chip btn btn-sm btn-outline-secondary" data-lang="en">English</button>
                        <button type="button" class="language-chip btn btn-sm btn-outline-secondary" data-lang="de">Deutsch</button>
                        <button type="button" class="language-chip btn btn-sm btn-outline-secondary" data-lang="zh">中文</button>
                        <button type="button" class="language-chip btn btn-sm btn-outline-secondary" data-lang="ja">日本語</button>
                        <button type="button" class="language-chip btn btn-sm btn-outline-secondary" data-lang="vi">Tiếng Việt</button>
                        <button type="button" class="language-chip btn btn-sm btn-outline-secondary" data-lang="ru">Русский</button>
                        <button type="button" class="language-chip btn btn-sm btn-outline-secondary" data-lang="es">Español</button>
                    </div>
                    <input type="hidden" name="language" id="settings-language" value="{{ old('language', $authUser['language'] ?? 'id') }}">
                    @error('language')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>

                <div class="alert alert-info bg-white bg-opacity-10 border-0 text-white">
                    Preferensi akan disimpan ke akun Anda. Tema juga akan diterapkan secara lokal untuk sesi ini.
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Simpan Preferensi</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const profileTab = document.getElementById('tab-profile');
    const preferencesTab = document.getElementById('tab-preferences');
    const profilePanel = document.getElementById('panel-profile');
    const preferencesPanel = document.getElementById('panel-preferences');
    const themeInput = document.getElementById('settings-theme');
    const languageInput = document.getElementById('settings-language');

    const switchTab = (tab) => {
        profileTab.classList.toggle('active', tab === 'profile');
        preferencesTab.classList.toggle('active', tab === 'preferences');
        profilePanel.style.display = tab === 'profile' ? 'block' : 'none';
        preferencesPanel.style.display = tab === 'preferences' ? 'block' : 'none';
    };

    profileTab.addEventListener('click', () => switchTab('profile'));
    preferencesTab.addEventListener('click', () => switchTab('preferences'));

    document.querySelectorAll('[data-theme]').forEach(button => {
        button.addEventListener('click', () => {
            const theme = button.dataset.theme;
            themeInput.value = theme;
            document.querySelectorAll('[data-theme]').forEach(btn => btn.classList.toggle('active', btn === button));
        });
    });

    document.querySelectorAll('.language-chip').forEach(chip => {
        chip.addEventListener('click', () => {
            const lang = chip.dataset.lang;
            languageInput.value = lang;
            document.querySelectorAll('.language-chip').forEach(item => item.classList.toggle('active', item === chip));
        });
    });

    document.addEventListener('DOMContentLoaded', () => {
        const currentTheme = themeInput.value || 'dark';
        document.querySelectorAll('[data-theme]').forEach(button => button.classList.toggle('active', button.dataset.theme === currentTheme));
        const currentLanguage = languageInput.value || 'id';
        document.querySelectorAll('.language-chip').forEach(chip => chip.classList.toggle('active', chip.dataset.lang === currentLanguage));
    });
</script>
@endsection