@extends('layouts.app')

@section('title', 'Detail Pelanggan - Restaurant POS')
@section('page-title', 'Detail Pelanggan')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-user me-2"></i>
                    Detail Pelanggan
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-muted">Nama Pelanggan</h6>
                        <p class="h5">{{ $pelanggan->namapelanggan }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">Jenis Kelamin</h6>
                        <p>
                            <span class="badge {{ $pelanggan->jeniskelamin ? 'bg-primary' : 'bg-pink' }}">
                                {{ $pelanggan->jeniskelamin ? 'Laki-laki' : 'Perempuan' }}
                            </span>
                        </p>
                    </div>
                </div>
                
                <div class="row mt-3">
                    <div class="col-md-6">
                        <h6 class="text-muted">No. HP</h6>
                        <p class="h6">{{ $pelanggan->nohp }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">Alamat</h6>
                        <p>{{ $pelanggan->alamat }}</p>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <h6 class="text-muted">Tanggal Dibuat</h6>
                        <p>{{ $pelanggan->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">Terakhir Diupdate</h6>
                        <p>{{ $pelanggan->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>
                        Kembali
                    </a>
                    <div>
                        <a href="{{ route('pelanggan.edit', $pelanggan) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>
                            Edit
                        </a>
                        <form action="{{ route('pelanggan.destroy', $pelanggan) }}" method="POST" class="d-inline" 
                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus pelanggan ini?')">
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

@section('styles')
<style>
    .bg-pink {
        background-color: #e91e63 !important;
    }
</style>
@endsection
