@extends('layouts.app')

@section('title', 'Meja Management - Restaurant POS')
@section('page-title', 'Meja Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h3 mb-0">Daftar Meja</h2>
    <a href="{{ route('meja.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>
        Tambah Meja
    </a>
</div>

<div class="card shadow">
    <div class="card-body">
        @if($mejas->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nomor Meja</th>
                            <th>Kapasitas</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($mejas as $index => $meja)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <strong>Meja {{ $meja->nomor_meja }}</strong>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $meja->kapasitas }} orang</span>
                            </td>
                            <td>
                                @if($meja->status == 'kosong')
                                    <span class="badge bg-success">Kosong</span>
                                @elseif($meja->status == 'terisi')
                                    <span class="badge bg-danger">Terisi</span>
                                @else
                                    <span class="badge bg-warning">Reserved</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('meja.show', $meja) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('meja.edit', $meja) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('meja.destroy', $meja) }}" method="POST" class="d-inline" 
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus meja ini?')">
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
                <i class="fas fa-table fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Belum ada meja</h5>
                <p class="text-muted">Klik tombol "Tambah Meja" untuk menambahkan meja pertama</p>
                <a href="{{ route('meja.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>
                    Tambah Meja Pertama
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
