<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Struk {{ $transaksi->idtransaksi }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #111; }
        .container { width: 100%; padding: 8px; }
        .header { text-align: center; margin-bottom: 8px; }
        .header h3 { margin: 0; color: black; }
        .meta { margin: 8px 0; }
        .meta table { width: 100%; }
        .meta td { vertical-align: top; padding: 2px 0; }
        .items { width: 100%; border-collapse: collapse; margin-top: 6px; }
        .items th, .items td { border: 1px solid #ddd; padding: 6px; }
        .items th { background: #e9f2ff; color: #111; }
        .totals { margin-top: 8px; width: 100%; }
        .totals td { padding: 4px 0; }
        .text-right { text-align: right; }
        .small { font-size: 11px; color: #555; }
        .footer { text-align: center; margin-top: 10px; font-size: 11px; color: #555; }
    </style>
    </head>
<body>
    <div class="container">
        <div class="header">
            <h3>Restaurant POS</h3>
            <div class="small">Struk Transaksi</div>
        </div>

        <div class="meta">
            <table>
                <tr>
                    <td><strong>ID Transaksi:</strong> {{ $transaksi->idtransaksi }}</td>
                    <td class="text-right"><strong>Tanggal:</strong> {{ $transaksi->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                <tr>
                    <td><strong>Pelanggan:</strong> {{ $transaksi->pesanan->pelanggan->namapelanggan }}</td>
                    <td class="text-right"><strong>Kasir:</strong> {{ auth()->user()->name }}</td>
                </tr>
            </table>
        </div>

        <table class="items">
            <thead>
                <tr>
                    <th>Item</th>
                    <th class="text-right">Qty</th>
                    <th class="text-right">Harga</th>
                    <th class="text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $items = $transaksi->pesanans->count() > 0 ? $transaksi->pesanans : collect([$transaksi->pesanan]);
                @endphp
                @foreach($items as $psn)
                    @php
                        $qty = max(1, (int) $psn->jumlah);
                        $unitPrice = (int) $psn->menu->harga;
                    @endphp
                    <tr>
                        <td>{{ $psn->menu->namamenu }}</td>
                        <td class="text-right">{{ $qty }}</td>
                        <td class="text-right">Rp {{ number_format($unitPrice, 0, ',', '.') }}</td>
                        <td class="text-right">Rp {{ number_format($unitPrice * $qty, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <table class="totals">
            <tr>
                <td><strong>Total</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($transaksi->total, 0, ',', '.') }}</strong></td>
            </tr>
            <tr>
                <td>Bayar</td>
                <td class="text-right">Rp {{ number_format($transaksi->bayar, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Kembalian</td>
                <td class="text-right">Rp {{ number_format($transaksi->bayar - $transaksi->total, 0, ',', '.') }}</td>
            </tr>
        </table>

        <div class="footer">Terima kasih telah berkunjung!</div>
    </div>
</body>
</html>


