@extends('layouts.app')

@section('content')
<div class="section-header">
    <div>
        <h2>Master Data User</h2>
        <p class="subtitle">Kelola akun pengguna, import, dan export data user dengan mudah.</p>
    </div>
    <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('users.create') }}" class="btn btn-primary btn-pill">Tambah User</a>
        <a href="{{ route('users.export', ['type' => 'csv']) }}" class="btn btn-outline-secondary btn-pill">Download CSV</a>
        <a href="{{ route('users.export', ['type' => 'xlsx']) }}" class="btn btn-outline-secondary btn-pill">Download XLSX</a>
        <button class="btn btn-success btn-pill" data-bs-toggle="modal" data-bs-target="#uploadModal">Upload File</button>
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

        <div class="card-custom p-4">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>NPK</th>
                            <th>Nama User</th>
                            <th>Email</th>
                            <th>Jabatan</th>
                            <th>Level</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->npk }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ ucfirst($user->jabatan) }}</td>
                            <td>{{ ucfirst($user->level) }}</td>
                            <td class="text-center">
                                <a href="{{ route('users.show', $user) }}" class="btn btn-sm btn-secondary">Detail</a>
                                <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-primary">Edit</a>
                                <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus user ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Belum ada data user.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Upload -->
<div class="modal fade" id="uploadModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload File CSV / XLSX</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('users.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="file" class="form-label">Pilih file CSV / XLSX / XLS</label>
                        <input type="file" class="form-control" id="file" name="file" accept=".csv,.xlsx,.xls" required>
                        <div class="form-text">Format: name,email,level. Baris baru akan dibuat atau diperbarui berdasarkan email.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
