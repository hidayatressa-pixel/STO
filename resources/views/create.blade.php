@extends('layouts.app')

@section('content')
<div class="section-header">
    <div>
        <h2>Tambah Barang Baru</h2>
        <p class="subtitle">Masukkan item produksi baru ke dalam sistem.</p>
    </div>
</div>
<div class="row">
    <div class="col-12 col-md-8">
        <div class="card-custom p-4">
            @if($errors->any())
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

        <form action="{{ route('barang.store') }}" method="POST" class="mt-4">
            @csrf

            <div class="mb-3">
                <label for="line" class="form-label">Line</label>
                <input type="text" class="form-control @error('line') is-invalid @enderror" id="line" name="line" value="{{ old('line') }}" required>
                @error('line')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>

            <div class="mb-3">
                <label for="part_number" class="form-label">Part Number</label>
                <input type="text" class="form-control @error('part_number') is-invalid @enderror" id="part_number" name="part_number" value="{{ old('part_number') }}" required>
                @error('part_number')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>

            <div class="mb-3">
                <label for="part_name" class="form-label">Part Name</label>
                <input type="text" class="form-control @error('part_name') is-invalid @enderror" id="part_name" name="part_name" value="{{ old('part_name') }}" required>
                @error('part_name')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>

            <div class="row">
                <div class="col-6 mb-3">
                    <label for="qty_system" class="form-label">Qty System</label>
                    <input type="number" class="form-control @error('qty_system') is-invalid @enderror" id="qty_system" name="qty_system" value="{{ old('qty_system') }}" required>
                    @error('qty_system')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>

                <div class="col-6 mb-3">
                    <label for="qty_aktual" class="form-label">Qty Aktual</label>
                    <input type="number" class="form-control @error('qty_aktual') is-invalid @enderror" id="qty_aktual" name="qty_aktual" value="{{ old('qty_aktual') }}" required>
                    @error('qty_aktual')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="gap" class="form-label">Gap</label>
                <input type="number" class="form-control @error('gap') is-invalid @enderror" id="gap" name="gap" value="{{ old('gap') }}" required>
                @error('gap')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('barang.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
