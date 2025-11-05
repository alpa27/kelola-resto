@extends('layouts.app')

@section('title', 'Detail Meja - Restaurant POS')
@section('page-title', 'Detail Meja')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-table me-2"></i>
                    Detail Meja
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-muted">Nomor Meja</h6>
                        <p class="h5">Meja {{ $meja->nomor_meja }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">Kapasitas</h6>
                        <p class="h5">{{ $meja->kapasitas }} orang</p>
                    </div>
                </div>
                
                <div class="row mt-3">
                    <div class="col-md-6">
                        <h6 class="text-muted">Status</h6>
                        <p>
                            @if($meja->status == 'kosong')
                                <span class="badge bg-success fs-6">Kosong</span>
                            @elseif($meja->status == 'terisi')
                                <span class="badge bg-danger fs-6">Terisi</span>
                            @else
                                <span class="badge bg-warning fs-6">Reserved</span>
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">Tanggal Dibuat</h6>
                        <p>{{ $meja->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('meja.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>
                        Kembali
                    </a>
                    <div>
                        <a href="{{ route('meja.edit', $meja) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>
                            Edit
                        </a>
                        <form action="{{ route('meja.destroy', $meja) }}" method="POST" class="d-inline" 
                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus meja ini?')">
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
