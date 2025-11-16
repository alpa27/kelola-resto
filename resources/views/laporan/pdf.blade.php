<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan {{ ucfirst($report_type) }}</title>
    <style>
    body {
        font-family: 'DejaVu Sans', sans-serif;
        font-size: 12px;
        line-height: 1.4;
        color: #000;
        margin: 0;
        padding: 20px;
        background: #fff;
    }

    .header {
        text-align: center;
        margin-bottom: 30px;
        background: #f2f2f2;
        padding: 20px;
        border: 1px solid #ccc;
    }

    .header h1 {
        color: #000;
        font-size: 28px;
        margin: 0 0 10px 0;
        font-weight: bold;
    }

    .header h2 {
        color: #333;
        font-size: 18px;
        margin: 0;
    }

    .info-section {
        background: #f9f9f9;
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
    }

    .info-label {
        font-weight: bold;
        color: #000;
    }

    .info-value {
        color: #333;
    }

    .summary-section {
        background: #f7f7f7;
        padding: 20px;
        border-radius: 5px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
    }

    .summary-title {
        font-size: 18px;
        font-weight: bold;
        color: #000;
        margin-bottom: 15px;
        text-align: center;
    }

    .summary-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
    }

    .summary-item {
        text-align: center;
        padding: 15px;
        background: #fff;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    .summary-value {
        font-size: 20px;
        font-weight: bold;
        color: #000;
    }

    .summary-label {
        font-size: 12px;
        color: #333;
        margin-top: 5px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
        background-color: white;
        border: 1px solid #ccc;
    }

    th {
        background: #000;
        color: #fff;
        padding: 10px;
        text-align: left;
        font-weight: bold;
        font-size: 11px;
    }

    td {
        padding: 8px;
        border-bottom: 1px solid #ddd;
        font-size: 11px;
        color: #000;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    tr:nth-child(odd) {
        background-color: #fff;
    }

    .text-right { text-align: right; }
    .text-center { text-align: center; }

    .badge {
        display: inline-block;
        padding: 3px 6px;
        border-radius: 3px;
        font-size: 10px;
        font-weight: bold;
        background: #000;
        color: #fff;
    }

    .footer {
        margin-top: 30px;
        text-align: center;
        font-size: 10px;
        color: #333;
        border-top: 1px solid #ccc;
        padding-top: 15px;
        background: #f2f2f2;
        padding: 15px;
    }

    .no-data {
        text-align: center;
        color: #555;
        font-style: italic;
        padding: 40px;
        background: #f7f7f7;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .page-break {
        page-break-before: always;
    }
</style>

</head>
<body>
    <div class="header">
        <h1>🍽️ RESTAURANT REPORT</h1>
        <h2>Laporan {{ ucfirst(str_replace('_', ' ', $report_type)) }}</h2>
    </div>

    <div class="info-section">
        <div class="info-row">
            <span class="info-label">Periode:</span>
            <span class="info-value">{{ \Carbon\Carbon::parse($start_date)->format('d F Y') }} - {{ \Carbon\Carbon::parse($end_date)->format('d F Y') }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Dibuat oleh:</span>
            <span class="info-value">{{ $generated_by }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Tanggal Generate:</span>
            <span class="info-value">{{ $generated_at->format('d F Y H:i:s') }}</span>
        </div>
    </div>

    @if($report_type == 'pesanan')
        <div class="summary-section">
            <div class="summary-title">📊 Ringkasan Laporan Pesanan</div>
            <div class="summary-grid">
                <div class="summary-item">
                    <div class="summary-value">{{ $total_pesanan }}</div>
                    <div class="summary-label">Total Pesanan</div>
                </div>
                <div class="summary-item">
                    <div class="summary-value">Rp {{ number_format($total_pendapatan, 0, ',', '.') }}</div>
                    <div class="summary-label">Total Pendapatan</div>
                </div>
            </div>
        </div>

        @if($pesanans->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Menu</th>
                        <th>Pelanggan</th>
                        <th>Meja</th>
                        <th>Jumlah</th>
                        <th>Harga Satuan</th>
                        <th>Total</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pesanans as $index => $pesanan)
                    @if($pesanan->menu && $pesanan->pelanggan)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td><strong>{{ $pesanan->menu->namamenu }}</strong></td>
                        <td>{{ $pesanan->pelanggan->namapelanggan }}</td>
                        <td>
                            @if($pesanan->meja)
                                <span class="badge badge-primary">Meja {{ $pesanan->meja->nomor_meja }}</span>
                            @else
                                <span>-</span>
                            @endif
                        </td>
                        <td class="text-center"><span class="badge badge-info">{{ $pesanan->jumlah }}</span></td>
                        <td class="text-right">Rp {{ number_format($pesanan->menu->harga, 0, ',', '.') }}</td>
                        <td class="text-right"><strong>Rp {{ number_format($pesanan->menu->harga * $pesanan->jumlah, 0, ',', '.') }}</strong></td>
                        <td class="text-center">{{ $pesanan->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    @endif
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="no-data">
                <p>Tidak ada data pesanan untuk periode yang dipilih.</p>
            </div>
        @endif

    @elseif($report_type == 'transaksi')
        <div class="summary-section">
            <div class="summary-title">💰 Ringkasan Laporan Transaksi</div>
            <div class="summary-grid">
                <div class="summary-item">
                    <div class="summary-value">{{ $total_transaksi }}</div>
                    <div class="summary-label">Total Transaksi</div>
                </div>
                <div class="summary-item">
                    <div class="summary-value">Rp {{ number_format($total_pendapatan, 0, ',', '.') }}</div>
                    <div class="summary-label">Total Pendapatan</div>
                </div>
            </div>
        </div>

        @if($transaksis->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID Transaksi</th>
                        <th>Pesanan</th>
                        <th>Meja</th>
                        <th>Total</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaksis as $index => $transaksi)
                    @if($transaksi->pesanan && $transaksi->pesanan->menu && $transaksi->pesanan->pelanggan)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td><strong>{{ $transaksi->idtransaksi }}</strong></td>
                        <td>
                            @php $items = $transaksi->pesanans->count() > 0 ? $transaksi->pesanans : collect([$transaksi->pesanan]); @endphp
                            <div>
                                <strong>{{ ($transaksi->pesanans->count() ? $transaksi->pesanans->first() : $transaksi->pesanan)->pelanggan->namapelanggan }}</strong>:
                                @foreach($items as $it)
                                    <span class="badge badge-info" style="margin-right:4px; margin-top:4px; display:inline-block;">{{ $it->menu->namamenu }} ({{ $it->jumlah }}x)</span>
                                @endforeach
                            </div>
                        </td>
                        <td>
                            @php $first = $transaksi->pesanans->count() ? $transaksi->pesanans->first() : $transaksi->pesanan; @endphp
                            @if($first->meja)
                                <span class="badge badge-primary">Meja {{ $first->meja->nomor_meja }}</span>
                            @else
                                <span>-</span>
                            @endif
                        </td>
                        <td class="text-right"><strong>Rp {{ number_format($transaksi->total, 0, ',', '.') }}</strong></td>
                        <td class="text-center">{{ $transaksi->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    @endif
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="no-data">
                <p>Tidak ada data transaksi untuk periode yang dipilih.</p>
            </div>
        @endif

    @elseif($report_type == 'pendapatan')
        <div class="summary-section">
            <div class="summary-title">📈 Ringkasan Laporan Pendapatan</div>
            <div class="summary-grid">
                <div class="summary-item">
                    <div class="summary-value">Rp {{ number_format($pendapatan['total_pendapatan'], 0, ',', '.') }}</div>
                    <div class="summary-label">Total Pendapatan</div>
                </div>
                <div class="summary-item">
                    <div class="summary-value">{{ $pendapatan['total_transaksi'] }}</div>
                    <div class="summary-label">Total Transaksi</div>
                </div>
                <div class="summary-item">
                    <div class="summary-value">Rp {{ number_format($pendapatan['rata_rata_transaksi'], 0, ',', '.') }}</div>
                    <div class="summary-label">Rata-rata per Transaksi</div>
                </div>
            </div>
        </div>

        @if($menu_populer->count() > 0)
            <div class="page-break"></div>
            <h3 style="color: black; margin-bottom: 15px;">🍽️ Menu Terpopuler</h3>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Menu</th>
                        <th>Harga</th>
                        <th>Total Terjual</th>
                        <th>Total Pendapatan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($menu_populer as $index => $item)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td><strong>{{ $item->menu->namamenu }}</strong></td>
                        <td class="text-right">Rp {{ number_format($item->menu->harga, 0, ',', '.') }}</td>
                        <td class="text-center"><span class="badge badge-info">{{ $item->total_terjual }}</span></td>
                        <td class="text-right"><strong>Rp {{ number_format($item->menu->harga * $item->total_terjual, 0, ',', '.') }}</strong></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
        @if(isset($transaksis) && $transaksis->count() > 0)
            <div class="page-break"></div>
            <h3 style="color: black; margin-bottom: 15px;">💰 Laporan Transaksi</h3>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID Transaksi</th>
                        <th>Pesanan</th>
                        <th>Meja</th>
                        <th>Total</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaksis as $index => $transaksi)
                    @if($transaksi->pesanan && $transaksi->pesanan->menu && $transaksi->pesanan->pelanggan)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td><strong>{{ $transaksi->idtransaksi }}</strong></td>
                        <td>{{ $transaksi->pesanan->menu->namamenu }} ({{ $transaksi->pesanan->pelanggan->namapelanggan }})</td>
                        <td>
                            @if($transaksi->pesanan->meja)
                                <span class="badge badge-primary">Meja {{ $transaksi->pesanan->meja->nomor_meja }}</span>
                            @else
                                <span>-</span>
                            @endif
                        </td>
                        <td class="text-right"><strong>Rp {{ number_format($transaksi->total, 0, ',', '.') }}</strong></td>
                        <td class="text-center">{{ $transaksi->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    @endif
                    @endforeach
                </tbody>
            </table>
        @endif
    @endif

    <div class="footer">
        <p>Laporan ini dibuat secara otomatis oleh sistem Restaurant Management</p>
        <p>© {{ date('Y') }} Restaurant App - Generated on {{ now()->format('d F Y H:i:s') }}</p>
    </div>
</body>
</html>
