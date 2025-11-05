<div class="card shadow">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="fas fa-shopping-cart me-2"></i>
            Laporan Pesanan
        </h5>
    </div>
    <div class="card-header" style="background: var(--primary-gradient); color: white; border-top-left-radius:.5rem; border-top-right-radius:.5rem;">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2">
                <i class="fas fa-file-invoice"></i>
                <strong>Ringkasan Laporan Pesanan</strong>
            </div>
            <div class="small opacity-75">Per periode terpilih</div>
        </div>
    </div>
    <div class="card-body">
        <style>
            .table-wrapper { max-height: 65vh; overflow: auto; border-radius: .75rem; border: 1px solid var(--gray-200); }
            .table { margin-bottom: 0; }
            .table thead th { position: sticky; top: 0; z-index: 2; background: var(--gray-200); border-bottom: 1px solid var(--gray-300); }
            .table tbody tr { transition: background .2s ease; }
            .table tbody tr:hover { background: var(--gray-50); }
            .table tbody td { vertical-align: middle; }
            .badge-soft { background: rgba(59,130,246,.12); color: var(--dark-color); border: 1px solid rgba(59,130,246,.25); }
            .chip { display: inline-flex; align-items: center; gap:.35rem; padding: .35rem .6rem; border-radius: 999px; background: var(--gray-100); border: 1px solid var(--gray-200); font-size:.85rem; }
            .toolbar { display:flex; gap:.5rem; align-items:center; justify-content: space-between; margin-bottom: .75rem; }
            .toolbar .meta { display:flex; gap:.5rem; flex-wrap: wrap; }
            .legend { display:flex; gap:.5rem; align-items:center; color: var(--gray-600); }
            .legend .dot { width:10px; height:10px; border-radius:50%; display:inline-block; }
        </style>
        @if(isset($data['pesanan_report']) && $data['pesanan_report']->count() > 0)
            <div class="toolbar">
                @php
                    $groupedForCount = $data['pesanan_report']->groupBy(function($p){ return ($p->idpelanggan ?? '-') . '|' . optional($p->created_at)->format('Y-m-d'); });
                @endphp
                <div class="meta">
                    <span class="chip"><i class="fas fa-users"></i> {{ $groupedForCount->count() }} grup</span>
                    <span class="chip"><i class="fas fa-list"></i> {{ $data['pesanan_report']->count() }} item</span>
                </div>
            </div>
            <div class="table-wrapper">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Pesanan</th>
                            <th>Pelanggan</th>
                            <th>Meja</th>
                            <th>Total Item</th>
                            <th>Total Harga</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $grouped = $data['pesanan_report']->groupBy(function($p) {
                                return ($p->idpelanggan ?? '-') . '|' . optional($p->created_at)->format('Y-m-d');
                            });
                            $row = 1;
                        @endphp
                        @foreach($grouped as $key => $items)
                            @php
                                $first = $items->first();
                                $pelangganNama = optional($first->pelanggan)->namapelanggan ?? '-';
                                $tanggal = optional($first->created_at)->format('Y-m-d');
                                $meja = optional($first->meja);
                                $aggregated = [];
                                $totalItem = 0;
                                $totalHarga = 0;
                                foreach ($items as $it) {
                                    if (!($it->menu && $it->pelanggan)) { continue; }
                                    $name = $it->menu->namamenu;
                                    if (!isset($aggregated[$name])) { $aggregated[$name] = 0; }
                                    $aggregated[$name] += (int) $it->jumlah;
                                    $totalItem += (int) $it->jumlah;
                                    $totalHarga += ((int) $it->jumlah) * ((int) $it->menu->harga);
                                }
                            @endphp
                            <tr>
                                <td>{{ $row++ }}</td>
                                <td>
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach($aggregated as $menuName => $qty)
                                            <span class="badge bg-secondary">{{ $menuName }} ({{ $qty }}x)</span>
                                        @endforeach
                                    </div>
                                </td>
                                <td>{{ $pelangganNama }}</td>
                                <td>
                                    @if($meja)
                                        <span class="badge badge-soft"><i class="fas fa-chair me-1"></i>Meja {{ $meja->nomor_meja }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td><span class="badge bg-info">{{ $totalItem }}</span></td>
                                <td><strong>Rp {{ number_format($totalHarga, 0, ',', '.') }}</strong></td>
                                <td>{{ $tanggal }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-end mt-2">
                <div class="legend small">
                    <span class="dot" style="background:#dbeafe"></span> Hover untuk sorot baris
                </div>
            </div>
        @else
            <div class="text-center py-4">
                <i class="fas fa-shopping-cart fa-2x text-muted mb-3"></i>
                <h6 class="text-muted">Tidak ada data pesanan untuk periode ini</h6>
            </div>
        @endif
    </div>
</div>
