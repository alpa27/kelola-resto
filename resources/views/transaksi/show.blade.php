@extends('layouts.app')

@section('title', 'Detail Transaksi - Restaurant POS')
@section('page-title', 'Detail Transaksi')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-cash-register me-2"></i>
                    Detail Transaksi
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-muted">Menu</h6>
                        <p class="h5">{{ $transaksi->pesanan->menu->namamenu }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">Pelanggan</h6>
                        <p class="h6">{{ $transaksi->pesanan->pelanggan->namapelanggan }}</p>
                    </div>
                </div>
                
                <div class="row mt-3">
                    <div class="col-md-6">
                        <h6 class="text-muted">Jumlah Pesanan</h6>
                        <p class="h6">
                            <span class="badge bg-info fs-6">{{ $transaksi->pesanan->jumlah }}</span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">Harga Satuan</h6>
                        <p class="h6">Rp {{ number_format($transaksi->pesanan->menu->harga, 0, ',', '.') }}</p>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <h6 class="text-muted">Total</h6>
                        <p class="h4 text-success">Rp {{ number_format($transaksi->total, 0, ',', '.') }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">Bayar</h6>
                        <p class="h4 text-primary">Rp {{ number_format($transaksi->bayar, 0, ',', '.') }}</p>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <h6 class="text-muted">Kembalian</h6>
                        <p class="h4 text-info">Rp {{ number_format($transaksi->bayar - $transaksi->total, 0, ',', '.') }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">Tanggal Transaksi</h6>
                        <p>{{ $transaksi->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>
                        Kembali
                    </a>
                    <div>
                        <a href="{{ route('transaksi.edit', $transaksi) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>
                            Edit
                        </a>
                        <form action="{{ route('transaksi.destroy', $transaksi) }}" method="POST" class="d-inline" 
                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash me-2"></i>
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
