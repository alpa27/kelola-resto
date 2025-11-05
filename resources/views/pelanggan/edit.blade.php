@extends('layouts.app')

@section('title', 'Edit Pelanggan - Restaurant POS')
@section('page-title', 'Edit Pelanggan')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-edit me-2"></i>
                    Form Edit Pelanggan
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('pelanggan.update', $pelanggan) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="namapelanggan" class="form-label">Nama Pelanggan <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('namapelanggan') is-invalid @enderror" 
                               id="namapelanggan" 
                               name="namapelanggan" 
                               value="{{ old('namapelanggan', $pelanggan->namapelanggan) }}" 
                               required
                               placeholder="Masukkan nama pelanggan">
                        @error('namapelanggan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="jeniskelamin" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                        <select class="form-select @error('jeniskelamin') is-invalid @enderror" 
                                id="jeniskelamin" 
                                name="jeniskelamin" 
                                required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="1" {{ old('jeniskelamin', $pelanggan->jeniskelamin) == '1' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="0" {{ old('jeniskelamin', $pelanggan->jeniskelamin) == '0' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jeniskelamin')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="nohp" class="form-label">No. HP <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('nohp') is-invalid @enderror" 
                               id="nohp" 
                               name="nohp" 
                               value="{{ old('nohp', $pelanggan->nohp) }}" 
                               required
                               maxlength="12"
                               placeholder="Masukkan nomor HP">
                        @error('nohp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                  id="alamat" 
                                  name="alamat" 
                                  rows="3" 
                                  required
                                  maxlength="95"
                                  placeholder="Masukkan alamat pelanggan">{{ old('alamat', $pelanggan->alamat) }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>
                            Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                            Update Pelanggan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
