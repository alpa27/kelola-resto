@extends('layouts.app')

@section('title', 'Edit Pesanan - Restaurant POS')
@section('page-title', 'Edit Pesanan')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-edit me-2"></i>
                    Form Edit Pesanan
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('pesanan.update', $pesanan) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="idmenu" class="form-label">Menu <span class="text-danger">*</span></label>
                        <select class="form-select @error('idmenu') is-invalid @enderror" 
                                id="idmenu" 
                                name="idmenu" 
                                required>
                            <option value="">Pilih Menu</option>
                            @foreach($menus as $menu)
                                <option value="{{ $menu->idmenu }}" 
                                        data-harga="{{ $menu->harga }}"
                                        {{ old('idmenu', $pesanan->idmenu) == $menu->idmenu ? 'selected' : '' }}>
                                    {{ $menu->namamenu }} - Rp {{ number_format($menu->harga, 0, ',', '.') }}
                                </option>
                            @endforeach
                        </select>
                        @error('idmenu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="idpelanggan" class="form-label">Pelanggan <span class="text-danger">*</span></label>
                        <select class="form-select @error('idpelanggan') is-invalid @enderror" 
                                id="idpelanggan" 
                                name="idpelanggan" 
                                required>
                            <option value="">Pilih Pelanggan</option>
                            @foreach($pelanggans as $pelanggan)
                                <option value="{{ $pelanggan->idpelanggan }}" 
                                        {{ old('idpelanggan', $pesanan->idpelanggan) == $pelanggan->idpelanggan ? 'selected' : '' }}>
                                    {{ $pelanggan->namapelanggan }}
                                </option>
                            @endforeach
                        </select>
                        @error('idpelanggan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="idmeja" class="form-label">Meja <span class="text-danger">*</span></label>
                        <select class="form-select @error('idmeja') is-invalid @enderror" 
                                id="idmeja" 
                                name="idmeja" 
                                required>
                            <option value="">Pilih Meja</option>
                            @foreach($mejas as $meja)
                                <option value="{{ $meja->id }}" 
                                        {{ old('idmeja', $pesanan->idmeja) == $meja->id ? 'selected' : '' }}>
                                    Meja {{ $meja->nomor_meja }} - Kapasitas: {{ $meja->kapasitas }} orang
                                </option>
                            @endforeach
                        </select>
                        @error('idmeja')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="jumlah" class="form-label">Jumlah <span class="text-danger">*</span></label>
                        <input type="number" 
                               class="form-control @error('jumlah') is-invalid @enderror" 
                               id="jumlah" 
                               name="jumlah" 
                               value="{{ old('jumlah', $pesanan->jumlah) }}" 
                               required
                               min="1"
                               placeholder="Masukkan jumlah pesanan">
                        @error('jumlah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Total Preview -->
                    <div class="alert alert-info" id="total-preview" style="display: none;">
                        <strong>Total: Rp <span id="total-amount">0</span></strong>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('pesanan.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>
                            Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                            Update Pesanan
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
    document.getElementById('idmenu').addEventListener('change', calculateTotal);
    document.getElementById('jumlah').addEventListener('input', calculateTotal);

    // Calculate total on page load
    calculateTotal();

    function calculateTotal() {
        const menuSelect = document.getElementById('idmenu');
        const jumlahInput = document.getElementById('jumlah');
        const totalPreview = document.getElementById('total-preview');
        const totalAmount = document.getElementById('total-amount');

        if (menuSelect.value && jumlahInput.value) {
            const harga = parseInt(menuSelect.selectedOptions[0].dataset.harga);
            const jumlah = parseInt(jumlahInput.value);
            const total = harga * jumlah;

            totalAmount.textContent = total.toLocaleString('id-ID');
            totalPreview.style.display = 'block';
        } else {
            totalPreview.style.display = 'none';
        }
    }
</script>
@endsection
