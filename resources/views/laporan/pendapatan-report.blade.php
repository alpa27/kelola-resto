<div class="row">
    <div class="col-md-6">
        <div class="card shadow mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-line me-2"></i>
                    Ringkasan Pendapatan
                </h5>
            </div>
            <div class="card-body">
                @if(isset($data['pendapatan_report']))
                    <div class="row text-center">
                        <div class="col-4">
                            <div class="h3 text-success">Rp {{ number_format($data['pendapatan_report']['total_pendapatan'], 0, ',', '.') }}</div>
                            <div class="text-muted small">Total Pendapatan</div>
                        </div>
                        <div class="col-4">
                            <div class="h3 text-primary">{{ $data['pendapatan_report']['total_transaksi'] }}</div>
                            <div class="text-muted small">Total Transaksi</div>
                        </div>
                        <div class="col-4">
                            <div class="h3 text-info">Rp {{ number_format($data['pendapatan_report']['rata_rata_transaksi'], 0, ',', '.') }}</div>
                            <div class="text-muted small">Rata-rata</div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-3">
                        <i class="fas fa-chart-line fa-2x text-muted mb-2"></i>
                        <h6 class="text-muted">Tidak ada data pendapatan</h6>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-star me-2"></i>
                    Menu Populer
                </h5>
            </div>
            <div class="card-body">
                @if(isset($data['menu_populer']) && $data['menu_populer']->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($data['menu_populer'] as $index => $menu)
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $menu->menu->namamenu }}</strong>
                            </div>
                            <span class="badge bg-primary rounded-pill">{{ $menu->total_terjual }}</span>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-3">
                        <i class="fas fa-star fa-2x text-muted mb-2"></i>
                        <h6 class="text-muted">Tidak ada data menu populer</h6>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
