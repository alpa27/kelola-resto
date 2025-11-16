@extends('layouts.app')

@section('title', 'Menu Management - Restaurant POS')
@section('page-title', 'Menu Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h3 mb-0">Daftar Menu</h2>
    <a href="{{ route('menu.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>
        Tambah Menu
    </a>
</div>

<div class="card shadow">
    <div class="card-body">
        @if($menus->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Menu</th>
                            <th>Harga</th>
                            <th>Tanggal Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($menus as $index => $menu)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <strong>{{ $menu->namamenu }}</strong>
                            </td>
                            <td>
                                <span class="badge bg-success fs-6">
                                    Rp {{ number_format($menu->harga, 0, ',', '.') }}
                                </span>
                            </td>
                            <td>{{ $menu->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('menu.edit', $menu) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('menu.destroy', $menu) }}" method="POST" class="d-inline" 
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus menu ini?')">
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
                <i class="fas fa-book fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Belum ada menu</h5>
                <p class="text-muted">Klik tombol "Tambah Menu" untuk menambahkan menu pertama</p>
                <a href="{{ route('menu.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>
                    Tambah Menu Pertama
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
