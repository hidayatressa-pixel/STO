@extends('layouts.app')

@section('content')
<div class="section-header">
    <div>
        <h2>Data Barang / Produksi</h2>
        <p class="subtitle">Filter dan pantau data production line dengan cepat.</p>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="row g-2 mb-3 align-items-end">
            <div class="col-12 col-md-5 col-lg-4">
                <form action="{{ route('barang.index') }}" method="GET" class="d-flex gap-2 align-items-end">
                    <div class="flex-grow-1">
                        <label for="search" class="form-label small mb-1">Filter Line</label>
                        <input list="lineOptions" id="search" name="search" value="{{ $search ?? '' }}" class="form-control" placeholder="Cari line...">
                        <div class="form-text">Ketik nama line lalu tunggu sebentar, tabel akan otomatis terfilter.</div>
                        <datalist id="lineOptions">
                            @foreach($lines as $lineOption)
                                <option value="{{ $lineOption }}"></option>
                            @endforeach
                        </datalist>
                    </div>
                </form>
            </div>
        </div>
        
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="small">ID</th>
                        <th class="small">Line</th>
                        <th class="small">Part #</th>
                        <th class="small">Part Name</th>
                        <th class="small text-end">Qty Sys</th>
                        <th class="small text-end">Qty Aktual</th>
                        <th class="small text-end">Gap</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($produksi as $item)
                    <tr class="table-row-link" data-href="{{ route('barang.edit', $item) }}" style="cursor: pointer;">
                        <td class="small">{{ $item->id }}</td>
                        <td class="small">{{ $item->line }}</td>
                        <td class="small"><code>{{ $item->part_number }}</code></td>
                        <td class="small">{{ substr($item->part_name, 0, 15) }}{{ strlen($item->part_name) > 15 ? '...' : '' }}</td>
                        <td class="small text-end">{{ $item->qty_system }}</td>
                        <td class="small text-end">{{ $item->qty_aktual }}</td>
                        <td class="small text-end">
                            <span class="badge {{ $item->gap >= 0 ? 'bg-success' : 'bg-danger' }}">
                                {{ $item->gap }}
                            </span>
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Tidak ada data. Ubah filter atau upload file baru.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.table-row-link').forEach(function(row) {
                    row.addEventListener('click', function() {
                        window.location.href = row.dataset.href;
                    });
                });

                const searchInput = document.getElementById('search');
                const searchForm = searchInput.closest('form');
                let timeoutId;

                if (searchInput && searchForm) {
                    searchInput.addEventListener('input', function () {
                        clearTimeout(timeoutId);
                        timeoutId = setTimeout(function () {
                            searchForm.submit();
                        }, 400);
                    });

                    searchInput.addEventListener('change', function () {
                        searchForm.submit();
                    });
                }
            });
        </script>
    </div>
</div>

@endsection
