@extends('layouts.app')

@section('content')
<div class="section-header">
    <div>
        <h2>Edit User</h2>
        <p class="subtitle">Perbarui informasi dan level akses pengguna.</p>
    </div>
</div>
<div class="row">
    <div class="col-12 col-md-8">
        <div class="card-custom p-4">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Validasi Error:</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('users.update', $user) }}" method="POST" class="mt-4">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Nama User</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                @error('email')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>

            <div class="mb-3">
                <label for="npk" class="form-label">NPK</label>
                <input type="text" class="form-control @error('npk') is-invalid @enderror" id="npk" name="npk" value="{{ old('npk', $user->npk) }}" required>
                @error('npk')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>

            <div class="mb-3">
                <label for="jabatan" class="form-label">Jabatan / Level</label>
                <select class="form-select @error('jabatan') is-invalid @enderror" id="jabatan" name="jabatan" required>
                    <option value="">Pilih jabatan</option>
                    <option value="member" {{ old('jabatan', $user->jabatan) === 'member' ? 'selected' : '' }}>Member</option>
                    <option value="leader" {{ old('jabatan', $user->jabatan) === 'leader' ? 'selected' : '' }}>Leader</option>
                    <option value="foreman" {{ old('jabatan', $user->jabatan) === 'foreman' ? 'selected' : '' }}>Foreman</option>
                    <option value="supervisior" {{ old('jabatan', $user->jabatan) === 'supervisior' ? 'selected' : '' }}>Supervisior</option>
                    <option value="manager" {{ old('jabatan', $user->jabatan) === 'manager' ? 'selected' : '' }}>Manager</option>
                    <option value="bod" {{ old('jabatan', $user->jabatan) === 'bod' ? 'selected' : '' }}>BOD</option>
                    <option value="administrator" {{ old('jabatan', $user->jabatan) === 'administrator' ? 'selected' : '' }}>Administrator</option>
                </select>
                @error('jabatan')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password (kosongkan jika tidak diubah)</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                @error('password')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
