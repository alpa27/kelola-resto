@extends('layouts.app')

@section('title', 'Transaksi - Restaurant POS')
@section('page-title', 'Transaksi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h3 mb-0">Daftar Transaksi</h2>
    <a href="{{ route('transaksi.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>
        Proses Transaksi
    </a>
</div>

<div class="card shadow">
    <div class="card-body">
        @if($transaksis->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Pesanan</th>
                            <th>Pelanggan</th>
                            <th>Total</th>
                            <th>Bayar</th>
                            <th>Kembalian</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaksis as $index => $transaksi)
                        @if($transaksi->pesanan)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                @php
                                    $items = $transaksi->pesanans->count() > 0 ? $transaksi->pesanans : collect([$transaksi->pesanan]);
                                @endphp
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach($items as $it)
                                        <span class="badge bg-primary">{{ $it->menu->namamenu }} ({{ $it->jumlah }}x)</span>
                                    @endforeach
                                </div>
                            </td>
                            <td>{{ ($transaksi->pesanans->count() ? $transaksi->pesanans->first() : $transaksi->pesanan)->pelanggan->namapelanggan }}</td>
                            <td>
                                <span class="badge bg-success fs-6">
                                    Rp {{ number_format($transaksi->total, 0, ',', '.') }}
                                </span>
                            </td>
                            <td>Rp {{ number_format($transaksi->bayar, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge bg-info">
                                    Rp {{ number_format($transaksi->bayar - $transaksi->total, 0, ',', '.') }}
                                </span>
                            </td>
                            <td>{{ $transaksi->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('transaksi.show', $transaksi) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('transaksi.receipt', $transaksi) }}" class="btn btn-success btn-sm" title="Struk">
                                        <i class="fas fa-receipt"></i>
                                    </a>
                                    <a href="{{ route('transaksi.edit', $transaksi) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('transaksi.destroy', $transaksi) }}" method="POST" class="d-inline" 
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-cash-register fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Belum ada transaksi</h5>
                <p class="text-muted">Klik tombol "Proses Transaksi" untuk memproses transaksi pertama</p>
                <a href="{{ route('transaksi.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>
                    Proses Transaksi Pertama
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
