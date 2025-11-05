@extends('layouts.app')

@section('title', 'Buat Pesanan - Restaurant POS')
@section('page-title', 'Buat Pesanan')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-shopping-cart me-2"></i>
                    Form Buat Pesanan
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('pesanan.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label">Item Pesanan <span class="text-danger">*</span></label>
                        <div id="items-container">
                            <div class="row g-2 align-items-end item-row">
                                <div class="col-md-7">
                                    <label class="form-label">Menu</label>
                                    <select class="form-select" name="items[0][idmenu]" required>
                                        <option value="">Pilih Menu</option>
                                        @foreach($menus as $menu)
                                            <option value="{{ $menu->idmenu }}" data-harga="{{ $menu->harga }}">
                                                {{ $menu->namamenu }} - Rp {{ number_format($menu->harga, 0, ',', '.') }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Jumlah</label>
                                    <input type="number" class="form-control" name="items[0][jumlah]" value="1" min="1" required>
                                </div>
                                <div class="col-md-2 d-grid">
                                    <button type="button" class="btn btn-outline-primary" onclick="addItemRow()">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
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
                                        {{ old('idpelanggan') == $pelanggan->idpelanggan ? 'selected' : '' }}>
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
                                        {{ old('idmeja') == $meja->id ? 'selected' : '' }}>
                                    Meja {{ $meja->nomor_meja }} - Kapasitas: {{ $meja->kapasitas }} orang
                                </option>
                            @endforeach
                        </select>
                        @error('idmeja')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Total Preview -->
                    <div class="alert alert-info" id="total-preview" style="display: none;">
                        <strong>Total Perkiraan: Rp <span id="total-amount">0</span></strong>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('pesanan.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>
                            Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                            Buat Pesanan
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
    function addItemRow() {
        const container = document.getElementById('items-container');
        const index = container.querySelectorAll('.item-row').length;
        const row = document.createElement('div');
        row.className = 'row g-2 align-items-end item-row mt-2';
        row.innerHTML = `
            <div class="col-md-7">
                <label class="form-label">Menu</label>
                <select class="form-select" name="items[${index}][idmenu]" required onchange="calculateTotal()">
                    <option value="">Pilih Menu</option>
                    @foreach($menus as $menu)
                        <option value="{{ $menu->idmenu }}" data-harga="{{ $menu->harga }}">
                            {{ $menu->namamenu }} - Rp {{ number_format($menu->harga, 0, ',', '.') }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Jumlah</label>
                <input type="number" class="form-control" name="items[${index}][jumlah]" value="1" min="1" required oninput="calculateTotal()">
            </div>
            <div class="col-md-2 d-grid">
                <button type="button" class="btn btn-outline-danger" onclick="this.closest('.item-row').remove(); calculateTotal();">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `;
        container.appendChild(row);
        calculateTotal();
    }

    function calculateTotal() {
        const container = document.getElementById('items-container');
        const rows = container.querySelectorAll('.item-row');
        let total = 0;
        rows.forEach(row => {
            const select = row.querySelector('select');
            const qtyInput = row.querySelector('input[type="number"]');
            if (select && select.selectedOptions.length && qtyInput && qtyInput.value) {
                const harga = parseInt(select.selectedOptions[0].dataset.harga || '0');
                const jumlah = parseInt(qtyInput.value || '0');
                total += harga * jumlah;
            }
        });
        const totalPreview = document.getElementById('total-preview');
        const totalAmount = document.getElementById('total-amount');
        if (total > 0) {
            totalAmount.textContent = total.toLocaleString('id-ID');
            totalPreview.style.display = 'block';
        } else {
            totalPreview.style.display = 'none';
        }
    }
</script>
@endsection
