@extends('layouts.app')

@section('title', 'Dashboard - Restaurant POS')
@section('page-title', 'Dashboard')

@section('content')

<!-- Sambutan -->
<div class="row mb-3">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4>Selamat Datang, {{ $data['user']->name }}!</h4>
                <p style="margin: 0; font-size: 13px; color: #666;">
                    @if($data['user']->isAdmin())
                        Anda login sebagai <strong>Admin</strong>. Anda memiliki akses penuh untuk mengelola sistem.
                    @elseif($data['user']->isWaiter())
                        Anda login sebagai <strong>Waiter</strong>. Anda dapat mengelola menu, pelanggan, dan pesanan.
                    @elseif($data['user']->isCashier())
                        Anda login sebagai <strong>Kasir</strong>. Anda dapat memproses transaksi pembayaran.
                    @elseif($data['user']->isOwner())
                        Anda login sebagai <strong>Owner</strong>. Anda dapat melihat laporan dan performa restoran.
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Statistik -->
<div class="row mb-3">
    <div class="col-md-3 mb-3">
        <div class="card">
            <div class="card-body">
                <div>Total Menu</div>
                <h3>{{ $data['total_menu'] }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card">
            <div class="card-body">
                <div>Total Pelanggan</div>
                <h3>{{ $data['total_pelanggan'] }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card">
            <div class="card-body">
                <div>Pesanan Hari Ini</div>
                <h3>{{ $data['pesanan_hari_ini'] ?? 0 }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card">
            <div class="card-body">
                <div>Total Transaksi</div>
                <h3>{{ $data['total_transaksi'] }}</h3>
            </div>
        </div>
    </div>
</div>


@endsection

@section('styles')
<style>
    .card h3 {
        font-size: 24px;
        margin: 10px 0 0 0;
        font-weight: bold;
    }
    
    .card h4 {
        font-size: 18px;
        margin: 0 0 10px 0;
        font-weight: bold;
    }
    
    .card-body > div {
        font-size: 12px;
        color: #666;
    }
</style>
@endsection