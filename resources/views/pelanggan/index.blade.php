@extends('layouts.app')

@section('title', 'Pelanggan - Restaurant POS')
@section('page-title', 'Pelanggan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h3 mb-0">Daftar Pelanggan</h2>
    <a href="{{ route('pelanggan.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>
        Tambah Pelanggan
    </a>
</div>

<div class="card shadow">
    <div class="card-body">
        @if($pelanggans->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Jenis Kelamin</th>
                            <th>No. HP</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pelanggans as $index => $pelanggan)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <strong>{{ $pelanggan->namapelanggan }}</strong>
                            </td>
                            <td>
                                <span class="badge {{ $pelanggan->jeniskelamin ? 'bg-primary' : 'bg-pink' }}">
                                    {{ $pelanggan->jeniskelamin ? 'Laki-laki' : 'Perempuan' }}
                                </span>
                            </td>
                            <td>{{ $pelanggan->nohp }}</td>
                            <td>{{ Str::limit($pelanggan->alamat, 30) }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('pelanggan.show', $pelanggan) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('pelanggan.edit', $pelanggan) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('pelanggan.destroy', $pelanggan) }}" method="POST" class="d-inline" 
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus pelanggan ini?')">
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
        @else
            <div class="text-center py-5">
                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Belum ada pelanggan</h5>
                <p class="text-muted">Klik tombol "Tambah Pelanggan" untuk menambahkan pelanggan pertama</p>
                <a href="{{ route('pelanggan.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>
                    Tambah Pelanggan Pertama
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

@section('styles')
<style>
    .bg-pink {
        background-color: #e91e63 !important;
    }
</style>
@endsection
