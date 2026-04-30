@extends('layouts.app')

@section('content')
<div class="section-header">
    <div>
        <h2>Edit Barang</h2>
        <p class="subtitle">Perbarui qty aktual dan simpan perubahan data produksi.</p>
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

        <form action="{{ url('barang/' . $barang->id) }}" method="POST" class="mt-4">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Line</label>
                <input type="text" class="form-control" value="{{ $barang->line }}" disabled>
            </div>

            <div class="mb-3">
                <label class="form-label">Part Number</label>
                <input type="text" class="form-control" value="{{ $barang->part_number }}" disabled>
            </div>

            <div class="mb-3">
                <label class="form-label">Part Name</label>
                <input type="text" class="form-control" value="{{ $barang->part_name }}" disabled>
            </div>

            <div class="row">
                <div class="col-6 mb-3">
                    <label class="form-label">Qty System</label>
                    <input type="number" class="form-control" value="{{ $barang->qty_system }}" disabled>
                </div>

                <div class="col-6 mb-3">
                    <label for="qty_aktual" class="form-label">Qty Aktual</label>
                    <input type="number" class="form-control @error('qty_aktual') is-invalid @enderror" id="qty_aktual" name="qty_aktual" value="{{ old('qty_aktual', $barang->qty_aktual) }}" required>
                    @error('qty_aktual')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Gap</label>
                <input type="number" class="form-control" value="{{ $barang->gap }}" disabled>
                <div class="form-text">Gap akan dihitung otomatis dari Qty Aktual dikurangi Qty System.</div>
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                <button type="submit" class="btn btn-primary">Update Qty Aktual</button>
                <a href="{{ route('barang.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection