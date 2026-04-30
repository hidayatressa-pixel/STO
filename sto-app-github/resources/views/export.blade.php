@extends('layouts.app')

@section('content')
<div class="section-header">
    <div>
        <h2>Export Data</h2>
        <p class="subtitle">Download data produksi dan pengguna dalam format CSV atau XLSX.</p>
    </div>
    <a href="{{ route('barang.dashboard') }}" class="btn btn-outline-light btn-pill">Kembali</a>
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

<div class="row gy-3">
    <div class="col-12 col-md-6">
        <div class="card-custom h-100">
            <div class="card-body">
                <h5 class="mb-2">Produksi</h5>
                <p class="text-muted">Download data produksi lengkap untuk analisis dan laporan.</p>
                <div class="d-grid gap-2 mt-3">
                    <a href="{{ route('barang.export.download', ['type' => 'csv']) }}" class="btn btn-outline-primary btn-pill">Download CSV</a>
                    <a href="{{ route('barang.export.download', ['type' => 'xlsx']) }}" class="btn btn-primary btn-pill">Download XLSX</a>
                </div>
            </div>
        </div>
    </div>

    @if(strtolower($authUser['level'] ?? '') === 'administrator')
        <div class="col-12 col-md-6">
            <div class="card-custom h-100">
                <div class="card-body">
                    <h5 class="mb-2">Pengguna</h5>
                    <p class="text-muted">Download data pengguna dan level akses untuk backup/analisis.</p>
                    <div class="d-grid gap-2 mt-3">
                        <a href="{{ route('users.export', ['type' => 'csv']) }}" class="btn btn-outline-secondary btn-pill">Download CSV</a>
                        <a href="{{ route('users.export', ['type' => 'xlsx']) }}" class="btn btn-secondary btn-pill">Download XLSX</a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
