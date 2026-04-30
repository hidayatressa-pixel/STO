@extends('layouts.app')

@section('content')
<div class="section-header">
    <div>
        <h2>Detail Line: <span class="badge bg-info">{{ $line }}</span></h2>
        <p class="subtitle">Lihat semua part dan gap pada line ini.</p>
    </div>
    <div>
        <a href="{{ route('barang.dashboard') }}" class="btn btn-outline-light btn-pill">← Kembali ke Dashboard</a>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card-custom p-4 mb-4">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div>
                    <h3 class="mb-1">Total Gap</h3>
                    <p class="text-muted mb-0">Kondisi terbaru untuk line {{ $line }}.</p>
                </div>
                <div>
                    <span class="badge {{ $totalGap < 0 ? 'bg-danger' : 'bg-success' }} p-3 fs-5">
                        <strong>{{ $totalGap }}</strong>
                    </span>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th class="small">ID</th>
                        <th class="small">Part Number</th>
                        <th class="small">Part Name</th>
                        <th class="small text-end">Qty Sys</th>
                        <th class="small text-end">Qty Aktual</th>
                        <th class="small text-end">Gap</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($parts as $part)
                    <tr>
                        <td class="small">{{ $part->id }}</td>
                        <td class="small"><code>{{ $part->part_number }}</code></td>
                        <td class="small">{{ substr($part->part_name, 0, 20) }}{{ strlen($part->part_name) > 20 ? '...' : '' }}</td>
                        <td class="small text-end">{{ $part->qty_system }}</td>
                        <td class="small text-end">{{ $part->qty_aktual }}</td>
                        <td class="small text-end">
                            <span class="badge {{ $part->gap < 0 ? 'bg-danger' : 'bg-success' }}">
                                {{ $part->gap }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
