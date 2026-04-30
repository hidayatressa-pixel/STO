@extends('layouts.app')

@section('content')
<div class="row justify-content-center py-5">
    <div class="col-12 col-md-6 col-lg-5">
        <div class="card-custom p-4">
            <div class="text-center mb-4">
                <div class="brand-logo spin-cube">
                    <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16 24L32 14L48 24L32 34L16 24Z" fill="currentColor" opacity="0.18"/>
                        <path d="M16 24L32 14L48 24" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M16 24V40L32 50V34" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M32 34V50L48 40V24" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <h2 class="mb-1">Masuk ke Stock Opname</h2>
                <p class="text-muted mb-0">Gunakan NPK, Jabatan, dan Password untuk mengakses.</p>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="npk" class="form-label">NPK</label>
                    <input type="text" id="npk" name="npk" value="{{ old('npk') }}" class="form-control @error('npk') is-invalid @enderror" required>
                    @error('npk')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label for="jabatan" class="form-label">Jabatan</label>
                    <select id="jabatan" name="jabatan" class="form-select @error('jabatan') is-invalid @enderror" required>
                        <option value="">Pilih Jabatan</option>
                        <option value="member" {{ old('jabatan') === 'member' ? 'selected' : '' }}>Member</option>
                        <option value="leader" {{ old('jabatan') === 'leader' ? 'selected' : '' }}>Leader</option>
                        <option value="foreman" {{ old('jabatan') === 'foreman' ? 'selected' : '' }}>Foreman</option>
                        <option value="supervisior" {{ old('jabatan') === 'supervisior' ? 'selected' : '' }}>Supervisior</option>
                        <option value="manager" {{ old('jabatan') === 'manager' ? 'selected' : '' }}>Manager</option>
                        <option value="bod" {{ old('jabatan') === 'bod' ? 'selected' : '' }}>BOD</option>
                        <option value="administrator" {{ old('jabatan') === 'administrator' ? 'selected' : '' }}>Administrator</option>
                    </select>
                    @error('jabatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <button type="submit" class="btn btn-primary w-100">Masuk</button>
            </form>

            <div class="mt-4 text-center text-muted small">
                Hubungi admin jika belum terdaftar.
            </div>
        </div>
    </div>
</div>
@endsection
