@extends('layouts.app')

@section('title', 'Edit Meja - Restaurant POS')
@section('page-title', 'Edit Meja')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-edit me-2"></i>
                    Form Edit Meja
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('meja.update', $meja) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="nomor_meja" class="form-label">Nomor Meja <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('nomor_meja') is-invalid @enderror" 
                               id="nomor_meja" 
                               name="nomor_meja" 
                               value="{{ old('nomor_meja', $meja->nomor_meja) }}" 
                               required
                               placeholder="Masukkan nomor meja (contoh: A1, B2, C3)">
                        @error('nomor_meja')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="kapasitas" class="form-label">Kapasitas <span class="text-danger">*</span></label>
                        <input type="number" 
                               class="form-control @error('kapasitas') is-invalid @enderror" 
                               id="kapasitas" 
                               name="kapasitas" 
                               value="{{ old('kapasitas', $meja->kapasitas) }}" 
                               required
                               min="1"
                               placeholder="Masukkan kapasitas meja">
                        @error('kapasitas')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select @error('status') is-invalid @enderror" 
                                id="status" 
                                name="status" 
                                required>
                            <option value="">Pilih Status</option>
                            <option value="kosong" {{ old('status', $meja->status) == 'kosong' ? 'selected' : '' }}>Kosong</option>
                            <option value="terisi" {{ old('status', $meja->status) == 'terisi' ? 'selected' : '' }}>Terisi</option>
                            <option value="reserved" {{ old('status', $meja->status) == 'reserved' ? 'selected' : '' }}>Reserved</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('meja.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>
                            Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                            Update Meja
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
