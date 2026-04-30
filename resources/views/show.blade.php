@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12 col-md-8">
        <h1 class="mb-3">Detail Barang</h1>
        
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-12 col-sm-4"><strong>ID:</strong></div>
                    <div class="col-12 col-sm-8">{{ $barang->id }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 col-sm-4"><strong>Line:</strong></div>
                    <div class="col-12 col-sm-8">{{ $barang->line }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 col-sm-4"><strong>Part Number:</strong></div>
                    <div class="col-12 col-sm-8"><code>{{ $barang->part_number }}</code></div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 col-sm-4"><strong>Part Name:</strong></div>
                    <div class="col-12 col-sm-8">{{ $barang->part_name }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 col-sm-4"><strong>Qty System:</strong></div>
                    <div class="col-12 col-sm-8">{{ $barang->qty_system }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 col-sm-4"><strong>Qty Aktual:</strong></div>
                    <div class="col-12 col-sm-8">{{ $barang->qty_aktual }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 col-sm-4"><strong>Gap:</strong></div>
                    <div class="col-12 col-sm-8">
                        <span class="badge {{ $barang->gap >= 0 ? 'bg-success' : 'bg-danger' }} p-2">
                            <strong>{{ $barang->gap }}</strong>
                        </span>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 col-sm-4"><strong>Dibuat:</strong></div>
                    <div class="col-12 col-sm-8">{{ $barang->created_at->format('d-m-Y H:i') }}</div>
                </div>
            </div>
        </div>

        <div class="d-grid gap-2 d-md-flex justify-content-md-start mt-3">
            <a href="{{ route('barang.edit', $barang->id) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('barang.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection
