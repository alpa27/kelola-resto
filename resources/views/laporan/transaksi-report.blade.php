<div class="card shadow">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="fas fa-cash-register me-2"></i>
            Laporan Transaksi
        </h5>
    </div>
    <div class="card-body">
        @if(isset($data['transaksi_report']) && $data['transaksi_report']->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Pesanan</th>
                            <th>Pelanggan</th>
                            <th>Meja</th>
                            <th>Total</th>
                            <th>Bayar</th>
                            <th>Kembalian</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['transaksi_report'] as $index => $transaksi)
                        @if($transaksi->pesanan && $transaksi->pesanan->menu && $transaksi->pesanan->pelanggan)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                @php
                                    $items = $transaksi->pesanans->count() > 0 ? $transaksi->pesanans : collect([$transaksi->pesanan]);
                                @endphp
                                @foreach($items as $it)
                                    <span class="badge bg-primary me-1 mb-1">{{ $it->menu->namamenu }} ({{ $it->jumlah }}x)</span>
                                @endforeach
                            </td>
                            <td>{{ ($transaksi->pesanans->count() ? $transaksi->pesanans->first() : $transaksi->pesanan)->pelanggan->namapelanggan }}</td>
                            <td>
                                @if($transaksi->pesanan->meja)
                                    <span class="badge bg-primary">Meja {{ $transaksi->pesanan->meja->nomor_meja }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-success">Rp {{ number_format($transaksi->total, 0, ',', '.') }}</span>
                            </td>
                            <td>Rp {{ number_format($transaksi->bayar, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge bg-info">Rp {{ number_format($transaksi->bayar - $transaksi->total, 0, ',', '.') }}</span>
                            </td>
                            <td>{{ $transaksi->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-4">
                <i class="fas fa-cash-register fa-2x text-muted mb-3"></i>
                <h6 class="text-muted">Tidak ada data transaksi untuk periode ini</h6>
            </div>
        @endif
    </div>
</div>
