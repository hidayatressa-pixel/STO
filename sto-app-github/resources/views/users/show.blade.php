@extends('layouts.app')

@section('content')
<div class="section-header">
    <div>
        <h2>Detail User</h2>
        <p class="subtitle">Informasi lengkap akun pengguna.</p>
    </div>
</div>
<div class="row">
    <div class="col-12 col-md-8">
        <div class="card-custom p-4">
            <div class="mb-3">
                <h5 class="mb-1">Nama</h5>
                <p class="mb-0">{{ $user->name }}</p>
            </div>

            <div class="mb-3">
                <h5 class="mb-1">NPK</h5>
                <p class="mb-0">{{ $user->npk }}</p>
            </div>

            <div class="mb-3">
                <h5 class="mb-1">Email</h5>
                <p class="mb-0">{{ $user->email }}</p>
            </div>

            <div class="mb-3">
                <h5 class="mb-1">Jabatan</h5>
                <p class="mb-0">{{ ucfirst($user->jabatan) }}</p>
            </div>

            <div class="mb-3">
                <h5 class="mb-1">Level</h5>
                <p class="mb-0">{{ ucfirst($user->level) }}</p>
            </div>

            <div class="d-flex gap-2 mt-3">
                <a href="{{ route('users.edit', $user) }}" class="btn btn-primary">Edit</a>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
</div>
@endsection
