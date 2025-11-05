@extends('layouts.app')

@section('title', 'Edit Transaksi - Restaurant POS')
@section('page-title', 'Edit Transaksi')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-edit me-2"></i>
                    Form Edit Transaksi
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('transaksi.update', $transaksi) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <!-- Display Pesanan Info (Read Only) -->
                    <div class="alert alert-info">
                        <h6 class="mb-2">Informasi Pesanan:</h6>
                        <p class="mb-1"><strong>Menu:</strong> {{ $transaksi->pesanan->menu->namamenu }}</p>
                        <p class="mb-1"><strong>Pelanggan:</strong> {{ $transaksi->pesanan->pelanggan->namapelanggan }}</p>
                        <p class="mb-0"><strong>Total:</strong> Rp {{ number_format($transaksi->total, 0, ',', '.') }}</p>
                    </div>

                    <div class="mb-3">
                        <label for="bayar" class="form-label">Jumlah Bayar <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" 
                                   class="form-control @error('bayar') is-invalid @enderror" 
                                   id="bayar" 
                                   name="bayar" 
                                   value="{{ old('bayar', $transaksi->bayar) }}" 
                                   required
                                   min="{{ $transaksi->total }}"
                                   placeholder="Masukkan jumlah pembayaran">
                        </div>
                        @error('bayar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Minimal pembayaran: Rp {{ number_format($transaksi->total, 0, ',', '.') }}</div>
                    </div>

                    <!-- Kembalian Display -->
                    <div class="alert alert-success" id="kembalian-display" style="display: none;">
                        <strong>Kembalian: Rp <span id="kembalian-amount">0</span></strong>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>
                            Kembali
                        </a>
                        <button type="submit" class="btn btn-primary" id="submit-btn">
                            <i class="fas fa-save me-2"></i>
                            Update Transaksi
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
    let totalAmount = {{ $transaksi->total }};

    document.getElementById('bayar').addEventListener('input', calculateKembalian);

    // Calculate kembalian on page load
    calculateKembalian();

    function calculateKembalian() {
        const bayar = parseInt(document.getElementById('bayar').value) || 0;
        const kembalian = bayar - totalAmount;
        const submitBtn = document.getElementById('submit-btn');

        if (bayar >= totalAmount) {
            document.getElementById('kembalian-amount').textContent = kembalian.toLocaleString('id-ID');
            document.getElementById('kembalian-display').style.display = 'block';
            document.getElementById('kembalian-display').className = 'alert alert-success';
            submitBtn.disabled = false;
        } else {
            document.getElementById('kembalian-amount').textContent = (bayar - totalAmount).toLocaleString('id-ID');
            document.getElementById('kembalian-display').style.display = 'block';
            document.getElementById('kembalian-display').className = 'alert alert-danger';
            submitBtn.disabled = true;
        }
    }
</script>
@endsection
