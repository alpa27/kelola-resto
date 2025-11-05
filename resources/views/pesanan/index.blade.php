@extends('layouts.app')

@section('title', 'Pesanan - Restaurant POS')
@section('page-title', 'Pesanan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h3 mb-0">Daftar Pesanan</h2>
    <a href="{{ route('pesanan.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>
        Buat Pesanan
    </a>
</div>

<div class="card shadow">
    <div class="card-header" style="background: var(--primary-gradient); color: white; border-top-left-radius:.5rem; border-top-right-radius:.5rem;">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2">
                <i class="fas fa-clipboard-list"></i>
                <strong>Ringkasan Pesanan</strong>
            </div>
            <div class="small opacity-75">Tampilan terkini</div>
        </div>
    </div>
    <div class="card-body">
        <style>
            .table-wrapper { max-height: 65vh; overflow: auto; border-radius: .75rem; border: 1px solid var(--gray-200); }
            .table { margin-bottom: 0; }
            .table thead th { position: sticky; top: 0; z-index: 2; background: var(--gray-200); border-bottom: 1px solid var(--gray-300); }
            .table tbody tr { transition: transform .08s ease, background .2s ease; }
            .table tbody tr:hover { transform: translateY(-1px); box-shadow: var(--shadow-sm); background: var(--gray-50); }
            .table tbody td { vertical-align: middle; }
            .badge-soft { background: rgba(59,130,246,.12); color: var(--dark-color); border: 1px solid rgba(59,130,246,.25); }
            .chip { display: inline-flex; align-items: center; gap:.35rem; padding: .35rem .6rem; border-radius: 999px; background: var(--gray-100); border: 1px solid var(--gray-200); font-size:.85rem; }
            .toolbar { display:flex; gap:.5rem; align-items:center; justify-content: space-between; margin-bottom: .75rem; }
            .toolbar .meta { display:flex; gap:.5rem; flex-wrap: wrap; }
            .legend { display:flex; gap:.5rem; align-items:center; color: var(--gray-600); }
            .legend .dot { width:10px; height:10px; border-radius:50%; display:inline-block; }
        </style>

        @if(isset($groupedPesanan) && $groupedPesanan->count() > 0)
            <div class="toolbar">
                <div class="meta">
                    <span class="chip"><i class="fas fa-users"></i> {{ $groupedPesanan->count() }} grup</span>
                    <span class="chip"><i class="fas fa-list"></i> {{ $pesanans->count() }} item</span>
                </div>
            </div>
            <div class="table-wrapper">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Pesanan</th>
                            <th>Pelanggan</th>
                            <th>Tanggal</th>
                            <th>Meja</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($groupedPesanan as $index => $group)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach($group['aggregated'] as $menuName => $qty)
                                            <span class="badge bg-primary"><i class="fas fa-utensils me-1"></i>{{ $menuName }} ({{ $qty }}x)</span>
                                        @endforeach
                                    </div>
                                </td>
                                <td>{{ $group['pelanggan_nama'] }}</td>
                                <td>{{ $group['tanggal'] }}</td>
                                <td>
                                    @if($group['meja'])
                                        <span class="badge badge-soft"><i class="fas fa-chair me-1"></i>Meja {{ $group['meja']->nomor_meja }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('pesanan.group.date', [$group['pelanggan_id'], $group['tanggal']]) }}" class="btn btn-primary">
                                            <i class="fas fa-eye me-1"></i> Show
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-end mt-2">
                <div class="legend small">
                    <span class="dot" style="background:#dbeafe"></span> Hover untuk sorot baris
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Belum ada pesanan</h5>
                <p class="text-muted">Klik tombol "Buat Pesanan" untuk membuat pesanan pertama</p>
                <a href="{{ route('pesanan.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>
                    Buat Pesanan Pertama
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
