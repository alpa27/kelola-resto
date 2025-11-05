@extends('layouts.app')

@section('title', 'Dashboard - Restaurant POS')
@section('page-title', 'Dashboard')

@section('content')
<div class="row">
    <!-- Statistics Cards -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Menu
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $data['total_menu'] }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-book fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total Pesanan
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $data['total_pesanan'] }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Total Transaksi
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $data['total_transaksi'] }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-cash-register fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Total Pelanggan
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $data['total_pelanggan'] }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Meja Status -->
    <div class="col-xl-6 col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Status Meja</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="text-center">
                            <div class="h3 text-success">{{ $data['meja_kosong'] }}</div>
                            <div class="text-muted">Meja Kosong</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-center">
                            <div class="h3 text-danger">{{ $data['meja_terisi'] }}</div>
                            <div class="text-muted">Meja Terisi</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Role-specific Information -->
    <div class="col-xl-6 col-lg-5">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">
                    Informasi {{ ucfirst($data['user']->role) }}
                </h6>
            </div>
            <div class="card-body">
                @if($data['user']->isWaiter())
                    <div class="text-center">
                        <div class="h3 text-primary">{{ $data['pesanan_hari_ini'] ?? 0 }}</div>
                        <div class="text-muted">Pesanan Hari Ini</div>
                    </div>
                @elseif($data['user']->isCashier())
                    <div class="row">
                        <div class="col-6 text-center">
                            <div class="h4 text-success">{{ $data['transaksi_hari_ini'] ?? 0 }}</div>
                            <div class="text-muted small">Transaksi Hari Ini</div>
                        </div>
                        <div class="col-6 text-center">
                            <div class="h4 text-info">Rp {{ number_format($data['total_pendapatan_hari'] ?? 0, 0, ',', '.') }}</div>
                            <div class="text-muted small">Pendapatan Hari Ini</div>
                        </div>
                    </div>
                @elseif($data['user']->isOwner())
                    <div class="text-center">
                        <div class="h3 text-success">Rp {{ number_format($data['pendapatan_bulan_ini'] ?? 0, 0, ',', '.') }}</div>
                        <div class="text-muted">Pendapatan Bulan Ini</div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Aksi Cepat</h6>
            </div>
            <div class="card-body">
                <div class="row">
                @if($data['user']->isAdmin() || $data['user']->isWaiter())
                <div class="col-md-3 mb-3">
                    <a href="{{ route('menu.create') }}" class="btn btn-primary btn-lg w-100">
                        <i class="fas fa-plus me-2"></i>
                        Tambah Menu
                    </a>
                </div>
                @endif
                
                @if($data['user']->isAdmin() || $data['user']->isWaiter())
                <div class="col-md-3 mb-3">
                    <a href="{{ route('pelanggan.create') }}" class="btn btn-success btn-lg w-100">
                        <i class="fas fa-user-plus me-2"></i>
                        Tambah Pelanggan
                    </a>
                </div>
                @endif
                    
                    @if($data['user']->isWaiter())
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('pesanan.create') }}" class="btn btn-warning btn-lg w-100">
                            <i class="fas fa-shopping-cart me-2"></i>
                            Buat Pesanan
                        </a>
                    </div>
                    @endif
                    
                    @if($data['user']->isCashier())
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('transaksi.create') }}" class="btn btn-info btn-lg w-100">
                            <i class="fas fa-cash-register me-2"></i>
                            Proses Transaksi
                        </a>
                    </div>
                    @endif
                    
                    @if($data['user']->isWaiter() || $data['user']->isCashier() || $data['user']->isOwner())
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('laporan.index') }}" class="btn btn-secondary btn-lg w-100">
                            <i class="fas fa-chart-bar me-2"></i>
                            Lihat Laporan
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .border-left-primary {
        border-left: 0.25rem solid #4e73df !important;
    }
    .border-left-success {
        border-left: 0.25rem solid #1cc88a !important;
    }
    .border-left-info {
        border-left: 0.25rem solid #36b9cc !important;
    }
    .border-left-warning {
        border-left: 0.25rem solid #f6c23e !important;
    }
    .text-xs {
        font-size: 0.7rem;
    }
    .font-weight-bold {
        font-weight: 700 !important;
    }
    .text-gray-800 {
        color: #5a5c69 !important;
    }
    .text-gray-300 {
        color: #dddfeb !important;
    }
</style>
@endsection
