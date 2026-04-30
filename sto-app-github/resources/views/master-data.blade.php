@extends('layouts.app')

@section('content')
<div class="section-header">
    <div>
        <h2>Master Data Produksi</h2>
        <p class="subtitle">Ringkasan line dan total gap untuk memantau performa produksi.</p>
    </div>
    <div>
        <a href="{{ route('barang.dashboard') }}" class="btn btn-outline-light btn-pill">Kembali</a>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card-custom p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="small">Line</th>
                            <th class="small text-end">Jumlah Part</th>
                            <th class="small text-end">Qty System</th>
                            <th class="small text-end">Qty Aktual</th>
                            <th class="small text-end">Total Gap</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lineSummaries as $line)
                            <tr>
                                <td class="small"><a href="{{ route('barang.detail-line', $line->line) }}">{{ $line->line }}</a></td>
                                <td class="small text-end">{{ $line->part_count }}</td>
                                <td class="small text-end">{{ $line->total_system }}</td>
                                <td class="small text-end">{{ $line->total_aktual }}</td>
                                <td class="small text-end">
                                    <span class="badge {{ $line->total_gap < 0 ? 'bg-danger' : 'bg-success' }}">
                                        {{ $line->total_gap }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Belum ada data produksi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
