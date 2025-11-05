@extends('layouts.app')

@section('title', 'Detail Pesanan - Restaurant POS')
@section('page-title', 'Detail Pesanan')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-shopping-cart me-2"></i>
                    Detail Pesanan
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-muted">Menu</h6>
                        <p class="h5">{{ $pesanan->menu->namamenu }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">Harga Satuan</h6>
                        <p class="h5 text-success">Rp {{ number_format($pesanan->menu->harga, 0, ',', '.') }}</p>
                    </div>
                </div>
                
                
                
                <div class="row mt-3">
                    <div class="col-md-6">
                        <h6 class="text-muted">Pelanggan</h6>
                        <p class="h6">{{ $pesanan->pelanggan->namapelanggan }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">Meja</h6>
                        <p class="h6">
                            @if($pesanan->meja)
                                <span class="badge bg-primary fs-6">Meja {{ $pesanan->meja->nomor_meja }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </p>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <h6 class="text-muted">Jumlah</h6>
                        <p class="h6">
                            <span class="badge bg-info fs-6">{{ $pesanan->jumlah }}</span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        @if($pesanan->meja)
                            <h6 class="text-muted">Kapasitas Meja</h6>
                            <p class="h6">{{ $pesanan->meja->kapasitas }} orang</p>
                        @endif
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <h6 class="text-muted">Total</h6>
                        <p class="h4 text-primary">Rp {{ number_format($pesanan->menu->harga * $pesanan->jumlah, 0, ',', '.') }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">Waiter</h6>
                        <p class="h6">{{ $pesanan->user->name }}</p>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <h6 class="text-muted">Tanggal Pesanan</h6>
                        <p>{{ $pesanan->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">Terakhir Diupdate</h6>
                        <p>{{ $pesanan->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('pesanan.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>
                        Kembali
                    </a>
                    <div>
                        <a href="{{ route('pesanan.edit', $pesanan) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>
                            Edit
                        </a>
                        <form action="{{ route('pesanan.destroy', $pesanan) }}" method="POST" class="d-inline" 
                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesanan ini?')">
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
