@extends('layouts.app')

@section('title', 'Proses Transaksi - Restaurant POS')
@section('page-title', 'Proses Transaksi')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-cash-register me-2"></i>
                    Form Proses Transaksi
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('transaksi.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label">Pilih Kelompok Pesanan per Pelanggan <span class="text-danger">*</span></label>
                        <div class="list-group" id="group-list">
                            @php
                                $grouped = $pesanans->groupBy('idpelanggan');
                            @endphp
                            @forelse($grouped as $idpelanggan => $items)
                                @php
                                    $pelangganNama = optional($items->first()->pelanggan)->namapelanggan ?? 'Pelanggan';
                                    $totalItems = $items->count();
                                    $sumTotal = $items->sum(fn($p) => $p->menu->harga * $p->jumlah);
                                    $ids = $items->pluck('idpesanan')->implode(',');
                                @endphp
                                <label class="list-group-item list-group-item-action d-flex align-items-start gap-3">
                                    <input class="form-check-input mt-1" type="radio" name="group_choice" value="{{ $idpelanggan }}" data-ids="{{ $ids }}" data-total="{{ $sumTotal }}">
                                    <div class="w-100">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <strong>{{ $pelangganNama }}</strong>
                                                <span class="badge bg-info ms-2">{{ $totalItems }} pesanan</span>
                                            </div>
                                            <div>
                                                <strong>Total: Rp {{ number_format($sumTotal, 0, ',', '.') }}</strong>
                                            </div>
                                        </div>
                                        <div class="mt-2 small text-muted">
                                            @foreach($items as $it)
                                                <span class="me-3">
                                                    {{ $it->menu->namamenu }} ({{ $it->jumlah }}x)
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                </label>
                            @empty
                                <div class="alert alert-info mb-0">Tidak ada pesanan yang menunggu pembayaran.</div>
                            @endforelse
                        </div>
                        @error('idpesanan')
                            <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Hidden container for selected ids -->
                    <div id="selected-ids"></div>

                    <!-- Total Display -->
                    <div class="alert alert-info" id="total-display" style="display: none;">
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Total: Rp <span id="total-amount">0</span></strong>
                            </div>
                            <div class="col-md-6">
                                <strong>Minimal Bayar: Rp <span id="min-bayar">0</span></strong>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="bayar" class="form-label">Jumlah Bayar <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" 
                                   class="form-control @error('bayar') is-invalid @enderror" 
                                   id="bayar" 
                                   name="bayar" 
                                   value="{{ old('bayar') }}" 
                                   required
                                   min="0"
                                   placeholder="Masukkan jumlah pembayaran">
                        </div>
                        @error('bayar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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
                        <button type="submit" class="btn btn-primary" id="submit-btn" disabled>
                            <i class="fas fa-save me-2"></i>
                            Proses Transaksi
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
    let totalAmount = 0;
    const groupList = document.getElementById('group-list');
    const selectedIdsContainer = document.getElementById('selected-ids');

    groupList?.addEventListener('change', function(e) {
        if (e.target && e.target.matches('input[type="radio"][name="group_choice"]')) {
            const ids = (e.target.getAttribute('data-ids') || '').split(',').filter(Boolean);
            const total = parseInt(e.target.getAttribute('data-total') || '0');

            // Rebuild hidden inputs
            selectedIdsContainer.innerHTML = '';
            ids.forEach(id => {
                const inp = document.createElement('input');
                inp.type = 'hidden';
                inp.name = 'idpesanan[]';
                inp.value = id;
                selectedIdsContainer.appendChild(inp);
            });

            totalAmount = total;
            if (totalAmount > 0) {
                document.getElementById('total-amount').textContent = totalAmount.toLocaleString('id-ID');
                document.getElementById('min-bayar').textContent = totalAmount.toLocaleString('id-ID');
                document.getElementById('total-display').style.display = 'block';
                document.getElementById('bayar').min = totalAmount;
            } else {
                document.getElementById('total-display').style.display = 'none';
            }
            calculateKembalian();
        }
    });

    document.getElementById('bayar').addEventListener('input', calculateKembalian);

    function calculateKembalian() {
        const bayar = parseInt(document.getElementById('bayar').value) || 0;
        const kembalian = bayar - totalAmount;
        const submitBtn = document.getElementById('submit-btn');

        if (totalAmount > 0) {
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
        } else {
            document.getElementById('kembalian-display').style.display = 'none';
            submitBtn.disabled = true;
        }
    }
</script>
@endsection
