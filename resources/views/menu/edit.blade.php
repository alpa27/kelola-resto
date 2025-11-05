@extends('layouts.app')

@section('title', 'Edit Menu - Restaurant POS')
@section('page-title', 'Edit Menu')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-edit me-2"></i>
                    Form Edit Menu
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('menu.update', $menu) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="namamenu" class="form-label">Nama Menu <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('namamenu') is-invalid @enderror" 
                               id="namamenu" 
                               name="namamenu" 
                               value="{{ old('namamenu', $menu->namamenu) }}" 
                               required
                               placeholder="Masukkan nama menu">
                        @error('namamenu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="harga" class="form-label">Harga <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" 
                                   class="form-control @error('harga') is-invalid @enderror" 
                                   id="harga" 
                                   name="harga" 
                                   value="{{ old('harga', $menu->harga) }}" 
                                   required
                                   min="0"
                                   placeholder="Masukkan harga menu">
                        </div>
                        @error('harga')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('menu.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>
                            Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                            Update Menu
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Format currency input
    document.getElementById('harga').addEventListener('input', function(e) {
        let value = e.target.value;
        if (value < 0) {
            e.target.value = 0;
        }
    });
</script>
@endsection
