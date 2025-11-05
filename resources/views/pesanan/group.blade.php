@extends('layouts.app')

@section('title', 'Detail Pesanan Pelanggan - Restaurant POS')
@section('page-title', 'Detail Pesanan: ' . ($pelanggan->namapelanggan ?? '-') . ' — ' . ($tanggal ?? ''))

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <a href="{{ route('pesanan.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i> Kembali
    </a>
    <div>
        @php $first = $items->first(); @endphp
        @if($first && $first->meja)
            <span class="badge bg-info">Meja {{ $first->meja->nomor_meja }}</span>
        @endif
    </div>
    <div></div>
    
</div>

<div class="card shadow">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Menu</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $index => $it)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $it->menu->namamenu }}</td>
                        <td><span class="badge bg-info">{{ $it->jumlah }}</span></td>
                        <td>Rp {{ number_format($it->menu->harga, 0, ',', '.') }}</td>
                        <td><strong>Rp {{ number_format($it->menu->harga * $it->jumlah, 0, ',', '.') }}</strong></td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('pesanan.edit', $it) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('pesanan.destroy', $it) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus menu ini dari pesanan?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection


