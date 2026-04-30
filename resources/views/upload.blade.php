@extends('layouts.app')

@section('content')
<div class="section-header">
    <div>
        <h2>Upload Data Produksi</h2>
        <p class="subtitle">Unggah file CSV atau XLSX untuk memperbarui data produksi cepat.</p>
    </div>
    <div>
        <a href="{{ route('barang.index') }}" class="btn btn-outline-light btn-pill">Kembali ke Data Barang</a>
    </div>
</div>
<div class="row">
    <div class="col-12 col-lg-7">
        <div class="card-custom p-4">
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

            <form action="{{ route('barang.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="file" class="form-label">Pilih File</label>
                    <input type="file" id="file" name="file" class="form-control" accept=".csv,.xls,.xlsx" required>
                </div>
                <div class="mb-3 text-muted">
                    Format file: <strong>line, part_number, part_name, qty_system, qty_aktual, gap</strong> untuk CSV.
                    Untuk XLSX, gunakan kolom yang sama di baris pertama.
                </div>
                <button type="submit" class="btn btn-primary">Upload Sekarang</button>
            </form>
        </div>
    </div>
</div>
@endsection
