@extends('layouts.app')

@section('content')
<div class="hero-panel">
    <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3">
        <div>
            <h1>Dashboard</h1>
            <p class="text-muted mb-0">Overview data barang / produksi</p>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('barang.dashboard', ['range' => 'today']) }}" class="btn {{ ($range ?? 'all') === 'today' ? 'btn-primary' : 'btn-outline-secondary' }}">Hari ini</a>
            <a href="{{ route('barang.dashboard', ['range' => 'week']) }}" class="btn {{ ($range ?? 'all') === 'week' ? 'btn-primary' : 'btn-outline-secondary' }}">Minggu ini</a>
            <a href="{{ route('barang.dashboard', ['range' => 'all']) }}" class="btn {{ ($range ?? 'all') === 'all' ? 'btn-primary' : 'btn-outline-secondary' }}">Semua Line</a>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card-highlight card-clickable" data-href="{{ route('barang.index', ['sort' => 'part_number']) }}">
            <div class="title">Total Part Number</div>
            <div class="amount">{{ number_format($totalParts) }}</div>
            <div class="text-success mt-2">+12 dari kemarin</div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card-highlight card-clickable" data-href="{{ route('barang.index', ['sort' => 'qty_system']) }}">
            <div class="title">Total Qty System</div>
            <div class="amount">{{ number_format($totalSystem) }}</div>
            <div class="text-success mt-2">+8,5% dari kemarin</div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card-highlight card-clickable" data-href="{{ route('barang.index', ['sort' => 'qty_aktual']) }}">
            <div class="title">Total Qty Aktual</div>
            <div class="amount">{{ number_format($totalAktual) }}</div>
            <div class="text-success mt-2">+7,2% dari kemarin</div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card-highlight card-clickable" data-href="{{ route('barang.index', ['sort' => 'gap']) }}">
            <div class="title">Total Gap</div>
            <div class="amount">{{ number_format($totalGap) }}</div>
            <div class="text-danger mt-2">-3,2% dari kemarin</div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-12 col-xl-7">
        <div class="card-custom">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div>
                        <h5 class="mb-1">Gap per Line</h5>
                        <p class="text-muted small mb-0">Total gap data per line terbaru</p>
                    </div>
                    <button class="btn btn-sm btn-outline-secondary">Semua Line</button>
                </div>
                <div style="min-height: 320px;">
                    <canvas id="gapChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-xl-5">
        <div class="card-custom h-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div>
                        <h5 class="mb-1">Data Barang Terbaru</h5>
                        <p class="text-muted small mb-0">Menampilkan update terakhir pada produksi</p>
                    </div>
                    <a href="{{ route('barang.index') }}" class="btn btn-sm btn-outline-secondary">Lihat Semua</a>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Line</th>
                                <th>Part Name</th>
                                <th class="text-end">Gap</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($latestProduksi as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->line }}</td>
                                    <td>{{ \Illuminate\Support\Str::limit($item->part_name, 24) }}</td>
                                    <td class="text-end">
                                        <span class="badge {{ $item->gap >= 0 ? 'bg-success' : 'bg-danger' }}">{{ $item->gap }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('gapChart').getContext('2d');
    const labels = @json($lines->pluck('line'));
    const data = @json($lines->pluck('total_gap'));
    const colors = data.map(value => value < 0 ? '#ef4444' : '#2563eb');

    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Total Gap',
                data: data,
                backgroundColor: colors,
                borderRadius: 12,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { color: '#6b7280' }
                },
                y: {
                    beginAtZero: true,
                    ticks: { color: '#6b7280' },
                    grid: { color: 'rgba(15, 23, 42, 0.08)' }
                }
            },
            plugins: {
                legend: { display: false }
            },
            onClick(evt) {
                const points = chart.getElementsAtEventForMode(evt, 'nearest', { intersect: true }, true);
                if (!points.length) {
                    return;
                }

                const index = points[0].index;
                const line = labels[index];
                if (line) {
                    window.location.href = '{{ url('detail-line') }}/' + encodeURIComponent(line);
                }
            }
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.card-clickable').forEach(function (card) {
            card.addEventListener('click', function () {
                const href = card.dataset.href;
                if (href) {
                    window.location.href = href;
                }
            });
        });
    });
</script>
@endsection