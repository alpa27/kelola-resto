@extends('layouts.app')

@section('title', 'Pesanan - Restaurant POS')
@section('page-title', 'Pesanan')

@section('content')
<div class="mb-3">
    <a href="{{ route('pesanan.create') }}" class="btn btn-primary">Buat Pesanan</a>
</div>

<div class="card">
    <div class="card-header">Daftar Pesanan</div>
    <div class="card-body">
        @if(isset($groupedPesanan) && $groupedPesanan->count() > 0)
            <p style="font-size: 12px; margin-bottom: 10px;">
                Total: {{ $groupedPesanan->count() }} grup | {{ $pesanans->count() }} item
            </p>
            
            <table class="table">
                <thead>
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
                                @foreach($group['aggregated'] as $menuName => $qty)
                                    <span class="badge bg-primary">{{ $menuName }} ({{ $qty }}x)</span>
                                @endforeach
                            </td>
                            <td>{{ $group['pelanggan_nama'] }}</td>
                            <td>{{ $group['tanggal'] }}</td>
                            <td>
                                @if($group['meja'])
                                    Meja {{ $group['meja']->nomor_meja }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('pesanan.group.date', [$group['pelanggan_id'], $group['tanggal']]) }}" class="btn btn-primary btn-sm">Detail</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="text-center py-5">
                <p>Belum ada pesanan</p>
                <a href="{{ route('pesanan.create') }}" class="btn btn-primary">Buat Pesanan Pertama</a>
            </div>
        @endif
    </div>
</div>
@endsection